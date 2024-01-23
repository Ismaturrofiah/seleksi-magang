<?php

namespace App\Controllers\API;

use App\Models\InternUniversityMajorModel;
use CodeIgniter\API\ResponseTrait;

use CodeIgniter\RESTful\ResourceController;

class InternUniversityMajor extends ResourceController
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
                    'required' => 'Silahkan masukkan {field}',
                ]
            ],
            'faculty_id' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Silahkan masukkan {field}',
                ]
            ],
        ];
        $validation->setRules($rules);
        if (!$validation->withRequest($this->request)->run()) {
            return $this->fail($validation->getErrors());
        }

        $faculty = new InternUniversityMajorModel();
        $data = [
            'name' => $this->request->getVar('name'),
            'faculty_id' => $this->request->getVar('faculty_id'),
        ];
        $result = $faculty->save($data);
        if ($result) {
            return $this->respondCreated([
                'status' => 1,
                'message' => 'Data program studi berhasil dibuat'
            ]);
        } else {
            return $this->respondCreated([
                'status' => 0,
                'message' => 'Data program studi gagal dibuat'
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
