<?php

namespace App\Controllers;

use App\Models\Usuarios;

class Home extends BaseController
{
    public function index()
    {
        $ssesion =\Config\Services::session();
        $id= $ssesion->get("user");
        if (!isset($id)) {
            return $this->response->redirect(site_url('/'));
        }else{
            $view = \Config\Services::renderer();
            $view->setVar('one', $id)
                ->setVar('pagina', "Salpicadero");
            echo $view->render("Contenido/contenidoDashboard");
        }
    }

    public function tablas(){
        $ssesion =\Config\Services::session();
        $id= $ssesion->get("user");
        if (!isset($id)) {
            return $this->response->redirect(site_url('/'));
        }else{
            $view = \Config\Services::renderer();
            $view->setVar('one', $id)
                 ->setVar('pagina', "Tablas");
            echo $view->render("Contenido/contenidoTablas");
        }
        
    }

    public function productos(){
        $ssesion =\Config\Services::session();
        $id= $ssesion->get("user");
        if (!isset($id)) {
            return $this->response->redirect(site_url('/'));
        }else{
            $view = \Config\Services::renderer();
            $view->setVar('one', $id)
            ->setVar('pagina', "Productos");
            echo $view->render("Contenido/contenidoProducto");
        }
        
    }
    public function login(){
        $view = \Config\Services::renderer();
        echo $view->render("Contenido/login");
    }

    public function guardar()
    {
        $ssesion =\Config\Services::session();
        $db = \Config\Database::connect();
        $builder = $db->table('users');
        $user = $this->request->getVar("Usuario");
        $pass =  $this->request->getVar("password");
        $data_array = array('Usuario' => $user);
        $datos = $builder->select('*')->where($data_array)->get()->getResultArray();
        foreach ($datos as $variable) {
            if(password_verify($pass,$variable['Password'])){
                $var=[
                    'user'=>$user
                ];
                $ssesion->set($var);
                $this->index();
            }else{
                $view = \Config\Services::renderer();
            echo $view->render("Contenido/login");
            }
        }
    }
    public function salir(){
        $ssesion =\Config\Services::session();
        $ssesion->remove("user");
        return "hola";
    }
    public function registrar(){
        $id = $this->request->getVar("Id");
        $user = $this->request->getVar("Usuario");
        $pass =  password_hash($this->request->getVar("password"), PASSWORD_DEFAULT);
        $compra = new Usuarios();
        $compra->insert([
            'Identificacion' => $id,
            'Usuario' => $user,
            'Password' => $pass
        ]);
        return $this->response->redirect(site_url('/'));
    }
    public function mostrarRegistrar(){
        $view = \Config\Services::renderer();
        echo $view->render("Contenido/Registrar");
    }
    
}
