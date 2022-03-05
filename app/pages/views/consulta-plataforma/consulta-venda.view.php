<div class="card">
  <div class="card-header">
    Consultar Dados do Pagamento
  </div>
  <div class="card-body">
    <h5 class="card-title">Digite o número do pedido</h5>

    <form id="frmConsultaPedido" name="frmConsultaPedido" method="post" action="<?php $PHP_SELF;?>">


       <div class="form-row align-items-center">
          <div class="col-auto">
            <input onclick="this.select();" type="text" class="form-control mb-2" id="numeroPedido" name="numeroPedido" value="<?php if(isSet($_POST['numeroPedido'])){echo $_POST['numeroPedido'];}?>" placeholder="ex: 01002">
          </div>
          <div class="col-auto">
            <button type="submit" class="btn btn-primary mb-2">Consultar</button>
          </div>
        </div>

    </form>

    <?php
    if(isSet($_POST['numeroPedido'])&&$_POST['numeroPedido']!=''){
      $consulta_script = "app/pages/views/consulta-plataforma/processa-consulta-plataforma-pgto.php";
      include_once($consulta_script);
    }
    ?>

  </div>
  <div class="card-footer text-muted">
  <small><b>UFO WAY LABS - TI TEAM</b></small>
  </div>

</div>
