$(document).ready(function(){

    $('#suc_id').select2();

    $.post("controller/sucursal.php?op=combo", function(data){
        $("#suc_id").html(data);
    });
    
    
});
