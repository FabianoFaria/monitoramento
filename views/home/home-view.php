    <!-- HOME VIEW -->
    <?php
        if (! defined('EFIPATH')) exit;
    ?>

    <script type="text/javascript">
        // gerenciador de link
        var menu = document.getElementById('listadir');
        menu.innerHTML = '<a href="<?php echo HOME_URI; ?>/home/" class="linkMenuSup">Home</a>';
    </script>

    <!-- MENSAGEM DE BOAS VINDAS -->

    <div class="row">
        <div class="col-md-12 barraBemvindo">
            <!-- Titulo pagina -->
            <label class="page-header">
                <h2>Bem vindo, <?php echo $_SESSION['userdata']['firstname']." ".$_SESSION['userdata']['secondname']; ?></h2>
            </label>
        </div>
    </div>

    <!-- CONTAGEM DE ALERTAS -->
    <div class="row">
        <!-- ALERTAS GERADOS -->
        <div class="col-lg-3 col-md-6">
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
        </div>
        <!-- ALERTAS RECONHECIDOS -->
        <div class="col-lg-3 col-md-6">
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
        </div>
        <!-- ALERTAS RECONHECIDOS E SOLUCIONADOS -->
        <div class="col-lg-3 col-md-6">
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
        </div>
        <!-- ALERTAS FINALIZADOS -->
        <div class="col-lg-3 col-md-6">
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
                    <div class="col-lg-6">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Data</th>
                                        <th>Hora</th>
                                        <th>Mestre</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="4">Nenhum alarme gerado!</td>

                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.table-responsive -->
                    </div>
                </div>
            </div>
        </div>

    </div>
