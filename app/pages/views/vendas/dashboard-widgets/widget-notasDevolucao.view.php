<?php
$totNFeDev            = totalDeNotasDevolucoes_noPeriodo($dataInicial,$dataFinal);
$devolucoesEstimadas  = number_format($totNFeDev['total'],2,',','.');
?>
    <div class="card mt-5">
      <div class="card-header">
        <b><?php echo $totNFeDev['qtd'];?> : Devoluções (notas de devolução)</b><br /><small>(<?php echo swdata($dataInicial);?> - <?php echo swdata($dataFinal);?>)</small>
      </div>
      <div class="card-body">
        <h1 class="card-title"> <a href="#" class="showGrid" data-wbox='notas-de-devolucao' data-di='<?php echo $dataInicial;?>' data-df='<?php echo $dataFinal;?>'>R$
          <?php
          echo $devolucoesEstimadas;
          ?></a>
        </h1>
        <small>"Valor total em Nfe de dev.(entrada) cfops 1202 e 2202"</small>
      </div>
    </div>
