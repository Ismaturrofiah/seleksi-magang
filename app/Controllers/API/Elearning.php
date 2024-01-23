<?php

namespace App\Controllers\API;

use App\Models\PrakerinQuotaModel;
use App\Models\InternPositionModel;
use App\Models\InternStudentModel;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

class Elearning extends ResourceController
{
    protected $modelName = 'App\Models\PrakerinQuotaModel';
    protected $format = 'json';

    use ResponseTrait;

    public function quota()
    {
        $year = $this->request->getVar('year');
        $position = new InternPositionModel();
        $data = [
            'message' => 'success',
            'quota' => $position->quota($year),
        ];

        return $this->respond($data, 200);
    }

    public function instansi()
    {
        $year = $this->request->getVar('year');
        $university = new InternStudentModel();
        $data = [
            'message' => 'success',
            'instansi' => $university->getPersebaranInstansi($year),
        ];

        return $this->respond($data, 200);
    }

    public function divisi()
    {
        $year = $this->request->getVar('year');
        $university = new InternStudentModel();
        $data = [
            'message' => 'success',
            'divisi' => $university->getPersebaranDivisi($year),
        ];

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
