/*
 * ***********DASHBOARD
 * ********************************************************************
 * ********************************************************************
 * ********************************************************************
 * */

var itemAtual   = '';
var uidProdAtual= '';


//encerra separacao da caixa atual e envia para o banco os dados da caixa
$(document).on("click","a.saveBoxContent", function(e){
  var cod_produto         = $('#barcode-produto-atual').val();
  var uid_cliente         = parseInt( $('#cd-cliente-selecionado').val() );
  var uid_pedido          = parseInt( $('#cd-pedido-atual').val() );
  var pedido_id           = parseInt( $('#cd-pedido-atual').val() );
  var qtd_virtual_inbox   = parseInt( $('#max-vcx-'+itemAtual).val() );
  var qtd_total_do_pedido = parseInt( $('#tot-'+itemAtual).attr("data-qtdtotal") );

  var request3 = $.ajax({
    url: "ajax.php?do=fechacaixa&cliente="+uid_cliente+"&pedido="+uid_pedido+"&vbox="+qtd_virtual_inbox+"&produto="+cod_produto+"&totaldoitem="+qtd_total_do_pedido,
    method: "GET",
    dataType: "html",
    success: function(data) {
      //return data;
      if(data!='ERROR'){

        //ZERA A CAIXA VIRTUAL PARA NAO TER SOMATORIO DE VALORES
        $('#max-vcx-'+itemAtual).val('0');

      }
    }
  });
  $.fancybox.close();
});




//CLICK PARA FECHAR QUAQUER JANELA FANCY (a.closeFancy)
$(document).on("click","a.closeFancy", function(e){
  $.fancybox.close();
});


//BOTAO PARA VISUALIZAR A JANELA DE IMPRESSAO DE ETIQUETAS
$(document).on("click","a#btn-etiquetas-all", function(e){

  var pedidoatual = $('#cd-pedido-atual').val();
  window.open(pathUrl+'etiquetas.php?peduid='+pedidoatual, '_blank');

/*
  $.fancybox({
    type: 'ajax',
    href: 'ajax.php?win=closebox',
    padding: 0,
    autoSize: true,
    closeClick  : false, // prevents closing when clicking INSIDE fancybox
    openEffect  : 'none',
    closeEffect : 'none',
    helpers   : {
      overlay : {closeClick: false} // prevents closing when clicking OUTSIDE fancybox
    }
  });
  */
});


//JANELA DE CONFIRMACAO PARA FECHAMENTO DE CAIXAS
//SO PROSSEGUE SE CAIXA TIVER CONTEUDO
$(document).on("click","a.confirmaFecharCaixa", function(e){

  var qtd_virtual_inbox = parseInt( $('#max-vcx-'+itemAtual).val() );
  var urlpop='';

  if(parseInt( qtd_virtual_inbox ) > 0){
    urlpop = 'ajax.php?win=confirmaclosebox&totalcaixa='+qtd_virtual_inbox;
  }else{
    urlpop = 'ajax.php?win=caixavazia&totalcaixa='+qtd_virtual_inbox;
  }

  $.fancybox({
    type: 'ajax',
    href: urlpop,
    padding: 0,
    autoSize: true,
    closeClick  : false, // prevents closing when clicking INSIDE fancybox
    openEffect  : 'none',
    closeEffect : 'none',
    helpers   : {
      overlay : {closeClick: false} // prevents closing when clicking OUTSIDE fancybox
    }
  });
});







/*
 * funcoes do leitor
 * */

//ATIVA FOCO CONSTANTE NO CAMPO DO LEITOR DE BARRAS
$("#breader").blur(function() {
    setTimeout(function() { $("#breader").focus(); }, 0);
});


