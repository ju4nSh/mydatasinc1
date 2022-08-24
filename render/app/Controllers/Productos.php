<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Producto;

class Productos extends Controller
{
	private $mercadolibre;
	private $producto;
	// variables paginación
	private $_limit;
	private $_page;
	private $_total;
	// fin
	public function __construct()
	{
		$this->mercadolibre = new Mercadolibre();
		$this->producto = new Producto();
		$respuesta = $this->producto->select("nombre, cantidad, codigo, precio, imagen, link, categoria")->findAll();
		foreach ($respuesta as $key => $value) {
			$respuesta[$key]["imagen"] = json_decode($value["imagen"]);
		}
		$this->_total = count($respuesta);
	}

	public function getProduct()
	{
		$respuesta = $this->producto->select("nombre, cantidad, codigo, precio, imagen, link, categoria")->findAll();
		foreach ($respuesta as $key => $value) {
			$respuesta[$key]["imagen"] = json_decode($value["imagen"]);
		}
		$this->_total = count($respuesta);
	}
	public function getData($limit, $page = 1)
	{

		$this->_limit   = $limit;
		$this->_page    = $page;

		if ($this->_limit == 'all') {
			$respuesta = $this->producto->select("nombre, cantidad, codigo, precio, imagen, link, categoria")->findAll();
			foreach ($respuesta as $key => $value) {
				$respuesta[$key]["imagen"] = json_decode($value["imagen"]);
			}
		} else {
			$offset = (($this->_page - 1) * $this->_limit);
			$respuesta = $this->producto->select("nombre, cantidad, codigo, precio, imagen, link, categoria")->findAll($this->_limit, $offset);
			foreach ($respuesta as $key => $value) {
				$respuesta[$key]["imagen"] = json_decode($value["imagen"]);
			}
		}

		$result         = [
			"page" => $this->_page,
			"limit" => $this->_limit,
			"total" => $this->_total,
			"data" => $respuesta
		];

		return json_encode($result);
	}
	// TODO MEJORAR LA FUNCIONALIDAD DE UX
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
		// $html       .= '<li class="' . $class . '"><a onclick="buscarNuevo(' . $this->_limit .', ' . ($this->_page - 1) .')" href="javascript: void(0)">&laquo;</a></li>';

		if ($start > 1) {
			$html   .= '<li><a onclick="buscarNuevo(' . $this->_limit . ', 1)" href=javascript: void(0)">1</a></li>';
			$html   .= '<li class="disabled"><span>...</span></li>';
		}

		for ($i = $start; $i <= $end; $i++) {
			$class  = ($this->_page == $i) ? "active" : "";
			$html   .= '<li class="' . $class . '"><a onclick="buscarNuevo(' . $this->_limit .', ' . $i . ')" href="javascript: void(0)">' . $i . '</a></li>';
		}

		if ($end < $last) {
			$html   .= '<li class="disabled"><span>...</span></li>';
			$html   .= "<li><a onclick='buscarNuevo(" . $this->_limit . ", " . $last . ")' href='javascript: void(0)'>" . $last . "</a></li>";
		}

		$class      = ($this->_page == $last) ? "disabled" : "";
		// $html       .= '<li class="' . $class . '"><a onclick="buscarNuevo(' . $this->_limit . ', ' . ($this->_page + 1) . ')" href="javascript: void(0)">&raquo;</a></li>';

		$html       .= '</ul>';

		return $html;
	}
	public function getCategory_Id()
	{
		return  json_encode(["data" => $this->producto->select("id, descripcion")->where("codigo", $this->request->getVar("codigo"))->get()->getFirstRow()]);
	}

	public function obtenerCategoria()
	{
		return $this->mercadolibre->getAllCategories();
	}

	public function obtenerDetallesCategoria($id)
	{
		return $this->mercadolibre->getDetailsCategories($id);
	}
	public function actualizarProducto()
	{
		if ($this->request->getVar("codigo") != "" && $this->request->getVar("id") != "" && $this->request->getVar("nombre") != "" && $this->request->getVar("precio") != "" && $this->request->getVar("descripcion") != "" && $this->request->getVar("cantidad") != "") {

			$id = $this->producto->escapeString($this->request->getVar("codigo"));
			$codigo = $this->producto->escapeString($this->request->getVar("id"));
			$data = [
				"nombre" => $this->producto->escapeString($this->request->getVar("nombre")),
				"precio" => $this->producto->escapeString($this->request->getVar("precio")),
				"descripcion" => $this->producto->escapeString($this->request->getVar("descripcion")),
				"cantidad" => $this->producto->escapeString($this->request->getVar("cantidad")),
			];
			$datos = [
				"title" => $data["nombre"],
				"price" => $data["precio"],
				"available_quantity" => $data["cantidad"],
			];
			// agregar descripcion al producto
			$descripcion = $this->mercadolibre->addDescriptionMercadolibre($codigo, $data["descripcion"]);
			// Item already has a description, use PUT instead
			if (json_decode($descripcion)->message == "Item already has a description, use PUT instead") {
				$descripcion = $this->mercadolibre->addDescriptionMercadolibrePUT($codigo, $data["descripcion"]);
			}
			if ($descripcion) {
				if ($this->producto->update($id, $data)) {
					//actualizar productos en mercadolibre
					if ($this->mercadolibre->updateMercadolibre($codigo, $datos))
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
			echo json_encode(["result" => 30]);
		}
	}

	public function attributesCategory($id)
	{
		return $this->mercadolibre->attributesCategory($id);
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
				"attributes" => json_decode($this->request->getVar("attributes")),
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
			];

			$respuesta = $this->mercadolibre->postMercadolibre($datos);

			$respuesta = (array) json_decode($respuesta);
			
			if (in_array("id", $respuesta)) {
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
					"cantidad" => $data["cantidad"]
				];
				$res = $this->producto->save($dataProduct);
				if ($res) {
					echo json_encode(["result" => 1]);
				} else {
					echo json_encode(["result" => 0]);
				}
			} else if (in_array("status", $respuesta)) {
				if ($respuesta["status"] != 400 && $respuesta["status"] != 401)
					echo json_encode(["result" => 0, "cause" => $respuesta["cause"], "mensaje" => $respuesta["message"]]);
			}
		} else {
			echo json_encode(["result" => 0]);
		}
	}
}
