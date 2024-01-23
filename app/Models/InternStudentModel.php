<?php

namespace App\Models;

use CodeIgniter\Model;

class InternStudentModel extends Model
{
    protected $table            = 'intern_list';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields    = ['user_id', 'position_id', 'mentor_id', 'status'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function DataStudent()
    {
        return $this->db->table('intern_list')
            ->select('intern_list.id, users.name AS name, intern_university_major.name AS major, intern_university_faculty.name AS faculty, intern_university.name AS university, division.name AS divisi, intern_position.position, master_mentor.name AS mentor, intern_position.start_intern, intern_position.close_intern, intern_list.status')
            ->join('users', 'users.id = intern_list.user_id')
            ->join('student_identity', 'student_identity.user_id = intern_list.user_id')
            ->join('intern_university', 'intern_university.id = student_identity.university_id')
            ->join('intern_university_faculty', 'intern_university_faculty.id = student_identity.university_id')
            ->join('intern_university_major', 'intern_university_major.id = student_identity.major_id')
            ->join('intern_position', 'intern_position.id = intern_list.position_id')
            ->join('division', 'division.id = intern_position.division_id')
            ->join('master_personil AS master_mentor', 'master_mentor.npp = intern_list.mentor_id', 'left')
            ->orderBy('intern_list.status', 'ASC')
            ->orderBy('users.name', 'ASC')
            ->get()
            ->getResultArray();
    }

    public function DataStudentDivision($npp)
    {
        return $this->db->table('intern_list')
            ->select('intern_list.id, users.name AS name, intern_university_major.name AS major, intern_university_faculty.name AS faculty, intern_university.name AS university, division.name AS divisi, intern_position.position, master_mentor.name AS mentor, intern_position.start_intern, intern_position.close_intern, intern_list.status')
            ->join('users', 'users.id = intern_list.user_id')
            ->join('student_identity', 'student_identity.user_id = intern_list.user_id')
            ->join('intern_university', 'intern_university.id = student_identity.university_id')
            ->join('intern_university_faculty', 'intern_university_faculty.id = student_identity.university_id')
            ->join('intern_university_major', 'intern_university_major.id = student_identity.major_id')
            ->join('intern_position', 'intern_position.id = intern_list.position_id')
            ->join('division', 'division.id = intern_position.division_id')
            ->join('master_personil', 'master_personil.division_id = intern_position.division_id')
            ->join('master_personil AS master_mentor', 'master_mentor.npp = intern_list.mentor_id', 'left')
            ->where('master_personil.npp', $npp)
            ->orderBy('intern_list.status', 'ASC')
            ->orderBy('users.name', 'ASC')
            ->get()
            ->getResultArray();
    }

    public function ShowStudent($id)
    {
        return $this->db->table('intern_list')
            ->select('intern_list.id, intern_list.mentor_id, master_personil.name, intern_list.status')
            ->join('master_personil', 'master_personil.npp = intern_list.mentor_id', 'left')
            ->where('intern_list.id', $id)
            ->get()
            ->getResultArray();
    }

    public function CheckList($nama, $univ, $major, $division, $year)
    {
        return $this->db->table('intern_list')
            ->where('name', $nama)
            ->where('university_id', $univ)
            ->where('major', $major)
            ->where('division_id', $division)
            ->where('year', $year)
            ->get()
            ->getResultArray();
    }

    public function getPersebaranInstansi($year)
    {
        return $this->db->table('intern_list')
            ->selectCount('intern_university.region_id', 'total')
            ->select('region.latitude, region.longitude, region.name AS region')
            ->join('student_identity', 'student_identity.user_id = intern_list.user_id')
            ->join('intern_position', 'intern_position.id = intern_list.position_id')
            ->join('intern_university', 'intern_university.id = student_identity.university_id')
            ->join('region', 'region.id = intern_university.region_id')
            ->where('YEAR(start_intern)', $year)
            ->orWhere('YEAR(close_intern)', $year)
            ->groupBy('intern_university.region_id')
            ->get()
            ->getResultArray();
    }

    public function getPersebaranDivisi($year)
    {
        return $this->db->table('intern_list')
            ->selectCount('intern_position.division_id', 'total')
            ->select('division.name AS division')
            ->join('intern_position', 'intern_position.id = intern_list.position_id')
            ->join('division', 'division.id = intern_position.division_id')
            ->where('YEAR(start_intern)', $year)
            ->orWhere('YEAR(close_intern)', $year)
            ->groupBy('intern_position.division_id')
            ->get()
            ->getResultArray();
    }
}
