var cartBackend = function(options){

    var vars = {
        mode  : 'add',
        urlAddOrder: null,
        urlEditOrder: null,
        order_id: null,
        dataItem : new Array(),
        dataReservation : {},
        detailPayment : new Array(),
        tableItemSelector: null,
        totalPriceItemSelector: null,
        totalFinalSelector: null,
        totalPrice: 0,
        typeOrder : 'katering'
    };
   
    //can access method in this clas use root.method()
    var root = this;

    //constructor
    this.construct = function(options){
        $.extend(vars, options);
        initEvent();
    }

    var updateSubtotalItem = function(index){
        vars.dataItem[index].subtotal = vars.dataItem[index].price * vars.dataItem[index].quantity;
        root.renderTable();
    }

    var getItemIndexByattr = function(attr, value){
        return vars.dataItem.findIndex(el => el[attr] === value);
    }

    var getdetailIndexByid = function(id){
        return vars.detailPayment.findIndex(el => el.id === id);
    }

    var getRowDataID = function(element){
        return $(element).closest('tr').attr('data-id');
    }

    this.addReservation = function(tableId,startDate, totPeople){
        vars.dataReservation = {};//delete first
        vars.dataReservation = {
            'odr_table' : tableId,
            'odr_start' : startDate,
            'odr_people': totPeople
        };
    }

    this.getReservation = function(){
        return vars.dataReservation;
    }

    this.setOrderType = function(type){
        vars.typeOrder = type;
    }

    this.getOrderType = function(){
        return vars.typeOrder;
    }


    this.addItem = function(options){
        const index = getItemIndexByattr('id',options.id)
        if(index !== -1){
            vars.dataItem[index].quantity = parseInt(vars.dataItem[index].quantity) + 1;
            updateSubtotalItem(index);
        }else
        {
            vars.dataItem.push({
                id: options.id,
                name: options.name,
                type: options.type,
                price: parseFloat(options.price),
                quantity: parseInt(options.quantity),
                min_order: parseInt(options.min_order),
                subtotal: (parseFloat(options.price) * parseInt(options.quantity)),
                note: '', 
                add_date: new Date()
            });
            root.renderTable();
        }
    }

    this.addAdditionalItem = function(options){
        const index = getItemIndexByattr('id','ADD'+options.id);
        if(index !== -1){
            vars.dataItem[index].quantity = parseInt(vars.dataItem[index].quantity) + 1;
            updateSubtotalItem(index);
        }else{
            vars.dataItem.push({
                id: 'ADD'+options.id,
                origin_id: options.id,
                name: options.name,
                type: 'Menu tambahan',
                price: parseFloat(options.price),
                min_order: parseInt(options.quantity),
                quantity: parseInt(options.quantity),
                subtotal: (parseFloat(options.price) * parseInt(options.quantity)),
                parentId : options.parentId
            });
            root.renderTable();
        }
        
    }

    this.removeItem = function(options){
        const index = getItemIndexByattr('id',options.id)
        if(index !== -1){
            vars.dataItem.splice(index,1);
        }
        root.renderTable();
    }

    this.updateQuantityItem = function(options){
        const index = getItemIndexByattr('id',options.id)
        if(index !== -1){
            vars.dataItem[index].quantity = options.quantity;
            updateSubtotalItem(index);
        }
    }

    this.updateNoteItem = function(options){
        const index = getItemIndexByattr('id',options.id)
        if(index !== -1){
            vars.dataItem[index].note = options.note;
        }
    }

    this.showAllItem = function(){
        return vars.dataItem;
    }

    this.removeAllItem = function(){
        vars.dataItem = {}
    }

    var updateDetailPayment = function(){
        vars.detailPayment = [];
        var tempTotal = 0;
        //update the item cart
        totalItem = 0;
        $.each(vars.dataItem,function(idx,obj){
            totalItem += obj.subtotal;
        });

        vars.detailPayment.push({
            id: "item",
            desc: "Total item menu",
            value: totalItem,
            type: "add",
            color: "primary"
        });
        tempTotal = totalItem;
        itemTotal = tempTotal;  //use for calculate tax

        //update the discount 
        if($('#ord_discount').val() !== ""){
            if($('#ord_discount option').filter(':selected').data('unit') === "cash"){
                var disc_value = parseFloat($('#ord_discount option').filter(':selected').data('value'));
                tempTotal -= disc_value;
            }else{
                var disc_value = (tempTotal * (parseFloat($('#ord_discount option').filter(':selected').data('value'))/100));
                tempTotal -= disc_value;
            }  
            vars.detailPayment.push({
                id: "discount",
                desc: $('#ord_discount option').filter(':selected').text().trim(),
                value: disc_value,
                type: "minus",
                color: "danger"
            })
        }

        //update the tax
        if($('#tax_id').val().length !== 0){
            $('#tax_id').val().forEach((item,idx)=>{
                var tax_value = 0;
                if($(`#tax_id option[value=${item}]:selected`).data('unit') === "cash"){
                    tax_value = parseFloat($(`#tax_id option[value=${item}]:selected`).data('value'));
                    tempTotal += tax_value;
                }else{
                    //tax add to total item
                    tax_value = (itemTotal * (parseFloat($(`#tax_id option[value=${item}]:selected`).data('value'))/100));
                    tempTotal += tax_value;
                }
                vars.detailPayment.push({
                    id: "pajak-"+idx,
                    desc: $(`#tax_id option[value=${item}]:selected`).text().trim(),
                    value: tax_value,
                    type: "add",
                    color: "primary"
                })
            })
        }

        vars.totalPrice = tempTotal;
        return tempTotal;
    }


   
    this.renderTable = function(){
        updateDetailPayment(); //update the current page total

        $(vars.tableItemSelector+' tbody').empty();//reset all table to render again
        vars.dataItem.forEach(function (r) {
            var html = `<tr data-id=${r.id}>
                      <td>${r.name}</td>
                      <td>${r.type}</td> 
                      <td>Rp.${toCurrency(r.price)}</td> 
                      <td><input type="number" min="${r.min_order}" class="input-quantity-item text-center" style="width:70px;" value="${r.quantity}"></td> 
                      <td style="text-align: right">Rp.${toCurrency(r.subtotal)}</td> 
                      <td title="Action for item cart" class="text-center" >
                        <div class="btn-group" role="group" aria-label="action-item">
                        <button type="button" class="btn btn-xs btn-danger remove-item-btn"><i class="fas fa-fw fa-trash"></i></button>
                        ` + (typeof r.parentId == "undefined" ? 
                        `<div class="btn-group" role="group">
                            <button type="button" class="btn btn-xs btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-fw fa-chevron-down"></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                <a class="dropdown-item note-item-btn" href="#"><i class="fas fa-fw fa-sticky-note"></i> Note</a>
                                <a class="dropdown-item additional-item-btn " href="#"><i class="fas fa-fw fa-plus"></i> Menu tambahan</a>
                            </div>
                        </div>
                        </div>` : ``) +
                      `</td>                  
                    </tr>`;
            $(vars.tableItemSelector+' tbody').append(html);

            $(vars.totalPriceItemSelector).text('Rp.'+toCurrency(vars.detailPayment[getdetailIndexByid('item')].value));
            
            $(vars.totalFinalSelector).text('Rp. '+toCurrency(vars.totalPrice));
            
            //update detail payment,clear first
            $('#description-payment').empty();
            $('#value-payment').empty();

            vars.detailPayment.forEach((item,idx)=>{
                $('#description-payment').append(`<span data-id="${item.id}">${item.desc}</span><br>`);
                $('#value-payment').append(` <span class="text-${item.color}" data-value="${item.id}">
                ${item.type == "add" ? '+' : '-'} Rp. ${toCurrency(item.value)}</span><br>`)
            })

        })
    }

    var initEvent = function(){
        //event for item quantity changing
        $('body').on('change keyup','.input-quantity-item',function(){
            var val = $(this).val();
            var itemId = getRowDataID(this);
            delay(function(){
                root.updateQuantityItem({
                    id: itemId,
                    quantity: val
                });
            }, 300);
        });

        //event for item delete
        $('body').on('click','.remove-item-btn',function(){
            var itemId = getRowDataID(this);
            root.removeItem({
                id: itemId
            })
            root.renderTable();
            //update total to 2
            $(vars.totalPriceItemSelector).text('Rp.'+toCurrency(vars.detailPayment[getdetailIndexByid('item')].value));
        });

        $('body').on('click','.note-item-btn',function(){
            var itemId = getRowDataID(this);
            var index = getItemIndexByattr('id',itemId);
            $.confirm({
                title: 'Note',
                content: '' +
                '<form action="" >' +
                '<div class="form-group">' +
                '<label>Masukkan catatan pesanan</label>' +
                '<input type="text" placeholder="contoh : yang pedas ya" class="note form-control"/>' +
                '</div>' +
                '</form>',
                buttons: {
                    formSubmit: {
                        text: 'Submit',
                        btnClass: 'btn-blue',
                        action: function () {
                            var note = this.$content.find('.note').val();
                            if(!note){return false;}
                            root.updateNoteItem({id: itemId,note:note});
                        }
                    },
                    batal: function () {},
                },
                onOpenBefore: function () {
                    this.$content.find('.note').val(vars.dataItem[index].note)
                }
            });})

        //event for add menu tambahan
        $('body').on('click','.additional-item-btn',function(){
                var itemId = getRowDataID(this);
                $.confirm({
                    title: 'Menu tambahan',
                    content: `
                        <form action="">
                        <div class="form-group">
                            <label for="">Cari menu tambahan yang ingin ditambah</label>
                            <select class=" form-control add-menuadditional-search"></select>
                        </div>
                        </form>
                        `,
                    buttons:{
                        formSubmit: {
                            text: 'Tambah',
                            btnClass: 'btn-blue',
                            action: function () {
                                var element = this.$content.find('.add-menuadditional-search').children("option:selected");
                                if(!element.val()){return false;}
                                root.addAdditionalItem({
                                    id: element.val(),
                                    name: element.text().split('--',1)[0].trim(),
                                    price: element.data('price'),
                                    quantity: 1,
                                    parentId: itemId
                                });
                            }
                        },
                        batal : ()=>{}
                    },
                    onOpenBefore: function () {
                        var select_additional = this;
                        this.$content.find('.add-menuadditional-search').append(`
                                    <option value="" disabled selected>Silahkan pilih menu tambahan</option>
                        `);
                        ajaxExtend({
                            url: base_url+'backend/menu/detail',
                            data: { 'mnu_id': itemId},
                            success: function(resp){
                                if(resp.status === "success"){
                                    $.each(resp.data.mnu_additionaldetail, function(idx,value){
                                        select_additional.$content.find('.add-menuadditional-search').append(`
                                            <option value="${value[0].mad_id}" data-price="${value[0].mad_price}">
                                            ${value[0].mad_name} -- Rp.${value[0].mad_price}
                                            </option>
                                        `);
                                    })
                                }
                            },
                            error: function(jxhr){ }
                        })
                    }
                });
            })
        
        $('#ord_discount').on('change',(e) => {
            root.renderTable()
        })

        $('#tax_id').on('change',(e) => {
            root.renderTable()
        })
    }

    var serializeData = function(){
        dataOrderMenu = new Array();
        dataReservation = {};
        dataDelivery = {};
        dataCustomer = {};

        $.each(vars.dataItem,function(idx,value){
            if(typeof(value.parentId) == 'undefined'){//is menu utama
                value.menu_additional = vars.dataItem.filter(el => el.parentId == value.id);
                dataOrderMenu.push(value);
            }
        })
        if(!$("#odr_type").prop('checked')){
            dataReservation = vars.dataReservation;
        }
        if($("#ord_isdelivery").prop('checked')){
            dataDelivery.ord_delivaddress = $('#ord_delivaddress').val();
            dataDelivery.ord_delivcity = $('#ord_delivcity').val();
            dataDelivery.ord_delivprovince = $('#ord_delivprovince').val();
            dataDelivery.ord_delivzip = $('#ord_delivzip').val();
        }
        if(!$("#ord_iscustdatabase").prop('checked')){
            dataCustomer.cst_name = $('#cst_name').val();
            dataCustomer.cst_phone = $('#cst_phone').val();
            dataCustomer.cst_address = $('#cst_address').val();
        }
        return {tax : $('#tax_id').val(), ord_discount : $('#ord_discount').val(),
                ord_fordate: $('#ord_fordate').val(),inv_paygateway: $('#inv_paygateway').val(),
                inv_isdp: $('#ord_isdp').prop('checked'),inv_customer: $('#inv_customer').val(),
                order_item : dataOrderMenu,reservation : dataReservation,
                deliv_data : dataDelivery,new_customer:dataCustomer};
    }

    
    this.submitOrder = function(options){     
        
        ajaxExtend({
            url: base_url+'backend/pemesanan/checkout',
            data: serializeData(),
            success: options.success,
            error: options.error
        })
        
    }


    //Helpers


    var delay = (function(){
        var timer = 0;
        return function(callback, ms){
          clearTimeout(timer);
          timer = setTimeout(callback,ms);
        };
      })();  

    this.construct(options)



}