<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Produk extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Produk_model');
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
        $config['total_rows'] = $this->Produk_model->total_rows($q);
        $produk = $this->Produk_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $fotoprofil = $this->session->userdata('gambar');
        $nama = $this->session->userdata('nama');
        $role = $this->session->userdata('role');

        $data = array(
            'produk_data' => $produk,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'foto' => $fotoprofil,
            'nama' => $nama,
            'role' => $role,
            'title' => 'Produk'
        );
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar');
        $this->load->view('produk/tbl_produk_list', $data);
        $this->load->view('template/footer');
    }

    public function create()
    {
        $fotoprofil = $this->session->userdata('gambar');
        $nama = $this->session->userdata('nama');
        $role = $this->session->userdata('role');

        $data = array(
            'button' => 'Create',
            'action' => site_url('produk/create_action'),
            'jenis' => $this->Produk_model->get_jenis()->result(),
            'id_produk' => set_value('id_produk'),
            'nama_produk' => set_value('nama_produk'),
            'id_jenis' => set_value('id_jenis'),
            'stok' => set_value('stok'),
            'harga' => set_value('harga'),
            'gambar' => set_value('gambar'),
            'foto' => $fotoprofil,
            'nama' => $nama,
            'role' => $role,
            'title' => 'Tambah Produk'
        );
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar');
        $this->load->view('produk/tbl_produk_form', $data);
        $this->load->view('template/footer');
    }

    public function create_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $file_spec = $this->_upload_file();
            $nama_file = $file_spec['namafile'];

            $data = array(
                'nama_produk' => $this->input->post('nama_produk', TRUE),
                'id_jenis' => $this->input->post('id_jenis', TRUE),
                'stok' => $this->input->post('stok', TRUE),
                'harga' => $this->input->post('harga', TRUE),
                'gambar' => $nama_file
            );

            $this->Produk_model->insert($data);
            $this->session->set_flashdata('message', '<div class="alert alert-success">Data Berhasil Ditambah!</div>');
            redirect(site_url('produk'));
        }
    }

    public function update($id)
    {
        $row = $this->Produk_model->get_by_id($id);

        $fotoprofil = $this->session->userdata('gambar');
        $nama = $this->session->userdata('nama');
        $role = $this->session->userdata('role');

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('produk/update_action'),
                'jenis' => $this->Produk_model->get_jenis()->result(),
                'id_produk' => set_value('id_produk', $row->id_produk),
                'nama_produk' => set_value('nama_produk', $row->nama_produk),
                'id_jenis' => set_value('id_jenis', $row->id_jenis),
                'stok' => set_value('stok', $row->stok),
                'harga' => set_value('harga', $row->harga),
                'foto' => $fotoprofil,
                'nama' => $nama,
                'role' => $role,
                'title' => 'Update Produk'
            );
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar');
            $this->load->view('produk/tbl_produk_form', $data);
            $this->load->view('template/footer');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-failed">Data tidak ditemukan!</div>');
            redirect(site_url('produk'));
        }
    }

    public function update_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_produk', TRUE));
        } else {
            $data = array(
                'nama_produk' => $this->input->post('nama_produk', TRUE),
                'id_jenis' => $this->input->post('id_jenis', TRUE),
                'stok' => $this->input->post('stok', TRUE),
                'harga' => $this->input->post('harga', TRUE),
            );

            $this->Produk_model->update($this->input->post('id_produk', TRUE), $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success">Data Berhasil Dirubah!</div>');
            redirect(site_url('produk'));
        }
    }

    public function delete($id)
    {
        $row = $this->Produk_model->get_by_id($id);

        if ($row) {
            unlink('./uploads/file/' . $row->gambar);
            $this->Produk_model->delete($id);
            $this->session->set_flashdata('message', '<div class="alert alert-success">Data Berhasil Dihapus</div>');
            redirect(site_url('produk'));
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-failed">Data tidak ditemukan!</div>');
            redirect(site_url('produk'));
        }
    }

    private function _upload_file()
    {
        $uploadFile = [];

        $config['upload_path'] = './uploads/file/';
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['max_size'] = 4096;
        $config['file_name'] = 'Produk-' . date('dmy') . '-' . substr(md5(rand()), 0, 10);

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('gambar')) {
            $this->session->set_flashdata('message', '<div class="alert alert-failed"><?php $this->upload->display_errors(); ?></div>');
            redirect(site_url('produk/create'));
        } else {
            $fileData = $this->upload->data();
            $this->_resize_image($fileData['file_name']);
            $uploadFile['namafile'] = $fileData['file_name'];
        }

        if (!empty($uploadFile)) {
            return $uploadFile;
        }
    }

    private function _resize_image($filename)
    {
        $resize['image_library'] = 'gd2';
        $resize['source_image'] = './uploads/file/' . $filename;
        $resize['create_thumb'] = FALSE;
        $resize['maintain_ratio'] = TRUE;
        $resize['width'] = 300;
        $resize['heigth'] = 300;
        $resize['new_image'] = './uploads/file/' . $filename;

        $this->load->library('image_lib', $resize);

        $this->image_lib->resize();
    }

    public function _rules()
    {
        $this->form_validation->set_rules('nama_produk', 'nama produk', 'required', [
            'required' => 'Nama Produk Wajib Diisi!'
        ]);
        $this->form_validation->set_rules('id_jenis', 'id_jenis', 'required', [
            'required' => 'Jenis Produk Harus Dipilih!'
        ]);
        $this->form_validation->set_rules('harga', 'harga', 'required', [
            'required' => 'Harga Barang Wajib Diisi!'
        ]);
        $this->form_validation->set_rules('stok', 'stok', 'required', [
            'required' => 'Stok Barang Harus Diisi!'
        ]);

        $this->form_validation->set_rules('id_produk', 'id_produk', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }
}
