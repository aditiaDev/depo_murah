<?php
class Penjualan extends CI_Controller {

    public function __construct(){
        parent::__construct();
    
        if(!$this->session->userdata('id_user'))
          redirect('login', 'refresh');

    }

	public function index()
	{
    $this->db->order_by("nm_kategori", "asc");
    $data['kategori'] = $this->db->get('tb_kategori_barang')->result();

		$this->load->view('template/back/header');
    $this->load->view('template/back/sidebar');
    $this->load->view('template/back/topnav');
    $this->load->view('pages/back/penjualan', $data);
    $this->load->view('template/back/footer');

	}

  public function datapenjualan(){
    $this->load->view('template/back/header');
    $this->load->view('template/back/sidebar');
    $this->load->view('template/back/topnav');
    $this->load->view('pages/back/datapenjualan');
    $this->load->view('template/back/footer');
  }

  public function generateId(){
    $unik = 'J'.date('y');
    $kode = $this->db->query("SELECT MAX(id_penjualan) LAST_NO FROM tb_penjualan WHERE id_penjualan LIKE '".$unik."%'")->row()->LAST_NO;
    // mengambil angka dari kode barang terbesar, menggunakan fungsi substr
    // dan diubah ke integer dengan (int)
    $urutan = (int) substr($kode, 3, 5);
    
    // bilangan yang diambil ini ditambah 1 untuk menentukan nomor urut berikutnya
    $urutan++;
    
    $huruf = $unik;
    $kode = $huruf . sprintf("%05s", $urutan);
    return $kode;
  }

  public function generateIdBarangKeluar(){
    $unik = 'K'.date('y');
    $kode = $this->db->query("SELECT MAX(id_barang_keluar) LAST_NO FROM tb_barang_keluar WHERE id_barang_keluar LIKE '".$unik."%'")->row()->LAST_NO;

    $urutan = (int) substr($kode, 3, 5);
    $urutan++;
    
    $huruf = $unik;
    $kode = $huruf . sprintf("%05s", $urutan);
    return $kode;
  }

