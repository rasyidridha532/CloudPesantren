<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Home extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Produk_model');
    }

    public function index()
    {
        $produk = $this->Produk_model->get_produk();

        $this->load->view('frontend/index', $produk);
    }
}
