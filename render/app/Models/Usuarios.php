<?php 
namespace App\Models;

use CodeIgniter\Model;

class Usuarios extends Model{
    protected $table      = 'users';
    // Uncomment below if you want add primary key
     protected $primaryKey = 'id';
     protected $allowedFields = ['Identificacion', 'Nombre', 'Apellido', 'Correo', 'Direccion','Ciudad','Pais','SobreMi','Usuario','Password','Creator','Foto','Rol'];
}