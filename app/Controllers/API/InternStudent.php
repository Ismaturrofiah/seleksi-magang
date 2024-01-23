<?php

namespace App\Controllers\API;

use App\Models\InternStudentModel;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

class InternStudent extends ResourceController
{
    protected $modelName = 'App\Models\InternStudentModel';
    protected $format = 'json';

    use ResponseTrait;
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        $npp = $this->request->getVar('npp');
        $student = new InternStudentModel();
        $data = [
            'message' => 'success',
            'alldata' => $student->DataStudent(),
            'data' => $student->DataStudentDivision($npp),
        ];

        return $this->respond($data, 200);
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($id = null)
    {
        $intern = new InternStudentModel();
        $data = [
            'message' => 'success',
            'data' => $intern->ShowStudent($id),
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
            'position_id' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Silahkan pilih {field}',
                ]
            ],
            'mentor_id' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Silahkan pilih pembimbing',
                ]
            ],
        ];
        $validation->setRules($rules);
        if (!$validation->withRequest($this->request)->run()) {
            return $this->fail($validation->getErrors());
        }

        $intern = new InternStudentModel();
        $data = [
            'user_id' => $this->request->getVar('user_id'),
            'position_id' => $this->request->getVar('position_id'),
            'mentor_id' => $this->request->getVar('mentor_id'),
            'status' => $this->request->getVar('status'),
        ];
        $result = $intern->save($data);
        if ($result) {
            return $this->respondCreated([
                'status' => 1,
                'message' => 'Mahasiswa magang berhasil dibuat'
            ]);
        } else {
            return $this->respondCreated([
                'status' => 0,
                'message' => 'Mahasiswa magang gagal dibuat'
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
            'mentor_id' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Silahkan pilih pembimbing',
                ]
            ],
            'status' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Silahkan pilih status mahasiswa magang',
                ]
            ],
        ];
        $validation->setRules($rules);
        if (!$validation->withRequest($this->request)->run()) {
            return $this->fail($validation->getErrors());
        }

        $intern = new InternStudentModel();
        $result = $intern->update($id, [
            'mentor_id' => $this->request->getVar('mentor_id'),
            'status' => $this->request->getVar('status'),
        ]);
        if ($result) {
            return $this->respondCreated([
                'status' => 2,
                'message' => 'Mahasiswa magang berhasil diubah'
            ]);
        } else {
            return $this->respondCreated([
                'status' => 0,
                'message' => 'Mahasiswa magang gagal diubah'
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
        $this->model->delete($id);

        $response = [
            'message' => 'Data berhasil dihapus'
        ];

        return $this->respondDeleted($response);
    }
}
