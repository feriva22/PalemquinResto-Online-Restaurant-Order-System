$(document).ready(()=>{

var dataTableObj = $("#invoice_table").DataTable({
            processing:true,
            serverSide:false,
            bProcessing: true,
            stateSave: false,
            pagingType: 'full_numbers',
            ajax:{
                url: base_url+'customer/get_invoice',
                type: 'POST',
                dataType: "json",
            },
            'columns':[ 
                {   data:"inv_code"},
                { data:"inv_order" },
                { data:"inv_date"},
                { data:"inv_duedate"},
                { data:"inv_total",
                    render: function(data,type,meta){
                        return 'Rp.'+data;
                    }
                },
                { data:"inv_status",
                    render: function(data,type,meta){
                        if(data == 0){
                            return `<span class="label label-danger">UNPAID</span>`;
                        }else if(data == 2){
                            return `<span class="label label-success">PAID</span>`;
                        }else{
                            return `<span class="label label-default">CANCELED</span>`;
                        }
                    }
                },
                { 
                    data:"inv_code",
                    render: function(data, type, meta){
                        return `
                        <div class="btn-group" role="group" aria-label="action-item">
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-xs btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fa fa-chevron-down"></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                <a class="dropdown-item show-invoice-btn" target="_blank" href="${backend_url}backend/invoice/view_invoice?inv_code=${data}"><i class="fa fa-eye"></i> Lihat invoice</a><br>
                                <a class="dropdown-item " target="_blank" href="${base_url}customer/transaksi?inv_code=${data}"><i class="fa fa-money"></i> Transaksi</a>
                            </div>
                        </div>
                        </div>
                        `;
                    }
                }
            ],
            'createdRow': function(row,data,dataIndex){
              $(row).addClass('rowData').attr('data-id',data.inv_code);
            }
    });     

        
})