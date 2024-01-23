<?php

namespace App\Controllers\API;

use App\Models\StudentIdentityModel;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

class StudentIdentity extends ResourceController
{
    protected $modelName = 'App\Models\StudentIdentityModel';
    protected $format = 'json';

    use ResponseTrait;

    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        //
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($id = null)
    {
        $student = new StudentIdentityModel();
        $data = [
            'message' => 'success',
            'data' => $student->detailData($id),
        ];

        if ($data['data'] == null) {
            return $this->failNotFound('Data tidak ditemukan');
        }

        return $this->respond($data, 200);
    }

    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function new()
    {
        //
    }

    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function create()
    {
        $validation = \Config\Services::validation();
        $rules = [
            'user_id' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Silahkan masukan {field}',
                ]
            ],
            'gender' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Silahkan pilih {field}',
                ]
            ],
            'birthplace' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Silahkan pilih {field}',
                ]
            ],
            'birthdate' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Silahkan pilih {field}',
                ]
            ],
            'number_phone' => [
                'rules' => 'required|min_length[10]|max_length[13]',
                'errors' => [
                    'required' => 'Masukan nomor telepon',
                    'min_length' => 'Isi nomor telepon minimal 10 angka',
                    'max_length' => 'Isi nomor telepon maksimal 13 angka',
                ]
            ],
            'address' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Silahkan pilih {field}',
                ]
            ],
            'university_id' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Silahkan pilih {field}',
                ]
            ],
            'faculty_id' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Silahkan pilih {field}',
                ]
            ],
            'major_id' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Silahkan masukan {field}',
                ]
            ],
            'photo' => [
                'rules' => 'uploaded[photo]|max_size[photo,2048]|mime_in[photo,image/jpg,image/jpeg,image/png]',
            ],
            'cv' => [
                'rules' => 'uploaded[cv]|max_size[cv,2048]|mime_in[cv,application/pdf]',
            ],
            'proposal' => [
                'rules' => 'uploaded[proposal]|max_size[proposal,2048]|mime_in[proposal,application/pdf]',
            ],
        ];
        $validation->setRules($rules);
        if (!$validation->withRequest($this->request)->run()) {
            return $this->fail($validation->getErrors());
        }

        $request = \Config\Services::request();

        $student = new StudentIdentityModel();

        // Upload File
        $user = $request->getVar('user_id');
        $cv = $request->getFile('cv');
        $namacv = $user . "_curiculum_vitae.pdf";
        $cv->move('cv', $namacv);

        $proposal = $request->getFile('proposal');
        $namaproposal = $user . "_proposal.pdf";
        $proposal->move('proposal', $namaproposal);

        $photo = $request->getFile('photo');
        $namaphoto = $user . "_photo.png";
        $photo->move('photo', $namaphoto);

        $data = [
            'user_id' => $request->getVar('user_id'),
            'university_id' => $request->getVar('university_id'),
            'faculty_id' => $request->getVar('faculty_id'),
            'major_id' => $request->getVar('major_id'),
            'gender' => $request->getVar('gender'),
            'birthplace' => $request->getVar('birthplace'),
            'birthdate' => $request->getVar('birthdate'),
            'number_phone' => $request->getVar('number_phone'),
            'address' => $request->getVar('address'),
            'photo' => $namaphoto,
            'curiculum_vitae' => $namacv,
            'proposal' => $namaproposal,
        ];
        $result = $student->save($data);
        if ($result) {
            return $this->respondCreated([
                'status' => 1,
                'message' => 'Data diri berhasil diisi'
            ]);
        } else {
            return $this->respondCreated([
                'status' => 0,
                'message' => 'Data diri gagal diisi'
            ]);
        }
    }

    /**
     * Return the editable properties of a resource object
     *
     * @return mixed
     */
    public function edit($id = null)
    {
        //
    }

    /**
     * Add or update a model resource, from "posted" properties
     *
     * @return mixed
     */
    public function update($id = null)
    {
        $validation = \Config\Services::validation();
        $rules = [
            'gender' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Silahkan pilih {field}',
                ]
            ],
            'birthplace' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Silahkan pilih {field}',
                ]
            ],
            'birthdate' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Silahkan pilih {field}',
                ]
            ],
            'number_phone' => [
                'rules' => 'required|min_length[10]|max_length[13]',
                'errors' => [
                    'required' => 'Silahkan masukan nomor telepon',
                    'min_length' => 'Isi nomor telepon minimal 10 angka',
                    'max_length' => 'Isi nomor telepon maksimal 13 angka',
                ]
            ],
            'address' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Silahkan pilih {field}',
                ]
            ],
            'university_id' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Silahkan pilih {field}',
                ]
            ],
            'faculty_id' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Silahkan pilih {field}',
                ]
            ],
            'major_id' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Silahkan masukan {field}',
                ]
            ],
            'photo' => [
                'rules' => 'uploaded[photo]|max_size[photo,2048]|mime_in[photo,image/jpg,image/jpeg,image/png]',
            ],
            'cv' => [
                'rules' => 'uploaded[cv]|max_size[cv,2048]|mime_in[cv,application/pdf]',
            ],
            'proposal' => [
                'rules' => 'uploaded[proposal]|max_size[proposal,2048]|mime_in[proposal,application/pdf]',
            ],
        ];
        $validation->setRules($rules);
        if (!$validation->withRequest($this->request)->run()) {
            return $this->fail($validation->getErrors());
        }

        $request = \Config\Services::request();

        $cv = $request->getFile('cv');
        $proposal = $request->getFile('proposal');
        $photo = $request->getFile('photo');

        // Upload File
        $user = $request->getVar('user_id');

        unlink("cv/" . $user . "_curiculum_vitae.pdf");
        unlink("proposal/" . $user . "_proposal.pdf");
        unlink("photo/" . $user . "_photo.png");

        $namacv = $user . "_curiculum_vitae.pdf";
        $cv->move('cv', $namacv);

        $namaproposal = $user . "_proposal.pdf";
        $proposal->move('proposal', $namaproposal);

        $namaphoto = $user . "_photo.png";
        $photo->move('photo', $namaphoto);

        $id = $request->getVar('id');

        $student = new StudentIdentityModel();
        $result = $student->update($id, [
            'university_id' => $request->getVar('university_id'),
            'faculty_id' => $request->getVar('faculty_id'),
            'major_id' => $request->getVar('major_id'),
            'gender' => $request->getVar('gender'),
            'birthplace' => $request->getVar('birthplace'),
            'birthdate' => $request->getVar('birthdate'),
            'number_phone' => $request->getVar('number_phone'),
            'address' => $request->getVar('address'),
            'photo' => $namaphoto,
            'curiculum_vitae' => $namacv,
            'proposal' => $namaproposal,
        ]);
        if ($result) {
            return $this->respondCreated([
                'status' => 2,
                'message' => 'Data diri berhasil diubah'
            ]);
        } else {
            return $this->respondCreated([
                'status' => 0,
                'message' => 'Data diri gagal diubah'
            ]);
        }
    }

    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function delete($id = null)
    {
        //
    }
}
