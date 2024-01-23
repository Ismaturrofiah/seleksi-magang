<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class StudentIdentity extends Migration
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
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'university_id' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'major' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'curiculum_vitae' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'proposal' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp',
        ]);
        $this->forge->addKey('id', true);
        // $this->forge->addForeignKey('month_id', 'month', 'id');
        $this->forge->createTable('student_identity');
    }

    public function down()
    {
        $this->forge->dropTable('student_identity');
    }
}
