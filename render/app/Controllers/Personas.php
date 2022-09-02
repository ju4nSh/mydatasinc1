<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Usuarios;

class Personas extends Controller
{
    public function validarConexionMerLi(){
        $ssesion = \Config\Services::session();
        $id = $ssesion->get("rol");
        if($id==="0"){
            echo"Bien";
        }else{
            echo "No";
        }
    }

    public function ValidarModificarContraseña(){
        $Identificacion = $this->request->getVar("identificacion");
        $db = \Config\Database::connect();
        $builder = $db->table('users');
        $data_array = array('Identificacion' => $Identificacion);
        $datos = $builder->select('Password')->where($data_array)->get()->getResultArray();
        if(empty($datos[0]["Password"])){
            echo"error";
        }else{
            echo json_encode($datos[0]["Password"]);
        }
    }
    
    public function PassClienteRef(){
        $Identificacion = $this->request->getVar("id");
        $Password = $this->request->getVar("Password");
        $db = \Config\Database::connect();
        $builder = $db->table('users');
        $data_array = array(
            'Password' => password_hash($Password,PASSWORD_DEFAULT)
        );
        $builder->where('Identificacion', $Identificacion);
        $data=$builder->update($data_array);
        return json_encode($data);
    }

    public function PersonasRolNull(){
        $db = \Config\Database::connect();
        $builder = $db->table('users');
        $ssesion = \Config\Services::session();
        $id = $ssesion->get("id");
        $rol = $ssesion->get("rol");
        if($rol == 0){
            $data_array = array('Creator' => $id,'Rol' => NULL);
        $datos = $builder->select('*')->where($data_array)->get()->getResultArray();
        if(count($datos) > 0){
            foreach ($datos as $variable) {
                $array[] = [
                    'Identificacion' => $variable['Identificacion'],
                    'Nombre' => $variable['Nombre'],
                    'Apellido' => $variable['Apellido'],
                    'Correo' => $variable['Correo'],
                    'Ciudad' => $variable['Ciudad'],
                    'Pais' => $variable['Pais'],
                ];
            }
        }else{
            $array=[];
        }
        }else{
            $data_array = array('id' => $id);
        $datos = $builder->select('Creator')->where($data_array)->get()->getResultArray();
        $data_array1 = array('Creator' => $datos[0]["Creator"],'Rol' => NULL);
        $datos1 = $builder->select('*')->where($data_array1)->get()->getResultArray();
        if(count($datos1) > 0){
            foreach ($datos1 as $variable) {
                $array[] = [
                    'Identificacion' => $variable['Identificacion'],
                    'Nombre' => $variable['Nombre'],
                    'Apellido' => $variable['Apellido'],
                    'Correo' => $variable['Correo'],
                    'Ciudad' => $variable['Ciudad'],
                    'Pais' => $variable['Pais'],
                ];
            }
        }else{
            $array=[];
        }
        }
        
        echo json_encode($array);
    }
    
    
}
