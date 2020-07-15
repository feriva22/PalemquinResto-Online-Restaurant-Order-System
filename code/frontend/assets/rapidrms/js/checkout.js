$(document).ready(function() {
    
    var date = new Date();
    date.setDate(date.getDate());
    $("#datepicker").datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        todayHighlight: true,
        startDate: date
    });

    $('#timepicker').datetimepicker({
        format: 'HH:mm',
        useCurrent: false
    });

    // validate form on keyup and submit
    var v = $("#basicform").validate({
        rules: {
            cst_name: {
                required: true
            },
            cst_phone:{
                required: true,
                minlength: 10,
                maxlength: 13,
                number: true
            },
            ord_fordate: {
                required: true
            },
            ord_time: {
                required:true
            }
        },
        errorElement: "span",
        errorClass: "help-inline-error",
    });

    // Binding next button on first step
    $("#open1").click(function() {
        //if (v.form()) {
          $(".frm").hide("fast");
          $("#sf2").show("slow");

          $("html, body").animate({ scrollTop: $('.side-panel').offset().top }, 1000);
        //}
     });
   
     // Binding next button on second step
     $("#open2").click(function() {
        if (v.form()) {
          $(".frm").hide("fast");
          $("#sf3").show("slow");
          //set value for review page
          $('#revOrderName').text($('#cst_name').val());
          $('#revPhone').text($('#cst_phone').val());
          $("html, body").animate({ scrollTop: $('.side-panel').offset().top }, 1000);
        }
      });
   
       // Binding back button on second step
      $(".back2").click(function() {
        $(".frm").hide("fast");
        $("#sf1").show("slow");
        $("html, body").animate({ scrollTop: $('.side-panel').offset().top }, 1000);

      });
   
       // Binding back button on third step
       $(".back3").click(function() {
        $(".frm").hide("fast");
        $("#sf2").show("slow");
        $("html, body").animate({ scrollTop: $('.side-panel').offset().top }, 1000);

      });
   
      $(".payNow").click(function() {

        var responses = new Array();
        $.ajax({
            url: base_url+"Menu/checkout_act",
            type: "post",
            data: {
                "cst_name" : $('#cst_name').val(),
                "cst_phone" : $('#cst_phone').val(),
                "ord_fordate" : $('#ord_fordate').val(),
                "ord_time" :$('#ord_time').val(),
                "inv_delivaddress" : $('#inv_delivaddress').val(),
                "inv_isdp" : $("input[name='inv_isdp']:checked").val(),
                "inv_paygateway" : $("#inv_paygateway").val()
            },
            dataType: "JSON",
            success: function(r){
              responses['icon'] = 'success'
              responses['message'] = r.message;
              $("#loader").show();
              $("html, body").animate({ scrollTop: $('.side-panel').offset().top }, 1000);
              setTimeout(function(){
                  $("#basicform").html(`<h2>Pemesanan selesai</h2>
                  <p>Silahkan lakukan pembayaran sesuai invoice, klik link berikut <a href="${base_url}customer/invoice" style="color:blue;">Lihat invoice</a></p>`);
              }, 1000);
            },
            error: function(jqXhr){
              if(jqXhr.status !== 200){ //validation error for responses not 200 OK
                var json = JSON.parse(jqXhr.responseText);
                responses['icon'] = 'error';
                responses['message'] = json.message;
              } 
              
            }
          }).always(() => {
             $.toast({
              text: responses['message'], 
              heading: 'Status Pemesanan', 
              icon: responses['icon'], 
              showHideTransition: 'slide', 
              allowToastClose: true, 
              hideAfter: 2000, 
              position: 'top-center', 
              textAlign: 'left'
            });
            
        });

          
          // Remove this if you are not using ajax method for submitting values
          return false;
        
    });




    
  });