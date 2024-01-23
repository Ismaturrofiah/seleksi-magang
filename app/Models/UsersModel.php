<?php

namespace App\Models;

use CodeIgniter\Model;
use Exception;

class UsersModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields    = ['npp', 'name', 'email', 'password', 'role', 'status'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    function getNPP($npp)
    {
        $data = $this->table("users")
            ->where("status", "active")
            ->where("npp", $npp)
            ->orWhere("email", $npp)
            ->first();
        return $data;
    }

    function getData()
    {
        return $this->table("users")
            ->orderBy('status', 'ASC')
            ->orderBy('role', 'ASC')
            ->orderBy('name', 'ASC')
            ->get()
            ->getResultArray();
    }

    function showData($id)
    {
        return $this->table("users")
            ->orderBy('status', 'ASC')
            ->orderBy('role', 'ASC')
            ->orderBy('name', 'ASC')
            ->where('id', $id)
            ->get()
            ->getResultArray();
    }

    function Session($npp)
    {
        return $this->table('users')
            ->select('users.npp, users.name, master_personil.division_id')
            ->join('master_personil', 'master_personil.npp = users.npp')
            ->where('users.npp', $npp)
            ->get()
            ->getResultArray();
    }

    public function getUser($id)
    {
        return $this->db->table('users')
            ->where('id', $id)
            ->get()
            ->getResultArray();
    }
}
