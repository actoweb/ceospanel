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
