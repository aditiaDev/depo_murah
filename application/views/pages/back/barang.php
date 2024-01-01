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
                  <th>#</th>
                      <th>Kategori</th>
                      <th>ID Barang</th>
                      <th>Nama Barang</th>
                      <th>Harga</th>
                      <th>Point Barang</th>
                      <th width="110px;">Action</th>
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
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form id="FRM_DATA">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel">Modal title</h4>
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          
            
            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label>Kategori</label>
                  <select name="id_kategori_barang" id="" class="form-control">
                    <option value="" disabled selected> - Pilih - </option>
                    <?php
                      foreach($kategori as $kat){
                        echo "<option value='".$kat->id_kategori_barang."'>".$kat->nm_kategori."</option>";
                      }
                    ?>
                  </select>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label>Nama Barang</label>
                  <input type="text" class="form-control" name="nm_barang" >
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label>Harga</label>
                  <input name="harga_barang"  class="form-control" onkeypress="return onlyNumberKey(event)" required>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label id="lbl_foto">Foto Produk</label>
                  <div class="custom-file">
                    <input type="file" class="form-control" name="foto_barang" accept="image/png, image/gif, image/jpeg">
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label>Point Barang</label>
                  <input name="point_barang"  class="form-control" onkeypress="return onlyNumberKey(event)" required>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-sm-12">
                <div class="form-group">
                  <label>Deskripsi</label>
                  <textarea name="deskripsi" rows="5" class="form-control"></textarea>
                </div>
              </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" id="BTN_SAVE" class="btn btn-primary">Save changes</button>
        </div>
      </form>
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

    $(function(){
      REFRESH_DATA()
    })

  function REFRESH_DATA(){
    $('#tb_data').DataTable().destroy();
    tb_data =  $("#tb_data").DataTable({
        "order": [[ 1, "asc" ], [ 2, "asc" ]],
        "pageLength": 25,
        "autoWidth": false,
        "responsive": true,
        "ajax": {
            "url": "<?php echo site_url('barang/getAllData') ?>",
            "type": "POST",
        },
        "columns": [
            {
              "className":      'dt-control',
              "orderable":      false,
              "data":           null,
              "defaultContent": ''
            },
            { "data": "nm_kategori" },
            { "data": "id_barang" },
            { "data": "nm_barang"},
            { "data": "harga_barang",
              "render": function(data){
                return formatRupiah(data.toString(), "")
              }
            },
            { "data": "point_barang"},
            { "data": null, 
              "render" : function(data){
                return "<button class='btn btn-sm btn-warning' title='Edit Data' onclick='editData("+JSON.stringify(data)+");'><i class='fa fa-pencil-square-o'></i> </button> "+
                  "<button class='btn btn-sm btn-danger' title='Hapus Data' onclick='deleteData(\""+data.id_barang+"\");'><i class='fa fa-trash'></i> </button>"
              },
              className: "text-center"
            },
        ]
      }
    )
  }

  function format ( d ) {
    // `d` is the original data object for the row
    console.log(d)
    if(d.foto_barang){
      img = "<a target='_blank' href='<?php echo base_url() ?>assets/images/barang/"+d.foto_barang+"'><img  style='max-width: 120px;' class='img-fluid' src='<?php echo base_url() ?>assets/images/barang/"+d.foto_barang+"' ></a>";
    }else{
      img = "No Image"
    }
    return '<table class="table table-bordered" style="width:450px;">'+
        '<tr>'+
            '<td style="width:80px;">Photo:</td>'+
            '<td>'+img+'</td>'+
        '</tr>'+
        '<tr>'+
            '<td>Harga:</td>'+
            '<td>'+d.deskripsi+'</td>'+
        '</tr>'+
    '</table>';
  }

  $('#tb_data tbody').on('click', 'td.dt-control', function () {
      var tr = $(this).closest('tr');
      var row = tb_data.row( tr );

      if ( row.child.isShown() ) {
          // This row is already open - close it
          row.child.hide();
          tr.removeClass('shown');
      }
      else {
          // Open this row
          row.child( format(row.data()) ).show();
          tr.addClass('shown');
      }
  } );

  $("#add_data").click(function(){
    $("#FRM_DATA")[0].reset()
    save_method = "save"
    $("#modal_add .modal-title").text('Tambah Data')
    $("#modal_add").modal('show')
  })

  $("#FRM_DATA").on('submit', function(event){
    event.preventDefault();
    let formData = new FormData(this);

    
    if(save_method == 'save') {
        urlPost = "<?php echo site_url('barang/saveData') ?>";
    }else{
        urlPost = "<?php echo site_url('barang/updateData/') ?>"+id_data;
    }
    // console.log(formData)
    ACTION(urlPost, formData)
    // $("#modal_add").modal('hide')
  })

  function editData(data, index){
    console.log(data)
    save_method = "edit"
    id_data = data.id_barang;
    $("[name='foto_barang']").val('')
    $("#lbl_foto").text("Ganti Foto")
    $("#modal_add .modal-title").text('Edit Data')
    $("[name='id_barang']").val(data.id_barang)
    $("[name='nm_barang']").val(data.nm_barang)
    $("[name='harga_barang']").val(data.harga_barang.replaceAll(".",""))
    $("[name='id_kategori_barang']").val(data.id_kategori_barang)
    $("[name='deskripsi']").val(data.deskripsi)
    $("[name='point_barang']").val(data.point_barang)

    $("#modal_add").modal('show')
  }
  
  function ACTION(urlPost, formData){
    $.ajax({
      url: urlPost,
      type: "POST",
      data: formData,
      beforeSend: function(){
        $("#LOADER").show();
      },
      complete: function(){
        $("#LOADER").hide();
      },
      processData : false,
      cache: false,
      contentType : false,
      success: function(data){
        data = JSON.parse(data)
        console.log(data)
        if (data.status == "success") {
          toastr.info(data.message)
          REFRESH_DATA()
          $("#modal_add").modal('hide')

        }else{
          toastr.error(data.message)
        }
      },
      error: function (err) {
        console.log(err);
      }
    })
  }

  function deleteData(id){
    if(!confirm('Delete this data?')) return

    urlPost = "<?php echo site_url('barang/deleteData') ?>";
    formData = "id_barang="+id
    
    $.ajax({
        url: urlPost,
        type: "POST",
        data: formData,
        dataType: "JSON",
        success: function(data){
          // console.log(data)
          if (data.status == "success") {
            toastr.info(data.message)
            

            REFRESH_DATA()

          }else{
            toastr.error(data.message)
          }
        }
    })
  }
</script>