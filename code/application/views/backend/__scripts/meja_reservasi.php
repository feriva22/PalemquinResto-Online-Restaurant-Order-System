<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<script type="text/javascript">
$(document).ready(function() {

    url = {
        upload_map : base_url+'backend/meja_reservasi/upload_map',
        detail     : base_url+'backend/meja_reservasi/detail',
        edit     : base_url+'backend/meja_reservasi/edit'
    };

    var disableScroll = function(){
        $('#canvas-wrapper').css('overflow','hidden');
    }
    var enableScroll = function(){
        $('#canvas-wrapper').css('overflow','auto');
        $('#canvas-wrapper').css('overflow-x','visible');
    };
    var setMapImage = function(imgUrl){
        $('#canvas').css(`background-size`,`100% 100%`);
        $('#canvas').css(`background-image`,`url(${imgUrl})`);
    };

    var createNewTable = function(x,y,rad,number,id,fontSize,capacity,minOrder){
        var circle = new fabric.Circle({
            radius:rad , 
            fill: 'red',
            opacity : 0.5,
            originX: 'center',
            originY: 'center'
        });
        var text = new fabric.Text(''+(number)
        , {
          fontSize: fontSize,
          originX: 'center',
          originY: 'center'
        });
       var group = new fabric.Group([ circle, text ], {
            id: id,
            numberTable : number,  
            capacity : capacity,
            minimOrder: minOrder,
            top: y, 
            left:x,
            borderColor: 'red',
            cornerColor: 'green',
            cornerSize: 6,
            transparentCorners: false,
            hasControls : false, //disable if want enable control
            hasBorders : false  //disable if want enable control
        });
        canvas.add(group);
        canvas.requestRenderAll();
    }

    var get_mapdata = function(){
        canvas.clear();
        ajaxExtend({
            url: url.detail,
            data: {},
            success: function(resp){
                if(resp.status == "success"){
                    data = resp.data;
                    $('#canvas').width(data.imageData.width);
                    $('#canvas').height(data.imageData.height);
                    setMapImage(base_url+data.imageData.url);
                    if(data.map_data !== null){
                        data.map_data.forEach(e => {
                            attr = JSON.parse(e.tbm_attr);
                            createNewTable(parseInt(attr.loc_x),
                                           parseInt(attr.loc_y),
                                           parseInt(attr.rad_circle),
                                           e.tbm_name,
                                           e.tbm_id,
                                           attr.text_size,
                                           e.tbm_max,
                                           e.tbm_min
                                           );
                            canvas.ObjectCounter['counterId'] = parseInt(e.tbm_id);
                        });
                    }
                }
            },
            error: function(jxhr){
                show_notification('error','Terjadi error');
            }
        })
    }

    var canvas = this.__canvas = new fabric.Canvas('canvas',{
        selection : false,
        controlsAboveOverlay:true,
        centeredScaling:true,
        allowTouchScrolling: true
    });
    canvas.ObjectCounter = {};
    canvas.ObjectCounter['counterId'] = 0;
    
    //event on canvas
    canvas.on({
        'mouse:up' : enableScroll,
        'mouse:down': function(options){
            if(!canvas.findTarget(options)){
                canoffset = $('canvas').offset();
                x = options.e.clientX + document.body.scrollLeft + document.documentElement.scrollLeft - Math.floor(canoffset.left);
                y = options.e.clientY + document.body.scrollTop + document.documentElement.scrollTop - Math.floor(canoffset.top) + 1;
                createNewTable(x,y,15,++canvas.ObjectCounter['counterId'],canvas.ObjectCounter['counterId'],20,1,1);
            }
        },
        'object:moving' : disableScroll,
        'object:scaling' : disableScroll,
        'object:rotating' : disableScroll,
        'selection:created' : function(e){}
    });

    // mouse event double click table
    fabric.util.addListener(canvas.upperCanvasEl, 'dblclick', function(e) {
        if (canvas.findTarget(e)) {
            objectTable = canvas.findTarget(e);
            const objType = objectTable.type;
            if (objType !== 'image') {
                //alert('double clicked on not image! '+canvas.findTarget(e).id);
                $('#editTableId').data("id",objectTable.id);
                $('#table-number').attr('value',canvas.findTarget(e).numberTable);
                $('#table-capacity').attr('value',objectTable.capacity);
                $('#table-min').attr('value',objectTable.minimOrder);
                $('#editTableId').modal('show');
            }
        }
    });

    //reset form if hidden
    $('#editTableId').on('hidden.bs.modal', function(){
        $(this).find('form')[0].reset();
        $('.error').hide();
        $('.form-control').removeClass('is-invalid');
    })

    //delete table push
    $("#deleteTable").on('click',function(){
        var SelectObject = canvas.getActiveObject();
        if(SelectObject){
            if (confirm('Apa anda yakin ingin menghapus ?')) {
                canvas.remove(SelectObject);
                $('#editTableId').modal('hide');
            }
        }
    });

    //submit edit table
    $('#editTableId').submit(function(e){
        e.preventDefault();
        var tnumber = true;
        var capacity = true;
        var minOrder = true;
        var SelectObject = canvas.getActiveObject();

        var result = canvas.getObjects().find((e) => {
            return (e.numberTable === parseInt($('#table-number').val(),10) &&  parseInt($('#table-number').val(),10) !== SelectObject.numberTable);
        })
        if(typeof result !== 'undefined'){
            $('#table-number').addClass('is-invalid');
            $('#table-numberError').show();
            tnumber = false;
        }
        if(parseInt($('#table-capacity').val()) < parseInt($('#table-min').val())){
            $('#table-capacity').addClass('is-invalid');
            $('#table-capacityError').show();
            capacity = false;
        }
        if(parseInt($('#table-min').val()) > parseInt($('#table-capacity').val())){
            $('#table-min').addClass('is-invalid');
            $('#table-minError').show();
            minOrder = false;
        }
        
        if(tnumber && capacity && minOrder){
            if(SelectObject){
                if(confirm('Apa anda yakin ingin mengubah ?')){
                    SelectObject.getObjects()[1].set({ text: ''+$('#table-number').val() });
                    SelectObject.numberTable = parseInt($('#table-number').val(),10);
                    SelectObject.capacity = parseInt($('#table-capacity').val(),10);
                    SelectObject.minimOrder = parseInt($('#table-min').val(),10);
                    canvas.renderAll();
                    $('#editTableId').modal('hide');
                }
            }
        }
    });

    //save map push
    $("#saveMap").on('click',function(){
        if(confirm('Apa anda yakin ingin mengupdate Meja Reservasi ?')){
            var data = canvas.getObjects().map(item => ({ 
                tbm_id: item.id, 
                tbm_name:item.numberTable,
                tbm_max: item.capacity,
                tbm_min: item.minimOrder,
                tbm_attr: { 'loc_x' : item.left,'loc_y' : item.top,'rad_circle':item.getObjects()[0].radius,'text_size':item.getObjects()[1].fontSize }
            }));

            ajaxExtend({
                url: url.edit,
                data : {table_map : data},
                success: function(resp){
                    if(resp.status == "success"){                        
                        show_notification('success',resp.message);
                        get_mapdata();
                    }
                },
                error: function(jxhr){
                    show_notification('error','Error terhubung ke server');
                }
            })
        }
    })

    $('#map_upload_form').submit(function(e){
        e.preventDefault();
        var img_data = $("#map_upload")[0].files[0]
        uploadImage(url.upload_map,img_data,(resp)=>{
            get_mapdata();
            show_notification('success',resp.message);
        })
    })

    get_mapdata();
});
</script>