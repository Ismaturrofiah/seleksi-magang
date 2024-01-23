<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Users extends Migration
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
            'npp' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'name' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'email' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'password' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'role' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default' => 2,
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
        $this->forge->createTable('users');
    }

    public function down()
    {
        $this->forge->dropTable('users');
    }
}
