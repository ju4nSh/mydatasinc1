<?php

namespace App\Controllers;
// require  '../vendor/autoload.php';

use App\Models\Producto;
use CodeIgniter\Controller;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Excel extends Controller
{
	public function index()
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
		for ($row = 2; $row <= $highestRow; ++$row) {
			for ($col = 1; $col <= $highestColumnIndex; ++$col) {
				$value = $worksheet->getCellByColumnAndRow($col, $row)->getValue();
				if ($value != null) {
					$colums++;
					$colProduct[] = $value;
				}
			}
		}
		$colProduct;
		unlink("../public/uploads/meli.xlsx");
		$publicar = new Mercadolibre();
		$productoBD = new Producto();
		$flag = false;
		#TODO MEJORAR EL DINAMISMO
		for ($i = 0; $i < $colums / 10; $i++) {
			$data = [];
			$imagen = explode(",", $colProduct[$i * ($colums / 3) + (4)]);
			foreach ($imagen as $key => $img) {
				$imagen[$key] = array("source" => trim($img));
			}
			$data = [
				"title" => $colProduct[$i * ($colums / 3) + (0)],
				"category_id" => $colProduct[$i * ($colums / 3) + (1)],
				"price" => $colProduct[$i * ($colums / 3) + (2)],
				"available_quantity" => $colProduct[$i * ($colums / 3) + (3)],
				"pictures" => $imagen,
				"currency_id" => "COP",
				"condition" => "new",
				"attributes" => [
					["id" => "MOTO_TYPE", "value_name" => $colProduct[$i * ($colums / 3) + (6)]],
					["id" => "BRAND", "value_name" => $colProduct[$i * ($colums / 3) + (7)]],
					["id" => "MODEL", "value_name" => $colProduct[$i * ($colums / 3) + (8)]],
					["id" => "VEHICLE_YEAR", "value_name" => $colProduct[$i * ($colums / 3) + (9)]],
				],
				"listing_type_id" => "gold_pro",
			];
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
					"nombre" => $colProduct[$i * ($colums / 3) + (0)],
					"precio" => $colProduct[$i * ($colums / 3) + (2)],
					"categoria" => $categoryP,
					"codigo"  => $idP,
					"imagen" => json_encode(explode(",", $colProduct[$i * ($colums / 3) + (4)])),
					"link" => $linkP,
					"cantidad" => $colProduct[$i * ($colums / 3) + (3)],
					"descripcion" =>  $colProduct[$i * ($colums / 3) + (5)],
					"Owner" => session("id"),
				];
				$res = $productoBD->save($dataProduct);
				if ($res) {
					$publicar->addDescriptionMercadolibre($idP, $colProduct[$i * ($colums / 3) + (5)]);
					$flag = true;
				} else {
					$flag = false;
				}
			} else if (array_key_exists("status", $respuesta)) {
				if ($respuesta["status"] != 400 || $respuesta["status"] != 401)
					echo json_encode(["result" => 0, "cause" => $respuesta["cause"], "mensaje" => $respuesta["message"]]);
			} else {
				echo json_encode(["result" => 0, "mensaje" => "Ocurrió un error"]);
			}
		}
		if($flag) {
			echo json_encode(["result" => 1]);
		} else {
			echo json_encode(["result" => 0]);
		}
	}
}
