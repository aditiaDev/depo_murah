<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kriteria extends CI_Controller {

    public function __construct(){
        parent::__construct();
    
        // if(!$this->session->userdata('id_user'))
        //   redirect('login', 'refresh');
    }

	public function index(){
    $this->load->view('template/back/header');
    $this->load->view('template/back/sidebar');
    $this->load->view('template/back/topnav');
    $this->load->view('pages/back/kriteria');
    $this->load->view('template/back/footer');
	}

  public function getAllData(){
    $data['data'] = $this->db->query("SELECT * FROM tb_kriteria")->result();
    echo json_encode($data);
  }

  public function generateId(){
    $unik = 'KR';
    $kode = $this->db->query("SELECT MAX(id_kriteria) LAST_NO FROM tb_kriteria WHERE id_kriteria LIKE '".$unik."%'")->row()->LAST_NO;

    $urutan = (int) substr($kode, 2, 3);
    $urutan++;
    
    $huruf = $unik;
    $kode = $huruf . sprintf("%03s", $urutan);
    return $kode;
  }

  public function saveData(){
    
    $this->load->library('form_validation');
    $this->form_validation->set_rules('kriteria', 'kriteria', 'required|is_unique[tb_kriteria.kriteria]');

    if($this->form_validation->run() == FALSE){
      // echo validation_errors();
      $output = array("status" => "error", "message" => validation_errors());
      echo json_encode($output);
      return false;
    }

    $id = $this->generateId();
    
    $data = array(
              "id_kriteria" => $id,
              "kriteria" => $this->input->post('kriteria'),
            );
    $this->db->insert('tb_kriteria', $data);
    $output = array("status" => "success", "message" => "Data Berhasil Disimpan");
    echo json_encode($output);

  }

  public function updateData(){

    $this->load->library('form_validation');
    $this->form_validation->set_rules('kriteria', 'kriteria', 'required');

    if($this->form_validation->run() == FALSE){
      // echo validation_errors();
      $output = array("status" => "error", "message" => validation_errors());
      echo json_encode($output);
      return false;
    }

    $data = array(
      "kriteria" => $this->input->post('kriteria'),
    );
    $this->db->where('id_kriteria', $this->input->post('id_kriteria'));
    $this->db->update('tb_kriteria', $data);
    if($this->db->error()['message'] != ""){
      $output = array("status" => "error", "message" => $this->db->error()['message']);
      echo json_encode($output);
      return false;
    }
    $output = array("status" => "success", "message" => "Data Berhasil di Update");
    echo json_encode($output);
  }

  public function deleteData(){
    $this->db->where('id_kriteria', $this->input->post('id_kriteria'));
    $this->db->delete('tb_kriteria');

    $output = array("status" => "success", "message" => "Data Berhasil di Hapus");
    echo json_encode($output);
  }
}
