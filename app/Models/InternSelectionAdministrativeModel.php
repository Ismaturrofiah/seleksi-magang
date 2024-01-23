<?php

namespace App\Models;

use CodeIgniter\Model;

class InternSelectionAdministrativeModel extends Model
{
    protected $table            = 'intern_selection_administrative';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields    = ['selection_id', 'reason'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function showData($id)
    {
        return $this->db->table('intern_selection_administrative')
            ->where('id', $id)
            ->get()
            ->getResultArray();
    }
}
