<link href="<?php echo base_url(); ?>assets/datatable/datatables.min.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>assets/toastr/toastr.min.css" rel="stylesheet">

<div class="right_col" role="main">
  <div class="">

    <div class="row">
      <div class="col-md-12 col-sm-12  ">
        <div class="x_panel">
          <div class="x_title">
            <h2>Data Penilaian</h2>
            <ul class="nav navbar-right panel_toolbox">
              <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
              </li>
              <li><a class="close-link"><i class="fa fa-close"></i></a>
              </li>
            </ul>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <div class="row">
              <div class="col-md-3">
                <div class="input-group">
                  <input type="text" class="form-control" name="tahun" placeholder="Masukkan Tahun Pencarian" onkeypress="return onlyNumberKey(event)" maxlength="4">
                  <div class="input-group-btn">
                    <button type="button" class="btn btn-secondary no-border" id="btnTampil" style="margin-left: 5px;">
                      <i class="ace-icon fa fa-search icon-on-right bigger-110"></i> Tampilkan
                    </button>
                  </div>
                </div>
              </div>
              <div class="col-md-9">
                <a class="btn btn-info" href="<?php echo base_url("penilaian/inputpenilaian")?>" style="float: right;"><i class="fa fa-plus-square"></i> Input Baru</a>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <table class="table table-bordered table-hover table-striped" id="tb_data">
                  <thead>
                    <th class="text-center">No</th>
                    <th class="text-center">Pelanggan</th>
                    <?php
                      foreach($kriteria as $row){
                        echo '<th class="text-center">'.$row->kriteria.'</th>';
                      }
                    ?>
                  </thead>
                  <tbody></tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="<?php echo base_url(); ?>assets/template/back/jquery/dist/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/toastr/toastr.min.js"></script>
<script>

  $("#btnTampil").click(function(){
    event.preventDefault()

  })
</script>