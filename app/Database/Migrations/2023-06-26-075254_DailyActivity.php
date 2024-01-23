<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DailyActivity extends Migration
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
            'intern_id' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'activity' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'date' => [
                'type' => 'DATE',
                'null' => false,
            ],
            'status' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default' => 1,
            ],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp',
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('intern_activity');
    }

    public function down()
    {
        $this->forge->dropTable('intern_activity');
    }
}
