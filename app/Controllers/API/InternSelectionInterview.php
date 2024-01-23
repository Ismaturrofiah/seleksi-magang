<?php

namespace App\Controllers\API;

use App\Models\InternSelectionTechnicalModel;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

class InternSelectionInterview extends ResourceController
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
            'date_int' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Silahkan masukan {field}',
                ]
            ],
            'time_int' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Silahkan masukan {field}',
                ]
            ],
            'location_int' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Silahkan masukan {field}',
                ]
            ],
            'type_int' => [
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

        $int = new InternSelectionTechnicalModel();

        $data = [
            'selection_id' => $request->getVar('selection_id'),
            'date_int' => $request->getVar('date_int'),
            'time_int' => $request->getVar('time_int'),
            'location_int' => $request->getVar('location_int'),
            'type_int' => $request->getVar('type_int'),
        ];
        $result = $int->save($data);
        if ($result) {
            return $this->respondCreated([
                'status' => 1,
                'message' => 'Jadwal Wawancara berhasil diisi'
            ]);
        } else {
            return $this->respondCreated([
                'status' => 0,
                'message' => 'Jadwal Wawancara gagal diisi'
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
