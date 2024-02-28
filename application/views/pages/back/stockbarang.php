<link href="<?php echo base_url(); ?>assets/datatable/datatables.min.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>assets/toastr/toastr.min.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>assets/select2/css/select2.min.css" rel="stylesheet">
<a href="javascript:;" id="add_data" class="float" data-toggle="tooltip" data-placement="left" title="Tambah Data">
  <i class="fa fa-plus my-float"></i>
</a>
<div class="right_col" role="main">
  <div class="">

    <div class="row">
      <div class="col-md-12 col-sm-12  ">
        <div class="x_panel">
          <div class="x_title">
            <h2>Data Stock Barang</h2>
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
              <div class="col-md-12">
                <table class="table table-bordered table-hover table-striped" id="tb_data">
                  <thead>
                    <th>Cabang</th>
                    <th>ID Barang</th>
                    <th>Nama Barang</th>
                    <th>Harga</th>
                    <th>Stock</th>
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
<script>
  $(function() {
    REFRESH_DATA()
  })

  function REFRESH_DATA() {
    $('#tb_data').DataTable().destroy();
    tb_data = $("#tb_data").DataTable({
      "order": [
        [0, "asc"],
        [2, "asc"]
      ],
      "pageLength": 25,
      "autoWidth": false,
      "responsive": true,
      "ajax": {
        "url": "<?php echo site_url('stockbarang/getStockCabang') ?>",
        "type": "POST",
      },
      "columns": [{
          "data": "nm_cabang"
        },
        {
          "data": "id_barang"
        },
        {
          "data": "nm_barang"
        },
        {
          "data": "harga_barang",
          "render": function(data) {
            return formatRupiah(data.toString(), "")
          }
        },
        {
          "data": "stock"
        },
      ]
    })
  }
</script>