<?php

namespace App\Controllers\API;

use App\Models\InternSelectionModel;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

class InternSelection extends ResourceController
{
    protected $modelName = 'App\Models\InternSelectionModel';
    protected $format = 'json';

    use ResponseTrait;
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        $request = \Config\Services::request();
        $npp = $request->getVar('npp');
        $selection = new InternSelectionModel();
        $data = [
            'message' => 'success',
            'data' => $selection->getDataAdministrative($npp),
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
        $selection = new InternSelectionModel();
        $data = [
            'message' => 'success',
            'data' => $selection->showData($id),
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
        $request = \Config\Services::request();
        $selection = new InternSelectionModel();

        $result = $selection->update($id, [
            'status' => $request->getVar('status'),
        ]);
        if ($result) {
            return $this->respondCreated([
                'status' => 2,
                'message' => 'Status seleksi berubah'
            ]);
        } else {
            return $this->respondCreated([
                'status' => 0,
                'message' => 'Status seleksi berubah'
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
