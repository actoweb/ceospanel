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
