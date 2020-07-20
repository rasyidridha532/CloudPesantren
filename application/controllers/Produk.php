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
            'harga' => set_value('harga'),
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
            $data = array(
                'nama_produk' => $this->input->post('nama_produk', TRUE),
                'jenis' => $this->input->post('jenis', TRUE),
                'harga' => $this->input->post('harga', TRUE),
            );

            $this->Produk_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
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
                'id_produk' => set_value('id_produk', $row->id_produk),
                'nama_produk' => set_value('nama_produk', $row->nama_produk),
                'jenis' => set_value('jenis', $row->jenis),
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
            $this->session->set_flashdata('message', 'Record Not Found');
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
                'jenis' => $this->input->post('jenis', TRUE),
                'harga' => $this->input->post('harga', TRUE),
            );

            $this->Produk_model->update($this->input->post('id_produk', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('produk'));
        }
    }

    public function delete($id)
    {
        $row = $this->Produk_model->get_by_id($id);

        if ($row) {
            $this->Produk_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('produk'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('produk'));
        }
    }

    public function _rules()
    {
        $this->form_validation->set_rules('nama_produk', 'nama produk', 'required');
        $this->form_validation->set_rules('jenis', 'jenis', 'required', [
            'required' => 'Jenis Produk Harus Dipilih!'
        ]);
        $this->form_validation->set_rules('harga', 'harga', 'required');

        $this->form_validation->set_rules('id_produk', 'id_produk', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }
}
