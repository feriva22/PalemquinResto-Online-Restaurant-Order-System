<div class="container" style="padding-left: 0px; padding-right: 15px;margin-top:30px;">
<div class="side-panel">
  <div class="panel panel-default-red">
    <div class="panel-heading">
      <h3 class="panel-title">Lengkapi terlebih dahulu form berikut dalam 3 langkah !</h3>
    </div>
    <div class="panel-body">
      <form name="basicform" id="basicform" method="post" >
        
        <div id="sf1" class="frm">
          <fieldset>
            <legend>Langkah 1 dari 3</legend>
            <h4>Informasi Pelanggan</h4>
            <div class="row">
            <div class="form-group col-md-6">
              <label class="col-lg-4 control-label" for="cst_name">Nama Pemesan: </label>
              <div class="col-lg-8">
                <input type="text" placeholder="Nama Pemesanan" id="cst_name" name="cst_name" value="<?php echo $this->session->userdata('name');?>" class="form-control" autocomplete="off">
              </div>
            </div>
            </div>
            <div class="row">
            <div class="form-group col-md-6">
              <label class="col-lg-4 control-label" for="cst_phone">Nomer Handphone : </label>
              <div class="col-lg-8">
                <input type="text" placeholder="Nomor handphone" id="cst_phone" name="cst_phone" class="form-control" value="<?php echo $data['customer']->cst_phone;?>"autocomplete="off">
              </div>
            </div>
            </div>
            <div class="row">
            <div class="form-group col-md-6">
              <label class="col-lg-4 control-label" for="ord_fordate">Pesanan untuk Tanggal  : </label>
              <div class="col-lg-8">
                <div class="input-group date"  id="datepicker">
                    <input size="16" type="text" name="ord_fordate" class="form-control " id="ord_fordate" placeholder="ex :10-10-2019" required>
                    <span class="input-group-addon "><span class= "fa fa-calendar"></span></span>
                </div>
              </div>
            </div>
            </div>
            <div class="row">
            <div class="form-group col-md-6">
            <label class="col-lg-4 control-label" for="ord_time">Jam  : </label>
              <div class="col-lg-8">
                <div class="input-group date" id="timepicker">
                      <input size="16" type="text" name="ord_time" class="form-control " id="ord_time" value="12:00" autocomplete="off" required>
                      <span class="input-group-addon "><span class="fa fa-clock-o "></span></span>
                </div>
              </div>
            </div>
            </div>
            <?php if(!$data['isReservation']):?>
            <div class="row">
            <div class="form-group col-md-6">
              <label class="col-lg-4 control-label" for="inv_delivaddress">Alamat Pengiriman (kosongi jika ingin diambil sendiri): </label>
              <div class="col-lg-8">
                <input type="text" placeholder="contoh : Jln. wahiding mojosari, Mojokerto no 10" id="inv_delivaddress" name="inv_delivaddress" class="form-control" autocomplete="off">
              </div>
            </div>
            </div>
            <?php endif;?>
            <div class="clearfix" style="height: 10px;clear: both;"></div>
            <div class="form-group">
              <div class="col-lg-10 col-lg-offset-2">
                <button class="btn btn-primary" id="open1" type="button">Next <span class="fa fa-arrow-right"></span></button> 
              </div>
            </div>

          </fieldset>
        </div>

        <div id="sf2" class="frm" style="display: none;">
          <fieldset>
            <legend>Step 2 of 3</legend>

            <h4>Pemilihan metode pembayaran</h4>
            <div class="row">
            <div class="form-group col-md-6">
              <label class="col-lg-4 control-label" for="inv_isdp">Pembayaran : </label>
              <div class="col-lg-8">
              <input type="radio" name="inv_isdp"  value="1" > DP <?php echo $data['dp_info']->stg_value.'%';?><br>
              <input type="radio" name="inv_isdp" value="2" > Lunas<br>           
              </div>
            </div>
            </div>
            <div class="row">
            <div class="form-group col-md-6">
              <label class="col-lg-4 control-label" for="inv_paygateway">Metode Pembayaran : </label>
              <div class="col-lg-8">
              
              <select name="inv_paygateway" id="inv_paygateway">
              <?php foreach($data['payment_method'] as $paygateway):?>
                <option value="<?php echo $paygateway->pyg_id;?>"><?php echo $paygateway->pyg_name.'('.$paygateway->pyg_detail.')';?></option>
              <?php endforeach;?>
              </select>
              </div>
            </div>
            </div>

            <div class="clearfix" style="height: 10px;clear: both;"></div>

            <div class="clearfix" style="height: 10px;clear: both;"></div>

            <div class="form-group">
              <div class="col-lg-10 col-lg-offset-2">
                <button class="btn btn-warning back2" type="button"><span class="fa fa-arrow-left"></span> Back</button> 
                <button class="btn btn-primary" id="open2" type="button">Next <span class="fa fa-arrow-right"></span></button> 
              </div>
            </div>

          </fieldset>
        </div>

        <div id="sf3" class="frm" style="display: none;">
          <fieldset>
            <legend>Step 3 of 3</legend>

            <h4>Review Pemesanan anda</h4>
            <div class="row">
            <div class="well col-xs-10 col-sm-10 col-md-6 col-xs-offset-1 col-sm-offset-1 col-md-offset-3">
                <div class="row">
                    <div class="col-xs-6 col-sm-6 col-md-6">
                        <address>
                            <strong id="revOrderName"></strong>
                            <br>
                            <div id="revAddr"></div>
                            <br>
                            <abbr title="Phone" >No.Hp:</abbr> <div id="revPhone"></div>
                        </address>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6 text-right">
                        <p>
                            <em>Tanggal: <?php echo $data['time'];?></em>
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="text-center">
                        <h3>Nota pembayaran</h3>
                    </div>
                    </span>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th>#</th>
                                <th class="text-center">Harga</th>
                                <th class="text-center">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                          <?php foreach($this->cart->contents() as $item):?>
                            <tr>
                                <td class="col-md-9"><em><?php echo $item['name'];?></em></h4></td>
                                <td class="col-md-1" style="text-align: center"> <?php echo $item['qty'];?></td>
                                <td class="col-md-1 text-center">Rp.<?php echo $item['price'];?></td>
                                <td class="col-md-1 text-center">Rp.<?php echo ($item['price']*$item['qty']);?></td>
                            </tr>
                          <?php endforeach;?>
                            <tr>
                                
                                <td class="text-right" colspan="2">
                                <p>
                                    <strong>Subtotal: </strong>
                                </p>
                                <!--
                                <p>
                                    <strong>Pajak (10% PPh): </strong>
                                </p></td>
                                -->
                                <td class="text-center" colspan="2">
                                <p>
                                    <strong>Rp.<?php echo $this->cart->total();?></strong>
                                </p>
                                <!--
                                <p>
                                    <strong>Rp.<?php ?></strong>
                                </p>-->
                                </td>
                            </tr>
                            <tr>
                                <td class="text-right" colspan="2"><h4><strong>Total: </strong></h4></td>
                                <td class="text-center text-danger" colspan="2"><h4 id="totOrder"><strong>Rp. <?php echo ($this->cart->total() );?></strong></h4></td>
                            </tr>
                        </tbody>
                    </table>
                    <button type="button" class="btn btn-success btn-lg btn-block payNow">
                        Pay Now   <span class="glyphicon glyphicon-chevron-right"></span>
                    </button></td>
                </div>
            </div>


            <div class="clearfix" style="height: 10px;clear: both;"></div>

            <div class="form-group">
              <div class="col-lg-10 col-lg-offset-2">
                <button class="btn btn-warning back3" type="button"><span class="fa fa-arrow-left"></span> Back</button> 
                <!--<button class="btn btn-primary open3" type="button">Submit </button> -->
                <img src="<?php echo base_url();?>assets/rapidrms/img/spinner.gif" alt="" id="loader" style="display: none">
              </div>
            </div>

          </fieldset>
        </div>
      </form>
    </div>
    </div>
  </div>