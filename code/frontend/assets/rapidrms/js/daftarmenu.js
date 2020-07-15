
// Call the dataTables jQuery plugin
$(document).ready(function() {
    var table = $('#TlistMenu').DataTable({
      'processing' : true,
      'serverSide' : true,
      'language':{
        'url':'https://cdn.datatables.net/plug-ins/1.10.19/i18n/Indonesian.json',
        'sEmptyTable':'Kosong'
      },
      'ajax':{
        "url": base_url+"rapidrms/Menu/getdaftar_menu",
        "type": 'POST',
        "dataType": "json",
        "data": function(d){
          d.filter = {
            'bycategory' : $('#menucategoryfilter').find(":selected").val(),
            'byminpricemenu' : $('#menuminpricefilter').val(),
            'bymaxpricemenu' : $('#menumaxpricefilter').val(),
            'bystatusmenu' : $('#menuactivestatus').find(":selected").val(),
            'byMenuType' : $(".btnMenuType.active").data('id')
          }
        }        
      },
      'columns':[   //extract data in json array 
        { "data":"idmenu"},
        { "data":"foto",
        "render":function(data,type,row){
            return '<div class="text-center"><img style="width:100%;" class="img-responsive" src="'+data+'" alt="" ></div>'
        }},
        { "data":"nama"},
        { "data":"deskripsi"},
        { "data":"kategori"},
        { "data":"harga",
        "render":function(data,type,row){
            return 'Rp.'+data+''
        }},
        { "data":{
            "idmenu":"idmenu",
            "aktif":"aktif"
          },
        "render":function(data,type,row){
        return `
            <div class="container-fluid">
            <div class="row mb-2">
            <button type="button" class="btn btn-sm btn-primary btnUpdateMenu">
            <i class="fas fa-edit"></i>Edit
            </button>
            </div>
            <div class="row mb-2">
            <button type="button" class="btn btn-danger btn-sm btnDeleteMenu">
                <i class="fas fa-trash"></i> Hapus
            </button>
            </div>
            <div class="row ">
            <button type="button" class="btn `+((data['aktif']==1) ? `btn-secondary` : `btn-success`) +` btn-sm btnStatusMenu" >
                <i class="fas fa-`+((data['aktif']==1) ? `times` : `check`)+` "></i> `+((data['aktif']==1) ? `Non-aktifkan` : `Aktifkan`)+`
            </button>
            </div>
            </div>

        `
        }}
      ],
      'createdRow': function(row,data,dataIndex){
        $(row).attr('data-id',data.idmenu);
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
        $('#menucategoryfilter')
          .find('option')
          .remove()
          .end()
          .append('<option value="" selected>Semua</option>')
          .val('');

        $('#menu-category')
        .find('option')
        .remove()
        .end();

        var datacategory = table.column(4).data().unique();
        for(i=0;i<datacategory.length;i++){
          
          $('#menucategoryfilter').append($('<option>', {
            value: datacategory[i],
            text: datacategory[i]
        }));

        }
        $('#lastupdate').text('Updated '+json['last_update']);
      }
    });

    var tableMenuOptional = $('#TlistMenuOptional').DataTable({
      'processing' : true,
      'serverSide' : true,
      'language':{
        'url':'https://cdn.datatables.net/plug-ins/1.10.19/i18n/Indonesian.json',
        'sEmptyTable':'Kosong'
      },
      'ajax':{
        "url": base_url+"rapidrms/Menu/getopsional_menu",
        "type": 'POST',
        "dataType": "json",
        "data": function(d){
          d.filter = {
            'byminpricemenu' : $('#menuminpricefilter').val(),
            'bymaxpricemenu' : $('#menumaxpricefilter').val(),
            'byMenuType' : $(".btnMenuType.active").data('id')
          }
        }        
      },
      'columns':[   //extract data in json array 
        { "data":"idmenu_tambahan"},
        { "data":"nama"},
        { "data":"deskripsi"},
        { "data":"harga",
        "render":function(data,type,row){
            return 'Rp.'+data+''
        }},
        {
          "data":"unit"
        },
        { "data":{
            "idmenu_tambahan":"idmenu_tambahan"
                    },
        "render":function(data,type,row){
        return `
            <div class="container-fluid">
            <div class="row mb-2">
            <button type="button" class="btn btn-sm btn-primary btnUpdateMenuOpt" data-action="edit" data-toggle="modal" data-target="#addMenuOptModal">

            <i class="fas fa-edit"></i>Edit
            </button>
            </div>
            <div class="row mb-2">
            <button type="button" class="btn btn-danger btn-sm btnDeleteMenuOpt">
                <i class="fas fa-trash"></i> Hapus
            </button>
            </div>
            </div>
        `
        }}
      ],
      'createdRow': function(row,data,dataIndex){
        $(row).attr('data-id',data.idmenu_tambahan);
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
      }
    });

  $('.titleMenuType').text(`Daftar ${$(".btnMenuType.active").text()}`);
  $('#menu-orderType').val($(".btnMenuType.active").data('id'));
  $('#menu-orderTypeOpt').val($(".btnMenuType.active").data('id'));


  $('#cariBtn').click(function() {
    table.ajax.reload(null,false); 
  });

  $("body").on('click',".btnMenuType", function(e){
    e.preventDefault();
    $(".btnMenuType").removeClass("active");
    $(this).addClass("active");
    $('.titleMenuType').text(`Daftar ${$(this).text()}`);
    $('#menu-orderType').val($(this).data('id'));
    $('#menu-orderTypeOpt').val($(this).data('id'));

    table.ajax.reload(null,false);
    tableMenuOptional.ajax.reload(null,false);

  });

  //reset form if hidden
  $('#addMenuModal').on('hidden.bs.modal', function(){
    $(this).find('form')[0].reset();
    $('#label-photo-preview').text("");
    $('#photo-preview').attr('src','');
    $('#menu-category')
        .find('option')
        .remove()
        .end();
  })

  $('#addMenuModal').on('show.bs.modal', function(){
    $(this).find('#addtitleMenuType').text(`Tambah Menu Utama ${$(".btnMenuType.active").text()}`);
    $.ajax({
      url: base_url+"/rapidrms/Menu/getkategori_menu",
      type: "post",
      dataType: "JSON"
      }).done(function(res){
        var datacategory = res["data"];
        for(i=0;i<datacategory.length;i++){
          $('#menu-category').append($('<option>',{
            value: datacategory[i]["nama"],
            text: datacategory[i]["nama"]
          }));
        }
    });
  })

  //add menu 
  $('#addmenuForm').submit(function(e){
    e.preventDefault();
    var formData = new FormData(this);
    var responses = new Array();
    $.ajax({
      url: base_url+"/rapidrms/Menu/tambah_menu",
      type: "post",
      data: formData,
      mimeType: 'multipart/form-data',
      contentType: false,
      cache: false,
      processData: false,
      success: function(r){
        var json = JSON.parse(r);
        responses['icon'] = 'success'
        responses['message'] = json.message;
      },
      error: function(jqXhr){
        if(jqXhr.status !== 200){ //validation error for responses not 200 OK
          var json = JSON.parse(jqXhr.responseText);
          responses['icon'] = 'error';
          responses['message'] = json.message;
        } 
      }
    }).always(() => {
      $("#addMenuModal").modal('hide');
      $('#addmenuForm')[0].reset();
      $('#label-photo-preview').text("");
      $('#photo-preview').attr('src','');
      table.ajax.reload(function(){
        $('#lastupdate').text('Updated '+table.ajax.json().last_update);
       }); 
       console.log(responses['message']);
       $.toast({
        text: responses['message'], 
        heading: 'Status Edit Menu', 
        icon: responses['icon'], 
        showHideTransition: 'slide', 
        allowToastClose: true, 
        hideAfter: 2000, 
        position: 'top-center', 
        textAlign: 'left'
      });
    });
    
  });

  //add preview photos
  $('#menu-photo').on('change', function(e){
     var files = e.target.files; //FILESLIST object

     //loop throught the FileLIst and render image as thumbnails
     for (var i=0,f;f = files[i];i++){
        //only process image files
        if(!f.type.match('image.*'))  {
          return;
        }
        var reader = new FileReader();
        //closure to capture the file information
        reader.onload = (function(theFile){
          return function(e){
            //render thumbnail 
            $('#label-photo-preview').text("Pratinjau :");
            $('#photo-preview').attr('src',e.target.result);

          };
        })(f);
        reader.readAsDataURL(f);
     }
  })

  

 $("body").on('click',".btnUpdateMenu",function(){
    var idMenu = $(this).closest('.rowData').attr('data-id');
 
    $.ajax({
      url: base_url+"rapidrms/Menu/getdaftar_menu",
      type: "POST",
      dataType: "json",
      data: {
        'filter': {
          'byIdMenu' : idMenu
        },
        'length' : 1
      }      
    }).done(function(res){
      var data = res["data"];
      $('#menu-idEdit').attr('value',idMenu);
      $('#menu-nameEdit').val(res["data"][0]["nama"]);
      $('#menu-descriptionEdit').val(res["data"][0]["deskripsi"]);
      $('#menu-priceEdit').val(res["data"][0]["harga"]);
      $('#photo-previewEdit').attr('src',`${res["data"][0]["foto"]}`);
      $('#menu-mindpEdit').val(res["data"][0]["minim_dp"]);
      $('#menu-minorderEdit').val(res["data"][0]["minim_order"]);
      //console.log(res["data"][0]["kategori"]);
      $.ajax({
        url: base_url+"/rapidrms/Menu/getkategori_menu",
        type: "post",
        dataType: "JSON"
        }).done(function(res){
          var datacategory = res["data"];
          for(i=0;i<datacategory.length;i++){
            $('#menu-categoryEdit').append($('<option>',{
              value: datacategory[i]["nama"],
              text: datacategory[i]["nama"],
              selected: datacategory[i]["nama"] == data[0]["kategori"]
            }));
            
          }
      });

    });


    $('#editMenuModal').find('.titleMenuType').text(`Edit Menu Utama ${$(".btnMenuType.active").text()}`);
    $('#editMenuModal').modal('show');
 })

 //reset form if hidden
 $('#editMenuModal').on('hidden.bs.modal', function(){
  $('#editmenuForm')[0].reset();
  $('#menu-categoryEdit')
       .find('option')
       .remove()
       .end();
  $('#photo-previewEdit').attr('src','');
  $(this).find('.titleMenuType').text();
 })

 $('#editmenuForm').submit(function(e){
   e.preventDefault();
   var formData = new FormData(this);
   var responses = new Array();
   $.ajax({
     url: base_url+"rapidrms/Menu/edit_menu",
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
   }).always(()=>{
     $("#editMenuModal").modal('hide');
     table.ajax.reload(function(){
      $('#lastupdate').text('Updated '+table.ajax.json().last_update);
     }); 
     $.toast({
      text: responses['message'], 
      heading: 'Status Edit Menu', 
      icon: responses['icon'], 
      showHideTransition: 'slide', 
      allowToastClose: true, 
      hideAfter: 2000, 
      position: 'top-center', 
      textAlign: 'left'
    });
   });
   
 });

 //add preview photos
 $('#menu-photoEdit').on('change', function(e){
   var files = e.target.files; //FILESLIST object

   //loop throught the FileLIst and render image as thumbnails
   for (var i=0,f;f = files[i];i++){
      //only process image files
      if(!f.type.match('image.*'))  {
        return;
      }
      var reader = new FileReader();
      //closure to capture the file information
      reader.onload = (function(theFile){
        return function(e){
          //render thumbnail 
          $('#label-photo-preview').text("Pratinjau :");
          $('#photo-previewEdit').attr('src',e.target.result);
        };
      })(f);
      reader.readAsDataURL(f);
   }
})


 $("body").on('click',".btnDeleteMenu",function(){
  var Menudata = $(this).closest('.rowData');
  var b = table.column(0).data();
  var idx = -1;
  for (var key in b){
    if(b[key] == Menudata.attr('data-id') ){
      idx = key;
      break;
    }
  }
  var data = table.rows(idx).data()[0];
  $("#deleteMenuMessage").text('Kamu akan menghapus menu '+data['nama']);
  $("#deleteMenuModal").modal('show');
  $("#actionDeleteMenu").off().on('click',function() {
    var responses = new Array();
    $.ajax({
      url: base_url+"/rapidrms/Menu/menu_action",
      type: "post",
      dataType: "JSON",
      data : { "action" : "delete", "idmenu":[data['idmenu']]},
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
        $("#deleteMenuModal").modal('hide');
        table.ajax.reload(function(){
          $('#lastupdate').text('Updated '+table.ajax.json().last_update);
        }); 
        $.toast({
          text: responses['message'], 
          heading: 'Status Hapus Menu', 
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
   $( "#deleteMenu" ).click(function() {
    var rows_selected=table.column(0).checkboxes.selected();
    if(rows_selected.length != 0){
      //Iterate over all selected checkboxes
      var idMenuSelected = new Array();
      $.each(rows_selected, function(Index, rowId) {
      idMenuSelected.push(rowId);
     });
     $("#deleteMenuMessage").text('Kamu akan menghapus '+rows_selected.length+' menu');
     $("#deleteMenuModal").modal('show');
     $("#actionDeleteMenu").off().on('click',function() {
      var responses = new Array();
      $.ajax({
        url: base_url+"/rapidrms/Menu/menu_action",
        type: "post",
        dataType: "JSON",
        data : { "action" : "delete", "idmenu":idMenuSelected},
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
          $("#deleteMenuModal").modal('hide');
          table.ajax.reload(function(){
            $('#lastupdate').text('Updated '+table.ajax.json().last_update);
          });
          $.toast({
            text: responses['message'], 
            heading: 'Status Hapus Menu', 
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

  $("body").on('click','.btnStatusMenu',function(){
    var Menudata = $(this).closest('.rowData');
    var responses = new Array();
    $.ajax({
      "url": base_url+"rapidrms/Menu/menu_action",
      "type": "POST",
      "dataType": "JSON",
      "data" : { "action" : "setStatusActive", "idmenu":Menudata.attr('data-id')},
      "success" : function(r){
        responses['icon'] = 'success'
        responses['message'] = r.message;
      },
      "error" : function(jqXhr){
        if(jqXhr.status !== 200){ //validation error for responses not 200 OK
          var json = JSON.parse(jqXhr.responseText);
          responses['icon'] = 'error';
          responses['message'] = json.message;
        } 
      }
      }).always(() =>{
        $.toast({
          text: responses['message'],
          heading: 'Ubah status Menu', 
          icon: responses['icon'],
          showHideTransition: 'slide',
          hideAfter: 2000, 
          position: 'top-center',
          textAlign: 'left'
        });
        table.ajax.reload(function(){
          $('#lastupdate').text('Updated '+table.ajax.json().last_update);
        }); 
    });
  })

  //add menu opsi

  //reset form if hidden
  $('#addMenuOptModal').on('hidden.bs.modal', function(){
    $(this).find('form')[0].reset();
    $(this).find('#addmenuOptForm').attr("class",'');
  })

  $('#addMenuOptModal').on('show.bs.modal', function(ev){
    var myVal = $(ev.relatedTarget).data('action');

    if(myVal=='add'){

      $(this).find('#addtitleMenuOptType').text(`Tambah Menu Opsional ${$(".btnMenuType.active").text()}`);
      $('#btn-menuOpt').val("Tambah Menu Opsional");
      $('#addMenuOptModal').find('#addmenuOptForm').addClass("add");
    }
    else if(myVal == 'edit'){
      var idMenuOpt = $(ev.relatedTarget).closest('.rowData').attr('data-id');
      $.ajax({
        url: base_url+"rapidrms/Menu/getopsional_menu",
        type: "POST",
        dataType: "json",
        data: {
          'filter': {
            'byIdMenuOpt' : idMenuOpt
          },
          'length' : 1
        }      
      }).done(function(res){
        $('#menu-idOpt').attr('value',idMenuOpt);
        $('#menu-nameOpt').val(res["data"][0]["nama"]);
        $('#menu-descriptionOpt').val(res["data"][0]["deskripsi"]);
        $('#menu-priceOpt').val(res["data"][0]["harga"]);
        $('#menu-unitOpt').val(res["data"][0]["unit"]);
        $('#btn-menuOpt').val("Edit Menu Opsional")
      });

      $('#addMenuOptModal').find('#addtitleMenuOptType').text(`Edit Menu Opsional ${$(".btnMenuType.active").text()}`);
      $('#addMenuOptModal').find('#addmenuOptForm').addClass("edit");
    } 
  })

  $('#addmenuOptForm').submit(function(e){
    e.preventDefault();
    var formData = new FormData(this);
    var responses = new Array();
    if($(this).is('.add')){
      var urlEdit = base_url+"rapidrms/Menu/tambah_menu_opsional";
      var heading = "Status Tambah Menu Opsional";
    }
    else if($(this).is('.edit')){
      var urlEdit = base_url+"rapidrms/Menu/edit_menu_opsional";
      var heading = "Status Edit Menu Opsional";
    }
    $.ajax({
      url: urlEdit,
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
    }).always(()=>{
      $("#addMenuOptModal").modal('hide');
      tableMenuOptional.ajax.reload(null,false);
      $.toast({
       text: responses['message'], 
       heading: heading, 
       icon: responses['icon'], 
       showHideTransition: 'slide', 
       allowToastClose: true, 
       hideAfter: 2000, 
       position: 'top-center', 
       textAlign: 'left'
     });
    });
    
  });

  $("body").on('click',".btnDeleteMenuOpt",function(){
    console.log('sdf');
    var Menudata = $(this).closest('.rowData');
    var b = tableMenuOptional.column(0).data();
    var idx = -1;
    for (var key in b){
      if(b[key] == Menudata.attr('data-id') ){
        idx = key;
        break;
      }
    }
    var data = tableMenuOptional.rows(idx).data()[0];
    $("#deleteMenuMessage").text('Kamu akan menghapus menu '+data['nama']);
    $("#deleteMenuModal").modal('show');
    $("#actionDeleteMenu").off().on('click',function() {
      var responses = new Array();
      $.ajax({
        url: base_url+"/rapidrms/Menu/menu_optional_action",
        type: "post",
        dataType: "JSON",
        data : { "action" : "delete", "idmenu_optional":[data['idmenu_tambahan']]},
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
          $("#deleteMenuModal").modal('hide');
          tableMenuOptional.ajax.reload(null,false);
          $.toast({
            text: responses['message'], 
            heading: 'Status Hapus Menu Optional', 
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

});

