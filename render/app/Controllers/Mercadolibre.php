<?php

/*
User = TEST0DZEHY3B
app Id = 4332857485021545
secret key = BXQbMgaylwbml72KGRrBtkdQCsATIkAm
user id = 833930674
*/
namespace App\Controllers;

use CodeIgniter\Controller;
// url para buscar productos  -- https://api.mercadolibre.com/users/833930674/items/search?search_type=scan 

class Mercadolibre extends Controller
{
	private $baseUri = '';
	private $users = [
		"token" => "APP_USR-7132638262334053-090314-b8460aa0e7caee0a47911f2234656e6a-245929580",
		"user" => "TEST0DZEHY3B",
		"userId" => "245929580",
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

		$uri = $this->baseUri . "items/" . $code;
		$conexion = curl_init();
		$token = $this->users["token"];
		curl_setopt($conexion, CURLOPT_URL, $uri);
		curl_setopt($conexion, CURLOPT_CUSTOMREQUEST, 'PUT');
		curl_setopt($conexion, CURLOPT_HTTPHEADER, array('Accept: application/json', 'Content-Type: application/json', "Authorization: Bearer $token"));
		curl_setopt($conexion, CURLOPT_POSTFIELDS, json_encode($datos));
		curl_setopt($conexion, CURLOPT_RETURNTRANSFER, 1);

		$r = curl_exec($conexion);
		curl_close($conexion);
		return $r;
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

	public function getAccionesProducto($producto)
	{
		$client = \Config\Services::curlrequest();
		$resp = $client->request('GET', 'https://api.mercadolibre.com/items/' . $producto.'/health/actions', [
			"headers" => [
				"Accept" => "application/json",
				"Authorization" => "Bearer " . $this->users["token"]
			]
		]);
		$array = $resp->getBody();
		$list=[];
		$list2=[];
		$fotos = [];
		$products2 = json_decode($array, true);
			$list= $products2['actions'];
			foreach ($list as $key => $foto) {
				$fotos[] = $foto["name"];
			}
			$list2= $products2['health'];
			$dato=[
				"health" => $list2,
				"name" => json_encode($fotos)
			];
		return $dato;
	}
	public function getAllProduct($scroll_id)
	{
		$uri = $this->baseUri . "users/" . $this->users["userId"] . "/items/search?search_type=scan&scroll_id=" . $scroll_id;
		$conexion = curl_init();
		$token = $this->users["token"];
		curl_setopt($conexion, CURLOPT_URL, $uri);
		curl_setopt($conexion, CURLOPT_CUSTOMREQUEST, 'GET');
		curl_setopt($conexion, CURLOPT_HTTPHEADER, array('Accept: application/json', 'Content-Type: application/json', "Authorization: Bearer $token"));
		// curl_setopt($conexion, CURLOPT_POSTFIELDS, json_encode($datos));
		curl_setopt($conexion, CURLOPT_RETURNTRANSFER, 1);

		$r = curl_exec($conexion);
		return $r;
	}
	public function getInfoProduct($code)
	{
		$uri = $this->baseUri . "items/" . $code;
		$conexion = curl_init();
		$token = $this->users["token"];
		curl_setopt($conexion, CURLOPT_URL, $uri);
		curl_setopt($conexion, CURLOPT_CUSTOMREQUEST, 'GET');
		curl_setopt($conexion, CURLOPT_HTTPHEADER, array("Authorization: Bearer $token"));
		// curl_setopt($conexion, CURLOPT_POSTFIELDS, json_encode($datos));
		curl_setopt($conexion, CURLOPT_RETURNTRANSFER, 1);

		$r = curl_exec($conexion);
		return $r;
	}

	public function generateToken($app_id, $client_Secret)
	{
		$redirect = 'https://google.com';
		$uri = "https://auth.mercadolibre.com.co/authorization?response_type=code&client_id=$app_id&redirect_uri=$redirect";
		
	}

	public function getAllQuestions()
	{
		$SELLER_ID = $this->users["userId"];
		$uri = $this->baseUri . "questions/search?seller_id=$SELLER_ID&api_version=4";
		$conexion = curl_init();
		$token = $this->users["token"];
		curl_setopt($conexion, CURLOPT_URL, $uri);
		curl_setopt($conexion, CURLOPT_CUSTOMREQUEST, 'GET');
		curl_setopt($conexion, CURLOPT_HTTPHEADER, array('Accept: application/json', 'Content-Type: application/json', "Authorization: Bearer $token"));
		// curl_setopt($conexion, CURLOPT_POSTFIELDS, json_encode($datos));
		curl_setopt($conexion, CURLOPT_RETURNTRANSFER, 1);

		$r = curl_exec($conexion);
		return $r;
	}

	public function answerQuestions($id_question, $answer)
	{
		$uri = $this->baseUri . "/answers";
		$conexion = curl_init();
		$token = $this->users["token"];
		$datos = [
			"question_id" => $id_question,
			"text" => $answer
		];
		curl_setopt($conexion, CURLOPT_URL, $uri);
		curl_setopt($conexion, CURLOPT_CUSTOMREQUEST, 'POST');
		curl_setopt($conexion, CURLOPT_HTTPHEADER, array('Accept: application/json', 'Content-Type: application/json', "Authorization: Bearer $token"));
		curl_setopt($conexion, CURLOPT_POSTFIELDS, json_encode($datos));
		curl_setopt($conexion, CURLOPT_RETURNTRANSFER, 1);

		$r = curl_exec($conexion);
		return $r;

	}
}
