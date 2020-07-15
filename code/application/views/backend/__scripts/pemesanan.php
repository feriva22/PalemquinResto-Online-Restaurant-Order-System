<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<script type="text/javascript">
$(document).ready(function() {

    var order_status = <?php echo json_encode($this->config->item('order_status'));?>;
    var url = {
        data : base_url+'backend/pemesanan/get_datatable',
        add_index : base_url+'backend/pemesanan/tambah_pemesanan',
        cancel : base_url+'backend/pemesanan/cancel_order'
    };

    var dataTableObj = $("#pemesanan_table").DataTable({
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
            {   data:"ord_id",
                render: function(data, type, meta){
                    return '<input type="checkbox" name="ord_id[]" value="'+ data +'"/>';
                }
            },
            { data:"ord_code" },
            { data:"ord_fordate" },
            { data:"ord_date" },
            { data:"ord_isdelivery",visible:false },
            { data:"ord_delivaddress",visible:false },
            { data:"ord_delivcity",visible:false },
            { data:"ord_delivprovince",visible:false },
            { data:"ord_delivzip",visible:false },
            { data:"ord_subtotal",visible:false },
            { data:"ord_total",
                render:function(data,type,meta){
                    return 'Rp. '+toCurrency(data);
                } 
            },
            { data:"ord_discount",visible:false },
            { data:"ord_type" ,
                render:function(data,type,meta){
                    return data == <?php echo KATERING;?> ? 'Katering' : 'Reservasi';
                }},
            { data:"ord_status",
                render:function(data,type,meta){
                    return order_status[data].label;
                }
            },
            { data:"ord_created",visible:false },
            { data:"ord_updated",visible:false },
            { 
                data:"ord_code",
                render: function(data, type, meta){
                    return `
                    <div class="btn-group" role="group" aria-label="action-item">
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-xs btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-fw fa-chevron-down"></i>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                            <a class="dropdown-item " target="_blank" href="${base_url}backend/invoice?ord_code=${data}"><i class="fas fa-fw fa-eye"></i> Daftar invoice</a>
                            <a class="dropdown-item cancel-order-btn" href="#"><i class="fas fa-fw fa-trash-alt"></i> Batalkan Pemesanan</a>
                        </div>
                    </div>
                    </div>
                    `
                }
            }
        ],
        'createdRow': function(row,data,dataIndex){
          $(row).addClass('rowData').attr('data-id',data.ord_id);
        }
    });

    page_click('#add_act',(e)=>{
        document.location = url.add_index;
    })

    page_click('.cancel-order-btn',(e)=>{
        var ord_id = get_row_dataid('ord_id',e);
        $.confirm({
            title: 'Membatalkan pemesanan',
            content: 'ingin membatalkan pemesanan ?',
            buttons: {
                Konfirmasi: function () {
                    $.confirm({
                        title: 'Membatalkan pemesanan',
                        content: 'Invoice yang sudah terbayar tidak akan dibatalkan statusnya',
                        buttons:{
                            Yakin: function(){
                                ajaxExtend({
                                    url: url.cancel,
                                    data: ord_id,
                                    success: function(resp){
                                        show_notification(resp.status,resp.message);
                                        dataTableObj.ajax.reload(null,false);
                                    },
                                    error: function(jxhr){
                                        show_notification('error','Error terkoneksi dengan server');
                                    }
                                })
                            },
                            Batal: function(){}
                        }
                    })
                },
                Batal: function () {}
            }
        });
       
    })
});
</script>