<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Usuarios;
use App\Models\Roles;

class Rol extends Controller
{
    public function abrirContenidoRol()
    {
        $ssesion = \Config\Services::session();
        $id = $ssesion->get("user");
        $rol = $ssesion->get("rol");
        if (empty($id)) {
            return $this->response->redirect(site_url('/'));
        } else {
            $view = \Config\Services::renderer();
            $view->setVar('one', $id)
                ->setVar('pagina', "Roles")
                ->setVar('titulo', "Roles")
                ->setVar('rol', $rol);
            echo $view->render("Contenido/contenidoRoles");
        }
    }
    public function agregarNuevoRol()
    {
        $home = new Home();
        $select = $this->request->getVar("select");
        $rol = new Roles();
        if ($home->isValidEspacio($this->request->getVar("nombre"))) {
            if (strlen($this->request->getVar("nombre")) > 0 && strlen($select) > 0) {
                try {
                    $rol->insert([
                        'Contenido' => $select,
                        'Nombre' => $this->request->getVar("nombre"),
                    ]);

                    $dato = [
                        'Contenido' => $select,
                        'Nombre' => $this->request->getVar("nombre"),
                    ];
                } catch (\Exception $e) {
                    $dato = [
                        'error' => $e->getMessage(),
                    ];
                }
            } else {
                $dato = [
                    'error' => "Rellene el campo Nombre",
                ];
            }
        } else {
            $dato = [
                'error' => "Rellene el campo Nombre",
            ];
        }
        echo json_encode($dato);
    }

    public function mostrarRolesRegistrados()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('roles');
        $ssesion = \Config\Services::session();
        $datos = $builder->select('*')->get()->getResultArray();
        foreach ($datos as $variable) {
            $array[] = [
                'Identificacion' => $variable['Identificacion'],
                'Nombre' => $variable['Nombre'],
                'Contenido' => $variable['Contenido'],
            ];
        }
        echo json_encode($array);
    }
    public function modificarRol()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('users');
        $Identificacion = $this->request->getVar("Identificacion");
        $Rol = $this->request->getVar("Rol1");

        $data_array = array('Identificacion' => $Identificacion);
        $data = array(
            'Rol' => $Rol
        );
        $builder->where($data_array);
        $builder->update($data);
        $controlador = new Home();
        $controlador->mostrarClientesReferenciados();
    }

    public function consultarDatosRol($id = 8)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('roles');
        $ssesion = \Config\Services::session();
        $datos = $builder->select('*')->where('Identificacion', $id)->get()->getResultArray();
        foreach ($datos as $variable) {
            $array = [
                'Contenido' => $variable['Contenido'],
            ];
        }
        return json_encode($datos[0]["Contenido"]);
    }

    public function eliminarRol()
    {
        $Identificacion = $this->request->getVar("identificacion");
        $db = \Config\Database::connect();
        $builder = $db->table('roles');
        $builder1 = $db->table('users');
        $datos = $builder1->select('Identificacion,Nombre')->where('Rol', $Identificacion)->get()->getResultArray();
        if (count($datos) > 0) {
            foreach ($datos as $variable) {
                $array[] = [
                    'Identificacion' => $variable['Identificacion'],
                    'Nombre' => $variable['Nombre']
                ];
            }
            echo json_encode($array);
        } else {
            $data_array = array('Identificacion' => $Identificacion);
            $builder->where($data_array);
            $dato = $builder->delete();
            $array[] = [
                'respuesta' => $dato
            ];
            echo json_encode($array);
        }
    }
    public function mostrarRolesDelete()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('roles');
        $Identificacion = $this->request->getVar("identificacion");
        $datos = $builder->select('*')->get()->getResultArray();
        foreach ($datos as $variable) {
            if($variable['Identificacion']!=$Identificacion){
                $array[] = [
                    'Identificacion' => $variable['Identificacion'],
                    'Nombre' => $variable['Nombre'],
                    'Contenido' => $variable['Contenido'],
                ];
            }
           
        }
        echo json_encode($array);
    }
}
