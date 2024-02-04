<!doctype html>
<html lang="zxx">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Depo Murah</title>
    <link rel="icon" href="<?php echo base_url(); ?>assets/images/icon.jpg">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/template/front/css/bootstrap.min.css">
    <!-- animate CSS -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/template/front/css/animate.css">
    <!-- owl carousel CSS -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/template/front/css/owl.carousel.min.css">
    <!-- font awesome CSS -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/template/front/css/all.css">
    <!-- flaticon CSS -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/template/front/css/flaticon.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/template/front/css/themify-icons.css">
    <!-- font awesome CSS -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/template/front/css/magnific-popup.css">
    <!-- swiper CSS -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/template/front/css/slick.css">
    <!-- style CSS -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/template/front/css/style.css">
    <style>
      .txtCoret {
        font-size: 1rem;
        text-decoration: line-through;
        color: #929292;
        margin-right: 10px;
        font-weight: bold;
        font-size: 16px;
        color: #ff3368;
      }
    </style>
</head>

<body>
<!--::header part start::-->
<header class="main_menu home_menu">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-12">
                    <nav class="navbar navbar-expand-lg navbar-light">
                        <a class="navbar-brand" href="<?php echo base_url("front")?>"> <img src="<?php echo base_url(); ?>assets/images/icon.jpg" alt="logo"> </a>
                        <button class="navbar-toggler" type="button" data-toggle="collapse"
                            data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="Toggle navigation">
                            <span class="menu_icon"><i class="fas fa-bars"></i></span>
                        </button>

                        <div class="collapse navbar-collapse main-menu-item" id="navbarSupportedContent">
                            <ul class="navbar-nav">
                                <li class="nav-item">
                                    <a class="nav-link" href="<?php echo base_url("front")?>">Home</a>
                                </li>

                                <!-- <li class="nav-item">
                                    <a class="nav-link" href="contact.html">Contact</a>
                                </li> -->
                            </ul>
                        </div>
                        <div class="hearer_icon d-flex">
                            <a id="search_1" href="javascript:void(0)"><i class="ti-search"></i></a>
                            <a href="<?php echo base_url("login")?>" title="Login"><i class="fas fa-sign-in-alt"></i></a>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
        <div class="search_input" id="search_input_box">
            <div class="container ">
                <form class="d-flex justify-content-between search-inner">
                    <input type="text" class="form-control" id="search_input" placeholder="Search Here">
                    <button type="submit" class="btn"></button>
                    <span class="ti-close" id="close_search" title="Close Search"></span>
                </form>
            </div>
        </div>
    </header>
    <!-- Header part end-->

    <!--================Home Banner Area =================-->
    <!-- breadcrumb start-->
    <section class="breadcrumb breadcrumb_bg">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="breadcrumb_iner">
                        <div class="breadcrumb_iner_item">
                            <h2 style="color: #ff3368;">Depo Murah</h2>
                            <p>Menjual berbagai bahan bangunan Berkualitas dan Murah</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- breadcrumb start-->

    <!--================Category Product Area =================-->
    <section class="cat_product_area section_padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="left_sidebar_area">
                        <aside class="left_widgets p_filter_widgets">
                            <div class="l_w_title">
                                <h3>Kategori</h3>
                            </div>
                            <div class="widgets_inner">
                                <ul class="list">
                                  <li>
                                      <a href="javascript:;" onclick="actKategori('')">All</a>
                                  </li>
                                  <?php
                                    $l_kategori = $this->db->query("
                                      SELECT id_kategori_barang, nm_kategori FROM tb_kategori_barang ORDER BY nm_kategori
                                    ")->result();
                                    foreach($l_kategori as $dataKat){
                                  ?>
                                    <li>
                                        <a href="javascript:;" onclick="actKategori('<?= $dataKat->id_kategori_barang ?>')"><?= $dataKat->nm_kategori ?></a>
                                    </li>
                                  <?php } ?>
                                </ul>
                            </div>
                        </aside>

                        
                    </div>
                </div>
                <div class="col-lg-9">

                    <div class="row align-items-center latest_product_inner" id="postsList">
                      
                      
                        <!-- <div class="col-lg-12">
                            <div class="pageination">
                                <nav aria-label="Page navigation example">
                                    <ul class="pagination justify-content-center">
                                        <li class="page-item">
                                            <a class="page-link" href="#" aria-label="Previous">
                                                <i class="ti-angle-double-left"></i>
                                            </a>
                                        </li>
                                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                                        <li class="page-item"><a class="page-link" href="#">4</a></li>
                                        <li class="page-item"><a class="page-link" href="#">5</a></li>
                                        <li class="page-item"><a class="page-link" href="#">6</a></li>
                                        <li class="page-item">
                                            <a class="page-link" href="#" aria-label="Next">
                                                <i class="ti-angle-double-right"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div> -->
                    </div>
                    <div id='pagination'></div>
                </div>
            </div>
        </div>
    </section>
    <!--================End Category Product Area =================-->


    <!--::footer_part start::-->
    <footer class="footer_part" style="padding: 0px 0px 25px;">
        <div class="copyright_part">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="copyright_text">
                            <P><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="ti-heart" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></P>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="footer_icon social_icon">
                            <ul class="list-unstyled">
                                <li><a href="#" class="single_social_icon"><i class="fab fa-facebook-f"></i></a></li>
                                <li><a href="#" class="single_social_icon"><i class="fab fa-twitter"></i></a></li>
                                <li><a href="#" class="single_social_icon"><i class="fas fa-globe"></i></a></li>
                                <li><a href="#" class="single_social_icon"><i class="fab fa-behance"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!--::footer_part end::-->

    <!-- jquery plugins here-->
    <script src="<?php echo base_url(); ?>assets/template/front/js/jquery-1.12.1.min.js"></script>
    <!-- popper js -->
    <script src="<?php echo base_url(); ?>assets/template/front/js/popper.min.js"></script>
    <!-- bootstrap js -->
    <script src="<?php echo base_url(); ?>assets/template/front/js/bootstrap.min.js"></script>
    <!-- easing js -->
    <script src="<?php echo base_url(); ?>assets/template/front/js/jquery.magnific-popup.js"></script>
    <!-- swiper js -->
    <script src="<?php echo base_url(); ?>assets/template/front/js/swiper.min.js"></script>
    <!-- swiper js -->
    <script src="<?php echo base_url(); ?>assets/template/front/js/masonry.pkgd.js"></script>
    <!-- particles js -->
    <script src="<?php echo base_url(); ?>assets/template/front/js/owl.carousel.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/template/front/js/jquery.nice-select.min.js"></script>
    <!-- slick js -->
    <script src="<?php echo base_url(); ?>assets/template/front/js/slick.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/template/front/js/jquery.counterup.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/template/front/js/waypoints.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/template/front/js/contact.js"></script>
    <script src="<?php echo base_url(); ?>assets/template/front/js/jquery.ajaxchimp.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/template/front/js/jquery.form.js"></script>
    <script src="<?php echo base_url(); ?>assets/template/front/js/jquery.validate.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/template/front/js/mail-script.js"></script>
    <!-- custom js -->
    <script src="<?php echo base_url(); ?>assets/template/front/js/custom.js"></script>
    <script>
      var kategori=""
      var barang=""
      $('#pagination').on('click','a',function(e){
        e.preventDefault(); 
        var pageno = $(this).attr('data-ci-pagination-page');
        loadPagination(pageno);
      });

      loadPagination(0);

      function loadPagination(pagno){
        $.ajax({
          url: "<?php echo site_url('/front/loadRecord/') ?>"+pagno,
          data: {
            kategori,
            barang
          },
          type: 'get',
          dataType: 'json',
          success: function(response){
            $('#pagination').html(response.pagination);
            // createTable(response.result,response.row);
            $('#postsList').html(response.result)
          }
        });
      }

      function createTable(result,sno){
        sno = Number(sno);var row="";
        for(index in result){
          var content = result[index].nm_barang.replace(/<\/?[^>]+(>|$)/g, "");
          if(content.length > 200)
          content = content.substr(0, 200) + " ...";
          sno+=1;

          row += "<div class='col-lg-4 col-sm-6'>"+
                            "<div class='single_product_item'>"+
                                "<img src='<?php echo base_url(); ?>assets/images/barang/"+result[index].foto_barang+"' >"+
                                "<div class='single_product_text'>"+
                                    "<h4>"+result[index].nm_barang+"</h4>"+
                                    "<h3 style='font-weight: bold;color:#2168c8;'>RP. "+formatRupiah(result[index].harga_barang,'')+"</h3>"+
                                    
                                "</div>"+
                            "</div>"+
                        "</div>"

        }
        $('#postsList').html(row)
      }

      function actSearch(){
        event.preventDefault()
        barang = $("#search_input").val()
        loadPagination(0);
        $("#postsList").focus()
      }

      $('#search_input').keypress(function (e) {
        // alert('asd')
        var key = e.which;
        if(key == 13)  // the enter key code
        {
          actSearch()
          return false;  
        }
      });

      function actKategori(id_kategori){
        kategori=id_kategori
        loadPagination(0);
        $("#postsList").focus()
      }

      /* Fungsi formatRupiah */
      function formatRupiah(angka, prefix){
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
        split   		= number_string.split(','),
        sisa     		= split[0].length % 3,
        rupiah     		= split[0].substr(0, sisa),
        ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);

        // tambahkan titik jika yang di input sudah menjadi angka ribuan
        if(ribuan){
        separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? prefix + rupiah : '');
      }
    </script>
</body>

</html>