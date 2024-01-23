<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Intern extends BaseController
{
    public function __construct()
    {
        helper('restclient');
        helper('alert');
    }

    public function index()
    {
        //
    }

    public function quota()
    {
        return view('Intern/quota-intern');
    }

    public function schedule()
    {
        $data = [
            'title' => 'Data Jadwal Seleksi',
        ];
        return view('Intern/schedule-intern', $data);
    }

    public function position()
    {
        $data = [
            'title' => 'Data Posisi Magang',
        ];
        return view('Intern/position-intern', $data);
    }

    public function university()
    {
        return view('Intern/university-intern');
    }

    public function selection_administrative()
    {
        $data = [
            'title' => 'Data Seleksi Magang Administrasi',
        ];
        return view('Intern/selection-administrative-intern', $data);
    }

    public function selection_technical()
    {
        $data = [
            'title' => 'Data Seleksi Magang Technical',
        ];
        return view('Intern/selection-technical-intern', $data);
    }

    public function mentor()
    {
        return view('Intern/mentor-intern');
    }

    public function student()
    {
        return view('Intern/student-intern');
    }

    public function allstudent()
    {
        return view('Intern/all-student-intern');
    }
}
