<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<script type="text/javascript">
$(document).ready(function() {

    var url = {
        data : base_url+'backend/menu/get_datatable',
        detail : base_url+'backend/menu/detail',
        add: base_url + 'backend/menu/add',
		edit: base_url + 'backend/menu/edit',
		delete: base_url + 'backend/menu/delete',
    };

    var dataTableObj = $("#menu_table").DataTable({
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
            {   data:"mnu_id",
                render: function(data, type, meta){
                    return '<input type="checkbox" name="mnu_id[]" value="'+ data +'"/>';
                }
            },
            { data:"mnu_name" },
            { data:"mnu_desc",visible:false },
            { data:"mnu_category" },
            { data:"mnu_price" },
            { data:"mnu_photo", visible : false },
            { data:"mnu_minorder" },
            { data:"mnu_variant_parent", visible: false },
            { data:"mnu_status",
                render:function(data,type,meta){
                    return (data == <?php echo PUBLISH;?>) ? 
                    `<label class="badge badge-success">Publish</label>` :
                    `<label class="badge badge-danger">Draft</label>`
                }
            },
            { data:"mnu_created",visible: false },
            { data:"mnu_updated", visible: false },
            { 
                data:"mnu_id",
                render: function(data, type, meta){
                    /*return `<button class="btn btn-sm btn-success btn-edit" data-id=${data}><i class="far fa-edit"></i></button>
                            <button class="btn btn-sm btn-danger btn-delete" data-id=${data}><i class="fa fa-trash"></i></button>`;*/

                    return `<div class="table-actions" style="text-align: left;" >
                                    <a class="edit_act update_role"><i class="ik ik-edit-2"></i></a>
                                    <a class="delete_act delete_role"><i class="ik ik-trash-2"></i></a>
                            </div>`
                }
            }
        ],
        'createdRow': function(row,data,dataIndex){
          $(row).addClass('rowData').attr('data-id',data.mnu_id);
        }
    });

    init_role(<?php echo json_encode($role);?>);



    page_click('#add_act',(e)=>{
        show_detail('add');
    });

    page_click('.edit_act',(e)=>{
        show_detail('edit',url,get_row_dataid('mnu_id',e));
    });

    page_click('.delete_act',(e)=>{
        deleteData_handler(url,get_row_dataid('mnu_id',e,true),dataTableObj);
    });

    page_click('#add_varian',(e)=>{
        $('#varian_modal').modal('show');
    });

    page_click('#add_menuadditional',(e)=>{
        $('#menuadditional_modal').modal('show');
    });

    page_click('#multidel_act',(e)=>{
        var row_selected = get_checked_row('mnu_id');
        if(row_selected['mnu_id'].length != 0){
            deleteData_handler(url,row_selected,dataTableObj);
        }else{
            show_notification('warning','Pilih data !');
        }
    });

    formPhoto_handler('#mnu_photo');

    //handler submit form
    submitForm_handler('#form_detail',url,dataTableObj);
});
</script>