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
		if (empty($id)) {
			return $this->response->redirect(site_url('/'));
		} else {
			$view = \Config\Services::renderer();
			$view->setVar('one', $id)
				->setVar('pagina', "Dashboard")
				->setVar('titulo', "Dashboard");
			echo $view->render("Contenido/contenidoDashboard");
		}
	}

	public function tablas()
	{
		$ssesion = \Config\Services::session();
		$id = $ssesion->get("user");
		if (empty($id)) {
			return $this->response->redirect(site_url('/'));
		} else {
			$view = \Config\Services::renderer();
			$view->setVar('one', $id)
				->setVar('pagina', "Clientes")
				->setVar('titulo', "Clientes");
			echo $view->render("Contenido/contenidoTablas");
		}
	}

	public function productos()
	{
		$ssesion = \Config\Services::session();
		$id = $ssesion->get("user");
		if (empty($id)) {
			return $this->response->redirect(site_url('/'));
		} else {
			$producto = new Productos();
			$view = \Config\Services::renderer();
			$view->setVar('one', $id)
				->setVar('pagina', "Productos")
				->setVar('titulo', "Productos");
			echo $view->render("Contenido/contenidoProducto");
		}
	}
	public function login()
	{
		$ssesion = \Config\Services::session();
		$id = $ssesion->get("user");
		if (empty($id)) {
			$view = \Config\Services::renderer();
			echo $view->render("Contenido/login");
		} else {
			$view = \Config\Services::renderer();
			$view->setVar('one', $id)
				->setVar('pagina', "Salpicadero")
				->setVar('titulo', "Dashboard");
			echo $view->render("Contenido/contenidoDashboard");
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
						$session->set("user", $userExits[0]["id"]);
						echo json_encode(["result" => 1]);
					} else {
						echo json_encode(["result" => 0]);
					}
				} else {
					echo json_encode(["result" => 2]);
				}
			} catch (\Exception $e) {
				echo json_encode(["result" => 3]);
			}
		}



		// $ssesion = \Config\Services::session();
		// $db = \Config\Database::connect();
		// $builder = $db->table('users');
		// $user = $this->request->getVar("Usuario");

		// $pass =  $this->request->getVar("password");
		// $data_array = array('Usuario' => $user);
		// $datos = $builder->select('*')->where($data_array)->get()->getResultArray();
		// if (count($datos) > 0) {
		//     foreach ($datos as $variable) {
		//         if (password_verify($pass, $variable['Password'])) {
		//             $var = [
		//                 'user' => $user
		//             ];
		//             $ssesion->set($var);
		//             echo "Bien";
		//         } else {
		//             echo "Contraseña invalida";
		//         }
		//     }
		// } else {
		//     echo "Para el usuario digitado no existe una cuenta asociada";
		// }
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

			$userExits = $this->usuario->select("id, usuario")->where("usuario", $user)->find();
			if (count($userExits) == 0) {
				$data = [
					"Identificacion" => $identity,
					"Usuario" => $user,
					"Password" => $password,
					"Creator" => 0,
				];
				$registro = $this->usuario->save($data);
				if ($registro) {
					echo json_encode(["result" => 1]);
				} else {
					echo json_encode(["result" => 0]);
				}
			} else {
				try {
					$data = [
						"Identificacion" => $identity,
						"Usuario" => $user,
						"Password" => $password,
						"Creator" => $userExits[0]["id"],
					];
					$registro = $this->usuario->save($data);
					if ($registro) {
						echo json_encode(["result" => 1]);
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
		// $db = \Config\Database::connect();
		// $ssesion = \Config\Services::session();
		// $builder = $db->table('users');
		// $data_array = array('Identificacion' => $id, 'Usuario' => '');
		// $datos = $builder->select('*')->where($data_array)->get()->getResultArray();
		// if (count($datos) > 0) {
		//     $pass =  password_hash($this->request->getVar("password"), PASSWORD_DEFAULT);
		//     $data_pass = array(
		//         'Password' => $pass,
		//         'Usuario' => $user
		//     );
		//     $builder->where('Identificacion', $id);
		//     $builder->update($data_pass);
		//     $var = [
		//         'user' => $user
		//     ];
		//     $ssesion->set($var);
		//     echo "registrado";
		// } else {
		//     echo "Verifique la informacion suministrada";
		// }
	}
	public function mostrarRegistrar()
	{
		$view = \Config\Services::renderer();
		echo $view->render("Contenido/Registrar");
	}

	public function perfil()
	{
		$ssesion = \Config\Services::session();
		$id = $ssesion->get("user");
		if (empty($id)) {
			return $this->response->redirect(site_url('/'));
		} else {
			$view = \Config\Services::renderer();

			$view->setVar('one', $id)
				->setVar('pagina', "Perfil")
				->setVar('titulo', "Perfil");
			echo $view->render("Contenido/contenidoPerfil");
		}
	}

	public function ModificarPerfil()
	{
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
		$builder->update($data_array);
		$this->llenarPerfil();
	}
	public function llenarPerfil()
	{
		$db = \Config\Database::connect();
		$builder = $db->table('users');
		$ssesion = \Config\Services::session();
		$id = $ssesion->get("user");
		$data_array = array('Usuario' => $id);
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
			];
		}
		echo json_encode($array);
	}
	public function mostrarClientesReferenciados()
	{
		$db = \Config\Database::connect();
		$builder = $db->table('users');
		$ssesion = \Config\Services::session();
		$id = $ssesion->get("user");
		$data_array = array('Referenciado' => $id);
		$datos = $builder->select('*')->where($data_array)->get()->getResultArray();
		foreach ($datos as $variable) {
			$array[] = [
				'Identificacion' => $variable['Identificacion'],
				'Nombre' => $variable['Nombre'],
				'Apellido' => $variable['Apellido'],
				'Correo' => $variable['Correo'],
				'Ciudad' => $variable['Ciudad'],
				'Pais' => $variable['Pais']
			];
		}
		echo json_encode($array);
	}

	public function agregarClienteRef()
	{
		$Identificacion = $this->request->getVar("Id");
		$Nombre = $this->request->getVar("Nombre");
		$Apellido = $this->request->getVar("Apellido");
		$Correo = $this->request->getVar("Correo");
		$Ciudad = $this->request->getVar("Ciudad");
		$Pais = $this->request->getVar("Pais");
		$Usuario = $this->request->getVar("Usuario");
		$ssesion = \Config\Services::session();
		$id = $ssesion->get("user");
		$compra = new Usuarios();
		try {
			$compra->insert([
				'Identificacion' => $Identificacion,
				'Nombre' => $Nombre,
				'Apellido' => $Apellido,
				'Correo' => $Correo,
				'Ciudad' => $Ciudad,
				'Pais' => $Pais,
				'Referenciado' => $id,
			]);

			$dato = [
				'Identificacion' => $Identificacion,
				'Nombre' => $Nombre,
				'Apellido' => $Apellido,
				'Correo' => $Correo,
				'Ciudad' => $Ciudad,
				'Pais' => $Pais,
				'Referenciado' => $id,
			];
		} catch (\Exception $e) {
			$dato = [
				'error' => $e->getMessage(),
			];
		}
		echo json_encode($dato);
	}
	public function eliminarClienteRef()
	{
		$Identificacion = $this->request->getVar("identificacion");
		$usuario = new Usuarios();
		$data_array = array('Identificacion' => $Identificacion);
		$usuario->delete($data_array);
		echo json_encode("dsjdkskdj");
	}


	public function datosApi()
	{
		$ssesion = \Config\Services::session();
		$id = $ssesion->get("user");
		$view = \Config\Services::renderer();
		$view->setVar('one', $id)
			->setVar('pagina', "Tabla Api")
			->setVar('titulo', "Tabla Api");
		echo $view->render("Contenido/contenidoTablaApi");
	}
	public function info()
	{
		echo phpinfo();
	}
}
