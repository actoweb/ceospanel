<?php
$todosPedidos             = listaTodosPedidos($dataInicial,$dataFinal);
$valor_bruto_dos_pedidos  = number_format($todosPedidos['total'],2,',','.');
?>
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
