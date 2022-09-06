<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Clientes extends Migration
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
            'identificacion' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'correo' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'direccion' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'estado' => [
                'type' => 'BIT'
            ]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('clientes');
    }

    public function down()
    {
        $this->forge->dropTable('clientes');
    }
}
