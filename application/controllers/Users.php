<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Users extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Users_model');
        $this->load->library('form_validation');

        $status = $this->session->userdata('status');
        if (isset($status) != "login") {
            redirect(base_url("auth"));
        }
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Users_model->total_rows($q);
        $users = $this->Users_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $fotoprofil = $this->session->userdata('gambar');
        $nama = $this->session->userdata('nama');
        $role = $this->session->userdata('role');

        $data = array(
            'users_data' => $users,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'foto' => $fotoprofil,
            'nama' => $nama,
            'role' => $role,
            'title' => 'User'
        );
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar');
        $this->load->view('users/tbl_users_list', $data);
        $this->load->view('template/footer');
    }

    public function update($id)
    {
        $fotoprofil = $this->session->userdata('gambar');
        $nama_session = $this->session->userdata('nama');
        $role_session = $this->session->userdata('role');

        $row = $this->Users_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'foto' => $fotoprofil,
                'nama' => $nama_session,
                'role' => $role_session,
                'action' => site_url('users/update_action'),
                'id' => set_value('id', $row->id),
                'nama' => set_value('nama', $row->nama),
                'title' => 'Ubah User',
                'email' => set_value('email', $row->email),
                'role' => set_value('role', $row->role)
            );
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar');
            $this->load->view('users/tbl_users_form', $data);
            $this->load->view('template/footer');
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('users'));
        }
    }

    public function update_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            // $fotoprofil = $this->_upload_foto();
            // $namagambar = $fotoprofil['nama_gambar'];

            $data = array(
                'nama' => $this->input->post('nama', TRUE),
                'email' => $this->input->post('email', TRUE),
                'password' => sha1($this->input->post('password1')),
                // 'gambar' => $namagambar,
                'role' => $this->input->post('role', TRUE),
            );

            $this->Users_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('users'));
        }
    }

    public function delete($id)
    {
        $row = $this->Users_model->get_by_id($id);

        if ($row) {
            $this->Users_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('users'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('users'));
        }
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
            redirect('users/up');
        } else {
            $fileData = $this->upload->data();
            $uploadfoto['nama_gambar'] = $fileData['file_name'];
        }

        if (!empty($uploadfoto)) {
            return $uploadfoto;
        }
    }

    public function _rules()
    {
        $this->form_validation->set_rules('nama', 'nama', 'trim|required', [
            'required' => 'Nama Lengkap Harus Diisi!'
        ]);
        $this->form_validation->set_rules('email', 'email', 'required|trim|valid_email', [
            'required' => 'Email Harus Diisi!',
            'valid_email' => 'Alamat Email Harus Valid!'
        ]);
        $this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[8]', [
            'required' => 'Password Harus diisi!',
            'min_length' => 'Password terlalu pendek!'
        ]);
        $this->form_validation->set_rules('password2', 'Password', 'required|trim|matches[password1]', [
            'required' => 'Password Harus diisi!',
            'matches' => 'Password tidak sama!'
        ]);

        $this->form_validation->set_rules('role', 'role', 'trim|required', [
            'required' => 'Pilih Role Terlebih Dahulu'
        ]);

        $this->form_validation->set_rules('id', 'id', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }
}
