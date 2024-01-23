<?php

namespace App\Controllers\API;

use App\Models\InternPositionModel;
use App\Models\UsersModel;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

class InternPosition extends ResourceController
{
    protected $modelName = 'App\Models\InternPositionModel';
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
        $npp = $this->request->getVar('npp');
        $data = [
            'message' => 'success',
            'data' => $position->DataPosition($npp),
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
        $position = new InternPositionModel();
        $data = [
            'message' => 'success',
            'data' => $position->ShowPosition($id),
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
            'position' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Silahkan pilih {field}',
                ]
            ],
            'detail' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Silahkan pilih {field}',
                ]
            ],
            'start_reqruitment' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Silahkan pilih {field}',
                ]
            ],
            'close_reqruitment' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Silahkan pilih {field}',
                ]
            ],
            'start_intern' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Silahkan pilih {field}',
                ]
            ],
            'close_intern' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Silahkan pilih {field}',
                ]
            ],
            'quota' => [
                'rules' => 'required|integer',
                'errors' => [
                    'required' => 'Silahkan masukan {field}',
                    'integer' => 'Masukkan {field} yang valid',
                ]
            ],
        ];
        $validation->setRules($rules);
        if (!$validation->withRequest($this->request)->run()) {
            return $this->fail($validation->getErrors());
        }

        $intern = new InternPositionModel();
        $users = new UsersModel();
        $npp = $this->request->getVar('npp');
        $div_id = $users->Session($npp);

        $data = [
            'division_id' => $div_id[0]['division_id'],
            'position' => $this->request->getVar('position'),
            'detail' => $this->request->getVar('detail'),
            'start_reqruitment' => $this->request->getVar('start_reqruitment'),
            'close_reqruitment' => $this->request->getVar('close_reqruitment'),
            'start_intern' => $this->request->getVar('start_intern'),
            'close_intern' => $this->request->getVar('close_intern'),
            'quota' => $this->request->getVar('quota'),
            'realization' => $this->request->getVar('realization'),
            'status' => $this->request->getVar('status'),
        ];
        $result = $intern->save($data);
        if ($result) {
            return $this->respondCreated([
                'status' => 1,
                'message' => 'Posisi magang berhasil dibuat'
            ]);
        } else {
            return $this->respondCreated([
                'status' => 0,
                'message' => 'Posisi magang gagal dibuat'
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
            'position' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Silahkan pilih {field}',
                ]
            ],
            'detail' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Silahkan pilih {field}',
                ]
            ],
            'start_reqruitment' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Silahkan pilih {field}',
                ]
            ],
            'close_reqruitment' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Silahkan pilih {field}',
                ]
            ],
            'start_intern' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Silahkan pilih {field}',
                ]
            ],
            'close_intern' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Silahkan pilih {field}',
                ]
            ],
            'quota' => [
                'rules' => 'required|integer',
                'errors' => [
                    'required' => 'Silahkan masukan {field}',
                    'integer' => 'Masukkan {field} yang valid',
                ]
            ],
        ];
        $validation->setRules($rules);
        if (!$validation->withRequest($this->request)->run()) {
            return $this->fail($validation->getErrors());
        }

        $quota = new InternPositionModel();
        $result = $quota->update($id, [
            'position' => $this->request->getVar('position'),
            'detail' => $this->request->getVar('detail'),
            'start_reqruitment' => $this->request->getVar('start_reqruitment'),
            'close_reqruitment' => $this->request->getVar('close_reqruitment'),
            'start_intern' => $this->request->getVar('start_intern'),
            'close_intern' => $this->request->getVar('close_intern'),
            'quota' => $this->request->getVar('quota'),
            'realization' => $this->request->getVar('realization'),
            'status' => $this->request->getVar('status'),
        ]);
        if ($result) {
            return $this->respondCreated([
                'status' => 2,
                'message' => 'Posisi magang berhasil diubah'
            ]);
        } else {
            return $this->respondCreated([
                'status' => 0,
                'message' => 'Posisi magang gagal diubah'
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
