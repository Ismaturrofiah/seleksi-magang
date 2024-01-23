<?php

namespace App\Controllers\API;

use App\Models\SettingDisplayModel;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

class SettingDisplay extends ResourceController
{
    protected $modelName = 'App\Models\SettingDisplayModel';
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
        $setting = new SettingDisplayModel();
        $data = [
            'message' => 'success',
            'data' => $setting->showData($id),
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
        $validation = \Config\Services::validation();
        $rules = [
            'image' => [
                'rules' => 'uploaded[image]|max_size[image,2048]|mime_in[image,image/jpg,image/jpeg,image/png]',
            ],
            'caption' => [
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

        $setting = new SettingDisplayModel();

        $id = $request->getVar('id');

        // Upload File
        $image = $request->getFile('image');

        unlink("assets/img/dashboard.png");

        $namaimage = "dashboard.png";
        $image->move('assets/img', $namaimage);

        $caption = $request->getVar('caption');

        $result = $setting->update($id, [
            'caption' => $caption,
        ]);
        if ($result) {
            return $this->respondCreated([
                'status' => 2,
                'message' => 'Tampilan berubah'
            ]);
        } else {
            return $this->respondCreated([
                'status' => 0,
                'message' => 'Tampilan gagal berubah'
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