//ROTINA PARA RESETAR ITENS DA LISTA DO PEDIDO
//E EXECUTADA DEPOIS DE SEPARAR TODOS OS PRODUTOS
//DE UM ITEM DO PEDIDO (REMOVE O CHECKBOX JA USADO E HABILITA OS DEMAIS)
function resetItens(){
  var rowCount = $('#detalhes-pedido tr.rowIPD').length;
  for (i = 1; i <= rowCount; i++)
  {
    $('#mck_'+i).attr("disabled", false);
    $('#btnBox-'+i).removeClass( "disabled" );
    $('#btn-etiquetas-'+i).removeClass( "disabled" );
  }
}


//FUNCAO PARA ATIVACAO INICIAL DO CHECKBOX DE SELECAO DO ITEM A SER SEPARADO
//ATIVA O CAMPO DE LEITURA DE BARRAS E DESATIVA OS DEMAIS CHECKBOXES
function onCheck(length,uid){
  for (i = 1; i <= length; i++)
  {
    if(i!=uid){
        $('#mck_'+i).attr("disabled", true);
        $('#btnBox-'+i).addClass( "disabled" );
        $('#btn-etiquetas-'+i).addClass( "disabled" );
    }else{
      itemAtual = uid;
      $('#itemAseparar').val(uid);
      $('#produto-alvo').html( $('#descProd-'+uid).html() );
      $('#breader').attr("disabled", false);
      $('#breader').attr("readonly", false);
    }
  }
}

//MSG DE CONFIRMACAO SE DESEJA REALIZAR A SEPARACAO DO
//ITEM SELECIONADO, CASO SIM ENTAO CHAMA (onCheck) PARA DAR O START

$(document).on("click",".big-checkbox", function(e){
/*
  Alertify.dialog.confirm("<h3>CONFIRMA A SEPARAÇÃO DESTE ITEM?</h3>", function () {
      // user clicked "ok"
*/
    $('#breader').attr("disabled", false);
    $('#breader').attr("readonly", false);
    $('#breader').focus();

    var rowCount = $('#detalhes-pedido tr.rowIPD').length;
    var uid = $(this).attr("data-order");

    //onCheck(rowCount,uid);

    if($(this).is(':checked')){
      Alertify.dialog.confirm("<h3>CONFIRMA INICIAR A SEPARAÇÃO DESTE ITEM?</h3>", function () {
      //alert('checkON')

       onCheck(rowCount,uid);
       $('#mck_'+uid).prop( "checked", true );

      }, function () {
          // user clicked "cancel"
          //$(this).prop('checked', false);
          $('#mck_'+uid).prop( "checked", false );
          Alertify.log.error("<h4>Cancelado!</h4>!");
      });

    }else{
      Alertify.dialog.confirm("<h3>CONFIRMA INTERROMPER A SEPARAÇÃO DESTE ITEM?</h3>", function () {
      //alert('checkOFF')
      $('#breader').attr("disabled", false);
      $('#breader').attr("readonly", false);
      $('#breader').val('');

        $('#mck_'+uid).prop( "checked", false );
        resetItens();

      }, function () {
          // user clicked "cancel"
          $(this).prop('checked', false);
          $('#mck_'+uid).prop( "checked", true );
          Alertify.log.error("<h4>Cancelado!</h4>!");
      });



    }

/*
  }, function () {
      // user clicked "cancel"
      $(this).prop('checked', false);
      Alertify.log.error("<h3>Cancelado!</h3>!");
  });
  */
});



$(document).on("click",".msgRowOff", function(e){
    $.fancybox({
      type: 'ajax',
      href: 'ajax.php?win=alertas',
      padding: 0,
      autoSize: true
    });
});

$(document).on("click","a.btnCx", function(e){
  e.preventDefault();
  var noitem  = $('#itemAseparar').val();
  var cxs = parseInt( $('#caixas-'+noitem).val() );
  cxs += 1;
  $('#caixas-'+noitem).val(cxs);
});


