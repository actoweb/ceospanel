<div class="row">

  <div class="col-md-4"></div>
  <div class="col-md-4">

    <div class="card mt-5" style="width:80%!important;margin:0px auto;">
      <div class="card-header">
        <b>ACESSO AO CEOS</b>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-9">
            <form id="frmLogin" name="frmLogin" method="POST" action="<?php $PHP_SELF; ?>">
              <div class="mb-3">
                <input type="text" class="form-control" id="username" name="username" placeholder="Username">
              </div>
              <div class="mb-3">
                <input type="password" class="form-control" id="usrpwd" name="usrpwd" placeholder="Senha de acesso">
              </div>
              <button type="submit" class="btn btn-primary">Autenticar</button>
              <small style="float:right;"><a href="#">Esqueci a senha</a></small>

              <?php
              if (isset($login_status) && $login_status == 'error') {
              ?>
                <div class="alert alert-warning mt-2" role="alert">
                  Os dados informados não conferem
                </div>
              <?php
              }
              ?>

            </form>
          </div>
          <div class="col-md-3">
            <img src="assets/images/login.png" style="max-width:80px;height:auto;" />
          </div>
        </div>
      </div>
      <div class="card-footer text-muted">
        <small><b>UFO WAY LABS - TI TEAM</b></small>
      </div>
    </div>



  </div>
  <div class="col-md-4"></div>


</div>