<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Producto;
use App\Models\Usuarios;
use DateTime;

class Productos extends Controller
{
	private $mercadolibre;
	private $producto;
	private $resultados = [];
	private $usuario;

	// variables paginación
	private $_limit;
	private $_page;
	private $_total;
	// fin
	public function __construct()
	{
		$this->mercadolibre = new Mercadolibre();
		$this->producto = new Producto();
		$this->usuario = new Usuarios();
		$respuesta = $this->producto->select("nombre, cantidad, codigo, precio, imagen, link, categoria")->findAll();
		foreach ($respuesta as $key => $value) {
			$respuesta[$key]["imagen"] = json_decode($value["imagen"]);
		}
		$this->_total = count($respuesta);
	}

	public function getProduct()
	{
		$respuesta = $this->producto->select("nombre, cantidad, codigo, precio, imagen, link, categoria, estado")->findAll();
		foreach ($respuesta as $key => $value) {
			$respuesta[$key]["imagen"] = json_decode($value["imagen"]);
		}
		$this->_total = count($respuesta);
	}

	public function getData($limit, $page = 1, $numLinks = 3, $limite = "null")
	{

		$this->_limit   = $limit;
		$this->_page    = $page;

		if ($this->_limit == 'all') {
			if (session("rol") == 0) {
				$respuesta = $this->producto->select("nombre, cantidad, codigo, precio, imagen, link, categoria, estado")->orderBy("id DESC")->where("Owner", session("id"))->findAll();
				foreach ($respuesta as $key => $value) {
					$respuesta[$key]["imagen"] = json_decode($value["imagen"]);
				}
			} else {
				$id_father = $this->usuario->select("Creator")->where("id", session("id"))->find();
				$respuesta = $this->producto->select("nombre, cantidad, codigo, precio, imagen, link, categoria, estado")->orderBy("id DESC")->where("Owner", $id_father)->findAll();
				foreach ($respuesta as $key => $value) {
					$respuesta[$key]["imagen"] = json_decode($value["imagen"]);
				}
			}
		} else {
			$offset = (($this->_page - 1) * $this->_limit);
			if (session("rol") == 0) {
				$respuesta = $this->producto->select("nombre, cantidad, codigo, precio, imagen, link, categoria, estado")->orderBy("id DESC")->where("Owner", session("id"))->findAll($this->_limit, $offset);
				foreach ($respuesta as $key => $value) {
					$respuesta[$key]["imagen"] = json_decode($value["imagen"]);
				}
			} else {
				$id_father = $this->usuario->select("Creator")->where("id", session("id"))->find();
				$respuesta = $this->producto->select("nombre, cantidad, codigo, precio, imagen, link, categoria, estado")->orderBy("id DESC")->where("Owner", $id_father)->findAll($this->_limit, $offset);
				foreach ($respuesta as $key => $value) {
					$respuesta[$key]["imagen"] = json_decode($value["imagen"]);
				}
			}
		}

		$result         = [
			"page" => $this->_page,
			"limit" => $this->_limit,
			"total" => $this->_total,
			"data" => $respuesta
		];
		if ($limite == "null")
			$html = $this->createLinks($numLinks, $result["limit"]);
		else
			$html = $this->createLinks($numLinks, $limite);

		$result["html"] = $html;
		return json_encode($result);
	}
	public function createLinks($links, $limit)
	{
		$this->_limit = $limit;
		if ($this->_limit == 'all') {
			return '';
		}

		$last       = ceil($this->_total / $this->_limit);

		$start      = (($this->_page - $links) > 0) ? $this->_page - $links : 1;
		$end        = (($this->_page + $links) < $last) ? $this->_page + $links : $last;

		$html       = '<ul>';

		$class      = ($this->_page == 1) ? "disabled" : "";
		$html       .= '<li class="' . $class . '"><a onclick="buscarNuevo(' . $this->_limit . ', ' . ($this->_page - 1) . ')" href="javascript: void(0)">&laquo;</a></li>';

		if ($start > 1) {
			$html   .= '<li><a onclick="buscarNuevo(' . $this->_limit . ', 1)" href=javascript: void(0)">1</a></li>';
			$html   .= '<li class="disabled"><span>...</span></li>';
		}

		for ($i = $start; $i <= $end; $i++) {
			$class  = ($this->_page == $i) ? "active" : "";
			$html   .= '<li class="' . $class . '"><a onclick="buscarNuevo(' . $this->_limit . ', ' . $i . ')" href="javascript: void(0)">' . $i . '</a></li>';
		}

		if ($end < $last) {
			$html   .= '<li class="disabled"><span>...</span></li>';
			$html   .= "<li><a onclick='buscarNuevo(" . $this->_limit . ", " . $last . ")' href='javascript: void(0)'>" . $last . "</a></li>";
		}

		$class      = ($this->_page == $last) ? "disabled" : "";
		$html       .= '<li class="' . $class . '"><a onclick="buscarNuevo(' . $this->_limit . ', ' . ($this->_page + 1) . ')" href="javascript: void(0)">&raquo;</a></li>';

		$html       .= '</ul>';

		return $html;
	}

