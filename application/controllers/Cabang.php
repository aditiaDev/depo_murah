<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cabang extends CI_Controller {

    public function __construct(){
        parent::__construct();
    
        // if(!$this->session->userdata('id_user'))
        //   redirect('login', 'refresh');
    }

	public function index(){
    $this->load->view('template/back/header');
    $this->load->view('template/back/sidebar');
    $this->load->view('template/back/topnav');
    $this->load->view('pages/back/cabang');
    $this->load->view('template/back/footer');
	}

  public function getAllData(){
    $data['data'] = $this->db->query("SELECT * FROM tb_cabang")->result();
    echo json_encode($data);
  }

  public function getUserKepala(){
    $data['data'] = $this->db->query("SELECT id_user, nm_pengguna FROM tb_user WHERE LEVEL = 'KEPALA TOKO'")->result();
    echo json_encode($data);
  }

  public function generateId(){
    $unik = 'CB';
    $kode = $this->db->query("SELECT MAX(id_cabang) LAST_NO FROM tb_cabang WHERE id_cabang LIKE '".$unik."%'")->row()->LAST_NO;
    // mengambil angka dari kode barang terbesar, menggunakan fungsi substr
    // dan diubah ke integer dengan (int)
    $urutan = (int) substr($kode, 2, 3);
    
    // bilangan yang diambil ini ditambah 1 untuk menentukan nomor urut berikutnya
    $urutan++;
    
    // membentuk kode barang baru
    // perintah sprintf("%03s", $urutan); berguna untuk membuat string menjadi 3 karakter
    // misalnya perintah sprintf("%03s", 15); maka akan menghasilkan '015'
    // angka yang diambil tadi digabungkan dengan kode huruf yang kita inginkan, misalnya BRG 
    $huruf = $unik;
    $kode = $huruf . sprintf("%03s", $urutan);
    return $kode;
  }

  public function saveData(){
    
    $this->load->library('form_validation');
    // $this->form_validation->set_rules('id_user', 'id_user', 'required');
    $this->form_validation->set_rules('nm_cabang', 'Nama cabang', 'required');
    $this->form_validation->set_rules('alamat_cabang', 'Alamat cabang', 'required');
    // $this->form_validation->set_rules('nm_kepala_toko', 'Nama Kepala Cabang', 'required');

    if($this->form_validation->run() == FALSE){
      // echo validation_errors();
      $output = array("status" => "error", "message" => validation_errors());
      echo json_encode($output);
      return false;
    }

    $id = $this->generateId();
    
    $data = array(
              "id_cabang " => $id,
              "nm_cabang" => $this->input->post('nm_cabang'),
              "alamat_cabang" => $this->input->post('alamat_cabang'),
              // "id_user" => $this->input->post('id_user'),
              // "nm_kepala_toko" => $this->input->post('nm_kepala_toko'),
            );
    $this->db->insert('tb_cabang', $data);
    $output = array("status" => "success", "message" => "Data Berhasil Disimpan");
    echo json_encode($output);

  }

  public function updateData(){

    $this->load->library('form_validation');
    $this->form_validation->set_rules('id_cabang', 'id Cabang', 'required');
    $this->form_validation->set_rules('nm_cabang', 'nm_cabang', 'required');
    $this->form_validation->set_rules('alamat_cabang', 'alamat_cabang', 'required');
    // $this->form_validation->set_rules('id_user', 'id_user', 'required');
    
    // $this->form_validation->set_rules('nm_kepala_toko', 'Nama Kepala Cabang', 'required');

    if($this->form_validation->run() == FALSE){
      // echo validation_errors();
      $output = array("status" => "error", "message" => validation_errors());
      echo json_encode($output);
      return false;
    }

    $data = array(
      "nm_cabang" => $this->input->post('nm_cabang'),
      "alamat_cabang" => $this->input->post('alamat_cabang'),
      // "id_user" => $this->input->post('id_user'),
      // "nm_kepala_toko" => $this->input->post('nm_kepala_toko'),
    );
    $this->db->where('id_cabang', $this->input->post('id_cabang'));
    $this->db->update('tb_cabang', $data);
    if($this->db->error()['message'] != ""){
      $output = array("status" => "error", "message" => $this->db->error()['message']);
      echo json_encode($output);
      return false;
    }
    $output = array("status" => "success", "message" => "Data Berhasil di Update");
    echo json_encode($output);
  }

  public function deleteData(){
    $this->db->where('id_cabang', $this->input->post('id_cabang'));
    $this->db->delete('tb_cabang');

    $output = array("status" => "success", "message" => "Data Berhasil di Hapus");
    echo json_encode($output);
  }
}
