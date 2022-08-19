<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Mercadolibre extends Controller
{
    private $baseUri = '';
    private $users = [
        "token" => "APP_USR-4332857485021545-081908-ea1191c951cbb9af5a4c07f0cfcfae9f-833930674",
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
    public function updateMercadolibre($code, $datos)
    {
        $client = \Config\Services::curlrequest();

        $uri = $this->baseUri . "items/" . $code;
        $response = $client->request('PUT', $uri, [
            "json" => $datos,
            "headers" => [
                "Accept" => "application/json",
                "Authorization" => "Bearer " . $this->users['token']
            ],
        ]);
        return $response;
    }
}
