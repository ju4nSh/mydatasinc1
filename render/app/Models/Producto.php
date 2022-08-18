<?php 
namespace App\Models;

use CodeIgniter\Model;

class Producto extends Model{
    protected $table      = 'productos';
    // Uncomment below if you want add primary key
    protected $primaryKey = 'id';
    protected $allowedFields = ['nombre', 'categoria', 'codigo','precio', 'link', 'imagen', 'cantidad', 'estado', 'descripcion'];

}