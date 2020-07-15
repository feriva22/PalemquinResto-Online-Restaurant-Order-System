<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<script type="text/javascript">
$(document).ready(function() {

    var url = {
        data : base_url+'backend/menu_tambahan/get_datatable',
        detail : base_url+'backend/menu_tambahan/detail',
        add: base_url + 'backend/menu_tambahan/add',
		edit: base_url + 'backend/menu_tambahan/edit',
		delete: base_url + 'backend/menu_tambahan/delete',
    };

    var dataTableObj = $("#menu_tambahan_table").DataTable({
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
            {   data:"mad_id",
                render: function(data, type, meta){
                    return '<input type="checkbox" name="mad_id[]" value="'+ data +'"/>';
                }
            },
            { data:"mad_name" },
            { data:"mad_price" },
            { data:"mad_status",
                render:function(data,type,meta){
                    return (data == <?php echo PUBLISH;?>) ? 'Publish' : 'Hide';
                }
            },
            { 
                data:"mad_id",
                render: function(data, type, meta){
                    return `<div class="table-actions" style="text-align: left;">
                                    <a class="edit_act update_role"><i class="ik ik-edit-2"></i></a>
                                    <a class="delete_act delete_role"><i class="ik ik-trash-2"></i></a>
                            </div>`
                }
            }
        ],
        'createdRow': function(row,data,dataIndex){
          $(row).addClass('rowData').attr('data-id',data.mad_id);
        }
    });

    init_role(<?php echo json_encode($role);?>);

    page_click('#add_act',(e)=>{
        show_detail('add');
    });

    page_click('.edit_act',(e)=>{
        show_detail('edit',url,get_row_dataid('mad_id',e));
    });

    page_click('.delete_act',(e)=>{
        deleteData_handler(url,get_row_dataid('mad_id',e,true),dataTableObj);
    });

    page_click('#multidel_act',(e)=>{
        var row_selected = get_checked_row('mad_id');
        if(row_selected['mad_id'].length != 0){
            deleteData_handler(url,row_selected,dataTableObj);
        }else{
            show_notification('warning','Pilih data !');
        }
    });

    //handler submit form
    submitForm_handler('#form_detail',url,dataTableObj);
});
</script>