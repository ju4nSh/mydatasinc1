<?php

namespace App\Controllers;

use App\Models\Producto;
use App\Models\Usuarios;

class Home extends BaseController
{

	private $usuario;
	public function __construct()
	{
		$this->usuario = new Usuarios();
	}
	public function index()
	{
		$ssesion = \Config\Services::session();
		$id = $ssesion->get("user");
		$rol = $ssesion->get("rol");
		$contenido = $ssesion->get("contenido");
		if (empty($id)) {
			return $this->response->redirect(base_url('login'));
		} else {
			$view = \Config\Services::renderer();
			$view->setVar('one', $id)
				->setVar('pagina', "Salpicadero")
				->setVar('titulo', "Dashboard")
				->setVar('rol', $rol)
				->setVar('contenido', $contenido);
			echo $view->render("Contenido/contenidoDashboard");
		}
	}

	public function tablas()
	{
		$ssesion = \Config\Services::session();
		$id = $ssesion->get("user");
		$rol = $ssesion->get("rol");
		$contenido = $ssesion->get("contenido");
		if (empty($id)) {
			return $this->response->redirect(site_url('/'));
		} else {
			$view = \Config\Services::renderer();
			$view->setVar('one', $id)
				->setVar('pagina', "Clientes")
				->setVar('titulo', "Clientes")
				->setVar('rol', $rol)
				->setVar('contenido', $contenido);
			echo $view->render("Contenido/contenidoTablas");
		}
	}

	public function guardar()
	{
		if ($this->request->getVar("usuario") != '' && $this->request->getVar("password")) {
			try {
				$user = $this->usuario->escapeString($this->request->getVar("usuario"));
				$pass =  $this->usuario->escapeString($this->request->getVar("password"));
				$userExits = $this->usuario->where("usuario", $user)->find();
				if (count($userExits) > 0) {
					if (password_verify($pass, $userExits[0]["Password"])) {
						$session = session();
						$rol = new Rol();
						$dato = $rol->consultarDatosRol($userExits[0]["Rol"]);
						$data = [
							"user" => $userExits[0]["Usuario"],
							"rol" => $userExits[0]["Rol"],
							"id" => $userExits[0]["id"],
							"contenido" => $dato
						];
						$session->set($data);
						echo json_encode(["result" => 1]);
					} else {
						echo json_encode(["result" => 2]);
					}
				} else {
					echo json_encode(["result" => 2]);
				}
			} catch (\Exception $e) {
				echo json_encode(["result" => 3]);
			}
		}
	}
	public function tablaProductoHealth()
	{
		$ssesion = \Config\Services::session();
		$id = $ssesion->get("user");
		$rol = $ssesion->get("rol");
		$contenido = $ssesion->get("contenido");
		if (empty($id)) {
			return $this->response->redirect(site_url('/'));
		} else {
			$view = \Config\Services::renderer();
			$view->setVar('one', $id)
				->setVar('pagina', "DatoProducto")
				->setVar('titulo', "DatoProducto")
				->setVar('rol', $rol)
				->setVar('contenido', $contenido);
			echo $view->render("Contenido/contenidoDatosProducto");
		}
	}
	public function productos()
	{
		$ssesion = \Config\Services::session();
		$id = $ssesion->get("user");
		$rol = $ssesion->get("rol");
		$contenido = $ssesion->get("contenido");
		if (empty($id)) {
			return $this->response->redirect(site_url('/'));
		} else {
			$producto = new Productos();
			$view = \Config\Services::renderer();
			$view->setVar('one', $id)
				->setVar('pagina', "Productos")
				->setVar('titulo', "Productos")
				->setVar('rol', $rol)
				->setVar('contenido', $contenido);
			echo $view->render("Contenido/contenidoProducto");
		}
	}
	public function login()
	{
		$ssesion = \Config\Services::session();
		$id = $ssesion->get("user");
		$rol = $ssesion->get("rol");
		$contenido = $ssesion->get("contenido");
		if (empty($id)) {
			$view = \Config\Services::renderer();
			echo $view->render("Contenido/login");
		} else {
			$view = \Config\Services::renderer();
			$view->setVar('one', $id)
				->setVar('pagina', "Salpicadero")
				->setVar('titulo', "Dashboard")
				->setVar('rol', $rol)
				->setVar('contenido', $contenido);
			echo $view->render("Contenido/contenidoDashboard");
		}
	}
	public function obtenerDProd()
	{
		$mercadolibre = new Mercadolibre();
		$product = new DataProducto();
		$limit = 3;
		$offset = $this->request->getVar("offset");
		$calcular = ($offset - 1) * $limit;
		$array = [];
		$data = [];
		$arrayDatosProducto = [];
		$arrayAccionesProducto = [];
		$array = $product->obtenerDatosProducto($limit, $calcular);
		for ($i = 0; $i < count($array); $i++) {
			$arrayAccionesProducto[] = $mercadolibre->getAccionesProducto($array[$i]["Codigo"]);
		};
		for ($p = 0; $p < count($array); $p++) {
			$data[] = [
				"Id" => $array[$p]["Codigo"],
				"Title" => $array[$p]["Nombre"],
				"Imagen" => $array[$p]["Imagen"],
				"Health" => round($arrayAccionesProducto[$p]["health"] * 100),
				"Color" => $this->randomColor(),
				"Acciones" => ($arrayAccionesProducto[$p]["name"])
			];
		}
		echo json_encode($data);
	}
	function randomColor()
	{
		$str = '#';
		for ($i = 0; $i < 6; $i++) {
			$randNum = rand(0, 15);
			switch ($randNum) {
				case 10:
					$randNum = 'A';
					break;
				case 11:
					$randNum = 'B';
					break;
				case 12:
					$randNum = 'C';
					break;
				case 13:
					$randNum = 'D';
					break;
				case 14:
					$randNum = 'E';
					break;
				case 15:
					$randNum = 'F';
					break;
			}
			$str .= $randNum;
		}
		return $str;
	}

