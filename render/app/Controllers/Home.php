<?php

namespace App\Controllers;

use App\Models\Producto;
use App\Models\Usuarios;

class Home extends BaseController
{
    public function index()
    {
        $ssesion = \Config\Services::session();
        $id = $ssesion->get("user");
        if (!isset($id)) {
            return $this->response->redirect(site_url('/'));
        } else {
            $view = \Config\Services::renderer();
            $view->setVar('one', $id)
                ->setVar('pagina', "Salpicadero");
            echo $view->render("Contenido/contenidoDashboard");
        }
    }

    public function tablas()
    {
        $ssesion = \Config\Services::session();
        $id = $ssesion->get("user");
        if (!isset($id)) {
            return $this->response->redirect(site_url('/'));
        } else {
            $view = \Config\Services::renderer();
            $view->setVar('one', $id)
                ->setVar('pagina', "Tablas");
            echo $view->render("Contenido/contenidoTablas");
        }
    }
    
    public function productos(){
        $ssesion =\Config\Services::session();
        $id= $ssesion->get("user");
        if (empty($id)) {
            return $this->response->redirect(site_url('/'));
        }else{
            $producto = new Productos();
            $respuesta = $producto->getProduct();
            $view = \Config\Services::renderer();
            $view->setVar('one', $id)
            ->setVar('pagina', "Productos")
            ->setVar("productos", $respuesta);
            echo $view->render("Contenido/contenidoProducto");
        }
    }
    public function login()
    {
        $view = \Config\Services::renderer();
        echo $view->render("Contenido/login");
    }

    public function guardar()
    {
        $ssesion = \Config\Services::session();
        $db = \Config\Database::connect();
        $builder = $db->table('users');
        $user = $this->request->getVar("Usuario");

        $pass =  $this->request->getVar("password");
        $data_array = array('Usuario' => $user);
        $datos = $builder->select('*')->where($data_array)->get()->getResultArray();
        foreach ($datos as $variable) {
            if (password_verify($pass, $variable['Password'])) {
                $var = [
                    'user' => $user
                ];
                $ssesion->set($var);
                $this->index();
            } else {
                $view = \Config\Services::renderer();
                echo $view->render("Contenido/login");
            }
        }
    }
    public function salir()
    {
        $ssesion = \Config\Services::session();
        $ssesion->remove("user");
        return "hola";
    }
    public function registrar()
    {
        $id = $this->request->getVar("Id");
        $user = $this->request->getVar("Usuario");
        $db = \Config\Database::connect();
        $builder = $db->table('users');
        $data_array = array('Usuario' => $user,'Identificacion ' => $id);
        $datos = $builder->select('*')->where($data_array)->get()->getResultArray();
        if(count($datos) > 0){
            $pass =  password_hash($this->request->getVar("password"), PASSWORD_DEFAULT);
            $data_pass = array(
                'Password' => $pass
            );
            $builder->where('Usuario', $user);
            $builder->update($data_pass);
            return $this->response->redirect(site_url('/'));
        }else{
            return $this->response->redirect(site_url('/'));
        }
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
        if (!isset($id)) {
            return $this->response->redirect(site_url('/'));
        } else {
            $view = \Config\Services::renderer();

            $view->setVar('one', $id)
                ->setVar('pagina', "Perfil");
            echo $view->render("Contenido/contenidoPerfil");
        }
    }

    public function ModificarPerfil()
    {
        $Nombre=$this->request->getVar("Nombre");
        $Apellido=$this->request->getVar("Apellido");
        $Correo=$this->request->getVar("Correo");
        $Direccion=$this->request->getVar("Direccion");
        $Ciudad=$this->request->getVar("Ciudad");
        $Pais=$this->request->getVar("Pais");
        $SobreMi=$this->request->getVar("SobreMi");
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
        );
        $builder->where('Usuario', $id);
        $builder->update($data_array);
        $view = \Config\Services::renderer();

            $view->setVar('one', $id)
                ->setVar('pagina', "Perfil");
            echo $view->render("Contenido/contenidoPerfil");

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
            $array []= [
                'Nombre' => $variable['Nombre'],
                'Apellido' => $variable['Apellido'],
                'Correo' => $variable['Correo'],
                'Direccion' => $variable['Direccion'],
                'Ciudad' => $variable['Ciudad'],
                'Pais' => $variable['Pais'],
                'SobreMi' => $variable['SobreMi'],
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
            $array []= [
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
        $Identificacion=$this->request->getVar("Id");
        $Nombre=$this->request->getVar("Nombre");
        $Apellido=$this->request->getVar("Apellido");
        $Correo=$this->request->getVar("Correo");
        $Ciudad=$this->request->getVar("Ciudad");
        $Pais=$this->request->getVar("Pais");
        $Usuario=$this->request->getVar("Usuario");
        $ssesion = \Config\Services::session();
        $id = $ssesion->get("user");
        $compra = new Usuarios();
        $compra->insert([
            'Identificacion' => $Identificacion,
            'Nombre' => $Nombre,
            'Apellido' => $Apellido,
            'Correo' => $Correo,
            'Ciudad' => $Ciudad,
            'Pais' => $Pais,
            'Usuario' => $Usuario,
            'Referenciado' => $id,
        ]);
        
        $dato[]=[
            'Identificacion' => $Identificacion,
            'Nombre' => $Nombre,
            'Apellido' => $Apellido,
            'Correo' => $Correo,
            'Ciudad' => $Ciudad,
            'Pais' => $Pais,
            'Usuario' => $Usuario,
            'Referenciado' => $id,
        ];
        echo json_encode($dato);
    }
    public function eliminarClienteRef(){
        $Identificacion=$this->request->getVar("identificacion");
        $usuario = new Usuarios();
        $data_array = array('Identificacion' => $Identificacion);
        $usuario->delete($data_array);
        echo json_encode("dsjdkskdj");
    }
    public function datosApi(){
        $ssesion = \Config\Services::session();
        $id = $ssesion->get("user");
        $view = \Config\Services::renderer();
            $view->setVar('one', $id)
                ->setVar('pagina', "Perfil");
            echo $view->render("Contenido/contenidoTablaApi");
    }
}
