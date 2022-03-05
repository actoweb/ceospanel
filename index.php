<?php
include_once('config.all.php');
?>
<!doctype html>
<html lang="pt-br">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/bootstrap-datepicker.min.css" />
    <link rel="stylesheet" href="assets/fancybox/jquery.fancybox.css">
    <link rel="stylesheet" href="assets/css/bootstrap-table.min.css">
    <link rel="stylesheet" href="assets/css/bootstrap-table-sticky-header.min.css">
    <link rel="stylesheet" href="assets/css/alertify.css">
    <link rel="stylesheet" href="assets/css/alertify.default.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="assets/css/app.css?v=<?php echo time(); ?>">
    <title>CEOS PANEL</title>
    <?php
    //arquivo com configuracoes variaveis para relatorios (tabelas de graficos)
    include_once('reports_vars.php');
    ?>
  </head>
  <body>

  <?php
  include_once('app/includes/navbar.php');
  ?>


<div class="container-fluid">
<?php
include_once("app/pages/${_page}.page.php");
?>
</div>


<script>
var pathUrl='<?php echo $app_url;?>';
<?php if(!isSet($loadTAR)){$loadTAR='';}?>
var loadTAR='<?php echo $loadTAR;?>';
</script>

    <script src="assets/js/jquery-3.5.1.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="assets/locales/bootstrap-datepicker.pt-BR.min.js"></script>
<!--
    <script type="text/javascript" src="https://canvasjs.com/assets/script/jquery.canvasjs.min.js"></script>
-->
    <script src="assets/js/bootstrap-table.min.js"></script>
    <script src="assets/js/bootstrap-table-mobile.min.js"></script>
    <script src="assets/js/bootstrap-table-pt-BR.min.js"></script>
    <script src="assets/js/bootstrap-table-sticky-header.min.js"></script>
    <script src="assets/js/alertify.min.js"></script>
    <script src="assets/fancybox/jquery.fancybox.pack.js"></script>
    <script src="assets/js/custom.js?v=<?php echo time();?>"></script>
    <script>
      <?php
      if(sessionVar('statusMessage')!=''){
      echo sessionVar('statusMessage');
      $_SESSION['statusMessage'] = '';
      }
      ?>
      var $table = $('#table')
      $('#table').bootstrapTable({pagination: true,search: true});
    </script>
  </body>
</html>
