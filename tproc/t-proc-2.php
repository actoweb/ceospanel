<?php
include_once('config.all.php');




$ins = dbf_o("INSERT pedidos_bling_json_2 SET
              numero = 1,
              numeroPedidoLoja = 100,
              data = '2022-02-15',
              json_pedido = 'testeJson',
              dataimportacao = '2022-01-15'");


echo $ins;


?>
