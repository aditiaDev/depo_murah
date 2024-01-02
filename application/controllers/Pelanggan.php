<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pelanggan extends CI_Controller {

    public function __construct(){
        parent::__construct();
    
        // if(!$this->session->userdata('id_user'))
        //   redirect('login', 'refresh');
    }

	public function index()
	{
    $this->load->view('template/back/header');
    $this->load->view('template/back/sidebar');
    $this->load->view('template/back/topnav');
    $this->load->view('pages/back/pelanggan');
    $this->load->view('template/back/footer');
	}

  public function getAllData(){
    $data['data'] = $this->db->query("
      SELECT * FROM tb_pelanggan 
    ")->result();
    echo json_encode($data);
  }

  public function generateId(){
    $unik = 'P'.date('y');
    $kode = $this->db->query("SELECT MAX(id_pelanggan) LAST_NO FROM tb_pelanggan WHERE id_pelanggan LIKE '".$unik."%'")->row()->LAST_NO;

    $urutan = (int) substr($kode, 3, 5);
    $urutan++;
    
    $huruf = $unik;
    $kode = $huruf . sprintf("%05s", $urutan);
    return $kode;
  }

  public function saveData(){
    
    $this->load->library('form_validation');
    $this->form_validation->set_rules('nm_pelanggan', 'Nama pelanggan', 'required');
    $this->form_validation->set_rules('no_pelanggan', 'No pelanggan', 'required');
    $this->form_validation->set_rules('alamat', 'alamat', 'required');


    if($this->form_validation->run() == FALSE){
      // echo validation_errors();
      $output = array("status" => "error", "message" => validation_errors());
      echo json_encode($output);
      return false;
    }

    $id = $this->generateId();
    
    $data = array(
              "id_pelanggan" => $id,
              "nm_pelanggan" => $this->input->post('nm_pelanggan'),
              "no_pelanggan" => $this->input->post('no_pelanggan'),
              "alamat" => $this->input->post('alamat'),
              "tgl_register" => date('Y-m-d'),
              "point_pelanggan" => 0,
            );
    $this->db->insert('tb_pelanggan', $data);
    $output = array("status" => "success", "message" => "Data Berhasil Disimpan");
    echo json_encode($output);

  }

  public function updateData(){

    $this->load->library('form_validation');
    $this->form_validation->set_rules('nm_pelanggan', 'Nama pelanggan', 'required');
    $this->form_validation->set_rules('no_pelanggan', 'No pelanggan', 'required');
    $this->form_validation->set_rules('alamat', 'alamat', 'required');

    if($this->form_validation->run() == FALSE){
      // echo validation_errors();
      $output = array("status" => "error", "message" => validation_errors());
      echo json_encode($output);
      return false;
    }

    $data = array(
      "nm_pelanggan" => $this->input->post('nm_pelanggan'),
      "no_pelanggan" => $this->input->post('no_pelanggan'),
      "alamat" => $this->input->post('alamat'),
    );
    $this->db->where('id_pelanggan', $this->input->post('id_pelanggan'));
    $this->db->update('tb_pelanggan', $data);
    if($this->db->error()['message'] != ""){
      $output = array("status" => "error", "message" => $this->db->error()['message']);
      echo json_encode($output);
      return false;
    }
    $output = array("status" => "success", "message" => "Data Berhasil di Update");
    echo json_encode($output);
  }

  public function deleteData(){
    $this->db->where('id_pelanggan', $this->input->post('id_pelanggan'));
    $this->db->delete('tb_pelanggan');

    $output = array("status" => "success", "message" => "Data Berhasil di Hapus");
    echo json_encode($output);
  }

  public function getPelanggan(){
    $data['data'] = $this->db->query("
      SELECT * FROM tb_pelanggan 
    ")->result();
    echo json_encode($data);
  }
  
}
