<link href="<?php echo base_url(); ?>assets/datatable/datatables.min.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>assets/toastr/toastr.min.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>assets/select2/css/select2.min.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>assets/css/cssku.css" rel="stylesheet">
<style>
  .form-control {
    display: block;
    width: 100%;
    /* height: calc(1.5em + 0.75rem + 2px); */
    padding: 0.335rem 0.5rem;
    font-size: 13px;
    font-weight: 400;
    line-height: 1.5;
    color: #495057;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #ced4da;
    border-radius: 0.25rem;
    transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
  }
</style>
<div class="right_col" role="main">
  <div class="">

    <div class="row">
      <div class="col-md-12">
        <div class="x_panel">
          <div class="x_content">
            <form id="FRM_DATA">
              <div class="row">
                <div class="col-md-5" style="padding-left: 1px;padding-right: 1px;">
                  <div style="overflow-y: auto;height:400px;">
                    <table id="tb_item" class="table table-bordered table-hover">
                      <thead>
                        <tr style="background-color: #e9ecef;">
                          <th style="width: 270px;">Item</th>
                          <th style="width:80px;">Qty</th>
                          <th>Harga</th>
                          <th style="width:100px;">Sub Total</th>
                        </tr>
                      </thead>
                      <tbody>

                      </tbody>
                    </table>
                  </div>

                  <div>
                    <table class="table table-bordered">
                      <tbody>
                        <tr>
                          <td style="width: 150px;font-size: 14px;font-weight: bold;">No Nota</td>
                          <td colspan="2">
                            <input type="text" name="id_penjualan" style="float:left;width:50%;" class="form-control" readonly>
                            <button type="button" class="btn btn-sm btn-secondary" id="BTN_NOTA" ><i class="fa fa-search"></i></button>
                          </td>
                        </tr>
                        <tr>
                          <td style="font-size: 14px;font-weight: bold;">Total</td>
                          <td colspan="2" style="text-align:right;padding-right: 25px;font-weight: bold;font-family: fantasy;font-size: 14px;" id="total_text">0</td>
                        </tr>
                        <tr>
                          <td style="font-size: 14px;font-weight: bold;">Pelanggan</td>
                          <td style="min-width: 150px;">
                            <input type="text" class="form-control" value="GUEST" name="id_pelanggan" style="float:left;width:70%;" placeholder="Kode Pelanggan">
                            <button type="button" class="btn btn-sm btn-secondary" id="BTN_PELANGGAN" ><i class="fa fa-list"></i></button>
                          </td>
                          <td id="nm_pelanggan" style="font-size:15px;">Non Member</td>
                        </tr>
                        <tr>
                          <td></td>
                          <td style="font-size:15px;">Point Pelanggan</td>
                          <!-- <td><input type="number" name="jml_point" onchange="diskon_calculate()" readonly class="form-control" value="0"></td> -->
                          <td><input type="number" name="jml_point"  readonly class="form-control" value="0"></td>
                        </tr>
                        <tr>
                          <td  style="font-size: 18px;font-weight: bold;">Total Akhir</td>
                          <td colspan="2" style="color:red;text-align:right;padding-right: 25px;font-weight: bold;font-family: fantasy;font-size: 25px;" id="order_text">0</td>
                        </tr>
                        <!-- <tr>
                          <td  style="font-size: 14px;font-weight: bold;">Pembayaran</td>
                          <td colspan="2">
                            <select name="tipe_bayar" id="tipe_bayar" class="form-control">
                              <option value="TUNAI">Tunai</option>
                              <option value="NON TUNAI">Non Tunai</option>
                            </select>
                          </td>
                        </tr> -->
                        <tr class="tunai" >
                          <td  style="font-size: 14px;font-weight: bold;">Bayar</td>
                          <td colspan="2"><input type="text" name="bayar"  class="form-control"></td>
                        </tr>
                        <tr class="tunai" >
                          <td  style="font-size: 14px;font-weight: bold;">Kembali</td>
                          <td colspan="2" style="text-align:right;padding-right: 25px;font-weight: bold;font-family: fantasy;font-size: 14px;" id="kembali_text">0</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <div>
                    <div class="col-md-4" style="padding: 0px;">
                      <button class="btn btn-warning btn-block"  id="btnCancel"><i class="ace-icon fa fa-times bigger-160"></i> Batal</button>
                    </div>
                    <div class="col-md-4" style="padding: 0px;">
                      <button class="btn btn-light btn-block" id="btnPrint"><i class="ace-icon fa fa-print bigger-160"></i> Cetak Struk</button>
                    </div>
                    <div class="col-md-4" style="padding: 0px;">
                      <button class="btn btn-danger btn-block" id="btnPay"><i class="ace-icon fa fa-shopping-cart bigger-160"></i> Bayar</button>
                    </div>
                  </div>

                </div>

                <div class="col-md-2" style="overflow-y: auto;height:550px;padding-left: 1px;padding-right: 1px;">
                  <button type="button" class="btn-danger block btn-kat" onclick="actKategori('ALL')">ALL</button>
                  <?php foreach($kategori as $kat){ ?>
                    <button type="button" class="btn-danger block btn-kat" onclick="actKategori('<?= $kat->id_kategori_barang  ?>')"><?= $kat->nm_kategori ?></button>
                  <?php } ?>
                </div>

                <div class="col-md-5" style="padding-left: 1px;padding-right: 1px;">
                  <div class="input-group">
                    <input type="text" class="form-control" name="keywords" placeholder="Cari Barang">
                    <div class="input-group-btn">
                      <button type="button" class="btn btn-sm btn-secondary no-border " id="btnSearch">
                        <i class="ace-icon fa fa-search icon-on-right bigger-110"></i>
                      </button>
                    </div>
                  </div>
                  <div>
                    <ul class="ace-thumbnails clearfix" id="item_data">

                    </ul>
                  </div>
                </div>

              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    
    
  </div>
