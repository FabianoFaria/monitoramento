<!-- HOME VIEW -->
<?php
    if (! defined('EFIPATH')) exit;

    //var_dump($_SESSION);

    //$alarmesRegistrados = $modeloAlarme->alarmesGerados();

    /*
    * VERIFICA O TIPO DE USUÁRIO E EFETUA AS RESPECTIVAS OPERAÇÕES
    */
    switch ($_SESSION['userdata']['tipo_usu']) {
        case 'Administrador':
            //var_dump($_SESSION);

            $alarmesRegistrados = $modeloAlarme->alarmesGerados();
            $notificacaoAlertas = $modelo->recuperaNotificacoesAlarmes();

        break;

        case 'Cliente':

            $alarmesRegistrados = $modeloAlarme->alarmesGeradosCliente($_SESSION['userdata']['cliente']);
            $notificacaoAlertas = $modelo->recuperaNotificacoesAlarmesCliente($_SESSION['userdata']['userId']);

        break;

        case 'Visitante':

            $alarmesRegistrados = $modeloAlarme->alarmesGeradosCliente($_SESSION['userdata']['cliente']);
            $notificacaoAlertas = $modelo->recuperaNotificacoesAlarmesCliente($_SESSION['userdata']['userId']);

        break;

        case 'Tecnico':
            $alarmesRegistrados = $modeloAlarme->alarmesGerados();
            $notificacaoAlertas = $modelo->recuperaNotificacoesAlarmes();

        break;
    }

    $usuarioLogado = $_SESSION['userdata']['firstname']." ".$_SESSION['userdata']['secondname'];

