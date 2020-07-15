<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<script type="text/javascript">
function formatDataSelect2 (data) {
  if(data.loading){
      return data.text;
  }
  var $container = $(
    `${data.text}`);
  return $container;
}

function formatDataSelect2Selection (data) {
  return data.text; 
}
</script>
<script type="text/javascript">
$(document).ready(function() {

    var transaksi_status = <?php echo json_encode($this->config->item('trs_status'));?>;

    var url = {
        data : base_url+'backend/transaksi/get_datatable',
        detail : base_url+'backend/transaksi/detail',
        add: base_url + 'backend/transaksi/add',
		edit: base_url + 'backend/transaksi/edit',
    };

    var dataTableObj = $("#transaksi_table").DataTable({
        processing:true,
        serverSide:false,
        bProcessing: true,
        stateSave: false,
        pagingType: 'full_numbers',
        ajax:{
            url: url.data,
            type: 'POST',
            dataType: "json",
            data: (dataReq)=>{ dataReq[csrf_name] = Cookies.get(csrf_name);return dataReq;}, 
        },
        'columns':[ 
            {   data:"trs_id",
                render: function(data, type, meta){
                    return '<input type="checkbox" name="trs_id[]" value="'+ data +'"/>';
                }
            },
            { data:"trs_code" },
            { data:"trs_date" },
            { data:"trs_invoicecode",
                render:function(data,type,meta){
                    return `<a style="color:blue;" href="${base_url}backend/invoice?inv_code=${data}">${data}</a>`;
                } 
            },
            { data:"trs_paygateway" },
            { data:"trs_total",render: function(data,type,meta){ return 'Rp.'+toCurrency(data)} },
            { data:"trs_name" },
            { data:"trs_email",visible:false },
            { data:"trs_note",visible:false },
            { data:"trs_photo",visible:false },
            { data:"trs_status",
                render:function(data,type,meta){
                    return transaksi_status[data].label;
                }
            },
            { 
                data:"trs_id",
                render: function(data, type, meta){
                    return `<div class="table-actions" style="text-align: left;">
                                    <a class="edit_act update_role"><i class="ik ik-edit-2"></i></a>
                            </div>`
                }
            }
        ],
        'createdRow': function(row,data,dataIndex){
          $(row).addClass('rowData').attr('data-id',data.trs_id);
        }
    });

    init_role(<?php echo json_encode($role);?>);

    page_click('#add_act',(e)=>{
        show_detail('add');
    });

    page_click('.edit_act',(e)=>{
        show_detail('edit',url,get_row_dataid('trs_id',e));
    });

    formPhoto_handler('#trs_photo');

    //handler submit form
    submitForm_handler('#form_detail',url,dataTableObj);

    select2ajax({
      selector: '.invoice-code-filter',
      url: base_url+'backend/invoice/get_invoiceajax',
      placeholder: 'Filter invoice code',
      minInput: 3,
      pk_id: 'inv_id',
      key_value: 'inv_code',
      selectedcallBack: (e)=>{
        data = $(".invoice-code-filter option:selected").html();
        dataTableObj.columns(3).search(data).draw();//3 is key of invoice code
      },
      clearcallBack: (e)=>{
          dataTableObj.columns(3).search('');
          dataTableObj.ajax.reload(null,false);
      },
      initValue: '<?php echo $inv_code;?>'
    });



   
});
</script>