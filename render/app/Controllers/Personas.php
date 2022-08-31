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
    
    
}