//acao de leitura do codigo de barras
$("#breader").keyup(function(e){
    var sbar = $(this).val();
    var code = e.key; // recommended to use e.key, it's normalized across devices and languages
    if(code==="Enter") e.preventDefault();
    if(code===" " || code==="Enter" || code===","|| code===";"){

        var noitem  = parseInt( $('#itemAseparar').val() );

        var barcode = parseInt( $('#pdt-barcode-'+noitem).val() );
        var barcode2 = ''+$('#pdt-barcode-'+noitem).val();
        $('#barcode-produto-atual').val(barcode2);
        var lido    = parseInt( $('#lido-'+noitem).val() );
        var vcx     = parseInt( $('#max-vcx-'+noitem).val() );
        var maxcx   = parseInt( $('#max-cx-'+noitem).val() );
        var tot     = parseInt( $('#tot-'+noitem).val() );
        var uidprod = parseInt( $('#prod-id-'+noitem).val() );//produto_id
        var uidcli  = parseInt( $('#cd-cliente-atual').val() );//cliente_id
        var uidped  = parseInt( $('#cd-pedido-atual').val() );//cliente_id
        var tcalc   = tot;
        var cxVirt  = vcx;

        if( $(this).val() == barcode){

          if(tot>0){
          cxVirt +=1;
          lido += 1;
          tot -=1;

          $('#lido-'+noitem).val(parseInt(lido));
          //$('#max-vcx-'+itemAtual).val(parseInt(lido));
          $('#max-vcx-'+itemAtual).val(parseInt(cxVirt));
          $('#tot-'+noitem).val( tot );
          $("#cd-produto-atual").val( noitem );
          $("#breader").val('');
          $( "#breader" ).removeClass( "redfield" );
          $( "#breader" ).addClass( "greenfield" );
          $('.bigIconReader').attr('src','assets/images/ok-check.png');
          $('body').css("background-color","#89B1CE");

              var request = $.ajax({
                url: "ajax.php?do=procped&uidped="+uidped+"&uidcli="+uidcli+"&uidprod="+uidprod+"&barcode="+sbar,
                method: "GET",
                dataType: "html",
                success: function(data) {
                  //return data;
                  if(data!='ERROR'){
                    $( "#breader" ).removeClass( "redfield" );
                    $( "#breader" ).removeClass( "greenfield" );
                    if( parseInt($('#max-vcx-'+noitem).val())==parseInt($('#max-cx-'+noitem).val())){
                      $.fancybox({
                        type: 'ajax',
                        href: 'ajax.php?win=closebox&uidped='+uidped+'&uidprod='+uidprod+'&vcaixa='+maxcx,
                        padding: 0,
                        autoSize: true
                      });
                    }
                  }
                }
              });

          }else{
            $.fancybox({
              type: 'ajax',
              href: 'ajax.php?win=itemconcluido',
              padding: 0,
              autoSize: true
            });
            $("#breader").val('');
            $("#mck_"+itemAtual).remove();
            resetItens();
          }

        }else{
          //$( "#breader" ).addClass( "redfield" );
          $('body').css("background-color","red");
          $('.bigIconReader').attr('src','assets/images/error-check.png');
          $("#breader").val('');
          $('#breader').attr("disabled", false);
          $('#breader').attr("readonly", false);
        }



    } // missing closing if brace
});




