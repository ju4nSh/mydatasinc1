<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Usuarios;
use CodeIgniter\CLI\CLI;

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
    public function Prueba($to){
        $db = \Config\Database::connect();
        $builder = $db->table('productos');
        $countEstado1=0;
        $countCantidadMen15=0;
        $countCantidadMen50=0;
        $countCantidadMay50=0;
        $countEstado0=0;
        $datos = $builder->select('nombre,cantidad,precio,estado')->get()->getResultArray();
        $thead = [
            CLI::color('Nombre', 'white'),
            CLI::color('Cantidad', 'white'), 
            CLI::color('Precio', 'white'),
            CLI::color('Estado', 'white'),  
        ];
        CLI::newLine();
        CLI::print("Tabla Productos");

        foreach($datos as $variable){
            if($variable["estado"]==1){
                $countEstado1+=1; 
                if($variable["cantidad"]>=15 &&  $variable["cantidad"]<50){
                    $countCantidadMen50+=1;
                    $tbody []= [
                        CLI::color($variable["nombre"],'white'),
                        CLI::color($variable["cantidad"],'yellow'),
                        CLI::color($variable["precio"],'white'),
                        CLI::color($variable["estado"],'green')
                    ];
                }else if($variable["cantidad"]>=50){
                    $countCantidadMay50+=1;
                    $tbody []= [
                        CLI::color($variable["nombre"],'white'),
                        CLI::color($variable["cantidad"],'green'),
                        CLI::color($variable["precio"],'white'),
                        CLI::color($variable["estado"],'green')
                    ];
                }else{
                    $countCantidadMen15+=1;
                    $tbody []= [
                        CLI::color($variable["nombre"],'white'),
                        CLI::color($variable["cantidad"],'red'),
                        CLI::color($variable["precio"],'white'),
                        CLI::color($variable["estado"],'green')
                    ];
                }
            }else{
                $countEstado0+=1;
                $tbody []= [
                    CLI::color($variable["nombre"],'light_red'),
                    CLI::color($variable["cantidad"],'light_red'),
                    CLI::color($variable["precio"],'light_red'),
                    CLI::color($variable["estado"],'light_red')
                ];
            }
        };
        CLI::table($tbody, $thead);
        CLI::newLine();
        CLI::print(count($datos). ' Total de productos' );CLI::newLine();
        CLI::print("Resumen tabla : ".$countEstado1. ' Productos Activos.' );CLI::newLine();
        CLI::print($countEstado0. ' Productos Inactivos.' );CLI::newLine();
        CLI::print('Detalle Tabla' );CLI::newLine();
        CLI::print($countCantidadMen15. ' Productos con una cantidad menor de 15.' );CLI::newLine();
        CLI::print($countCantidadMen50. ' Productos con una cantidad menor de 50.' );CLI::newLine();
        CLI::print($countCantidadMay50. ' Productos con una cantidad mayor de 50.' );CLI::newLine();
    }

    public function PausarLote($to){
        $db = \Config\Database::connect();
        $builder = $db->table('productos');
        $datos = $builder->select('codigo')->like("nombre",$to,'after')->limit(2)->get()->getResultArray();
        foreach($datos as $variable){
            CLI::newLine();
            $uri ="https://api.mercadolibre.com/items/".$variable["codigo"];

		$descripcion = [
			"status"=>"paused"
		];
		$conexion = curl_init();
		$token ="APP_USR-4332857485021545-090516-f69a7b649907e5a96228a68c6007cf56-833930674";
		curl_setopt($conexion, CURLOPT_URL, $uri);
		curl_setopt($conexion, CURLOPT_CUSTOMREQUEST, 'PUT');
		curl_setopt($conexion, CURLOPT_HTTPHEADER, array('Accept: application/json', 'Content-Type: application/json', "Authorization: Bearer $token"));
		curl_setopt($conexion, CURLOPT_POSTFIELDS, json_encode($descripcion));
		curl_setopt($conexion, CURLOPT_RETURNTRANSFER, 1);

		$r = curl_exec($conexion);
		curl_close($conexion);
		print_r($r);
        CLI::newLine();

        }
    }
    
    
}
