<?php

class Auth extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->library(array('form_validation', 'Recaptcha'));
        $this->load->model('Users_model');
    }

    public function index()
    {
        $data = array(
            'action' => site_url('auth/login'),
            'captcha' => $this->recaptcha->getWidget(),
            'script_captcha' => $this->recaptcha->getScriptTag()
        );

        $this->load->view('login', $data);
    }

    public function login()
    {
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email', [
            'required' => 'Email Harus Diisi!',
            'valid_email' => 'Alamat Email Harus Valid!'
        ]);
        $this->form_validation->set_rules('password', 'Password', 'required', [
            'required' => 'Password Harus diisi!',
        ]);

        $recaptcha = $this->input->post('g-recaptcha-response');
        $response = $this->recaptcha->verifyResponse($recaptcha);

        if ($this->form_validation->run() == false || !isset($response['success']) || $response['success'] <> true) {
            $this->index();
        } else {
            $email = $this->input->post('email');
            $password = $this->input->post('password');

            $recaptcha = $this->input->post('g-recaptcha-response');
            $response = $this->recaptcha->verifyResponse($recaptcha);

            $where = array(
                'email' => $email,
                'password' => sha1($password)
            );

            $cek = $this->Users_model->cekLogin($where)->row_array();

            if (!$where['email'] == $cek['email'] && !$where['password'] == $cek['password']) {
                $this->session->set_flashdata('messagelogin', '<div class="alert alert-warning">Email atau password salah!</div>');
                redirect(site_url('auth/login'));
            } else {
                $nama = $cek['nama'];
                $gambar = $cek['gambar'];
                if ($cek['role'] == 'admin') {
                    $role = 'Admin';
                } else {
                    $role = 'Pengelola';
                }

                if (isset($cek)) {
                    $data_session = array(
                        'role' => $role,
                        'status' => 'login',
                        'gambar' => $gambar,
                        'nama' => $nama
                    );
                    $this->session->set_userdata($data_session);
                    redirect(base_url(""));
                }
            }
        }
    }

    public function register()
    {
        $this->load->view('register');
    }

    public function proses_register()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->register();
        } else {
            $fotoprofil = $this->_upload_foto();
            $namagambar = $fotoprofil['nama_gambar'];

            $data = array(
                'nama' => htmlspecialchars($this->input->post('namalengkap', true)),
                'email' => $this->input->post('email', true),
                'password' => sha1($this->input->post('password1')),
                'gambar' => $namagambar,
                'role' => $this->input->post('role')
            );

            $this->Users_model->insert($data);
            $this->session->set_flashdata('message', '<div class="alert alert-success">Selamat! Akun anda sudah dibuat. Silahkan Login!</div>');
            redirect('auth');
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        $this->session->set_flashdata('message', '<div class="alert alert-success">Anda sudah log out!</div>');
        redirect('auth');
    }

    private function _upload_foto()
    {
        $uploadfoto = [];

        $config['upload_path'] = './uploads/fotoprofil/';
        $config['allowed_types'] = 'jpg|png|jpeg';
        $config['max_size'] = 0;
        $config['max_height'] = 600;
        $config['max_width'] = 600;
        $config['file_name'] = 'Pesantren-' . date('dmy') . '-' . substr(md5(rand()), 0, 10);

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('gambar')) {
            $this->session->set_flashdata('message', $this->upload->display_errors());
            redirect('auth/register');
        } else {
            $fileData = $this->upload->data();
            $uploadfoto['nama_gambar'] = $fileData['file_name'];
        }

        if (!empty($uploadfoto)) {
            return $uploadfoto;
        }
    }

    private function _rules()
    {
        $this->form_validation->set_rules('namalengkap', 'Nama Lengkap', 'required|trim', [
            'required' => 'Nama Lengkap Harus Diisi!'
        ]);
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[tbl_users.email]', [
            'required' => 'Email Harus Diisi!',
            'valid_email' => 'Alamat Email Harus Valid!',
            'is_unique' => 'Alamat Email sudah terdaftar!'
        ]);
        $this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[8]', [
            'required' => 'Password Harus diisi!',
            'min_length' => 'Password terlalu pendek!'
        ]);
        $this->form_validation->set_rules('password2', 'Password', 'required|trim|matches[password1]', [
            'matches' => 'Password tidak sama!'
        ]);
    }
}
