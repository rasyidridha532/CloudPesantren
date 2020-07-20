<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class File extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('File_model');
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
        $config['total_rows'] = $this->File_model->total_rows($q);
        $file = $this->File_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $fotoprofil = $this->session->userdata('gambar');
        $nama = $this->session->userdata('nama');
        $role = $this->session->userdata('role');

        $data = array(
            'file_data' => $file,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'foto' => $fotoprofil,
            'nama' => $nama,
            'role' => $role,
            'title' => 'File'
        );
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar');
        $this->load->view('file/tbl_file_list', $data);
        $this->load->view('template/footer');
    }

    public function create()
    {
        $fotoprofil = $this->session->userdata('gambar');
        $nama = $this->session->userdata('nama');
        $role = $this->session->userdata('role');

        $data = array(
            'button' => 'Create',
            'action' => site_url('file/create_action'),
            'id_file' => set_value('id_file'),
            'judul' => set_value('judul'),
            'foto' => $fotoprofil,
            'nama' => $nama,
            'role' => $role,
            'title' => 'Upload File'
        );
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar');
        $this->load->view('file/tbl_file_form', $data);
        $this->load->view('template/footer');
    }

    public function update($id)
    {
        $fotoprofil = $this->session->userdata('gambar');
        $nama = $this->session->userdata('nama');
        $role = $this->session->userdata('role');

        $row = $this->File_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'foto' => $fotoprofil,
                'nama' => $nama,
                'role' => $role,
                'action' => site_url('file/update_action' . $row->id_file),
                'id_file' => set_value('id_file', $row->id_file),
                'judul' => set_value('judul', $row->judul),
            );
            $this->load->view('file/tbl_file_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('file'));
        }
    }

    public function create_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $file_spec = $this->_upload_file();
            $nama_file = $file_spec['namafile'];
            $size = $file_spec['size'];
            $data = array(
                'judul' => $this->input->post('judul', TRUE),
                'nama_file' => $nama_file,
                'size' => $size
            );

            $this->File_model->insert($data);
            $this->session->set_flashdata('message', '<div class="alert alert-success">File berhasil diupload!</div>');
            redirect(site_url('file'));
        }
    }

    public function update_action($id)
    {
        $this->_rules();

        $row = $this->File_model->get_by_id($id);
        $old_file = $row->nama_file;

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_file', TRUE));
        } else {
            $filename = $this->_upload_file();
            $nama_file = $filename['namafile'];
            $size = $filename['size'];

            $data = array(
                'judul' => $this->input->post('judul', TRUE),
                'nama_file' => $nama_file,
                'size' => $size
            );

            unlink('./uploads/file/opop/' . $old_file);
            $this->File_model->update($this->input->post('id_file', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('file'));
        }
    }

    public function delete($id)
    {
        $row = $this->File_model->get_by_id($id);

        if ($row) {
            $this->File_model->delete($id);
            $this->session->set_flashdata('message', '<div class="alert alert-success">File Berhasil Dihapus!</div>');
            redirect(site_url('file'));
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-failed">Data Tidak Ditemukan!</div>');
            redirect(site_url('file'));
        }
    }

    private function _upload_file()
    {
        $uploadFile = [];

        $config['upload_path'] = './uploads/file/';
        $config['allowed_types'] = 'pdf|doc|docx|xls|xlsx|ppt|pptx';
        $config['max_size'] = 0;
        $config['file_name'] = 'Pesantren-' . date('dmy') . '-' . substr(md5(rand()), 0, 10);

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('file')) {
            $this->session->set_flashdata('message', '<div class="alert alert-failed">File tidak support!</div>');
            redirect(site_url('file/create'));
        } else {
            $fileData = $this->upload->data();
            $uploadFile['namafile'] = $fileData['file_name'];
            $uploadFile['size'] = $fileData['file_size'];
        }

        if (!empty($uploadFile)) {
            return $uploadFile;
        }
    }

    public function _rules()
    {
        $this->form_validation->set_rules('judul', 'judul', 'trim|required' . [
            'required' => 'Nama File Harus Diisi!'
        ]);

        $this->form_validation->set_rules('id_file', 'id_file', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }
}
