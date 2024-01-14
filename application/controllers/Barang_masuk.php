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

  public function inputbarangmasuk(){
    $data['cabang'] = $this->db->query(
      "SELECT A.id_cabang, B.nm_cabang FROM tb_user A 
      LEFT JOIN tb_cabang B ON A.id_cabang = B.id_cabang
      WHERE A.id_user = '".$this->session->userdata('id_user')."'"
    )->result();
    $this->load->view('template/back/header');
    $this->load->view('template/back/sidebar');
    $this->load->view('template/back/topnav');
    $this->load->view('pages/back/inputbarangmasuk', $data);
    $this->load->view('template/back/footer');
  }

  public function generateId(){
    $unik = 'BM'.date('my');
    $kode = $this->db->query("SELECT MAX(id_barang_masuk) LAST_NO FROM tb_barang_masuk WHERE id_barang_masuk LIKE '".$unik."%'")->row()->LAST_NO;
    $urutan = (int) substr($kode, 6, 4);
    
    $urutan++;
    
    $huruf = $unik;
    $kode = $huruf . sprintf("%04s", $urutan);
    return $kode;
  }

  function saveData(){
    $this->load->library('form_validation');
    $this->form_validation->set_rules('id_barang', 'Barang', 'required');
    $this->form_validation->set_rules('doc_tipe', 'Doc Tipe', 'required');
    $this->form_validation->set_rules('jumlah', 'jumlah', 'required|numeric');
    $this->form_validation->set_rules('harga', 'harga', 'required|numeric');

    if($this->form_validation->run() == FALSE){
      $output = array("status" => "error", "message" => validation_errors());
      echo json_encode($output);
      return false;
    }

    $id = $this->generateId();

    // $id_cabang = $this->db->query("
    //   SELECT id_cabang FROM tb_user WHERE id_user = '".$this->session->userdata('id_user')."'
    // ")->row()->id_cabang;

    $id_cabang = $this->input->post('id_cabang');
    
    $total = $this->input->post('harga') * $this->input->post('jumlah');
    $data = array(
              "id_barang_masuk " => $id,
              "id_barang" => $this->input->post('id_barang'),
              "id_cabang" => $id_cabang,
              "doc_tipe" => $this->input->post('doc_tipe'),
              "tgl_masuk" => date('Y-m-d H:i:s'),
              "ket" => $this->input->post('ket'),
              "jumlah" => $this->input->post('jumlah'),
              "harga" => $this->input->post('harga'),
              "total" => $total,
            );
    $this->db->insert('tb_barang_masuk', $data);

    $cekExistBarang = $this->db->query("
      SELECT COUNT(id_barang) CEK FROM tb_stock_cabang WHERE id_barang = '".$this->input->post('id_barang')."' 
      AND id_cabang = '".$id_cabang."'
    ")->row()->CEK;

    if($cekExistBarang == 0){
      $this->db->query("
        INSERT INTO tb_stock_cabang(id_cabang, id_barang, stock) VALUES(
          '".$id_cabang."', '".$this->input->post('id_barang')."', 0
        )
      ");
    }else{
      $this->db->query("
        UPDATE tb_stock_cabang SET 
        stock = stock + ".$this->input->post('jumlah')." 
        WHERE id_barang = '".$this->input->post('id_barang')."' 
        AND id_cabang = '".$id_cabang."'
      ");
    }

    $output = array("status" => "success", "message" => "Data Berhasil Disimpan");
    echo json_encode($output);
  }

}