	public function mostrarRegistrar()
	{
		$view = \Config\Services::renderer();
		echo $view->render("Contenido/Registrar");
	}

	public function salir()
	{
		$ssesion = \Config\Services::session();
		$ssesion->remove("user");
		return $this->response->redirect(site_url('/'));
	}
	public function registrar()
	{
		if ($this->request->getVar("id") != '' && $this->request->getVar("usuario") && $this->request->getVar("password")) {
			$identity = $this->usuario->escapeString($this->request->getVar("id"));
			$user = $this->usuario->escapeString($this->request->getVar("usuario"));
			$password = password_hash($this->usuario->escapeString($this->request->getVar("password")), PASSWORD_DEFAULT);
			$registro = false;
			$userExits = $this->usuario->select("Creator, Rol, Password, id")->where("Usuario", $user)->where("Identificacion", $identity)->find();
			if (count($userExits) == 0) {
				$data = [
					"Identificacion" => $identity,
					"Usuario" => $user,
					"Password" => $password,
					// "Creator" => 0,
					"Rol" => 0,
				];
				$registro = $this->usuario->save($data);
				$creator = $this->usuario->getInsertID();
				$dataNew = [
					"id" => $creator,
					"Creator" => $creator
				];
				$registro = $this->usuario->save($dataNew);
				if ($registro) {
					echo json_encode(["result" => 1]);
				} else {
					echo json_encode(["result" => 0]);
				}
			} else {
				try {
					if ($userExits[0]["Password"] == '') {
						$data = [
							"id" => $userExits[0]["id"],
							"Password" => $password,
						];
						$registro = $this->usuario->save($data);
						if ($registro) {
							echo json_encode(["result" => 1]);
						} else {
							echo json_encode(["result" => 0]);
						}
					} else {
						echo json_encode(["result" => 0]);
					}
				} catch (\Exception $e) {
					echo json_encode(["result" => 0, "error" => "usuario ya existe!"]);
				}
			}
		} else {
			echo json_encode(["result" => 2]);
		}
	}

	public function perfil()
	{
		$ssesion = \Config\Services::session();
		$id = $ssesion->get("user");
		$rol = $ssesion->get("rol");
		$contenido = $ssesion->get("contenido");
		if (empty($id)) {
			return $this->response->redirect(site_url('/'));
		} else {
			$view = \Config\Services::renderer();

			$view->setVar('one', $id)
				->setVar('pagina', "Perfil")
				->setVar('titulo', "Perfil")
				->setVar('rol', $rol)
				->setVar('contenido', $contenido);
			echo $view->render("Contenido/contenidoPerfil");
		}
	}


