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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="assets/fancybox/jquery.fancybox.css">
    <link rel="stylesheet" href="assets/css/alertify.css">
    <link rel="stylesheet" href="assets/css/alertify.default.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="assets/css/app.css?v=<?php echo time(); ?>">
    <title>CEOS PANEL</title>
    <?php
    include_once('app/graficos/graficos.php');
    ?>
  </head>
  <body>

  <?php
  include_once('navbar.php');
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


    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
<!--
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
-->
    <script src="assets/js/jquery-3.5.1.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>

<!--
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>
-->

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.min.js" integrity="sha384-VHvPCCyXqtD5DqJeNxl2dtTyhF78xXNXdkwX1CZeRusQfRKp+tA7hAShOK/B/fQ2" crossorigin="anonymous"></script>
    -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.pt-BR.min.js" integrity="sha512-mVkLPLQVfOWLRlC2ZJuyX5+0XrTlbW2cyAwyqgPkLGxhoaHNSWesYMlcUjX8X+k45YB8q90s88O7sos86636NQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script type="text/javascript" src="https://canvasjs.com/assets/script/jquery.canvasjs.min.js"></script>
    <script src="assets/js/alertify.min.js"></script>
    <script src="assets/fancybox/jquery.fancybox.pack.js"></script>
    <script src="assets/js/custom.js?v=<?php echo time();?>"></script>
<!--
    <script src="assets/js/scripts-js.php?v=<?php echo time();?>"></script>
-->
    <script>

      <?php
      if(sessionVar('statusMessage')!=''){
      echo sessionVar('statusMessage');
      $_SESSION['statusMessage'] = '';
      }
      ?>

    </script>
  </body>
</html>
