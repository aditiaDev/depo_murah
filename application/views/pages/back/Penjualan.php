<link href="<?php echo base_url(); ?>assets/datatable/datatables.min.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>assets/toastr/toastr.min.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>assets/select2/css/select2.min.css" rel="stylesheet">
<style>
  .block {
    display: block;
    width: 100%;
    border: none;
    background-color: #04AA6D;
    padding: 14px 28px;
    font-size: 16px;
    cursor: pointer;
    text-align: center;
    margin: 0px;
  }

  .block:hover {
    background-color: #ddd;
    color: black;
  }

  .modClose {
    float: right;
    font-size: 34px;
    color: #f5002b;
    text-shadow: 0 1px 0 #fff;
    opacity: 1;
    filter: alpha(opacity=20);
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
                        <tr>
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
                          <td  style="width: 150px;font-size: 14px;font-weight: bold;">Total</td>
                          <td colspan="2" style="text-align:right;padding-right: 25px;font-weight: bold;font-family: fantasy;font-size: 14px;" id="total_text">0</td>
                        </tr>
                        <tr>
                          <td style="font-size: 14px;font-weight: bold;">Pelanggan</td>
                          <td style="min-width: 150px;">
                            <input type="text" class="form-control" value="GUEST" name="id_pelanggan" style="float:left;width:70%;" placeholder="Kode Pelanggan">
                            <button type="button" class="btn btn-secondary" id="BTN_PELANGGAN" ><i class="fa fa-list"></i></button>
                          </td>
                          <td id="nm_pelanggan" style="font-size:15px;">Non Member</td>
                        </tr>
                        <tr>
                          <td></td>
                          <td style="font-size:15px;">Point Pelanggan</td>
                          <td><input type="number" name="jml_point" onchange="diskon_calculate()" readonly class="form-control" value="0"></td>
                        </tr>
                        <tr>
                          <td  style="font-size: 18px;font-weight: bold;">Order Value</td>
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
                      <button class="btn btn-warning btn-block"  id="btnCancel"><i class="ace-icon fa fa-times bigger-160"></i> Cancel</button>
                    </div>
                    <div class="col-md-4" style="padding: 0px;">
                      <button class="btn btn-light btn-block" id="btnPrint"><i class="ace-icon fa fa-print bigger-160"></i> Print</button>
                    </div>
                    <div class="col-md-4" style="padding: 0px;">
                      <button class="btn btn-danger btn-block" id="btnPay"><i class="ace-icon fa fa-shopping-cart bigger-160"></i> Pay</button>
                    </div>
                  </div>

                </div>

                <div class="col-md-2" style="overflow-y: auto;height:550px;padding-left: 1px;padding-right: 1px;">
                  <button type="button" class="btn-danger block" onclick="actKategori('ALL')">ALL</button>
                  <?php foreach($kategori as $kat){ ?>
                    <button type="button" class="btn-danger block" onclick="actKategori('<?= $kat->id_kategori_barang  ?>')"><?= $kat->nm_kategori ?></button>
                  <?php } ?>
                </div>

                <div class="col-md-5" style="padding-left: 1px;padding-right: 1px;">
                  <div class="input-group">
                    <input type="text" class="form-control" name="keywords" placeholder="Cari Barang">
                    <div class="input-group-btn">
                      <button type="button" class="btn btn-secondary no-border " id="btnSearch">
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
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Pilih Pelanggan</h4>
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
                      <tr>
                      </tr>
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

<!-- Modal Cetak -->
<div class="modal fade" id="modal_cetak"  role="dialog"  aria-hidden="true">
  <div class="modal-dialog" role="document" style="width:700px">
    <!-- <form id="form_item"> -->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Masukkan No Penjualan</h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <input type="text" class="form-control" name="no_nota" placeholder="No NOTA">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button class="btn btn-primary" id="okPrint">OK</button>
        </div>
      </div>
    <!-- </form> -->
  </div>
</div>
<!-- Modal Cetak -->

<!-- <form id="payment-form" method="post" action="<?=site_url()?>snap/finish">
  <input type="hidden" name="result_type" id="result-type" value=""></div>
  <input type="hidden" name="result_data" id="result-data" value=""></div>
</form> -->

<script src="<?php echo base_url(); ?>assets/template/back/jquery/dist/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/toastr/toastr.min.js"></script>
<script src="<?php echo base_url(); ?>assets/select2/js/select2.min.js"></script>