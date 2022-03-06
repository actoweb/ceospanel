<script>
  var pathUrl = '<?php echo $app_url; ?>';
  <?php if (!isset($loadTAR)) {
    $loadTAR = '';
  } ?>
  var loadTAR = '<?php echo $loadTAR; ?>';
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
<script src="assets/js/custom.js?v=<?php echo time(); ?>"></script>
<script>
  <?php
  if (sessionVar('statusMessage') != '') {
    echo sessionVar('statusMessage');
    $_SESSION['statusMessage'] = '';
  }
  ?>
  var $table = $('#table')
  $('#table').bootstrapTable({
    pagination: true,
    search: true
  });

  <?php
  if (isset($login_status) && $login_status == 'error') {
    echo 'Alertify.log.error("<h5>Ops!</h5>Os dados informados não conferem!");';
  }

  if(isSet($dataTable)&&$dataTable!=''){
    echo 'var $table = '."$('#$dataTable');\n";
    echo "$('#$dataTable').bootstrapTable({pagination: true,search: true});\n";
  }

  ?>
</script>
</body>

</html>