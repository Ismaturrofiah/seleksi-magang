<?php

namespace App\Controllers\API;

use App\Models\StudentIdentityModel;
use App\Models\InternPositionModel;
use App\Models\InternSelectionModel;
use App\Models\UsersModel;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

class LandingPage extends ResourceController
{
    // protected $modelName = 'App\Models\InternUniversityModel';
    protected $format = 'json';

    use ResponseTrait;
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        $position = new InternPositionModel();
        $data = [
            'message' => 'success',
            'data' => $position->PositionReady(),
        ];

        return $this->respond($data, 200);
    }

    public function detailposition($id = null)
    {
        $position = new InternPositionModel();
        $data = [
            'message' => 'success',
            'data' => $position->ShowDetailPosition($id),
        ];

        if ($data['data'] == null) {
            return $this->failNotFound('Data tidak ditemukan');
        }

        return $this->respond($data, 200);
    }

    public function cekIdentity()
    {
        $id = $this->request->getVar('id');
        $student = new StudentIdentityModel();
        $data = [
            'message' => 'success',
            'data' => $student->CekData($id),
        ];

        if ($data['data'] == null) {
            return $this->failNotFound('Data tidak ditemukan');
        }

        return $this->respond($data, 200);
    }

    public function applyposition()
    {
        $selection = new InternSelectionModel();
        $data = [
            'position_id' => $this->request->getVar('position_id'),
            'user_id' => $this->request->getVar('user_id'),
            'status' => $this->request->getVar('status'),
        ];
        $result = $selection->save($data);
        if ($result) {
            return $this->respondCreated([
                'status' => 1,
                'message' => 'Pendaftaran berhasil dilakukan'
            ]);
        } else {
            return $this->respondCreated([
                'status' => 0,
                'message' => 'Pendaftaran gagal dilakukan'
            ]);
        }
    }

    public function cekapply()
    {
        $id = $this->request->getVar('id');
        $selection = new InternSelectionModel();
        $data = [
            'message' => 'success',
            'data' => $selection->CekData($id),
        ];

        if ($data['data'] == null) {
            return $this->failNotFound('Data tidak ditemukan');
        }

        return $this->respond($data, 200);
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
        //
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
