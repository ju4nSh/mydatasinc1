<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Usuarios;

class Personas extends Controller
{
    public function validarConexionMerLi(){
        $ssesion = \Config\Services::session();
        $id = $ssesion->get("rol");
        if($id==="Administrador"){
            echo"Bien";
        }else{
            echo "No";
        }
    }
 
}
