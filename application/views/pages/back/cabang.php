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
            <h2>Data Cabang</h2>
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
                    <th class="text-center">ID Cabang</th>
                    <th class="text-center">Nama Cabang</th>
                    <th class="text-center">Alamat</th>
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
            <label>Nama Cabang</label>
            <input type="text" class="form-control" name="nm_cabang">
          </div>
          <!-- <div class="form-group">
            <label>Kepala cabang</label>
            <select name="id_user" class="form-control select2" style="width:100%"></select>
          </div>
          <div class="form-group">
            <label>Nama Kepala cabang</label>
            <input type="text" class="form-control" name="nm_kepala_toko">
          </div> -->
          <div class="form-group">
            <label>Alamat cabang</label>
            <textarea class="form-control" name="alamat_cabang"></textarea>
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
<script src="<?php echo base_url(); ?>assets/toastr/toastr.min.js"></script>
<script src="<?php echo base_url(); ?>assets/select2/js/select2.min.js"></script>
<script>

  var save_method;
  var id_data;
  var tb_data;

  $(document).ready(function () {
    REFRESH_DATA()
  })

  select_id_user = $("[name='id_user']").select2({
    placeholder: "Pilih",
  })
  
  // ISI_SELECT()
  function ISI_SELECT(){
    $.ajax({
      url: "<?php echo site_url('cabang/getUserKepala') ?>",
      type: "POST",
      dataType: "JSON",
      success: function(data){
        let row='<option value="" disabled selected>Pilih</option>'
        $.map(data.data, function (item) {
          row += "<option value='"+item.id_user+"' dtl='"+item.nm_pengguna+"'>"+item.id_user+" - "+item.nm_pengguna+"</option>"
        })
        $("[name='id_user']").html(row)
      }
    })
  }

  $("[name='id_user']").change(function(){
    let nm_kepala = $("[name='id_user'] option:selected").attr('dtl')
    $("[name='nm_kepala_toko']").val(nm_kepala)
  })

  $("#add_data").click(function(){
    select_id_user.val('').trigger('change')
    $("#FRM_DATA")[0].reset()
    save_method = "save"
    $("#modal_add .modal-title").text('Tambah Data')
    $("#modal_add").modal('show')
  })

  $("#BTN_SAVE").click(function(){
    event.preventDefault();
    var formData = $("#FRM_DATA").serialize();
    if(save_method == 'save') {
        urlPost = "<?php echo site_url('cabang/saveData') ?>";
    }else{
        urlPost = "<?php echo site_url('cabang/updateData') ?>";
        formData+="&id_cabang="+id_data
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
            "url": "<?php echo site_url('cabang/getAllData') ?>",
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
            { "data": "id_cabang", className: "text-center" },
            { "data": "nm_cabang"},
            { "data": "alamat_cabang"},
            // { "data": null,
            //     render: function(data){
            //         return data.id_user+"</br>"+data.nm_kepala_toko
            //     }
            // },
            { "data": null, 
              "render" : function(data){
                return "<button class='btn btn-sm btn-warning' title='Edit Data' onclick='editData("+JSON.stringify(data)+");'>Edit </button> "+
                  "<button class='btn btn-sm btn-danger' title='Hapus Data' onclick='deleteData(\""+data.id_cabang+"\");'>Hapus </button>"
              },
              className: "text-center"
            },
        ]
      }
    )
  }


  function editData(data){
    // console.log(data)
    save_method = "edit"
    id_data = data.id_cabang;
    $("#modal_add .modal-title").text('Edit Data')
    $("[name='nm_cabang']").val(data.nm_cabang)
    $("[name='alamat_cabang']").val(data.alamat_cabang)
    // select_id_user.val(data.id_user).trigger('change')
    // $("[name='nm_kepala_toko']").val(data.nm_kepala_toko)

    $("#modal_add").modal('show')
  }

  function deleteData(id){
    if(!confirm('Delete this data?')) return

    urlPost = "<?php echo site_url('cabang/deleteData') ?>";
    formData = "id_cabang="+id
    ACTION(urlPost, formData)
  }
</script>