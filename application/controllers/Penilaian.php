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
      A.id_pelanggan, B.nm_pelanggan, A.jml_pembelian, A.intensitas_pembelian, 
      E.sub_kriteria jumlah_pembelian, F.sub_kriteria intens_pembelian, 
      C.sub_kriteria sikap_pembeli, D.sub_kriteria pengantaran
      FROM tb_real_kriteria_pelanggan A
      LEFT JOIN tb_pelanggan B ON A.id_pelanggan = B.id_pelanggan 
      LEFT JOIN tb_sub_kriteria C ON C.id_sub_kriteria = A.KR003
      LEFT JOIN tb_sub_kriteria D ON D.id_sub_kriteria = A.KR004

      LEFT JOIN tb_sub_kriteria E ON E.id_sub_kriteria = A.KR001
      LEFT JOIN tb_sub_kriteria F ON F.id_sub_kriteria = A.KR002
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

      $jml_pembelian = $this->input->post('jml_pembelian')[$key];
      if($jml_pembelian > 75){
        $KR001 = "SK001";
      }elseif($jml_pembelian >= 51 AND $jml_pembelian <= 75){
        $KR001 = "SK002";
      }elseif($jml_pembelian >= 26 AND $jml_pembelian <= 50){
        $KR001 = "SK003";
      }else{
        $KR001 = "SK004";
      }

      $intensitas_pembelian = $this->input->post('intensitas_pembelian')[$key];
      if($intensitas_pembelian > 15){
        $KR002 = "SK005";
      }elseif($intensitas_pembelian >= 11 AND $intensitas_pembelian <= 15){
        $KR002 = "SK006";
      }elseif($intensitas_pembelian >= 6 AND $intensitas_pembelian <= 10){
        $KR002 = "SK007";
      }else{
        $KR002 = "SK008";
      }


      $data = array(
        "id_pelanggan" => $this->input->post('id_pelanggan')[$key],
        "tahun" => $this->input->post('tahun'),
        "jml_pembelian" => $this->input->post('jml_pembelian')[$key],
        "intensitas_pembelian" => $this->input->post('intensitas_pembelian')[$key],
        "KR001" => $KR001,
        "KR002" => $KR002,
        "KR003" => $this->input->post('sikap_pembeli')[$key],
        "KR004" => $this->input->post('cara_antar')[$key],
      );
      $this->db->insert('tb_real_kriteria_pelanggan', $data);
    }
    
    
    $output = array("status" => "success", "message" => "Data Berhasil Disimpan");
    echo json_encode($output);
  }

  public function perhitungan(){
    $this->load->view('template/back/header');
    $this->load->view('template/back/sidebar');
    $this->load->view('template/back/topnav');
    $this->load->view('pages/back/perhitungan');
    $this->load->view('template/back/footer');
  }

  public function getPerhitunganSPK(){
    $tahun = $this->input->post('tahun');

    $arr = [];
    $dthitungBobot = $this->db->query("
      SELECT A.id_kriteria, COUNT(B.id_sub_kriteria) JML_KRITERIA
      FROM tb_kriteria A
      INNER JOIN tb_sub_kriteria B ON A.id_kriteria = B.id_kriteria
      GROUP BY A.id_kriteria
      ORDER BY A.id_kriteria
    ")->result_array();
    $a=0;
    $b=0;
    foreach($dthitungBobot as $row){
      $id_kriteria = $row['id_kriteria'];
      $jml_subKriteria = $row['JML_KRITERIA'];
      $b=$b+1;
      $bobotKriteria = 0;
      $c=0;
      for ($i=$a; $i < $jml_subKriteria; $i++) { 

        $rumus = 1/$b;
        $bobotKriteria += $rumus;
        $arr['data'][$a]['id_kriteria'] = $id_kriteria;
        $arr['data'][$a]['bobot'] = round($bobotKriteria/$jml_subKriteria,3);
        $b++;
        $c++;
        
      }
      
      $a++;
      $b=$a;
    }

    // echo "<pre>";
    // print_r($arr);
    // echo "</pre>";

    foreach($arr['data'] as $row){

      $query = "UPDATE tb_kriteria SET bobot = '".$row['bobot']."' 
      WHERE id_kriteria = '".$row['id_kriteria']."'";
      $this->db->query($query);
    }

    $dtsub_kriteria = $this->db->query("
      SELECT id_kriteria, id_sub_kriteria FROM tb_sub_kriteria
      ORDER BY id_kriteria, id_sub_kriteria
    ")->result_array();

    $i=0;
    foreach($dtsub_kriteria as $row){
      
      $query = "UPDATE tb_sub_kriteria SET bobot = '".$arr['data'][$i]['bobot']."' 
      WHERE id_kriteria = '".$row['id_kriteria']."' AND id_sub_kriteria = '".$row['id_sub_kriteria']."'";
      $this->db->query($query);

      if($i < (count($arr['data']) - 1)){
        $i++;
      }else{
        $i=0;
      }
      
    }


    $html = "";
    $thKriteria = "";
    $dtKriteria = $this->db->query("
      SELECT id_kriteria, kriteria FROM tb_kriteria 
      ORDER BY id_kriteria
    ")->result_array();

    foreach($dtKriteria as $row){
      $thKriteria .= "<th>".$row['id_kriteria']."</br>".$row['kriteria']."</th>";
    }

    $html="<p style='margin-bottom: 0px;font-weight:bold;'>Nilai Real Kriteria Pelanggan</p>
          <table class='table table-bordered' style='text-align:center;'>
            <thead>
              <tr>
                <th>ID Pelanggan</th>
                <th>Nama Pelanggan</th>
                ".$thKriteria."
              </tr>
            </thead>
            <tbody>";
    $dtPelanggan = $this->db->query("
    SELECT 
    A.id_pelanggan, B.nm_pelanggan, 
    E.sub_kriteria jumlah_pembelian, F.sub_kriteria intensitas_pembelian, 
    C.sub_kriteria sikap_pembeli, D.sub_kriteria pengantaran,
    E.bobot bobot_jml_beli, F.bobot bobot_intens_beli,
    C.bobot bobot_sikap, D.bobot bobot_antar 
    FROM tb_real_kriteria_pelanggan A
    LEFT JOIN tb_pelanggan B ON A.id_pelanggan = B.id_pelanggan 
    LEFT JOIN tb_sub_kriteria E ON E.id_sub_kriteria = A.KR001
    LEFT JOIN tb_sub_kriteria F ON F.id_sub_kriteria = A.KR002
    LEFT JOIN tb_sub_kriteria C ON C.id_sub_kriteria = A.KR003
    LEFT JOIN tb_sub_kriteria D ON D.id_sub_kriteria = A.KR004
    where tahun = '".$this->input->post('tahun')."'
    ORDER BY A.id_pelanggan
    ")->result_array();

    $arr2 = [];
    foreach($dtPelanggan as $row){

      $arr2['KR001'][] = $row['bobot_jml_beli'] ;
      $arr2['KR002'][] = $row['bobot_intens_beli'] ;
      $arr2['KR003'][] = $row['bobot_sikap'] ;
      $arr2['KR004'][] = $row['bobot_antar'] ;
      
      $html .= "<tr>
                  <td>".$row['id_pelanggan']."</td>
                  <td>".$row['nm_pelanggan']."</td>
                  <td>".$row['jumlah_pembelian']."</td>
                  <td>".$row['intensitas_pembelian']."</td>
                  <td>".$row['sikap_pembeli']."</td>
                  <td>".$row['pengantaran']."</td>
              </tr>";
    }

    $html .= "</tbody></table>";

    $i=0;
    foreach ($arr['data'] as $row) {
      $id_kriteria = $row['id_kriteria'];
      $arr['data'][$i]['max'] = max($arr2[$id_kriteria]) ;
      $arr['data'][$i]['min'] = min($arr2[$id_kriteria]) ;
      $i++;
    }

    //   echo "<pre>";
    // print_r($arr);
    // echo "</pre>";


    $html .= "Tabel Normalisasi dan Utility Setiap Kriteria
    <table class='table table-bordered' style='text-align:center;'>
      <thead>
        <tr>
          <th rowspan='2'>ID Pelanggan</th>
          <th rowspan='2'>Nama Pelanggan</th>
          <th colspan='4'>Normalisasi Nilai</th>
          <th colspan='4'>Nilai Utility</th>
        </tr>
        <tr>
        ".$thKriteria.$thKriteria."
        </tr>
      </thead>
      <tbody>";

      $arr3 = [];
      $a=0;
      foreach ($dtPelanggan as $row) {

          if($arr['data'][0]['max'] - $arr['data'][0]['min'] == 0){
            $pembagi0 = 0;
            $U1 = 0;
          }else{
            $pembagi0 = $arr['data'][0]['max'] - $arr['data'][0]['min'];
            $U1 = ($row['bobot_jml_beli'] - $arr['data'][0]['min']) / $pembagi0;
          }

          if($arr['data'][1]['max'] - $arr['data'][1]['min'] == 0){
            $pembagi1 = 0;
            $U2 = 0;
          }else{
            $pembagi1 = $arr['data'][1]['max'] - $arr['data'][1]['min'];
            $U2 = ($row['bobot_intens_beli'] - $arr['data'][1]['min']) / $pembagi1;
          }

          if($arr['data'][2]['max'] - $arr['data'][2]['min'] == 0){
            $pembagi2 = 0;
            $U3 = 0;
          }else{
            $pembagi2 = $arr['data'][2]['max'] - $arr['data'][2]['min'];
            $U3 = ($row['bobot_sikap'] - $arr['data'][2]['min']) / $pembagi2;
          }

          if($arr['data'][3]['max'] - $arr['data'][3]['min'] == 0){
            $pembagi3 = 0;
            $U4 = 0;
          }else{
            $pembagi3 = $arr['data'][3]['max'] - $arr['data'][3]['min'];
            $U4 = ($row['bobot_antar'] - $arr['data'][3]['min']) / $pembagi3;
          }

          // $arr3['KR001'][$a] = $U1 * $arr['data'][0]['bobot'];
          // $arr3['KR002'][$a] = $U2 * $arr['data'][1]['bobot'];
          // $arr3['KR003'][$a] = $U3 * $arr['data'][2]['bobot'];
          // $arr3['KR004'][$a] = $U4 * $arr['data'][3]['bobot'];
      
          $arr3[$row['id_pelanggan']]['KR001'] = $U1 * $arr['data'][0]['bobot'];
          $arr3[$row['id_pelanggan']]['KR002'] = $U2 * $arr['data'][1]['bobot'];
          $arr3[$row['id_pelanggan']]['KR003'] = $U3 * $arr['data'][2]['bobot'];
          $arr3[$row['id_pelanggan']]['KR004'] = $U4 * $arr['data'][3]['bobot'];

          $arr3[$row['id_pelanggan']]['TOTAL'] = ($U1 * $arr['data'][0]['bobot']) + ($U2 * $arr['data'][1]['bobot']) + ($U3 * $arr['data'][2]['bobot']) + ($U4 * $arr['data'][3]['bobot']);
        $html .= "<tr>
                    <td>".$row['id_pelanggan']."</td>
                    <td>".$row['nm_pelanggan']."</td>
                    <td>".$row['bobot_jml_beli']."</td>
                    <td>".$row['bobot_intens_beli']."</td>
                    <td>".$row['bobot_sikap']."</td>
                    <td>".$row['bobot_antar']."</td>
                    <td>".$U1."</td>
                    <td>".$U2."</td>
                    <td>".$U3."</td>
                    <td>".$U4."</td>
                  </tr>";
        
        $a++;
      }

      $html .= "</tbody></table>";

      $html .= "Nilai Akhir Smarter
                <table class='table table-bordered' style='text-align:center;'>
                  <thead>
                    <tr>
                      <th>ID Pelanggan</th>
                      <th>Nama Pelanggan</th>
                      ".$thKriteria."
                    </tr>
                  </thead>
                  <tbody>";

      $html .= "</tbody></table>";

      echo "<pre>";
      print_r($arr3);
      echo "</pre>";
    // echo $html;
    
  }

}
?>