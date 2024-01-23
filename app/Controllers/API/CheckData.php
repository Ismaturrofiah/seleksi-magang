<?php

namespace App\Controllers\API;

use App\Models\InternStudentModel;
use App\Models\InternKuotaModel;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

class CheckData extends ResourceController
{
    protected $format = 'json';

    use ResponseTrait;

    public function checkintern()
    {
        $name = $this->request->getVar('name');
        $univ = $this->request->getVar('univ');
        $major = $this->request->getVar('major');
        $division = $this->request->getVar('division');
        $year = $this->request->getVar('year');

        $student = new InternStudentModel();

        $data = [
            'message' => 'success',
            'data' => $student->CheckList($name, $univ, $major, $division, $year),
        ];

        if ($data['data'] == null) {
            return $this->failNotFound('Data tidak ditemukan');
        }

        return $this->respond($data, 200);
    }

    public function checkquota()
    {
        $id = $this->request->getVar('id');

        $quota = new InternKuotaModel();
        $data = [
            'message' => 'success',
            'data' => $quota->editQuota($id),
        ];

        if ($data['data'] == null) {
            return $this->failNotFound('Data tidak ditemukan');
        }

        return $this->respond($data, 200);
    }

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
