<?php

function getClientes(){
  $res = dbf('SELECT * FROM clientes','','fetch');
  return $res;
}

function getClienteData($idCli){
  $res = dbf('SELECT * FROM clientes WHERE id = :id',array(':id'=>$idCli),'fetch');
  return $res;
}

function getPedidosByPedID($pedCli){
  $res = dbf('SELECT * FROM pedidos_clientes WHERE id = :uid',array(':uid'=>$pedCli),'fetch');
  return $res;
}

function getPedidos($uidCli){
  $res = dbf('SELECT * FROM pedidos_clientes WHERE cliente_id = :uid',array(':uid'=>$uidCli),'fetch');
  return $res;
}

function getProdutos($uidCli){
  $res = dbf('SELECT * FROM produtos_clientes WHERE cliente_id = :uid',array(':uid'=>$uidCli),'fetch');
  return $res;
}

function getProdutosData($uidProd){
  $res = dbf('SELECT * FROM produtos_clientes WHERE id = :uid',array(':uid'=>$uidProd),'fetch');
  return $res;
}

function getItensPedido($uidItem){
  $res = dbf('SELECT * FROM pedidos_itens WHERE id = :uid',array(':uid'=>$uidItem),'fetch');
  return $res;
}

//verifica se ja existe separacao para o pedido atual, caso nao entao cria ela
function separacaoPedidos($args=array()){

  $cliente_id   = $args['cliente_id'];
  $pedido_id    = $args['pedido_id'];
  $datainicio   = date('Y-m-d H:i:s');
  $datatermino  = arrayVar($args,'datatermino');
  $observacoes  = arrayVar($args,'observacoes');
  $status       = arrayVar($args,'status');


  //consulta existencia de separacao em andamento
  $res =  dbf('SELECT * FROM separacao_pedidos WHERE
          cliente_id = :cliente_id AND pedido_id = :pedido_id',
          array(':cliente_id'=>$cliente_id,':pedido_id'=>$pedido_id),'num');

  if($res>0){



  $res2 =   dbf('SELECT * FROM separacao_pedidos WHERE
            cliente_id = :cliente_id AND pedido_id = :pedido_id',
            array(':cliente_id'=>$cliente_id,':pedido_id'=>$pedido_id),'fetch');

      return $res2;//caso exista separacao em andamento retorna ARRAY com os dados

  }else{//caso contrario cria o registro na tabela

    $ins =  dbf('INSERT separacao_pedidos
            SET
            cliente_id  = :cliente_id,
            pedido_id   = :pedido_id,
            datainicio  = :datainicio,
            status      = :status',
            array(':cliente_id'=>$cliente_id,':pedido_id'=>$pedido_id,':datainicio'=>$datainicio,':status'=>1),'');

    if($ins){//retorna o ID da separacao criada
        return $ins;
    }

  }
}

//funcao para incrementar os itens que estao sendo separados
function contaItemSeparado($uidprod='',$barcode=''){
  if($uidprod!=''&&$barcode!=''){

    $res = dbf('SELECT * FROM pedidos_itens WHERE
              produto_id = :produto_id AND barcode = :barcode',array(
            ':produto_id'=>$uidprod,
            ':barcode'=>$barcode),'fetch');

    $tot = $res[0]['total_separado']+1;


    $upd =  dbf('UPDATE pedidos_itens SET total_separado = :totalSeparado
            WHERE produto_id = :produto_id AND barcode = :barcode',array(
            ':totalSeparado'=>$tot,
            ':produto_id'=>$uidprod,
            ':barcode'=>$barcode),'');
    if($upd){
        return $upd;//retorna o numero de linhas afetadas
    }else{
        return false;//retorna falso em caso de erro
    }
  }
}


//retorna o total de itens de um pedido
function totalItensPedido($uidped){
  $res = dbf('SELECT SUM(qtd), SUM(total_separado) FROM pedidos_itens WHERE pedido_id = :pedido_id',
          array(':pedido_id'=>$uidped),'fetch');
  return $res;
}

//pesquisa produto pelo codigo de barras
function getProdutoByBarcode($barcode){
  $se = dbf('SELECT * FROM produtos_clientes WHERE barcode = :barcode',array(':barcode'=>$barcode),'fetch');
  return $se;
}

//funcao para SALVAR (ANOTAR) a caixa fechada
function saveBox($args=array()){
  $pedido_id      = $args['pedido_id'];
  $separacao_id   = $args['separacao_id'];
  $ref_ped        = $args['ref_ped'];
  $produto_id     = $args['produto_id'];
  $qtd            = $args['qtd'];


  //consultamos quantas caixas já foram fechadas para este pedido
  //assim obtemos o CAIXA NUMERO
  $chk =  dbf('SELECT * FROM caixas_pedidos WHERE pedido_id = :pedido_id',
          array(':pedido_id'=>$pedido_id),'num');

  //caso nenhum caixa tenha sido fechada entao conta como a PRIMEIRA
  //caso contrato incrementa o numero encontrado ++
  if($chk==0){
    $numero_caixa = 1;
  }else{
    $numero_caixa = $chk+1;
  }


  //agora salva a caixa na tabela de dados
  $ins = dbf('INSERT caixas_pedidos SET
          caixa_numero  = :caixa_numero,
          separacao_id  = :separacao_id,
          pedido_id     = :pedido_id,
          ref_ped       = :ref_ped,
          produto_id    = :produto_id,
          qtd           = :qtd',array(
          ':caixa_numero'=> $numero_caixa,
          ':separacao_id'=> $separacao_id,
          ':pedido_id'=>    $pedido_id,
          ':ref_ped'=>      $ref_ped,
          ':produto_id'=>   $produto_id,
          ':qtd'=>          $qtd),'');

}


