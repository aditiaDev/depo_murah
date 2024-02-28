<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Stockbarang extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();

    // if(!$this->session->userdata('id_user'))
    //   redirect('login', 'refresh');
  }

  public function index()
  {

    $this->load->view('template/back/header');
    $this->load->view('template/back/sidebar');
    $this->load->view('template/back/topnav');
    $this->load->view('pages/back/stockbarang');
    $this->load->view('template/back/footer');
  }

  public function getStockCabang()
  {
    $id_user = $this->session->userdata('id_user');
    $q_cabang = "";
    if ($this->session->userdata('level') != "PEMILIK") {
      $id_cabang = $this->db->query("SELECT id_cabang FROM tb_user WHERE id_user = '" . $id_user . "'")->row()->id_cabang;
      $q_cabang = " WHERE B.id_cabang = '" . $id_cabang . "' ";
    }

    $data['data'] = $this->db->query("SELECT A.id_barang, A.id_kategori_barang, A.nm_barang, A.harga_barang, 
    C.id_cabang, C.nm_cabang, B.stock
    FROM tb_barang A
    LEFT JOIN tb_stock_cabang B ON A.id_barang = B.id_barang
    LEFT JOIN tb_cabang C ON B.id_cabang = C.id_cabang 
    " . $q_cabang)->result();
    echo json_encode($data);
  }
}
