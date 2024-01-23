<?php

namespace App\Models;

use CodeIgniter\Model;

class InternPositionModel extends Model
{
    protected $table            = 'intern_position';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields    = ['division_id', 'position', 'detail', 'start_reqruitment', 'close_reqruitment', 'start_intern', 'close_intern', 'quota', 'realization', 'status'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function DataPosition($npp)
    {
        return $this->db->table('intern_position')
            ->select('intern_position.id, intern_position.position, intern_position.detail, intern_position.start_reqruitment, intern_position.close_reqruitment, intern_position.start_intern, intern_position.close_intern, intern_position.quota, intern_position.realization, intern_position.status')
            ->join('master_personil', 'intern_position.division_id = master_personil.division_id')
            ->where('master_personil.npp', $npp)
            ->orderBy('intern_position.id', 'DESC')
            ->get()
            ->getResultArray();
    }

    public function ShowPosition($id)
    {
        return $this->db->table('intern_position')
            ->where('id', $id)
            ->get()
            ->getResultArray();
    }

    public function PositionReady()
    {
        return $this->db->table('intern_position')
            ->select('intern_position.id, division.name AS divisi, intern_position.position, intern_position.detail, intern_position.start_reqruitment, intern_position.close_reqruitment, intern_position.start_intern, intern_position.close_intern, intern_position.quota, intern_position.realization')
            ->join('division', 'division.id = intern_position.division_id')
            ->where('intern_position.status', 'open')
            ->Where('start_reqruitment <=', date("Y-m-d"))
            ->Where('close_reqruitment >', date("Y-m-d"))
            ->orderBy('id', 'DESC')
            ->get()
            ->getResultArray();
    }

    public function ShowDetailPosition($id)
    {
        return $this->db->table('intern_position')
            ->select('intern_position.id, division.name AS divisi, intern_position.position, intern_position.detail, intern_position.start_reqruitment, intern_position.close_reqruitment, intern_position.start_intern, intern_position.close_intern, intern_position.quota, intern_position.realization')
            ->join('division', 'division.id = intern_position.division_id')
            ->where('intern_position.id', $id)
            ->get()
            ->getResultArray();
    }

    public function quota($year)
    {
        return $this->db->table('intern_position')
            ->selectSum('quota')
            ->selectSum('realization')
            ->where('YEAR(start_intern)', $year)
            ->orWhere('YEAR(close_intern)', $year)
            ->get()
            ->getResultArray();
    }
}
