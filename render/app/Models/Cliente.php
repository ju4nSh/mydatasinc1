<?php 
namespace App\Models;

use CodeIgniter\Model;

class Cliente extends Model{
    protected $table      = 'clientes';
    // Uncomment below if you want add primary key
    protected $primaryKey = 'id';
    protected $allowedFields = ['nombre', 'identificacion', 'correo','direccion'];
}