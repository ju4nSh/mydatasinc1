<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Usuarios;

class MercadoShop extends Controller
{
    public function getValidarMercadoShop()
    {
        $token = "APP_USR-4332857485021545-090516-f69a7b649907e5a96228a68c6007cf56-833930674";
        $ssesion = \Config\Services::session();
        $db = \Config\Database::connect();
        $builder = $db->table('users');
        $id = $ssesion->get("user");
        $rol = $ssesion->get("rol");
        if ($rol == 0) {
            $data_array = array('Usuario' => $id);
            $datos = $builder->select('userId')->where($data_array)->get()->getResultArray();
            foreach ($datos as $variable) {
                $this->getConsultaMercadoShop($variable['userId'],$token);
            }
        } else {
            $data_array = array('Usuario' => $id);
            $datos1 = $builder->select('Creator')->where($data_array)->get()->getResultArray();
            foreach ($datos1 as $variable1) {
                $data_array1 = array('id' => $variable1['Creator'][0]);
                $datos3 = $builder->select('userId')->where($data_array1)->get()->getResultArray();
                foreach ($datos3 as $variable2) {
                    $this->getConsultaMercadoShop($variable2['userId'],$token);
                }
            }
        }
    }

    public function getConsultaMercadoShop($user,$token)
    {
        $uri = 'https://api.mercadolibre.com/sites/MCO/search?seller_id=' .$user ;
        $conexion = curl_init();
        
        curl_setopt($conexion, CURLOPT_URL, $uri);
        curl_setopt($conexion, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($conexion, CURLOPT_HTTPHEADER, array('Accept: application/json', 'Content-Type: application/json', "Authorization: Bearer $token"));
        // curl_setopt($conexion, CURLOPT_POSTFIELDS, json_encode($datos));
        curl_setopt($conexion, CURLOPT_RETURNTRANSFER, 1);

        $r = curl_exec($conexion);
        $m = json_decode($r, true);
        $respuesta = false;
        foreach ($m["seller"]["tags"] as $busca) {
            if ($busca === "mshops") {
                $respuesta = true;
            }
        }
        if ($respuesta == true) {
            echo json_encode(["result" => 1]);
        } else {
            echo json_encode(["result" => 0]);
        }
    }
}
