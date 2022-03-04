
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
