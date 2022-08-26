<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Mercadolibre extends Controller
{
    private $baseUri = '';
    private $users = [
        "token" => "APP_USR-4332857485021545-082516-f8bb0818257e5ea3a94d2b6d1c24fbd4-833930674",
        "user" => "TEST0DZEHY3B",
        "userId" => "833930674",
    ];
    public function __construct()
    {
        $this->baseUri = "https://api.mercadolibre.com/";
    }
    public function getAllCategories()
    {
        $client = \Config\Services::curlrequest();
        $uri = $this->baseUri . "sites/MCO/categories";
        $response = $client->request('GET', "$uri");
        $array = $response->getBody();
        return $array;
    }

    public function getDetailsCategories($id)
    {
        $client = \Config\Services::curlrequest();

        $uri = $this->baseUri . "categories/$id";
        $response = $client->request('GET', "$uri");
        $array = $response->getBody();
        return $array;
    }
    public function attributesCategory($id)
    {
        $client = \Config\Services::curlrequest();

        $uri = $this->baseUri . "categories/$id/attributes";
        $response = $client->request('GET', "$uri");
        $array = $response->getBody();
        return $array;
    }
    public function postMercadolibre($datos)
    {
        $uri = $this->baseUri . "items";
        $conexion = curl_init();
        $token = $this->users["token"];
        curl_setopt($conexion, CURLOPT_URL, $uri);
        curl_setopt($conexion, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($conexion, CURLOPT_HTTPHEADER, array('Accept: application/json', 'Content-Type: application/json', "Authorization: Bearer $token"));
        curl_setopt($conexion, CURLOPT_POSTFIELDS, json_encode($datos));
        curl_setopt($conexion, CURLOPT_RETURNTRANSFER, 1);

        $r = curl_exec($conexion);
        return $r;
    }
    public function addDescriptionMercadolibre($code, $descripcion)
    {
        $uri = $this->baseUri .  "/items/$code/description";

        $descripcion = [
            "plain_text" => $descripcion
        ];
        $conexion = curl_init();
        $token = $this->users["token"];
        curl_setopt($conexion, CURLOPT_URL, $uri);
        curl_setopt($conexion, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($conexion, CURLOPT_HTTPHEADER, array('Accept: application/json', 'Content-Type: application/json', "Authorization: Bearer $token"));
        curl_setopt($conexion, CURLOPT_POSTFIELDS, json_encode($descripcion));
        curl_setopt($conexion, CURLOPT_RETURNTRANSFER, 1);

        $r = curl_exec($conexion);
        curl_close($conexion);
        return $r;
    }
    public function addDescriptionMercadolibrePUT($code, $descripcion)
    {
        $uri = $this->baseUri .  "/items/$code/description";

        $descripcion = [
            "plain_text" => $descripcion
        ];
        $conexion = curl_init();
        $token = $this->users["token"];
        curl_setopt($conexion, CURLOPT_URL, $uri);
        curl_setopt($conexion, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($conexion, CURLOPT_HTTPHEADER, array('Accept: application/json', 'Content-Type: application/json', "Authorization: Bearer $token"));
        curl_setopt($conexion, CURLOPT_POSTFIELDS, json_encode($descripcion));
        curl_setopt($conexion, CURLOPT_RETURNTRANSFER, 1);

        $r = curl_exec($conexion);
        curl_close($conexion);
        return $r;
    }
    public function updateMercadolibre($code, $datos)
    {
        $client = \Config\Services::curlrequest();

        $uri = $this->baseUri . "items/" . $code;
        $response = $client->request('PUT', $uri, [
            "json" => $datos,
            "headers" => [
                "Content-Type" => "application/json",
                "Accept" => "application/json",
                "Authorization" => "Bearer " . $this->users['token']
            ],
        ]);
        return $response;
    }
    public function pausar_activar_eliminar($item, $value)
    {

        $uri = $this->baseUri . "items/" . $item;
        $conexion = curl_init();
        $token = $this->users["token"];
        curl_setopt($conexion, CURLOPT_URL, $uri);
        curl_setopt($conexion, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($conexion, CURLOPT_HTTPHEADER, array('Accept: application/json', 'Content-Type: application/json', "Authorization: Bearer $token"));
        curl_setopt($conexion, CURLOPT_POSTFIELDS, json_encode($value));
        curl_setopt($conexion, CURLOPT_RETURNTRANSFER, 1);

        $r = curl_exec($conexion);
        return $r;
    }

    public function getProductosdelUsuario($limit,$offset)
    {
        $client = \Config\Services::curlrequest();
        $token = "APP_USR-4332857485021545-082614-0a6013052ed8f7f19e6c62ee55778896-833930674";
        $user_id = "833930674";
        $resp = $client->request('GET', 'https://api.mercadolibre.com/users/' . $user_id . '/items/search?offset='.$offset.'&limit='.$limit, [
            "headers" => [
                "Accept" => "application/json",
                "Authorization" => "Bearer " . $token
            ]
        ]);
        $array = $resp->getBody();
        $products2 = json_decode($array, true);
            $list = $products2['results'];
        return $list;
    }

    public function getDatosProducto($producto)
    {
        $client = \Config\Services::curlrequest();
        $token = "APP_USR-4332857485021545-082614-0a6013052ed8f7f19e6c62ee55778896-833930674";
        $resp = $client->request('GET', 'https://api.mercadolibre.com/items/' . $producto, [
            "headers" => [
                "Accept" => "application/json",
                "Authorization" => "Bearer " . $token
            ]
        ]);
        $array = $resp->getBody();
        $list=[];
        $list2=[];
        $products2 = json_decode($array, true);
            $list= [$products2['health']];
            $list2= [$products2['title']];
            for($i=0;$i<count($list);$i++){
                $dat=[
                    "title"=> $list2[$i],
                    "health"=> $list[$i]
                ];
            }
            
        return ($dat);
    }

    public function getAccionesProducto($producto)
    {
        $client = \Config\Services::curlrequest();
        $token = "APP_USR-4332857485021545-082614-0a6013052ed8f7f19e6c62ee55778896-833930674";
        $resp = $client->request('GET', 'https://api.mercadolibre.com/items/' . $producto.'/health/actions', [
            "headers" => [
                "Accept" => "application/json",
                "Authorization" => "Bearer " . $token
            ]
        ]);
        $array = $resp->getBody();
        $list=[];
        $fotos = [];
        $products2 = json_decode($array, true);
            $list= $products2['actions'];
            foreach ($list as $key => $foto) {
                $fotos[] = $foto["name"];
                //   $array[]=[
                //     'Id'=>$products2['id'],
                //     'Titulo'=>$products2['title'],
                //     'Precio'=>$products2['price'],
                //     'Foto'=>json_encode($fotos)
                // ];
            }
        return $fotos;
    }
}
