<?php
    /* verifica se esta definido o path */
    if (! defined('EFIPATH')) exit();

    $dadosCliente   = $modeloClie->carregarDadosCliente($this->parametros[0]);

    if($dadosCliente['status']){
        $dadosCliente   = $dadosCliente['dados'][0];
        $lista          = $modeloEquip->listarEquipamentosCliente($this->parametros[0]);
        $lista          = $lista['equipamentos'];
        $nomeCliente    = $dadosCliente['nome'];
    }else{
        $lista          = false;
    }

    /*
    * EFETUA O TRATAMENTO DOS PARAMETROS DE DATA_INICIO_REL
    */
    $dataInicio     = implode("-", array_reverse(explode(",",($this->parametros[1]))));
    $dataFim        = implode("-", array_reverse(explode(",",($this->parametros[2]))));

    //RECUPERA O TOTAL DE ALARMES REGISTRADOS DURANTE O PERIOODO
    $totalAlertas       = 0;
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
    <div class="col-md-12">
        <!-- Titulo pagina -->
        <label class="page-header">Relatôrios para equipamentos do cliente</label><!-- Fim Titulo pagina -->
    </div>
</div>

<div class="row">
    <div class="col-md-12">

        <!-- TABELA CONTENDO OS USUÁRIOS CADASTRADOS -->
        <div class="panel panel-default">
            <div class="panel-heading">
                Cliente : <?php echo $nomeCliente; ?>
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

                    foreach ($equipamentos as $equipamento){

                        if(isset($equipamento['nomeEquipamento'])){
                            ?>

                            <div class="panel panel-info">
                                <div class="panel-heading">
                                    <?php echo $equipamento['tipo_equipamento']." ".$equipamento['nomeEquipamento']." ".$equipamento['modelo']; ?>
                                </div>
                                <div class="panel-body">
                                    <div class="row">

                                        <?php

                                            $alarmesGeral  = $modeloAlarme->totalAlarmesGeradoEquipamento($equipamento['id_equipamento'], $dataInicio, $dataFim);

                                            var_dump($alarmesGeral);

                                        ?>

                                        <div class="col-md-3">

                                        </div>
                                        <div class="col-md-3">

                                        </div>
                                        <div class="col-md-3">

                                        </div>
                                        <div class="col-md-3">

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <?php
                        }

                    }

                ?>

            </div>
        </div>

    </div>
</div>
