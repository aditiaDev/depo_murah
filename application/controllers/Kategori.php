<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kategori extends CI_Controller {

    public function __construct(){
        parent::__construct();
    
        // if(!$this->session->userdata('id_user'))
        //   redirect('login', 'refresh');
    }

	public function index(){
    $this->load->view('template/back/header');
    $this->load->view('template/back/sidebar');
    $this->load->view('template/back/topnav');
    $this->load->view('pages/back/kategori');
    $this->load->view('template/back/footer');
	}

  public function getAllData(){
    $data['data'] = $this->db->query("SELECT * FROM tb_kategori_barang")->result();
    echo json_encode($data);
  }

  public function generateId(){
    $unik = 'K';
    $kode = $this->db->query("SELECT MAX(id_kategori_barang) LAST_NO FROM tb_kategori_barang WHERE id_kategori_barang LIKE '".$unik."%'")->row()->LAST_NO;
    // mengambil angka dari kode barang terbesar, menggunakan fungsi substr
    // dan diubah ke integer dengan (int)
    $urutan = (int) substr($kode, 1, 4);
    
    // bilangan yang diambil ini ditambah 1 untuk menentukan nomor urut berikutnya
    $urutan++;
    
    // membentuk kode barang baru
    // perintah sprintf("%03s", $urutan); berguna untuk membuat string menjadi 3 karakter
    // misalnya perintah sprintf("%03s", 15); maka akan menghasilkan '015'
    // angka yang diambil tadi digabungkan dengan kode huruf yang kita inginkan, misalnya BRG 
    $huruf = $unik;
    $kode = $huruf . sprintf("%04s", $urutan);
    return $kode;
  }

  public function saveData(){
    
    $this->load->library('form_validation');
    $this->form_validation->set_rules('nm_kategori', 'Nama kategori', 'required');
    $this->form_validation->set_rules('kode_kategori', 'kode kategori', 'required|is_unique[tb_kategori_barang.kode_kategori]');

    if($this->form_validation->run() == FALSE){
      // echo validation_errors();
      $output = array("status" => "error", "message" => validation_errors());
      echo json_encode($output);
      return false;
    }

    $id = $this->generateId();
    
    $data = array(
              "id_kategori_barang" => $id,
              "nm_kategori" => $this->input->post('nm_kategori'),
              "kode_kategori" => $this->input->post('kode_kategori'),
            );
    $this->db->insert('tb_kategori_barang', $data);
    $output = array("status" => "success", "message" => "Data Berhasil Disimpan");
    echo json_encode($output);

  }

  public function updateData(){

    $this->load->library('form_validation');
    $this->form_validation->set_rules('id_kategori_barang', 'id kategori barang', 'required');
    $this->form_validation->set_rules('nm_kategori', 'Nama kategori', 'required');
    $this->form_validation->set_rules('kode_kategori', 'kode kategori', 'required');

    if($this->form_validation->run() == FALSE){
      // echo validation_errors();
      $output = array("status" => "error", "message" => validation_errors());
      echo json_encode($output);
      return false;
    }

    $data = array(
        "nm_kategori" => $this->input->post('nm_kategori'),
        "kode_kategori" => $this->input->post('kode_kategori'),
    );
    $this->db->where('id_kategori_barang', $this->input->post('id_kategori_barang'));
    $this->db->update('tb_kategori_barang', $data);
    if($this->db->error()['message'] != ""){
      $output = array("status" => "error", "message" => $this->db->error()['message']);
      echo json_encode($output);
      return false;
    }
    $output = array("status" => "success", "message" => "Data Berhasil di Update");
    echo json_encode($output);
  }

  public function deleteData(){
    $this->db->where('id_kategori_barang', $this->input->post('id_kategori_barang'));
    $this->db->delete('tb_kategori_barang');

    $output = array("status" => "success", "message" => "Data Berhasil di Hapus");
    echo json_encode($output);
  }
}
