<?php

namespace App\Controllers;

use App\Models\Producto;

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
    public function login(){
        $view = \Config\Services::renderer();
        echo $view->render("Contenido/login");
    }

    public function guardar()
    {
        $ssesion =\Config\Services::session();
        $nombre = $this->request->getVar("Nombre");
        $user = $this->request->getVar("Usuario");
        $pass = $this->request->getVar("password");
        $home = new Home();
        if ($user==="juan" && $pass==="1234") {
            $var=[
                'user'=>$nombre
            ];
            $ssesion->set($var);
            $this->index();
        //    $r= new Home();
        //    $r->index();
        } else {
            $view = \Config\Services::renderer();
            echo $view->render("Contenido/login");
        }
    }
    public function salir(){
        $ssesion =\Config\Services::session();
        $ssesion->remove("user");
        return "hola";
    }
}
