<?php
class Front extends CI_Controller {

  public function __construct(){
      parent::__construct();
  
      // if(!$this->session->userdata('id_user'))
      //   redirect('login', 'refresh');
      
      $this->load->helper('url');
      $this->load->library('pagination');
      $this->load->database();
  }

	public function index()
	{
        // $this->db->order_by("nm_kategori", "asc");
        // $data['kategori'] = $this->db->get('tb_kategori_barang')->result();

        // $data['merk'] = $this->db->query("select distinct merk from tb_barang where merk not in ('-') order by merk")->result();
        
        

        // $this->load->view('template/front/header');
        // $this->load->view('template/front/menu');
        // $this->load->view('pages/front/home', $data);
        // $this->load->view('template/front/footer');

        $this->load->view('template/front/home');
	}

}