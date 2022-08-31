<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Usuarios;

class MercadoShop extends Controller
{
    public function getValidarMercadoShop(){
        $ssesion = \Config\Services::session();
        $db = \Config\Database::connect();
        $builder = $db->table('users');
        $id = $ssesion->get("user");
        $rol = $ssesion->get("rol");
        if($rol == 0){
            $data_array = array('Usuario' => $id);
        $datos = $builder->select('userId')->where($data_array)->get()->getResultArray();
        foreach ($datos as $variable) {
            $uri = 'https://api.mercadolibre.com/sites/MCO/search?seller_id='.$variable['userId'];
            $conexion = curl_init();
            $token = "APP_USR-4332857485021545-083014-e5fa0cb97af6419f78a945df0e0bc0c6-833930674";
            curl_setopt($conexion, CURLOPT_URL, $uri);
            curl_setopt($conexion, CURLOPT_CUSTOMREQUEST, 'GET');
            curl_setopt($conexion, CURLOPT_HTTPHEADER, array('Accept: application/json', 'Content-Type: application/json', "Authorization: Bearer $token"));
            // curl_setopt($conexion, CURLOPT_POSTFIELDS, json_encode($datos));
            curl_setopt($conexion, CURLOPT_RETURNTRANSFER, 1);
    
            $r = curl_exec($conexion);
            $m = json_decode($r,true);
            echo json_encode($m);
        }
        }
        
        
    }
}