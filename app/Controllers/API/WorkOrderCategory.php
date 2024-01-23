<?php

namespace App\Controllers\API;

use App\Models\WorkOrderCategoryModel;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

class WorkOrderCategory extends ResourceController
{
    protected $modelName = 'App\Models\WorkOrderCategoryModel';
    protected $format = 'json';

    use ResponseTrait;
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        $data = [
            'message' => 'success',
            'data' => $this->model->findAll()
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
        $categories = new WorkOrderCategoryModel();
        $data = [
            'name' => $this->request->getVar('name'),
            'code' => $this->request->getVar('code'),
            'year' => $this->request->getVar('year'),
        ];
        $result = $categories->save($data);
        if ($result) {
            return $this->respondCreated([
                'status' => 1,
                'message' => 'Kategori work order berhasil dibuat'
            ]);
        } else {
            return $this->respondCreated([
                'status' => 0,
                'message' => 'Kategori work order gagal dibuat'
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
