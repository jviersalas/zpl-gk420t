
$(document).ready(function()
{
    setup_web_print();
    $('#btn-zpl').click(function(){
        var num = $( "input[name*='numero']" ).val();
        var parametros = {
            "numero" : num
        };
        imprimirZPLPedido(parametros);
    });
});