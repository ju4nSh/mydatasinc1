<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Cliente;

class Clientes extends Controller
{

    private $clientes;
    public function __construct()
    {
        $this->clientes = new Cliente();
    }
    public function index()
    {
        $view = \Config\Services::renderer();
        $view->setVar('one', session("user"))
            ->setVar('pagina', "Usuarios");
        return $view->render("Contenido/contenidoUsuario");
    }
    public function llenarClientes()
    {
        for ($i = 0; $i < 1000; $i++) {
            $data = [
                "nombre" => $this->generateName(),
                "identificacion" => $this->generateId(),
                "correo" => $this->generateCorreo(),
                "direccion" => $this->generateDir(),
            ];
            $this->clientes->save($data);
        }
    }
    public function generateName()
    {
        $alpha = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'ñ', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z'];
        $name = "";
        for ($i = 0; $i < rand(8, 15); $i++) {
            $name .= $alpha[rand(0, count($alpha) - 1)];
        }
        return $name;
    }
    public function generateId()
    {
        $alpha = ['0', '1', '2', '2', '4', '5', '6', '7', '8', '9'];
        $id = "";
        for ($i = 0; $i < rand(8, 15); $i++) {
            $id .= $alpha[rand(0, count($alpha) - 1)];
        }
        return $id;
    }
    public function generateCorreo()
    {
        $alpha = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'ñ', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z'];
        $name = "";
        for ($i = 0; $i < rand(8, 15); $i++) {
            $name .= $alpha[rand(0, count($alpha) - 1)];
        }
        $name .= "@";
        for ($i = 0; $i < 3; $i++) {
            $name .= $alpha[rand(0, count($alpha) - 1)];
        }
        $name .= ".com";
        return $name;
    }
    public function generateDir()
    {
        $alpha = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'ñ', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z'];
        $dir = "";
        for ($i = 0; $i < rand(8, 15); $i++) {
            $dir .= $alpha[rand(0, count($alpha) - 1)];
        }
        return $dir;
    }
}