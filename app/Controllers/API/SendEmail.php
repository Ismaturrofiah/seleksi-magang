<?php

namespace App\Controllers\API;

use App\Models\InternSelectionModel;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

class SendEmail extends ResourceController
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

    public function reject_email_adm()
    {
        $seleksi = new InternSelectionModel();
        $request = \Config\Services::request();
        $id = $request->getVar('id');
        $data = $seleksi->rejectDataAdm($id);
        $email = \Config\Services::email();
        $email->setTo($data[0]['email']);
        $alamat_pengirim = "ismata2023@gmail.com";
        $email->setFrom($alamat_pengirim);
        $subject = "Pemberitahuan Pendaftaran Magang PT Pindad";
        $email->setSubject($subject);
        $pembuka = "Halo " . $data[0]['name'] . "<br/><br/>Terimakasih telah mendaftar magang pada : <br/>";
        $posisi = "<br/>Posisi : " . $data[0]['position'] . "<br/>";
        $divisi = "Divisi : " . $data[0]['division'] . "<br/>";
        $rec = "Pada periode pendaftaran : " . $data[0]['start_reqruitment'] . " sampai dengan " . $data[0]['close_reqruitment'] . "<br/>";
        $reason = "<br/>Mohon maaf, terkait pendaftaran yang anda lakukan, anda dinyatakan tidak lolos seleksi administrasi dengan alasan " . $data[0]['reason'] . "<br/>";
        $penutup = "<br/>Kami harap anda sukses dengan kegiatan lain kedepannya. Tetap Semangat!!!<br/><br/>Salam<br/><br/>Learning PT Pindad";
        $isi_pesan = $pembuka . $posisi . $divisi . $rec . $reason . $penutup;
        $email->setMessage($isi_pesan);
        if ($email->send()) {
            return $this->respondCreated([
                'status' => 1,
                'message' => 'Email pemberitahuan berhasil dikirim'
            ]);
        } else {
            $data_error = $email->printDebugger();
            return $this->respondCreated([
                'status' => 0,
                'message' => $data_error
            ]);
        }
    }

    public function accept_email_adm()
    {
        $seleksi = new InternSelectionModel();
        $request = \Config\Services::request();
        $id = $request->getVar('id');
        $data = $seleksi->accDataAdm($id);
        $email = \Config\Services::email();
        $email->setTo($data[0]['email']);
        $alamat_pengirim = "ismata2023@gmail.com";
        $email->setFrom($alamat_pengirim);
        $subject = "Pemberitahuan Pendaftaran Magang PT Pindad";
        $email->setSubject($subject);
        $pembuka = "Halo " . $data[0]['name'] . "<br/><br/>Terimakasih telah mendaftar magang pada : <br/>";
        $posisi = "<br/>Posisi : " . $data[0]['position'] . "<br/>";
        $divisi = "Divisi : " . $data[0]['division'] . "<br/>";
        $rec = "Pada periode pendaftaran : " . $data[0]['start_reqruitment'] . " sampai dengan " . $data[0]['close_reqruitment'] . "<br/>";
        $reason = "<br/>Selamat, terkait pendaftaran yang anda lakukan, anda dinyatakan lolos seleksi administrasi<br/><br/>";
        $info = "Selanjutnya, kami mengundang " . $data[0]['name'] . " untuk melakukan tes wawancara yang akan dilaksanakan secara " . $data[0]['type_int'] . " pada :<br/><br/>";
        $tanggal = "Tanggal : " . $data[0]['date_int'] . "<br/>";
        $waktu = "Waktu : " . $data[0]['time_int'] . "<br/>";
        if ($data[0]['type_int'] == "Offline") {
            $location = "Lokasi : " . $data[0]['location_int'] . "<br/>";
        } else {
            $location = "Link : <a href = " . $data[0]['location_int']  . ">" . $data[0]['location_int'] . "</a><br/>";
        }
        $penutup = "<br/>Demikian undangan wawancara ini kami sampaikan. Kami berharap saudara dapat hadir tepat waktu. Atas perhatiannya, kami ucapkan terimakasih.<br/><br/>Salam<br/><br/>Learning PT Pindad";
        $isi_pesan = $pembuka . $posisi . $divisi . $rec . $reason . $info . $tanggal . $waktu . $location . $penutup;
        $email->setMessage($isi_pesan);
        if ($email->send()) {
            return $this->respondCreated([
                'status' => 1,
                'message' => 'Email pemberitahuan berhasil dikirim'
            ]);
        } else {
            $data_error = $email->printDebugger();
            return $this->respondCreated([
                'status' => 0,
                'message' => $data_error
            ]);
        }
    }

    public function reject_email_int()
    {
        $seleksi = new InternSelectionModel();
        $request = \Config\Services::request();
        $id = $request->getVar('id');
        $data = $seleksi->rejectDataInt($id);
        $email = \Config\Services::email();
        $email->setTo($data[0]['email']);
        $alamat_pengirim = "ismata2023@gmail.com";
        $email->setFrom($alamat_pengirim);
        $subject = "Pemberitahuan Pendaftaran Magang PT Pindad";
        $email->setSubject($subject);
        $pembuka = "Halo " . $data[0]['name'] . "<br/><br/>Terimakasih telah mendaftar magang pada : <br/>";
        $posisi = "<br/>Posisi : " . $data[0]['position'] . "<br/>";
        $divisi = "Divisi : " . $data[0]['division'] . "<br/>";
        $rec = "Pada periode pendaftaran : " . $data[0]['start_reqruitment'] . " sampai dengan " . $data[0]['close_reqruitment'] . "<br/>";
        $reason = "<br/>Mohon maaf, terkait pendaftaran yang anda lakukan, anda dinyatakan tidak lolos seleksi wawancara dengan alasan " . $data[0]['reason'] . "<br/>";
        $penutup = "<br/>Kami harap anda sukses dengan kegiatan lain kedepannya. Tetap Semangat!!!<br/><br/>Salam<br/><br/>Learning PT Pindad";
        $isi_pesan = $pembuka . $posisi . $divisi . $rec . $reason . $penutup;
        $email->setMessage($isi_pesan);
        if ($email->send()) {
            return $this->respondCreated([
                'status' => 1,
                'message' => 'Email pemberitahuan berhasil dikirim'
            ]);
        } else {
            $data_error = $email->printDebugger();
            return $this->respondCreated([
                'status' => 0,
                'message' => $data_error
            ]);
        }
    }

    public function accept_email_int()
    {
        $seleksi = new InternSelectionModel();
        $request = \Config\Services::request();
        $id = $request->getVar('id');
        $data = $seleksi->accDataInt($id);
        $email = \Config\Services::email();
        $email->setTo($data[0]['email']);
        $alamat_pengirim = "ismata2023@gmail.com";
        $email->setFrom($alamat_pengirim);
        $subject = "Pemberitahuan Pendaftaran Magang PT Pindad";
        $email->setSubject($subject);
        $pembuka = "Halo " . $data[0]['name'] . "<br/><br/>Terimakasih telah mendaftar magang pada : <br/>";
        $posisi = "<br/>Posisi : " . $data[0]['position'] . "<br/>";
        $divisi = "Divisi : " . $data[0]['division'] . "<br/>";
        $rec = "Pada periode pendaftaran : " . $data[0]['start_reqruitment'] . " sampai dengan " . $data[0]['close_reqruitment'] . "<br/>";
        $reason = "<br/>Selamat, terkait pendaftaran yang anda lakukan, anda dinyatakan lolos seleksi wawancara dan berkesempatan untuk magang di PT Pindad.<br/>";
        $penutup = "<br/>Periode magang akan dilakukan mulai " . $data[0]['start_intern'] . " sampai dengan " . $data[0]['close_intern'] . "<br/>Selamat bergabung bersama kami.<br/><br/>Salam<br/><br/>Learning PT Pindad";
        $isi_pesan = $pembuka . $posisi . $divisi . $rec . $reason . $penutup;
        $email->setMessage($isi_pesan);
        if ($email->send()) {
            return $this->respondCreated([
                'status' => 1,
                'message' => 'Email pemberitahuan berhasil dikirim'
            ]);
        } else {
            $data_error = $email->printDebugger();
            return $this->respondCreated([
                'status' => 0,
                'message' => $data_error
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