</div>


<!-- Modal Pelanggan -->
<div class="modal fade" id="modal_pelanggan"  role="dialog"  aria-hidden="true">
  <div class="modal-dialog" role="document" style="width:700px">
    <!-- <form id="form_item"> -->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel">Pilih Pelanggan</h4>
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <table class="table table-bordered table-hover table-striped" id="tb_select_pelanggan">
                  <thead>
                      <th>ID Pelanggan</th>
                      <th>Nama</th>
                      <th>Jumlah Point</th>
                  </thead>
                  <tbody>
                  </tbody>
              </table>
          </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    <!-- </form> -->
  </div>
</div>
<!-- Modal Pelanggan -->


<div class="modal fade" id="modalNota"  role="dialog"  aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document" >
    <!-- <form id="form_item"> -->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" >Pilih Nota</h4>
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <table class="table table-bordered table-hover table-striped" id="tb_select_nota">
                  <thead>
                      <th>No Nota</th>
                      <th>Tanggal Transaksi</th>
                      <th>Pelanggan</th>
                      <th>Penginput</th>
                  </thead>
                  <tbody>
                  </tbody>
              </table>
          </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    <!-- </form> -->
  </div>
</div>


<!-- Modal Sikap -->
<div class="modal fade" id="modal_sikap" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog" role="document" style="width:700px">
    <!-- <form id="form_item"> -->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" >Perilaku Pembeli</h4>
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="FRM_SIKAP">
            <div class="form-group">
              <label>Sikap Pelanggan</label>
              <select name="id_sub_kriteria" class="form-control">
                <option value="" selected disabled>Pilih</option>
                <?php
                  foreach($sub_kriteria as $sk){
                    echo "<option value='".$sk->id_sub_kriteria."'>".$sk->sub_kriteria."</option>";
                  }
                ?>
              </select>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" id="btnPerilaku">Simpan</button>
        </div>
      </div>
    <!-- </form> -->
  </div>
