   <div class="card mt-2">
      <div class="card-header">
        <b>Produtos TOP 20</b><br /><small>(<?php echo swdata($dataInicial);?> - <?php echo swdata($dataFinal);?>)</small>
      </div>
      <div class="card-body">
        <div style="height:200px!important;overflow:auto!important;">

          <table class="table table-bordered">
          <?php
          $res  = topProdutos($dataInicial,$dataFinal);
          $totVenda   = 0;
          $sepProduct = array();
          $sepSku     = array();
          $bestItens  = array();
          $totBI      = array();
          $nomePrd    = array();
          $gl=1;
          for ($p = 0; $p < count($res); $p++)
          {
            $drow           = $res[$p];
            $prod           = $drow['produto'];
            $vend           = $drow['vendas'];
            $sku            = $drow['sku'];

            $sku_limpa      = limpaSku($sku);
            $a              = explode('Tamanho',$prod);
            $nomeProduto    = strtoupper(trim($a[0]));
            $bestItens[$p]  = array('item'=>$p,$vend,$sku,$prod,$sku_limpa,$nomeProduto);

            if(!arrayVar($totBI,$sku_limpa)){
            $totBI[$sku_limpa] = 0;
            }

            $totBI[$sku_limpa] += $vend;

            if(!isSet($sepSku[$sku_limpa])){
              $sepSku[$sku_limpa] = $nomeProduto;
            }
          }

          arsort($totBI);

          $cc=1;
          foreach($totBI as $keySku => $valueSku){
              if($cc<=20){
                $sku_prod = $keySku;
                $nom_prod = $sepSku[$keySku];
                $qtd_prod = $valueSku;
                echo "<tr><td><small>#$cc</small></td><td><a href=\"#\" class=\"showTopProd\" data-sku=\"$sku_prod\" data-di=\"$dataInicial\" data-df=\"$dataFinal\" data-dpn=\"".base64_encode($nom_prod)."\"><small>$nom_prod</small></td><td>$qtd_prod</td></tr></a>";
                $cc++;
              }
          }
          ?>
          </table>

          </div>
          <small>Com base em Nfe's (CFOPs 5102 e 6108) pode incluir trocas</small>
      </div>
    </div>
