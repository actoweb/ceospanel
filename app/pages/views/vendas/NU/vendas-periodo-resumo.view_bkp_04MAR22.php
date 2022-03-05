<?php
$di = swdata($dataInicial);
$df = swdata($dataFinal);

$todosPedidos = listaTodosPedidos($dataInicial,$dataFinal);
$totBruto     = totalBrutoDeNotas_noPeriodo($dataInicial,$dataFinal);
$totTrocas    = totalDeTrocas_noPeriodo($dataInicial,$dataFinal);
$totNFeDev    = totalDeNotasDevolucoes_noPeriodo($dataInicial,$dataFinal);
$totBoni      = totalDeBonificacoes_noPeriodo($dataInicial,$dataFinal);


$valor_bruto_dos_pedidos  = number_format($todosPedidos['total'],2,',','.');
$notasEmitidasBruto       = number_format($totBruto['total'],2,',','.');
$totalDeTrocasEstimado    = number_format($totTrocas['total'],2,',','.');
$totalDeBonificacoes      = number_format($totBoni['total'],2,',','.');
$devolucoesEstimadas      = number_format($totNFeDev['total'],2,',','.');


?>

<div class="row">


  <div class="col-md-4">

    <div class="card">
      <div class="card-header">
        <b><?php echo $todosPedidos['qtd'];?> : Total de Pedidos emitidos</b><br /><small>(<?php echo swdata($dataInicial);?> - <?php echo swdata($dataFinal);?>)</small>
      </div>
      <div class="card-body">
        <h1 class="card-title"> <a href="#" class="showGrid" data-wbox='total-de-pedidos' data-di='<?php echo $dataInicial;?>' data-df='<?php echo $dataFinal;?>'>R$
          <?php
          echo $valor_bruto_dos_pedidos;
          ?></a>
        </h1>
        <small>Volume total em Pedidos realizados na loja online ou internamente</small>
<!--
        <table class="table-bordered" style="width:100%;">
          <tr>
            <td width="150">Vendas Cartão</td>
            <td>R$ 000,00</td>
          </tr>
          <tr>
            <td>Vendas Pix</td>
            <td>R$ 000,00</td>
          </tr>
        </table>
-->
      </div>
    </div>

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


  </div>
  <div class="col-md-4">

    <div class="card">
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

    <div class="card mt-5">
      <div class="card-header">
        <b><?php echo $totBoni['qtd'];?> : Bonificações</b><br /><small>(<?php echo swdata($dataInicial);?> - <?php echo swdata($dataFinal);?>)</small>
<!--
        <a href="#" class="showGrid"></a>
-->
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

  </div>
  <div class="col-md-4">

    <div class="card">
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


    <div class="card mt-2">
      <div class="card-header">
        <b>Produtos TOP 20</b><br /><small>(<?php echo swdata($dataInicial);?> - <?php echo swdata($dataFinal);?>)</small>
      </div>
      <div class="card-body">
        <div style="height:200px!important;overflow:auto!important;">

          <table class="table table-bordered">
          <?php
          $res  = topProdutos($dataInicial,$dataFinal);
          //print_r($res);
          $totVenda   = 0;
          $sepProduct = array();
          $bestItens  = array();
          $totBI      = array();
          $nomePrd    = array();

          for ($p = 0; $p < count($res); $p++)
          {
            $drow       = $res[$p];
            $prod       = $drow['produto'];
            $vend       = $drow['vendas'];
            $sku        = $drow['sku'];

            echo "<tr><td>$sku</td><td><a href=\"#\" class=\"showTopProd\" data-sku=\"$sku\" data-di=\"$dataInicial\" data-df=\"$dataFinal\" data-dpn=\"".base64_encode($nomePrd[$ky])."\"><small>$prod</small></td><td>$vend</td></tr></a>";

          }



          ?>
          </table>

          </div>
          <small>Com base em Nfe's (CFOPs 5102 e 6108) pode incluir trocas</small>
          <?php
          //~ arsort($sepProduct);
          //~ echo json_encode($sepProduct);
          //~ echo '<hr />';
          //~ echo json_encode($totBI);
          ?>
      </div>
    </div>


  </div>

</div>


<div class="row mt-5">



</div>
