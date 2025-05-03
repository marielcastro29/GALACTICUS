$(document).ready(function() {

    $('#suc_id').select2();

    $.post("controller/sucursal.php?op=combo", function(data){
        $("#suc_id").html(data);
    });


});

$(document).on("click", ".toggle-eye", function () {
    let icon = $(this).find("i");
    let input = $(this).siblings("input");

    if (input.attr("type") === "password") {
        input.attr("type", "text");
        icon.removeClass("ri-eye-off-line").addClass("ri-eye-line");
    } else {
        input.attr("type", "password");
        icon.removeClass("ri-eye-line").addClass("ri-eye-off-line");
    }
});
