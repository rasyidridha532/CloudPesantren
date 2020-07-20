<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class File_model extends CI_Model
{

    public $table = 'tbl_file';
    public $id = 'id_file';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // get all
    function get_all()
    {
        $this->db->order_by($this->id, $this->order);
        return $this->db->get($this->table)->result();
    }

    // get data by id
    function get_by_id($id)
    {
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }

    // get total rows
    function total_rows($q = NULL)
    {
        $this->db->or_like('judul', $q);
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    function total_row_by_id($q = NULL, $id)
    {
        $this->db->join('tbl_users', 'tbl_file.id_file = tbl_users.id');
        $this->db->or_like('judul', $q);
        $this->db->from($this->table);
        $this->db->where('id_user', $id);
        return $this->db->count_all_results();
    }

    function total($id)
    {
        $this->db->where('id_user', $id);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL)
    {
        $this->db->join('tbl_users', 'tbl_file.id_user = tbl_users.id');
        $this->db->order_by($this->id, $this->order);
        $this->db->or_like('judul', $q);
        $this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }

    function get_limit_data_by_id($limit, $start = 0, $q = NULL, $id)
    {
        $this->db->select('id_file,judul,nama_file,size,uploaded_at,id_user');
        $this->db->order_by($this->id, $this->order);
        $this->db->like('judul', $q);
        $this->db->limit($limit, $start);
        return $this->db->get_where($this->table, array('id_user' => $id))->result();
    }

    // insert data
    function insert($data)
    {
        $this->db->insert($this->table, $data);
    }

    // update data
    function update($id, $data)
    {
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
    }

    // delete data
    function delete($id)
    {
        $this->db->where($this->id, $id);
        $this->db->delete($this->table);
    }
}
