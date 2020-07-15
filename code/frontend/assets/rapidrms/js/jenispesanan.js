// Call the dataTables jQuery plugin
$(document).ready(function() {
    var table = $('#TlistOrderMenuType').DataTable({
      'processing':true,
      'serverSide':false,
      'bProcessing': true,
      'language':{
        'url':'https://cdn.datatables.net/plug-ins/1.10.19/i18n/Indonesian.json',
        'sEmptyTable':'Kosong'
      },
      'ajax':{
        url: base_url+"rapidrms/Menu/getjenis_pesanan",
        type: 'POST',
        dataType: "json"  
      },
      'columns':[   //extract data in json array 
        { "data":"idjenis_pesanan"},
        { "data":"nama"},
        { "data":"deskripsi"},
        /*
        { "data":{
            "idjenis_pesanan":"idjenis_pesanan"
          },
        "render":function(data,type,row){
        return `
            <div class="container-fluid">
            <div class="row mb-2">
            <button type="button" class="btn btn-sm btn-primary btnUpdateJenisPesanan">
            <i class="fas fa-edit"></i>Edit
            </button>
            </div>
            <div class="row mb-2">
            <button type="button" class="btn btn-danger btn-sm btnDeleteJenisPesanan" >
                <i class="fas fa-trash"></i> Hapus
            </button>
            </div>
            </div>
        `
        }
      }*/
      ],
      'createdRow':function(row,data,dataIndex){
        $(row).attr('data-id',data.idjenis_pesanan);
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
        $('#lastupdate').text('Updated '+json['last_update']);
      }
    });

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

});