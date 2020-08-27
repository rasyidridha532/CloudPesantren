<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Produk_model extends CI_Model
{

    public $table = 'tbl_produk';
    public $id = 'id_produk';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // get all
    function get_all()
    {
        $this->db->order_by($this->id, $this->order);
        $this->db->join('tbl_jenis', 'tbl_produk.id_jenis = tbl_jenis.id_jenis');
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
        $this->db->join('tbl_jenis', 'tbl_produk.id_jenis = tbl_jenis.id_jenis');
        $this->db->like('nama_produk', $q);
        $this->db->or_like('nama_jenis', $q);
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL)
    {
        $this->db->join('tbl_jenis', 'tbl_produk.id_jenis = tbl_jenis.id_jenis');
        $this->db->order_by($this->id, $this->order);
        $this->db->like('nama_produk', $q);
        $this->db->or_like('nama_jenis', $q);
        $this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }

    function get_produk()
    {
        $this->db->select('nama_produk,stok,gambar');
        $query = $this->db->get($this->table);

        return $query;
    }

    function get_stok()
    {
        $this->db->select('stok');
        $query = $this->db->get('tbl_produk');

        if ($query->num_rows() > 0) {
            return $query->row()->stok;
        }
        return false;
    }

    // insert data
    function insert($data)
    {
        $this->db->insert($this->table, $data);
    }

    function get_jenis()
    {
        $this->db->select('id_jenis,nama_jenis');
        $query = $this->db->get('tbl_jenis');
        return $query;
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
