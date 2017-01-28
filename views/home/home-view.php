<!-- HOME VIEW -->
<?php
    if (! defined('EFIPATH')) exit;

    //var_dump($_SESSION);

    $alarmesRegistrados = $modeloAlarme->alarmesGerados();
    
    /*
    * VERIFICA O TIPO DE USUÁRIO E EFETUA AS RESPECTIVAS OPERAÇÕES
    */
    switch ($_SESSION['userdata']['tipo_usu']) {
        case 'Administrador':
            //var_dump($_SESSION);

            $alarmesRegistrados = $modeloAlarme->alarmesGerados();

        break;

        case 'Cliente':

            $alarmesRegistrados = $modeloAlarme->alarmesGeradosCliente($_SESSION['userdata']['cliente']);

        break;

        case 'Visitante':

            $alarmesRegistrados = $modeloAlarme->alarmesGeradosCliente($_SESSION['userdata']['cliente']);

        break;

        case 'Tecnico':
            $alarmesRegistrados = $modeloAlarme->alarmesGerados();

        break;
    }


?>

    <script type="text/javascript">
        // gerenciador de link
        var menu = document.getElementById('listadir');
        menu.innerHTML = '<a href="<?php echo HOME_URI; ?>/home/" class="linkMenuSup">Home</a>';
    </script>

    <!-- MENSAGEM DE BOAS VINDAS -->

    <div class="row">
        <div class="col-md-8 barraBemvindo">
            <!-- Titulo pagina -->
            <label class="page-header">
                <h4>Bem vindo, <?php echo $_SESSION['userdata']['firstname']." ".$_SESSION['userdata']['secondname']; ?></h4>
            </label>
        </div>
        <div class="col-md-4 pull-right">
            <!-- <div class="panel panel-info">
                <div class="panel-heading">
                    <i class="fa fa-clock-o  fa-fw"></i> Última atualização
                </div>
                <div class="panel-body">
                    <p>
                        <?php // Exibe alguma coisa como: Monday 8th of August 2005 03:12:46 PM
                            //echo date('d/ m/ Y, g:i a');
                        ?>
                    </p>
                </div>
            </div> -->
        </div>
    </div>

    <?php

        //Se usuário for administrador
        if(($_SESSION['userdata']['cliente'] == 0) && ($_SESSION['userdata']['tipo_usu'] == 'Administrador')){

            $listaCliente = $modeloCliente->listarCliente($_SESSION['userdata']['cliente'], $_SESSION['userdata']['tipo']);

            //var_dump($_SESSION);

    ?>

    <?php

        }else{

            $listarFiliais = $modeloFilial->filiaisCliente($_SESSION['userdata']['cliente']);

            if($listarFiliais){
                //var_dump($listarFiliais);
            }
    ?>

    <?php

        }

    ?>


    <!-- CONTAGEM DE ALERTAS -->
    <!-- CONTADOR DE ALERTAS COMENTADO E SUBSTITUIDO POR UM TABELA MENOR-->
    <!-- <div class="row"> -->
        <!-- ALERTAS GERADOS -->
        <!-- <div class="col-lg-3 col-md-6">
            <a href="<?php echo HOME_URI; ?>/alarme/alarmeStatus/1">
                <div class="panel panel-red">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-warning fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge">0</div>
                                <div>Alarme <br> gerados!</div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer alert-danger">
                        <span class="pull-left">Ver detalhes</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </a>
        </div> -->
        <!-- ALERTAS RECONHECIDOS -->
        <!-- <div class="col-lg-3 col-md-6">
            <a href="<?php echo HOME_URI; ?>/alarme/alarmeStatus/2">
                <div class="panel panel-yellow">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-search-plus fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge">0</div>
                                <div>Alarmes </br>reconhecidos!</div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer alert-warning">
                        <span class="pull-left">Ver detalhes</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </a>
        </div> -->
        <!-- ALERTAS RECONHECIDOS E SOLUCIONADOS -->
        <!-- <div class="col-lg-3 col-md-6">
            <a href="<?php echo HOME_URI; ?>/alarme/alarmeStatus/3">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-wrench fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge">0</div>
                                <div>Alarmes </br>solucionados!</div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer alert-info">
                        <span class="pull-left">Ver detalhes</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </a>
        </div> -->
        <!-- ALERTAS FINALIZADOS -->
        <!-- <div class="col-lg-3 col-md-6">
            <a href="<?php echo HOME_URI; ?>/alarme/alarmeStatus/4">
                <div class="panel panel-green">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa  fa-check fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge">0</div>
                                <div>Alarmes </br> finalizados!</div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer alert-success">
                        <span class="pull-left">Ver detalhes</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </a>
        </div> -->
    <!-- </div> -->

    <!-- FILTRO DE ALERTAS -->
    <!-- <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <a data-toggle="collapse" data-parent="" href="#filtroCollapse"><i class="fa fa-arrow-circle-o-down fw"></i> Filtro de alarmes </a>
                </div>
                <div id="filtroCollapse" class="painel-body panel-collapse collapse in">
                    <form id="filtroAlarmes">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Cliente/Filia</label><br>
                                <?php $modelo->loadClienteFilial(); ?>
                            </div>
                        </div>
                        <div class="col-md-4">

                        </div>
                        <div class="col-md-4">
                            <button class="btn btn-info">Filtrar</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div> -->

    <!-- PRINCIPAIS STATUS DE ALERTAS -->
    <!-- <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne"><i class="fa fa-list-ul fa-fw"></i> Status de alarmes</a>
                </div>
                <div id="collapseOne" class="panel-body panel-collapse collapse in">
                    <table class="table-responsive">
                        <tr>
                            <td class="blink-test">
                                <i class="fa fa-exclamation-circle fa-fw alert-danger "></i> Alarme gerado
                            </td>
                            <td>
                                <i class="fa fa-exclamation-circle fa-fw alert-warning"></i> Alarme reconhecido
                            </td>
                            <td>
                                <i class="fa fa-exclamation-circle fa-fw alert-info"></i> Alarme solucionado
                            </td>
                            <td>
                                <i class="fa fa-exclamation-circle fa-fw alert-success"></i> Alarme finalizado
                            </td>

                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div> -->

    <!-- GRÁFICO DOS ÚLTIMOS ALERTAS -->
    <div class="row">
        <!-- /.panel -->
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-bar-chart-o fa-fw"></i> Últimos registros de alarmes
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="table-responsive">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>Status</th>
                                        <th>Data</th>
                                        <th>Cliente</th>
                                        <!-- <th>Módulo</th> -->
                                        <th>Equipamento</th>
                                        <th>Descrição</th>
                                        <th>Medida gerada</th>
                                        <th>Detalhes</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                                        if($alarmesRegistrados['status']){

                                            foreach ($alarmesRegistrados['alerta'] as $listaAlarmes) {
                                    ?>
                                        <tr>
                                            <td>
                                                <?php
                                                    switch ($listaAlarmes['status_ativo']) {
                                                        case '1':
                                                            echo "<i class='fa fa-exclamation-triangle  fa-2x fa-blink' style='color:red'></i> <p> Novo</p>";
                                                        break;
                                                        case '2':
                                                            echo "<i class='fa fa-exclamation-triangle  fa-2x' style='color:orange'></i> <p> Visualizado</p>";
                                                        break;
                                                        case '3':
                                                            echo "<i class='fa fa-exclamation-triangle  fa-2x' style='color:yellow'></i> <p> Em tratamento</p>";
                                                        break;
                                                        case '4':
                                                            echo "<i class='fa fa-exclamation-triangle  fa-2x' style='color:gray'></i> <p> Solucionado</p>";
                                                        break;

                                                        default:
                                                            echo "<i class='fa  fa-check  fa-2x' style='color:green'></i> <p> Finalizado</p>";
                                                        break;
                                                    }
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                    $data = explode(" ", $listaAlarmes['dt_criacao']);
                                                    echo implode("/",array_reverse(explode("-", $data[0])));
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                    echo $listaAlarmes['nome'];
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                    echo $listaAlarmes['nomeEquipamento'];
                                                ?>
                                            </td>
                                            <td>
                                                <p>
                                                    <b>
                                                        <?php
                                                            echo $listaAlarmes['mensagem'];
                                                        ?>
                                                    </b>
                                                </p>

                                            </td>
                                            <td>
                                                <h4>
                                                    <span class="text-danger">
                                                        <?php
                                                            echo  $listaAlarmes['parametroMedido'];
                                                        ?>
                                                    </span>/
                                                    <span class="text-info">
                                                        <?php
                                                            echo $listaAlarmes['parametroAtingido'];
                                                        ?>
                                                    </span>
                                                </h4>
                                            </td>
                                            <td>
                                                <button class="btn btn-primary" onclick="detalharAlarme(<?php echo $listaAlarmes['id']; ?>)">
                                                    <i class="fa fa-search "></i> Detalhes
                                                </button>
                                            </td>
                                        </tr>

                                    <?php
                                            }

                                        }else{
                                    ?>
                                    <tr>
                                        <td colspan="8">Nenhum alarme gerado até o momento!</td>
                                    </tr>
                                    <?php

                                        }

                                    ?>


                                </tbod>
                            </table>
                        </div>
                        <!-- /.table-responsive -->
                    </div>
                </div>
            </div>
        </div>

    </div>


    <!--
        Modal para exibição dos detalhes do alarme especificado
    -->
    <!-- Modal -->
    <div class="modal fade" id="detalhesAlarme" tabindex="-1" role="dialog" aria-labelledby="detalhes">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Detalhes do alarme</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <!-- Data do alarme -->
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <i class="fa fa-warning "></i> <span id="statusAlarme"></span>
                            </div>

                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="well">
                                        <p>
                                                Data de geração : <span id="dataGeracao"></span>
                                        </p>
                                        <p>
                                                Data de geração : <span id="dataVizualizacao"></span>
                                        </p>

                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="well">
                                        <p>
                                                Vínculo equipamento : <span id="nomeCliente"></span>
                                        </p>
                                        <p>
                                                Local do alarme : <span id="localAlarme"></span>
                                        </p>

                                    </div>
                                </div>
                            </div>

                            <!-- <div class="row">
                                <div class="col-md-12">
                                    <div class="well">

                                        <p>
                                            <b>Limite que gerou o alarme : </b><span id="limiteAlarme"></span>
                                        </p>
                                        <p>
                                            <b>Descrição extra : </b><span id="informacaoesAlarme"></span>
                                        </p>

                                    </div>
                                </div>
                            </div> -->

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="well">
                                        <p>
                                            <b>Medida que gerou o alarme : </b><span id="tipoMedida"></span>
                                        </p>
                                        <p>
                                            <b>Medida que gerou o alarme : </b><span id="medidaOriginal"></span>
                                        </p>
                                        <p>
                                            <b>Última medida Registrada : </b><span id="ultimaMedida"></span>
                                        </p>

                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="well">
                                        <form id="solucaoAplicada" method="post">
                                            <div class="row">
                                                <div class="col-md-4 ">
                                                    <div class="form-group">
                                                        <label for="statusAlarmeModal">Status do alarme</label>
                                                        <select id="statusAlarmeModal" name="statusAlarmeModal" class="form-control">
                                                            <option value="2">Visualizado</option>
                                                            <option value="3">Em tratamento</option>
                                                            <option value="4">Solucionado</option>
                                                            <option value="5">Finalizado</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="cliente">Ações para tratamento do alarme</label>
                                                        <textarea id="tratamentoAlarme" name="tratamentoAlarme" class="form-control" rows="7"></textarea>
                                                    </div>
                                                </div><!-- fim do campo nome do cliente -->
                                            </div>
                                            <div class="row">
                                                <div class="col-md-5">
                                                </div>
                                                <div class="col-md-4 ">
                                                    <div class="form-group">
                                                        <div class=" txt-center"><button id="validarResponsavel" type="button" name="validarResponsavel" class="btn btn-info" value="Salvar">Fechar janela</button</div>
                                                        <input id="idAlarme" name="idAlarme" type="hidden" value="">
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- <div class="modal-footer">

                    <button id="fecharTelaAlarme" type="button" class="btn btn-primary">Save changes</button>
                </div> -->
            </div>
        </div>
    </div>

<script type="text/javascript">
$(document).ready(function() {
    $('#collapseOne').collapse("hide");
    $('#filtroCollapse').collapse("hide");
  });
</script>