	public function ModificarPerfil()
	{
		$validator = \Config\Services::validation();
		if ($this->validate('formularioPerfil')) {
			$Nombre = $this->request->getVar("Nombre");
			$Foto = $this->request->getVar("Foto");
			$Apellido = $this->request->getVar("Apellido");
			$Correo = $this->request->getVar("Correo");
			$Direccion = $this->request->getVar("Direccion");
			$Ciudad = $this->request->getVar("Ciudad");
			$Pais = $this->request->getVar("Pais");
			$SobreMi = $this->request->getVar("SobreMi");
			$ssesion = \Config\Services::session();
			$id = $ssesion->get("user");
			$db = \Config\Database::connect();
			$builder = $db->table('users');
			$data_array = array(
				'Nombre' => $Nombre,
				'Apellido' => $Apellido,
				'Correo' => $Correo,
				'Direccion' => $Direccion,
				'Ciudad' => $Ciudad,
				'Pais' => $Pais,
				'SobreMi' => $SobreMi,
				'Foto' => $Foto
			);
			$builder->where('Usuario', $id);
			if ($builder->update($data_array)) {
				$array[] = [
					'Nombre' => $Nombre,
					'Apellido' => $Apellido,
					'Correo' => $Correo,
					'Direccion' => $Direccion,
					'Ciudad' => $Ciudad,
					'Pais' => $Pais,
					'SobreMi' => $SobreMi,
					'Foto' => $Foto
				];
			} else {
				$array = [
					"error" => "No se pudo actualizar"
				];
			}
		} else {
			$array[] = [
				'Validar' => 'Validar',
				'Nombre' => $validator->getError('Nombre'),
				'Apellido' => $validator->getError('Apellido'),
				'Correo' => $validator->getError('Correo'),
				'Direccion' => $validator->getError('Direccion'),
				'Ciudad' => $validator->getError('Ciudad'),
				'Pais' => $validator->getError('Pais'),
				'SobreMi' => $validator->getError('SobreMi'),
				'Foto' => $validator->getError('Foto'),
			];
		}
		echo json_encode($array);
	}
	public function llenarPerfil()
	{
		$db = \Config\Database::connect();
		$builder = $db->table('users');
		$ssesion = \Config\Services::session();
		$id = $ssesion->get("id");
		$data_array = array('id' => $id);
		$array = [];
		$datos = $builder->select('*')->where($data_array)->get()->getResultArray();
		foreach ($datos as $variable) {
			$array[] = [
				'Nombre' => $variable['Nombre'],
				'Apellido' => $variable['Apellido'],
				'Correo' => $variable['Correo'],
				'Direccion' => $variable['Direccion'],
				'Ciudad' => $variable['Ciudad'],
				'Pais' => $variable['Pais'],
				'SobreMi' => $variable['SobreMi'],
				'Foto' => $variable['Foto'],
				'Password' => $variable['Password']
			];
		}
		echo json_encode($array);
	}
	public function mostrarClientesReferenciados()
	{
		$db = \Config\Database::connect();
		$builder = $db->table('users as u');
		$ssesion = \Config\Services::session();
		$id = $ssesion->get("id");
		$rol = $ssesion->get("rol");
		$data_array = array('Creator' => $id, 'id !=' => $id);
		$p1 = '';
		$respuesta = false;
		$datos = $builder->select('u.id as id,u.Identificacion as Identificacion, 
        u.Nombre as Nombre, u.Apellido as Apellido, u.Correo as Correo,u.Ciudad as Ciudad, 
        u.Pais as Pais, r.Nombre as Rol')->where($data_array)->join('roles as r', 'u.Rol=r.Identificacion')->get()->getResultArray();
		if (count($datos) == 0) {
			if ($rol == 0) {
				$respuesta = true;
			} else {
				$builder1 = $db->table('users');
				$datos1 = $builder1->select('Creator')->where('id', $id)->get()->getResultArray();
				$p1 = $datos1[0]["Creator"];
				$data_array = array('Creator' => $datos1[0]["Creator"], 'id !=' => $datos1[0]["Creator"]);
				$datos = $builder->select('u.id as id,u.Identificacion as Identificacion, 
        u.Nombre as Nombre, u.Apellido as Apellido, u.Correo as Correo,u.Ciudad as Ciudad, 
        u.Pais as Pais, r.Nombre as Rol')->where($data_array)->join('roles as r', 'u.Rol=r.Identificacion')->get()->getResultArray();
			}
		}
		if ($respuesta == false) {
			if (count($datos) > 0) {
				foreach ($datos as $variable) {
					if (count($datos) == 1 && $id == $variable["id"]) {
						$array = [];
					} else {
						if ($id != $variable['id']) {
							$array[] = [
								'Identificacion' => $variable['Identificacion'],
								'Nombre' => $variable['Nombre'],
								'Apellido' => $variable['Apellido'],
								'Correo' => $variable['Correo'],
								'Ciudad' => $variable['Ciudad'],
								'Pais' => $variable['Pais'],
								'Rol' => $variable['Rol']
							];
						}
					}
				}
			} else {
				$array = [];
			}
		} else {
			$array = [];
		}

		echo json_encode($array);
	}

	public function agregarClienteRef()
	{
		$validator = \Config\Services::validation();
		if ($this->validate('formularioClienteRef')) {
			$Identificacion = $this->request->getVar("Id");
			$Apellido = $this->request->getVar("Apellido");
			$Nombre = $this->request->getVar("Nombre");
			$Correo = $this->request->getVar("Correo");
			$Ciudad = $this->request->getVar("Ciudad");
			$Pais = $this->request->getVar("Pais");
			$Rol = $this->request->getVar("Rol");
			$Usuario = $this->request->getVar("Usuario");
			$ssesion = \Config\Services::session();
			$id = $ssesion->get("id");
			$roles = $ssesion->get("rol");
			$respuesta = $id;
			$compra = new Usuarios();
			if ($roles != 0) {
				$db = \Config\Database::connect();
				$builder1 = $db->table('users');
				$datos1 = $builder1->select('Creator')->where('id', $id)->get()->getResultArray();
				$datos2 = $builder1->select('id')->where('id', $datos1[0]["Creator"])->get()->getResultArray();
				$respuesta = $datos2[0]["id"];
			}
			try {
				$compra->insert([
					'Identificacion' => $Identificacion,
					'Nombre' => $Nombre,
					'Apellido' => $Apellido,
					'Correo' => $Correo,
					'Ciudad' => $Ciudad,
					'Pais' => $Pais,
					'Creator' => $respuesta,
					'Usuario' => $Usuario,
					'Rol' => $Rol,
				]);
				$db = \Config\Database::connect();
				$builder = $db->table('roles');
				$data_array = array('Identificacion' => $Rol);
				$datos = $builder->select('Nombre')->where($data_array)->get()->getResultArray();
				foreach ($datos as $variable) {
					$array = $variable['Nombre'];
				}
				$dato = [
					'Identificacion' => $Identificacion,
					'Nombre' => $Nombre,
					'Apellido' => $Apellido,
					'Correo' => $Correo,
					'Ciudad' => $Ciudad,
					'Pais' => $Pais,
					'Creator' => $respuesta,
					'Rol' => $array,
				];
			} catch (\Exception $e) {
				$dato = [
					'error' => $e->getMessage(),
				];
			}
		} else {
			$dato = [
				'Validar' => 'Validar',
				'Id' => $validator->getError('Id'),
				'Nombre' => $validator->getError('Nombre'),
				'Apellido' => $validator->getError('Apellido'),
				'Correo' => $validator->getError('Correo'),
				'Direccion' => $validator->getError('Direccion'),
				'Ciudad' => $validator->getError('Ciudad'),
				'Pais' => $validator->getError('Pais'),
				'Usuario' => $validator->getError('Usuario'),
			];
		}
		echo json_encode($dato);
	}
	public function eliminarClienteRef()
	{
		$Identificacion = $this->request->getVar("identificacion");
		$db = \Config\Database::connect();
		$builder = $db->table('users');
		$data_array = array('Identificacion' => $Identificacion);
		$builder->where($data_array);
		$dato = $builder->delete();
		echo json_encode($dato);
	}


	public function datosApi()
	{
		$ssesion = \Config\Services::session();
		$id = $ssesion->get("user");
		$rol = $ssesion->get("rol");
		$contenido = $ssesion->get("contenido");
		$view = \Config\Services::renderer();
		$view->setVar('one', $id)
			->setVar('pagina', "Tabla Api")
			->setVar('titulo', "Tabla Api")
			->setVar('rol', $rol)
			->setVar('contenido', $contenido);
		echo $view->render("Contenido/contenidoTablaApi");
	}
	public function validar_input($data)
	{
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}

	public function isValidEspacio($text)
	{
		$compara = "/^[a-zA-Z\sñáéíóúÁÉÍÓÚ]+$/";
		if ((preg_match($compara, $text))) {
			return true;
		} else {
			return false;
		}
	}

	public function isValid($text)
	{
		$compara = '/^[a-zA-Z]+$/';
		if ((preg_match($compara, $text))) {
			return true;
		} else {
			return false;
		}
	}


	public function isValidNumber($text)
	{
		$compara = "/^[0-9]+$/";
		if ((preg_match($compara, $text))) {
			return true;
		} else {
			return false;
		}
	}
	public function isValidUrl($text)
	{
		$compara = "/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|](\.)[a-z]{2}/i";
		if ((preg_match($compara, $text))) {
			return true;
		} else {
			return false;
		}
	}
	public function isValidNumberText($text)
	{
		$compara = '/^[a-z][a-z0-9_#*$]{3,}/i';
		if ((preg_match($compara, $text))) {
			return true;
		} else {
			return false;
		}
	}

	public function MostrarContenidoClienteSinRoll()
	{
		$ssesion = \Config\Services::session();
		$id = $ssesion->get("user");
		$rol = $ssesion->get("rol");
		$contenido = $ssesion->get("contenido");
		if (empty($id)) {
			return $this->response->redirect(site_url('/'));
		} else {
			$producto = new Productos();
			$view = \Config\Services::renderer();
			$view->setVar('one', $id)
				->setVar('pagina', "Clientes Sin Rol")
				->setVar('titulo', "Clientes Sin Rol")
				->setVar('rol', $rol)
				->setVar('contenido', $contenido);
			echo $view->render("Contenido/contenidoClientesSinRol");
		}
	}
}
