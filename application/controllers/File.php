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

        if ($q <> '') {
            $config['base_url'] = base_url() . 'file/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'file/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'file/index.html';
            $config['first_url'] = base_url() . 'file/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->File_model->total_rows($q);
        $file = $this->File_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'file_data' => $file,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->load->view('file/tbl_file_list', $data);
    }

    public function read($id)
    {
        $row = $this->File_model->get_by_id($id);
        if ($row) {
            $data = array(
                'id_file' => $row->id_file,
                'judul' => $row->judul,
                'nama_file' => $row->nama_file,
                'size' => $row->size,
                'uploaded_at' => $row->uploaded_at,
            );
            $this->load->view('file/tbl_file_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('file'));
        }
    }

    public function create()
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('file/create_action'),
            'id_file' => set_value('id_file'),
            'judul' => set_value('judul'),
            'nama_file' => set_value('nama_file'),
            'size' => set_value('size'),
            'uploaded_at' => set_value('uploaded_at'),
        );
        $this->load->view('file/tbl_file_form', $data);
    }

    public function create_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
                'judul' => $this->input->post('judul', TRUE),
                'nama_file' => $this->input->post('nama_file', TRUE),
                'size' => $this->input->post('size', TRUE),
                'uploaded_at' => $this->input->post('uploaded_at', TRUE),
            );

            $this->File_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('file'));
        }
    }

    public function update($id)
    {
        $row = $this->File_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('file/update_action'),
                'id_file' => set_value('id_file', $row->id_file),
                'judul' => set_value('judul', $row->judul),
                'nama_file' => set_value('nama_file', $row->nama_file),
                'size' => set_value('size', $row->size),
                'uploaded_at' => set_value('uploaded_at', $row->uploaded_at),
            );
            $this->load->view('file/tbl_file_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('file'));
        }
    }

    public function update_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_file', TRUE));
        } else {
            $data = array(
                'judul' => $this->input->post('judul', TRUE),
                'nama_file' => $this->input->post('nama_file', TRUE),
                'size' => $this->input->post('size', TRUE),
                'uploaded_at' => $this->input->post('uploaded_at', TRUE),
            );

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
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('file'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('file'));
        }
    }

    public function _rules()
    {
        $this->form_validation->set_rules('judul', 'judul', 'trim|required');
        $this->form_validation->set_rules('nama_file', 'nama file', 'trim|required');
        $this->form_validation->set_rules('size', 'size', 'trim|required');
        $this->form_validation->set_rules('uploaded_at', 'uploaded at', 'trim|required');

        $this->form_validation->set_rules('id_file', 'id_file', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }
}

/* End of file File.php */
/* Location: ./application/controllers/File.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2020-07-20 07:04:27 */
/* http://harviacode.com */