<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Usuarios;

class Graficos extends Controller
{
    public function graficoCircular(){
        $db = \Config\Database::connect();
        $builder = $db->table('users');
        $respuesta = $builder->select("Ciudad, COUNT(Identificacion) as Numero")->groupBy("Ciudad")->get()->getResultArray();
        foreach ($respuesta as $variable) {
            $array[] = [
                'Ciudad' => $variable['Ciudad'],
                'Numero' => $variable['Numero'],
            ];
        }
        echo json_encode($array);
    }
    public function graficoLineaProducto(){
        $db = \Config\Database::connect();
        $builder = $db->table('productos');
        $respuesta = $builder->select("codigo,cantidad")->get()->getResultArray();
        foreach ($respuesta as $variable) {
            $array[] = [
                'codigo' => $variable['codigo'],
                'cantidad' => $variable['cantidad'],
            ];
        }
        echo json_encode($array);
    }
}
