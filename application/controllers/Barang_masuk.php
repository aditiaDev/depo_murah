<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Barang_masuk extends CI_Controller {

    public function __construct(){
        parent::__construct();
    
        if(!$this->session->userdata('id_user'))
          redirect('login', 'refresh');
    }

	public function index(){
    $this->load->view('template/back/header');
    $this->load->view('template/back/sidebar');
    $this->load->view('template/back/topnav');
    $this->load->view('pages/back/barangmasuk');
    $this->load->view('template/back/footer');
	}

  public function getAllData(){
    $data['data'] = $this->db->query("SELECT * FROM tb_barang_masuk")->result();
    echo json_encode($data);
  }

}