function format ( d ) {
  // `d` is the original data object for the row
  var trHtml = '';
  $.each(d.payment, function(i, item){
    var evidence = '-';
    if(item.bukti_pembayaran !== null){
      evidence = '<button type="button" class="btn btn-sm btn-secondary" data-evidence="'+item.bukti_pembayaran+'" ><i class="fas fa-eye"></i> Cek</button></td></tr>'
    }
    trHtml += '<tr class="dataPayment" data-idPayment="'+item.id_pemesanan+'_'+item.idpembayaran+'"><td>'+ item.pay_date+'</td>'+
              '<td>'+ 
              '<select class="statPayment">'+
              '<option value="0" '+((item.status_pembayaran == "0") ? 'selected' : '') +'>Belum terbayar</option>'+
              '<option value="1" '+((item.status_pembayaran == "1") ? 'selected' : '') +'>Terbayar</option>'+
              '<option value="2" '+((item.status_pembayaran == "2") ? 'selected' : '')+'>Ditolak</option>'+
              '</select>'+
              '</td>'+
              '<td>'+ item.via_pembayaran +'</td>'+
              '<td>Rp.'+ item.subtotal +'</td>'+
              '<td>'+ item.pajak+'%</td>'+
              '<td>Rp.'+ (parseFloat(item.subtotal) + (parseFloat(item.subtotal)*parseFloat(item.pajak)))+'</td>'+
              '<td>'+evidence+'</td>'

  });
  
//  for() //TODO butuh diedit untuk diisi dengan populasi data pembayaran beserta rendering server sidenya
  return '<h5 style="display:inline;">Daftar Pembayaran order #'+d.idpesanan+'</h5>'+
    '<!--<button type="button" class="btn btn-success btn-sm float-sm-right btnNewPayment" data-idOrder="'+d.idpesanan+'">'+
    '<i class="fas fa-plus"></i> Pembayaran Baru</button><br><br>-->'+
    '<div class="table-responsive">'+
    '<table class="table table-bordered table-striped dt-responsive" width="100%" border="1" cellspacing="0">'+
      '<thead><tr>'+
          '<th>Waktu bayar</th>'+
          '<th>Status</th>'+
          '<th>Via</th>'+
          '<th>Subtotal</th>'+
          '<th>Pajak</th>'+
          '<th>Total</th>'+
          '<th>Bukti</th>'+
      '</thead>'+
      '<tbody>'+
      trHtml+
      '</tbody>'+
    '</table>'+
    '</div>';
}

