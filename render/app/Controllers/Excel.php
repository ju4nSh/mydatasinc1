<?php

namespace App\Controllers;
// require  '../vendor/autoload.php';

use App\Models\Producto;
use CodeIgniter\Controller;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\Console\Descriptor\Descriptor;

class Excel extends Controller
{
	public static function index()
	{
		$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xlsx');
		$reader->setReadDataOnly(TRUE);
		$spreadsheet = $reader->load("../public/uploads/meli.xlsx");
		$worksheet = $spreadsheet->getActiveSheet();
		// Get the highest row and column numbers referenced in the worksheet
		$highestRow = $worksheet->getHighestRow(); // e.g. 10
		$highestColumn = $worksheet->getHighestColumn(); // e.g 'F'
		$highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn); // e.g. 5
		$colProduct = [];
		$colums = 0;
		$rows = 0;
		$flagColumn = false;
		$col = 0;
		$keys = ["title", "category_id", "price", "available_quantity", "pictures", "attributes", "descripcion"];
		$attributes = ["MOTO_TYPE", "BRAND", "MODEL", "VEHICLE_YEAR"];
		$publicar = new Mercadolibre();
		$productoBD = new Producto();
		$object = [];
		for ($row = 2; $row <= $highestRow; ++$row) {
			for ($col = 1; $col <= $highestColumnIndex; ++$col) {
				$value = $worksheet->getCellByColumnAndRow($col, $row)->getValue();
				if ($value != null) {
					$colProduct[] = $value;
				}
			}
		}
		$description = '';
		$colProduct;
		unlink("../public/uploads/meli.xlsx");
		$flag = false;
		#SIRVE SOLO PARA CATEGORIAS MOTO
		for ($ñ = 0; $ñ < $highestRow - 1; $ñ++) {
			$data = [];
			$offset = $ñ * $highestColumnIndex;
			$jsonImagen = [];
			for ($j = 0; $j < $highestColumnIndex; $j++) {
				if ($keys[$j] == "pictures") {
					$imagen = explode(",", $colProduct[$offset + $j]);
					$jsonImagen = $imagen;
					foreach ($imagen as $key => $img) {
						$imagen[$key] = array("source" => trim($img));
					}
					$data[$keys[$j]] = $imagen;
					continue;
				}
				if ($keys[$j] == "attributes") {
					$auxAt = [];
					for ($k = $j, $c = 0; $k < $j + 4; $k++, $c++) {
						$auxAt[] = [
							"id" => $attributes[$c],
							"value_name" => $colProduct[$offset + $k]
						];
					}
					$data[$keys[$j]] =  $auxAt;
					continue;
				}
				if ($keys[$j] == "descripcion") {
					$description = $colProduct[$offset + $j + 3];
					break;
				}
				$data[$keys[$j]] = $colProduct[$offset + $j];
			}
			$data["currency_id"] = "COP";
			$data["condition"] = "new";
			$data["listing_type_id"] = "gold_pro";
			$respuesta = $publicar->postMercadolibre($data);
			$respuesta = (array) json_decode($respuesta);

			if (array_key_exists("id", $respuesta)) {
				// INSERTAR EN LA BASE DE DATOS
				$idP = '';
				$categoryP = '';
				$linkP = '';
				$response = $respuesta;
				$idP = $response["id"];
				$categoryP = $response["category_id"];
				$linkP = $response["permalink"];
				$dataProduct = [
					"nombre" => $response["title"],
					"precio" => $response["price"],
					"categoria" => $categoryP,
					"codigo"  => $idP,
					"imagen" => json_encode($jsonImagen),
					"link" => $linkP,
					"cantidad" => $response["available_quantity"],
					"descripcion" =>  $description,
					"Owner" => session("id"),
				];
				$res = $productoBD->save($dataProduct);
				if ($res) {
					$publicar->addDescriptionMercadolibre($idP, $description);
					$flag = true;
				} else {
					$flag = false;
				}
			} else if (array_key_exists("status", $respuesta)) {
				if ($respuesta["status"] != 400 || $respuesta["status"] != 401)
					echo json_encode(["result" => 0, "cause" => $respuesta["cause"], "mensaje" => $respuesta["message"]]);
				return;
			} else {
				echo json_encode(["result" => 0, "mensaje" => "Ocurrió un error"]);
				return;
			}
		}
		if ($flag) {
			echo json_encode(["result" => 1]);
		} else {
			echo json_encode(["result" => 0]);
		}
	}
}
