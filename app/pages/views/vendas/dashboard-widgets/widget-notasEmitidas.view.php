<?php
$totBruto             = totalBrutoDeNotas_noPeriodo($dataInicial,$dataFinal);
$notasEmitidasBruto   = number_format($totBruto['total'],2,',','.');
?>
    <div class="card mb-5">
      <div class="card-header">
        <b><?php echo $totBruto['qtd'];?> : Notas emitidas</b><br /><small>(<?php echo swdata($dataInicial);?> - <?php echo swdata($dataFinal);?>)</small>
      </div>
      <div class="card-body">
        <h1 class="card-title"> <a href="#" class="showGrid" data-wbox='notas-emitidas' data-di='<?php echo $dataInicial;?>' data-df='<?php echo $dataFinal;?>'>R$
          <?php
          echo $notasEmitidasBruto;
          ?></a>
        </h1>
        <small>Notas fiscais emitidas (CFOPs 5102 e 6108) <b>pode incluir trocas</b></small>
      </div>
    </div>
