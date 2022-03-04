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



?>
