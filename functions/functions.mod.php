<?php

function vendasPorEstado($dataInicial='',$dataFinal=''){ /*em uso ceospanel dashboard*/
  if($dataInicial==''){$dataInicial='2021-10-29';}
  if($dataFinal=='')  {$dataFinal=date('Y-m-d');}else{$dataFinal = $dataFinal;}

    $sql = "SELECT
            nfe_uf,
            ROUND( SUM(nfe_valorNota), 2 ) AS total
            FROM bs_notas
            WHERE
            (nfe_cfops = :nfe_cfops1 OR  nfe_cfops = :nfe_cfops2)
            AND DATE(nfe_dataEmissao) >= :nfe_dataEmissao1 AND DATE(nfe_dataEmissao) <= :nfe_dataEmissao2
            AND (
            nfe_situacao = :nfe_situacao1
            OR nfe_situacao = :nfe_situacao2
            OR nfe_situacao = :nfe_situacao3)
            AND nfe_tipo = :nfe_tipo
            GROUP BY nfe_uf
            ORDER BY total DESC";

    $res = dbf($sql,array(
                          ':nfe_tipo'=>'S',
                          ':nfe_dataEmissao1'=>$dataInicial,
                          ':nfe_dataEmissao2'=>$dataFinal,
                          ':nfe_cfops1'=>'5102',
                          ':nfe_cfops2'=>'6108',
                          ':nfe_situacao1'=>'Autorizada',
                          ':nfe_situacao2'=>'Emitida DANFE',
                          ':nfe_situacao3'=>'Enviada - Aguardando protocolo'),'fetch','ufowayco_blingsinc');
    return $res;

}

function limpaSku($str){ /*em uso ceospanel dashboard TOP 20*/
  $str = strtoupper($str);
  $str = str_replace(' ','',$str);
  $str = str_replace('-','',$str);
  $str = str_replace('34','',$str);
  $str = str_replace('36','',$str);
  $str = str_replace('38','',$str);
  $str = str_replace('40','',$str);
  $str = str_replace('42','',$str);
  $str = str_replace('44','',$str);
  $str = str_replace('46','',$str);

  if(strstr($str,'LA')){
    $a    = explode('LA',$str);
    $pre  = $a[0];
    $tail = $a[1];
    $tail = str_replace('PP','',$tail);
    $tail = str_replace('P','',$tail);
    $tail = str_replace('M','',$tail);
    $tail = str_replace('G','',$tail);
    $str  = $pre.'LA'.$tail;
  }

  return $str;
}

function topProdutos($dataInicial,$dataFinal){ /*em uso ceospanel dashboard*/

  $sql='SELECT
        itens.item_sku as sku,
        itens.item_descricao as produto,
        count(itens.id) as vendas
        FROM bs_notas_itens as itens, bs_notas as notas
        WHERE
        itens.item_cfop IN (:nfe_cfops1,:nfe_cfops2)
        AND itens.item_numeroNota = notas.nfe_numero
        AND notas.nfe_dataEmissao BETWEEN DATE(:dataInicial) AND DATE(:dataFinal)
        AND NOT itens.item_sku IN (:exclude)
        GROUP BY item_sku
        ORDER BY vendas  DESC LIMIT 0,50';

    $res = dbf($sql,array(
                          ':exclude'=>'15191',
                          ':dataInicial'=>$dataInicial,
                          ':dataFinal'=>$dataFinal,
                          ':nfe_cfops1'=>'5102',
                          ':nfe_cfops2'=>'6108'),'fetch','ufowayco_blingsinc');
    return $res;


}

function topProdutosByDesc($desc,$dataInicial,$dataFinal){

  $sql='SELECT
        itens.item_sku as sku,
        itens.item_descricao as produto,
        count(itens.id) as vendas
        FROM bs_notas_itens as itens, bs_notas as notas
        WHERE
        itens.item_cfop IN (:nfe_cfops1,:nfe_cfops2)
        AND itens.item_numeroNota = notas.nfe_numero
        AND notas.nfe_dataEmissao BETWEEN DATE(:dataInicial) AND DATE(:dataFinal)
        AND itens.item_sku LIKE :skuFilter
        GROUP BY item_sku
        ORDER BY sku LIMIT 0,50';

    $res = dbf($sql,array(
                          ':skuFilter'=>"$desc%",
                          ':dataInicial'=>$dataInicial,
                          ':dataFinal'=>$dataFinal,
                          ':nfe_cfops1'=>'5102',
                          ':nfe_cfops2'=>'6108'),'fetch','ufowayco_blingsinc');
    return $res;


}

