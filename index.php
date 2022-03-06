<?php
include_once('config.all.php');


include_once('app/includes/headers.inc.php');

// caso usuario nao esteja logado entao carrega a pagina de login
if (sessionVar('usrCeos') == '' && sessionVar('usrLevel') == '') {

  //carrega as rotinas de login
  include_once('app/rotinas/login.process.php');

  //carrega a navbar de usuarios nao autenticados
  include_once('app/includes/navbar-noAuth.php');

  //carrega a pagina de login do usuario
  include_once('app/pages/login.page.php');
  
} else { //caso contrario carrega pagina normalmente

  include_once('app/includes/navbar.php');

?>

  <div class="container-fluid">
    <?php include_once("app/pages/${_page}.page.php"); ?>
  </div>

<?php
}
include_once('app/includes/footers.inc.php'); ?>