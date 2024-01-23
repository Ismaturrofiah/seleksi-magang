<?php

namespace App\Models;

use CodeIgniter\Model;

class InternScheduleModel extends Model
{
    protected $table            = 'intern_schedule';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields    = ['name', 'startdate', 'closedate', 'status'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
