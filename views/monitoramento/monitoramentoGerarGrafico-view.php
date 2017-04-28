<?php

// Verifica se esta definido o path
if (! defined('EFIPATH')) exit();

if(is_numeric($this->parametros[0])){

    // Aqui está sendo simplificado o processo de coleta de dados do equipamento para geração de gráficos
    $dadosEquipamento   = $modeloEquip->dadosEquipamentoCliente($this->parametros[0]);
    $dadosEquipamento   = $dadosEquipamento['equipamento'][0];
    // Aqui está sendo carregado os dados de Sim, id_sim_equipamento necessarios para está página
    $dadosVinculoEquip  = $modeloEquip->detalhesEquipamentoParaConfiguracao($this->parametros[0]);
    //Aqui são os dados do cliente para exibição na tela
    $dadosClie          = $modeloEquip->dadosEquipamentoCliente($this->parametros[0]);

    if($dadosClie['status']){
        $dadosClie = $dadosClie['equipamento'][0];
        $idClie    = $dadosClie['idClie'];
        $nomeClie  = $dadosClie['cliente'];
    }

    if($dadosVinculoEquip['status']){
        $idEquip    = $dadosVinculoEquip['equipamento'][0]['id_equipamento'];
        $idSimEquip = $dadosVinculoEquip['equipamento'][0]['id'];
        $idSim      = $dadosVinculoEquip['equipamento'][0]['id_sim'];
    }else{
        $idEquip    = null;
        $idSimEquip = null;
        $idSim      = null;
    }

    $equipamentoMonitorado = $dadosEquipamento['tipoEquip']." ".$dadosEquipamento['nomeModeloEquipamento'];

    //INICIA CLASS DA LISTA INICAL
    $parametroListaIni  = array();
    array_push($parametroListaIni, $idSim);
    $limite             = 30;
    $listaIni           = new ListaInicial($limite, $this->db, $parametroListaIni);

    // CARREGA OS PARAMETROS CONFIGURADOS PARA O EQUIPAMENTO
    $retorno = $modelo->loadGraficoParam($idEquip, $idSimEquip, $idSim);

    //var_dump($dadosEquipamento);

}else{
    $retorno = null;
}


