    <div class="card mb-5">
      <div class="card-header">
        <b>Vendas por estado</b><br /><small>(<?php echo swdata($dataInicial);?> - <?php echo swdata($dataFinal);?>)</small>
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
