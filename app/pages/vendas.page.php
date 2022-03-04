<?php
$opt  = getVar('opt');
$view = getVar('view');
?>

  <div class="row mt-5">
    <div class="col-md-2 sidebar">
        <?php
        $menu_view = "app/pages/views/$opt/menu-$opt.view.php";
        include_once($menu_view);
        ?>
    </div>
    <div class="col-md-10">

        <?php
        if($view==''){$view='home';}

        $url_view = "app/pages/views/$opt/$view.view.php";


        if(file_exists($url_view)){

          include_once($url_view);

        }else{

          echo "<h3>View ($url_view) não disponível!</h3>";

        }

        ?>

    </div>
  </div>
