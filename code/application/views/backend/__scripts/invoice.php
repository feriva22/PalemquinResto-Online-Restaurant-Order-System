<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<script type="text/javascript">
$(document).ready(function() {

    var invoice_status = <?php echo json_encode($this->config->item('invoice_status'));?>;
    var url = {
        data : base_url+'backend/invoice/get_datatable',
        detail : base_url+'backend/invoice/detail',
        add: base_url + 'backend/invoice/add',
		edit: base_url + 'backend/invoice/edit',
		delete: base_url + 'backend/invoice/delete'
    };

    var dataTableObj = $("#invoice_table").DataTable({
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
            {   data:"inv_id",
                render: function(data, type, meta){
                    return '<input type="checkbox" name="inv_id[]" value="'+ data +'"/>';
                }
            },
            { data:"inv_code" },
            { data:"inv_order" ,
                render:function(data,type,meta){
                    return `<a style="color:blue;" 
                    href="${base_url}backend/pemesanan?ord_code=${data}">${data}</a>`;
                }
            },
            { data:"inv_customer",visible:false },
            { data:"inv_date" },
            { data:"inv_duedate" },
            { data:"inv_paygateway", visible:false},
            { data:"inv_isdp",visible:false },
            { data:"inv_dp",visible:false },
            { data:"inv_dpvalue",visible:false },
            { data:"inv_total",render: function(data,type,meta) {
                return `Rp.${toCurrency(data)}`} 
            },
            { data:"inv_status",
                render:function(data,type,meta){
                    return invoice_status[data].label;
                }
            },
            { data:"inv_created",visible:false },
            { data:"inv_updated",visible:false },
            { 
                data:"inv_code",
                render: function(data, type, meta){
                    return `
                    <div class="btn-group" role="group" aria-label="action-item">
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-xs btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-fw fa-chevron-down"></i>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                            <a class="dropdown-item show-invoice-btn" target="_blank" href="${base_url}backend/invoice/view_invoice?inv_code=${data}"><i class="fas fa-fw fa-eye"></i> Lihat invoice</a>
                            <a class="dropdown-item change-status-btn" href="#"><i class="fas fa-fw fa-pencil-alt"></i> Ubah status</a>
                            <a class="dropdown-item " target="_blank" href="${base_url}backend/transaksi?inv_code=${data}"><i class="fas fas fa-search-dollar"></i> Transaksi</a>
                        </div>
                    </div>
                    </div>
                    `;
                }
            }
        ],
        'createdRow': function(row,data,dataIndex){
          $(row).addClass('rowData').attr('data-id',data.inv_id);
        }
    });

    init_role(<?php echo json_encode($role);?>);

    page_click('#add_act',(e)=>{
        show_detail('add');
    });

    page_click('.edit_act',(e)=>{
        show_detail('edit',url,get_row_dataid('inv_id',e));
    });

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
        dataTableObj.columns(1).search(data).draw();//3 is key of invoice code
      },
      clearcallBack: (e)=>{
          dataTableObj.columns(1).search('');
          dataTableObj.ajax.reload(null,false);
      },
      initValue: '<?php echo $inv_code;?>'
    }); 

    page_click('.change-status-btn',(e)=>{
        param = get_row_dataid('inv_id',e);
        $.confirm({
            title: 'Ubah Status',
            content: `
                <form action="">
                <div class="form-group">
                    <label for="">Ubah status invoice</label>
                    <select class=" form-control invoice-status-option">
                    </select>
                </div>
                </form>
                `,
            buttons:{
                formSubmit: {
                    text: 'Ubah',
                    btnClass: 'btn-blue',
                    action: function () {
                        $.extend(param, {
                            inv_status : this.$content.find('.invoice-status-option').val()}
                        );
                        ajaxExtend({
                            url: base_url+'backend/invoice/edit',
                            data: param,
                            success: function(resp){
                                show_notification(resp.status,resp.message);
                                dataTableObj.ajax.reload(null,false);
                            },
                            error: function(jxhr){ show_notification('error','Error terkoneksi dengan server')}
                        })
                    }
                },
                batal : ()=>{}
            },
            onOpenBefore: function () {
                var select_additional = this;
                $.each(invoice_status,(idx,value)=>{
                    this.$content.find('.invoice-status-option').append(`
                        <option value=${idx}>${value.text}</option>`);
                })
                ajaxExtend({
                    url: base_url+'backend/invoice/detail',
                    data: param,
                    success: function(resp){
                        if(resp.status === "success"){
                           select_additional.$content.find('.invoice-status-option').val(resp.data.inv_status);
                        }
                    },
                    error: function(jxhr){ }
                })
            }
        });
    })

});
</script>