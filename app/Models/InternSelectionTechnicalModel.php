<?php

namespace App\Models;

use CodeIgniter\Model;

class InternSelectionTechnicalModel extends Model
{
    protected $table            = 'intern_selection_technical';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields    = ['selection_id', 'date_int', 'time_int', 'location_int', 'type_int'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
