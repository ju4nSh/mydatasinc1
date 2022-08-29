<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class DataProducto extends Controller
{
    public function obtenerDatosProducto($limit,$offset)
	{
        $dato=[];
        $db = \Config\Database::connect();
        $builder = $db->table('productos');
        
		if ($limit == 'all') {
			$respuesta = $builder->select('nombre,codigo')->get()->getResultArray();
            foreach ($respuesta as $key => $value) {
				 $dato[]=[
                    "Nombre" => $value["nombre"],
                    "Codigo" => $value["codigo"]
                ];
			}
		} else {
			$respuesta = $builder->select('nombre,codigo,imagen')->limit($limit,$offset)->get()->getResultArray();
            foreach ($respuesta as $key => $value) {
                $dato[]=[
                   "Nombre" => $value["nombre"],
                   "Codigo" => $value["codigo"],
                   "Imagen" => json_decode($value["imagen"])
               ];
           }
		}
		return ($dato);
	}
    public function obtenerPaginacion()
	{
        $limit =  $this->request->getVar("limit");
        $dato=[];
        $db = \Config\Database::connect();
        $builder = $db->table('productos');
        $respuesta = $builder->select('nombre')->get()->getResultArray();
        $tamaño= count($respuesta)/$limit;
		echo round($tamaño);
	}
}
