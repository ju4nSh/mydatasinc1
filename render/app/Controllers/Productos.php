<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Producto;

class Productos extends Controller
{

    public function getProduct()
    {
        $producto = new Producto();
        $respuesta = $producto->findAll();
        return $respuesta;
    }

    public function obtenerCategoria()
    {
        $productos = new Mercadolibre();
        return $productos->getAllCategories();
    }

    public function obtenerDetallesCategoria($id)
    {
        $detalles = new Mercadolibre();
        return $detalles->getDetailsCategories($id);
    }

}