	public function createLinksProductsSearch($links, $limit)
	{
		$this->_limit = $limit;
		if ($this->_limit == 'all') {
			return '';
		}

		$last       = ceil($this->_total / $this->_limit);

		$start      = (($this->_page - $links) > 0) ? $this->_page - $links : 1;
		$end        = (($this->_page + $links) < $last) ? $this->_page + $links : $last;

		$html       = '<ul>';

		$class      = ($this->_page == 1) ? "disabled" : "";
		$html       .= '<li class="' . $class . '"><a onclick="searchProductNew(' . $this->_limit . ', ' . ($this->_page - 1) . ')" href="javascript: void(0)">&laquo;</a></li>';

		if ($start > 1) {
			$html   .= '<li><a onclick="searchProductNew(' . $this->_limit . ', 1)" href=javascript: void(0)">1</a></li>';
			$html   .= '<li class="disabled"><span>...</span></li>';
		}

		for ($i = $start; $i <= $end; $i++) {
			$class  = ($this->_page == $i) ? "active" : "";
			$html   .= '<li class="' . $class . '"><a onclick="searchProductNew(' . $this->_limit . ', ' . $i . ')" href="javascript: void(0)">' . $i . '</a></li>';
		}

		if ($end < $last) {
			$html   .= '<li class="disabled"><span>...</span></li>';
			$html   .= "<li><a onclick='searchProductNew(" . $this->_limit . ", " . $last . ")' href='javascript: void(0)'>" . $last . "</a></li>";
		}

		$class      = ($this->_page == $last) ? "disabled" : "";
		$html       .= '<li class="' . $class . '"><a onclick="searchProductNew(' . $this->_limit . ', ' . ($this->_page + 1) . ')" href="javascript: void(0)">&raquo;</a></li>';

		$html       .= '</ul>';

		return $html;
	}

	public function getCategory_Id()
	{
		$res = $this->producto->select("id, descripcion, imagen")->where("codigo", $this->request->getVar("codigo"))->get()->getFirstRow();
		$res->imagen = json_decode($res->imagen);
		return  json_encode(["data" => $res]);
	}

	public function obtenerCategoria()
	{
		return $this->mercadolibre->getAllCategories();
	}

	public function obtenerDetallesCategoria($id)
	{
		return $this->mercadolibre->getDetailsCategories($id);
	}

