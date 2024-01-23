<?php

namespace App\Controllers\API;

use App\Models\InternScheduleModel;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

class InternSchedule extends ResourceController
{
    protected $modelName = 'App\Models\InternScheduleModel';
    protected $format = 'json';
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        $data = [
            'message' => 'success',
            'data' => $this->model->findAll(),
            'display' => $this->model->where('status', 'active')->findAll(),
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
        $data = [
            'message' => 'success',
            'data' => $this->model->where('id', $id)->findAll(),
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
                    'required' => 'Silahkan masukan {field}',
                ]
            ],
            'startdate' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Silahkan masukan {field}',
                ]
            ],
        ];
        $validation->setRules($rules);
        if (!$validation->withRequest($this->request)->run()) {
            return $this->fail($validation->getErrors());
        }

        $request = \Config\Services::request();

        $schedule = new InternScheduleModel();

        $data = [
            'name' => $request->getVar('name'),
            'startdate' => $request->getVar('startdate'),
            'closedate' => $request->getVar('closedate'),
            'status' => $request->getVar('status')
        ];

        $result = $schedule->save($data);
        if ($result) {
            return $this->respondCreated([
                'status' => 1,
                'message' => 'Jadwal Seleksi berhasil dibuat'
            ]);
        } else {
            return $this->respondCreated([
                'status' => 0,
                'message' => 'Jadwal Seleksi gagal dibuat'
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
                    'required' => 'Silahkan masukan {field}',
                ]
            ],
            'startdate' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Silahkan masukan {field}',
                ]
            ],
        ];
        $validation->setRules($rules);
        if (!$validation->withRequest($this->request)->run()) {
            return $this->fail($validation->getErrors());
        }

        $request = \Config\Services::request();

        $schedule = new InternScheduleModel();

        $result = $schedule->update($id, [
            'name' => $request->getVar('name'),
            'startdate' => $request->getVar('startdate'),
            'closedate' => $request->getVar('closedate'),
            'status' => $request->getVar('status')
        ]);

        if ($result) {
            return $this->respondCreated([
                'status' => 2,
                'message' => 'Jadwal seleksi berubah'
            ]);
        } else {
            return $this->respondCreated([
                'status' => 0,
                'message' => 'Jadwal seleksi gagal berubah'
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
