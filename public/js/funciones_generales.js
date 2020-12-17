var MSG_WARNING = "warning";
var MSG_SUCCESS = "success";
var MSG_ERROR = "danger";
var MSG_INFO = "info";

function msgShow(mensaje, tipo) {
    switch (tipo) {
        case MSG_WARNING:
        {
            $("#msg").addClass("alert alert-warning");
            $("#msg").html("<strong>Alerta:</strong> " + mensaje);
            break;
        }
        case MSG_SUCCESS:
        {
            $("#msg").addClass("alert alert-success");
            $("#msg").html("<strong>&#161;Bien&#33; </strong> " + mensaje);
            break;
        }
        case MSG_ERROR:
        {
            $("#msg").addClass("alert alert-danger");
            $("#msg").html("<strong>&#161;Error&#33; </strong> " + mensaje);
            break;
        }
        case MSG_INFO:
        {
            $("#msg").addClass("alert alert-info");
            $("#msg").html("<strong>&#161;Atento&#33; </strong> " + mensaje);
            break;
        }
    }
    $("#msg").show();
    $("html, body").animate({scrollTop: 0}, 300);
}
function abrirFormularioAlta(nombreFormAlta) {
    window.location = "index.php?pg=" + nombreFormAlta;
}