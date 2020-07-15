$(document).ready(function(){

    $('body').on('click','.btnAddCart', function(){
        $idMenu = $(this).closest("div.item-list").data('idmenu');
        $qty = $(this).closest("div.qty-cart").find('input').val();
        $noteMenu = $(`#noteMenu-${$idMenu}`).val();
        $optionalMenu = new Array();

        $menuCart = {
            'menu_id' : $idMenu,
            'menu_qty' : $qty,
            'menu_note' : $noteMenu,
            'menu_opt': []
        };

        
        $.each($(`#menuOptional-${$idMenu}`).find($(`input[name="menutambahan[]"]:checked`)), function(){  
            $idMenuOpsi = $(this).attr('id').split("-")[2];
            $qtyMenuOpsi = $(`#menuOptional-${$idMenu}`).find($(`input[name="Quantitymenutambahan-${$idMenu}-${$idMenuOpsi}"]`)).val();
            $menuCart.menu_opt.push({
                'menuOpt_id' : $idMenuOpsi,
                'menuOpt_qty' : $qtyMenuOpsi,
            });
        });

        $.ajax({
            url : base_url+"Menu/add_to_cart",
            method : "POST",
            data : $menuCart,
            success: function(data){
                $('#detail_cart').html(data);
            }
        });
        
        $("html, body").animate({ scrollTop: $('.side-panel').offset().top }, 1000);
    })

    $('body').on('click','.updateCartItem',(function(ev){
        $('#editCartModal').data('rowidmenu',$(this).closest('li').data('rowid'))
        $('#editCartModal').modal('show');
    }))

    $('body').on('click','.deleteCartItem',(function(ev){
        $.ajax({
            url : base_url+"Menu/delete_all_cart",
            method : "POST",
            data : {row_id:$(this).closest('li').data('rowid')},
            success: function(data){
                $('#detail_cart').html(data);
            }
        });
    }))

    loadCartData = function(){
        $.ajax({
            url : base_url+"Menu/load_cart",
            method : "POST",
            success: function(data){
                $('#detail_cart').html(data);
            }
        })
    }

    init = function(){
        $('.titleMenuType').text($('.active.titleMenuTabNav a').text());
        loadCartData();
        //show toggle for panel checkout
        $('.sd-panel-heading ').toggle();
        $('.sd-panel-heading .slideToggle').toggle();
        if ( $('.menu-view-all').hasClass('blurred') ) {
            //do something it does have the protected class!
            /*
            $.when(() => {
                $('.menu-view-all.blurred').css({"filter": "blur(2px)", "opacity": "0.3"});
                $('.menu-view-all.blurred :input').prop("disabled",true);
            }).done(function(){
            */
                alert('Anda harus reservasi tempat terlebih dahulu untuk memesan menu restoran');
                $(location).attr('href',base_url+"Reservation/");
            /*})*/
	    }
    }

    init();


    
    
})