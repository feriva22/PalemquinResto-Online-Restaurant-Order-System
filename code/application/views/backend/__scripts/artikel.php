<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<script type="text/javascript">
$(document).ready(function() {

    var url = {
        data : base_url+'backend/artikel/get_datatable',
        detail : base_url+'backend/artikel/detail',
        add: base_url + 'backend/artikel/add',
		edit: base_url + 'backend/artikel/edit',
        delete: base_url + 'backend/artikel/delete',
        img_upload: base_url + 'backend/artikel/upload_image',
        img_del: base_url + 'backend/artikel/delete_image'
    };

    var dataTableObj = $("#artikel_table").DataTable({
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
            {   data:"art_id",
                render: function(data, type, meta){
                    return '<input type="checkbox" name="art_id[]" value="'+ data +'"/>';
                }
            },
            { data:"art_staff" , visible: true},
            { data:"art_name" , visible: true},
            { data:"art_slug" , visible: false},
            { data:"art_content" , visible: false},
            { data:"art_status" ,
                render:function(data,type,meta){
                    return (data == <?php echo PUBLISH;?>) ? 'Publish' : 'Draft';
                }
            },
            { data:"art_created" , visible: true},
            { data:"art_updated" , visible: false},
            { 
                data:"art_id",
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
          $(row).addClass('rowData').attr('data-id',data.art_id);
        }
    });

    $('#art_content').summernote({
        height: 300,
        callbacks: {
            onImageUpload: (img) => {
                uploadImage(url.img_upload,img[0],(resp)=>{
                    $('#art_content').summernote("insertImage",resp.message)
                });
            },
            onMediaDelete: (target) => {
                deleteImage(url.img_del,target[0].src);
            }
        }
    });

    init_role(<?php echo json_encode($role);?>);

    page_click('#add_act',(e)=>{
        show_detail('add',null,null,true);
    });

    page_click('.edit_act',(e)=>{
        show_detail('edit',url,get_row_dataid('art_id',e),true);
    });

    page_click('.delete_act',(e)=>{
        deleteData_handler(url,get_row_dataid('art_id',e,true),dataTableObj);
    });

    page_click('#multidel_act',(e)=>{
        var row_selected = get_checked_row('art_id');
        if(row_selected['art_id'].length != 0){
            deleteData_handler(url,row_selected,dataTableObj);
        }else{
            show_notification('warning','Pilih data !');
        }
    });

    //handler submit form
    submitForm_handler('#form_detail',url,dataTableObj);
});
</script>