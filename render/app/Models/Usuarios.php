<?php 
namespace App\Models;

use CodeIgniter\Model;

class Usuarios extends Model{
    protected $table      = 'users';
    // Uncomment below if you want add primary key
     protected $primaryKey = 'id';
     protected $allowedFields = ['Identificacion', 'Nombre', 'Apellido', 'Correo', 'Direccion','Ciudad','Pais','SobreMi','Usuario','Password','Creator','Foto','Rol', "dateProductUpdated"];
     static $rules = [
        'usuario' => [
            'label'  => 'usuario',
            'rules'  => 'required|is_not_unique[users.Usuario]',
            'errors' => [
                'required' => 'el campo {field} es requerido',
                'is_not_unique' => '{field} no se encuentra registrado'
            ],
        ],
        'password' => [
            'label'  => 'Contraseña',
            'rules'  => 'required|min_length[10]',
            'errors' => [
                'required' => 'el campo {field} es requerido',
                'min_length' => '{field} debe tener 8 caracteres',
            ],
        ],
    ];
}