$(document).ready(function() {
    var table = $('#TlistOrderMenu').DataTable({
      'processing':true,
      'serverSide':true,
      'language':{
        'url':'https://cdn.datatables.net/plug-ins/1.10.19/i18n/Indonesian.json',
        'sEmptyTable':'Kosong'
      },
      'ajax':{
        "url": base_url+"rapidrms/Order/get_order",
        "type": 'POST',
        "dataType": "json",
        "data" : function(d){
          d.filter = {
            'byOrderStat': $('#filstatorderCategory').find(":selected").val(),
            'byOrderPaymentStat': $('#filstatPaymentOrder').find(":selected").val(),
            'byOrderDeadline': $('#filorderDeadline').find(":selected").val(),            
          }
        } 
      },
      'columns':[   //extract data in json array 
        { "data":"idpesanan"},
        { "data":{
            "pelanggan":"pelanggan",
            "idpesanan":"idpesanan"
        },
        "render":function(data,type,row){
            return `
                #`+data['idpesanan']+` oleh `+data['pelanggan']+` 
            `
        }},
        {
            "data":"waktu_order"
        },
        {
          "data":"waktu_kirim"
        },
        { "data":"status",
        "render":function(data,type,row){
            return '<select class="statOrder">'+
            '<option value="0" '+((data == "0") ? 'selected' : '') +'>Belum Lunas</option>'+
            '<option value="1" '+((data == "1") ? 'selected' : '') +'>Proses</option>'+
            '<option value="2" '+((data == "2") ? 'selected' : '')+'>Terkirim</option>'+
            '<option value="3" '+((data == "3") ? 'selected' : '')+'>Selesai</option>'+
            '<option value="4" '+((data == "4") ? 'selected' : '')+'>Dibatalkan</option>'+
            '<option value="6" '+((data == "5") ? 'selected' : '')+'>Gagal</option>'+
            '</select>'
        }},
        { "data":{
            "tipe_pembayaran":"tipe_pembayaran"
          },
        "render":function(data,type,row){
        return ` 
            `+((data.tipe_pembayaran == '1') ? 'DP' : 'Tunai' )+` <div class="float-sm-right">
            <button type="button" class="btn btn-sm btn-primary btnShowPayment">Cek</button>
            </div>
            `
        }},
        { "data":{
            "total":"total"
        },
        "render":function(data,type,row){
            return `
            Rp.`+data.total+`
            `
        }},
        {"data":"idpesanan",
        "render":function(data,type,row){
            return `
                <div class="container-fluid">
                <div class="row mb-2">
                <button type="button" class="btn btn-sm btn-secondary btnPrevOrder" ><i class="fas fa-eye"></i>
                </button>
                &nbsp;&nbsp;&nbsp;
                <button type="button" class="btn btn-sm btn-success btnEditOrder"><i class="fas fa-pen"></i>
                </button>
                </div>
                </div>
            `
        }}
      ],
      'createdRow':function(row,data,dataIndex){
        $(row).attr('data-id',data.idpesanan);
        $(row).addClass('rowData');
      },
      'columnDefs':[
        {
          'targets':0,
          'checkboxes':{
            'selectRow' : true
          }
        }
      ],
      'select': {
        'style': 'multi'
      },
      'order':[[0,'asc']],
      'initComplete': function(settings,json){
        //$('#lastupdate').text('Updated '+json['last_update']);
        console.log(json);

        $('#TlistOrderMenu_filter input').off().on('keyup', function(e) {
          var value = $(this).val();
          setTimeout(function() {
            //your change action goes here 
            if (value.length >= 3 || e.keyCode == 13) {
              table.search(value).draw();
            }
            if(value == ""){
              table.search("").draw();
            }
            }, 500);
          return false;
        });  
      },
      "bPaginate": true,
      "bLengthChange": true,
      "bFilter": true,
      "bSort": true,
      "bInfo": true,
      "bAutoWidth": true
    });
    
    //cari filter order
    $('#cariBtn').click(function() {
      table.ajax.reload(null,false); 
    });

    /*
    $(".dataTables_filter input")
    .unbind()
    .bind('input', function(e) {
        if (this.value.length >= 3 || e.keyCode == 13) {
            table.search(this.value).draw();
        }
        if(this.value == ""){
          table.search("").draw();
        }
    });
    */


    // Add event listener for opening and closing details
    $('body').on('click', ".btnShowPayment", function () {
      var tr = $(this).closest('tr');
      var row = table.row( tr );

      if ( row.child.isShown() ) {
          // This row is already open - close it
          row.child.hide();
          tr.removeClass('shown');
      }
      else {
          // Open this row
          
          row.child( format(row.data())).show();
          tr.addClass('shown');
      }
    });

    //cek change of order status
    $("body").on('change','.statOrder', function(){
      var selectedValue = $(this).children("option:selected").val();
      var idOrder = $(this).closest('.rowData').attr('data-id');
      var responses = new Array();
      $.ajax({
        "url": base_url+"rapidrms/Order/order_action",
        "type": "POST",
        "dataType": "JSON",
        "data" : { "action" : "changeStatus", "idOrder":idOrder, "statusValue":selectedValue},
        "success" : function(r){
          responses['icon'] = 'success'
          responses['message'] = r.message ;
        },
        "error" : function(jqXhr){
          if(jqXhr.status !== 200){ //validation error for responses not 200 OK
            var json = JSON.parse(jqXhr.responseText);
            responses['icon'] = 'error';
            responses['message'] = json.message ;
          } 
        }
        }).always(() =>{
          $.toast({
            text: responses['message'],
            heading: 'Ubah status Order #'+idOrder, 
            icon: responses['icon'],
            showHideTransition: 'slide',
            hideAfter: 2000, 
            position: 'top-center',
            textAlign: 'left'
          });
          table.ajax.reload(null,false); 
      });
      });
    
          //cek change of order status
    $("body").on('change','.statPayment', function(){
      var selectedValue = $(this).children("option:selected").val();
      var idOrder = $(this).closest('.rowData').attr('data-id');
      var responses = new Array();
      $.ajax({
        "url": base_url+"rapidrms/Order/order_action",
        "type": "POST",
        "dataType": "JSON",
        "data" : { "action" : "changeStatus", "idOrder":idOrder, "statusValue":selectedValue},
        "success" : function(r){
          responses['icon'] = 'success'
          responses['message'] = r.message ;
        },
        "error" : function(jqXhr){
          if(jqXhr.status !== 200){ //validation error for responses not 200 OK
            var json = JSON.parse(jqXhr.responseText);
            responses['icon'] = 'error';
            responses['message'] = json.message ;
          } 
        }
        }).always(() =>{
          $.toast({
            text: responses['message'],
            heading: 'Ubah status Order #'+idOrder, 
            icon: responses['icon'],
            showHideTransition: 'slide',
            hideAfter: 2000, 
            position: 'top-center',
            textAlign: 'left'
          });
          table.ajax.reload(null,false); 
      });
      });

    //reset previewOrderModal if hidden
    $('#previewOrdermodal').on('hidden.bs.modal', function(){
      $('#prev_titleOrder').text('');
      $('#prev_statusOrder').text('');
      $('#shippment_address').html('');
      $('#customer_name').html('');
      $('#phone_number').html('');
      $('#payment_via').html('');
      $('#prev_orderMenuDetail').find('tr').remove();
    })

    //edit button
    $("body").on('click',".btnPrevOrder",function(){
      var idOrder = $(this).closest('.rowData').attr('data-id');
      var b = table.column(0).data();
      var idx = -1;
      for (var key in b){
        if(b[key] == idOrder){
          idx = key;
          break;
        }
      }
      var data = table.rows(idx).data()[0];
      //modal show for update
      $('#prev_titleOrder').text('Pemesanan #'+idOrder);
      $('#shippment_address').html("<h5>Alamat pengiriman</h5>rt 01,rw 02 lempung<br>Turirejo<br>Kedamean,Gresik, Jawa timur 61175<br><br>");
      $('#customer_name').html('<h5>Atas Nama</h5>Ferico deno<br><br>');
      $('#phone_number').html('<h5>Nomor handphone</h5>081232123123<br><br>');
      $("#payment_via").html('<h5>Pembayaran via</h5>Rekening<br><br>'); 
      $('#prev_orderMenuDetail').append('<tr><td>Ayam goreng 2</td><td>2</td><td>Rp.100000</td></tr>');
      $('#previewOrdermodal').modal('show');
    });

    /*
    //reset form if hidden
    $('#ctgMenuModal').on('hidden.bs.modal', function(){
      $(this).find('form')[0].reset();
    })

    //edit button
    $("body").on('click',".btnUpdateCtgMenu",function(){
      var idMenu = $(this).closest('.rowData').attr('data-id');
      var b = table.column(0).data();
      var idx = -1;
      for (var key in b){
        if(b[key] == idMenu){
          idx = key;
          break;
        }
      }
      var data = table.rows(idx).data()[0];
      //modal show for update
      $('#ctgMenuModal').data("action","edit");
      $('#titleCtgMenuModal').text('Edit Kategori Menu');
      $('#ctgmenu-id').attr('value',idMenu);
      $('#ctgmenu-name').val(data['nama']);
      $('#ctgmenu-description').val(data['deskripsi']);
      $("#submit_btn").attr('value','Edit'); 
      $('#ctgMenuModal').modal('show');
    });

    //add button
    $("#addMenuCategory").on('click',function(){
      $('#ctgMenuModal').data("action","add");
      $('#titleCtgMenuModal').text('Tambah Kategori Menu')
      $("#submit_btn").attr('value','Tambah'); 
      $('#ctgMenuModal').modal('show');
    })

    $('#ctgMenuModal').on('show.bs.modal', function(){
      if($(this).data("action") === "edit"){
        $('#ctgMenuForm').unbind('submit').submit(function(e){
          e.preventDefault();
          var formData = new FormData(this);
          var responses = new Array();
          formData.append('action','update');
          $.ajax({
            url: base_url+"/rapidrms/Menu/kategori_action",
            type: "post",
            data: formData,
            mimeType: 'multipart/form-data',
            contentType: false,
            cache: false,
            processData: false,
            success : function(r){
             var json = JSON.parse(r);
             responses['icon'] = 'success'
             responses['message'] = json.message;
            },
            error : function(jqXhr){
             if(jqXhr.status !== 200){ //validation error for responses not 200 OK
               var json = JSON.parse(jqXhr.responseText);
               responses['icon'] = 'error';
               responses['message'] = json.message;
             } 
            }
          }).always(() => {
            $("#ctgMenuModal").modal('hide');
            table.ajax.reload(function(){
             $('#lastupdate').text('Updated '+table.ajax.json().last_update);
            }); 
            $.toast({
              text: responses['message'], 
              heading: 'Status Edit Kategori Menu', 
              icon: responses['icon'], 
              showHideTransition: 'slide', 
              allowToastClose: true, 
              hideAfter: 2000, 
              position: 'top-center', 
              textAlign: 'left'
            });
          })
          
          $("#ctgMenuModal").modal('hide');
        })
      }else if($(this).data("action") === "add"){
        $('#ctgMenuForm').unbind('submit').submit(function(e){
          e.preventDefault();
          var formData = new FormData(this);
          var responses = new Array();
          $.ajax({
            url: base_url+"/rapidrms/Menu/tambah_kategori",
            type: "post",
            data: formData,
            mimeType: 'multipart/form-data',
            contentType: false,
            cache: false,
            processData: false,
            success : function(r){
             var json = JSON.parse(r);
             responses['icon'] = 'success'
             responses['message'] = json.message;
            },
            error : function(jqXhr){
             if(jqXhr.status !== 200){ //validation error for responses not 200 OK
               var json = JSON.parse(jqXhr.responseText);
               responses['icon'] = 'error';
               responses['message'] = json.message;
             } 
            }
          }).always(() => {
            $("#ctgMenuModal").modal('hide');
            table.ajax.reload(function(){
             $('#lastupdate').text('Updated '+table.ajax.json().last_update);
            }); 
            $.toast({
              text: responses['message'], 
              heading: 'Status Tambah Kategori Menu', 
              icon: responses['icon'], 
              showHideTransition: 'slide', 
              allowToastClose: true, 
              hideAfter: 2000, 
              position: 'top-center', 
              textAlign: 'left'
            });
          })
        })
      }
    })

    $("body").on('click',".btnDeleteCtgMenu",function(){
      var ctgMenudata = $(this).closest('.rowData');
      var b = table.column(0).data();
      var idx = -1;
      for (var key in b){
        if(b[key] == ctgMenudata.attr('data-id') ){
          idx = key;
          break;
        }
      }
      var data = table.rows(idx).data()[0];
      $("#delCtgMenuMsg").text('Kamu akan menghapus Kategori '+data['nama']);
      $("#delCtgMenuModal").modal('show');
      $("#actDelCtgMenu").off().on('click',function() {
        var responses = new Array();
        $.ajax({
          url: base_url+"/rapidrms/Menu/kategori_action",
          type: "post",
          dataType: "JSON",
          data : { "action" : "delete", "idctgmenu":[data['idkategori_menu']]},
          success : function(r){
            responses['icon'] = 'success'
            responses['message'] = r.message;
          },
          error : function(jqXhr){
            if(jqXhr.status !== 200){ //validation error for responses not 200 OK
              var json = JSON.parse(jqXhr.responseText);
              responses['icon'] = 'error';
              responses['message'] = json.message;
            } 
          }          
          }).always(()=>{
            $("#delCtgMenuModal").modal('hide');
            table.ajax.reload(function(){
              $('#lastupdate').text('Updated '+table.ajax.json().last_update);
            }); 
            $.toast({
              text: responses['message'], 
              heading: 'Status Hapus Kategori Menu', 
              icon: responses['icon'], 
              showHideTransition: 'slide', 
              allowToastClose: true, 
              hideAfter: 2000, 
              position: 'top-center', 
              textAlign: 'left'
            });
          })
          return false;
        });
     }); 

     //delete several menu
   $( "#deleteMenuCategory" ).click(function() {
    var rows_selected=table.column(0).checkboxes.selected();
    if(rows_selected.length != 0){
      //Iterate over all selected checkboxes
      var idctgMenuSelected = new Array();
      $.each(rows_selected, function(Index, rowId) {
      idctgMenuSelected.push(rowId);
     });
     $("#delCtgMenuMsg").text('Kamu akan menghapus '+rows_selected.length+' kategori ?');
     $("#delCtgMenuModal").modal('show');
     $("#actDelCtgMenu").off().on('click',function() {
      var responses = new Array();
      $.ajax({
        url: base_url+"/rapidrms/Menu/kategori_action",
        type: "post",
        dataType: "JSON",
        data : { "action" : "delete", "idctgmenu":idctgMenuSelected},
        success : function(r){
          responses['icon'] = 'success'
          responses['message'] = r.message;
        },
        error : function(jqXhr){
          if(jqXhr.status !== 200){ //validation error for responses not 200 OK
            var json = JSON.parse(jqXhr.responseText);
            responses['icon'] = 'error';
            responses['message'] = json.message;
          } 
        }          
        }).always(() => {
          $("#delCtgMenuModal").modal('hide');
          table.ajax.reload(function(){
            $('#lastupdate').text('Updated '+table.ajax.json().last_update);
          });
          $.toast({
            text: responses['message'], 
            heading: 'Status Hapus Kategori Menu', 
            icon: responses['icon'], 
            showHideTransition: 'slide', 
            allowToastClose: true, 
            hideAfter: 2000, 
            position: 'top-center', 
            textAlign: 'left'
          });
          table.column(0).checkboxes.deselectAll();
        });
        return false;
      })
    }
  });
  */

});