<?php

namespace App\Controllers\API;

use App\Models\UsersModel;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use \Firebase\JWT\JWT;
use \Firebase\JWT\KEY;

class Users extends ResourceController
{
    protected $modelName = 'App\Models\UsersModel';
    protected $format = 'json';

    use ResponseTrait;

    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        $users = new UsersModel();
        $data = [
            'message' => 'success',
            'data' => $users->getData()
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
        $users = new UsersModel();
        $data = [
            'message' => 'success',
            'data' => $users->ShowData($id),
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
            'email' => [
                'rules' => 'required|valid_email|is_unique[users.email,id,{id}]',
                'errors' => [
                    'required' => 'Silahkan masukan {field}',
                    'valid_email' => 'Silahkan masukan {field} yang valid',
                    'is_unique' => '{field} sudah terdaftar'
                ]
            ],
            'nama' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Silahkan masukan {field}',
                ]
            ],
            'password' => [
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
        $users = new UsersModel();

        $getnpp = $this->request->getVar('npp');

        if ($this->request->getVar('npp') == "") {
            $getnpp = random_int(100000, 999999);
        }

        $data = [
            'npp' => $getnpp,
            'name' => $this->request->getVar('nama'),
            'email' => $this->request->getVar('email'),
            'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
            'role' => $this->request->getVar('role'),
            'status' => $this->request->getVar('status'),
        ];

        // Jika Email sudah terdaftar
        $is_email = $users->where('email', $this->request->getVar('email'))->first();
        if ($is_email) {
            return $this->respondCreated([
                'status' => 0,
                'message' => 'Email telah terdaftarkan'
            ]);
        } else {
            // Jika NPP sudah terdaftar
            $is_npp = $users->where('npp', $this->request->getVar('npp'))->first();

            if ($is_npp) {
                return $this->respondCreated([
                    'status' => 0,
                    'message' => 'NPP telah terdaftarkan'
                ]);
            } else {
                $result = $users->save($data);
                if ($result) {
                    return $this->respondCreated([
                        'status' => 1,
                        'message' => 'User berhasil dibuat'
                    ]);
                } else {
                    return $this->respondCreated([
                        'status' => 0,
                        'message' => 'User gagal dibuat'
                    ]);
                }
            }
        }
    }

    public function login()
    {
        $validation = \Config\Services::validation();
        $rules = [
            'npp' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Silahkan masukan {field}',
                ]
            ],
            'password' => [
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
        $users = new UsersModel();
        $npp = $this->request->getVar('npp');
        $password = $this->request->getVar('password');
        $is_npp = $users->getNPP($npp);

        if ($is_npp) {
            $verify_password = password_verify($password, $is_npp['password']);
            // dd($verify_password);
            if ($verify_password || $is_npp['password'] == $password) {
                $key = getenv('JWT_SECRET_KEY');
                $RequestToken = time();
                $ExpiredToken = $RequestToken + 21600;
                $payload = [
                    'npp' => $npp,
                    'iat' => $RequestToken,
                    'exp' => $ExpiredToken,
                ];
                $jwt = JWT::encode($payload, $key, 'HS256');
                return $this->respond([
                    'status' => 200,
                    'message' => 'User berhasil login',
                    'data' => [
                        'id' => $is_npp['id'],
                        'nama' => $is_npp['name'],
                        'email' => $is_npp['email'],
                        'npp' => $is_npp['npp'],
                        'role' => $is_npp['role']
                    ],
                    'access_token' => $jwt
                ]);
            } else {
                return $this->respondCreated([
                    'status' => 0,
                    'message' => 'Password salah'
                ]);
            }
        } else {
            return $this->respondCreated([
                'status' => 0,
                'message' => 'NPP atau Email tidak ditemukan'
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
        $users = new UsersModel();
        $result = $users->update($id, [
            'npp' => $this->request->getVar('npp'),
            'name' => $this->request->getVar('nama'),
            'email' => $this->request->getVar('email'),
            'role' => $this->request->getVar('role'),
            'status' => $this->request->getVar('status'),
        ]);
        if ($result) {
            return $this->respondCreated([
                'status' => 2,
                'message' => 'Data pengguna berhasil diubah'
            ]);
        } else {
            return $this->respondCreated([
                'status' => 0,
                'message' => 'Data pengguna gagal diubah'
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
