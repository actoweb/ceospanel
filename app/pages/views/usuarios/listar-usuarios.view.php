<div class="card">
  <div class="card-header">
    <b>Lista de Usuários do CEOS</b>
  </div>
  <div class="card-body">

    <?php $dataTable = 'tblUsuarios'; ?>
    <table id="tblUsuarios" data-toggle="table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nome</th>
          <th>Email</th>
          <th>Data Cadastro</th>
          <th>Permissões</th>
          <th>Status</th>
          <th>Nivel</th>
        </tr>
      </thead>
      <tbody>

        <?php
        $usuarios = selectDB2('*', 'usuarios', false, ' ORDER BY nome ASC');
        if (is_array($usuarios)) {
          $table = '';
          for ($i = 0; $i < count($usuarios); $i++) {

            $nivelUsuario = $usuarios[$i]['nivel']==2 ? '<b style="color:red">Admin</b>' : '<b>User</b>';
            $table .= '<tr>';
            $table .= '<td>1</td>';
            $table .= '<td><a href="?opt=usuarios&view=adm-usuarios&uid=' . $usuarios[$i]['id'] . '">' . $usuarios[$i]['nome'] . '</td>';
            $table .= '<td>' . $usuarios[$i]['email'] . '</td>';
            $table .= '<td>' . swdatetime($usuarios[$i]['dtcadastro']) . '</td>';
            $table .= '<td><a href="#" class="viewUserPerm" data-useruid="' . $usuarios[$i]['id'] . '">Visualizar</td>';
            $table .= '<td>' . $usuarios[$i]['status'] . '</td>';
            $table .= '<td>' . $nivelUsuario . '</td>';
            $table .= '</tr>' . "\n";
          }
        }
        if ($table != '') {
          echo $table;
        }
        ?>

      </tbody>
    </table>
  </div>
  <div class="card-footer text-muted">
    <small><b>UFO WAY LABS - TI TEAM</b></small>
  </div>
</div>