</div>
<!-- Modal Sikap -->

<!-- <form id="payment-form" method="post" action="<?=site_url()?>snap/finish">
  <input type="hidden" name="result_type" id="result-type" value=""></div>
  <input type="hidden" name="result_data" id="result-data" value=""></div>
</form> -->

<script src="<?php echo base_url(); ?>assets/template/back/jquery/dist/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/toastr/toastr.min.js"></script>
<script src="<?php echo base_url(); ?>assets/select2/js/select2.min.js"></script>
<script>
  var max_point_pelanggan
  var table_find_pelanggan
  var table_find_nota

  $("#BTN_NOTA").click(function(){
    $('#tb_select_nota').DataTable().destroy();
    table_find_nota = $('#tb_select_nota').DataTable( {
        "order": [[ 1, "asc" ]],
        "pageLength": 25,
        "autoWidth": false,
        "responsive": true,
        "ajax": {
            "url": "<?php echo site_url('penjualan/getIdPenjualan') ?>",
            "type": "POST",
        },
        "columns": [
            { "data": "id_penjualan" },{ "data": "tgl_penjualan" },{ "data": "nm_pelanggan" },{ "data": "nm_pengguna" }
        ]
    });

    $("#modalNota").modal('show')
  })

  $('body').on( 'click', '#tb_select_nota tbody tr', function (e) {
      let Rowdata = table_find_nota.row( this ).data();
      let id_penjualan = Rowdata.id_penjualan;

      $("[name='id_penjualan']").val(id_penjualan)
      $("#modalNota").modal('hide')
  })

  function actKategori(id_kategori_barang){
    $.ajax({
      url: "<?php echo site_url('barang/getByKategori') ?>",
      type: "POST",
      data: {
        id_kategori_barang
      },
      dataType: "HTML",
      success: function(data){
        // console.log(data)
        $("#item_data").html(data)
      }
    })
  }

  var noRow=0
  function addItem(id_barang){

    var ITEM_NO = $(".i_barang");

    for (var i = 0; i <ITEM_NO.length; i++) {
      if ($(".i_barang").eq(i).text() == id_barang) {
        let jml = parseFloat( $("[name='qty[]']").eq(i).val() )
        $("[name='qty[]']").eq(i).val(jml+1)
        subTotal(i)
        return
      }
    }
    
    $.ajax({
      url: "<?php echo site_url('barang/getBarangById') ?>",
      type: "POST",
      data: {
        id_barang
      },
      beforeSend: function(){
        $("#LOADER").fadeIn(300);
      },
      complete: function(){
        $("#LOADER").fadeOut(500);
      },
      // dataType: "JSON",
      success: function(data){
        // console.log(data)
        var t_data;
        
        datane = $.parseJSON(data);
        data = datane['data'];
        
        $.each(data, function(index,array){
          // console.log(noRow);
          
          t_data += '<tr id="row_'+noRow+'">'+
                      '<td ><span class="i_barang"><input type="hidden" name="id_barang[]" value="'+array['id_barang']+'" >'+array['id_barang']+'</span><button type="button" onClick="deleteRow(\''+noRow+'\')" class="bootbox-close-button close modClose" >×</button><br>'+array['nm_barang']+'</td>'+
                      '<td style="padding-left: 3px;padding-right: 3px;"><input type="text" name="qty[]" id="qty_'+noRow+'" onChange="subTotal(\''+noRow+'\')" class="form-control qty" style="padding: 10px 5px;" value="1"></td>'+
                      '<td style="text-align:right;" id="harga_'+noRow+'" class="harga"><input type="hidden" name="harga[]" value="'+array['harga_barang']+'" >'+formatRupiah(array['harga_barang'], '')+'</td>'+
                      '<td style="text-align:right;" id="subTotal_'+noRow+'" class="subTotal">'+formatRupiah(array['harga_barang'], '')+'</td>'+
                    '</tr>'

                    noRow = noRow+1;
        });
        $("#tb_item tbody").append(t_data);
        total()
      }
    })
  }

  function subTotal(id){
    // console.log(id)
    // let qty = $("#qty_"+id).val().split('.').join('');
    // let harga = $("#harga_"+id).text().split('.').join('');
    

    // let subTotal = ( parseFloat(qty) * parseFloat(harga) ) 
    // $("#subTotal_"+id).text(formatRupiah(subTotal.toString(), ''))

    let qty = $("[name='qty[]']").eq(id).val().split('.').join('');
    let harga = $(".harga").eq(id).text().split('.').join('');
    

    let subTotal = ( parseFloat(qty) * parseFloat(harga) ) 
    $(".subTotal").eq(id).text(formatRupiah(subTotal.toString(), ''))

    total()
  }

  function total(){
    var tot=0; var subTotal=0;
    var jml_part = $("[name='qty[]']").length - 1;
    for (var j = 0; j <= jml_part; j++) {
        subTotal = $(".subTotal").eq(j).text().split('.').join('');
        tot += parseFloat(subTotal);

    }

    $("#total_text").text(formatRupiah(tot.toString(), ''));
    $("#order_text").text(formatRupiah(tot.toString(), ''));
  }

  $("#BTN_PELANGGAN").click(function(){
    if($("#tb_item tbody tr").length < 1){
      alert("Pilih Barang yg akan di Jual")
      return
    }
    $('#tb_select_pelanggan').DataTable().destroy();
    table_find_pelanggan = $('#tb_select_pelanggan').DataTable( {
          "order": [[ 1, "asc" ]],
          "pageLength": 25,
          "autoWidth": false,
          "responsive": true,
          "ajax": {
              "url": "<?php echo site_url('pelanggan/getPelanggan') ?>",
              "type": "POST",
          },
          "columns": [
              { "data": "id_pelanggan" },{ "data": "nm_pelanggan" },{ "data": "point_pelanggan" }
          ]
      });

    $("#modal_pelanggan").modal('show');
  });

  $('body').on( 'dblclick', '#tb_select_pelanggan tbody tr', function (e) {
      let Rowdata = table_find_pelanggan.row( this ).data();
      let id_pelanggan = Rowdata.id_pelanggan;
      let nm_pelanggan = Rowdata.nm_pelanggan;
      let point_pelanggan = Rowdata.point_pelanggan;

      max_point_pelanggan = Rowdata.point_pelanggan;

      // if(jml_point >= min_point){
      //   $("[name='jml_point']").attr('readonly', false)
      // }else{
      //   $("[name='jml_point']").attr('readonly', true)
      // }

      $("[name='jml_point']").attr('readonly', false)

      $("[name='id_pelanggan']").val(id_pelanggan);
      $("#nm_pelanggan").text(nm_pelanggan);
      $("[name='jml_point']").val(point_pelanggan);

      // diskon_calculate()

      $('#tb_select_pelanggan').DataTable().destroy();
      
      $('#modal_pelanggan').modal('hide');

      
  });

  function diskon_calculate(){
    
    let tot_barang = $("#total_text").text().split('.').join('');
    let jml_point = $("[name='jml_point']").val()

    if( jml_point > max_point_pelanggan ){
      alert("Point yg anda input melebihi jumlah point pelanggan")
      $("[name='jml_point']").val(max_point_pelanggan)
      return
    }

    let order_value = parseFloat(tot_barang) - parseFloat(jml_point)
    $("#order_text").text(formatRupiah(order_value.toString(), ''));
  }

  function deleteRow(id){
    $("#row_"+id).remove();
    total()
  }

  $("#btnSearch").click(function(){
    $.ajax({
      url: "<?php echo site_url('barang/getByName') ?>",
      type: "POST",
      data: {
        search : $("[name='keywords']").val()
      },
      dataType: "HTML",
      success: function(data){
        // console.log(data)
        $("#item_data").html(data)
      }
    })
  })

  $("[name='bayar']").change(function(){
    $(this).val(formatRupiah($(this).val().toString(), ''))

    let bayar = $(this).val().split('.').join('');

    let order_val = $("#order_text").text().split('.').join('');

    if(parseFloat(bayar) < parseFloat(order_val)){
      alert("Uang kurang")
      $(this).val("")
      return
    }

    let kembali = parseFloat(bayar) - parseFloat(order_val)
    $("#kembali_text").text(formatRupiah(kembali.toString(), ''));
  })

  $("#btnPay").click(function(){
    event.preventDefault()

    if($("[name='qty[]']").length == 0){
      alert("Belum ada Item di keranjang")
      return
    }

    if( $("#tipe_bayar").val() == "TUNAI" && $("[name='bayar']").val() == ""){
      alert("Input Uang Pembayaran")
      return
    }

    let tot_harga_barang = $("#total_text").text().split('.').join('');
    let tot_akhir = $("#order_text").text().split('.').join('');
    let frmData = $("#FRM_DATA").serialize()
    frmData+="&tot_harga_barang="+tot_harga_barang+"&tot_akhir="+tot_akhir

    $.ajax({
      url: "<?php echo site_url('penjualan/saveCheckout') ?>",
      type: "POST",
      dataType: "JSON",
      data: frmData,
      beforeSend: function () {
        $("#LOADER").fadeIn(300);
      },
      complete: function () {
        $("#LOADER").fadeOut(500);
      },
      success: function(data){
        // console.log(data)
        if (data.status == "success") {
          toastr.info(data.message)
          afterSave()
          $("[name='no_nota']").val(data.id)
          $("[name='id_penjualan']").val(data.id)
          
          if($("[name='id_pelanggan']").val() != "GUEST"){
            $("#modal_sikap").modal('show')
          }
          
          
          setTimeout(() => {
            cetak(data.id)
          }, 1000);
          
        }else{
          toastr.error(data.message)
        }
      }
    })
  })

  function afterSave(){
    $("[name='qty[]']").attr('disabled',true)
    $("#BTN_PELANGGAN").attr('disabled',true)
    $("[name='jml_point']").attr('disabled',true)
    $("[name='bayar']").attr('disabled',true)
    $("#btnPay").attr('disabled',true)
    $(".btn-kat").attr('disabled',true)
  }

  $("#btnPrint").click(function(){
    event.preventDefault()
    let id_penjualan = $("[name='id_penjualan']").val()
    if(id_penjualan == ""){
      alert('Masukkan Nomor Nota')
      return
    }
    cetak(id_penjualan)
  })

  function cetak(id){
    var form = document.createElement("form");
    $(form).attr("action", "<?php echo site_url('report/ctkStruk') ?>")
            .attr("method", "post")
            .attr("target", "_blank");
    $(form).html('<input type="hidden" name="id_penjualan" value="'+id+'" />');
    document.body.appendChild(form);
    $(form).submit();
    document.body.removeChild(form);
  }

  $("#btnPerilaku").click(function(){
    event.preventDefault()
    frmData = $("#FRM_SIKAP").serialize()
    frmData += "&id_pelanggan="+$("[name='id_pelanggan']").val()+"&id_penjualan="+$("[name='id_penjualan']").val()
    $.ajax({
      url: "<?php echo site_url('penjualan/savePerilaku') ?>",
      type: "POST",
      dataType: "JSON",
      data: frmData,
      beforeSend: function () {
        $("#LOADER").fadeIn(300);
      },
      complete: function () {
        $("#LOADER").fadeOut(500);
      },
      success: function(data){
        
        if (data.status == "success") {
          toastr.info(data.message)
          $("#modal_sikap").modal('hide')
        }else{
          toastr.error(data.message)
        }
      }
    })
  })
</script>