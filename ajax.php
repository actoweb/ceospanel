<?php
include_once('config.all.php');
include_once('functions/functions.all.php');

if(getVar('view')=='userPerms'&&getVar('useruid')!=''){

//abre a fancywin com a lista de permissoes do usuarios selecionado
include_once('app/pages/views/usuarios/fancywin-userPerms.php');  

}



if(getVar('topprod')!=''){

//janela fancy com a tabela com os detalhes dos itens mais vendidos
include_once('app/pages/views/vendas/fancywin-top-prod.php');

}elseif(getVar('v')=='table' && getVar('grid')!=''){

//janela fancy com a tabela das vendas do dashboard
include_once('app/pages/views/vendas/fancywin-wbox-grid.php');

}

//consulta frete na jadlog
if(postVar('optdo')=='getFreteStatus'){
  //rotinas para obter o status do frete na jadlog
  include_once('app/pages/views/fretes/status-frete-jadlog.php');
}
