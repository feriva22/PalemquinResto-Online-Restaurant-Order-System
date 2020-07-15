$(document).ready(()=>{

var dataTableObj = $("#transaction_table").DataTable({
            processing:true,
            serverSide:false,
            bProcessing: true,
            stateSave: false,
            pagingType: 'full_numbers',
            ajax:{
                url: base_url+'customer/get_transaction',
                type: 'POST',
                dataType: "json",
            },
            'columns':[ 
                {   data:"trs_code"},
                { data:"trs_invoicecode" },
                { data:"trs_date"},
                { data:"trs_paygateway"},
                { data:"trs_total",
                    render: function(data,type,meta){
                        return 'Rp.'+data;
                    }
                },
                { data:"trs_status",
                    render: function(data,type,meta){
                        if(data == 0){
                            return `<span class="label label-warning">Menunggu Konfirmasi</span>`;
                        }else if(data == 1){
                            return `<span class="label label-success">Diterima</span>`;
                        }else{
                            return `<span class="label label-danger">Ditolak</span>`;
                        }
                    }
                }
            ],
            'createdRow': function(row,data,dataIndex){
              $(row).addClass('rowData').attr('data-id',data.trs_code);
            }
    });  
    
    
    $('#add_transaction').on('click',function(e){
        $('#add_transaction_modal').modal('show');
    })

        
})