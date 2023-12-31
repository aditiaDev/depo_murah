<link href="<?php echo base_url(); ?>assets/datatable/datatables.min.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>assets/toastr/toastr.min.css" rel="stylesheet">

<div class="right_col" role="main">
  <div class="">

    <div class="row">
      <div class="col-md-12 col-sm-12  ">
        <div class="x_panel">
          <div class="x_title">
            <h2>Data Perhitungan SMARTER</h2>
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
                  <input type="text" class="form-control" name="tahun" value="<?= date('Y') ?>" placeholder="Masukkan Tahun Pencarian" onkeypress="return onlyNumberKey(event)" maxlength="4">
                  <div class="input-group-btn">
                    <button type="button" class="btn btn-secondary no-border" id="btnTampil" style="margin-left: 5px;">
                      <i class="ace-icon fa fa-search icon-on-right bigger-110"></i> Tampilkan
                    </button>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <span id="result"></span>
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
    
    $.ajax({
      url: "<?php echo site_url('penilaian/getPerhitunganSPK') ?>",
      data: {
        tahun: $("[name='tahun']").val()
      },
      type: "POST",
      dataType: "HTML",
      success: function(data){
        console.log(data)
        $("#result").html(data)
      }
    })
  })

  
</script>