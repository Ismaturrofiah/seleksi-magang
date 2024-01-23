<?php

namespace App\Controllers\API;

use App\Models\InternSelectionAdministrativeModel;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

class InternSelectionAdministrative extends ResourceController
{
    // protected $modelName = 'App\Models\StudentIdentityModel';
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
        $adm = new InternSelectionAdministrativeModel();
        $data = [
            'message' => 'success',
            'data' => $adm->showData($id),
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
            'reason' => [
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

        $adm = new InternSelectionAdministrativeModel();

        $data = [
            'selection_id' => $request->getVar('selection_id'),
            'reason' => $request->getVar('reason'),
        ];
        $result = $adm->save($data);
        if ($result) {
            return $this->respondCreated([
                'status' => 1,
                'message' => 'Alasan Penolakan berhasil diisi'
            ]);
        } else {
            return $this->respondCreated([
                'status' => 0,
                'message' => 'Alasan Penolakan gagal diisi'
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
            'reason' => [
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

        $adm = new InternSelectionAdministrativeModel();

        $result = $adm->update($id, [
            'reason' => $request->getVar('reason'),
        ]);
        if ($result) {
            return $this->respondCreated([
                'status' => 2,
                'message' => 'Alasan Penolakan berubah'
            ]);
        } else {
            return $this->respondCreated([
                'status' => 0,
                'message' => 'Alasan Penolakan gagal berubah'
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
