<?php
$totBoni                  = totalDeBonificacoes_noPeriodo($dataInicial,$dataFinal);
$totalDeBonificacoes      = number_format($totBoni['total'],2,',','.');
?>
    <div class="card mt-5">
      <div class="card-header">
        <b><?php echo $totBoni['qtd'];?> : Bonificações</b><br /><small>(<?php echo swdata($dataInicial);?> - <?php echo swdata($dataFinal);?>)</small>
      </div>
      <div class="card-body">
        <h1 class="card-title"> <a href="#" class="showGrid" data-wbox='bonificacoes' data-di='<?php echo $dataInicial;?>' data-df='<?php echo $dataFinal;?>'>R$
          <?php
          echo $totalDeBonificacoes;
          ?></a>
        </h1>
        <small>Notas fiscais emitidas (CFOPs 5910 e 6910)</small>
      </div>
    </div>
