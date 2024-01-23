<?php

namespace App\Controllers\API;

use App\Models\InternUniversityModel;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

class InternUniversity extends ResourceController
{
    protected $modelName = 'App\Models\InternUniversityModel';
    protected $format = 'json';

    use ResponseTrait;
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        $university = new InternUniversityModel();
        $data = [
            'message' => 'success',
            'data' => $university->DataInternUniversity(),
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
        $university = new InternUniversityModel();
        $data = [
            'message' => 'success',
            'data' => $university->ShowInternUniversity($id),
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
            'name' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Silahkan masukkan nama universitas',
                ]
            ],
        ];
        $validation->setRules($rules);
        if (!$validation->withRequest($this->request)->run()) {
            return $this->fail($validation->getErrors());
        }

        $university = new InternUniversityModel();
        $data = [
            'name' => $this->request->getVar('name'),
            'region_id' => $this->request->getVar('region_id'),
            'status' => 'active',
        ];
        $result = $university->save($data);
        if ($result) {
            return $this->respondCreated([
                'status' => 1,
                'message' => 'Data universitas berhasil dibuat'
            ]);
        } else {
            return $this->respondCreated([
                'status' => 0,
                'message' => 'Data universitas gagal dibuat'
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
            'name' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Silahkan masukkan nama universitas',
                ]
            ],
            'year' => [
                'rules' => 'required|integer|min_length[4]|max_length[4]',
                'errors' => [
                    'required' => 'Silahkan masukan tahun',
                    'integer' => 'Silahkan masukan angka',
                    'min_length' => 'Silahkan masukan 4 angka',
                    'max_length' => 'Silahkan masukan 4 angka'
                ]
            ],
        ];
        $validation->setRules($rules);
        if (!$validation->withRequest($this->request)->run()) {
            return $this->fail($validation->getErrors());
        }

        $university = new InternUniversityModel();

        $result = $university->update($id, [
            'name' => $this->request->getVar('name'),
            'region_id' => $this->request->getVar('region_id'),
            'year' => $this->request->getVar('year'),
        ]);
        if ($result) {
            return $this->respondCreated([
                'status' => 2,
                'message' => 'Data universitas berhasil diubah'
            ]);
        } else {
            return $this->respondCreated([
                'status' => 0,
                'message' => 'Data universitas gagal diubah'
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
