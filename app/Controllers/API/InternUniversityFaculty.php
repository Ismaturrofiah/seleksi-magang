<?php

namespace App\Controllers\API;

use App\Models\InternUniversityFacultyModel;
use CodeIgniter\API\ResponseTrait;

use CodeIgniter\RESTful\ResourceController;

class InternUniversityFaculty extends ResourceController
{
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
        //
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
            'university_id' => [
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

        $faculty = new InternUniversityFacultyModel();
        $data = [
            'name' => $this->request->getVar('name'),
            'university_id' => $this->request->getVar('university_id'),
        ];
        $result = $faculty->save($data);
        if ($result) {
            return $this->respondCreated([
                'status' => 1,
                'message' => 'Data fakultas berhasil dibuat'
            ]);
        } else {
            return $this->respondCreated([
                'status' => 0,
                'message' => 'Data fakultas gagal dibuat'
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
        //
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