function listaTodosPedidos($dataInicial,$dataFinal){ /*em uso ceospanel dashboard*/
  $sql  = "SELECT
          pedidos.data as dataPedido,
          pedidos.pedido_loja as numeroPedido,
          pedidos.loja as numeroLoja,
          TRIM(BOTH '\"' FROM JSON_EXTRACT(pedidos.pedido_json,'$.nota.numero')) AS Nfe,
          TRIM(BOTH '\"' FROM JSON_EXTRACT(pedidos.pedido_json,'$.cliente.nome')) AS cliente,
          TRIM(BOTH '\"' FROM JSON_EXTRACT(pedidos.pedido_json,'$.cliente.cep')) as CepCliente,
          TRIM(BOTH '\"' FROM JSON_EXTRACT(pedidos.pedido_json,'$.cliente.uf')) as ufCliente,
          TRIM(BOTH '\"' FROM JSON_EXTRACT(pedidos.pedido_json,'$.cliente.email')) as emailCliente,
          TRIM(BOTH '\"' FROM JSON_EXTRACT(pedidos.pedido_json,'$.totalvenda')) as valorPedido,
          pedidos.situacao as situacao
          FROM
          bs_pedidos as pedidos
          WHERE
          pedidos.data BETWEEN DATE(:dataInicial) AND DATE(:dataFinal)
          AND JSON_EXTRACT(pedidos.pedido_json,'$.tipoIntegracao') = 'CoreCommerce'
          ORDER BY dataPedido DESC";


  //$res = dbf($sql,array(':dataInicial'=>$dataInicial,':dataFinal'=>$dataFinal),'fetch','ufowayco_blingsinc');
  $res = dbf($sql,array(':dataInicial'=>$dataInicial,':dataFinal'=>$dataFinal),'fetch');

  $result = false;

  if(is_array($res)){

  $total=0;
  for ($i = 0; $i < count($res); $i++)
  {
    $drow=$res[$i];
    $total += (float) $drow['valorPedido'];
  }

  $resDATA=array();
  if(isSet($res[0])){
    $resDATA = $res[0];
  }

  $result=array('res'=>$resDATA,'qtd'=>count($res),'total'=>$total,'resData'=>$res);
  }
  return $result;
}

function totalBrutoDeNotas_noPeriodo($dataInicial,$dataFinal){ /*em uso ceospanel dashboard*/

  $sql = "SELECT
          *
          FROM
          bs_notas
          WHERE
          nfe_tipo = 'S'
          AND (nfe_cfops = '5102' OR  nfe_cfops = '6108')
          AND (
          nfe_situacao = 'Autorizada'
          OR nfe_situacao = 'Emitida DANFE'
          OR nfe_situacao = 'Enviada - Aguardando protocolo')
          AND DATE(nfe_dataEmissao) >= :dataInicial AND DATE(nfe_dataEmissao) <= :dataFinal
          ORDER BY nfe_dataEmissao";

  $res = dbf($sql,array(':dataInicial'=>$dataInicial,':dataFinal'=>$dataFinal),'fetch','ufowayco_blingsinc');

  $total=0;
  for ($i = 0; $i < count($res); $i++)
  {
    $drow=$res[$i];
    $total += (float) $drow['nfe_valorNota'];
  }

  $resDATA=array();
  if(isSet($res[0])){
    $resDATA = $res[0];
  }

  $result=array('res'=>$resDATA,'qtd'=>count($res),'total'=>$total,'resData'=>$res);
  return $result;

}

