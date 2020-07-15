<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<script type="text/javascript">
$(document).ready(function() {

    var type_payment = <?php echo json_encode($type_payment);?>;
    var url = {
        data : base_url+'backend/payment_gateway/get_datatable',
        detail : base_url+'backend/payment_gateway/detail',
        add: base_url + 'backend/payment_gateway/add',
		edit: base_url + 'backend/payment_gateway/edit',
		delete: base_url + 'backend/payment_gateway/delete',
    };

    var dataTableObj = $("#payment_gateway_table").DataTable({
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
            {   data:"pyg_id",
                render: function(data, type, meta){
                    return '<input type="checkbox" name="pyg_id[]" value="'+ data +'"/>';
                }
            },
            { data:"pyg_name" },
            { data:"pyg_detail" },
            { data:"pyg_type" , 
                render:function(data,type,meta){
                    return type_payment[data];
                }},
            { data:"pyg_status",
                render:function(data,type,meta){
                    return (data == <?php echo PUBLISH;?>) ? 'Publish' : 'Draft' ;
                }
            },
            { 
                data:"pyg_id",
                render: function(data, type, meta){
                    return `<div class="table-actions">
                                    <a class="edit_act update_role"><i class="ik ik-edit-2"></i></a>
                                    <a class="delete_act delete_role"><i class="ik ik-trash-2"></i></a>
                            </div>`
                }
            }
        ],
        'createdRow': function(row,data,dataIndex){
          $(row).addClass('rowData').attr('data-id',data.pyg_id);
        }
    });

    init_role(<?php echo json_encode($role);?>);

    page_click('#add_act',(e)=>{
        show_detail('add');
    });

    page_click('.edit_act',(e)=>{
        show_detail('edit',url,get_row_dataid('pyg_id',e));
    });

    page_click('.delete_act',(e)=>{
        deleteData_handler(url,get_row_dataid('pyg_id',e,true),dataTableObj);
    });

    page_click('#multidel_act',(e)=>{
        var row_selected = get_checked_row('pyg_id');
        if(row_selected['pyg_id'].length != 0){
            deleteData_handler(url,row_selected,dataTableObj);
        }else{
            show_notification('warning','Pilih data !');
        }
    });

    //handler submit form
    submitForm_handler('#form_detail',url,dataTableObj);
});
</script>