//funcao para gerar etiquetas com base no pedido uid
function mkLabels($peduid){
  $printer=array();
  //qual o cliente dono deste pedido
  $pc       = dbf('SELECT * FROM pedidos_clientes WHERE id = :uid',
              array(':uid'=>$peduid),'fetch');

  //var_dump($pc);

  $cliUID   = $pc[0]['cliente_id'];
  $refPed   = $pc[0]['referencia'];

  //qual o nome deste cliente
  $cli      = getClienteData($cliUID);
  $nomeCli  = $cli[0]['nomeCliente'];


  //quantas caixas existem para esse pedido
  $tc = dbf('SELECT * FROM caixas_pedidos WHERE pedido_id = :pedido_id',array(
        ':pedido_id'=>$peduid),'num');

  $totalCXpedido = $tc;

  //dados do cliente (NOME)
  $cli  = getClienteData($cliUID);


  //construcao array de impressao com os dados de cada caixa
  $printer['sender']  = 'UFO WAY EXPORTAÇÃO E IMPORTAÇÃO EIRELI';
  $printer['totbox']  = $totalCXpedido;
  $printer['cliente'] = $nomeCli;
  $printer['pedref']  = $refPed;


  //dados da caixa
  $cxdata = dbf('SELECT * FROM caixas_pedidos
            WHERE pedido_id = :pedido_id
            ORDER BY caixa_numero ASC',array(
            ':pedido_id'=>$peduid),'fetch');


  for ($i = 0; $i < count($cxdata); $i++)
  {
    $cxD = $cxdata[$i];
    $caixa_numero = $cxD['caixa_numero'];
    $produto_id   = $cxD['produto_id'];

    $pd   = getProdutosData($produto_id);
    $descricao_produto  = $pd[0]['descricao'];
    if(strstr($descricao_produto,'TM:')){
    $tm       = explode('TM:',$descricao_produto);
    $tm_prod  = $tm[1];
    $descricao_produto  = $tm[0];
    }else{
    $tm_prod  = 'ND';
    }
    $tamanho_produto    = $tm_prod;

    $qtdCx    = $cxD['qtd'];
    $cxNum    = $cxD['caixa_numero'] . '/' . $totalCXpedido;

    $printer['produtos'][] = array(
      'itemfilho'=>'0000000',
      'descricao'=>$descricao_produto,
      'tamanho'=>$tamanho_produto,
      'cor'=>$pd[0]['cor'],
      'quantidade'=>$qtdCx,
      'cxnumero'=>$caixa_numero
    );
  }
  return $printer;
}



function resumo_VendaBrutas($dataInicial='',$dataFinal=''){
  if($dataInicial==''){$dataInicial='2021-10-29';}
  if($dataFinal=='')  {$dataFinal=date('Y-m-d');}else{$dataFinal = $dataFinal;}

  $sql = "SELECT
          ROUND(SUM(nfe_valorNota),2) as total
          FROM bs_notas
          WHERE
          nfe_tipo = :tipo
          AND (nfe_cfops = :nfe_cfops1 OR nfe_cfops = :nfe_cfops2)
          AND DATE(nfe_dataEmissao) >= :nfe_dataEmissao1 AND DATE(nfe_dataEmissao) <= :nfe_dataEmissao2
          AND (nfe_situacao = :nfe_situacao1 OR nfe_situacao = :nfe_situacao2)
          ORDER BY nfe_numero ASC";

  $res = dbf($sql,array(':tipo'=>'S',
                        ':nfe_dataEmissao1'=>$dataInicial,
                        ':nfe_dataEmissao2'=>$dataFinal,
                        ':nfe_cfops1'=>'5102',
                        ':nfe_cfops2'=>'6108',
                        ':nfe_situacao1'=>'Autorizada',
                        ':nfe_situacao2'=>'Emitida DANFE'),'fetch','ufowayco_blingsinc');
  //echo $sql;
  return $res;
}


function resumo_bonificacoes($dataInicial='',$dataFinal=''){
  if($dataInicial==''){$dataInicial='2021-10-29';}
  if($dataFinal=='')  {$dataFinal=date('Y-m-d');}else{$dataFinal = $dataFinal;}

  $sql = "SELECT
          ROUND(SUM(nfe_valorNota),2) AS total
          FROM `bs_notas`
          WHERE
          nfe_tipo = :tipo
          AND DATE(nfe_dataEmissao) >= :nfe_dataEmissao1 AND DATE(nfe_dataEmissao) <= :nfe_dataEmissao2
          AND (nfe_cfops = :nfe_cfops1 OR  nfe_cfops = :nfe_cfops2)
          AND (nfe_situacao = :nfe_situacao1 OR nfe_situacao = :nfe_situacao2)";

  $res = dbf($sql,array(':tipo'=>'S',
                        ':nfe_dataEmissao1'=>$dataInicial,
                        ':nfe_dataEmissao2'=>$dataFinal,
                        ':nfe_cfops1'=>'6910',
                        ':nfe_cfops2'=>'5910',
                        ':nfe_situacao1'=>'Autorizada',
                        ':nfe_situacao2'=>'Emitida DANFE'),'fetch','ufowayco_blingsinc');

  return $res;
}


function vendasPorEstado($dataInicial='',$dataFinal=''){
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


function limpaSku($str){
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


function topProdutos($dataInicial,$dataFinal){

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
















function listaTodosPedidos($dataInicial,$dataFinal){
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


function totalBrutoDeNotas_noPeriodo($dataInicial,$dataFinal){

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


function totalDeNotasDevolucoes_noPeriodo($dataInicial,$dataFinal){

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


function totalDeTrocas_noPeriodo($dataInicial,$dataFinal){

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


function totalDeBonificacoes_noPeriodo($dataInicial,$dataFinal){

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

















?>
