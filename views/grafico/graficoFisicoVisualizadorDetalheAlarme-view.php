<?php

    /* verifica se esta definido o path */
    if (! defined('EFIPATH')) exit();

    $dadosCliente   = $modeloClie->carregarDadosCliente($this->parametros[0]);

    /*
    * INICIA CONTADOR DE ALERTAS
    */
    $totalAlertas       = 0;

    /*
    * VERIFICA A QUANTIDADE DE PARAMETROS PASSADOS PARA A EXIBIÇÃO CORRETA DOS RELATÔRIOS
    */
    $totalParans = count($this->parametros);
    if($totalParans == 4){
        /*
        * EFETUA O TRATAMENTO DOS PARAMETROS DE DATA_INICIO_REL
        */
        $dataInicio     = implode("-", array_reverse(explode(",",($this->parametros[2]))));
        $dataFim        = implode("-", array_reverse(explode(",",($this->parametros[3]))));

        //EQUIPAMENTO ESPECIFICADO
        if($dadosCliente['status']){
            $dadosCliente   = $dadosCliente['dados'][0];
            $lista          = $modeloEquip->dadosEquipamentoCliente($this->parametros[1]);
            $lista          = $lista['equipamento'];
            $nomeCliente    = $dadosCliente['nome'];
        }else{
            $lista          = false;
        }

        //RECUPERA O TOTAL DE ALARMES REGISTRADOS DURANTE O PERIOODO, PARA O EQUIPAMENTO SELECIONADO
        $alarmesGeral  = $modeloAlarme->totalAlarmesGeradoEquipamento($lista[0]['id'], $dataInicio, $dataFim);

        if($alarmesGeral['status']){
            //EFETUA A SOMA DE ALERTAS GERADOS
            $totalAlertas = $totalAlertas + $alarmesGeral['alarmes'][0]['total'];
        }

    }

?>

<script type="text/javascript">
    // gerenciador de link
    var menu = document.getElementById('listadir');
    menu.innerHTML = '<a href="<?php echo HOME_URI; ?>/home/" class="linkMenuSup">Home</a> / '+
                      '<a href="<?php echo HOME_URI; ?>/grafico/graficoTratamentoAlarme" class="linkMenuSup">Relatôrio alarmes detalhados</a> / '+
                      '<a href="#"> Unidade : <?php echo (isset($lista[0]['filial'])) ? $lista[0]['filial'] :"Matriz"; ?></a> /'+
                      '<a href="<?php echo HOME_URI; ?>/grafico/gerarRelatorioAlarmeDetalheEquipamentoCliente/<?php echo $this->parametros[0]; ?>/<?php echo $this->parametros[1]; ?>/<?php echo $this->parametros[2]; ?>/<?php echo $this->parametros[3]; ?>"> Gerando relatôrio detalhado alarme </a>';
</script>

<div class="row">
    <div class="col-md-9">
        <!-- Titulo pagina -->
        <label class="page-header">Relatôrios para alarmes detalhados do equipamento</label><!-- Fim Titulo pagina -->
    </div>
    <div class="col-md-3">
        <a class="btn btn-primary pull-right" href="<?php echo HOME_URI; ?>/grafico/exibirImpressaoRelatorioAlarmeDetalhado/<?php echo $this->parametros[0]; ?>/<?php echo $this->parametros[1]; ?>/<?php echo $this->parametros[2]; ?>/<?php echo $this->parametros[3]; ?>" target="_blank"><i class="fa fa-print"></i> Imprimir relatôrio</a>
    </div>