if (empty($retorno) && isset($retorno))
{
    // Caso nao exista valor
    // Apresenta mensagem e link informando que nao ha resultado
    echo "<div class='mensagem-semvalor'>
            <label class='mensagem-texto'>Verifique se os parametros est&atilde;o configurados.<br>
                <a href='".HOME_URI."/configuracao/configurarEquipamentoCliente/".$this->parametros[0]."' class='link-mensagem'>Clique aqui para voltar</a>
            </label></div>";
}
else
{
    // carrega os dados
    $cValor = $modelo->insereDadosGrafico($listaIni->carregaValorTri());
    $cValor2 = $modelo->insereDadosGrafico($listaIni->carregaValorTri("saida"));

    // Busca informacoes sobre o cliente e equipamento, alterando o parametro de '$nova_url[0]' para '$idSim'
    $infoCli = $modelo->buscaDadosClinte($idSim);

    // Carrega a data, para realizar a comparacao de tempo ligado , alterando o parametro de '$nova_url[0]' para '$idSim'
    $respData = $modelo->verificaTempoOperacao($idSim);

    // Variavel que monitora se existe data como parametro
    // Se existir desabilita os graficos do multimetro
    // Inicia a variavel
    $data_rel = 0;

    // Tamanho do grafico de linha
    $tamanho_grafico = "311px";

    // Verifica se existe os para metros da data
    if (isset($this->parametros[4]) && !empty($this->parametros[4]) && isset($this->parametros[5]) && !empty($this->parametros[5]))
    {
        // Oculta os graficos de multimetro
        $data_rel = 1;

        // Aumenta o tamanho do grafico
        $tamanho_grafico = "580px";
    }
    ?>

    <script>
        // GERENCIADOR DE LINK NO TOPO DA PÁGINA
        var menu = document.getElementById('listadir');
        menu.innerHTML = '<a href="<?php echo HOME_URI; ?>/home/" class="linkMenuSup">Home</a> / ' +
                         '<a href="<?php echo HOME_URI; ?>/monitoramento/" class="linkMenuSup">Monitoramento</a> / ' +
                         '<a href="<?php echo HOME_URI; ?>/monitoramento/unidades/<?php echo $idClie ?>"> Unidade :<?php echo (isset($dadosEquipamento['filial'])) ? $dadosEquipamento['filial'] :"Matriz"; ?></a>' +
                         '/<a href="<?php echo HOME_URI; ?>/monitoramento/gerarGrafico/<?php echo $this->parametros[0]; ?>"> <?php echo $equipamentoMonitorado; ?> </a>';
    </script>

    <?php

    // Verifica se existe retorno
    if (!$cValor)
    {
        // Caso nao exista valor na result
        // Apresenta mensagem e link informando que nao ha resultado
        echo "<div class='mensagem-semvalor'>
                <label class='mensagem-texto'>Nenhum resultado foi encontrado.<br>
                    <a href='".HOME_URI."/monitoramento/' class='link-mensagem'>Clique aqui para voltar</a>
                </label></div>";
    }
    else
    {
    ?>

    <!-- Custom CSS -->
    <link href="<?php echo HOME_URI; ?>/views/_css/grafics.css" rel="stylesheet" type="text/css">

    <!-- scripts do grafico -->
    <script src="<?php echo HOME_URI; ?>/views/_js/highcharts/highcharts.js"></script>
    <script src="<?php echo HOME_URI; ?>/views/_js/highcharts/highcharts-more.js"></script>
    <script src="<?php echo HOME_URI; ?>/views/_js/moment/moment.js"></script>
    <script src="<?php echo HOME_URI; ?>/views/_js/main.js"></script>

    <script type="text/javascript">

        <?php

            //var_dump($retorno);
            // var_dump($cValor);
            // var_dump($cValor2);

            // TABELA UTILIZADAS PARA TENSÃO E CORRENTE
            $tabela = array("b","c","d","e","f","g","i","j","l","m","n","o");
            $tipoES = array("R","S","T","CR","CS","CT","R","S","T","CR","CS","CT");
            $nomes = array ("entrada","saida");

            $id = $idSim;

            // LOOP PARA CRIAR O GRAFICO
            for($p=0;$p<sizeof($tabela);$p++)
            {
                // VERIFICA QUAL O TIPO, SE EH ENTRADA OU SAIDA
                if ($p <= 5)
                {
                    // 0 PARA ENTRADA
                    $g = 0;
                }
                else
                {
                    // 1 PARA SAIDA
                    $g = 1;
                }

                // COLETA OS DADOS
                $dadosMoni = $modelo->carregaDadosGrafico($tabela[$p], $nomes[$g], $id);
                $dadosMoni = explode(";",$dadosMoni);

                /*
                * SAI DO PHP PARA EXECUTAR FUNÇÃO JAVASCRIPT PARA ALIMENTAR OS GRÁFICOS
                */
                ?>
                    $(function () {
                        $('#grafico-<?php echo $nomes[$g].'-'.strtolower($tipoES[$p]); ?>').highcharts({
                            title: {
                                text: 'Grafico <?php echo $nomes[$g] . " " . $tipoES[$p]; ?>',
                                x: -20 //center
                            },
                            subtitle: {
                                text: '',
                                x: -20
                            },
                            xAxis: {
                                categories: <?php echo $dadosMoni[1]; ?>
                            },
                            yAxis: {
                                title: {
                                    text: ''
                                },
                                plotLines: [{
                                    value: 0,
                                    width: 0,
                                    color: '#808080'
                                }]
                            },

                            tooltip: {
                                valueSuffix: ''
                            },
                            series: [{
                                name: '<?php echo strtoupper($nomes[$g]).'-'.$tipoES[$p]; ?>',
                                data: <?php echo $dadosMoni[0]; ?>
                            }]
                        });

                    });

                <?php
            }

            if ($data_rel == 0 )
            {

                // VARIAVEL QUE SOMA AS POSICOES (Servirá para contabilizar as posições de '$retorno')
                $mult = 0;

                // POSICOES DOS GRAFICOS
                $c = array(1,2,3,1,2,3,1,2,3,1,2,3,1);

                // MONTA OS GRAFICOX
                for ($b = 0; $b<12; $b++)
                {
                    // COLETA O NUMERO
                    $a = $c[$b];
                    // VARIA A TABELA DE ACORDO COM O TIPO DE GRAFICO
                    $t = $tabela[$b];

                    // VERIFICA SE O VALOR ESTA NO GRAFICO DE ENTRADA OU SAIDA
                    if ($b < 3)
                    {
                        // SE O VALOR DO LOOP FOR MENOR 3
                        // ALTERA O NOME DO ID E TEXTO
                        $container = "containerEntrada";
                        $texto = "Entrada";
                        $nomeDiv = "sit-ent";
                        $nomeDivBat = "bat_e";
                    }elseif($b > 2 && $b < 6){
                        // SE O VALOR DO LOOP FOR IGUAL OU MAIOR QUE 2
                        // ALTERA O NOME DO ID E TEXTO
                        $container = "containerTensaSaida";
                        $texto = "Saida";
                        $nomeDiv = "sit-sai";
                        $nomeDivBat = "bat_s";

                        $mult = 5;
                    }elseif($b > 5 && $b < 9){
                        // SE O VALOR DO LOOP FOR IGUAL OU MAIOR QUE 5
                        // ALTERA O NOME DO ID E TEXTO
                        $container = "containerEntradaCorente";
                        $texto = "Entrada Corrente";
                        $nomeDiv = "sit-cor-ent";
                        $nomeDivBat = "cor_e";

                        $mult = 15;
                    }else{
                        // SE O VALOR DO LOOP FOR IGUAL OU MAIOR QUE 10
                        // ALTERA O NOME DO ID E TEXTO
                        $container = "containerCorrentSaida";
                        $texto = "Saída Corrente";
                        $nomeDiv = "sit-cor-sai";
                        $nomeDivBat = "cor_s";

                        $mult = 20;

                    }

                    /*
                    * SAINDO DO PHP< DESTA VEZ PARA FAZER COM QUE O JAVASCRIPT INSIRA OS GRÁFICOS GERADOS EM SEUS RESPECTIVOS ESPAÇOS NO HTML
                    */

                    ?>

                    /**
                     * MEDIDOR DE TENSAO ANALOGICO <?php echo $texto . " " . $a . "\n" ; ?>
                     */
                     $(function () {
                         $('#<?php echo $container.$a; ?>').highcharts({
                             chart: {
                                 type: 'gauge',
                                 plotBorderWidth: 0,
                                 plotBackgroundColor: {
                                     linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
                                     stops: [ [0, '#fff'], [0.3, '#fff'], [1, '#fff'] ]
                                 },
                                 plotBackgroundImage: null, height: 150 // altura do painel
                             },
                             title: { text: '<?php echo $texto . " " . $tipoES[$a-1] ?>' },
                             pane: [{ startAngle: -45, endAngle: 45, background: null, center: ['54%', '95%'], size: 150 /* tamanho do painel */ }],
                             yAxis: [{
                                 min: 0,
                                 max: <?php echo number_format($retorno[4+$mult], 2, '.', ''); ?>,
                                 minorTickPosition: 'outside',
                                 tickPosition: 'outside',
                                 labels: {
                                     rotation: 'auto',
                                     distance: 20
                                 },
                                 plotBands: [{
                                     from: 0,
                                     to: <?php echo str_replace(',','.', $retorno[0+$mult]); ?>,
                                     color: '#DF5353' // red
                                 }, {
                                     from: <?php echo str_replace(',','.', $retorno[0+$mult]); ?>,
                                     to: <?php echo str_replace(',','.', $retorno[1+$mult]); ?>,
                                     color: '#DDDF0D' // yellow
                                 }, {
                                     from: <?php echo str_replace(',','.',$retorno[1+$mult]); ?>,
                                     to: <?php echo str_replace(',','.',$retorno[2+$mult]); ?>,
                                     color: '#55BF3B' // green
                                 }, {
                                     from: <?php echo str_replace(',','.',$retorno[2+$mult]); ?>,
                                     to: <?php echo str_replace(',','.',$retorno[3+$mult]); ?>,
                                     color: '#DDDF0D' // yellow
                                 }, {
                                     from: <?php echo str_replace(',','.',$retorno[3+$mult]); ?>,
                                     to: <?php echo str_replace(',','.',$retorno[4+$mult]); ?>,
                                     color: '#DF5353' // red
                                 }],

                                 pane: 0, title: { text: '<br/><span style="font-size:15px"><?php echo $texto; ?></span>', y: -10 } }],
                             plotOptions: { gauge: { dataLabels: { enabled: false }, dial: { radius: '100%' } } },
                             series: [{ data: [0],yAxis: 0 }]
                         },

                         // Let the music play
                         // EFETUA A BUSCA POR DADOS VIA JSON
                         function (chart) {
                             var valor = 0;
                             setInterval(function () {
                                 if (chart.series) { // the chart may be  destroyed, colocando '$idSim' no lugar de '$nova_url[0]'
                                     var url =  "<?php echo HOME_URI; ?>/classes/sincronizacaoGrafico/syncEntradaSaida.php?6e756d65726f=<?php echo $idSim;?>&656e7472616461=1&706f73546162656c61=<?php echo $t;?>&callback=?";
                                     $.getJSON(url,  function(data) {
                                         valor = parseFloat(data[0]);
                                     });

                                     var left = chart.series[0].points[0],
                                         //right = chart.series[1].points[0],
                                         leftVal,
                                         //rightVal,
                                         inc = parseFloat(valor/100);


                                     leftVal =  inc;


                                     //rightVal = inc;

                                    if (leftVal <= 0) {
                                         leftVal = 0;
                                         $("#<?php echo $nomeDiv.$a;?>").removeClass('situacaoLigado');
                                         $("#<?php echo $nomeDiv.$a;?>").addClass('situacaoDesligado');

                                         <?php

                                            //CASO ESTEJA MEDINDO UMA TENSÃO
                                            if($b < 6){
                                        ?>
                                            document.getElementById('<?php echo $nomeDiv.$a;?>').innerHTML = 'Desligado';

                                        <?php
                                            //CASO ESTEJA MEDINDO UMA CORRENTE
                                            }else{
                                        ?>
                                            document.getElementById('<?php echo $nomeDiv.$a;?>').innerHTML = 'Consumo';
                                        <?php
                                            }
                                         ?>


                                         console.log(leftVal + ' Desligado');
                                     }
                                     else if(leftVal < <?php echo $retorno[0+$mult]; ?>){
                                         $("#<?php echo $nomeDiv.$a;?>").removeClass('situacaoLigado');
                                         $("#<?php echo $nomeDiv.$a;?>").removeClass('situacaoAtencao');
                                         $("#<?php echo $nomeDiv.$a;?>").addClass('situacaoDesligado well-blink');
                                         document.getElementById('<?php echo $nomeDiv.$a;?>').innerHTML = 'Falha!';

                                         console.log(leftVal + 'Falhando');
                                     }
                                     else if (leftVal < <?php echo $retorno[1+$mult]; ?>) {
                                         $("#<?php echo $nomeDiv.$a;?>").removeClass('situacaoLigado');
                                         $("#<?php echo $nomeDiv.$a;?>").removeClass('situacaoDesligado');
                                         $("#<?php echo $nomeDiv.$a;?>").removeClass('well-blink');
                                         $("#<?php echo $nomeDiv.$a;?>").addClass('situacaoAtencao');
                                         document.getElementById('<?php echo $nomeDiv.$a;?>').innerHTML = 'Atenção';

                                     }
                                     else if (leftVal > <?php echo $retorno[4+$mult]; ?>) {
                                         leftVal = <?php echo $retorno[4+$mult]; ?> // alterar para panes
                                         $("#<?php echo $nomeDiv.$a;?>").removeClass('situacaoLigado');
                                         $("#<?php echo $nomeDiv.$a;?>").removeClass('situacaoAtencao');
                                         $("#<?php echo $nomeDiv.$a;?>").addClass('situacaoDesligado');
                                         document.getElementById('<?php echo $nomeDiv.$a;?>').innerHTML = 'Crítico!';

                                         console.log(leftVal + 'Ligado !!!!!'+ <?php echo number_format((float)$retorno[0+$mult], 2, '.', ''); ?>);

                                     }
                                     else if ((leftVal > <?php echo $retorno[3+$mult]; ?>) && (leftVal < <?php echo $retorno[4+$mult]; ?>)){
                                         $("#<?php echo $nomeDiv.$a;?>").removeClass('situacaoLigado');
                                         $("#<?php echo $nomeDiv.$a;?>").removeClass('situacaoDesligado');
                                         $("#<?php echo $nomeDiv.$a;?>").removeClass('well-blink');
                                         $("#<?php echo $nomeDiv.$a;?>").addClass('situacaoAtencao');
                                         document.getElementById('<?php echo $nomeDiv.$a;?>').innerHTML = 'Atenção';

                                          console.log(leftVal + 'Ligado Atencão!');
                                     }

                                     else {
                                         $("#<?php echo $nomeDiv.$a;?>").removeClass('situacaoDesligado');
                                         $("#<?php echo $nomeDiv.$a;?>").removeClass('well-blink');
                                         $("#<?php echo $nomeDiv.$a;?>").removeClass('situacaoAtencao');
                                         $("#<?php echo $nomeDiv.$a;?>").addClass('situacaoLigado');

                                         <?php

                                            //CASO ESTEJA MEDINDO UMA TENSÃO
                                            if($b < 6){
                                        ?>
                                            document.getElementById('<?php echo $nomeDiv.$a;?>').innerHTML = 'Ligado';

                                        <?php
                                            //CASO ESTEJA MEDINDO UMA CORRENTE
                                            }else{
                                        ?>
                                            document.getElementById('<?php echo $nomeDiv.$a;?>').innerHTML = 'Normal';
                                        <?php
                                            }
                                         ?>


                                         console.log(leftVal + 'Ligado Ok!');
                                     }

                                     left.update(leftVal, false);
                                     document.getElementById('<?php echo $nomeDivBat.$a;?>').innerHTML = leftVal + "";
                                     chart.redraw();

                                     //console.log(leftVal);
                                 }
                             }, 5000);
                         });
                     });
                    <?php

                    //$MULT FOI COMENTADO POIS ESTAVA GERANDO ERRO COM A NOVA FORMA DE CARREGAR AS CONFIGURAÇÕES
                    //$mult += 5;

                }

            }

        ?>

    </script>

    <!-- INICIO DO HTML DA PÁGINA -->
    <div class="row">
        <div class="col-lg-12">
            <!-- PAINEL CONTENDO PARTE DOS DADOS DO CLIENTE E DO EQUIPAMENTO MONITORADO -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-8">
                            <!-- TITULO PAINEL -->
                            <h4 class="page-header">Monitoramento de equipamento :</h4><!-- Fim Titulo pagina -->
                        </div>
                        <div class="col-md-4">
                            <div class="list-group">
                                <a href="<?php echo HOME_URI ?>/grafico/opcaoVisualizacao/<?php echo $idEquip; ?>" class="btn-primary list-group-item"><i class="fa fa-area-chart fa-1x"></i> Gerar relatorio gráfico</a>
                                <a href="<?php echo HOME_URI ?>/grafico/graficoFisicoParametrosEquipamentoCliente/<?php echo $idEquip; ?>" class="btn-primary list-group-item"><i class="fa fa-clipboard fa-1x"></i> Gerar relatorio estatístico</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <!-- DETALHES DO CLIENTE -->
                    <div class="row">

                        <div class="col-lg-6">
                            <h4>Cliente</h4>
                            <p>
                                <?php echo $nomeClie; ?> - <?php echo (isset($dadosEquipamento['filial'])) ? $dadosEquipamento['filial'] :"Matriz"; ?>
                            </p>
                        </div>
                        <div class="col-lg-6">
                            <h4>Equipamento</h4>
                            <p>
                                <?php echo $dadosEquipamento['tipoEquip']." ".$dadosEquipamento['nomeModeloEquipamento']; ?>
                            </p>
                        </div>
                    </div>
                    <!-- INICIO DOS GRÁFICO DE MONITORAMENTO -->
                    <?php

                        //var_dump($dadosEquipamento);

                        // 'tipo_entrada' => string '3' (length=1)
                        // 'tipo_saida' => string '3' (length=1)
                        //VERIFICA O TIPO DE SAIDA E ENTRADA PARA EXIBIR NA TELA
                        $tipoEntrada    = $dadosEquipamento['tipo_entrada'];
                        $tipoSaida      = $dadosEquipamento['tipo_saida'];
                    ?>
                    <input type="hidden" id="tipoEntrada" value="<?php echo $tipoEntrada; ?>" />
                    <input type="hidden" id="tipoSaida" value="<?php echo $tipoSaida; ?>" />

                    <div class="row">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h4>Tensão</h4>
                                    </div>
                                    <div class="col-md-6">
                                        <h4>Corrente</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body">

                                <div class="row">

                                    <div class="col-md-6">
                                        <div class="well">

                                            <div class="row">
                                                <!-- ENTRADA -->
                                                <div class="col-lg-6">
                                                    <h4>Entrada</h4>
                                                    <div class="row">
                                                        <!-- Entrada R/S -->
                                                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                                                            <div id="containerEntrada1" style="width: 100%; margin: 0 auto;"></div>
                                                            <label class="valorVindo" value=""><span id="bat_e1">0</span> ( v )</label>
                                                            <div id="sit-ent1" class="situacaoDesligado">Carregando...</div>
                                                        </div><!-- Fim entrada R/S -->
                                                    </div>
                                                    <?php
                                                        //VERIFICA SE ENTRADA POSSUI A ENTRADA S
                                                        if($tipoEntrada >= 2){

                                                        ?>
                                                        <div class="row">
                                                            <!-- Entrada R/S -->
                                                            <div class="ol-md-12 col-sm-12 col-xs-12">
                                                                <div id="containerEntrada2" style="width: 100%; margin: 0 auto;"></div>
                                                                <label class="valorVindo" value=""><span id="bat_e2">0</span> ( v )</label>
                                                                <div id="sit-ent2" class="situacaoDesligado">Carregando...</div>
                                                            </div><!-- Fim entrada R/S -->
                                                        </div>
                                                        <?php

                                                        }
                                                    ?>

                                                    <?php

                                                        //VERIFICA SE ENTRADA POSSUI A ENTRADA T
                                                        if($tipoEntrada == 3){
                                                        ?>
                                                        <div class="row">
                                                            <!-- Entrada R/S -->
                                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                                <div id="containerEntrada3" style="width: 100%; margin: 0 auto;"></div>
                                                                <label class="valorVindo" value=""><span id="bat_e3">0</span> ( v )</label>
                                                                <div id="sit-ent3" class="situacaoDesligado">Carregando...</div>
                                                            </div><!-- Fim entrada R/S -->
                                                        </div>
                                                        <?php
                                                        }

                                                    ?>



                                                </div>
                                                <!-- SAÍDA -->
                                                <div class="col-lg-6">
                                                    <h4>Saída</h4>
                                                    <div class="row">
                                                        <!-- Saida S/T -->
                                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                                            <div id="containerTensaSaida1" style="width:100%; margin: 0 auto"></div>
                                                            <label class="valorVindo" value=""><span id="bat_s1">0</span> ( v )</label>
                                                            <div id="sit-sai1" class="situacaoDesligado">Carregando...</div>
                                                        </div><!-- Saida S/T -->
                                                    </div>
                                                    <?php

                                                        //VERIFICA SE ENTRADA POSSUI A ENTRADA T
                                                        if($tipoEntrada >= 2){
                                                        ?>
                                                        <div class="row">
                                                            <!-- Saida S/T -->
                                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                                <div id="containerTensaSaida2" style="width:100%; margin: 0 auto"></div>
                                                                <label class="valorVindo" value=""><span id="bat_s2">0</span> ( v )</label>
                                                                <div id="sit-sai2" class="situacaoDesligado">Carregando...</div>
                                                            </div><!-- Saida S/T -->
                                                        </div>
                                                        <?php
                                                        }

                                                    ?>

                                                    <?php

                                                        //VERIFICA SE ENTRADA POSSUI A ENTRADA T
                                                        if($tipoEntrada == 3){
                                                        ?>
                                                        <div class="row">
                                                            <!-- Saida S/T -->
                                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                                <div id="containerTensaSaida3" style="width:100%; margin: 0 auto"></div>
                                                                <label class="valorVindo" value=""><span id="bat_s3">0</span> ( v )</label>
                                                                <div id="sit-sai3" class="situacaoDesligado">Carregando...</div>
                                                            </div><!-- Saida S/T -->
                                                        </div>
                                                        <?php
                                                        }

                                                    ?>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="well">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <h4>Entrada</h4>
                                                    <div class="row">
                                                        <!-- Entrada Corrente -->
                                                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                                                            <div id="containerEntradaCorente1" style="width: 100%; margin: 0 auto;"></div>
                                                            <label class="valorVindo"><span id="cor_e1">0</span> ( A )</label>
                                                            <div id="sit-cor-ent1" class="situacaoDesligado">Carregando...</div>
                                                        </div><!-- Fim entrada Corrente -->
                                                        <?php

                                                            //VERIFICA SE EQUIPAMENTO POSSUI A SAÍDA S
                                                            if($tipoSaida >= 2){
                                                            ?>
                                                            <!-- Entrada Corrente -->
                                                            <div class="col-md-12 col-sm-12 col-xs-12 ">
                                                                <div id="containerEntradaCorente2" style="width: 100%; margin: 0 auto;"></div>
                                                                <label class="valorVindo"><span id="cor_e2" >0</span> ( A )</label>
                                                                <div id="sit-cor-ent2" class="situacaoDesligado">Carregando...</div>
                                                            </div><!-- Fim entrada Corrente -->
                                                            <?php
                                                            }
                                                        ?>

                                                        <?php

                                                            //VERIFICA SE EQUIPAMENTO POSSUI A SAÍDA S
                                                            if($tipoSaida == 3 ){
                                                            ?>
                                                            <!-- Entrada Corrente -->
                                                            <div class="col-md-12 col-sm-12 col-xs-12 ">
                                                                <div id="containerEntradaCorente3" style="width: 100%; margin: 0 auto;"></div>
                                                                <label class="valorVindo"> <span id="cor_e3" >0</span> ( A )</label>
                                                                <div id="sit-cor-ent3" class="situacaoDesligado">Carregando...</div>
                                                            </div><!-- Fim entrada Corrente -->
                                                            <?php
                                                            }
                                                        ?>

                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <h4>Saída</h4>
                                                    <!-- Saida S/T -->
                                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                                        <div id="containerCorrentSaida1" style="width:100%; margin: 0 auto"></div>
                                                        <label class="valorVindo"><span id="cor_s1">0</span> ( A )</label>
                                                        <div id="sit-cor-sai1" class="situacaoDesligado">Carregando...</div>
                                                    </div><!-- Saida S/T -->

                                                    <?php

                                                        //VERIFICA SE EQUIPAMENTO POSSUI A SAÍDA S
                                                        if($tipoSaida >= 2){
                                                        ?>
                                                        <!-- Saida S/T -->
                                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                                            <div id="containerCorrentSaida2" style="width:100%; margin: 0 auto"></div>
                                                            <label  class="valorVindo"><span id="cor_s2">0</span> ( A )</label>
                                                            <div id="sit-cor-sai2" class="situacaoDesligado">Carregando...</div>
                                                        </div><!-- Saida S/T -->
                                                        <?php
                                                        }
                                                    ?>

                                                    <?php

                                                        //VERIFICA SE EQUIPAMENTO POSSUI A SAÍDA S
                                                        if($tipoSaida == 3 ){
                                                        ?>
                                                        <!-- Saida S/T -->
                                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                                            <div id="containerCorrentSaida3" style="width:100%; margin: 0 auto"></div>
                                                            <label  class="valorVindo"><span id="cor_s3">0</span> ( A )</label>
                                                            <div id="sit-cor-sai3" class="situacaoDesligado">Carregando...</div>
                                                        </div><!-- Saida S/T -->
                                                        <?php
                                                        }
                                                    ?>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <h4>Potência</h4>
                            </div>
                            <div class="panel-body">

                                <div class="row">
                                    <span id="totalPotenciaEquip" style="display:none;"><?php echo $dadosEquipamento['potencia']; ?></span>
                                    <script>
                                        setInterval(function(){

                                            /*
                                             VARIAVEIS PARA VERIFICAÇÃO DE TIPO DE EQUIPAMENTO
                                            */
                                            // var tipoEntradaEquip    = $('#tipoEntrada').val();
                                            // var tipoSaidaEquip      = $('#tipoSaida').val();

                                            var tipoEntradaEquip    = document.getElementById("tipoEntrada").value;
                                            var tipoSaidaEquip      = document.getElementById("tipoSaida").value;

                                            //console.log('Entrada = '+ tipoEntradaEquip+' sadidas'+ tipoSaidaEquip);

                                            var potenciaEquip = $('#totalPotenciaEquip').html();

                                            //ENTRADA R
                                            var tempEntR = $('#bat_e1').html();
                                            var tempSaiR = $('#cor_e1').html();

                                            var entR    = tempEntR.split(' ');
                                            var saiR    = tempSaiR.split(' ');

                                            var potEntR = new Number(entR[0]) * new Number(saiR[0]);
                                            $('#entrR').html(potEntR.toFixed(2) + " (w)");

                                            //VERIFICA SE EQUIPAMENTO POSSUI ENTRADA S

                                            if(tipoEntradaEquip >= 2){
                                                //ENTRADA S
                                                var tempEntS = $('#bat_e2').html();
                                                var tempSaiS = $('#cor_e2').html();

                                                var entS    = tempEntS.split(' ');
                                                var saiS    = tempSaiS.split(' ');

                                                var potEntS = new Number(entS[0]) * new Number(saiS[0]);
                                                $('#entrS').html(potEntR.toFixed(2) + " (w)");

                                            }else{
                                                //ENTRADA S
                                                var tempEntS = 0;
                                                var tempSaiS = 0;

                                                var entS    = 0;
                                                var saiS    = 0;

                                                var potEntS = 0;
                                            }


                                            //VERIFICA SE EQUIPAMENTO POSSUI ENTRADA T
                                            if(tipoEntradaEquip == 3){
                                                //ENTRADA T
                                                var tempEntT = $('#bat_e3').html();
                                                var tempSaiT = $('#cor_e3').html();

                                                var entT    = tempEntT.split(' ');
                                                var saiT    = tempSaiT.split(' ');

                                                var potEntT = new Number(entT[0]) * new Number(saiT[0]);
                                                $('#entrT').html(potEntT.toFixed(2) + " (w)");
                                            }else{
                                                //ENTRADA T
                                                var tempEntT = 0;
                                                var tempSaiT = 0;

                                                var entT    = 0;
                                                var saiT    = 0;

                                                var potEntT = 0;
                                            }





                                            //  Inicio do calculo para saidas

                                            //SAÍDA R
                                            var tempCorEntR = $('#bat_s1').html();
                                            var tempCorSaiR = $('#cor_s1').html();

                                            var corEntR    = tempCorEntR.split(' ');
                                            var corSaiR    = tempCorSaiR.split(' ');

                                            var potSaiR = new Number(corEntR[0]) * new Number(corSaiR[0]);
                                            $('#saiR').html(potSaiR.toFixed(2) + " (w)");

                                            //VERIFICA SE EQUIPAMENTO POSSUI SAIDA S

                                            if(tipoSaidaEquip >= 2){
                                                //SAÍDA S
                                                var tempCorEntS = $('#bat_s2').html();
                                                var tempCorSaiS = $('#cor_s2').html();

                                                var corEntS    = tempCorEntS.split(' ');
                                                var corSaiS    = tempCorSaiS.split(' ');

                                                var potSaiS = new Number(corEntS[0]) * new Number(corSaiS[0]);
                                                $('#saiS').html(potSaiS.toFixed(2) + " (w)");

                                            }else{
                                                //SAÍDA S
                                                var tempCorEntS = 0;
                                                var tempCorSaiS = 0;

                                                var potSaiS = 0;
                                            }

                                            //VERIFICA SE EQUIPAMENTO POSSUI SAIDA T

                                            if(tipoSaidaEquip == 3){

                                                //SAÍDA T
                                                var tempCorEntT = $('#bat_s3').html();
                                                var tempCorSaiT = $('#cor_s3').html();

                                                var corEntT    = tempCorEntT.split(' ');
                                                var corSaiT    = tempCorSaiT.split(' ');

                                                var potSaiT = new Number(corEntT[0]) * new Number(corSaiT[0]);
                                                $('#saiT').html(potSaiT.toFixed(2) + " (w)");

                                            }else{
                                                //SAÍDA T
                                                var tempCorEntT = 0;
                                                var tempCorSaiT = 0;

                                                var corEntT    = 0;
                                                var corSaiT    = 0;

                                                var potSaiT =  0;
                                            }


                                            //SOMA DA ENTRADA DE POTÊNCIA -- CORRIGIR AS VARIAVEIS QUE COMPOE A SOMA
                                            var totalEntradaPot = potEntR + potEntS + potEntT;
                                            var percentualEntradaPot = (totalEntradaPot * 100) / ((potenciaEquip * 1000) * 0.85);

                                            //Estilização do gráfico de entrada de potência
                                            // document.getElementById('cargaEntradaPotenciaPorcentagem').innerHTML = percentualEntradaPot.toFixed(2)+" %";
                                            // document.getElementById('cargaEntradaPotencia').style.width = percentualEntradaPot+"%";

                                            //SOMA DE SAÍDA DE POTÊNCIA
                                            var totalSaidaPot       = potSaiR + potSaiS + potSaiT;
                                            var percentualSaidaPot  = (totalSaidaPot * 100) / ((potenciaEquip * 1000) * 0.85);
                                            var percentualDisponivel = 100 - percentualSaidaPot;

                                            //VALOR DE POTENCIA SENDO CONSUMIDA ATUALMENTE

                                            var potenciaConsumida  =  (((potenciaEquip * 100) * percentualSaidaPot) / 100) / 100;
                                            //console.log('POTENCIA CONSMIDA ATUALMENTE '+ potenciaConsumida.toFixed(2));

                                            //Estilização do gráfico de saída de potência
                                            document.getElementById('potenciaSaidaConsumida').innerHTML = potenciaConsumida.toFixed(2)+" (Kva)";
                                            document.getElementById('cargaSaidaPotenciaPorcentagem').innerHTML = percentualSaidaPot.toFixed(2)+" %";
                                            document.getElementById('cargaSaidaPotencia').style.width = percentualSaidaPot+"%";
                                            document.getElementById('cargaDisponivelPotencia').style.width = percentualDisponivel+"%";
                                            document.getElementById('potenciaPorcentagemDisponivel').innerHTML = percentualDisponivel.toFixed(2)+" %";

                                        },5000);
                                    </script>

                                    <div class="col-lg-6">
                                        <div class="well">
                                            <div class="table-responsive">
                                                <table class="table table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>
                                                                Potência
                                                            </th>
                                                            <th>
                                                                R
                                                            </th>
                                                            <th>
                                                                S
                                                            </th>
                                                            <th>
                                                                T
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                Entrada
                                                            </td>
                                                            <td>
                                                                <span id="entrR"></span>
                                                            </td>
                                                            <td>
                                                                <span id="entrS"></span>
                                                            </td>
                                                            <td>
                                                                <span id="entrT"></span>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                Saída
                                                            </td>
                                                            <td>
                                                                <span id="saiR"></span>
                                                            </td>
                                                            <td>
                                                                <span id="saiS"></span>
                                                            </td>
                                                            <td>
                                                                <span id="saiT"></span>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="well">
                                            <h4>Consumo de potência</h4>
                                            <!-- GRAFICO POTÊNCIA ENTRADA -->
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <span class="pull-left text-muted">Potência equipamento</span><span class="pull-right text-muted"><?php echo $dadosEquipamento['potencia']; ?>(Kva)</span>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <!-- <div id="consumoEntradaPotencia">
                                                        <div class="progress progress-striped active">
                                                            <div id="cargaEntradaPotencia" class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                                                                <span id="cargaEntradaPotenciaPorcentagem" class=""></span>
                                                            </div>

                                                        </div>
                                                    </div> -->
                                                    <h4 id="mensagemCargaEntradaPotencia" class="text-center"></h4>
                                                </div>
                                            </div>

                                            <!-- GRÁFICO DE POTÊNCIA SAÍDA -->
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <!-- <span class="pull-left text-muted">0</span> -->
                                                    <span class="pull-left text-muted">Potência consumida</span>
                                                    <span id="potenciaSaidaConsumida" class="pull-right text-center"></span>
                                                    <!-- <span class="pull-right text-muted"><?php //echo $dadosEquipamento['potencia']; ?>(Kva)</span> -->
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h4 class="text-center"></h4>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <!-- <span class="pull-left text-muted">0</span> -->
                                                    <span class="pull-left text-muted">Potência disponível</span>
                                                    <span id="potenciaPorcentagemDisponivel" class="pull-right text-center"></span>
                                                    <!-- <span class="pull-right text-muted"><?php //echo $dadosEquipamento['potencia']; ?>(Kva)</span> -->
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div id="consumoSaidaPotencia">
                                                        <div class="progress progress-striped active">
                                                            <div id="cargaSaidaPotencia" class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                                                                <span id="cargaSaidaPotenciaPorcentagem" class=""></span>
                                                            </div>
                                                            <div id="cargaDisponivelPotencia" class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 0%">

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <h4 id="mensagemCargaSaidaPotencia" class="text-center"></h4>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <h4>Bateria</h4>
                            </div>
                            <div class="panel-body">
                                <div class="col-lg-4">
                                    <h4>Tensão do banco de bateria</h4>

                                    <!-- GRAFICO BATERIA REVISADO -->
                                    <?php
                                        /*
                                        * RECUPERANDO O VALOR PARA OS NÍVEIS DE BATERIA, VINDOS DA VARIAVEL '$retorno'
                                        */
                                        $bateriaCriticoBaixo    = $retorno['10'];
                                        $bateriaBaixo           = $retorno['11'];
                                        $bateriaNivelNormal     = $retorno['12'];
                                        $bateriaNivelAlto       = $retorno['13'];

                                    ?>
                                    <input type="hidden" id="bateriaValorAlto" value="<?php echo $bateriaNivelAlto; ?>" />

                                    <div class="row">
                                        <input id="quantidadeBancoBateria" type="hidden" value="<?php echo $dadosEquipamento['quantidade_banco_bateria']; ?>"/>
                                        <div id="wellCargabateria" class="well well-normal-status" style="margin-top:30px;height:100px;">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <span class="pull-left text-muted">0%</span><span class="pull-right text-muted">100%</span>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div id="cargaBateria">
                                                        <div class="progress progress-striped active">
                                                            <div id="cargaUtilGraficoBateria" class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                                                                <span id="cargaBateriaPorcentagem" class=""></span>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <h4 id="mensagemCargaBateria" class="text-center"></h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- FIM GRAFICO BATERIA REVISADO -->

                                    <!-- GRAFICO ANTIGO BATERIA -->
                                    <!-- <div class="div-baseBateria"> -->
                                        <!-- Barras de forca -->
                                        <!-- <div class="div-faixaVermelha"></div><div class="div-faixaVerde"></div> -->

                                        <!-- Valores -->
                                        <!-- <span class="span-menor">0</span>
                                        <span id="span-maior" class="span-maior">400</span> -->

                                        <!-- Campo de preenchimento -->
                                        <!-- <div class="div-campoPreen"> -->
                                            <!-- Legenda -->
                                            <!-- <div id="div-legenda"></div> -->
                                            <!-- Barra de carga -->
                                            <!-- <div id="div-cargaBat" class="div-carga"></div> -->
                                        <!-- </div> -->


                                        <script type="application/javascript">

                                            var valorBat            = 0;
                                            var valorBateriaAlto    = $('#bateriaValorAlto').val();
                                            var maxBat              = valorBateriaAlto - 1;

                                            setInterval(function(){  //, colocando '$idSim' no lugar de '$nova_url[0]'
                                                var url = "<?php echo HOME_URI; ?>/classes/sincronizacaoGrafico/syncEntradaSaida.php?6e756d65726f=<?php echo $idSim;?>&656e7472616461=5&706f73546162656c61=h&callback=?";
                                                $.getJSON(url,  function(data) {
                                                    valorBat        = (parseFloat(data[0]) / 100);
                                                    var calcula     = (valorBat*100)/maxBat;
                                                    var labelCarga  = parseFloat(calcula.toFixed(2));
                                                    //console.log(calcula);

                                                    if(valorBat > 0){
                                                        valorBat = valorBat + 17;
                                                    }

                                                    //FORNECE O MESMO DADO PARA O INPUT DE CALCULO PARA TENSÃO DE CARREGADOR DE BATERIA
                                                    document.getElementById('valorVariavelTensaoBateria').value = valorBat;
                                                    // document.getElementById('div-cargaBat').style.width = calcula+"%";

                                                    //Estilização do novo gráfico de bateria
                                                    document.getElementById('cargaBateriaPorcentagem').innerHTML = valorBat+" (Vdc)";
                                                    document.getElementById('cargaUtilGraficoBateria').style.width = calcula+"%";
                                                    //Se a bateria chegar a menor de 15% muda o estilo do well
                                                    if(valorBat < <?php echo $bateriaBaixo; ?>){
                                                        document.getElementById('mensagemCargaBateria').innerHTML = " ";
                                                        document.getElementById('mensagemCargaBateria').innerHTML = "Carga em nível baixo!";

                                                        document.getElementById('wellCargabateria').className = "";
                                                        document.getElementById('wellCargabateria').className = "well well-atention-status";

                                                        document.getElementById('cargaUtilGraficoBateria').className = "";
                                                        document.getElementById('cargaUtilGraficoBateria').className = "progress-bar progress-bar-warning";
                                                    }
                                                    if(valorBat < <?php echo $bateriaCriticoBaixo; ?>){
                                                        // document.getElementById('cargaUtilGraficoBateria').style.width = calcula+"%";
                                                        document.getElementById('mensagemCargaBateria').innerHTML = " ";
                                                        document.getElementById('mensagemCargaBateria').innerHTML = "Carga criticamente baixa!";

                                                        document.getElementById('wellCargabateria').className = "";
                                                        document.getElementById('wellCargabateria').className = "well well-danger-status well-blink";
                                                        document.getElementById('cargaUtilGraficoBateria').className = "";
                                                        document.getElementById('cargaUtilGraficoBateria').className = "progress-bar progress-bar-danger";
                                                    }
                                                    if(valorBat > <?php echo $bateriaBaixo; ?>){
                                                        document.getElementById('mensagemCargaBateria').innerHTML = " ";
                                                        document.getElementById('mensagemCargaBateria').innerHTML = "Carga nível seguro!";
                                                        document.getElementById('wellCargabateria').className = "";
                                                        document.getElementById('wellCargabateria').className = "well well-normal-status";
                                                        document.getElementById('cargaUtilGraficoBateria').className = "";
                                                        document.getElementById('cargaUtilGraficoBateria').className = "progress-bar progress-bar-success";
                                                    }
                                                });
                                            },5000);

                                            //console.log("data[0] : " + parseFloat(data[0]));
                                        </script>

                                    <!-- </div> -->


                                </div>
                                <!-- <div class="col-lg-4">
                                    <h4>Equipamento ligado?</h4>
                                    <div class="div-nbLigado">
                                        <script type="application/javascript">
                                            var valorLigado = 0;
                                            setInterval(function(){  //, colocando '$idSim' no lugar de '$nova_url[0]'
                                                var url = "<?php //echo HOME_URI; ?>/classes/sincronizacaoGrafico/syncEntradaSaida.php?6e756d65726f=<?php echo $idSim;?>&656e7472616461=2&&callback=?";
                                                $.getJSON(url,  function(data) {
                                                    valorLigado = parseFloat(data[0]);
                                                });


                                                // Verifica se esta ligado
                                                if (valorLigado == 1)
                                                {
                                                    // Se estiver ligado
                                                    // Adiciona um estado de cor verde
                                                    $("#fundoBaseNobreak").removeClass('nobreakDesligadoStatus');
                                                    $("#fundoBaseNobreak").addClass('nobreakLigadoStatus');
                                                    var resposta = "Ligado";
                                                }
                                                else
                                                {
                                                    // Se estiver desligado
                                                    // Adiciona um estado de cor vermelho
                                                    $("#fundoBaseNobreak").removeClass('nobreakLigadoStatus');
                                                    $("#fundoBaseNobreak").addClass('nobreakDesligadoStatus');
                                                    var resposta = "Desligado";
                                                }

                                                //document.getElementById('nobreakLigado').innerHTML = valorLigado + "<br>" + resposta;
                                                document.getElementById('nobreakLigado').innerHTML = "<h4><i class='fa fa-power-off fa-2x'></i> " + resposta+"</h4>";//
                                            },6000);
                                        </script>
                                        <div id="fundoBaseNobreak" class="well"><label id="nobreakLigado"></label></div>
                                    </div>
                                </div> -->
                                <div class="col-lg-4">
                                    <?php
                                        // Coleta a data atual
                                        // $dtAtual = date ("Y/m/d H:i:s");
                                        // // Substitui os tracos por barra da data
                                        // $respData = str_replace("-","/",$respData);
                                        //
                                        // //echo "<pre>". $dtAtual . "<br>" . $respData . "</pre>";
                                        //
                                        // // Converter data para tempo
                                        // $dtAtual = strtotime($dtAtual);
                                        // $respData = strtotime($respData);
                                        //
                                        // // Calcula a diferenca
                                        // $diff = $dtAtual - $respData;
                                        //
                                        // // Converte para dias
                                        //$conv = floor($diff/3600/24);
                                    ?>
                                    <h4>Tempo de autonomia estimado</h4>
                                    <script type="application/javascript">

                                        setInterval(function(){
                                            var url = "<?php echo HOME_URI; ?>/classes/sincronizacaoGrafico/syncAutonomiaBateria.php?6e756d65726f=<?php echo $idSim;?>&706f73546162656c61=<?php echo $idEquip?>&callback=?";
                                            $.getJSON(url,  function(data) {

                                                var quantidadeBancoBateria = $('#quantidadeBancoBateria').val();

                                                console.log(data.data_registro);

                                                var tempoEstimadoHora   = parseFloat(data.tempoEstimadoHora);//parseFloat(data[1]);
                                                var data_registro       = data.data_registro; //data[3];
                                                var correnteNominalBateria = parseFloat(data.correnteBancoBateria);//parseFloat(data.);//parseFloat(data[5]);

                                                var tempoTemp           = data_registro.split(" ");
                                                var dataCarga           = tempoTemp[0].split("-");
                                                var horario             = tempoTemp[1].split(":");
                                                var ultimaCarga         = new Date(dataCarga[0],(dataCarga[1] - 1),dataCarga[2], horario[0], horario[1], horario[2]);

                                                //CALCULA O TEMPO ESTIMADO DE AUTONOMIA DA BATERIA EM MINUTOS

                                                var tempoEstimado  = (60 * correnteNominalBateria) / tempoEstimadoHora;

                                                if(quantidadeBancoBateria == 2){
                                                    tempoEstimado = tempoEstimado * 2;
                                                }

                                                var horaAtual   = new Date();
                                                //var timeDiff    = Math.abs(ultimaCarga.getTime() - horaAtual.getTime());
                                                var timeDiff    = (horaAtual - ultimaCarga);
                                                var diffHrs     = Math.floor((timeDiff % 86400000) / 3600000); // hours
                                                var diffMins    = Math.round(((timeDiff % 86400000) % 3600000) / 60000);
                                                var diferencaTotal = (diffHrs * 60) + diffMins;
                                                var temporestante  = tempoEstimado - diferencaTotal;



                                                console.log("Tempo estimado em minutos :"+ tempoEstimado+ " Tempo da ultima carga :"+ ultimaCarga);
                                                console.log("Diferença de tempo  :"+ timeDiff+ " Diferença em horas e minutos :"+ diffHrs +":"+ diffMins);
                                                console.log("Minutos restantes :"+ temporestante);

                                                //Porcentagem da bateria
                                                var bateriaRestante   = (temporestante*100)/ tempoEstimado;
                                                //var bateriaRestante   = 24;

                                                if(bateriaRestante >= 25 ) {
                                                    document.getElementById('cargaUtilAutonomiaBateria').style.width = bateriaRestante+"%";
                                                }else if(bateriaRestante < 10){
                                                    document.getElementById('cargaUtilAutonomiaBateria').style.width ="25%";
                                                    document.getElementById('cargaUtilAutonomiaBateria').className = "progress-bar progress-bar-danger";
                                                }else if(bateriaRestante < 25){
                                                    document.getElementById('cargaUtilAutonomiaBateria').style.width = "25%";
                                                    document.getElementById('cargaUtilAutonomiaBateria').className = "progress-bar progress-bar-warning";
                                                }

                                                if(temporestante >= 0){
                                                    document.getElementById('cargaAutonomiaBateriaPorcentagem').innerHTML = temporestante.toFixed(0)+" (min)";
                                                }else{
                                                    document.getElementById('cargaAutonomiaBateriaPorcentagem').innerHTML = 0+" (min)";
                                                }

                                            });
                                        },5000);

                                    </script>
                                    <!-- GRAFICO AUTONOMIA BATERIA REVISADO -->
                                    <div class="row">
                                        <div id="wellAutonomiaBateria" class="well well-normal-status" style="margin-top:30px;height:100px;">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <span class="pull-left text-muted">0%</span><span class="pull-right text-muted">100%</span>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div id="cargaAutonomiaBateria">
                                                        <div class="progress progress-striped active">
                                                            <div id="cargaUtilAutonomiaBateria" class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                                                                <span id="cargaAutonomiaBateriaPorcentagem" class=""></span>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <h4 id="mensagemAutonomiaBateria" class="text-center"></h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <h4>Tensão do carregador por bateria</h4>
                                    <!-- RECUPERA QUANTIDADE DE BATERIAS E CONFIGURAÇÂO DE CARREGADOR -->
                                    <?php

                                        $configuracoesCarregador = $retorno;
                                        $quantidadeBateriaBanco  = $modeloEquip->quantidadeBateriaPorBanco($this->parametros[0]);

                                        //var_dump($quantidadeBateriaBanco);
                                        //var_dump($valorCriticBaixo, $valorBaixo, $valorIdeal, $valorAlto, $valorCriticoAlto);

                                    ?>

                                    <!-- GRAFICO CARREGADOR BATERIA -->
                                    <!-- QUANTIDADE DE BATERIA POR BANCO -->
                                    <input id="quantidadeBateriaPorBanco" type="hidden" name="quantidadeBateriaPorBanco" value="<?php echo $quantidadeBateriaBanco['quantidade'][0]['quantidade_bateria_por_banco']; ?>" />
                                    <input id="valorVariavelTensaoBateria" type="hidden" name="valorVariavelTensaoBateria" value="">

                                    <input id="carregadorCritAlto" type="hidden" name="carregadorCritAlto" value="<?php echo (isset($configuracoesCarregador[39])) ? $configuracoesCarregador[39] : '0'; ?>" />
                                    <input id="carregadorAlto" type="hidden" name="carregadorAlto" value="<?php echo (isset($configuracoesCarregador[38])) ? $configuracoesCarregador[38] : '0'; ?>" />
                                    <input id="carregadorIdeal" type="hidden" name="carregadorIdeal" value="<?php echo (isset($configuracoesCarregador[37])) ? $configuracoesCarregador[37] : '0'; ?>" />
                                    <input id="carregadorBaixo" type="hidden" name="carregadorBaixo" value="<?php echo (isset($configuracoesCarregador[36])) ? $configuracoesCarregador[36] : '0'; ?>" />
                                    <input id="carregadorCritBaixo" type="hidden" name="carregadorCritBaixo" value="<?php echo (isset($configuracoesCarregador[35])) ? $configuracoesCarregador[35] : '0'; ?>" />

                                    <script>

                                        setInterval(function(){

                                            var quantidadeBateria = $('#quantidadeBateriaPorBanco').val();

                                            var valorrCritAlto  = $('#carregadorCritAlto').val();
                                            var valorrAlto      = $('#carregadorAlto').val();
                                            var valorrIdeal     = $('#carregadorIdeal').val();
                                            var valorrBaixo     = $('#carregadorBaixo').val();
                                            var valorrCritBaixo = $('#carregadorCritBaixo').val();

                                            //RECUPERA O VALOR DA TENSÃO DA BATERIA

                                            var tensaoBancoBateria = $('#valorVariavelTensaoBateria').val();

                                            var tensaoPorBateria   = tensaoBancoBateria/quantidadeBateria;

                                            if(tensaoBancoBateria > valorrCritAlto){
                                                document.getElementById('cargaCarregadorBateria').style.width = "90%";
                                                document.getElementById('cargaCarregadorBateria').className = "progress-bar progress-bar-danger";
                                                document.getElementById('mensagemCarregadorBateria').innerHTML = "Carregador criticamente alto!";
                                            }else if(tensaoBancoBateria >= valorrAlto){
                                                document.getElementById('cargaCarregadorBateria').style.width = "75%";
                                                document.getElementById('cargaCarregadorBateria').className = "progress-bar progress-bar-warning";
                                                document.getElementById('mensagemCarregadorBateria').innerHTML = "Carregador em nível alto!";
                                            }else if(tensaoBancoBateria < valorrCritBaixo){
                                                document.getElementById('cargaCarregadorBateria').style.width = "20%";
                                                document.getElementById('cargaCarregadorBateria').className = "progress-bar progress-bar-warning";
                                                document.getElementById('mensagemCarregadorBateria').innerHTML = "Carregador em rampa!";
                                            }else if(tensaoBancoBateria <= valorrBaixo){
                                                document.getElementById('cargaCarregadorBateria').style.width = "40%";
                                                document.getElementById('cargaCarregadorBateria').className = "progress-bar progress-bar-warning";
                                                document.getElementById('mensagemCarregadorBateria').innerHTML = "Carregador em nível baixo.";
                                            }else{
                                                document.getElementById('cargaCarregadorBateria').style.width = "60%";
                                                document.getElementById('cargaCarregadorBateria').className = "progress-bar progress-bar-success";
                                                document.getElementById('mensagemCarregadorBateria').innerHTML = "Carregador em nível normal.";
                                            }

                                            //Estilização do novo gráfico de bateria
                                            document.getElementById('cargaCarregadorBateriaPorcentagem').innerHTML = tensaoPorBateria.toFixed(2)+"(Vdc) / Bat";
                                            console.log(tensaoBancoBateria+" tensao banco bateria!!");
                                        },5000);

                                    </script>

                                    <div class="row">
                                        <div id="wellCarregadorBateria" class="well well-normal-status" style="margin-top:30px;height:100px;">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <span class="pull-left text-muted">Min</span><span class="pull-right text-muted">Max</span>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div id="carregadorBateria">
                                                        <div class="progress progress-striped active">
                                                            <div id="cargaCarregadorBateria" class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                                                                <span id="cargaCarregadorBateriaPorcentagem" class=""></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <h4 id="mensagemCarregadorBateria" class="text-center"></h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <h4>Temperaturas</h4>
                            </div>
                            <div class="panel-body">

                                <!-- TRECHO QUE IRÁ POPULAR OS DADOS DE TEMPERATURA -->

                                <script type="application/javascript">

                                    //MEDIDOR DE TEMPERATURA 1

                                    var temperatura1 = 0;
                                    var temperatura2 = 0;

                                    setInterval(function(){
                                        //URL para chamar a função de medição de temperatura
                                        var url = "<?php echo HOME_URI; ?>/classes/sincronizacaoGrafico/syncTemperatura.php?6e756d65726f=<?php echo $idSim;?>&656e7472616461=5&706f73546162656c61=q&callback=?";
                                        $.getJSON(url,  function(data) {

                                            temperatura1 = parseFloat(data[0])/100;
                                            $('#cor_temp1').html(temperatura1.toFixed(1) +"");
                                            $('#sit-cor-temp1').html('');

                                            switch (temperatura1) {
                                                case (temperatura1 < 250):
                                                    document.getElementById('sit-cor-temp1').className = "well well-normal-status";
                                                break;
                                                case (temperatura1 < 350):
                                                    document.getElementById('sit-cor-temp1').className = "well well-atention-statuss";
                                                break;
                                                case (temperatura1 < 450):
                                                    document.getElementById('sit-cor-temp1').className = "well well-danger-status well-blink";
                                                break;
                                            }

                                            //TRATA OS RESULTADOS DA FUNÇÃO

                                        });
                                    },5000);


                                    //MEDIDOR DE TEMPERATURA 2
                                    setInterval(function(){
                                        //URL para chamar a função de medição de temperatura
                                        var url = "<?php echo HOME_URI; ?>/classes/sincronizacaoGrafico/syncTemperatura.php?6e756d65726f=<?php echo $idSim;?>&656e7472616461=5&706f73546162656c61=r&callback=?";
                                        $.getJSON(url,  function(data) {

                                            temperatura1 = parseFloat(data[0])/100;
                                            $('#cor_temp2').html(temperatura1.toFixed(1) +"");
                                            $('#sit-cor-temp2').html('');

                                            switch (temperatura1) {
                                                case (temperatura1 < 250):
                                                    document.getElementById('sit-cor-temp2').className = "well well-normal-status";
                                                break;
                                                case (temperatura1 < 350):
                                                    document.getElementById('sit-cor-temp2').className = "well well-atention-statuss";
                                                break;
                                                case (temperatura1 < 450):
                                                    document.getElementById('sit-cor-temp2').className = "well well-danger-status well-blink";
                                                break;
                                            }

                                            //TRATA OS RESULTADOS DA FUNÇÃO

                                        });
                                    },5000);

                                </script>

                                <div class="col-lg-3">
                                    <h4>Temp. ambiente</h4>
                                    <!-- Medidor temperatura 1 -->
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div id="containerTemperatura1" style="width:100%; margin: 0 auto"></div>
                                        <label class="valorVindo"><span id="cor_temp1"> 0</span> ( °C )</label>
                                        <div id="sit-cor-temp1" class="situacaoDesligado">Carregando...</div>
                                    </div><!-- Saida S/T -->
                                </div>
                                <div class="col-lg-3">
                                    <h4>Temp. banco de bateria</h4>
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div id="containerTemperatura2" style="width:100%; margin: 0 auto"></div>
                                        <label class="valorVindo"><span id="cor_temp2"> 0</span> ( °C )</label>
                                        <div id="sit-cor-temp2" class="situacaoDesligado">Carregando...</div>
                                    </div><!-- Saida S/T -->
                                </div>
                                <div class="col-lg-6">
                                    <!-- <div class="demo-container">
                            			<div id="placeholder" class="demo-placeholder" style="height:300px;"></div>
                            		</div>

                                    <p>Time between updates: <input id="updateInterval" type="text" value="" style="text-align: right; width:5em"> milliseconds</p> -->

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-footer">

                </div>
            </div>

        </div>
    </div>


        <?php
        // Verifica se as datas existem
        // Caso nao existam, mostra os multimetros de tensao
        if ($data_rel == 0 ) { ?>


        <?php } ?>

    <?php }
}

?>
