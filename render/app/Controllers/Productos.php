<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Producto;

class Productos extends Controller
{
    private $mercadolibre;
    private $producto;
    public function __construct()
    {
        $this->mercadolibre = new Mercadolibre();
        $this->producto = new Producto();
    }

    public function getProduct()
    {
        return  json_encode(["data" => $this->producto->findAll()]) ;
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
            echo json_encode(["result" => 20]);
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

            // INSERTAR EN LA BASE DE DATOS
            if ($respuesta) {
                $idP = '';
                $categoryP = '';
                $linkP = '';
                $response = json_decode($respuesta);
                $idP = $response->id;
                $categoryP = $response->category_id;
                $linkP = $response->permalink;
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
            } else {
                echo json_encode(["result" => 0, "data" => $respuesta]);
            }
        } else {
            echo json_encode(["result" => 0]);
        }
    }
}
