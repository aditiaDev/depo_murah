<div class="col-md-3 left_col">
  <div class="left_col scroll-view">
    <div class="navbar nav_title" style="border: 0;">
      <!-- <a href="index.html" class="site_title"><i class="fa fa-paw"></i> <span>Gentelella Alela!</span></a> -->
      <a href="index.html" class="site_title"><img src="<?php echo base_url(); ?>assets/images/icon.jpg" class="img-circle" style="max-width: 45px;"> 
        <span>DEPO MURAH</span>
      </a>
    </div>

    <div class="clearfix"></div>

    <!-- menu profile quick info -->
    <div class="profile clearfix">
      <div class="profile_pic">
        <img src="<?php echo base_url(); ?>assets/images/img.jpg" alt="..." class="img-circle profile_img">
      </div>
      <div class="profile_info">
        <span>Selamat Datang,</span>
        <h2><?= $this->session->userdata('nm_pengguna') ?></h2>
      </div>
      <div class="clearfix"></div>
    </div>
    <!-- /menu profile quick info -->

    <br />

    <!-- sidebar menu -->
    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
      <div class="menu_section">

        <ul class="nav side-menu">
          <li class="<?= ($this->uri->segment(1) == 'home' || $this->uri->segment(1) == '') ? 'current-page' : '' ?>"><a href="<?php echo base_url("home")?>"><i class="fa fa-home"></i> Home</a></li>
          <li class="<?= ($this->uri->segment(1) == 'master') ? 'current-page' : '' ?>">
            <a><i class="fa fa-desktop"></i> Master Data <span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
              <li><a href="<?php echo base_url("master/user")?>">User</a></li>
              <li><a href="<?php echo base_url("master/cabang")?>">Cabang</a></li>
              <li><a href="<?php echo base_url("master/kategori")?>">Kategori</a></li>
              <li><a href="<?php echo base_url("master/barang")?>">Barang</a></li>
              <li><a href="<?php echo base_url("master/pelanggan")?>">Pelanggan</a></li>
            </ul>
          </li>

          <li class="<?= ($this->uri->segment(1) == 'transaksi') ? 'current-page' : '' ?>">
            <a><i class="fa fa-shopping-cart"></i> Transaksi <span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
              <li><a href="<?php echo base_url("transaksi/penjualan")?>">Penjualan</a></li>
              <li><a href="<?php echo base_url("transaksi/datapenjualan")?>">Data Penjualan</a></li>
            </ul>
          </li>
          
        </ul>
      </div>

    </div>
    <!-- /sidebar menu -->

    <!-- /menu footer buttons -->
    <div class="sidebar-footer hidden-small">
      <a data-toggle="tooltip" data-placement="top" title="Settings">
        <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
      </a>
      <a data-toggle="tooltip" data-placement="top" title="FullScreen">
        <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
      </a>
      <a data-toggle="tooltip" data-placement="top" title="Lock">
        <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
      </a>
      <a data-toggle="tooltip" data-placement="top" title="Logout" href="<?php echo base_url("login/logout")?>">
        <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
      </a>
    </div>
    <!-- /menu footer buttons -->
  </div>
</div>