function totalDeNotasDevolucoes_noPeriodo($dataInicial,$dataFinal){ /*em uso ceospanel dashboard*/

  $sql = "SELECT
          *
          FROM bs_notas
          WHERE
          nfe_tipo = 'E'
          AND DATE(nfe_dataEmissao) >= :dataInicial AND DATE(nfe_dataEmissao) <= :dataFinal
          AND nfe_cfops IN ('1202','2202','1201')
          AND NOT nfe_situacao IN ('Cancelada','Pendente')";

  $res = dbf($sql,array(':dataInicial'=>$dataInicial,':dataFinal'=>$dataFinal),'fetch','ufowayco_blingsinc');

  $total=0;
  for ($i = 0; $i < count($res); $i++)
  {
    $drow=$res[$i];
    $total += (float) $drow['nfe_valorNota'];
  }

  $resDATA=array();
  if(isSet($res[0])){
    $resDATA = $res[0];
  }

  $result=array('res'=>$resDATA,'qtd'=>count($res),'total'=>$total,'resData'=>$res);
  return $result;

}

function totalDeTrocas_noPeriodo($dataInicial,$dataFinal){ /*em uso ceospanel dashboard*/

  $sql = "select
          notas.nfe_dataEmissao,
          notas.nfe_numero,
          notas.nfe_nome,
          notas.nfe_cep,
          notas.nfe_uf,
          notas.nfe_email,
          notas.nfe_valorNota,
          notas.nfe_linkPDF,
          pedidos.data,
          notas.nfe_cfops,
          notas.nfe_valorNota as valorNota,
          CONVERT(JSON_EXTRACT(pedidos.pedido_json,'$.parcelas[0].parcela.forma_pagamento.descricao')  USING utf8) AS  Descricao,
          JSON_EXTRACT(pedidos.pedido_json,'$.parcelas[0].parcela.forma_pagamento.codigoFiscal') AS  CodFiscal,
          REPLACE(JSON_EXTRACT(pedidos.pedido_json,'$.observacoes'),'\"','') AS  ObsNota,
          REPLACE(JSON_EXTRACT(pedidos.pedido_json,'$.observacaointerna'),'\"','') AS  ObsInterna,
          pedidos.pagamento,
          pedidos.pedido_loja,
          pedidos.situacao,
          pedidos.pedido_json
          from
          bs_notas as notas, bs_pedidos as pedidos
          where
          notas.nfe_chaveAcesso = pedidos.chaveAcesso
          AND JSON_EXTRACT(pedidos.pedido_json,'$.parcelas[0].parcela.forma_pagamento.codigoFiscal') = 5
          AND DATE(notas.nfe_dataEmissao) >= :dataInicial AND DATE(notas.nfe_dataEmissao) <= :dataFinal
          AND (notas.nfe_situacao = 'Autorizada'
          OR notas.nfe_situacao = 'Emitida DANFE')";

  $res = dbf($sql,array(':dataInicial'=>$dataInicial,':dataFinal'=>$dataFinal),'fetch','ufowayco_blingsinc');

  $total=0;
  for ($i = 0; $i < count($res); $i++)
  {
    $drow=$res[$i];
    $total += (float) $drow['valorNota'];
  }

  $resDATA=array();
  if(isSet($res[0])){
    $resDATA = $res[0];
  }

  $result=array('res'=>$resDATA,'qtd'=>count($res),'total'=>$total,'resData'=>$res);
  return $result;

}

function totalDeBonificacoes_noPeriodo($dataInicial,$dataFinal){ /*em uso ceospanel dashboard*/

  $sql = "SELECT
          *
          FROM `bs_notas`
          WHERE
          nfe_tipo = 'S'
          AND DATE(nfe_dataEmissao) >= :dataInicial AND DATE(nfe_dataEmissao) <= :dataFinal
          AND nfe_cfops IN ('6910','5910')
          AND nfe_situacao IN ('Autorizada','Emitida DANFE','Enviada - Aguardando protocolo')";

  $res = dbf($sql,array(':dataInicial'=>$dataInicial,':dataFinal'=>$dataFinal),'fetch','ufowayco_blingsinc');

  $total=0;
  for ($i = 0; $i < count($res); $i++)
  {
    $drow=$res[$i];
    $total += $drow['nfe_valorNota'];
  }

  $resDATA=array();
  if(isSet($res[0])){
    $resDATA = $res[0];
  }

  $result=array('res'=>$resDATA,'qtd'=>count($res),'total'=>$total,'resData'=>$res);
  return $result;

}
