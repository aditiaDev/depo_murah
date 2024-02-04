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

  public function loadRecord($rowno=0){
 
    $rowperpage = 15;

    if($rowno != 0){
      $rowno = ($rowno-1) * $rowperpage;
    }

    $allcount = $this->db->count_all('tb_barang');

    // $this->db->limit($rowperpage, $rowno);
    $dtList = $this->db->query("SELECT * FROM tb_barang 
    WHERE id_kategori_barang LIKE '%".$this->input->get('kategori')."%'
    AND nm_barang LIKE '%".$this->input->get('barang')."%' LIMIT $rowno, $rowperpage
    ")->result();
    $row="";
    foreach($dtList as $dtBarang){
      $row .= '<div class="col-lg-4 col-sm-6">
                <div class="single_product_item">
                    <img src="'.base_url().'assets/images/barang/'.$dtBarang->foto_barang.'" alt="">
                    <div class="single_product_text">
                        <h4>'.$dtBarang->nm_barang.'</h4>
                        <h3 style="font-weight: bold;color:#2168c8;">RP. '.number_format($dtBarang->harga_barang, 0, ',', '.').'</h3>';
                        
                          $lst_stock = $this->db->query("
                            SELECT A.id_cabang, A.nm_cabang, IFNULL(SUM(stock),0) jml_stock FROM tb_cabang A
                            LEFT JOIN tb_stock_cabang B ON A.id_cabang = B.id_cabang 
                            AND id_barang='".$dtBarang->id_barang."'
                            GROUP BY A.id_cabang, A.nm_cabang
                          ")->result();
                          $class="";
                          foreach($lst_stock as $dtStock){
                            if($dtStock->jml_stock <= 0){
                              $class = 'class="txtCoret"';
                            }
                            $row .= '<p style="line-height: 1.5;" '.$class.' >Toko '.$dtStock->nm_cabang.' ('.$dtStock->jml_stock.')</p>';
                         } 
            $row .= '</div>
                </div>
              </div>';
    }

    $config['base_url'] = base_url().'welcome/loadRecord';
    $config['use_page_numbers'] = TRUE;
    $config['total_rows'] = $allcount;
    $config['per_page'] = $rowperpage;

    $config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination">';
    $config['full_tag_close']   = '</ul></nav></div>';
    $config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
    $config['num_tag_close']    = '</span></li>';
    $config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
    $config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
    $config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
    $config['next_tag_close']  = '<span aria-hidden="true"></span></span></li>';
    $config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
    $config['prev_tag_close']  = '</span></li>';
    $config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
    $config['first_tag_close'] = '</span></li>';
    $config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
    $config['last_tag_close']  = '</span></li>';

    $this->pagination->initialize($config);

    $data['pagination'] = $this->pagination->create_links();
    $data['result'] = $row;
    $data['row'] = $rowno;

    echo json_encode($data);
  }

}