?>

    <script type="text/javascript">
        // gerenciador de link
        var menu = document.getElementById('listadir');
        menu.innerHTML = '<a href="<?php echo HOME_URI; ?>/home/" class="linkMenuSup">Bem vindo : <?php echo $usuarioLogado; ?></a>';
    </script>

    <?php

        //LOCAL PARA GUARDAR A QUANTIDADE DE NOVOS ALARMES
        if($alarmesRegistrados['status']){

            // echo sizeof($alarmesRegistrados['alerta']);
            //var_dump($notificacaoAlertas);
            ?>
            <span id="novoAlertasCount" style="display:none;"><?php echo sizeof($alarmesRegistrados['alerta']); ?></span>
            <?php
        }else{
            ?>
            <span id="novoAlertasCount" style="display:none;">0</span>
            <?php
        }
    ?>

    <script type="application/javascript">

        /*
        * EFETUA A ATUALIZAÇÃO DA LISTA DE ALARMES A CADA PERIODO DE TEMPO
        */
        $(document).ready(function () {

            setInterval(function(){

                var totalAlarmesAtual = $('#novoAlertasCount').html();
                console.log('prossiga monitoramento! '+totalAlarmesAtual);

                var url = "<?php echo HOME_URI; ?>/alarme/verificaListaNovoAlarme?clie=<?php echo $_SESSION['userdata']['cliente']; ?>&total="+totalAlarmesAtual;
                $.getJSON(url,  function(data) {

                    if(data.statusLista){
                        //Insere um linha no topo da tabela
                        //$(data.alarmesNovaLista).insertBefore( "#listaAlarmesEquipamentos tbody" );
                        $('#novoAlertasCount').html(data.contagemLista);
                        swal('Atenção!','Foi registrado um novo alarme, favor verificar.','warning' );
                        setTimeout(function(){
                            location.reload();
                        }, 3500);
                    }else{
                        console.log('prossiga monitoramento!');
                    }

                });
            },5000);

        });

    </script>

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

    <!-- GRÁFICO DOS ÚLTIMOS ALERTAS -->

    <div class="row">
        <div class="col-md-8 barraBemvindo">
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingOne">
                      <h4 class="panel-title">
                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Status dos alertas  <i class="fa fa-caret-down fa-1x"></i>
                        </a>
                      </h4>
                    </div>
                    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <p><i class='fa fa-exclamation-triangle  fa-2x fa-blink' style='color:red'></i>Novo</p>
                                </div>
                                <div class="col-md-3">
                                    <p><i class='fa fa-exclamation-triangle  fa-2x' style='color:orange'></i>Visualizado</p>
                                </div>
                                <div class="col-md-3">
                                    <p><i class='fa fa-exclamation-triangle  fa-2x' style='color:yellow'></i>Em tratamento</p>
                                </div>
                                <div class="col-md-3">
                                    <p><i class='fa fa-exclamation-triangle  fa-2x' style='color:green'></i>Solucionado</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- /.panel -->
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-bar-chart-o fa-fw"></i> Registros de alarmes ativos
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="table-responsive">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="listaAlarmesEquipamentos">
                                <thead>
                                    <tr>
                                        <th>Status</th>
                                        <th>Data</th>
                                        <th>Local</th>
                                        <!-- <th>Módulo</th> -->
                                        <th>Equipamento</th>
                                        <th>Ponto</th>
                                        <th>Descrição</th>
                                        <th>Medida que gerou alarme</th>
                                        <th>Tratamento alarme</th>
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
                                                            //echo "<i class='fa fa-exclamation-triangle  fa-2x fa-blink' style='color:red'></i> <p> Novo</p>";
                                                            echo "<i class='fa fa-exclamation-triangle  fa-2x fa-blink' style='color:red'></i>";
                                                        break;
                                                        case '2':
                                                            //echo "<i class='fa fa-exclamation-triangle  fa-2x' style='color:orange'></i> <p> Visualizado</p>";
                                                            echo "<i class='fa fa-exclamation-triangle  fa-2x' style='color:orange'></i>";
                                                        break;
                                                        case '3':
                                                            //echo "<i class='fa fa-exclamation-triangle  fa-2x' style='color:yellow'></i> <p> Em tratamento</p>";
                                                            echo "<i class='fa fa-exclamation-triangle  fa-2x' style='color:yellow'></i>";
                                                        break;
                                                        case '4':
                                                            //echo "<i class='fa fa-exclamation-triangle  fa-2x' style='color:green'></i> <p> Solucionado</p>";
                                                            echo "<i class='fa fa-exclamation-triangle  fa-2x' style='color:green'></i>";
                                                        break;

                                                        default:
                                                            //echo "<i class='fa  fa-check  fa-2x' style='color:green'></i> <p> Finalizado</p>";
                                                            echo "<i class='fa  fa-check  fa-2x' style='color:green'></i>";
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
                                                    $localEspecifico = (isset($listaAlarmes['filial'])) ? $listaAlarmes['filial']: "Matriz";

                                                    echo $listaAlarmes['nome']." - ".$localEspecifico;
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                    echo $listaAlarmes['nomeModeloEquipamento'];
                                                ?>
                                            </td>
                                            <td>
                                                <?php

                                                    //IF ELSE PARA TRATAR DO PONTO DA TABELA QUE GEROU O ALARME
                                                    $ponto = $this->verificarPontoTabela($listaAlarmes['pontoTabela']);

                                                    echo $ponto;

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
                                                <p>
                                                    <?php

                                                        //echo $listaAlarmes['parametro'];

                                                        switch ($listaAlarmes['parametro']){
                                                            case 'Bateria':
                                                                ?>
                                                                <span class="text-danger">
                                                                    <?php
                                                                        echo  $listaAlarmes['parametroMedido']." (V)";
                                                                    ?>
                                                                </span> onde o limite era
                                                                <span class="text-info">
                                                                    <?php
                                                                        echo $listaAlarmes['parametroAtingido']." (V)";
                                                                    ?>
                                                                </span>
                                                                <?php
                                                            break;
                                                            case 'Temperatura ambiente':
                                                                ?>
                                                                <span class="text-danger">
                                                                    <?php
                                                                        echo  $listaAlarmes['parametroMedido']." (°C)";
                                                                    ?>
                                                                </span> onde o limite era
                                                                <span class="text-info">
                                                                    <?php
                                                                        echo $listaAlarmes['parametroAtingido']." (°C)";
                                                                    ?>
                                                                </span>
                                                                <?php
                                                            break;
                                                            case 'Temperatura Banco de bateria':
                                                                ?>
                                                                <span class="text-danger">
                                                                    <?php
                                                                        echo  $listaAlarmes['parametroMedido']." (°C)";
                                                                    ?>
                                                                </span> onde o limite era
                                                                <span class="text-info">
                                                                    <?php
                                                                        echo $listaAlarmes['parametroAtingido']." (°C)";
                                                                    ?>
                                                                </span>
                                                                <?php
                                                            break;
                                                            case 'Equipamento mestre'
                                                                ?>
                                                                    Dados não estão sendo recebidos.
                                                                <?php
                                                            break;
                                                            case 'Corrente'
                                                                ?>
                                                                <span class="text-danger">
                                                                    <?php
                                                                        echo  $listaAlarmes['parametroMedido']." (A)";
                                                                    ?>
                                                                </span> onde o limite era
                                                                <span class="text-info">
                                                                    <?php
                                                                        echo $listaAlarmes['parametroAtingido']." (A)";
                                                                    ?>
                                                                </span>
                                                                <?php
                                                            break;
                                                            /*
                                                            TRATA CASOS DE TENSÃO
                                                            */
                                                            default:
                                                                ?>
                                                                <span class="text-danger">
                                                                    <?php
                                                                        echo  $listaAlarmes['parametroMedido']." (V)";
                                                                    ?>
                                                                </span> onde o limite era
                                                                <span class="text-info">
                                                                    <?php
                                                                        echo $listaAlarmes['parametroAtingido']." (V)";
                                                                    ?>
                                                                </span>
                                                                <?php
                                                            break;
                                                        }

                                                    ?>

                                                </p>
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
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="row">

                                <!-- DATA DO ALARME -->
                                <div class="col-md-6">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <b>Status e data do alarme</b>
                                        </div>
                                        <div class="panel-body">
                                            <p>
                                                <b>Data de geração : </b> <span id="dataGeracao"></span>
                                            </p>
                                            <p>
                                                <b>Data de Visualização : </b><span id="dataVizualizacao"></span>
                                            </p>
                                            <div class="panel-heading" id="statusAlarme">
                                                <!-- <i class="fa fa-warning "></i> <span id="statusAlarme"></span> -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- DADOS DOS LOCAL DO EQUIPAMENTO -->
                                <div class="col-md-6">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <b>Detalhes do local</b>
                                        </div>
                                        <div class="panel-body">
                                            <p>
                                                <b>Vínculo equipamento : </b><span id="nomeCliente"></span>
                                            </p>
                                            <p>
                                                <b>Sede onde ocorreu o alarme : </b><span id="localAlarme"></span>
                                            </p>
                                            <p>
                                                <b>Área ou setor </b> : <span id="localizacaoAlarme"></span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <!-- TIPO DO EQUIPAMENTO -->
                                <div class="col-md-6">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <b>Detalhes do equipamento</b>
                                        </div>
                                        <div class="panel-body">
                                            <p>
                                                <b>Tipo de equipamento : </b><span id="equipTipo"></span>
                                            </p>
                                            <p>
                                                <b>Equipamento : </b><span id="equipNome"></span>
                                            </p>
                                            <p>
                                                <b>Ponto : </b><span id="pontoTab"></span>
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <!-- DADOS DO ALARME -->
                                <div class="col-md-6">

                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <b>Detalhes do alarme</b>
                                        </div>
                                        <div class="panel-body">
                                            <p>
                                                <b>Origem do alarme : </b><span id="tipoMedida"></span>
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
                            </div>

                            <!-- TRATAMENTOS JÁ APLICADOS -->
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="well">
                                        <div class="panel panel-default">
                                           <div class="panel-heading">
                                               <b>Tratamentos já aplicados</b>
                                           </div>
                                           <div class="panel-body">
                                                <div class="table-responsive">
                                                    <table id="tratamentosAplicados" class="table table-striped table-bordered table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th>Usuário</th>
                                                                <th>Ação efetivada</th>
                                                                <th>Data</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        </tbody>
                                                    </table>
                                                </div>
                                           </div>
                                       </div>
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
                                                            <!-- <option value="5">Finalizado</option> -->
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
    //$('#collapseOne').collapse("hide");
    $('#filtroCollapse').collapse("hide");
  });
</script>
