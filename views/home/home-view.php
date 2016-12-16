    <!-- HOME VIEW -->
    <?php
        if (! defined('EFIPATH')) exit;

        //var_dump($_SESSION);
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
            <div class="panel panel-info">
                <div class="panel-heading">
                    <i class="fa fa-clock-o  fa-fw"></i> Última atualização
                </div>
                <div class="panel-body">
                    <p>
                        <?php // Exibe alguma coisa como: Monday 8th of August 2005 03:12:46 PM
                            echo date('d/ m/ Y, g:i a');
                        ?>
                    </p>
                </div>
            </div>
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
    <div class="row">
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
    </div>

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
                                        <th>Mestre</th>
                                        <th>Módulo</th>
                                        <th>Ponto</th>
                                        <th>Descrição</th>
                                        <th>Medida gerada</th>
                                        <th>Adicionar observações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="8">Nenhum alarme gerado até o momento!</td>
                                    </tr>
                                </tbod>
                            </table>
                        </div>
                        <!-- /.table-responsive -->
                    </div>
                </div>
            </div>
        </div>

    </div>

<script type="text/javascript">
$(document).ready(function() {
    $('#collapseOne').collapse("hide");
    $('#filtroCollapse').collapse("hide");
  });
</script>
