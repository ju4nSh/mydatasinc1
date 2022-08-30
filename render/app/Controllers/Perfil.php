<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Usuarios;

class Perfil extends Controller
{
    public function ModificarPasswordPerfil()
    {
        $home =  new Home();
        $db = \Config\Database::connect();
        $builder = $db->table('users');
        $ssesion = \Config\Services::session();
        $id = $ssesion->get("id");
        $PassActual = $this->request->getVar("PassActual");
        $PassNueva = $this->request->getVar("PassNueva");
        $PassNuevaConfir = $this->request->getVar("PassNuevaConfir");
        $data_array = array('id' => $id);
        $datos = $builder->select('*')->where($data_array)->get()->getResultArray();
        foreach ($datos as $variable) {
          if(password_verify($PassActual,$variable['Password']) && $PassNueva===$PassNuevaConfir){
            $data = array(
                'Password' => password_hash($PassNueva,PASSWORD_DEFAULT)
            );
            $builder->where($data_array);
            $builder->update($data);
            $home->llenarPerfil();
          }else{
            $array = [
                'error' => 'Verifique la informacion enviada',
            ];
            echo json_encode($array);
        }
        }
    }
}
