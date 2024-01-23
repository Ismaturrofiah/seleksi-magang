<?php

namespace App\Controllers\API;

use App\Models\InternActivityModel;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

class InternActivity extends ResourceController
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
            'activity' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Silahkan isi {field}',
                ]
            ],
            'date' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Silahkan pilih {field}',
                ]
            ],
        ];
        $validation->setRules($rules);
        if (!$validation->withRequest($this->request)->run()) {
            return $this->fail($validation->getErrors());
        }

        $logbook = new InternActivityModel();
        $data = [
            'activity' => $this->request->getVar('activity'),
            'date' => $this->request->getVar('date'),
        ];
        $result = $logbook->save($data);
        if ($result) {
            return $this->respondCreated([
                'status' => 1,
                'message' => 'Daily activity berhasil dibuat'
            ]);
        } else {
            return $this->respondCreated([
                'status' => 0,
                'message' => 'Daily activity gagal dibuat'
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
