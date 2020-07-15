$(document).ready(function() {
    var table = $('#TlistUserAdmin').DataTable({
        'processing':true,
        'serverSide':false,
        'bProcessing': true,
        'language':{
          'url':'https://cdn.datatables.net/plug-ins/1.10.19/i18n/Indonesian.json',
          'sEmptyTable':'Kosong'
        },
        'ajax':{
          url: base_url+"admin/Home/User_data",
          type: 'POST',
          dataType: "json"  
        },
        'columns':[   //extract data in json array 
          { "data":"idUser"},
          { "data":"username"},
          { "data":"email"},
          { "data" : "level"},
          { "data":{
              "idUser":"idUser"
            },
          "render":function(data,type,row){
          return `
              <div class="container-fluid">
              <div class="row mb-2">
              <button type="button" class="btn btn-sm btn-primary btnUpdateCtgMenu">
              <i class="fas fa-edit"></i>Edit
              </button>
              </div>
              <div class="row mb-2">
              <button type="button" class="btn btn-danger btn-sm btnDeleteCtgMenu" >
                  <i class="fas fa-trash"></i> Hapus
              </button>
              </div>
              </div>
          `
          }}
        ],
        'createdRow':function(row,data,dataIndex){
          $(row).attr('data-id',data.idUser);
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
});