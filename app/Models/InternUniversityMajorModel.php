<?php

namespace App\Models;

use CodeIgniter\Model;

class InternUniversityMajorModel extends Model
{
    protected $table            = 'intern_university_major';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields    = ['name', 'faculty_id'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    function getMajor($fac)
    {
        return $this->db->table('intern_university_major')
            ->where('faculty_id', $fac)
            ->get()
            ->getResultArray();
    }
}
