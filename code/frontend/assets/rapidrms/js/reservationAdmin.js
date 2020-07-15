function statusUpdateMap (message){
    $.toast({
        text: message, 
        heading: 'Status Update Map', 
        showHideTransition: 'slide', 
        allowToastClose: true, 
        hideAfter: 2000, 
        position: 'top-center', 
        textAlign: 'left'
    });
}

$(document).ready(function() {
    //function to disable overflow
    var disableScroll = function(e){
        // don't know why this does not work, but the css fix does
        //fancyProductDesigner.currentViewInstance.stage.allowTouchScrolling = false;
        $('#canvas-wrapper').css('overflow','hidden');
        //var obj = e.target
        //console.log(obj.width*obj.scaleX);
        //console.log(obj.height* e.target.scaleY);
        
    };
    //function to enable overflow
    var enableScroll = function(){
        //fancyProductDesigner.currentViewInstance.stage.allowTouchScrolling = true;
        $('#canvas-wrapper').css('overflow','auto');
        $('#canvas-wrapper').css('overflow-x','visible');
    };
    //set image in canvas as background
    var setMapImage = function(imgUrl){
        $('#canvas').css(`background-size`,`100% 100%`);
        $('#canvas').css(`background-image`,`url(${imgUrl})`);
    };

    
    //create new table

    //TODO edit variable for create new table

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

    var loadDataTableMap = function(){
        $.ajax({
            url: base_url+"/rapidrms/Reservation/get_MapDetails",
            type: "post",
            dataType: "JSON",
            success : function(r){
             var json = r;
             $('#canvas').width(json.width);
             $('#canvas').height(json.height);
             setMapImage(base_url+"assets/rapidrms/img/"+json.imageData);
             canvas.clear().renderAll();
             json.tableMap.forEach(element => {
                createNewTable(parseInt(element.x),parseInt(element.y),parseInt(element.radius),parseInt(element.title),parseInt(element.id),parseInt(element.text_size),parseInt(element.capacity),parseInt(element.min_people));
                canvas.ObjectCounter['counterId'] = parseInt(element.id);
             });

            },
            error : function(jqXhr){
             if(jqXhr.status !== 200){ //validation error for responses not 200 OK
               var json = JSON.parse(jqXhr.responseText);
               console.log(json);
             } 
            }
          }).always(() => {
            
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
        'selection:created' : function(e){  //if clicked object
           /* e.target.set({
                lockScalingX: true,
                lockScalingY: true
            });
            */
           //e.target.hasControls = e.target.hasBorders = true;
           
        }
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
        if($('#table-capacity').val() < $('#table-min').val()){
            $('#table-capacity').addClass('is-invalid');
            $('#table-capacityError').show();
            capacity = false;
        }
        if($('#table-min').val() > $('#table-capacity').val()){
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
                id: item.id, 
                title:item.numberTable,
                capacity:item.capacity, 
                min_people:item.minimOrder,
                x:item.left,
                y:item.top,
                radius:item.getObjects()[0].radius,
                text_size:item.getObjects()[1].fontSize
            }));
            var responses = new Array();
            $.ajax({
                url: base_url+"/rapidrms/Reservation/setMapData",
                type: "post",
                dataType: "JSON",
                data: {
                    "tableData" : JSON.stringify(data)
                },
                success : function(r){
                    var json = r;
                    responses['icon'] = 'success'
                    responses['message'] = json.message;
                },
                error : function(jqXhr){
                 if(jqXhr.status !== 200){ //validation error for responses not 200 OK
                   var json = JSON.parse(jqXhr.responseText);
                    responses['icon'] = 'error';
                    responses['message'] = json.message;
                 } 
                }
              }).always(() => {
                //loadDataTableMap(); 
                $.toast({
                    text: responses['message'], 
                    heading: 'Status Meja Reservasi', 
                    icon: responses['icon'], 
                    showHideTransition: 'slide', 
                    allowToastClose: true, 
                    hideAfter: 2000, 
                    position: 'top-center', 
                    textAlign: 'left'
                });
            })
        }
    })
    
    
    //load datatable if refresh 
    loadDataTableMap(); 


               

});