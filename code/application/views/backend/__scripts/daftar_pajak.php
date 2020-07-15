<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<script type="text/javascript">
$(document).ready(function() {

    var url = {
        data : base_url+'backend/daftar_pajak/get_datatable',
        detail : base_url+'backend/daftar_pajak/detail',
        add: base_url + 'backend/daftar_pajak/add',
		edit: base_url + 'backend/daftar_pajak/edit',
		delete: base_url + 'backend/daftar_pajak/delete',
    };

    var dataTableObj = $("#daftar_pajak_table").DataTable({
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
            {   data:"tax_id",
                render: function(data, type, meta){
                    return '<input type="checkbox" name="tax_id[]" value="'+ data +'"/>';
                }
            },
            { data:"tax_name" },
            { data:"tax_description" },
            { data:"tax_value" },
            { data:"tax_unit" ,
                render:function(data,type,meta){
                    return (data == <?php echo CASH;?>) ? 'Cash' : 'Percent';
                }
            },
            { data:"tax_status",
                render:function(data,type,meta){
                    return (data == <?php echo PUBLISH;?>) ? 
                    `<label class="badge badge-success">Publish</label>` :
                    `<label class="badge badge-danger">Draft</label>`
                }
            },
            { data:"tax_created",visible: false, },
            { data:"tax_updated",visible: false },
            { 
                data:"tax_id",
                render: function(data, type, meta){
                    /*return `<button class="btn btn-sm btn-success btn-edit" data-id=${data}><i class="far fa-edit"></i></button>
                            <button class="btn btn-sm btn-danger btn-delete" data-id=${data}><i class="fa fa-trash"></i></button>`;*/

                    return `<div class="table-actions" style="text-align: left;">
                                    <a class="edit_act update_role"><i class="ik ik-edit-2"></i></a>
                                    <a class="delete_act delete_role"><i class="ik ik-trash-2"></i></a>
                            </div>`
                }
            }
        ],
        'createdRow': function(row,data,dataIndex){
          $(row).addClass('rowData').attr('data-id',data.tax_id);
        }
    });

    init_role(<?php echo json_encode($role);?>);

    page_click('#add_act',(e)=>{
        show_detail('add');
    });

    page_click('.edit_act',(e)=>{
        show_detail('edit',url,get_row_dataid('tax_id',e));
    });

    page_click('.delete_act',(e)=>{
        deleteData_handler(url,get_row_dataid('tax_id',e,true),dataTableObj);
    });

    page_click('#multidel_act',(e)=>{
        var row_selected = get_checked_row('tax_id');
        if(row_selected['tax_id'].length != 0){
            deleteData_handler(url,row_selected,dataTableObj);
        }else{
            show_notification('warning','Pilih data !');
        }
    });

    //handler submit form
    submitForm_handler('#form_detail',url,dataTableObj);
});
</script>