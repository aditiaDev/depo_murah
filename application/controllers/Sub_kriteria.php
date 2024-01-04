<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sub_kriteria extends CI_Controller {

    public function __construct(){
        parent::__construct();
    
        // if(!$this->session->userdata('id_user'))
        //   redirect('login', 'refresh');
    }

	public function index(){
    $this->db->order_by("kriteria", "asc");
    $data['kriteria'] = $this->db->get('tb_kriteria')->result();

    $this->load->view('template/back/header');
    $this->load->view('template/back/sidebar');
    $this->load->view('template/back/topnav');
    $this->load->view('pages/back/sub_kriteria', $data);
    $this->load->view('template/back/footer');
	}

  public function getAllData(){
    $data['data'] = $this->db->query("
    SELECT A.id_sub_kriteria, A.id_kriteria, B.kriteria, A.sub_kriteria, A.bobot FROM tb_sub_kriteria A 
    INNER JOIN tb_kriteria B ON A.id_kriteria = B.id_kriteria")->result();
    echo json_encode($data);
  }

  public function generateId(){
    $unik = 'SK';
    $kode = $this->db->query("SELECT MAX(id_sub_kriteria) LAST_NO FROM tb_sub_kriteria WHERE id_sub_kriteria LIKE '".$unik."%'")->row()->LAST_NO;

    $urutan = (int) substr($kode, 2, 3);
    $urutan++;
    
    $huruf = $unik;
    $kode = $huruf . sprintf("%03s", $urutan);
    return $kode;
  }

  public function saveData(){
    
    $this->load->library('form_validation');
    $this->form_validation->set_rules('id_kriteria', 'kriteria', 'required');
    $this->form_validation->set_rules('sub_kriteria', 'Sub kriteria', 'required');

    if($this->form_validation->run() == FALSE){
      // echo validation_errors();
      $output = array("status" => "error", "message" => validation_errors());
      echo json_encode($output);
      return false;
    }

    $id = $this->generateId();
    
    $data = array(
              "id_sub_kriteria" => $id,
              "id_kriteria" => $this->input->post('id_kriteria'),
              "sub_kriteria" => $this->input->post('sub_kriteria'),
            );
    $this->db->insert('tb_sub_kriteria', $data);
    $output = array("status" => "success", "message" => "Data Berhasil Disimpan");
    echo json_encode($output);

  }

  public function updateData(){

    $this->load->library('form_validation');
    $this->form_validation->set_rules('id_kriteria', 'kriteria', 'required');
    $this->form_validation->set_rules('sub_kriteria', 'Sub kriteria', 'required');

    if($this->form_validation->run() == FALSE){
      // echo validation_errors();
      $output = array("status" => "error", "message" => validation_errors());
      echo json_encode($output);
      return false;
    }

    $data = array(
      "id_kriteria" => $this->input->post('id_kriteria'),
      "sub_kriteria" => $this->input->post('sub_kriteria'),
    );
    $this->db->where('id_sub_kriteria', $this->input->post('id_sub_kriteria'));
    $this->db->update('tb_sub_kriteria', $data);
    if($this->db->error()['message'] != ""){
      $output = array("status" => "error", "message" => $this->db->error()['message']);
      echo json_encode($output);
      return false;
    }
    $output = array("status" => "success", "message" => "Data Berhasil di Update");
    echo json_encode($output);
  }

  public function deleteData(){
    $this->db->where('id_sub_kriteria', $this->input->post('id_sub_kriteria'));
    $this->db->delete('tb_sub_kriteria');

    $output = array("status" => "success", "message" => "Data Berhasil di Hapus");
    echo json_encode($output);
  }
}
