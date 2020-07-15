<script type="text/javascript">
$(document).ready(function() {
    //init for initialization and event
    init = function(){
        $('#start_date').datetimepicker({
            format: 'YYYY-MM-DD'
        });
        $('#end_date').datetimepicker({
            format: 'YYYY-MM-DD',
            useCurrent: false
        });        
        $("#start_date").on("change.datetimepicker", function (e) {
            $('#end_date').datetimepicker('minDate', e.date);
        });
        $("#end_date").on("change.datetimepicker", function (e) {
            $('#start_date').datetimepicker('maxDate', e.date);
        });
        $('#type_report').change(function(){
            if($(this).val() == 'daily'){ 
                $('#start_date').datetimepicker('format','YYYY-MM-DD');
                $('#end_date').datetimepicker('format','YYYY-MM-DD');
            }
            else if($(this).val() == 'monthly'){
                $('#start_date').datetimepicker('format','YYYY-MM');
                $('#end_date').datetimepicker('format','YYYY-MM');
            }else{
                $('#start_date').datetimepicker('format','YYYY');
                $('#end_date').datetimepicker('format','YYYY');
            }
        })
    }

    init();
    
    $('#download_report').click(function(e){
        e.preventDefault();
        if($('input[name="start_date"]').val() == "" && $('input[name="end_date"]').val() == ""){
            show_notification('error','Masukkan rentang waktu');
        }else{
            window.location = 
            base_url+`backend/laporan/penjualan?
            type_report=${$('#type_report').val()}&
            start_date=${$('input[name="start_date"]').val()}&
            end_date=${$('input[name="end_date"]').val()}&
            act=download`;
        }
    })


 
})
</script>