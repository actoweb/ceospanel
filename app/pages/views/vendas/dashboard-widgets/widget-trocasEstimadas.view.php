<?php
$totTrocas    = totalDeTrocas_noPeriodo($dataInicial,$dataFinal);
$totalDeTrocasEstimado    = number_format($totTrocas['total'],2,',','.');
?>
    <div class="card mt-5">
      <div class="card-header">
        <b><?php echo $totTrocas['qtd'];?> : Trocas estimadas</b><br /><small>(<?php echo swdata($dataInicial);?> - <?php echo swdata($dataFinal);?>)</small>
      </div>
      <div class="card-body">
        <h1 class="card-title"> <a href="#" class="showGrid" data-wbox='trocas-estimadas' data-di='<?php echo $dataInicial;?>' data-df='<?php echo $dataFinal;?>'>R$
          <?php
          echo $totalDeTrocasEstimado;
          ?></a>
        </h1>
        <small>Em notas fiscais emitidas</small>
      </div>
    </div>