/*
 * ********************************************************************
 * */



  $(document).on("click","a.pickInfo", function(){
    var opt = $(this).attr("data-info");
    var uid = '';
    if(opt=='pedidos' && $('#cd-cliente-selecionado').val()!=''){
      uid = '&uid='+$('#cd-cliente-selecionado').val();
    }
    //var uid = $(this).attr("data-uid");
    $.fancybox({
      type: 'ajax',
      href: 'ajax.php?win='+opt+uid,
      padding: 0,
      autoSize: true
    });
  });

  $(document).on("click","a.pkCli", function(){
    var text  = $(this).text();
    var cdcli = parseInt( $(this).attr("data-codcli") );
    $('.cliNome').text( text );
    parent.$.fancybox.close();
    $('#cd-cliente-selecionado').val(cdcli);
    $('#cd-cliente-atual').val(cdcli);
  });

  $(document).on("click","a.pkPed", function(){
    var text  = $(this).text();
    var cdped = parseInt(  $(this).attr("data-codped") );
    $('.pedNum').text( text );
    parent.$.fancybox.close();

    var pdn = $(this).attr("data-codped");
    //alert(pdn);
    //data-codped

    $('#cd-pedido-atual').val(cdped);

    var request = $.ajax({
      url: "ajax.php?do=gettabpedido&uidped="+pdn,
      method: "GET",
      dataType: "html",
      success: function(data) {
        //return data;
        //if(data!='ERROR'){
          $('#detalhes-pedido').html( data );

              var request2 = $.ajax({
                url: "ajax.php?do=getTableHeader&uidped="+pdn,
                method: "GET",
                dataType: "html",
                success: function(data2) {
                  //return data;
                  //if(data!='ERROR'){
                    $('#tableHEADER').html( data2 );
                  //}
                }
              });

        //}
      }
    });

  });

/*
 * ***********CLIENTES
 * ********************************************************************
 * ********************************************************************
 * ********************************************************************
 * */


  //jump select cadastro de cliente para alteracao
  $(document).on("change","select#clientes_uid", function(){
    window.location=pathUrl+'?opt=clientes&uid='+$(this).val();
  });


  //remocao de CLIENTES selecionados
  $(document).on("click","a.removeThis", function(){
    var data_url    = $(this).attr("data-url");
    var url_return  = $(this).attr("data-urlReturn");

    Alertify.dialog.confirm("<h2>IMPORTANTE!</h2>Isso <b>não poderá ser desfeito</b>, deseja continuar msm?", function () {
        // user clicked "ok"

      var request = $.ajax({
        url: "ajax.php?"+data_url,
        method: "GET",
        dataType: "html",
        success: function(data) {
          //return data;
          if(data!='ERROR'){
          //alert(data);
          window.location = pathUrl+url_return;
          }
        }
      });

    }, function () {
        // user clicked "cancel"
        Alertify.log.error("<h2>Ufa!</h2><small>Missão abortada:</small><br />A remoção foi cancelada!");
    });
  });


  //inserir ou alterar cliente
  $(document).on("click","button.saveForm", function(){
    if($('#nomeCliente').val()==''){
      Alertify.log.error("<h2>Opa!</h2>O nome do cliente não informado!");
    }
    else
    {
      var dataForm = $( "#frmCli" ).serialize();
      var request = $.ajax({
        url: "ajax.php?do=admcli",
        method: "POST",
        data: dataForm,
        dataType: "html",
        success: function(data) {
             //return data;
             if(data!='ERROR'){
                //eval(data);
                $('#uid').val('');
                $('#nomeCliente').val('');
                window.location = $( "#urlReturn" ).val();
              }
          }
      });
    }
  });





/*
 * ***********IMPORTADOR
 * ********************************************************************
 * ********************************************************************
 * ********************************************************************
 * */

  //link fancywin form add novo pedido
  $(document).on("click","a.fancyImportProdWin", function(){
    var uid = $(this).attr("data-info");
    $.fancybox({
      type: 'ajax',
      href: 'ajax.php?win=import&modulo='+uid,
      padding: 0,
      autoSize: true
    });
  });


