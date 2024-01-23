<?php

namespace App\Models;

use CodeIgniter\Model;

class StudentIdentityModel extends Model
{
    protected $table            = 'student_identity';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields    = ['user_id', 'university_id', 'faculty_id', 'major_id', 'gender', 'birthplace', 'birthdate', 'number_phone', 'address', 'photo', 'curiculum_vitae', 'proposal'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function cekData($id)
    {
        return $this->table('student_identity')
            ->join('users', 'users.id = student_identity.user_id', 'right')
            ->where('users.id', $id)
            ->get()
            ->getResultArray();
    }

    public function showData($id)
    {
        return $this->table('student_identity')
            ->select('student_identity.id, student_identity.user_id, student_identity.gender, student_identity.birthplace, student_identity.birthdate, student_identity.number_phone, student_identity.address, student_identity.photo, intern_university_major.name AS major, student_identity.curiculum_vitae, student_identity.proposal, intern_university.name AS universitas, intern_university_faculty.name AS faculty')
            ->join('intern_university', 'intern_university.id = student_identity.university_id', 'left')
            ->join('intern_university_faculty', 'intern_university_faculty.id = student_identity.faculty_id', 'left')
            ->join('intern_university_major', 'intern_university_major.id = student_identity.major_id', 'left')
            ->join('users', 'users.id = student_identity.user_id', 'right')
            ->where('users.id', $id)
            ->get()
            ->getResultArray();
    }

    public function detailData($id)
    {
        return $this->table('student_identity')
            ->select('student_identity.id, student_identity.user_id, student_identity.gender, student_identity.birthplace, student_identity.birthdate, student_identity.number_phone, student_identity.address, student_identity.photo, student_identity.major_id, intern_university_major.name AS major, student_identity.curiculum_vitae, student_identity.proposal, student_identity.university_id, intern_university.name AS universitas, student_identity.faculty_id, intern_university_faculty.name AS faculty')
            ->join('intern_university', 'intern_university.id = student_identity.university_id', 'left')
            ->join('intern_university_faculty', 'intern_university_faculty.id = student_identity.faculty_id', 'left')
            ->join('intern_university_major', 'intern_university_major.id = student_identity.major_id', 'left')
            ->where('student_identity.id', $id)
            ->get()
            ->getResultArray();
    }
}
