        <ul class="list-group">
          <li class="list-group-item list-group-item-dark"><b>OPÇÕES</b></li>
<!--
          <li class="list-group-item"><a href="?opt=vendas&view=consulta-venda">Consultar venda</a></li>
-->
          <li class="list-group-item"><a href="?opt=vendas&view=vendas-periodo-resumo">Resumo</a></li>
          <!--
          <li class="list-group-item"><a href="?opt=vendas&view=vendas-periodo&visao=mensal">Vendas Mensais(BETA)</a></li>
          <li class="list-group-item"><a href="?opt=vendas&view=vendas-periodo&visao=semanal">Vendas Semanais(BETA)</a></li>
          <li class="list-group-item"><a href="?opt=vendas&view=vendas-periodo&visao=diaria">Vendas Diárias(BETA)</a></li>
          -->
<!--
          <li class="list-group-item"><a href="?opt=vendas&view=vendasxdev-periodo">Vendas X Devoluções</a></li>
-->
<!--
          <li class="list-group-item"><a href="?opt=vendas&view=consultar-frete">Consulta Frete</a></li>
-->
        </ul>

    <div class="card mt-2">
      <div class="card-header text-white bg-secondary"><b>Perído</b></div>
      <div class="card-body">

      <form method="post" action="?opt=vendas&view=vendas-periodo-resumo&visao=<?php echo getVar('visao');?>&grafico=bars">
        <input type="hidden" id="showgraph" name="showgraph" value="bar-graph-vendas-periodo" />
        <div class="form-row">
          <div class="form-group col-md-12">
            <label for="inputEmail4">Intervalo</label>

            <select id="periodo" name="periodo" class="form-control">
              <?php $pe=postVar('periodo');?>
              <option value=""<?php echo selselr('',$pe);?>>Selecione</option>
              <option value="H"<?php echo selselr('H',$pe);?>>Hoje</option>
              <option value="O"<?php echo selselr('O',$pe);?>>Ontem</option>
              <option value="7"<?php echo selselr('7',$pe);?>>Últimos 7 dias</option>
              <option value="15"<?php echo selselr('15',$pe);?>>Últimos 15 dias</option>
              <option value="30"<?php echo selselr('30',$pe);?>>Últimos 30 dias</option>
              <option value="all"<?php echo selselr('all',$pe);?>>Período completo</option>
            </select>
          </div>
          <div class="form-group col-md-12">
            <label for="datainicial">Data Inicial</label>
            <?php $di=postVar('datainicial');?>
            <input type="text" class="form-control" id="datainicial" name="datainicial" value="<?php echo $di;?>">
          </div>
          <div class="form-group col-md-12">
            <label for="datafinal">Data Final</label>
            <?php $df=postVar('datafinal');?>
            <input type="text" class="form-control" id="datafinal" name="datafinal" value="<?php echo $df;?>">
          </div>

        </div>
      <button type="submit" class="btn btn-primary" id="dofilter">Filtrar</button>
      </form>

      </div>
    </div>
