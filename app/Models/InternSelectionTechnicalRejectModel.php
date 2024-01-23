<?php

namespace App\Models;

use CodeIgniter\Model;

class InternSelectionTechnicalRejectModel extends Model
{
    protected $table            = 'intern_selection_technical_reject';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields    = ['selection_id', 'reason'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
