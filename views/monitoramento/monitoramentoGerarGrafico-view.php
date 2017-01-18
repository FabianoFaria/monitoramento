<?php

// Verifica se esta definido o path
if (! defined('EFIPATH')) exit();

// Aqui está sendo simplificado o processo de coleta de dados do equipamento para geração de gráficos
$dadosEquipamento   = $modeloEquip->dadosEquipamentoCliente($this->parametros[0]);
// Aqui está sendo carregado os dados de Sim, id_sim_equipamento necessarios para está página
$dadosVinculoEquip  = $modeloEquip->detalhesEquipamentoParaConfiguracao($this->parametros[0]);
//Aqui são os dados do cliente para exibição na tela
$dadosClie          = $modeloEquip->dadosEquipamentoCliente($this->parametros[0]);

if($dadosClie['status']){
    $dadosClie = $dadosClie['equipamento'][0];
    $idClie    = $dadosClie['idClie'];
    $nomeClie  = $dadosClie['cliente'];
}

// Carrega as configuracoes de sim , configurando e tratando a url
//METODO SENDO DESATIVADO
//$nova_url = $modelo->confParamentroGrafico();

if($dadosVinculoEquip['status']){
    $idEquip    = $dadosVinculoEquip['equipamento'][0]['id_equipamento'];
    $idSimEquip = $dadosVinculoEquip['equipamento'][0]['id'];
    $idSim      = $dadosVinculoEquip['equipamento'][0]['id_sim'];
}else{
    $idEquip    = null;
    $idSimEquip = null;
    $idSim      = null;
}

//Inicia class da Lista inical
$parametroListaIni  = array();
array_push($parametroListaIni, $idSim);
$limite             = 30;
$listaIni           = new ListaInicial($limite, $this->db, $parametroListaIni);

//var_dump($dadosVinculoEquip);

// Carrega os parametros
$retorno = $modelo->loadGraficoParam($idEquip, $idSimEquip, $idSim);

var_dump($retorno);

