<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class InternPosition extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'division_id' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'position' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'detail' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'start_reqruitment' => [
                'type' => 'DATE',
                'null' => false,
            ],
            'close_reqruitment' => [
                'type' => 'DATE',
                'null' => false,
            ],
            'start_intern' => [
                'type' => 'DATE',
                'null' => false,
            ],
            'close_intern' => [
                'type' => 'DATE',
                'null' => false,
            ],
            'quota' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'realization' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default' => 0,
            ],
            'status' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'default' => 'active',
            ],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp',
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('intern_position');
    }

    public function down()
    {
        $this->forge->dropTable('intern_position');
    }
}
