<link href="<?php echo base_url(); ?>assets/datatable/datatables.min.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>assets/toastr/toastr.min.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>assets/select2/css/select2.min.css" rel="stylesheet">
<?php print_r($cabang); ?>
<div class="right_col" role="main">
  <div class="">

    <div class="row">
      <div class="col-md-12 col-sm-12  ">
        <div class="x_panel">
          <div class="x_title">
            <h2>Input Barang Masuk</h2>
            <ul class="nav navbar-right panel_toolbox">
              <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
              </li>
              <li><a class="close-link"><i class="fa fa-close"></i></a>
              </li>
            </ul>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">

            <form id="FRM_DATA">

              <div class="row">
                <div class="col-sm-3">
                  <div class="form-group">
                    <label>ID Transaksi</label>
                    <input type="text" class="form-control" name="id_barang_masuk" value="<New>" readonly>
                  </div>
                </div>
                <div class="col-sm-3">
                  <div class="form-group">
                    <label>Tanggal</label>
                    <input type="text" class="form-control" name="tgl_masuk" value="<?= date('Y-m-d') ?>" readonly>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Cabang</label>
                    <div>
                    <input type="text" name="id_cabang" class="form-control" value="<?= $cabang[0]->id_cabang ?>" readonly style="width:20%;float:left;margin-right: 10px;">
                    <input type="text" name="nm_cabang" class="form-control" value="<?= $cabang[0]->nm_cabang ?>" readonly style="max-width: 60%;">
                    </div>
                  </div>
                </div>
                <div class="col-sm-3">
                  <div class="form-group">
                    <label>Dokumen Tipe</label>
                    <select name="doc_tipe" class="form-control" required>
                      <option value="" selected disabled>Pilih</option>
                      <option value="PEMBELIAN">Pembelian</option>
                      <option value="SAMPLE">Sample dari Vendor</option>
                      <option value="LAIN-LAIN">Lain-lain</option>
                    </select>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Keterangan</label>
                    <textarea name="ket" rows="3" class="form-control"></textarea>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-sm-12">
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th style="text-align: center;">ID Barang</th>
                        <th></th>
                        <th style="text-align: center;">Nama Barang</th>
                        <th style="text-align: center;">Jumlah</th>
                        <th style="text-align: center;">Harga</th>
                        <th style="text-align: center;">Total</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td style="width: 200px;"><input type="text" name="id_barang" class="form-control" required readonly></td>
                        <td style="width:50px;text-align: center;"><button type="button" id="btnBarang" class="btn btn-secondary"><i class="fa fa-list"></i></button></td>
                        <td class="brgdesc"></td>
                        <td style="width: 200px;"><input type="text" name="jumlah" onchange="calculateSubTotal()" readonly required class="form-control"></td>
                        <td style="width: 200px;"><input type="text" name="harga" onchange="calculateSubTotal()" readonly required class="form-control"></td>
                        <td style="width: 200px;"><input type="text" name="subtotal" class="form-control" readonly></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              
              <div class="ln_solid"></div>
              <div class="form-group row">
                <div class="col-md-12" style="text-align:center;">
                  <button type="button" class="btn btn-warning" id="btnCancel">Cancel</button>
                  <button type="submit" class="btn btn-success" id="btnSimpan">Simpan</button>
                </div>
              </div>
            </form>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade bs-example-modal-lg" id="modal_barang" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Data Barang</h4>
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table table-bordered" id="tb_barang">
          <thead>
            <tr>
              <th>ID Barang</th>
              <th>Kategori</th>
              <th>Nama Barang</th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>
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
  $("#btnBarang").click(function(){
    REFRESH_BARANG()
    $("#modal_barang").modal('show')
  })

  function REFRESH_BARANG(){
    $('#tb_barang').DataTable().destroy();
    tb_barang =  $("#tb_barang").DataTable({
        "order": [[ 1, "asc" ],[ 0, "asc" ]],
        "pageLength": 25,
        "autoWidth": false,
        "responsive": true,
        "ajax": {
            "url": "<?php echo site_url('barang/getAllData') ?>",
            "type": "POST",
        },
        "columns": [
            { "data": "id_barang", className: "text-center" },
            { "data": "nm_kategori" },
            { "data": "nm_barang"},
        ]
      }
    )
  }

  $('body').on( 'dblclick', '#tb_barang tbody tr', function (e) {
      let Rowdata = tb_barang.row( this ).data();
      let id_barang = Rowdata.id_barang;
      let nm_barang = Rowdata.nm_barang;
      let harga_barang = Rowdata.harga_barang;

      $("[name='id_barang']").val(id_barang)
      $(".brgdesc").text(nm_barang)
      $("[name='harga']").val(harga_barang)

      $("[name='harga']").attr('readonly', false)
      $("[name='jumlah']").attr('readonly', false)
      $("[name='jumlah']").val('')
      $("[name='subtotal']").val('')
      
      $('#modal_barang').modal('hide');
  });

  function calculateSubTotal(){
    let jumlah = parseFloat($("[name='jumlah']").val())
    let harga = parseFloat($("[name='harga']").val())

    let  subTotal = jumlah * harga
    $("[name='subtotal']").val(subTotal)
  }

  $("#FRM_DATA").submit(function(){
    event.preventDefault()
    if($("[name='id_barang']").val() == ""){
      alert("Pilih Barang")
      return
    }

    let formData = $("#FRM_DATA").serialize();
    $.ajax({
      url: "<?php echo site_url('barang_masuk/saveData') ?>",
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
        // console.log(data)
        if (data.status == "success") {
          toastr.info(data.message)
          setTimeout(() => {
            window.location = "<?php echo base_url("transaksi/barang_masuk")?>"
          }, 3000);

        }else{
          toastr.error(data.message)
        }
      }
    })
  })
</script>