<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<script type="text/javascript">
function formatDataMenu (menu) {
  if(menu.loading){
      return menu.text;
  }
  var $container = $(
    `<div class="clearfix" style="padding-top: 4px;padding-bottom: 3px;">
      <div style="float: left; width: 60px;margin-right: 10px">
        <img style="width: 100%;height:50px;border-radius: 2px;" src="${base_url+menu.mnu_photo}">
      </div>
      <div style="margin-left: 70px;">
        <div style="color: black;font-weight: 700;word-wrap: break-word;line-height: 1.1,margin-bottom: 4px">
        ${menu.text}</div>
        <div style="font-size: 13px;color: #777;margin-top:4px;">${menu.mnu_desc}</div>
        <div style="font-size: 13px;color: #777;margin-top:4px;display: inline-block;"><i class="fas fa-fw fa-tag"></i>${menu.mnu_category}</div>
        <div style="float:right;">Rp.${menu.mnu_price}</div>
      </div>

    </div>
    `);
  return $container;
}

function formatDataMenuSelection (menu) {
  return menu.mnu_name || menu.text; 
}

function getDateNow(){
  var dt = new Date();
  return dt.getYear()+"/"+dt.getMonth()+"/"+dt.getDate();
}


</script>

<script type="text/javascript">
$(document).ready(function() {
    //init function 

    var myCart = new cartBackend({
      mode : 'add',
      tableItemSelector: '#item-cart-table',
      typeOrder: 'katering',
      totalPriceItemSelector: '#item-cart-total',
      totalFinalSelector: '#grand-total'
    });

    $('.nav-toggle').trigger('click');
    /** on step 1 */
    $("#odr_type").change(function() {
        $(".is-reservation").toggle(!this.checked);
        $('.is-reservation-addr').toggle(this.checked);
        if(!this.checked){
          myCart.setOrderType('reservasi');
        }else{
          myCart.setOrderType('katering');
        }
    });
    /** on step 2 */
    $("#ord_isdelivery").change(function() {
        $(".is-delivered").toggle(this.checked);
    });
    $('#ord_iscustdatabase').change(function(){
        $('.customer_db').toggle(this.checked);
        $('.customer_created').toggle(!this.checked);
    })

    //datetimepicker
    $('#ord_fordate_picker').datetimepicker({
        format: 'YYYY-MM-DD HH:mm',
        minDate: new Date(),
        icons: {
            time: "fas fas fa-clock",
            date: "fa fa-calendar",
            up: "fa fa-arrow-up",
            down: "fa fa-arrow-down"
        }
    });
    
    url = {
      detail : base_url+'backend/meja_reservasi/detail_order',
    };
    page = ['step-1','step-2','step-3'];
    currentPage = 'step-1';

    change_page = function(section){
      if(section !== 'step-1' && myCart.showAllItem().length == 0){
          show_notification('warning','Pilih menu terlebih dahulu')
          change_page('step-1');
          return;
      }
      if(section !== 'step-1' && $('#ord_fordate').val() == ""){
          show_notification('warning','Masukkan tanggal untuk pesanan');
          change_page('step-1');
          return;
      }
      page.forEach((item,index)=>{
        $(`div[data-section=${item}]`).hide();
      })
      $(`div[data-section=${section}`).show();
      currentPage = section;
    }

    //init
    change_page(currentPage);

    select2ajax({
      selector: '.add-menu-search',
      url: base_url+'backend/menu/get_menuajax',
      placeholder: 'Cari Menu',
      minInput: 3,
      pk_id: 'mnu_id',
      key_value: 'mnu_name',
      templateResultcallBack: formatDataMenu,
      templateSelectioncallBack: formatDataMenuSelection,
      selectedcallBack: (e)=>{
        data = e.params.data;
        myCart.addItem({
          id: data.mnu_id,
          name: data.mnu_name,
          type: data.mnu_category,
          price: data.mnu_price,
          quantity: data.mnu_minorder,
          min_order: data.mnu_minorder
        });
        $('.add-menu-search').empty();
      }
    });

/*** URUSANNN E RESERVASI BOOOSSS */
var setMapImage = function(imgUrl){
        $('#canvas').css(`background-size`,`100% 100%`);
        $('#canvas').css(`background-image`,`url(${imgUrl})`);
    };

  
  var canvas = this.__canvas = new fabric.Canvas('canvas',{
      selection : false,
      controlsAboveOverlay:true,
      centeredScaling:true,
      allowTouchScrolling: true
  });

  canvas.ObjectCounter = {};
  canvas.ObjectCounter['counterId'] = 0;

  var createNewTable = function(x,y,rad,number,id,fontSize,capacity,minOrder,color,selectable){
    var circle = new fabric.Circle({
        radius:rad , 
        fill: color,
        opacity : 0.5,
        originX: 'center',
        originY: 'center'
    });
    var text = new fabric.Text(''+(number)
    , {
        fontSize: fontSize,
        originX: 'center',
        originY: 'center'
    });
    var group = new fabric.Group([ circle, text ], {
        id: id,
        numberTable : number, 
        capacity : capacity,
        minimOrder: minOrder,
        top: y, 
        left:x,
        borderColor: 'red',
        cornerColor: 'green',
        cornerSize: 6,
        transparentCorners: false,
        hasControls : false, 
        hasBorders : false,
        lockMovementX : true,
        lockMovementY : true,
        selectable : selectable
    });
    canvas.add(group);
    canvas.requestRenderAll();
  }

  canvas.on({'mouse:down': function(e){
      if (canvas.findTarget(e)) {
          objectTable = canvas.findTarget(e);
          if (objectTable.selectable) {
              $('#modalReservation').data('idSeat',objectTable.id);
              $('#no_mejaReservation').text(objectTable.numberTable);
              $('#date_Reservation').text($('#ord_fordate').val());
              $('#people_Reservation').text($('#odr_people').val());

              $('.reservation-map-read').modal('hide');
              setTimeout(() => {
                $('#modalReservation').modal('show');
              },500);
          }
      }
  }});

  var get_mapdata = function(data){
    canvas.clear();
    ajaxExtend({
        url: url.detail,
        data: data,
        success: function(resp){
            if(resp.status == "success"){
                data = resp.data;
                $('#canvas').width(data.imageData.width);
                $('#canvas').height(data.imageData.height);
                setMapImage(base_url+data.imageData.url);
                if(data.map_data !== null){
                    data.map_data.forEach(e => {
                        attr = JSON.parse(e.tbm_attr);
                        createNewTable(parseInt(attr.loc_x),
                                       parseInt(attr.loc_y),
                                       parseInt(attr.rad_circle),
                                       e.tbm_name,
                                       e.tbm_id,
                                       attr.text_size,
                                       e.tbm_max,
                                       e.tbm_min,
                                       e.tbm_color,
                                       e.tbm_selected
                                       );
                        canvas.ObjectCounter['counterId'] = parseInt(e.tbm_id);
                    });
                }
            }
        },
        error: function(jxhr){
            show_notification('error','Terjadi error');
        }
    })
}
/*** URUSAN E RESERVASI BOS WES MARI */

    
    page_click('#search-table-btn',()=>{
      get_mapdata({
        odr_fordate : $('#ord_fordate').val(),
        odr_people : $('#odr_people').val()
      });
      $('.reservation-map-read').modal('show');

    })

    page_click('.btnSaveReservation',()=>{
      myCart.addReservation($('#modalReservation').data('idSeat'),
                            $('#ord_fordate').val(),
                            $('#odr_people').val()
                          );
      $('#description-reservation').text('Reservasi meja '+$('#modalReservation').data('idSeat')+'('+
                                        $('#ord_fordate').val()+') '+ $('#odr_people').val() + ' Orang'
                                        );
      //$('#ord_fordate').val(''),
      //$('#odr_people').val('')
      $('#modalReservation').modal('hide');
    })

    page_click('#submit-data',()=>{
      myCart.submitOrder({
        success: function(resp){
          if(resp.status === "success"){

              show_notification(resp.status,resp.message);
              setTimeout(()=>{
                  document.location = resp.data.redir_url;
              },1000);
          }
        },
        error: function(jxhr){
          show_notification('error','Error koneksi dengan server');
          
        }
      })
    })
    
});  

</script>