	public function publicarMercadolibre()
	{
		if ($this->request->getVar("nombre") != "" && $this->request->getVar("precio") != "" && $this->request->getVar("categoria") != "" && $this->request->getVar("cantidad") != "" && $this->request->getVar("imagen") != "" && $this->request->getVar("attributes") != "") {
			$data = [
				"nombre" => $this->producto->escapeString($this->request->getVar("nombre")),
				"precio" => $this->producto->escapeString($this->request->getVar("precio")),
				"categoria" => $this->producto->escapeString($this->request->getVar("categoria")),
				"cantidad" => $this->producto->escapeString($this->request->getVar("cantidad")),
				"imagen" => json_decode($this->request->getVar("imagen")),
				"descripcion" => $this->request->getVar("descripcion"),
				"attributes" => json_decode($this->request->getVar("attributes")),
				"mshops" => $this->request->getVar("mshops")
			];
			$imagen = $data["imagen"];
			foreach ($imagen as $key => $img) {
				$imagen[$key] = array("source" => $img);
			}
			$datos = [
				"title" => $data["nombre"],
				"category_id" => $data["categoria"],
				"price" => $data["precio"],
				"currency_id" => "COP",
				"available_quantity" => $data["cantidad"],
				"condition" => "new",
				"listing_type_id" => "gold_pro",
				"pictures" => $imagen,
				"attributes" => $data["attributes"],
				"channels" => ["marketplace", $data["mshops"] ? "mshops" : ''],
			];

			$respuesta = $this->mercadolibre->postMercadolibre($datos);

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
					"nombre" => $data["nombre"],
					"precio" => $data["precio"],
					"categoria" => $categoryP,
					"codigo"  => $idP,
					"imagen" => json_encode($data["imagen"]),
					"link" => $linkP,
					"cantidad" => $data["cantidad"],
					"descripcion" => $data["descripcion"],
					"Owner" => session("id"),
				];
				$res = $this->producto->save($dataProduct);
				if ($res) {
					$this->mercadolibre->addDescriptionMercadolibre($idP, $data["descripcion"]);
					echo json_encode(["result" => 1]);
				} else {
					echo json_encode(["result" => 0]);
				}
			} else if (array_key_exists("status", $respuesta)) {
				if ($respuesta["status"] != 400 || $respuesta["status"] != 401)
					echo json_encode(["result" => 0, "cause" => $respuesta["cause"], "mensaje" => $respuesta["message"]]);
			} else {
				echo json_encode(["result" => 0, "mensaje" => "Ocurrió un error"]);
			}
		} else {
			echo json_encode(["result" => 0, "mensaje" => "llene todos los campos"]);
		}
	}

	public function actualizarProducto()
	{
		if ($this->request->getVar("codigo") != "" && $this->request->getVar("id") != "" && $this->request->getVar("nombre") != "" && $this->request->getVar("precio") != "" && $this->request->getVar("cantidad") != "") {

			$id = $this->producto->escapeString($this->request->getVar("codigo"));
			$codigo = $this->producto->escapeString($this->request->getVar("id"));
			$data = [
				"nombre" => $this->producto->escapeString($this->request->getVar("nombre")),
				"precio" => $this->producto->escapeString($this->request->getVar("precio")),
				"descripcion" => $this->producto->escapeString($this->request->getVar("descripcion")),
				"imagen" => json_decode($this->request->getVar("imagen")),
				"cantidad" => $this->producto->escapeString($this->request->getVar("cantidad")),
			];
			$imagen = $data["imagen"];
			foreach ($imagen as $key => $img) {
				$imagen[$key] = array("source" => $img);
			}
			$datos = [
				"title" => $data["nombre"],
				"price" => $data["precio"],
				"available_quantity" => $data["cantidad"],
				"pictures" => $imagen,
			];
			// agregar descripcion al producto
			$descripcion = $this->mercadolibre->addDescriptionMercadolibre($codigo, $data["descripcion"]);
			$descripcion = (array) json_decode($descripcion);
			// Item already has a description, use PUT instead
			if (array_key_exists("plain_text", $descripcion)) {
				if ($descripcion) {
					//actualizar productos en mercadolibre
					if ($this->mercadolibre->updateMercadolibre($codigo, $datos)) {
						// actualizo en la base de datos
						if ($this->producto->update($id, $data))
							echo json_encode(["result" => 1]);
						else
							echo json_encode(["result" => 0]);
					} else {
						echo json_encode(["result" => 10]);
					}
				} else {
					echo json_encode(["result" => 20, "data" => $descripcion]);
				}
			} else {
				if (array_key_exists("message", $descripcion)) {
					//actualizar productos en mercadolibre
					$re = $this->mercadolibre->updateMercadolibre($codigo, $datos);
					$re = (array) json_decode($re);
					if (array_key_exists("id", $re)) {
						$descripcion = $this->mercadolibre->addDescriptionMercadolibrePUT($codigo, $data["descripcion"]);
						if ($descripcion) {
							$dataAC = [
								"nombre" => $this->producto->escapeString($this->request->getVar("nombre")),
								"precio" => $this->producto->escapeString($this->request->getVar("precio")),
								"descripcion" => $this->producto->escapeString($this->request->getVar("descripcion")),
								"imagen" => ($this->request->getVar("imagen")),
								"cantidad" => $this->producto->escapeString($this->request->getVar("cantidad")),
							];
							if ($this->producto->update($id, $dataAC)) {
								echo json_encode(["result" => 1]);
							} else if (array_key_exists("status", $re)) {
								echo json_encode(["result" => 20, "data" => $descripcion]);
							}
						} else {
							echo json_encode(["result" => 10]);
						}
					} else {
						echo json_encode(["result" => 0, "cause" => $re["cause"], "mensaje" => $re["message"]]);
					}
				}
			}
		} else {
			echo json_encode(["result" => 30]);
		}
	}

	public function attributesCategory($id)
	{
		return $this->mercadolibre->attributesCategory($id);
	}

	public function pausarActivarEliminar($item, $value)
	{
		$respuesta = $this->mercadolibre->pausar_activar_eliminar($item, ["status" => $value]);
		$id = $this->producto->select("id")->where("codigo", $item)->find();
		$respuesta = (array) json_decode($respuesta);
		if (array_key_exists("id", $respuesta)) {
			// actualizar estado en base de dato
			if ($value == "closed") {
				// elimino de la base de datos
				if ($this->producto->delete($id[0])) {
					echo json_encode(["result" => 1]);
				} else {
					echo json_encode(["result" => 0]);
				}
			} else {
				if ($this->producto->update($id[0], ["estado" => $value == "paused" ? 0 : 1])) {
					echo json_encode(["result" => 1]);
				} else {
					echo json_encode(["result" => 0]);
				}
			}
		} else if (array_key_exists("status", $respuesta)) {
			if ($respuesta["status"] != 400 || $respuesta["status"] != 401)
				echo json_encode(["result" => 0, "cause" => $respuesta["cause"], "mensaje" => $respuesta["message"]]);
		}
	}

	public function getAllProduct($scroll_id = '')
	{
		$usuario = new Usuarios();
		$_date = $usuario->select("dateProductUpdated")->where("id", session("id"))->find();
		$dUpdate = strtotime($_date[0]["dateProductUpdated"]);
		$_time = new DateTime();
		$_today = date_timestamp_get($_time);

		if (($_today - $dUpdate) >= 86400) {
			if (count($this->producto->findAll()) > 0) {
				$this->producto->truncate();
			}
			$respuesta = $this->mercadolibre->getAllProduct($scroll_id);
			$respuesta = (array) json_decode($respuesta);
			if (array_key_exists("status", $respuesta)) {
				echo json_encode(["result" => 0, "mensaje" => $respuesta["message"]]);
			} else if (array_key_exists("scroll_id", $respuesta) && count($respuesta["results"]) > 0) {
				$this->resultados[] = $respuesta["results"];
				$this->getAllProduct($respuesta["scroll_id"]);
			} else {
				$flag = false;
				// proceso para buscar las caracteristicas de los productos por su codigo
				foreach ($this->resultados as $value) {
					foreach ($value as $pro) {
						$imagenes = [];
						$p = $this->mercadolibre->getInfoProduct($pro);
						$p = json_decode($p);
						if ($p->status != "closed" && $p->status != "paused") {
							// guardo las imagenes
							foreach ($p->pictures as $img) {
								$imagenes[] = $img->url;
							}

							$dataProduct = [
								"nombre" => $p->title,
								"cantidad" =>  $p->available_quantity,
								"precio" =>  $p->price,
								"codigo" =>  $p->id,
								"categoria" =>  $p->category_id,
								"imagen" => json_encode($imagenes),
								"link" =>  $p->permalink,
								"descripcion" => json_encode($p->descriptions),
								"Owner" => session("id"),
							];

							if ($this->producto->save($dataProduct)) {
								$flag = true;
							}
						}
					}
				}
				if ($flag) {
					$time = new DateTime();
					$data_user = [
						"id" => session("id"),
						"dateProductUpdated" => $time->setTimestamp($time->getTimestamp())->format("Y-m-d H:i:s"),
					];
					if ($usuario->save($data_user)) {
						echo json_encode(["result" => 1]);
					} else {
						echo json_encode(["result" => 0]);
					}
				} else
					echo json_encode(["result" => 0]);
			}
		} else {
			echo json_encode(["result" => 2]);
		}
	}

	public function searchProducts($product, $limit = 3, $page = 1, $numLinks = 3)
	{
		if ($product != "") {
			$this->_page  = $page;
			$this->_limit = $limit;
			$offset = (($this->_page - 1) * $this->_limit);
			$response = $this->producto->like("nombre", $product)->findAll();
			$this->_total = count($response);
			$response = $this->producto->like("nombre", $product)->findAll($this->_limit, $offset);

			foreach ($response as $key => $value) {
				$response[$key]["imagen"] = json_decode($value["imagen"]);
			}
			if ($response) {
				$result         = [
					"page" => $this->_page,
					"limit" => $this->_limit,
					"total" => $this->_total,
					"data" => $response,
					"result" => 1
				];

				$html = $this->createLinksProductsSearch($numLinks, $this->_limit);

				$result["html"] = $html;

				echo json_encode($result);
			} else {
				echo json_encode(["result" => 0]);
			}
		} else {
			echo json_encode(["result" => 0]);
		}
	}

	public function getAllQuestions()
	{
		$questions = $this->mercadolibre->getAllQuestions();
		$questions = (array) json_decode($questions);
		$response = [];
		if (array_key_exists("status", $questions)) {
			echo json_encode(["result" => 0, "mensaje" => $questions["message"]]);
		} else {
			foreach ($questions["questions"] as $question) {
				$aux = [];
				$quest = [];
				if ($question->status == "UNANSWERED") {
					// buscamos el producto que pertenece a la pregunta
					$producto = $this->getInfoProduct($question->item_id);
					if ($producto != 0) {
						if (count($response) == 0) {
							array_push($aux, $question->text, $question->id);
							array_push($quest, $aux);
							array_push($producto, $quest);
							$response[] = $producto;
						} else {
							// preguntar si es el mismo producto para agregar solo la pregunta
							$flag = false;
							foreach ($response as $key => $value) {
								if (array_key_exists("codigo", $value[0])) {
									if ($value[0]["codigo"] == $producto[0]["codigo"]) {
										array_push($quest,  $question->text, $question->id);
										array_push($response[$key][1], $quest);
										$flag = true;
									}
								}
							}
							if (!$flag) {
								array_push($aux,  $question->text, $question->id);
								array_push($quest,  $aux);
								array_push($producto, $quest);
								$response[] = $producto;
							}
						}
					}
				}
			}
			if (count($response) > 0)
				echo json_encode(["result" => 1, "data" => $response]);
			else {
				echo json_encode(["result" => 0]);
			}
		}
	}

	public function getInfoProduct($code)
	{
		$producto = $this->producto->where("codigo", $code)->where("Owner", session("id"))->find();
		if ($producto) {
			return $producto;
		} else {
			return 0;
		}
	}

	public function answerQuestions()
	{
		$id = $this->request->getVar("id");
		$answer = $this->request->getVar("answer");
		if ($id != "" && $answer != "") {
			$response = $this->mercadolibre->answerQuestions($id, $answer);
			$response = (array) json_decode($response);
			if (array_key_exists("error", $response)) {
				echo json_encode(["result" => 0, "mensaje" => $response["message"]]);
			} else {
				echo json_encode(["result" => 1]);
			}
		} else {
			echo json_encode(["result" => 2]);
		}
	}
}
