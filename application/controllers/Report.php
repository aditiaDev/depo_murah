<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller {

  public function __construct(){
      parent::__construct();
  
      if(!$this->session->userdata('id_user'))
        redirect('login', 'refresh');

      $this->load->library('pdf');
  }

	public function ctkStruk()
	{
		$data['data'] = $this->db->query("
    SELECT A.id_penjualan, A.tgl_penjualan, A.tot_harga_barang, A.tot_akhir, 
    B.id_barang, D.nm_barang, B.jumlah, B.harga_barang, B.subtotal,
    A.id_pelanggan, C.nm_pelanggan, A.diskon
    FROM tb_penjualan A
    LEFT JOIN tb_dtl_penjualan B ON A.id_penjualan = B.id_penjualan
    LEFT JOIN tb_pelanggan C ON A.id_pelanggan = C.id_pelanggan
    LEFT JOIN tb_barang D ON B.id_barang = D.id_barang
    WHERE A.id_penjualan = '".$this->input->post('id_penjualan')."'
    ")->result_array();

    // $this->pdf->setPaper('A4', 'potrait');
    $customPaper = array(0,0,290,380);
    $this->pdf->set_paper($customPaper);
    $this->pdf->filename = "ctk_struk.pdf";
    $this->pdf->load_view('report/ctk_struk', $data);

	}

  public function penjualan(){
    $this->load->view('template/back/header');
    $this->load->view('template/back/sidebar');
    $this->load->view('template/back/topnav');
    $this->load->view('pages/back/rptpenjualan');
    $this->load->view('template/back/footer');
  }

  public function ctkPenjualan(){
    $data['data'] = $this->db->query("
      SELECT A.id_penjualan, 
      DATE_FORMAT(A.tgl_penjualan,'%d %b %Y') tgl_penjualan, 
      A.id_pelanggan, C.nm_pelanggan, 
      A.tot_akhir, 
      b.id_barang, D.nm_barang,b.jumlah, B.harga_barang, B.subtotal,
      E.nm_cabang
      FROM tb_penjualan A
      LEFT JOIN tb_dtl_penjualan B ON A.id_penjualan = B.id_penjualan
      LEFT JOIN tb_pelanggan C ON A.id_pelanggan = C.id_pelanggan
      LEFT JOIN tb_barang D ON B.id_barang = D.id_barang
      LEFT JOIN tb_cabang E ON A.id_cabang = E.id_cabang
      WHERE DATE_FORMAT(A.tgl_penjualan,'%Y-%m-%d') >= '".$this->input->post('from')."' 
      AND DATE_FORMAT(A.tgl_penjualan,'%Y-%m-%d') < DATE_ADD('".$this->input->post('to')."', INTERVAL 1 DAY)
    ")->result_array();

    $data['from'] = $this->input->post('from');
    $data['to'] = $this->input->post('to');

    $this->pdf->setPaper('A4', 'landscape');
    $this->pdf->filename = "ctk_penjualan.pdf";
    $this->pdf->load_view('report/ctk_penjualan', $data);
  }

}
?>