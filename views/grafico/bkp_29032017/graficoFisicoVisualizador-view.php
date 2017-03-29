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
    if($totalParans == 3){

        /*
        * EFETUA O TRATAMENTO DOS PARAMETROS DE DATA_INICIO_REL
        */
        $dataInicio     = implode("-", array_reverse(explode(",",($this->parametros[1]))));
        $dataFim        = implode("-", array_reverse(explode(",",($this->parametros[2]))));

        //EQUIPAMENTOS EM GERAL
        if($dadosCliente['status']){
            $dadosCliente   = $dadosCliente['dados'][0];
            $lista          = $modeloEquip->listarEquipamentosCliente($this->parametros[0]);
            $lista          = $lista['equipamentos'];
            $nomeCliente    = $dadosCliente['nome'];
        }else{
            $lista          = false;
        }

        //RECUPERA O TOTAL DE ALARMES REGISTRADOS DURANTE O PERIOODO, PARA TODOS OS EQUIPAMENTOS
        $totalEquipamentos  = $modeloAlarme->totalEquipamentosClientes($this->parametros[0]);
        if($totalEquipamentos['status']){

            $equipamentos = $totalEquipamentos['equipamentos'];

            //var_dump(count($equipamentos));
            foreach ($equipamentos as $equipamento){

                $alarmesGeral  = $modeloAlarme->totalAlarmesGeradoEquipamento($equipamento['id_equipamento'], $dataInicio, $dataFim);

                if($alarmesGeral['status']){
                    //EFETUA A SOMA DE ALERTAS GERADOS
                    $totalAlertas = $totalAlertas + $alarmesGeral['alarmes'][0]['total'];


                }
                //EXIBE MEDIDADS MINIMAS E MAXIMAS REGISTRADAS PELO(S) EQUIPAMENTO(S).
                //#SQN
            }

        }

    }elseif($totalParans == 4){
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

<script src="<?php echo HOME_URI; ?>/views/_js/table/mustache.js" type="text/javascript"></script>
<script src="<?php echo HOME_URI; ?>/views/_js/table/stream_table.js" type="text/javascript"></script>

<script type="text/javascript">
    // gerenciador de link
    var menu = document.getElementById('listadir');
    menu.innerHTML = '<a href="<?php echo HOME_URI; ?>/home/" class="linkMenuSup">Home</a> / '+
                      '<a href="<?php echo HOME_URI; ?>/grafico/graficoFisicoGerador" class="linkMenuSup">Relatôrio fisico</a> / '+
                      '<a href="<?php echo HOME_URI; ?>/grafico/graficoFisicoEquipamentoCliente/<?php echo $this->parametros[0]; ?>"> Cliente :<?php echo $nomeCliente; ?></a> /'+
                      '<a href="<?php echo HOME_URI; ?>/grafico/gerarRelatorioCliente/<?php echo $this->parametros[0]; ?>/<?php echo $this->parametros[1]; ?>/<?php echo $this->parametros[2]; ?>"> Gerando relatôrio </a>';
</script>

<div class="row">
    <div class="col-md-9">
        <!-- Titulo pagina -->
        <label class="page-header">Relatôrios para equipamentos do cliente</label><!-- Fim Titulo pagina -->
    </div>
    <div class="col-md-3">

        <?php
            if($totalParans < 4){
            ?>
                <a class="btn btn-primary pull-right" href="<?php echo HOME_URI; ?>/grafico/exibirImpressaoRelatorio/<?php echo $this->parametros[0]; ?>/<?php echo $this->parametros[1]; ?>/<?php echo $this->parametros[2]; ?>" target="_blank"><i class="fa fa-print"></i> Imprimir relatôrio</a>
            <?php
            }else{
            ?>
                <a class="btn btn-primary pull-right" href="<?php echo HOME_URI; ?>/grafico/exibirImpressaoRelatorioEquipamento/<?php echo $this->parametros[0]; ?>/<?php echo $this->parametros[1]; ?>/<?php echo $this->parametros[2]; ?>/<?php echo $this->parametros[3]; ?>" target="_blank"><i class="fa fa-print"></i> Imprimir relatôrio</a>
            <?php
            }
        ?>
    </div>
</div>

<div class="row">
    <div class="col-md-12">

        <!-- TABELA CONTENDO OS USUÁRIOS CADASTRADOS -->
        <div class="panel panel-success">
            <div class="panel-heading">
                Cliente : <?php echo $nomeCliente; ?>
                <div class="col-md-4 pull-right">
                    Periodo : <?php echo  implode("/", array_reverse(explode("-",($dataInicio))))." até ".implode("/", array_reverse(explode("-",($dataFim)))); ?>
                </div>
            </diV>
            <div class="panel-body">

                <!-- Alertas totais -->
                <div class="panel panel-info">
                    <div class="panel-heading">
                        Totais de alarmes
                    </div>
                    <div class="panel-body">
                        <?php echo $totalAlertas; ?>
                    </div>
                </div>

                <!-- ESTATISTICAS DOS EQUIPAMENTOS -->

                <?php

                    if(isset($equipamentos)){

                        foreach ($equipamentos as $equipamento){

                            if(isset($equipamento['tipo_equipamento'])){

                                ?>

                                <div class="panel panel-info">
                                    <div class="panel-heading">
                                        <?php echo $equipamento['tipo_equipamento']." ".$equipamento['nomeModeloEquipamento']; ?>
                                    </div>
                                    <div class="panel-body">
                                        <div class="row">

                                            <?php

                                                //TOTAL DE ALARMES DO EQUIPAMENTO
                                                $totalAlarmes  = 0;
                                                $alarmesGeral  = $modeloAlarme->totalAlarmesGeradoEquipamento($equipamento['id_equipamento'], $dataInicio, $dataFim);

                                                //var_dump($alarmesGeral);

                                                if($alarmesGeral['status']){

                                                    $totalAlarmes = $alarmesGeral['alarmes'][0]['total'];
                                                }

                                                $alarmEquip    = $modeloAlarme->recuperaAlarmesEquipamento($equipamento['id_equipamento'], $dataInicio, $dataFim);

                                                //var_dump($alarmEquip);

                                            ?>

                                            <div class="col-md-12">

                                                <p class="text-header">Alarmes gerados pelo equipamento : <?php echo $totalAlarmes; ?></p>

                                                <table id="stream_table" class='table table-striped table-bordered'>
                                                    <thead>
                                                        <tr>
                                                            <th>Data Origem</th>
                                                            <th>Status</th>
                                                            <th>Mensagem</th>
                                                            <th>Parametro</th>
                                                            <th>Medida</th>
                                                            <th>Tratamento</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            if($alarmEquip['status']){
                                                                foreach ($alarmEquip['equipAlarm'] as $alarm) {

                                                                    //var_dump($alarm);
                                                                ?>
                                                                    <tr>
                                                                        <td>
                                                                            <?php

                                                                                $dataAlarme = explode(" ", $alarm['dt_criacao']);

                                                                                echo implode("/",array_reverse(explode("-", $dataAlarme[0])))." ".$dataAlarme[1];
                                                                            ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php
                                                                                switch ($alarm['status_ativo']){
                                                                                    case '1':
                                                                                        echo "<p> Novo</p>";
                                                                                    break;
                                                                                    case '2':
                                                                                        echo "<p> Visualizado</p>";
                                                                                    break;
                                                                                    case '3':
                                                                                        echo "<p> Em tratamento</p>";
                                                                                    break;
                                                                                    case '4':
                                                                                        echo "<p> Solucionado</p>";
                                                                                    break;

                                                                                    default:
                                                                                        echo "<p> Finalizado</p>";
                                                                                    break;
                                                                                }
                                                                            ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php echo $alarm['mensagem'] ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php echo $alarm['parametro'] ?>
                                                                        </td>
                                                                        <td>
                                                                            <span class="text-danger"><?php echo $alarm['parametroMedido'] ?></span> / <span class="text-primary"><?php echo $alarm['parametroAtingido'] ?></span>
                                                                        </td>
                                                                        <td>
                                                                            <?php echo (isset($alarm['tratamento_aplicado'])) ? $alarm['tratamento_aplicado'] : ""; ?>
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

                                <?php
                            }

                        }

                    }
                    else{

                        ?>
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
                                                <thead>
                                                    <tr>
                                                        <th>Data Origem</th>
                                                        <th>Status</th>
                                                        <th>Mensagem</th>
                                                        <th>Parametro</th>
                                                        <th>Medida</th>
                                                        <th>Tratamento</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        if($alarmEquip['status']){
                                                            foreach ($alarmEquip['equipAlarm'] as $alarm) {

                                                                //var_dump($alarm);
                                                            ?>
                                                                <tr>
                                                                    <td>
                                                                        <?php

                                                                            $dataAlarme = explode(" ", $alarm['dt_criacao']);

                                                                            echo implode("/",array_reverse(explode("-", $dataAlarme[0])))." ".$dataAlarme[1];
                                                                        ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php
                                                                            switch ($alarm['status_ativo']){
                                                                                case '1':
                                                                                    echo "<p> Novo</p>";
                                                                                break;
                                                                                case '2':
                                                                                    echo "<p> Visualizado</p>";
                                                                                break;
                                                                                case '3':
                                                                                    echo "<p> Em tratamento</p>";
                                                                                break;
                                                                                case '4':
                                                                                    echo "<p> Solucionado</p>";
                                                                                break;

                                                                                default:
                                                                                    echo "<p> Finalizado</p>";
                                                                                break;
                                                                            }
                                                                        ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php echo $alarm['mensagem'] ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php echo $alarm['parametro'] ?>
                                                                    </td>
                                                                    <td>
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
                                                                    </td>
                                                                    <td>
                                                                        <?php echo (isset($alarm['tratamento_aplicado'])) ? $alarm['tratamento_aplicado'] : ""; ?>
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

                        <?php
                    }

                ?>

            </div>
        </div>

    </div>
</div>