if (empty($retorno) && isset($retorno))
{
    // Caso nao exista valor
    // Apresenta mensagem e link informando que nao ha resultado
    echo "<div class='mensagem-semvalor'>
            <label class='mensagem-texto'>Verifique se os parametros est&atilde;o configurados.<br>
                <a href='".HOME_URI."/monitoramento/' class='link-mensagem'>Clique aqui para voltar</a>
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
        // gerenciador de link
        var menu = document.getElementById('listadir');
        menu.innerHTML = '<a href="<?php echo HOME_URI; ?>/home/" class="linkMenuSup">Home</a> / ' +
                         '<a href="<?php echo HOME_URI; ?>/monitoramento/" class="linkMenuSup">Monitoramento</a> / ' +
                         '<a href="<?php echo HOME_URI; ?>/monitoramento/unidades/<?php echo $idClie ?>"> <?php echo $nomeClie; ?></a>' +
                         '/<a href="<?php echo HOME_URI; ?>/monitoramento/gerarGrafico/<?php echo $this->parametros[0]; ?>"> Equipamento </a>';
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
        $(function () {
            $('#container-gr').highcharts({
                chart: { type: 'spline' },
                title: { text: 'Gráfico de tensão' },
                subtitle: { text: '' },
                xAxis: {
                    type: 'datetime',
                    dateTimeLabelFormats: { // don't display the dummy year
                        month: '%e. %b',
                        year: '%b'
                    },
                    title: { text: 'Período' }
                },
                yAxis: {
                    title: { text: '' }, min: 0
                },
                tooltip: {
                    headerFormat: '<b>{series.name}</b><br>',
                    pointFormat: '{point.x:%e/%b} - ({point.y:.2f} v)'
                },
                plotOptions: { spline: { marker: { enabled: true } } },
                series: [{
                    name: 'Tensao Entrada',
                    // Define the data points. All series have a dummy year
                    // of 1970/71 in order to be compared on the same x axis. Note
                    // that in JavaScript, months start at 0 for January, 1 for February etc.
                    data: [<?php echo $cValor; ?>] },
                {
                    name: 'Tensao Saida',
                    data: [<?php echo $cValor2; ?>]
                } /* , {
                    name: 'D',
                    data: [ [Date.UTC(1970,  9,  9), 0   ], [Date.UTC(1971,  4, 21), 0   ] ]
                }*/]
            });
        });



        <?php
            // Tabela utilizadas
            $tabela = array("b","c","d","e","f","g");
            $tipoES = array("R","S","T","R","S","T");
            $nomes = array ("entrada","saida");

            // Converte da base 64 para texto
            // $id = base64_decode($this->parametros[0]);
            // NESSA ALTERAÇÂO A id DO SIM FOI RECUPERADA COM A CHAMADA DE UMA FUNÇÃO NO INICIO DO ARQUIVO
            $id = $idSim;

            // Loop para criar o grafico
            for($p=0;$p<sizeof($tabela);$p++)
            {
                // Verifica qual o tipo, se eh entrada ou saida
                if ($p <= 2)
                {
                    // 0 para entrada
                    $g = 0;
                }
                else
                {
                    // 1 para saida
                    $g = 1;
                }

                // Coleta os dados
                $dadosMoni = $modelo->carregaDadosGrafico($tabela[$p], $nomes[$g], $id);
                $dadosMoni = explode(";",$dadosMoni);

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
                // Variavel que soma as posicoes
                $mult = 0;

                // Posicoes dos graficos
                $c = array(1,2,3,1,2,3);

                // Monta os graficox
                for ($b = 0; $b<6; $b++)
                {
                    // Coleta o numero
                    $a = $c[$b];
                    // Varia a tabela de acordo com o tipo de grafico
                    $t = $tabela[$b];

                    // Verifica se o valor esta no grafico de entrada ou saida
                    if ($b < 3)
                    {
                        // Se o valor do loop for menor 3
                        // Altera o nome do id e texto
                        $container = "containerEntrada";
                        $texto = "Entrada";
                        $nomeDiv = "sit-ent";
                        $nomeDivBat = "bat_e";
                    }
                    else
                    {
                        // Se o valor do loop for igual ou maior que 3
                        // Altera o nome do id e texto
                        $container = "containerTensaSaida";
                        $texto = "Saida";
                        $nomeDiv = "sit-sai";
                        $nomeDivBat = "bat_s";
                    }
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
                                max: <?php echo $retorno[4+$mult]; ?>,
                                minorTickPosition: 'outside',
                                tickPosition: 'outside',
                                labels: {
                                    rotation: 'auto',
                                    distance: 20
                                },
                                plotBands: [{
                                    from: 0,
                                    to: <?php echo $retorno[0+$mult]; ?>,
                                    color: '#DF5353' // red
                                }, {
                                    from: <?php echo $retorno[0+$mult]; ?>,
                                    to: <?php echo $retorno[1+$mult]; ?>,
                                    color: '#DDDF0D' // yellow
                                }, {
                                    from: <?php echo $retorno[1+$mult]; ?>,
                                    to: <?php echo $retorno[2+$mult]; ?>,
                                    color: '#55BF3B' // green
                                }, {
                                    from: <?php echo $retorno[2+$mult]; ?>,
                                    to: <?php echo $retorno[3+$mult]; ?>,
                                    color: '#DDDF0D' // yellow
                                }, {
                                    from: <?php echo $retorno[3+$mult]; ?>,
                                    to: <?php echo $retorno[4+$mult]; ?>,
                                    color: '#DF5353' // red
                                }],

                                pane: 0, title: { text: '<br/><span style="font-size:15px"><?php echo $texto; ?></span>', y: -10 } }],
                            plotOptions: { gauge: { dataLabels: { enabled: false }, dial: { radius: '100%' } } },
                            series: [{ data: [0],yAxis: 0 }]
                        },

                        // Let the music play
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
                                        inc = parseFloat(valor/10);


                                    leftVal =  inc;


                                    //rightVal = inc;

                                    if (leftVal <= 0) {
                                        leftVal = 0;
                                        $("#<?php echo $nomeDiv.$a;?>").removeClass('situacaoLigado');
                                        $("#<?php echo $nomeDiv.$a;?>").addClass('situacaoDesligado');
                                        document.getElementById('<?php echo $nomeDiv.$a;?>').innerHTML = 'Desligado';
                                    }
                                    else if (leftVal > <?php echo $retorno[4+$mult]; ?>) {
                                        leftVal = <?php echo $retorno[4+$mult]; ?> // alterar para panes
                                        $("#<?php echo $nomeDiv.$a;?>").removeClass('situacaoDesligado');
                                        $("#<?php echo $nomeDiv.$a;?>").addClass('situacaoLigado');
                                        document.getElementById('<?php echo $nomeDiv.$a;?>').innerHTML = 'Ligado';
                                    } else {
                                        $("#<?php echo $nomeDiv.$a;?>").removeClass('situacaoDesligado');
                                        $("#<?php echo $nomeDiv.$a;?>").addClass('situacaoLigado');
                                        document.getElementById('<?php echo $nomeDiv.$a;?>').innerHTML = 'Ligado';
                                    }

                                    left.update(leftVal, false);
                                    document.getElementById('<?php echo $nomeDivBat.$a;?>').innerHTML = leftVal + " ( v )";
                                    chart.redraw();
                                }
                            }, 6000);
                        });
                    });

        <?php
                    //$mult foi comentado pois estava gerando erro com a nova forma de carregar as configurações
                    // $mult += 5;
                }
            }
        ?>
    </script>


    <!-- INICIO DO HTML DA PÁGINA -->




    <div class="container-fluid fundo-geraGrafico">

        <!-- Dados do cliente -->
        <div class="row nome-apresentacao">

            <!-- Informacoes do clinte -->
            <div class="col-md-3 col-sm-6">
                <label class="info-monito">Unidade</label><br>
                <label class="info-monitoDados"><?php echo $infoCli['nomeCli']; ?></label>
            </div><!-- Fim informacao do cliente -->

            <!-- Informacoes Equipamento -->
            <div class="col-md-3 col-sm-6">
                <label class="info-monito">Equipamento</label><br>
                <label class="info-monitoDados">
                    <?php echo $infoCli['nomeEquip']; ?>
                    <?php echo $infoCli['nomeFabri']; ?>
                    <?php echo $infoCli['modeloEquip']; ?>
                </label>
            </div><!-- Fim Informacoes Equipamento -->
        </div><!-- Fim Dados do cliente -->


        <div class="row">

            <!-- Coluna de grafico analogico -->
            <div class="col-md-6 col-sm-12 col-xs-12">
                <div class="row">
                    <!-- Entrada R/S -->
                    <div class="col-md-6 col-sm-6 col-xs-6 fundo-camposGrafico">
                        <div id="containerEntrada1" style="width: 100%; margin: 0 auto;"></div>
                        <label id="bat_e1" class="valorVindo">0 ( v )</label>
                        <div id="sit-ent1" class="situacaoDesligado">Carregando...</div>
                    </div><!-- Fim entrada R/S -->


                    <!-- Saida R/S -->
                    <div class="col-md-6 col-sm-6 col-xs-6 fundo-camposGrafico">
                        <div id="containerTensaSaida1" style="width:100%; margin: 0 auto"></div>
                        <label id="bat_s1" class="valorVindo">0 ( v )</label>
                        <div id="sit-sai1" class="situacaoDesligado">Carregando...</div>
                    </div><!-- Saida R/S -->
                </div>

                <div class="row">
                    <!-- Entrada S/T -->
                    <div class="col-md-6 col-sm-6 col-xs-6 fundo-camposGrafico">
                        <div id="containerEntrada2" style="width: 100%; margin: 0 auto;"></div>
                        <label id="bat_e2" class="valorVindo">0 ( v )</label>
                        <div id="sit-ent2" class="situacaoDesligado">Carregando...</div>
                    </div><!-- Fim entrada S/T -->


                    <!-- Saida S/T -->
                    <div class="col-md-6 col-sm-6 col-xs-6 fundo-camposGrafico">
                        <div id="containerTensaSaida2" style="width:100%; margin: 0 auto"></div>
                        <label id="bat_s2" class="valorVindo">0 ( v )</label>
                        <div id="sit-sai2" class="situacaoDesligado">Carregando...</div>
                    </div><!-- Saida S/T -->
                </div>


                <div class="row">
                    <!-- Entrada R/T -->
                    <div class="col-md-6 col-sm-6 col-xs-6 fundo-camposGrafico">
                        <div id="containerEntrada3" style="width: 100%; margin: 0 auto;"></div>
                        <label id="bat_e3" class="valorVindo">0 ( v )</label>
                        <div id="sit-ent3" class="situacaoDesligado">Carregando...</div>
                    </div><!-- Fim entrada R/T -->


                    <!-- Saida R/T -->
                    <div class="col-md-6 col-sm-6 col-xs-6 fundo-camposGrafico">
                        <div id="containerTensaSaida3" style="width:100%; margin: 0 auto"></div>
                        <label id="bat_s3" class="valorVindo">0 ( v )</label>
                        <div id="sit-sai3" class="situacaoDesligado">Carregando...</div>
                    </div><!-- Saida R/T -->
                </div>
            </div><!-- Fim Coluna de grafico analogico -->




            <!-- Coluna de outros graficos -->
            <div class="col-md-6 col-sm-12 col-xs-12">

                <!-- Primeira linha -->
                <div class="row">
                    <!-- Bateria -->
                    <div class="col-md-4 col-sm-6 col-xs-6 txt-center fundo-camposGrafico separa-campo2 ajusteGrafico">
                        <label class="lb-monitoramento">Bateria</label>
                        <div class="div-baseBateria">
                            <!-- Barras de forca -->
                            <div class="div-faixaVermelha"></div><div class="div-faixaVerde"></div>

                            <!-- Valores -->
                            <span class="span-menor">0</span>
                            <span id="span-maior" class="span-maior">400</span>

                            <!-- Campo de preenchimento -->
                            <div class="div-campoPreen">
                                <!-- Legenda -->
                                <div id="div-legenda"></div>
                                <!-- Barra de carga -->
                                <div id="div-cargaBat" class="div-carga"></div>
                            </div>





                            <script type="application/javascript">
                                var valorBat = 0;
                                var maxBat = 400;

                                setInterval(function(){  //, colocando '$idSim' no lugar de '$nova_url[0]'
                                    var url = "<?php echo HOME_URI; ?>/classes/sincronizacaoGrafico/syncEntradaSaida.php?6e756d65726f=<?php echo $idSim;?>&656e7472616461=5&706f73546162656c61=h&callback=?";
                                    $.getJSON(url,  function(data) {
                                        valorBat = parseFloat(data[0]);
                                        var calcula = (valorBat*100)/maxBat;
                                        console.log(calcula);
                                        document.getElementById('div-legenda').innerHTML = valorBat;
                                        document.getElementById('div-cargaBat').style.width = calcula+"%";
                                    });
                                },6000);

                                console.log("data[0] : " + valorBat);
                            </script>
                        </div>
                    </div><!-- Fim Bateria -->



                    <!-- Grafico entrada r -->
                    <div class="col-md-4 col-sm-6 col-xs-6 separa-campo fundo-camposGrafico">
                        <div id="grafico-entrada-r" style="width: 100%; height: 220px; margin: 0 auto"></div>
                    </div>
                    <!-- Fim grafico entrada r -->



                    <!-- Grafico saida r -->
                    <div class="col-md-4 col-sm-6 col-xs-6 separa-campo fundo-camposGrafico">
                        <div id="grafico-saida-r" style="width: 100%; height: 220px; margin: 0 auto"></div>
                    </div>
                    <!-- Fim grafico saida r -->



                </div><!-- Primeira linha -->



                <!-- Tempo de operacao -->
                <div class="row">
                    <?php
                        // Coleta a data atual
                        $dtAtual = date ("Y/m/d H:i:s");
                        // Substitui os tracos por barra da data
                        $respData = str_replace("-","/",$respData);

                        //echo "<pre>". $dtAtual . "<br>" . $respData . "</pre>";

                        // Converter data para tempo
                        $dtAtual = strtotime($dtAtual);
                        $respData = strtotime($respData);

                        // Calcula a diferenca
                        $diff = $dtAtual - $respData;

                        // Converte para dias
                        $conv = floor($diff/3600/24);
                    ?>

                    <!-- Tempo de operacao -->
                    <div class="col-md-4 col-sm-6 col-xs-6 txt-center fundo-camposGrafico ajusteGrafico">
                        <label class="lb-monitoramento">Tempo de opera&ccedil;&atilde;o</label>
                        <div class="div-tempoOperacao">
                            <label id="lb-tempoOperacao">
                                <?php
                                    if ($conv < 2 )
                                      echo $conv . " Dia";
                                    else
                                      echo $conv . " Dias";
                                ?>
                            </label>
                        </div>
                    </div><!-- Fim tempo de operacao -->


                    <!-- Grafico entrada r -->
                    <div class="col-md-4 col-sm-6 col-xs-6 separa-campo fundo-camposGrafico">
                        <div id="grafico-entrada-s" style="width: 100%; height: 220px; margin: 0 auto"></div>
                    </div>
                    <!-- Fim grafico entrada r -->



                    <!-- Grafico saida r -->
                    <div class="col-md-4 col-sm-6 col-xs-6 separa-campo fundo-camposGrafico">
                        <div id="grafico-saida-s" style="width: 100%; height: 220px; margin: 0 auto"></div>
                    </div>
                    <!-- Fim grafico saida r -->
                </div>


                <!-- Segunda linha -->
                <div class="row">


                    <!-- Nobreak ligado -->
                    <div class="col-md-4 col-sm-6 col-xs-6 txt-center fundo-camposGrafico ajusteGrafico">
                        <label class="lb-monitoramento">No-break Ligado ?</label>
                        <div class="div-nbLigado">
                            <script type="application/javascript">
                                var valorLigado = 0;
                                setInterval(function(){  //, colocando '$idSim' no lugar de '$nova_url[0]'
                                    var url = "<?php echo HOME_URI; ?>/classes/sincronizacaoGrafico/syncEntradaSaida.php?6e756d65726f=<?php echo $idSim;?>&656e7472616461=2&&callback=?";
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

                                    document.getElementById('nobreakLigado').innerHTML = valorLigado + "<br>" + resposta;
                                },6000);
                            </script>
                            <div id="fundoBaseNobreak"><label id="nobreakLigado"></label></div>
                        </div>
                    </div><!-- Fim nobreak ligado -->


                    <!-- Grafico entrada t -->
                    <div class="col-md-4 col-sm-6 col-xs-6 separa-campo fundo-camposGrafico">
                        <div id="grafico-entrada-t" style="width: 100%; height: 220px; margin: 0 auto"></div>
                    </div>
                    <!-- Fim grafico entrada r -->



                    <!-- Grafico saida t -->
                    <div class="col-md-4 col-sm-6 col-xs-6 separa-campo fundo-camposGrafico">
                        <div id="grafico-saida-t" style="width: 100%; height: 220px; margin: 0 auto"></div>
                    </div>
                    <!-- Fim grafico saida r -->


                </div><!-- Fim Segunda linha -->


            </div><!-- Fim Coluna de outros graficos -->
        </div>




        <?php
        // Verifica se as datas existem
        // Caso nao existam, mostra os multimetros de tensao
        if ($data_rel == 0 ) { ?>




        <?php } ?>
    </div>

    <?php }
}

?>
