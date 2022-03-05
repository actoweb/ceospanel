<?php
$di = swdata($dataInicial);
$df = swdata($dataFinal);
?>
<div class="row">

  <div class="col-md-8">

      <div class="row">
        <div class="col-md-6">
        <?php
        //box total de pedidos emitidos
        include_once('app/pages/views/vendas/dashboard-widgets/widget-totalPedidosEmitidos.view.php');?>
        </div>
        <div class="col-md-6">
        <?php
        //box total de notas emitidas
        include_once('app/pages/views/vendas/dashboard-widgets/widget-notasEmitidas.view.php');?>
        </div>
      </div>

      <div class="row">
        <div class="col-md-6">
        <?php
        //box notas de devolução
        include_once('app/pages/views/vendas/dashboard-widgets/widget-notasDevolucao.view.php');?>
        </div>
        <div class="col-md-6">
        <?php
        //box trocas estimadas
        include_once('app/pages/views/vendas/dashboard-widgets/widget-trocasEstimadas.view.php');?>

        <?php
        //box total de bonificacoes
        include_once('app/pages/views/vendas/dashboard-widgets/widget-bonificacoes.view.php');?>
        </div>
      </div>

  </div>
  <div class="col-md-4">

    <div class="row">

      <div class="col-md-12">
        <?php
        //box total de vendas por estado
        include_once('app/pages/views/vendas/dashboard-widgets/widget-vendasPorEstado.view.php');?>

        <?php
        //box PRODUTOS TOP 20 (mais vendidos)
        include_once('app/pages/views/vendas/dashboard-widgets/widget-top20.view.php');?>
      </div>

    </div>

  </div>

</div>


<div class="row mt-5">


</div>
