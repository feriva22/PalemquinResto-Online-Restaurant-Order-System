<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<script type="text/javascript">
$(document).ready(function() {

    var url = {
        data : base_url+'backend/diskon/get_datatable',
        detail : base_url+'backend/diskon/detail',
        add: base_url + 'backend/diskon/add',
		edit: base_url + 'backend/diskon/edit',
		delete: base_url + 'backend/diskon/delete',
    };

    var dataTableObj = $("#diskon_table").DataTable({
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
            {   data:"dsc_id",
                render: function(data, type, meta){
                    return '<input type="checkbox" name="dsc_id[]" value="'+ data +'"/>';
                }
            },
            { data:"dsc_name" , visible: true},
            { data:"dsc_value" , visible: true},
            { data:"dsc_unit" , visible: true,
                render:function(data,type,meta){
                    return (data == <?php echo CASH;?>) ? 'Cash' : 'Percent'
                }
            },
            { data:"dsc_expired" , visible: true},
            { data:"dsc_status" ,
                render:function(data,type,meta){
                    return (data == <?php echo PUBLISH;?>) ? 'Publish' : 'Draft';
                }
            },
            { 
                data:"dsc_id",
                render: function(data, type, meta){
                    /*return `<button class="btn btn-sm btn-success btn-edit" data-id=${data}><i class="far fa-edit"></i></button>
                            <button class="btn btn-sm btn-danger btn-delete" data-id=${data}><i class="fa fa-trash"></i></button>`;*/

                    return `<div class="table-actions">
                                    <a class="edit_act update_role"><i class="ik ik-edit-2"></i></a>
                                    <a class="delete_act delete_role"><i class="ik ik-trash-2"></i></a>
                            </div>`
                }
            }
        ],
        'createdRow': function(row,data,dataIndex){
          $(row).addClass('rowData').attr('data-id',data.dsc_id);
        }
    });

    init_role(<?php echo json_encode($role);?>);

    page_click('#add_act',(e)=>{
        show_detail('add');
    });

    page_click('.edit_act',(e)=>{
        show_detail('edit',url,get_row_dataid('dsc_id',e));
    });

    page_click('.delete_act',(e)=>{
        deleteData_handler(url,get_row_dataid('dsc_id',e,true),dataTableObj);
    });

    page_click('#multidel_act',(e)=>{
        var row_selected = get_checked_row('dsc_id');
        if(row_selected['dsc_id'].length != 0){
            deleteData_handler(url,row_selected,dataTableObj);
        }else{
            show_notification('warning','Pilih data !');
        }
    });

    //handler submit form
    submitForm_handler('#form_detail',url,dataTableObj);
});
</script>