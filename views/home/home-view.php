                <?php
                    if (! defined('EFIPATH')) exit;
                ?>

                <script type="text/javascript">
                    // gerenciador de link
                    var menu = document.getElementById('listadir');
                    menu.innerHTML = '<a href="<?php echo HOME_URI; ?>/home/" class="linkMenuSup">Home</a>';
                </script>


                <div class="container-fluid nome-apresentacao">
                    <!-- Titulo pagina -->
                    <label class="titulo-pagina">
                        <?php
                            echo "Bem vindo, " . $_SESSION['userdata']['firstname'] ." ". $_SESSION['userdata']['secondname'];
                        ?>
                    </label><!-- Fim Titulo pagina -->


                    <div class="row">
                        <div class="col-md-12">

                            <h2 class="page-header">Painel inicial</h2>

                            <!-- /.row -->
                            <div class="row">

                                <!-- Alarmes reconhecidos-->
                                <div class="col-lg-3 col-md-6">
                                    <div class="panel panel-red">
                                        <div class="panel-heading">
                                            <div class="row">
                                                <div class="col-xs-3">
                                                    <i class="fa fa-volume-up  fa-5x"></i>
                                                </div>
                                                <div class="col-xs-9 text-right">
                                                    <div class="huge">13</div>
                                                    <div>Alarmes <br> gerados!</div>
                                                </div>
                                            </div>
                                        </div>
                                        <a href="#">
                                            <div class="panel-footer">
                                                <span class="pull-left">Ver detalhes</span>
                                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                                <div class="clearfix"></div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <!-- Alarmes reconhecidos e solucionados -->
                                <div class="col-lg-3 col-md-6">
                                    <div class="panel panel-yellow">
                                        <div class="panel-heading">
                                            <div class="row">
                                                <div class="col-xs-3">
                                                    <i class="fa fa-wrench  fa-5x"></i>
                                                </div>
                                                <div class="col-xs-9 text-right">
                                                    <div class="huge">124</div>
                                                    <div>Reconhecidos e solucionados!</div>
                                                </div>
                                            </div>
                                        </div>
                                        <a href="#">
                                            <div class="panel-footer">
                                                <span class="pull-left">Ver detalhes</span>
                                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                                <div class="clearfix"></div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <!-- Alarmes não reconhecidos e solucionados -->
                                <div class="col-lg-3 col-md-6">
                                    <div class="panel panel-green">
                                        <div class="panel-heading">
                                            <div class="row">
                                                <div class="col-xs-3">
                                                    <i class="fa fa-question fa-5x"></i>
                                                </div>
                                                <div class="col-xs-9 text-right">
                                                    <div class="huge">12</div>
                                                    <div>Não reconhecidos e solucionados!</div>
                                                </div>
                                            </div>
                                        </div>
                                        <a href="#">
                                            <div class="panel-footer">
                                                <span class="pull-left">Ver detalhes</span>
                                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                                <div class="clearfix"></div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <!-- Alarmes Alarmes finalizados -->
                                <div class="col-lg-3 col-md-6">
                                    <div class="panel panel-primary">
                                        <div class="panel-heading">
                                            <div class="row">
                                                <div class="col-xs-3">
                                                    <i class="fa fa-medkit fa-5x"></i>
                                                </div>
                                                <div class="col-xs-9 text-right">
                                                    <div class="huge">26</div>
                                                    <div>Alarmes solucionados!</div>
                                                </div>
                                            </div>
                                        </div>
                                        <a href="#">
                                            <div class="panel-footer">
                                                <span class="pull-left">Ver detalhes!</span>
                                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                                <div class="clearfix"></div>
                                            </div>
                                        </a>
                                    </div>
                                </div>

                            </div>
                            <!-- /.row -->



                        </div>
                    </div>

                    <!-- /.row -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel-heading">
                                Alarmes gerados recentemente
                            </div>
                            <!-- /.panel-heading -->
                           <div class="panel-body">
                               <div class="table-responsive">
                                   <table class="table table-striped table-bordered table-hover dataTable">
                                       <thead>
                                           <tr>
                                               <th>#</th>
                                               <th>Status</th>
                                               <th>Data de geração</th>
                                               <th>Mestre</th>
                                               <th>Módulo</th>
                                               <th>Ponto</th>
                                               <th>Limite que gerou o alarme/descrição</th>
                                               <th>Medida que gerou o alarme</th>
                                               <th>Observações</th>
                                           </tr>
                                       </thead>
                                       <tbody>
                                           <tr>
                                               <td colspan="9">Nenhum dado gerado no momento!</td>

                                           </tr>

                                       </tbody>
                                   </table>
                               </div>
                               <!-- /.table-responsive -->
                           </div>
                           <!-- /.panel-body -->
                        </div>
                    </div>

                </div>
