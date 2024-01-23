<?php

namespace App\Models;

use CodeIgniter\Model;

class SettingDisplayModel extends Model
{
    protected $table            = 'display_dashboard';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields    = ['name_image', 'caption'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getData()
    {
        return $this->db->table('display_dashboard')
            ->get()
            ->getResultArray();
    }

    public function showData($id)
    {
        return $this->db->table('display_dashboard')
            ->where('id', $id)
            ->get()
            ->getResultArray();
    }
}
