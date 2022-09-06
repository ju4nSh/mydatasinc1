<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

use function PHPUnit\Framework\containsOnly;

class Productos extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nombre' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'cantidad' => [
                'type'           => 'INT',
                'constraint'     => 5,
            ],
            'precio' => [
                'type'           => 'DECIMAL',
                'null' => true,
            ],
            'codigo' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'categoria' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'imagen' => [
                'type' => 'LONGTEXT'
            ],
            'link' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'estado' => [
                'type' => 'BIT',
                'null' => true,
            ],
            'descripcion' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'Owner' => [
                'type' => 'INT',
                'constraint'     => 5,
            ]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('productos');
    }

    public function down()
    {
        $this->forge->dropTable('clientes');
    }
}
