<div class="right_col" role="main">
  <div class="">

    <div class="row">
      <div class="col-md-6 col-sm-6  ">
        <div class="x_panel">
          <div class="x_title">
            <h2>Data Penjualan</h2>
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
                <form id="FRM_DATA" action="<?php echo base_url('report/ctkPenjualan') ?>" method="POST" target="_blank">
                  <div>
                    <label>
                        Dari
                    </label>
                    <input type="date" name="from" class="form-control rounded-full" />
                  </div>
                  <div>
                    <label>
                        Sampai
                    </label>
                    <input type="date" name="to" class="form-control rounded-full" />
                  </div>
                  <div class="mt-5 text-right">
                    <button class="btn btn-primary rounded-full" id="BTN_PRINT"><i class="fa fa-print"></i> Cetak</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>