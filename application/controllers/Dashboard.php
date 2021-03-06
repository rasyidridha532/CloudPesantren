<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

	function __construct()
	{
		parent::__construct();

		$status = $this->session->userdata('status');
		if (isset($status) != "login") {
			redirect(base_url("auth"));
		}
	}

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	public function index()
	{
		$fotoprofil = $this->session->userdata('gambar');
		$nama = $this->session->userdata('nama');
		$role = $this->session->userdata('role');

		$hitung_semua_user = $this->db->count_all('tbl_users');
		$hitung_semua_produk = $this->db->count_all('tbl_produk');
		$hitung_semua_file = $this->db->count_all('tbl_file');

		$this->load->model('Produk_model');
		$hitung_stok = $this->Produk_model->get_stok();

		if ($hitung_stok == 0) {
			$hitung_stok = 'Stok Kosong';
		}

		$user['hitung_user'] = $hitung_semua_user;
		$user['hitung_produk'] = $hitung_semua_produk;
		$user['hitung_file'] = $hitung_semua_file;
		$user['hitung_stok'] = $hitung_stok;


		$data = array(
			'title' => 'Dashboard',
			'foto' => $fotoprofil,
			'nama' => $nama,
			'role' => $role
		);

		$peran = array('role' => $role);

		$this->load->view('template/header', $data);
		$this->load->view('template/sidebar', $peran);
		$this->load->view('dashboard', $user);
		$this->load->view('template/footer');
	}
}
