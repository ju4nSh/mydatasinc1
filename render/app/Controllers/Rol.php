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
		$select = $this->request->getVar("select");
		$nombre = $this->request->getVar("nombre");
        $rol = new Roles();
        try{
            $rol->insert([
                'Contenido' => $select,
                'Nombre' => $nombre,
            ]);
    
            $dato = [
                'Contenido' => $select,
                'Nombre' => $nombre,
            ];
            
        }catch(\Exception $e){
            $dato = [
                'error' => $e->getMessage(),
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
        $Rol = $this->request->getVar("Rol");
        
        $data_array = array('Identificacion' => $Identificacion);
        $data = array(
            'Rol' => $Rol
        );
        $builder->where($data_array);
        $builder->update($data);
        $controlador = new Home();
        $controlador->mostrarClientesReferenciados();
    }

    public function consultarDatosRol($id=8)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('roles');
        $ssesion = \Config\Services::session();
        $datos = $builder->select('*')->where('Identificacion',$id)->get()->getResultArray();
        foreach ($datos as $variable) {
            $array= [
                'Contenido' => $variable['Contenido'],
            ];
        }
        return json_encode($datos[0]["Contenido"]);
    }
}
