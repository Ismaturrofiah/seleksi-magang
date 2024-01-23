<?php

namespace App\Models;

use CodeIgniter\Model;

class InternUniversityModel extends Model
{
    protected $table            = 'intern_university';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields    = ['name', 'region_id', 'status'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function DataInternUniversity()
    {
        return $this->db->table('intern_university')
            ->select('intern_university.id, intern_university.name AS university, region.name AS region')
            ->join('region', 'region.id = intern_university.region_id')
            ->orderBy('intern_university.name', 'ASC')
            ->get()
            ->getResultArray();
    }

    public function ShowInternUniversity($id)
    {
        return $this->db->table('intern_university')
            ->select('intern_university.id, intern_university.name AS university, region.name AS region')
            ->join('region', 'region.id = intern_university.region_id')
            ->where('intern_university.id', $id)
            ->orderBy('intern_university.name', 'ASC')
            ->get()
            ->getResultArray();
    }

    public function getPersebaranInstansi($year)
    {
        return $this->db->query(
            "SELECT
                v.region,
                COUNT(v.region) AS total,
                v.latitude,
                v.longitude
                FROM (
                SELECT  
                        x.`name` AS university,
                        y.`name` AS region,
                        y.latitude,
                        y.longitude,
                        x.`year`
                    FROM intern_university AS x
                        JOIN region AS y ON y.id = x.region_id
                    WHERE x.`year` = $year
                ) AS v
                GROUP BY v.region"
        )->getResultArray();
    }
}
