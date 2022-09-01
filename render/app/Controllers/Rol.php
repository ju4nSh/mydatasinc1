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
        $ssesion = \Config\Services::session();
        $id = $ssesion->get("id");
        $rol = new Roles();
        if ($home->isValidEspacio($this->request->getVar("nombre"))) {
            if (strlen($this->request->getVar("nombre")) > 0 && strlen($select) > 0) {
                try {
                    $rol->insert([
                        'Contenido' => $select,
                        'Nombre' => $this->request->getVar("nombre"),
                        'Usuario' => $id
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
        $id = $ssesion->get("id");
        $datos = $builder->select('*')->where('Usuario',$id)->get()->getResultArray();
        if(count($datos) == 0){
            $builder1 = $db->table('users');
            $datos1 = $builder1->select('Creator')->where('id',$id)->get()->getResultArray();
            $datos2 = $builder1->select('id')->where('id',$datos1[0]["Creator"])->get()->getResultArray();
            $datos3 = $builder->select('*')->where('Usuario',$datos2[0]["id"])->get()->getResultArray();
            foreach ($datos3 as $variable) {
                $array[] = [
                    'Identificacion' => $variable['Identificacion'],
                    'Nombre' => $variable['Nombre'],
                    'Contenido' => $variable['Contenido'],
                ];
            }
        }else{
            foreach ($datos as $variable) {
                $array[] = [
                    'Identificacion' => $variable['Identificacion'],
                    'Nombre' => $variable['Nombre'],
                    'Contenido' => $variable['Contenido'],
                ];
            }
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
        if (count($datos) == 0) {
            $data_array = array('Identificacion' => $Identificacion);
            $builder->where($data_array);
            $dato = $builder->delete();
            $array = [
                'respuesta' => $dato
            ];
            echo json_encode($array);
        } else {
            foreach ($datos as $variable) {
                $array[] = [
                    'Identificacion' => $variable['Identificacion'],
                    'Nombre' => $variable['Nombre']
                ];
            }
            echo json_encode($array);
        }
    }
    public function mostrarRolesDelete()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('roles');
        $Identificacion = $this->request->getVar("identificacion");
        $ssesion = \Config\Services::session();
        $id = $ssesion->get("id");
        $datos = $builder->select('*')->where('Usuario',$id)->get()->getResultArray();
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
    public function modificarRolAUsuarios()
    {
        $Identificacion = $this->request->getVar("Identificacion");
        $Nombre = $this->request->getVar("Nombre");
        $Rol = $this->request->getVar("Rol");
        for($i=0; $i<sizeof($Identificacion); $i++){
            $db = \Config\Database::connect();
            $builder = $db->table('users');
            $data_array = array(
                'Rol' => $Rol[$i],
            );
            $builder->where('Identificacion', $Identificacion[$i]);
            $builder->update($data_array);
        }
        echo "Modificado Correctamente";
    }

    public function ModificarContenidoRol(){
        $Identificacion = $this->request->getVar("Identificacion");
        $Contenido = $this->request->getVar("select");
        $db = \Config\Database::connect();
        $builder = $db->table('roles');
        $data_array = array('Identificacion' => $Identificacion);
        $data = array(
            'Contenido' => $Contenido
        );
        $builder->where($data_array);
        echo json_encode($builder->update($data));
    }
    
}