/*
 * ***********PRODUTOS
 * ********************************************************************
 * ********************************************************************
 * ********************************************************************
 * */

  //jump select cliente para prosseguir no cadastro de produtos
  $(document).on("change","select#clientes_produtos_uid", function(){
    window.location=pathUrl+'?opt=produtos&cliente_uid='+$(this).val();
  });

  $(document).on("click","a.excluirPedido", function(){

      var data_url    = $(this).attr("data-url");
      var url_return  = $(this).attr("data-urlReturn");

      Alertify.dialog.confirm("<h2>IMPORTANTE!</h2>Isso <b>não poderá ser desfeito</b>, deseja continuar msm?", function () {

          var request = $.ajax({
            url: "ajax.php?"+data_url,
            method: "GET",
            dataType: "html",
            success: function(data) {
              //return data;
              if(data!='ERROR'){
                window.location = pathUrl+url_return;
              }
              else
              {Alertify.log.error("<h2>Ops! :( </h2>ocorreu um erro não pude remover o produto!");}
            }
          });


      }, function () {
          // user clicked "cancel"
          Alertify.log.error("<h2>Ufa!</h2><small>Missão abortada:</small><br />A remoção foi cancelada!");
      });

  });


  //Btn add novo produto na linha de produtos do cliente
  $(document).on("click","a.addProdCli", function(){
    var itemNumber = $("#gridProds > div.row-prod").length+1;
    var buttons = '<a href="#" type="button" class="btn btn-outline-primary gridItem_'+itemNumber+' removeProdGrid" data-prodDBID="" data-rowid="'+itemNumber+'"><i class="bi bi-trash-fill" style="font-size:14pt;"></i></a>';
    var item = '<div id="row-number-'+itemNumber+'" class="form-group row row-prod no-gutters"><label for="cliente_add" class="col-sm-1 col-form-label">#'+itemNumber+'</label><div class="col-sm-4"><input type="text" class="form-control" id="barCode-'+itemNumber+'" name="barCode[]" value="" placeholder="Cód. de Barras" required></div><div class="col-sm-3"><input type="text" class="form-control" id="descProduto-'+itemNumber+'" name="descProduto[]" value="" placeholder="Descrição" required></div><div class="col-sm-2"><input type="text" class="form-control" id="corProduto-'+itemNumber+'" name="corProduto[]" value="" placeholder="Cor" required></div><div class="col-sm-1"><input type="text" class="form-control" id="maxCaixa'+itemNumber+'" name="maxCaixa[]" value="" placeholder="Max. Cx."></div><div class="col-sm-1">'+buttons+'</div></div>';
    $( ".gradeProdutosCliente" ).append(item);
  });


  //remover itens da grade de produtos reordenando a numeracao
  $(document).on("click","a.removeProdGrid", function(){
    var rowid       = $(this).attr("data-rowid");
    var dbID        = $(this).attr("data-prodDBID");
    var data_url    = $(this).attr("data-url");
    var url_return  = $('#urlReturn').val();
    var doRemove    = false;
    if(dbID!=''){

      Alertify.dialog.confirm("<h2>IMPORTANTE!</h2>Isso <b>não poderá ser desfeito</b>, deseja continuar msm?", function () {

          var request = $.ajax({
            url: "ajax.php?"+data_url+'='+dbID,
            method: "GET",
            dataType: "html",
            success: function(data) {
              //return data;
              if(data!='ERROR'){
                $( "#row-number-"+rowid ).remove();
                var nit=1;
                var itens = $("#gridProds > div.row-prod").length;
                for (i = 0; i < itens; i++)
                { $(".row-prod > label").eq(i).html('#'+nit); nit++;}
                window.location = pathUrl+url_return;
              }
              else
              {Alertify.log.error("<h2>Ops! :( </h2>ocorreu um erro não pude remover o produto!");}
            }
          });

      }, function () {
          // user clicked "cancel"
          Alertify.log.error("<h2>Ufa!</h2><small>Missão abortada:</small><br />A remoção foi cancelada!");
      });

    }else{
      $( "#row-number-"+rowid ).remove();
      var nit=1;
      var itens = $("#gridProds > div.row-prod").length;
      for (i = 0; i < itens; i++)
      { $(".row-prod > label").eq(i).html('#'+nit); nit++; }
    }
  });


  //cadastrar ou alterar produtos do cliente via formulario
  $(document).on("click","button.postDataAjax", function(){
      var formId    = $(this).attr("data-formId");
      var postUrl   = $(this).attr("data-postUrl");
      var urlReturn = $('#urlReturn').val();
      var dataForm  = $( "#"+formId ).serialize();
      var numitens  = 0;
      var unfilled = $('[required]').filter(function() {
          numitens = $(this).val().length;
          return $(this).val().length === 0;
      });
      if (unfilled.length > 0) {
          unfilled.css('border', '1px solid red');
          Alertify.log.error("<h2>Ops!</h2>Você deve selecionar um produto!");
      }else{
      if(numitens===0){
        Alertify.log.error("<h2>Ops!</h2>Você não informou nenhum produto!");
      }//endif sem produtos
      else
      {
        var request = $.ajax({
        url: postUrl,
        method: "POST",
        data: dataForm,
        dataType: "html",
        success: function(data) {
          //return data;
          if(data.indexOf('error')>0){
          eval(data);
          }else{
          window.location = pathUrl+urlReturn;
          }
        }
        });
      }//endif sem produtos
    }
  });


