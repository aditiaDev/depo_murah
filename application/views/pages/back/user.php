<link href="<?php echo base_url(); ?>assets/datatable/datatables.min.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>assets/toastr/toastr.min.css" rel="stylesheet">
<a href="javascript:;" id="add_data" class="float" data-toggle="tooltip" data-placement="left" title="Tambah Data">
  <i class="fa fa-plus my-float"></i>
</a>
<div class="right_col" role="main">
  <div class="">

    <div class="row">
      <div class="col-md-12 col-sm-12  ">
        <div class="x_panel">
          <div class="x_title">
            <h2>Data User</h2>
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
                    <th class="text-center">No</th>
                    <th class="text-center">ID User</th>
                    <th class="text-center">Nama Pengguna</th>
                    <th class="text-center">Username</th>
                    <th class="text-center">Password</th>
                    <th class="text-center">Level</th>
                    <th class="text-center" style="width:110px">Aksi</th>
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

<div class="modal fade bs-example-modal-lg" id="modal_add" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Modal title</h4>
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="FRM_DATA">
          <div class="form-group">
            <label>Nama Pengguna</label>
            <input type="text" class="form-control" name="nm_pengguna">
          </div>
          <div class="form-group">
            <label>Username</label>
            <input type="text" class="form-control" name="username">
          </div>
          <div class="form-group">
            <label>Password</label>
            <input type="password" class="form-control" name="password">
          </div>
          <div class="form-group">
            <label>Level</label>
            <select name="level" class="form-control">
              <option value="" disabled selected>-- Pilih --</option>
              <option value="ADMIN GUDANG">Admin Gudang</option>
              <option value="KASIR">Kasir</option>
              <option value="KEPALA TOKO">Kepala Toko</option>
              <option value="PEMILIK">Pemilik</option>
            </select>
          </div>

        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" id="BTN_SAVE" class="btn btn-primary">Save changes</button>
      </div>

    </div>
  </div>
</div>
<script src="<?php echo base_url(); ?>assets/template/back/jquery/dist/jquery.min.js"></script>
<!-- <script src="<?php echo base_url(); ?>assets/datatable/datatables.min.js"></script> -->
<script src="<?php echo base_url(); ?>assets/toastr/toastr.min.js"></script>
<script>
  // $.noConflict();
  var save_method;
  var id_data;
  var tb_data;

  $(document).ready(function () {
    REFRESH_DATA()
  })
  

  $("#add_data").click(function(){
    $("#FRM_DATA")[0].reset()
    save_method = "save"
    $("#modal_add .modal-title").text('Tambah Data')
    $("#modal_add").modal('show')
  })

  $("#BTN_SAVE").click(function(){
    event.preventDefault();
    var formData = $("#FRM_DATA").serialize();
    if(save_method == 'save') {
        urlPost = "<?php echo site_url('user/saveData') ?>";
    }else{
        urlPost = "<?php echo site_url('user/updateData') ?>";
        formData+="&id_user="+id_data
    }

    ACTION(urlPost, formData)
    $("#modal_add").modal('hide')
  })

  function ACTION(urlPost, formData){
    $.ajax({
      url: urlPost,
      type: "POST",
      data: formData,
      dataType: "JSON",
      beforeSend: function () {
        $("#overlay").fadeIn(300)
      },
      complete: function () {
        $("#overlay").hide();
      },
      success: function(data){
        console.log(data)
        if (data.status == "success") {
          toastr.info(data.message)
          REFRESH_DATA()

        }else{
          toastr.error(data.message)
        }
      }
    })
  }

  function REFRESH_DATA(){
    $('#tb_data').DataTable().destroy();
    tb_data =  $("#tb_data").DataTable({
        "order": [[ 0, "asc" ]],
        "pageLength": 25,
        "autoWidth": false,
        "responsive": true,
        "ajax": {
            "url": "<?php echo site_url('user/getAllData') ?>",
            "type": "POST",
        },
        "columns": [
            {
                "data": null,
                render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
                , className: "text-center"
            },
            { "data": "id_user", className: "text-center" },
            { "data": "nm_pengguna"},
            { "data": "username"},
            { "data": "password", className: "text-center" },
            { "data": "level"},
            { "data": null, 
              "render" : function(data){
                return "<button class='btn btn-sm btn-warning' title='Edit Data' onclick='editData("+JSON.stringify(data)+");'>Edit </button> "+
                  "<button class='btn btn-sm btn-danger' title='Hapus Data' onclick='deleteData(\""+data.id_user+"\");'>Hapus </button>"
              },
              className: "text-center"
            },
        ]
      }
    )
  }

  function deleteData(id){
    if(!confirm('Delete this data?')) return

    urlPost = "<?php echo site_url('user/deleteData') ?>";
    formData = "id_user="+id
    ACTION(urlPost, formData)
  }
</script>