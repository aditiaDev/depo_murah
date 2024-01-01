<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Barang extends CI_Controller {

    public function __construct(){
        parent::__construct();
    
        // if(!$this->session->userdata('id_user'))
        //   redirect('login', 'refresh');
    }

	public function index(){
    $this->db->order_by("nm_kategori", "asc");
    $data['kategori'] = $this->db->get('tb_kategori_barang')->result();

    $this->load->view('template/back/header');
    $this->load->view('template/back/sidebar');
    $this->load->view('template/back/topnav');
    $this->load->view('pages/back/barang', $data);
    $this->load->view('template/back/footer');
	}

  public function getAllData(){
    $data['data'] = $this->db->query("
    SELECT B.nm_kategori, A.id_barang, A.id_kategori_barang, A.nm_barang, 
    A.harga_barang, A.foto_barang, A.deskripsi, A.point_barang
    FROM tb_barang A 
    LEFT JOIN tb_kategori_barang B ON A.id_kategori_barang = B.id_kategori_barang
    ")->result();
    echo json_encode($data);
  }

  private function _do_upload(){
		$config['upload_path']          = 'assets/images/barang/';
    $config['allowed_types']        = 'gif|jpg|jpeg|png';
    $config['max_size']             = 5000; //set max size allowed in Kilobyte
    $config['max_width']            = 4000; // set max width image allowed
    $config['max_height']           = 4000; // set max height allowed
    $config['file_name']            = round(microtime(true) * 1000); //just milisecond timestamp fot unique name

    $this->load->library('upload', $config);

    if(!$this->upload->do_upload('foto_barang')) //upload and validate
    {
      $data['inputerror'] = 'foto';
			$data['message'] = 'Upload error: '.$this->upload->display_errors('',''); //show ajax error
			$data['status'] = FALSE;
			echo json_encode($data);
			exit();
		}
		return $this->upload->data('file_name');
	}

  public function generateId($code){
    $unik = $code;
    $kode = $this->db->query("SELECT MAX(id_barang) LAST_NO FROM tb_barang WHERE id_barang LIKE '".$unik."%'")->row()->LAST_NO;
    // mengambil angka dari kode barang terbesar, menggunakan fungsi substr
    // dan diubah ke integer dengan (int)
    $urutan = (int) substr($kode, 3, 5);
    
    // bilangan yang diambil ini ditambah 1 untuk menentukan nomor urut berikutnya
    $urutan++;
    
    $huruf = $unik;
    $kode = $huruf . sprintf("%05s", $urutan);
    return $kode;
  }

  public function saveData(){
    
    $this->load->library('form_validation');

    $this->form_validation->set_rules('nm_barang', 'nm_barang', 'required|is_unique[tb_barang.nm_barang]');
    $this->form_validation->set_rules('id_kategori_barang', 'id_kategori_barang', 'required');
    $this->form_validation->set_rules('harga_barang', 'harga', 'required|numeric');
    $this->form_validation->set_rules('deskripsi', 'deskripsi', 'required');
    $this->form_validation->set_rules('point_barang', 'point_barang', 'required');

    if($this->form_validation->run() == FALSE){
      // echo validation_errors();
      $output = array("status" => "error", "message" => validation_errors());
      echo json_encode($output);
      return false;
    }

    $code = $this->db->query("SELECT kode_kategori 
    FROM tb_kategori_barang WHERE id_kategori_barang = '".$this->input->post('id_kategori_barang')."'")->row()->kode_kategori;
    $id = $this->generateId($code);
    
    $data = array(
              "id_barang" => $id,
              "id_kategori_barang" => $this->input->post('id_kategori_barang'),
              "nm_barang" => $this->input->post('nm_barang'),
              "harga_barang" => $this->input->post('harga_barang'),
              "deskripsi" => $this->input->post('deskripsi'),
              "point_barang" => $this->input->post('point_barang'),
            );

    if(!empty($_FILES['foto_barang']['name'])){
      $upload = $this->_do_upload();
      $data['foto_barang'] = $upload;
    }

    $this->db->insert('tb_barang', $data);
    $output = array("status" => "success", "message" => "Data Berhasil Disimpan");
    echo json_encode($output);

  }

  public function updateData($id_barang){

    $this->load->library('form_validation');
    $this->form_validation->set_rules('nm_barang', 'nm_barang', 'required');
    $this->form_validation->set_rules('id_kategori_barang', 'id_kategori_barang', 'required');
    $this->form_validation->set_rules('harga_barang', 'harga', 'required|numeric');
    $this->form_validation->set_rules('deskripsi', 'deskripsi', 'required');
    $this->form_validation->set_rules('point_barang', 'point_barang', 'required');

    if($this->form_validation->run() == FALSE){
      // echo validation_errors();
      $output = array("status" => "error", "message" => validation_errors());
      echo json_encode($output);
      return false;
    }

    $data = array(
      "id_kategori_barang" => $this->input->post('id_kategori_barang'),
      "nm_barang" => $this->input->post('nm_barang'),
      "harga_barang" => $this->input->post('harga_barang'),
      "deskripsi" => $this->input->post('deskripsi'),
      "point_barang" => $this->input->post('point_barang'),
    );

    if(!empty($_FILES['foto_barang']['name'])){
      $upload = $this->_do_upload();
      $data['foto_barang'] = $upload;
    }

    $this->db->where('id_barang', $id_barang);
    $this->db->update('tb_barang', $data);
    if($this->db->error()['message'] != ""){
      $output = array("status" => "error", "message" => $this->db->error()['message']);
      echo json_encode($output);
      return false;
    }
    $output = array("status" => "success", "message" => "Data Berhasil di Update");
    echo json_encode($output);
  }

  public function deleteData(){
    $this->db->where('id_barang', $this->input->post('id_barang'));
    $this->db->delete('tb_barang');

    $output = array("status" => "success", "message" => "Data Berhasil di Hapus");
    echo json_encode($output);
  }

}
?>