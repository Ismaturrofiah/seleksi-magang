<?php

namespace App\Controllers\API;

use App\Models\InternSelectionModel;
use App\Models\InternPositionModel;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

class InternSelectionTechnical extends ResourceController
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
        $npp = $this->request->getVar('npp');
        $selection = new InternSelectionModel();
        $data = [
            'message' => 'success',
            'data' => $selection->getDataTechnical($npp),
        ];

        return $this->respond($data, 200);
    }

    public function addRealization($id)
    {
        $position = new InternPositionModel();

        $result = $position->update($id, [
            'realization' => $this->request->getVar('realization'),
        ]);
        if ($result) {
            return $this->respondCreated([
                'status' => 2,
                'message' => 'Realisasi posisi magang bertambah'
            ]);
        } else {
            return $this->respondCreated([
                'status' => 0,
                'message' => 'Realisasi posisi magang tetap'
            ]);
        }
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
