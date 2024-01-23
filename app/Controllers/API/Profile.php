<?php

namespace App\Controllers\API;

use App\Models\UsersModel;
use App\Models\StudentIdentityModel;
use App\Models\InternUniversityFacultyModel;
use App\Models\InternUniversityMajorModel;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

class Profile extends ResourceController
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

    public function getuser()
    {
        $id = $this->request->getVar('id');
        $user = new UsersModel();
        $data = [
            'message' => 'success',
            'data' => $user->getUser($id),
        ];

        if ($data['data'] == null) {
            return $this->failNotFound('Data tidak ditemukan');
        }

        return $this->respond($data, 200);
    }

    public function getidentity()
    {
        $id = $this->request->getVar('id');
        $user = new StudentIdentityModel();
        $data = [
            'message' => 'success',
            'data' => $user->showData($id),
        ];

        if ($data['data'] == null) {
            return $this->failNotFound('Data tidak ditemukan');
        }

        return $this->respond($data, 200);
    }

    public function getFaculty()
    {
        $univ_id = $this->request->getVar('univ');
        $faculty = new InternUniversityFacultyModel();
        $data = [
            'message' => 'success',
            'data' => $faculty->getFaculty($univ_id),
        ];
        return $this->respond($data, 200);
    }

    public function getMajor()
    {
        $fac_id = $this->request->getVar('fac');
        $major = new InternUniversityMajorModel();
        $data = [
            'message' => 'success',
            'data' => $major->getMajor($fac_id),
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
