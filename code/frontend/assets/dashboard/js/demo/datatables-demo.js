// Call the dataTables jQuery plugin
$(document).ready(function() {
  var table = $('#dataTable').DataTable({
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
    'order':[[1,'asc']]
  });


  
  
  

});
