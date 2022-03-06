/*###### CEOSPANEL ###########*/

$('#datainicial, #datafinal').datepicker({
    format: "dd/mm/yyyy",
    language: "pt-BR"
});

//reset date interval
$(document).on("change", "select#periodo", function() {
    $('#datainicial').val('');
    $('#datafinal').val('');
});

//abre janela fancy com as permissoes do usuário
$(document).on("click", "a.viewUserPerm", function(e) {

    var uuid = $(this).attr("data-useruid");
    $.fancybox({
        type: 'ajax',
        href: 'ajax.php?view=userPerms&useruid=' + uuid,
        padding: 0,
        autoSize: true
    });

});

//abre janela fancy com relatorio de notas ou pedidos no periodo informado
$(document).on("click", "a.showGrid", function(e) {
    var wbox = $(this).attr("data-wbox");
    var wdi = $(this).attr("data-di");
    var wdf = $(this).attr("data-df");
    $.fancybox({
        type: 'ajax',
        href: 'ajax.php?v=table&grid=' + wbox + '&di=' + wdi + '&df=' + wdf,
        padding: 0,
        autoSize: true,
        afterShow: function() {
            // Code to execute after the pop up shows
            //$('#exampletb').DataTable();
            var $table = $('#table');
            $('#table').bootstrapTable({
                pagination: true,
                search: true
            });
        }
    });
});

//abre janela fancy com as SKUs dos produtos mais vendidos
$(document).on("click", "a.showTopProd", function(e) {
    //alert("Recurso em Manutenção\nem breve estará disponível!");

    var wbox = $(this).attr("data-sku");
    var wdi = $(this).attr("data-di");
    var wdf = $(this).attr("data-df");
    var wdp = $(this).attr("data-dpn");
    $.fancybox({
        type: 'ajax',
        href: 'ajax.php?v=table&topprod=' + wbox + '&di=' + wdi + '&df=' + wdf + '&dpn=' + wdp,
        padding: 0,
        autoSize: true
    });

});


//pesquisa frete jadlog
$(document).ready(function() {
    // Handler for .ready() called.
    $(".btconsulta").click(function() {
        var dnf = $('#danfe').val();
        var optDo = $('#do').val();
        if (dnf == '') {
            $('#resultados').html('<center><h3>Selecione uma nota para consultar!<h3></center>');
        } else {
            $('#resultados').html('<center><h3>AGUARDE...!<h3></center>');
            $.ajax({
                type: "POST",
                data: {
                    df: dnf,
                    optdo: optDo
                },
                url: pathUrl + 'ajax.php',
                dataType: "html",
                success: function(result) {
                    $('#resultados').html('');
                    $('#resultados').html(result);
                }
            });
        }
    });

    //jump select UF
    $(document).on("change", "select.jumpUF", function() {
        window.location = pathUrl + '?opt=fretes&view=tabela-jadlog&tar=' + loadTAR + '&uf=' + $(this).val();
    });

});