/*
 * ***********PEDIDOS
 * ********************************************************************
 * ********************************************************************
 * ********************************************************************
 * */

  //consulta se pedido existe
  /*
  $(document).on("click","a.checkPedSave", function(){
    var npedido = $('.numeroNovoPedido').val();
    alert(npedido);
  });
  * */



  //force dynamic select selecteds
  $(document).on("change","select.selectItem", function(){
   $(this).find('[selected]').removeAttr('selected')
   $(this).find(':selected').attr('selected','selected')
  });


  //jump select cliente para prosseguir no cadastro de produtos
  $(document).on("change","select#clientes_pedidos_uid", function(){
    window.location=pathUrl+'?opt=pedidos&cliente_uid='+$(this).val();
  });

  //link fancywin form add novo pedido
  /*
  $(document).on("click","a.novoPedido", function(){
    var uid = $(this).attr("data-info");
    $.fancybox({
      type: 'ajax',
      href: 'ajax.php?win='+uid,
      padding: 0,
      autoSize: true
    });
  });
*/

  $(".novoPedido").fancybox({
    maxWidth	: 400,
    maxHeight	: 300,
    fitToView	: false,
    width		: '70%',
    height		: '70%',
    autoSize	: true,
    openEffect	: 'none',
    closeEffect	: 'none',
    padding: 3,
    closeClick	: false
  });

  $(document).on("click","input.numeroNovoPedido", function(){
    alert(  $(this).val() );
  });

  function popAlert(dados){
    alert( dados );
  }


  //btn click PARA SALVAR UM NOVO PEDIDO
  $( "#checkPedSave" ).click(function() {
    var newPedNum = $('#numeroNovoPedido').val();
    var backTo    = $('#urlReturnNP').val();
    var formId    = $(this).attr("data-formId");
    var postUrl   = $(this).attr("data-postUrl");
    if(newPedNum!=''){
    var dataForm  = $( "#"+formId ).serialize();

      var request = $.ajax({
      url: postUrl,
      method: "POST",
      data: dataForm,
      dataType: "html",
      success: function(data) {
        //return data;
        if(data.indexOf('error')>0){
        eval(data);
        }else{
        //alert('oxixxxEITA');
        window.location = pathUrl+backTo;
        }
      }
      });

    }
  });


  //jump select cliente para prosseguir no cadastro de produtos
  $(document).on("change","select#pedidos_cliente_uid", function(){
    window.location=pathUrl+'?opt=pedidos&cliente_uid='+$(this).val();
  });

  //Btn add novo ITEM DO PEDIDO na linha pedidos do cliente
  $(document).on("click","a.addItemPed", function(){
    var itemNumber    = $("#gridItens > div.row-item").length+1;
    var opts          = $( "#prodsCLI" ).val();//txt para montagem do select com os produtos do cliente
    var itens         = opts.split(';');
    var optProdSelect = '';
    var item          = '';
    var atbs;
    for (g = 0; g < itens.length; g++)
    {
      item = itens[g];
      atbs = item.split('|');
      optProdSelect +=  '<option value="'+atbs[0]+'|'+atbs[1]+'">'+atbs[2]+'</option>';
    }
    var buttons      = '<a href="#" type="button" class="btn btn-outline-primary gridItem_'+itemNumber+' removeIPedGrid" data-prodDBID="" data-rowid="'+itemNumber+'"><i class="bi bi-trash-fill" style="font-size:14pt;"></i></a>';
    var item         = '<div id="row-number-'+itemNumber+'" class="form-group row row-item no-gutters"><label for="cliente_add" class="col-sm-1 col-form-label">#'+itemNumber+'</label><div class="col-sm-8"><select id="itemPedido-'+itemNumber+'" name="itemPedido[]" class="form-control selectItem" required><option value="">Selecione</option>'+optProdSelect+'</select><input type="hidden" id="hitemPedido-1" name="hitemPedido[]" /></div><div class="col-sm-2"><input type="text" class="form-control" id="qtdItem-'+itemNumber+'" name="qtdItem[]" placeholder="Qtd." required></div><div class="col-sm-1">'+buttons+'</div></div>';
    $( ".gradeItensPedido" ).append(item);
  });


  //remover ITENS DO PEDIDOS reordenando a numeracao
  $(document).on("click","a.removeIPedGrid", function(){
    var rowid       = $(this).attr("data-rowid");
    var dbID        = $(this).attr("data-prodDBID");
    var data_url    = $(this).attr("data-url");
    var url_return  = $('#urlReturn').val();
    var doRemove    = false;
    if(dbID!=''){

      Alertify.dialog.confirm("<h2>IMPORTANTE!</h2>Isso <b>não poderá ser desfeito</b>, deseja continuar msm?", function () {

          var request = $.ajax({
            url: "ajax.php?"+data_url+'='+dbID,
            method: "GET",
            dataType: "html",
            success: function(data) {
              //return data;
              if(data!='ERROR'){
                $( "#row-number-"+rowid ).remove();
                var nit=1;
                var itens = $("#gridProds > div.row-prod").length;
                for (i = 0; i < itens; i++)
                { $(".row-prod > label").eq(i).html('#'+nit); nit++;}
                window.location = pathUrl+url_return;
              }
              else
              {Alertify.log.error("<h2>Ops! :( </h2>ocorreu um erro não pude remover o produto!");}
            }
          });

      }, function () {
          // user clicked "cancel"
          Alertify.log.error("<h2>Ufa!</h2><small>Missão abortada:</small><br />A remoção foi cancelada!");
      });

    }else{
      $( "#row-number-"+rowid ).remove();
      var nit=1;
      var itens = $("#gridItens > div.row-item").length;
      for (i = 0; i < itens; i++)
      { $(".row-item > label").eq(i).html('#'+nit); nit++; }
    }
  });


  //cadastrar ou alterar ITENS DO PEDIDO do cliente via formulario
  $(document).on("click","button.postDataAjaxPed", function(){
      var formId    = $(this).attr("data-formId");
      var postUrl   = $(this).attr("data-postUrl");
      var urlReturn = $('#urlReturn').val();
      var dataForm  = $( "#"+formId ).serialize();
      var numitens  = 0;
      var unfilled  = $('[required]').filter(function() {
          numitens  = $(this).val().length;
          return $(this).val().length === 0;
      });
      if (unfilled.length > 0) {
          unfilled.css('border', '1px solid red');
          Alertify.log.error("<h2>Ops!</h2>Você informar o produto e a quantidade!");
      }else{
      if(numitens===0){
        Alertify.log.error("<h2>Ops!</h2>Você não informou nenhum produto!");
      }//endif sem produtos
      else
      {
        var request = $.ajax({
        url: postUrl,
        method: "POST",
        data: dataForm,
        dataType: "html",
        success: function(data) {
          //return data;
          if(data.indexOf('error')>0){
          eval(data);
          }else{
          window.location = pathUrl+urlReturn;
          }
        }
        });
      }//endif sem produtos
    }
  });
