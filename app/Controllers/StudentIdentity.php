<?php

namespace App\Controllers;

use App\Models\StudentIdentityModel;
use App\Models\UsersModel;

use App\Controllers\BaseController;

class StudentIdentity extends BaseController
{
    public function index()
    {
        $user = new UsersModel();

        $user_id = $user->getUser(session()->get('email'));
        $id = $user_id[0]['id'];

        session();
        $data = [
            'title' => "Data Diri Mahasiswa",
            'validation' => \Config\Services::validation(),
            'user_id' => $id,
        ];
        return view('Users/student-identity', $data);
    }

    public function create()
    {
        $cv = $this->request->getVar('cv');
        if (!$this->validate([
            'user_id' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Silahkan masukan {field}',
                ]
            ],
            'univ' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Silahkan pilih {field}',
                ]
            ],
            'major' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Silahkan masukan {field}',
                ]
            ],
            'cv' => [
                'rules' => 'uploaded[cv]|max_size[cv,2048]|mime_in[cv,application/pdf]',
            ],
            'proposal' => [
                'rules' => 'uploaded[proposal]|max_size[proposal,2048]|mime_in[proposal,application/pdf]',
            ],
            'status' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Silahkan masukan {field}',
                ]
            ],
        ])) {
            $validation = \Config\Services::validation();
            return redirect()->to('/user/identity')->withInput();
        };

        $student = new StudentIdentityModel();

        // Upload File
        $user = $this->request->getVar('user_id');
        $cv = $this->request->getVar('cv');
        $namacv = $user . "_curiculum_vitae.pdf";
        $cv->move('cv', $namacv);

        $proposal = $this->request->getVar('proposal');
        $namaproposal = $user . "_proposal.pdf";
        $proposal->move('proposal', $namaproposal);


        $data = [
            'user_id' => $this->request->getVar('user_id'),
            'university_id' => $this->request->getVar('university_id'),
            'major' => $this->request->getVar('major'),
            'curiculum_vitae' => $namacv,
            'proposal' => $namaproposal,
            'status' => $this->request->getVar('status'),
        ];
        dd($data);
        $result = $student->save($data);

        if ($result) {
            setFlashDataSuccess("Berhasil mengisi data diri");
            return redirect()->to(site_url('/user/identity'));
        } else {
            setFlashDataError("Gagal mengisi data diri");
            return redirect()->to(site_url('/user/identity'));
        }
    }
}
