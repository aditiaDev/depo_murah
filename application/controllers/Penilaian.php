<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penilaian extends CI_Controller {

    public function __construct(){
        parent::__construct();
    
        // if(!$this->session->userdata('id_user'))
        //   redirect('login', 'refresh');
    }

	public function index(){
    $this->db->order_by("id_kriteria", "asc");
    $data['kriteria'] = $this->db->get('tb_kriteria')->result();

    $this->load->view('template/back/header');
    $this->load->view('template/back/sidebar');
    $this->load->view('template/back/topnav');
    $this->load->view('pages/back/penilaian', $data);
    $this->load->view('template/back/footer');
	}

  public function getPenilaianByYear(){
    $data['data'] = $this->db->query("
      SELECT 
      A.id_pelanggan, B.nm_pelanggan, 
      A.KR001, A.KR002, C.sub_kriteria sikap_pembeli, D.sub_kriteria pengantaran
      FROM tb_real_kriteria_pelanggan A
      LEFT JOIN tb_pelanggan B ON A.id_pelanggan = B.id_pelanggan 
      LEFT JOIN tb_sub_kriteria C ON C.id_sub_kriteria = A.KR003
      LEFT JOIN tb_sub_kriteria D ON D.id_sub_kriteria = A.KR004
      where tahun = '".$this->input->post('tahun')."'
      ORDER BY A.id_pelanggan
    ")->result();
    echo json_encode($data);
  }

  public function getPenilaian(){
    $data = $this->db->query("
      SELECT 
      A.id_pelanggan, A.nm_pelanggan, 
      SUM(IFNULL(C.jumlah,0)) jml_pembelian,
      COUNT(DISTINCT B.id_penjualan) intensitas_pembelian
      FROM tb_pelanggan A
      LEFT JOIN tb_penjualan B ON A.id_pelanggan = B.id_pelanggan
      LEFT JOIN tb_dtl_penjualan C ON B.id_penjualan = C.id_penjualan
      WHERE A.id_pelanggan <> 'GUEST'
      AND DATE_FORMAT(B.tgl_penjualan, '%Y') = '".$this->input->post('tahun')."'
      GROUP BY A.id_pelanggan, A.nm_pelanggan
      ORDER BY A.id_pelanggan
    ")->result();
    
    $sub_kriteria = $this->db->query("
      SELECT 
      id_sub_kriteria, sub_kriteria
      FROM tb_sub_kriteria
      WHERE id_kriteria = 'KR003'
    ")->result();
    $optSubKriteria = '<option value="" selected disabled>Pilih</option>';
    foreach($sub_kriteria as $sk){
      $optSubKriteria .= '<option value="'.$sk->id_sub_kriteria.'">'.$sk->sub_kriteria.'</option>';
    }

    $cara_antar = $this->db->query("
      SELECT 
      id_sub_kriteria, sub_kriteria
      FROM tb_sub_kriteria
      WHERE id_kriteria = 'KR004'
    ")->result();
    $optCaraAntar = '<option value="" selected disabled>Pilih</option>';
    foreach($cara_antar as $ca){
      $optCaraAntar .= '<option value="'.$ca->id_sub_kriteria.'">'.$ca->sub_kriteria.'</option>';
    }

    $html="";
    $no=1;
    foreach($data as $row){
      $html .= '<tr>
                  <td>'.$no++.'</td>
                  <td>
                    '.$row->id_pelanggan.'<br>'.$row->nm_pelanggan.'
                    <input type="hidden" name="id_pelanggan[]" value="'.$row->id_pelanggan.'">
                  </td>
                  <td>
                    '.$row->jml_pembelian.'
                    <input type="hidden" name="jml_pembelian[]" value="'.$row->jml_pembelian.'">
                  </td>
                  <td>
                    '.$row->intensitas_pembelian.'
                    <input type="hidden" name="intensitas_pembelian[]" value="'.$row->intensitas_pembelian.'">
                  </td>
                  <td>
                    <select class="form-control" name="sikap_pembeli[]" required>'.$optSubKriteria.'</select>
                  </td>
                  <td>
                    <select class="form-control" name="cara_antar[]" required>'.$optCaraAntar.'</select>
                  </td>
                </tr>';
    }
    echo $html;
  }

  public function inputpenilaian(){
    $this->db->order_by("id_kriteria", "asc");
    $data['kriteria'] = $this->db->get('tb_kriteria')->result();

    $this->load->view('template/back/header');
    $this->load->view('template/back/sidebar');
    $this->load->view('template/back/topnav');
    $this->load->view('pages/back/inputpenilaian', $data);
    $this->load->view('template/back/footer');
	}

  public function saveRealKriteriaPelanggan(){
    $this->load->library('form_validation');
    $this->form_validation->set_rules('tahun', 'tahun', 'required');

    if($this->form_validation->run() == FALSE){

      $output = array("status" => "error", "message" => validation_errors());
      echo json_encode($output);
      return false;
    }

    $this->db->query("DELETE FROM tb_real_kriteria_pelanggan WHERE tahun = '".$this->input->post('tahun')."'");

    foreach($this->input->post('id_pelanggan') as $key => $each){
      $data = array(
        "id_pelanggan" => $this->input->post('id_pelanggan')[$key],
        "tahun" => $this->input->post('tahun'),
        "KR001" => $this->input->post('jml_pembelian')[$key],
        "KR002" => $this->input->post('intensitas_pembelian')[$key],
        "KR003" => $this->input->post('sikap_pembeli')[$key],
        "KR004" => $this->input->post('cara_antar')[$key],
      );
      $this->db->insert('tb_real_kriteria_pelanggan', $data);
    }
    
    
    $output = array("status" => "success", "message" => "Data Berhasil Disimpan");
    echo json_encode($output);
  }

}
?>