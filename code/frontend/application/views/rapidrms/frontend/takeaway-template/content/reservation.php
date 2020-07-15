<div class="container">
    <br>
    <div class="row">
        <div class="col-md-12 text-center">
            <h4>Silahkan Pilih Tanggal dan waktu untuk pemesanan tempat kamu</h4>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
        <form method="post" autocomplete="off" id="reservationOrder">
            <div class="form-group col-md-3">
                <label for="date">Tanggal</label>  
                <div class="input-group date" id="datepicker">
                    <input size="16" type="text" name="date" class="form-control " id="dateReservation" placeholder="ex :10-10-2019" required>
                    <span class="input-group-addon "><span class="fa fa-calendar"></span></span>
                </div>
            </div>
            <div class="form-group col-md-3">
                <label for="time">Waktu</label>
                <div class="input-group date" id="timepicker">
                    <input size="16" type="text" name="time" class="form-control " id="timeReservation" value="12:00" required>
                    <span class="input-group-addon "><span class="fa fa-clock-o "></span></span>
                </div>
            </div>
            <div class="form-group col-md-2 col-xs-4">
                <label for="people">Orang</label>
                <div class="input-group date">
                    <input type="number" class="form-control" id="peopleReservation" name="people" min="1" placeholder="1" required>
                </div>
            </div>
            
            <div class="col-md-4">
                <label for=""></label>
            <input type="submit" class="btn btn-success btn-lg btn-block" value="Cek Ketersediaan">
            </div>
            
        </form>
        
    </div>
    </div>
<br>
<div class="row ">
    <div class="col-md-8 col-md-offset-2">
        <div class="text-center">
            <div class="row ">
                <div class="col-12" id="canvas-wrapper" style="overflow:auto">
                    <canvas id="canvas" width="627" height="396"></canvas>
                </div>
            </div>
        </div>
        <br>
    </div>
</div>
</div>

<!-- The modal for editcart -->
<div class="modal fade" id="modalReservation" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true" >
	<div class="modal-dialog" role="document">
	<div class="modal-content">
	<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
	<span aria-hidden="true">&times;</span>
	</button>
	<h4 class="modal-title" id="modalLabel">Reservasi tempat</h4>
	</div>
	<div class="modal-body">
        <p>Ringkasan Reservasi Tempat anda :</p>
        <dl class="row">
            <dt class="col-sm-3 col-md-3">Nomor Meja : </dt>
            <dd class="col-sm-9 col-md-9"><span id="no_mejaReservation"></span> <a href="#" style="color: blue;" onclick="$('#modalReservation').modal('hide')">Ubah</a></dd>
            <dt class="col-sm-3 col-md-3">Tanggal : </dt>
            <dd class="col-sm-9 col-md-9"><span id="date_Reservation">{}</span></dd>
            <dt class="col-sm-3 col-md-3">Jam : </dt>
            <dd class="col-sm-9 col-md-9"><span id="time_Reservation">{}</span></dd>
            <dt class="col-sm-3 col-md-3">Jumlah Orang : </dt>
            <dd class="col-sm-9 col-md-9"><span id="people_Reservation">{}</span></dd>
        </dl>
        <p>Silahkan <strong>klik tombol Order</strong> dibawah untuk melanjutkan memilih Menu </p>
	</div>
	<div class="modal-footer">
	<button type="button" class="btn btn-success btnSaveReservation" >Order</button>
	<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
	</div>
	</div>
	</div>
</div>
<!-- end  #editCartModal -->