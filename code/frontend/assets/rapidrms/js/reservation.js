$(document).ready(function() {

    var date = new Date();
    date.setDate(date.getDate());
    $("#datepicker").datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        todayHighlight: true,
        startDate: date
    });

    $('#timepicker').datetimepicker({
        format: 'HH:mm',
        useCurrent: false
    });

    //set image in canvas as background
    var setMapImage = function(imgUrl){
        $('#canvas').css(`background-size`,`100% 100%`);
        $('#canvas').css(`background-image`,`url(${imgUrl})`);
    };

    var canvas = this.__canvas = new fabric.Canvas('canvas',{
        selection : false,
        controlsAboveOverlay:true,
        centeredScaling:true,
        allowTouchScrolling: true
    });

    canvas.ObjectCounter = {};
    canvas.ObjectCounter['counterId'] = 0;

    var createNewTable = function(x,y,rad,number,id,fontSize,capacity,minOrder,color,selectable){
        var circle = new fabric.Circle({
            radius:rad , 
            fill: color,
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
            hasControls : false, 
            hasBorders : false,
            lockMovementX : true,
            lockMovementY : true,
            selectable : selectable
        });
        canvas.add(group);
        canvas.requestRenderAll();
    }


    canvas.on({'mouse:down': function(e){
        if (canvas.findTarget(e)) {
            objectTable = canvas.findTarget(e);
            if (objectTable.selectable) {
                $('#modalReservation').data('idSeat',objectTable.id);
                $('#no_mejaReservation').text(objectTable.numberTable);
                $('#date_Reservation').text($('#dateReservation').val());
                $('#time_Reservation').text($('#timeReservation').val());
                $('#people_Reservation').text($('#peopleReservation').val());
                $('#modalReservation').modal('show');
            }
        }
    }});

    $('body').on('click','.btnSaveReservation',function(e){
        $reservationData = {
            'idSeat' : $('#modalReservation').data('idSeat'),
            'noSeat' : objectTable.numberTable,
            'dateReservation' : $('#dateReservation').val(),
            'timeReservation' : $('#timeReservation').val(),
            'people' : $('#peopleReservation').val()
        };
        $.ajax({
            url : base_url+"Menu/add_reservation_cart",
            method : "POST",
            data : $reservationData,
            success: function(data){
                $(location).attr('href',base_url+"Menu/?menuType=6");
            }
        });
    })
    
    $('#reservationOrder').submit(function(e){
        e.preventDefault();
        var formData = new FormData(this);
        var responses = new Array();
        $.ajax({
            url: base_url+'Reservation/get_mapReservation',
            type: "post",
            data: formData,
            mimeType: 'multipart/form-data',
            contentType: false,
            cache: false,
            processData: false,
            success : function(r){
                var json = JSON.parse(r);
                responses['icon'] = 'success';
                responses['message'] = json.message;

                $('#canvas').width(json.width);
                $('#canvas').height(json.height);
                setMapImage(json.imageData);
                canvas.clear().renderAll();
                json.tableMap.forEach(element => {
                    createNewTable(parseInt(element.x),parseInt(element.y),parseInt(element.radius),parseInt(element.title),parseInt(element.id),parseInt(element.text_size),parseInt(element.capacity),parseInt(element.min_people),element.color,element.selected);
                    canvas.ObjectCounter['counterId'] = parseInt(element.id);
                });
            },
            error : function(jqXhr){
             if(jqXhr.status !== 200){ //validation error for responses not 200 OK
                var json = JSON.parse(jqXhr.responseText);
                responses['icon'] = 'error';
                responses['message'] = json.message;
            } 
            }
        }).always(()=>{
            $.toast({
                text: responses['message'], 
                heading: "Status Reservasi Meja", 
                icon: responses['icon'], 
                showHideTransition: 'slide', 
                allowToastClose: true, 
                hideAfter: 2000, 
                position: 'top-center', 
                textAlign: 'left'
        });
        });
    })



});