</div>
<div class="row">
    <div class="col-md-12">

        <!-- TABELA CONTENDO OS USUÁRIOS CADASTRADOS -->
        <div class="panel panel-success">

            <div class="panel-heading">
                <!-- Cliente : <?php //echo $nomeCliente; ?> -->
                Unidade : <?php echo (isset($lista[0]['filial'])) ? $lista[0]['filial'] :"Matriz"; ?>
                <div class="col-md-4 pull-right">
                    Periodo : <?php echo  implode("/", array_reverse(explode("-",($dataInicio))))." até ".implode("/", array_reverse(explode("-",($dataFim)))); ?>
                </div>
            </diV>
            <div class="panel-body">

                <!-- Alertas totais -->
                <!-- <div class="panel panel-info">
                    <div class="panel-heading">
                        Totais de alarmes
                    </div>
                    <div class="panel-body">
                        <?php //echo $totalAlertas; ?>
                    </div>
                </div> -->

                <!-- DETALHES DOS ALERTAS -->
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <?php echo $lista[0]['tipoEquip']." ".$lista[0]['nomeModeloEquipamento']; ?>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <?php

                                //TOTAL DE ALARMES DO EQUIPAMENTO
                                $totalAlarmes  = 0;
                                $alarmesGeral  = $modeloAlarme->totalAlarmesGeradoEquipamento($lista[0]['id'], $dataInicio, $dataFim);

                                //var_dump($alarmesGeral);

                                if($alarmesGeral['status']){

                                    $totalAlarmes = $alarmesGeral['alarmes'][0]['total'];
                                }

                                $alarmEquip    = $modeloAlarme->recuperaAlarmesEquipamento($lista[0]['id'], $dataInicio, $dataFim);

                                //var_dump($alarmEquip);

                            ?>
                            <div class="col-md-12">
                                <p class="text-header">Alarmes gerados pelo equipamento : <?php echo $totalAlarmes; ?></p>

                                    <table id="stream_table" class='table table-striped table-bordered'>
                                        <tbody>

                                            <?php

                                                if($alarmEquip['status']){

                                                    foreach ($alarmEquip['equipAlarm'] as $alarm) {

                                                        ?>
                                                        <tr>
                                                            <td>
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <?php

                                                                            $dataAlarme = explode(" ", $alarm['dt_criacao']);

                                                                        ?>
                                                                        <p><b>Data :</b> <?php echo implode("/",array_reverse(explode("-", $dataAlarme[0]))); ?></p>
                                                                        <p><b>Horário :</b> <?php echo $dataAlarme[1]; ?></p>
                                                                        <p><b>Alerta :</b> <?php echo $alarm['mensagem']; ?></p>
                                                                        <p><b>Status :</b>
                                                                            <?php
                                                                                switch ($alarm['status_ativo']){
                                                                                    case '1':
                                                                                        echo " Novo";
                                                                                    break;
                                                                                    case '2':
                                                                                        echo " Visualizado";
                                                                                    break;
                                                                                    case '3':
                                                                                        echo " Em tratamento";
                                                                                    break;
                                                                                    case '4':
                                                                                        echo " Solucionado";
                                                                                    break;

                                                                                    default:
                                                                                        echo " Finalizado";
                                                                                    break;
                                                                                }
                                                                            ?>
                                                                        </p>
                                                                    </div>
                                                                    <div class="col-md-2">

                                                                    </div>
                                                                    <div class="col-md-4">

                                                                        <p><b>Parametro :</b> <?php echo $alarm['parametro'] ?></p>
                                                                        <p><b>Ponto :</b> <?php echo $this->verificarPontoTabela($alarm['pontoTabela']); ?></p>
                                                                        <p><b>Medida :</b>
                                                                            <?php

                                                                                switch ($alarm['parametroMedido']){
                                                                                    case 'Bateria':
                                                                                        # code...
                                                                                    break;
                                                                                    case 'Temperatura':
                                                                                        # code...
                                                                                    break;
                                                                                    /*
                                                                                    TRATA CASOS DE CORRENTE E TENSÃO
                                                                                    */
                                                                                    default:
                                                                                        ?>
                                                                                        <span class="text-danger">
                                                                                            <?php
                                                                                                echo  $alarm['parametroMedido']." (V)";
                                                                                            ?>
                                                                                        </span> /
                                                                                        <span class="text-primary">
                                                                                            <?php
                                                                                                echo $alarm['parametroAtingido']." (V)";
                                                                                            ?>
                                                                                        </span>
                                                                                        <?php
                                                                                    break;
                                                                                }

                                                                            ?>
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <table id="stream_table" class='table  table-bordered'>
                                                                            <thead>
                                                                                <tr>
                                                                                    <th>Data tratamento</th>
                                                                                    <th>Tratamento</th>
                                                                                    <th>Usuário</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <?php

                                                                                    //CARREGA OS TRATAMENTOS REGISTRADOS PARA O ALARME
                                                                                    $tratamentosAlarme = $modeloAlarme->carregaTratamentosAlarme($alarm['alertId']);

                                                                                    if($tratamentosAlarme['status']){
                                                                                        //var_dump($tratamentosAlarme['alarmTrat']);

                                                                                        foreach ($tratamentosAlarme['alarmTrat'] as $tratamento) {

                                                                                            /*
                                                                                            array (size=6)
                                                                                             'tratamento_aplicado' => string 'Teste de tratamento.' (length=20)
                                                                                             'data_tratamento' => string '2017-03-02 16:10:02' (length=19)
                                                                                             'tratamentoId' => string '1' (length=1)
                                                                                             'userId' => string '5' (length=1)
                                                                                             'nome' => string 'Sistema2' (length=8)
                                                                                             'sobrenome' => string 'Eficaz' (length=6)
                                                                                            */

                                                                                            ?>
                                                                                                <tr>
                                                                                                    <td>
                                                                                                        <?php
                                                                                                            $dataAlarmeTrat = explode(" ", $tratamento['data_tratamento']);

                                                                                                            echo implode("/",array_reverse(explode("-", $dataAlarmeTrat[0])))." <br />".$dataAlarmeTrat[1];
                                                                                                        ?>

                                                                                                    </td>
                                                                                                    <td>
                                                                                                        <?php
                                                                                                            echo $tratamento['tratamento_aplicado'];
                                                                                                        ?>
                                                                                                    </td>
                                                                                                    <td>
                                                                                                        <?php
                                                                                                            echo $tratamento['nome']." ".$tratamento['sobrenome'];
                                                                                                        ?>
                                                                                                    </td>
                                                                                                </tr>

                                                                                            <?php

                                                                                        }

                                                                                    }

                                                                                    //CASO O ALARME TENHA SIDO FINALIZADO

                                                                                    if(isset($alarm['tratamento_aplicado'])){
                                                                                        ?>
                                                                                            <tr>
                                                                                                <td>
                                                                                                    <?php
                                                                                                        if(isset($alarm['dt_fechamento'])){
                                                                                                            $dataAlarmeTrat = explode(" ", $alarm['dt_fechamento']);

                                                                                                            echo implode("/",array_reverse(explode("-", $dataAlarmeTrat[0])))." <br />".$dataAlarmeTrat[1];
                                                                                                        }

                                                                                                    ?>

                                                                                                </td>
                                                                                                <td>
                                                                                                    <?php
                                                                                                        echo $alarm['tratamento_aplicado'];
                                                                                                    ?>
                                                                                                </td>
                                                                                                <td>
                                                                                                    <?php
                                                                                                        echo $alarm['usr_nome']." ".$alarm['sobrenome'];
                                                                                                    ?>
                                                                                                </td>
                                                                                            </tr>
                                                                                        <?php
                                                                                    }
                                                                                ?>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                    }

                                                }

                                            ?>
                                        </tbody>
                                    </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
