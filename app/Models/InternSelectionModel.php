<?php

namespace App\Models;

use CodeIgniter\Model;

class InternSelectionModel extends Model
{
    protected $table            = 'intern_selection';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields    = ['position_id', 'user_id', 'status'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function CekData($id)
    {
        $stat = ['0', '2'];
        return $this->db->table('intern_selection')
            ->join('users', 'users.id = intern_selection.user_id')
            ->join('intern_position', 'intern_position.id = intern_selection.position_id')
            ->where('intern_selection.user_id', $id)
            ->whereNotIn('intern_selection.status', $stat)
            ->where('intern_position.close_intern >', date("Y-m-d"))
            ->orderBy('intern_selection.id', 'DESC')
            ->limit(1)
            ->get()
            ->getResultArray();
    }

    public function getDataAdministrative($npp)
    {
        return $this->db->table('intern_selection')
            ->select('intern_selection.id, users.name, intern_position.position, intern_position.start_reqruitment, intern_position.close_reqruitment, intern_position.start_intern, intern_position.close_intern, intern_selection.status')
            ->join('users', 'users.id = intern_selection.user_id')
            ->join('intern_position', 'intern_position.id = intern_selection.position_id')
            ->join('master_personil', 'master_personil.division_id = intern_position.division_id')
            ->where('master_personil.npp', $npp)
            ->where('intern_selection.status <=', '1')
            ->orderBy('intern_selection.status', 'DESC')
            ->orderBy('intern_selection.id', 'DESC')
            ->get()
            ->getResultArray();
    }

    public function getDataTechnical($npp)
    {
        return $this->db->table('intern_selection')
            ->select('intern_selection.id, users.name, intern_selection.position_id, intern_selection.user_id, intern_position.position, intern_university.name AS university, intern_university_faculty.name AS faculty, intern_university_major.name AS major, intern_position.start_reqruitment, intern_position.close_reqruitment, intern_position.start_intern, intern_position.close_intern, intern_selection.status')
            ->join('users', 'users.id = intern_selection.user_id')
            ->join('intern_position', 'intern_position.id = intern_selection.position_id')
            ->join('student_identity', 'intern_selection.user_id = student_identity.user_id')
            ->join('intern_university', 'intern_university.id = student_identity.university_id')
            ->join('intern_university_faculty', 'intern_university_faculty.id = student_identity.faculty_id')
            ->join('intern_university_major', 'intern_university_major.id = student_identity.major_id')
            ->join('master_personil', 'master_personil.division_id = intern_position.division_id')
            ->where('master_personil.npp', $npp)
            ->where('intern_selection.status >=', '2')
            ->orderBy('intern_selection.status', 'DESC')
            ->orderBy('intern_selection.id', 'DESC')
            ->get()
            ->getResultArray();
    }

    public function showData($id)
    {
        return $this->db->table('intern_selection')
            ->select('intern_selection.id, intern_position.realization, intern_position.quota,
             intern_selection.user_id, users.name, intern_selection.position_id, student_identity.gender,
              student_identity.birthplace, student_identity.birthdate, student_identity.number_phone,
               student_identity.address, student_identity.photo, student_identity.major_id, 
               intern_university_major.name AS major, student_identity.faculty_id, 
               intern_university_faculty.name AS faculty, student_identity.university_id, 
               intern_university.name AS universitas, intern_position.position, 
               student_identity.curiculum_vitae, student_identity.proposal, intern_selection.position_id, 
               intern_selection.status, intern_selection_administrative.id AS adm_id,
               intern_selection_administrative.reason, intern_selection_technical.date_int, 
               intern_selection_technical.time_int, intern_selection_technical.location_int, 
               intern_selection_technical.type_int, intern_selection_technical_reject.reason AS reason_int')
            ->join('users', 'users.id = intern_selection.user_id')
            ->join('intern_position', 'intern_position.id = intern_selection.position_id')
            ->join('student_identity', 'users.id = student_identity.user_id')
            ->join('intern_university', 'intern_university.id = student_identity.university_id')
            ->join('intern_university_faculty', 'intern_university_faculty.id = student_identity.faculty_id')
            ->join('intern_university_major', 'intern_university_major.id = student_identity.major_id')
            ->join('intern_selection_administrative', 'intern_selection_administrative.selection_id = intern_selection.id', 'left')
            ->join('intern_selection_technical', 'intern_selection_technical.selection_id = intern_selection.id', 'left')
            ->join('intern_selection_technical_reject', 'intern_selection_technical_reject.selection_id = intern_selection.id', 'left')
            ->where('intern_selection.id', $id)
            ->get()
            ->getResultArray();
    }

    public function applyData($id)
    {
        return $this->db->table('intern_selection')
            ->select('intern_selection.id, intern_position.position, division.name AS divisi, intern_position.start_intern, intern_position.close_intern, intern_selection.status')
            ->join('users', 'users.id = intern_selection.user_id')
            ->join('intern_position', 'intern_position.id = intern_selection.position_id')
            ->join('division', 'division.id = intern_position.division_id')
            ->where('users.id', $id)
            ->orderBy('intern_selection.id', 'ASC')
            ->get()
            ->getResultArray();
    }

    public function rejectDataAdm($id)
    {
        return $this->db->table('intern_selection')
            ->select('users.name, users.email, intern_position.position, division.name AS division, intern_position.start_reqruitment, intern_position.close_reqruitment, intern_selection_administrative.reason')
            ->join('intern_position', 'intern_position.id = intern_selection.position_id')
            ->join('division', 'division.id = intern_position.division_id')
            ->join('intern_selection_administrative', 'intern_selection_administrative.selection_id = intern_selection.id')
            ->join('users', 'users.id = intern_selection.user_id')
            ->where('intern_selection.id', $id)
            ->get()
            ->getResultArray();
    }

    public function accDataAdm($id)
    {
        return $this->db->table('intern_selection')
            ->select('users.name, users.email, intern_position.position, division.name AS division, intern_position.start_reqruitment, intern_position.close_reqruitment, intern_selection_technical.date_int, intern_selection_technical.time_int, intern_selection_technical.location_int, intern_selection_technical.type_int')
            ->join('intern_position', 'intern_position.id = intern_selection.position_id')
            ->join('division', 'division.id = intern_position.division_id')
            ->join('intern_selection_technical', 'intern_selection_technical.selection_id = intern_selection.id')
            ->join('users', 'users.id = intern_selection.user_id')
            ->where('intern_selection.id', $id)
            ->get()
            ->getResultArray();
    }

    public function rejectDataInt($id)
    {
        return $this->db->table('intern_selection')
            ->select('users.name, users.email, intern_position.position, division.name AS division, intern_position.start_reqruitment, intern_position.close_reqruitment, intern_selection_technical_reject.reason')
            ->join('intern_position', 'intern_position.id = intern_selection.position_id')
            ->join('division', 'division.id = intern_position.division_id')
            ->join('intern_selection_technical_reject', 'intern_selection_technical_reject.selection_id = intern_selection.id')
            ->join('users', 'users.id = intern_selection.user_id')
            ->where('intern_selection.id', $id)
            ->get()
            ->getResultArray();
    }

    public function accDataInt($id)
    {
        return $this->db->table('intern_selection')
            ->select('users.name, users.email, intern_position.position, division.name AS division, intern_position.start_reqruitment, intern_position.close_reqruitment, intern_position.start_intern, intern_position.close_intern')
            ->join('intern_position', 'intern_position.id = intern_selection.position_id')
            ->join('division', 'division.id = intern_position.division_id')
            ->join('users', 'users.id = intern_selection.user_id')
            ->where('intern_selection.id', $id)
            ->get()
            ->getResultArray();
    }
}
