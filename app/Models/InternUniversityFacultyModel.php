<?php

namespace App\Models;

use CodeIgniter\Model;

class InternUniversityFacultyModel extends Model
{
    protected $table            = 'intern_university_faculty';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields    = ['name', 'university_id'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    function getFaculty($univ)
    {
        return $this->db->table('intern_university_faculty')
            ->where('university_id', $univ)
            ->get()
            ->getResultArray();
    }
}
