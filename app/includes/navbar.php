  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand ceoslogo" href="<?php echo $app_url;?>">CEOS</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <a class="nav-link" href="<?php echo $app_url;?>">Início <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
            Módulos
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="?opt=fretes">Fretes</a>
            <a class="dropdown-item" href="?opt=vendas&view=vendas-periodo-resumo">Vendas</a>
            <a class="dropdown-item" href="?opt=consulta-plataforma&view=consulta-venda">Consulta Plataforma</a>
            <div class="dropdown-divider"></div>
          </div>
        </li>
      </ul>

    </div>


<div class="pull-right" >


<ul class="navbar-nav ml-auto">

            <li class="nav-item dropdown">
                <a class="nav-link" href="#" id="navbarDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <b>
                    usuario
                  <i class="fas fa-chevron-down"></i></b>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="mod/perfil"><i class="fa fa-user" aria-hidden="true"></i> Perfil</a>
                    <a class="dropdown-item" href="<?php echo $app_url;?>"><i class="fa fa-lock" aria-hidden="true"></i> Alterar Senha</a>
                    <a class="dropdown-item" href="user/logout"><i class="fas fa-sign-out-alt" aria-hidden="true"></i> Logout</a>
                </div>
            </li>
        </ul>


</div>

  </nav>