  public function saveCheckout(){
    $this->load->library('form_validation');

    $this->form_validation->set_rules('id_pelanggan', 'Pelanggan', 'required');
    $this->form_validation->set_rules('id_barang[]', 'Barang', 'required');

    
    if($this->form_validation->run() == FALSE){
      // echo validation_errors();
      $output = array("status" => "error", "message" => validation_errors());
      echo json_encode($output);
      return false;
    }

    $id_cabang = $this->db->query("
      SELECT id_cabang FROM tb_user WHERE id_user = '".$this->session->userdata('id_user')."'
    ")->row()->id_cabang;

    foreach($this->input->post('id_barang') as $key => $each){
      $stock = $this->db->query(
        "SELECT IFNULL(sum(stock), 0) stock FROM tb_stock_cabang WHERE id_barang = '".$this->input->post('id_barang')[$key]."' 
        AND id_cabang = '".$id_cabang."'" 
      )->row()->stock;

      if($stock < $this->input->post('qty')[$key]){
        $output = array("status" => "error", "message" => "Stock untuk ".$this->input->post('id_barang')[$key]." hanya ".$stock);
        echo json_encode($output);
        return false;
      }
    }

    $id = $this->generateId();
    
    $data = array(
              "id_penjualan" => $id,
              "tgl_penjualan" => date('Y-m-d H:i:s'),
              "id_pelanggan" => $this->input->post('id_pelanggan'),
              "id_cabang" => $id_cabang,
              "diskon" => $this->input->post('jml_point'),
              "tot_harga_barang" => $this->input->post('tot_harga_barang'),
              "tot_akhir" => $this->input->post('tot_akhir'),
              "created_by" => $this->session->userdata('id_user'),
              // "status_penjualan" => "SELESAI"
            );
    $this->db->insert('tb_penjualan', $data);

    if( $this->input->post('id_pelanggan') <> "GUEST" ){
      $this->db->query("
        UPDATE tb_pelanggan SET point_pelanggan	 = ( point_pelanggan	 - ".$this->input->post('jml_point')." )
        WHERE id_pelanggan = '".$this->input->post('id_pelanggan')."'
      ");

      
    }
    

    $subtotal = 0;
    foreach($this->input->post('id_barang') as $key => $each){
      $subtotal = ( $this->input->post('qty')[$key] * $this->input->post('harga')[$key] );


      $dataDtl = array(
        "id_penjualan" => $id,
        "id_barang" => $this->input->post('id_barang')[$key],
        "jumlah" => $this->input->post('qty')[$key],
        "harga_barang" => $this->input->post('harga')[$key],
        "subtotal" => $subtotal,
      );

      $this->db->insert('tb_dtl_penjualan', $dataDtl);

      if( $this->input->post('id_pelanggan') <> "GUEST" ){
        $point_barang = $this->db->query("
              SELECT point_barang FROM tb_barang WHERE id_barang = '".$this->input->post('id_barang')[$key]."'
        ")->row()->point_barang;

        $this->db->query("
          UPDATE tb_pelanggan SET point_pelanggan = ( point_pelanggan + ".$point_barang." )
          WHERE id_pelanggan = '".$this->input->post('id_pelanggan')."'
        ");
      }

      // $id_barang_keluar = $this->generateIdBarangKeluar();

      // $dataDtl2 = array(
      //   "id_barang_keluar" => $id_barang_keluar,
      //   "doc_referensi" => $id,
      //   "doc_tipe" => "PENJUALAN",
      //   "tgl_barang_keluar" => date('Y-m-d H:i:s'),
      //   "id_barang" => $this->input->post('id_barang')[$key],
      //   "jumlah" => $this->input->post('qty')[$key],
      //   "harga" => $this->input->post('harga')[$key],
      // );

      // $this->db->insert('tb_barang_keluar', $dataDtl2);

      $this->db->query("
        UPDATE tb_stock_cabang SET stock = ( stock - ".$this->input->post('qty')[$key]." ) 
        WHERE id_barang = '".$this->input->post('id_barang')[$key]."' AND id_cabang = '".$id_cabang."'
      ");
      
    }
    
    $output = array("status" => "success", "message" => "Data Berhasil Disimpan</br>No Penjualan ".$id, "id" => $id,);
    echo json_encode($output);
  }

  public function getAllData(){
    $id_cabang = $this->db->query("
      SELECT id_cabang FROM tb_user WHERE id_user = '".$this->session->userdata('id_user')."'
    ")->row()->id_cabang;

    $data['data'] = $this->db->query("
      select A.id_penjualan, A.tgl_penjualan, B.nm_pelanggan,   
      C.nm_cabang, A.diskon, A.tot_harga_barang, A.tot_akhir 
      from tb_penjualan A
      left join tb_pelanggan B on A.id_pelanggan = B.id_pelanggan 
      left join tb_cabang C on A.id_cabang = C.id_cabang 
      where A.id_cabang = '".$id_cabang."'
    ")->result();
    echo json_encode($data);
  }

  public function deleteData(){
    $id_penjualan = $this->input->post('id_penjualan');
    $id_cabang = $this->db->query("
      SELECT id_cabang FROM tb_user WHERE id_user = '".$this->session->userdata('id_user')."'
    ")->row()->id_cabang;

    $query = "SELECT id_barang, jumlah FROM tb_dtl_penjualan WHERE id_penjualan = '".$id_penjualan."'";
    $sql = $this->db->query($query)->result_array();
    foreach($sql as $row){
      $this->db->query("
        UPDATE tb_stock_cabang SET 
        stock = stock + ".$row['jumlah']." 
        WHERE id_barang = '".$row['id_barang']."' 
        AND id_cabang = '".$id_cabang."'
      ");
    }
    
    $this->db->where('id_penjualan', $id_penjualan);
    $this->db->delete('tb_penjualan');

    $this->db->where('id_penjualan', $id_penjualan);
    $this->db->delete('tb_dtl_penjualan');

    $output = array("status" => "success", "message" => "Data Berhasil di Hapus");
    echo json_encode($output);
  }

}
?>