<?php

namespace App\Controllers;

use App\Models\Producto;
use App\Models\Usuarios;

class Home extends BaseController
{
    private $usuario;
    public function __construct() {
        $this->usuario = new Usuarios();
    }
    public function index()
    {
        $ssesion = \Config\Services::session();
        $id = $ssesion->get("user");
        $rol = $ssesion->get("rol");
        if (empty($id)) {   
             return $this->response->redirect(site_url('/login'));
        } else {
            $view = \Config\Services::renderer();
            $view->setVar('one', $id)
                ->setVar('pagina', "Salpicadero")
                ->setVar('titulo', "Dashboard")
                ->setVar('rol', $rol);
            echo $view->render("Contenido/contenidoDashboard");
        }
    }

    public function tablas()
    {
        $ssesion = \Config\Services::session();
        $id = $ssesion->get("user");
        $rol = $ssesion->get("rol");
        if (empty($id)) {
            return $this->response->redirect(site_url('/'));
        } else {
            $view = \Config\Services::renderer();
            $view->setVar('one', $id)
                ->setVar('pagina', "Clientes")
                ->setVar('titulo', "Clientes")
                ->setVar('rol', $rol);
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
						$session->set("user", $userExits[0]["Usuario"]);
						$session->set("rol", $userExits[0]["Rol"]);
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
	}
    public function tablaProductoHealth()
    {
        $ssesion = \Config\Services::session();
        $id = $ssesion->get("user");
        $rol = $ssesion->get("rol");
        if (empty($id)) {
            return $this->response->redirect(site_url('/'));
        } else {
            $view = \Config\Services::renderer();
            $view->setVar('one', $id)
                ->setVar('pagina', "DatoProducto")
                ->setVar('titulo', "DatoProducto")
                ->setVar('rol', $rol);
            echo $view->render("Contenido/contenidoDatosProducto");
        }
    }
    public function productos()
    {
        $ssesion = \Config\Services::session();
        $id = $ssesion->get("user");
        $rol = $ssesion->get("rol");
        if (empty($id)) {
            return $this->response->redirect(site_url('/'));
        } else {
            $producto = new Productos();
            $view = \Config\Services::renderer();
            $view->setVar('one', $id)
                ->setVar('pagina', "Productos")
                ->setVar('titulo', "Productos")
                ->setVar('rol', $rol);
            echo $view->render("Contenido/contenidoProducto");
        }
    }
    public function login()
    {
        $ssesion = \Config\Services::session();
        $id = $ssesion->get("user");
        $rol = $ssesion->get("rol");
        if (empty($id)) {
            $view = \Config\Services::renderer();
             echo $view->render("Contenido/login");
        } else {
            $view = \Config\Services::renderer();
            $view->setVar('one', $id)
                ->setVar('pagina', "Salpicadero")
                ->setVar('titulo', "Dashboard")
                ->setVar('rol', $rol);
            echo $view->render("Contenido/contenidoDashboard");
        }
        
    }
    public function obtenerDProd()
	{
        $mercadolibre = new Mercadolibre();
        $product = new DataProducto();
        $limit = 3;
        $offset = $this->request->getVar("offset");
        $calcular= ($offset-1)*$limit;
        $array=[];
        $data=[];
        $arrayDatosProducto=[];
        $arrayAccionesProducto=[];
		$array=$product->obtenerDatosProducto($limit,$calcular);
        for($i =0; $i<count($array); $i++){
          $arrayAccionesProducto[]= $mercadolibre->getAccionesProducto($array[$i]["Codigo"]);
        };
        for($p =0; $p<count($array); $p++){
            $data[]=[  
                "Id" => $array[$p]["Codigo"],
                "Title" => $array[$p]["Nombre"],
                "Imagen" => $array[$p]["Imagen"],
                "Health" => round($arrayAccionesProducto[$p]["health"]*100),
                "Color" => $this->randomColor(),
                "Acciones" => ($arrayAccionesProducto[$p]["name"])
            ];
        }
        echo json_encode($data);
	}
    function randomColor() {
        $str = '#';
        for($i = 0 ; $i < 6 ; $i++) {
            $randNum = rand(0 , 15);
            switch ($randNum) {
                case 10: $randNum = 'A'; break;
                case 11: $randNum = 'B'; break;
                case 12: $randNum = 'C'; break;
                case 13: $randNum = 'D'; break;
                case 14: $randNum = 'E'; break;
                case 15: $randNum = 'F'; break;
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

			$userExits = $this->usuario->select("Creator, Rol")->where("Usuario", $user)->find();
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
						"Creator" => $userExits[0]["Creator"],
						"Rol" => $userExits[0]["Rol"],
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
    }

    public function perfil()
    {
        $ssesion = \Config\Services::session();
        $id = $ssesion->get("user");
        $rol = $ssesion->get("rol");
        if (empty($id)) {
            return $this->response->redirect(site_url('/'));
        } else {
            $view = \Config\Services::renderer();

            $view->setVar('one', $id)
                ->setVar('pagina', "Perfil")
                ->setVar('titulo', "Perfil")
                ->setVar('rol', $rol);
            echo $view->render("Contenido/contenidoPerfil");
        }
    }

    public function ModificarPerfil()
    {
        $Nombre = $this->validar_input($this->request->getVar("Nombre"));
        $Foto = $this->validar_input($this->request->getVar("Foto"));
        $Apellido = $this->validar_input($this->request->getVar("Apellido"));
        $Correo = $this->validar_input($this->request->getVar("Correo"));
        $Direccion = $this->validar_input($this->request->getVar("Direccion"));
        $Ciudad = $this->validar_input($this->request->getVar("Ciudad"));
        $Pais = $this->validar_input($this->request->getVar("Pais"));
        $SobreMi = $this->validar_input($this->request->getVar("SobreMi"));
        $Pass = password_hash($this->request->getVar("Pass"),PASSWORD_DEFAULT);
        if($this->isValidEspacio($Nombre) === true && $this->isValidEspacio($Apellido) === true && $this->isValidEspacio($Ciudad) === true
        && $this->isValidEspacio($Pais) === true && $this->isValidEspacio($SobreMi) === true && $this->isValidUrl($Foto) === true && $this->isValidNumberText($Direccion) === true){
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
            'Foto' => $Foto,
            'Password'=> $Pass
        );
        $builder->where('Usuario', $id);
        $builder->update($data_array);
        $this->llenarPerfil();
        }else{
            $array = [
                'error' => 'Verifique la informacion enviada',
            ];
            echo json_encode($array);
        }
        
    }
    public function llenarPerfil()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('users');
        $ssesion = \Config\Services::session();
        $id = $ssesion->get("user");
        $data_array = array('id' => $id);
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
        $Identificacion = $this->validar_input($this->request->getVar("Id"));
        $Apellido = $this->validar_input($this->request->getVar("Apellido"));
        $Nombre = $this->validar_input($this->request->getVar("Nombre"));
        $Correo = $this->validar_input($this->request->getVar("Correo"));
        $Ciudad = $this->validar_input($this->request->getVar("Ciudad"));
        $Pais = $this->validar_input($this->request->getVar("Pais"));
        $Usuario = $this->validar_input($this->request->getVar("Usuario"));
        if($this->isValidNumber($Identificacion) === true && $this->isValidEspacio($Nombre) === true && $this->isValidEspacio($Apellido) === true && $this->isValidEspacio($Ciudad) === true
         && $this->isValidEspacio($Pais) === true){
        $ssesion = \Config\Services::session();
        $id = $ssesion->get("user");
        $compra = new Usuarios();
        try{
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
            
        }catch(\Exception $e){
            $dato = [
                'error' => $e->getMessage(),
            ];
        }
        }else{
            $dato = [
                'error' => 'Verifique la informacion enviada',
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
        $rol = $ssesion->get("rol");
        $view = \Config\Services::renderer();
        $view->setVar('one', $id)
            ->setVar('pagina', "Tabla Api")
            ->setVar('titulo', "Tabla Api")
            ->setVar('rol', $rol);
        echo $view->render("Contenido/contenidoTablaApi");
    }
    public function validar_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    public function isValidEspacio($text){
        $compara = "/^[a-zA-Z\sñáéíóúÁÉÍÓÚ]+$/";
        if((preg_match($compara, $text))){
            return true;
        }
        else{
            return false;
        }
    }

    public function isValid($text){
        $compara = '/^[a-zA-Z]+$/';
        if((preg_match($compara, $text))){
            return true;
        }
        else{
            return false;
        }
    }

    public function isValidNumber($text){
        $compara = "/^[0-9]+$/";
        if((preg_match($compara, $text))){
            return true;
        }
        else{
            return false;
        }
    }
    public function isValidUrl($text){
        $compara = "/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|](\.)[a-z]{2}/i";
        if((preg_match($compara, $text))){
            return true;
        }
        else{
            return false;
        }
    }
    public function isValidNumberText($text){
        $compara = '/^[a-z][a-z0-9_#*$]{3,}/i';
        if((preg_match($compara, $text))){
            return true;
        }
        else{
            return false;
        }
    }
        
        
}