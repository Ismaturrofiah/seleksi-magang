<?php

namespace App\Models;

use CodeIgniter\Model;

class InternActivityModel extends Model
{
    protected $table            = 'intern_activity';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields    = ['intern_id', 'activity', 'date', 'status'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
