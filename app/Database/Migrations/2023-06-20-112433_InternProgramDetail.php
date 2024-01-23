<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class InternProgramDetail extends Migration
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
            'program_id' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'intern_id' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp',
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('intern_program_detail');
    }

    public function down()
    {
        $this->forge->dropTable('intern_program_detail');
    }
}
