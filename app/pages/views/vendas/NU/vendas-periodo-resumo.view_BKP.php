<div class="row">


  <div class="col-md-4">

    <div class="card">
      <div class="card-header">
        Vendas (Valor BRUTO)<br /><small>(<?php echo swdata($dataInicial);?> - <?php echo swdata($dataFinal);?>)</small>
      </div>
      <div class="card-body">
        <h1 class="card-title"> R$
          <?php
          $vlrbruto = resumo_VendaBrutas($dataInicial,$dataFinal);
          $vendasBruto = $vlrbruto[0]['total'];
          echo number_format($vendasBruto,2,',','.');
          ?>
        </h1>
        <small>Com base nos CFOPs 5102 e 6108 "sem descontos ref trocas/devoluções"</small>
      </div>
    </div>

    <div class="card mt-5">
      <div class="card-header">
        Vendas (-Dev.)<br /><small>(<?php echo swdata($dataInicial);?> - <?php echo swdata($dataFinal);?>)</small>
      </div>
      <div class="card-body">
        <h1 class="card-title"> R$
          <?php
          $vlrbruto = resumo_VendaBrutas($dataInicial,$dataFinal);
          $vendasBruto = $vlrbruto[0]['total'];
          //echo number_format($vendasBruto,2,',','.');
          ?>
        </h1>
        <small>"Total itens vendidos (- itens troca/devoluções)"</small>
      </div>
    </div>


  </div>
  <div class="col-md-4">

    <div class="card">
      <div class="card-header">
        Bonificações no período<br /><small>(<?php echo swdata($dataInicial);?> - <?php echo swdata($dataFinal);?>)</small>
      </div>
      <div class="card-body">
        <h1 class="card-title"> R$
          <?php
          $bon = resumo_bonificacoes($dataInicial,$dataFinal);
          $bonTotal = $bon[0]['total'];
          echo number_format($bonTotal,2,',','.');
          ?>
        </h1>
        <small>Com base nos CFOPs 6910 e 5910</small>
      </div>
    </div>

    <div class="card mt-5">
      <div class="card-header">
        Devoluções no período<br /><small>(<?php echo swdata($dataInicial);?> - <?php echo swdata($dataFinal);?>)</small>
      </div>
      <div class="card-body">
        <h1 class="card-title"> R$
          <?php
          $bon = resumo_bonificacoes($dataInicial,$dataFinal);
          $bonTotal = $bon[0]['total'];
          //echo number_format($bonTotal,2,',','.');
          ?>
        </h1>
        <small>(BETA)</small>
      </div>
    </div>

  </div>
  <div class="col-md-4">

    <div class="card">
      <div class="card-header">
        Vendas por estado "BETA"<br /><small>(<?php echo swdata($dataInicial);?> - <?php echo swdata($dataFinal);?>)</small>
      </div>
      <div class="card-body">
        <div style="height:200px!important;overflow:auto!important;">
          <table class="table table-bordered">
          <?php
          $res  = vendasPorEstado($dataInicial,$dataFinal);
          $sum  = 0;
          for ($e = 0; $e < count($res); $e++)
          { $drow = $res[$e];
            $uf   = $drow['nfe_uf'];
            $sum += $drow['total'];
            $tot  = number_format($drow['total'],2,',','.');
            echo "<tr><td>$uf</td><td>$tot</td></tr>";
          }
          ?>
          <tr><td>Total</td><td><?php echo number_format($sum,2,',','.');?></td></tr>
          </table>
          </div>
      </div>
    </div>


    <div class="card mt-2">
      <div class="card-header">
        Itens mais vendidos "BETA"<br /><small>(<?php echo swdata($dataInicial);?> - <?php echo swdata($dataFinal);?>)</small>
      </div>
      <div class="card-body">
        <div style="height:200px!important;overflow:auto!important;">
          <table class="table table-bordered">

          <tr><td>Total</td><td><?php echo number_format($sum,2,',','.');?></td></tr>
          </table>
          </div>
      </div>
    </div>


  </div>

</div>


<div class="row mt-5">



</div>
