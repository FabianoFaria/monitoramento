<?php

/* verifica se esta definido o path */
if (! defined('EFIPATH')) exit();

/* carrega as configuracoes de sim */
$nova_url = $modelo->confParamentroGrafico();

/* carrega os parametros */
$retorno = $modelo->loadGraficoParam();

?>

<div class="container">
    <label class="tituloPagina">Gr&aacute;fico</label>
    <!-- lista de caminho -->
    <ol class="breadcrumb fontBreadCrumb">
        <li><a href="<?php echo HOME_URI; ?>/home/">Home</a></li>
        <li class="active">Gr&aacute;fico</li>
    </ol><!-- fim lista de caminho -->
</div>



<!-- scripts do grafico --> 
<script src="<?php echo HOME_URI; ?>/views/_js/highcharts/highcharts.js"></script>
<script src="<?php echo HOME_URI; ?>/views/_js/highcharts/highcharts-more.js"></script>


<script type="text/javascript">
    <?php if ($nova_url[4] == 1) { ?>
        /*
        $(function () {
            $(document).ready(function () {
                Highcharts.setOptions({
                    global: {
                        useUTC: false
                    }
                });
                /*
                 *      GRAFICO DE TENSAO
                 *

                $('#container').highcharts({
                    chart: {
                        type: 'spline',
                        animation: Highcharts.svg, // don't animate in old IE
                        marginRight: 10,
                        events: {
                            load: function () {
                                var urla =  "<?php echo HOME_URI;?>/classes/sincronizacaoGrafico/syncgrafico.php?sim=<?php echo $nova_url[0];?>&callback=?";
                                var valorAtual = 0;
                                // Inicia a variavel valorAtual com a primeira resposta do json
                                $.getJSON(urla,  function(data) {
                                    valorAtual = parseFloat(data[1]);
                                });

                                // set up the updating of the chart each second
                                var series = this.series[0];
                                setInterval(function () {
                                    // busca o valor da posicao atual
                                    $.getJSON(urla,  function(data) {
                                        // pega o valor atual retornado pelo json e seta na variavel
                                        valorAtual = parseFloat(data[1]);
                                    });

                                    // Escreve as posicoes
                                    var x = (new Date()).getTime(), // current time
                                        y = valorAtual;
                                    series.addPoint([x, y], true, true);
                                }, 30000);
                            }
                        }
                    },
                    title: {
                        text: 'Gráfico de tensão'
                    },
                    xAxis: {
                        type: 'datetime',
                        tickPixelInterval: 100
                    },
                    yAxis: {
                        title: {
                            text: 'Value'
                        },
                        plotLines: [{
                            value: 0,
                            width: 1,
                            color: '#808080'
                        }]
                    },
                    tooltip: {
                        formatter: function () {
                            return '<b>' + this.series.name + '</b><br/>' +
                                Highcharts.dateFormat('%d-%m-%Y %H:%M:%S', this.x) + '<br/><b>' +
                                Highcharts.numberFormat(this.y, 2) + ' (V)</b>';
                        }
                    },
                    legend: {
                        enabled: false
                    },
                    exporting: {
                        enabled: false
                    },
                    series: [{
                        name: 'Período',
                        data: (function () {
                            // endereco dos valores que retornam por array
                            // var urlb =  "class/iniciagrafico.php?callback=?";

                            // variavel que gerencia o contador
                            var a = 0;
                            var controle = parseInt('<?php echo $limite; ?>' - 1);
                            var b = controle;
                            var c = controle;

                            // array com a resposta da lista inicial
                            var datas = '<?php echo $strListaIni; ?>';
                            // Quebra a lista em um array
                            datas = datas.split("|");

                            // array que armazena as datas convertidas em numerico 
                            var guardaData = new Array();
                            var guardaValor = new Array();

                            // loop que converte e armazena as datas
                            // Pares data
                            // Impares valor do ponto no grafico
                            while (a < datas.length)
                            {
                                var resulMod = eval(a%2);
                                if (resulMod == 0)
                                {
                                    // quebra a data em uma array
                                    var dataMod = datas[a].split(/\-|\s/);
                                    // converte a data para o formato padrao
                                    var dat = new Date(dataMod.slice(0,3).reverse().join('/')+' '+dataMod[3]);
                                    // transforma a data em numerico
                                    var convertToTime = (new Date(dat)).getTime();
                                    // armazenar o valor convertido na array
                                    guardaData[b] = convertToTime;
                                    b--;
                                }
                                else if (resulMod == 1)
                                {
                                    guardaValor[c] = datas[a];
                                    c--;
                                }
                                a++;
                            }

                            var data = [],
                                time = (new Date()).getTime(),
                                i;

                            // reinicia a variavel
                            var b = 0;
                            var pont = guardaValor.length - 1;

                            for (i = -pont ; i < 0; i++) {
                                var dataConvertida = parseInt(guardaData[b]);

                                data.push({
                                    x: dataConvertida + i * 1000,
                                    y: parseFloat(guardaValor[b])
                                });
                                b++;
                            }
                            return data;
                        }())
                    }]
                });
            });
        }); */
    
    
    
    $(function () {
        $('#container').highcharts({
            chart: {
                type: 'spline'
            },
            title: {
                text: 'Gráfico de tensão'
            },
            subtitle: {
                text: ''
            },
            xAxis: {
                type: 'datetime',
                dateTimeLabelFormats: { // don't display the dummy year
                    month: '%e. %b',
                    year: '%b'
                },
                title: {
                    text: 'Período'
                }
            },
            yAxis: {
                title: {
                    text: 'Tensão em ( V )'
                },
                min: 0
            },
            tooltip: {
                headerFormat: '<b>{series.name}</b><br>',
                pointFormat: '{point.x:%e. %b}: {point.y:.2f} (v)'
            },

            plotOptions: {
                spline: {
                    marker: {
                        enabled: true
                    }
                }
            },


            series: [{
                name: 'Grafico Bateria',
                // Define the data points. All series have a dummy year
                // of 1970/71 in order to be compared on the same x axis. Note
                // that in JavaScript, months start at 0 for January, 1 for February etc.
                data: [
                    <?php

                        // carrega os dados
                        $cValor = $listaIni->carregaValorTri();

                        // quebra os dados do array e monta
                        for ($a=0;$a<sizeof($cValor);$a++)
                        {
                            echo $cValor[$a].",";
                            if ($a == (sizeof($cValor) - 1))
                                echo $cValor[$a];
                        }

                    ?>
                ]
            }, /*{
                name: 'E',
                data: [
                    [Date.UTC(1970,  9, 18), 0   ],
                    [Date.UTC(1971,  5,  7), 0   ]
                ]
            }*, /*{
                name: 'D',
                data: [
                    [Date.UTC(1970,  9,  9), 0   ],
                    [Date.UTC(1971,  4, 21), 0   ]
                ]
            }*/]
        });
    });
    
    
    
    
        <?php } if ($nova_url[1] == 1) { ?>
        
        /*
         *
         *      MEDIDOR DE TENSAO ANALOGICO DA BATERIA
         *
         */
        $(function () {
            $('#containerBat').highcharts({
                chart: {
                    type: 'gauge',
                    plotBorderWidth: 0,
                    plotBackgroundColor: {
                        linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
                        stops: [
                            [0, '#fff'],
                            [0.3, '#fff'],
                            [1, '#fff']
                        ]
                    },
                    plotBackgroundImage: null,
                    height: 210 // altura do painel
                },

                title: {
                    text: 'Medidor da Bateria Analógico'
                },

                pane: [{
                    startAngle: -45,
                    endAngle: 45,
                    background: null,
                    center: ['50%', '145%'],
                    size: 285 // tamanho do painel
                }],

                yAxis: [{
                    min: 0,
                    max: <?php echo $retorno[12]; ?>,
                    minorTickPosition: 'outside',
                    tickPosition: 'outside',
                    labels: {
                        rotation: 'auto',
                        distance: 20
                    },
                    plotBands: [{
                        from: 0,
                        to: <?php echo $retorno[13]; ?>,
                        color: '#DF5353' // red
                    }, {
                        from: <?php echo $retorno[13]; ?>,
                        to: <?php echo $retorno[14]; ?>,
                        color: '#DDDF0D' // yellow
                    }, {
                        from: <?php echo $retorno[14]; ?>,
                        to: <?php echo $retorno[15]; ?>,
                        color: '#55BF3B' // green
                    }, {
                        from: <?php echo $retorno[15]; ?>,
                        to: <?php echo $retorno[16]; ?>,
                        color: '#DF5353' // red
                    }],
                    pane: 0,
                    title: {
                        text: '<br/><span style="font-size:20px">Bateria</span>',
                        y: -40
                    }
                }],
                plotOptions: {
                    gauge: {
                        dataLabels: {
                            enabled: false
                        },
                        dial: {
                            radius: '100%'
                        }
                    }
                },
                series: [{
                    data: [0],
                    yAxis: 0
                }]
            },

            // Let the music play
            function (chart) {
                var valor = 0;
                setInterval(function () {
                    if (chart.series) { // the chart may be destroyed
                        var url =  "<?php echo HOME_URI; ?>/classes/sincronizacaoGrafico/syncBat.php?sim=<?php echo $nova_url[0];?>&callback=?";
                        $.getJSON(url,  function(data) {
                            valor = parseFloat(data[0]);
                        });

                        var left = chart.series[0].points[0],
                            leftVal,
                            inc = valor;
                        
                        leftVal =  inc;
                        //rightVal = inc;

                        if (leftVal <= 0) {
                            leftVal = 0;
                            $("#sit-bat").removeClass('situacaoLigado');
                            $("#sit-bat").addClass('situacaoDesligado');
                            document.getElementById('sit-bat').innerHTML = 'Bateria não OK';
                        }
                        else if (leftVal > <?php echo $retorno[16]; ?>) {
                            leftVal = <?php echo $retorno[16]; ?> // alterar para panes
                            $("#sit-bat").removeClass('situacaoDesligado');
                            $("#sit-bat").addClass('situacaoLigado');
                            document.getElementById('sit-bat').innerHTML = 'OK';
                        } else {
                            $("#sit-bat").removeClass('situacaoDesligado');
                            $("#sit-bat").addClass('situacaoLigado');
                            document.getElementById('sit-bat').innerHTML = 'Bateria OK';
                        }

                        left.update(leftVal, false);
                        document.getElementById('bat_v').innerHTML = leftVal + " ( v )";
                        chart.redraw();
                    }
                }, 2000);
            });
        });

        <?php } if ($nova_url[2] == 1) { ?>
        
        /*
         *
         *      MEDIDOR DE TENSAO ANALOGICO DE ENTRADA
         *
         */
        $(function () {
            $('#containerTensaEntrada').highcharts({
                chart: {
                    type: 'gauge',
                    plotBorderWidth: 0,
                    plotBackgroundColor: {
                        linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
                        stops: [
                            [0, '#fff'],
                            [0.3, '#fff'],
                            [1, '#fff']
                        ]
                    },
                    plotBackgroundImage: null,
                    height: 210 // altura do painel
                },

                title: {
                    text: 'Medidor de Entrada Analógico'
                },

                pane: [{
                    startAngle: -45,
                    endAngle: 45,
                    background: null,
                    center: ['50%', '145%'],
                    size: 285 // tamanho do painel
                }],

                yAxis: [{
                    min: 0,
                    max: <?php echo $retorno[0]; ?>,
                    minorTickPosition: 'outside',
                    tickPosition: 'outside',
                    labels: {
                        rotation: 'auto',
                        distance: 20
                    },
                    plotBands: [{
                        from: 0,
                        to: <?php echo $retorno[1]; ?>,
                        color: '#DF5353' // red
                    }, {
                        from: <?php echo $retorno[1]; ?>,
                        to: <?php echo $retorno[2]; ?>,
                        color: '#DDDF0D' // yellow
                    }, {
                        from: <?php echo $retorno[2]; ?>,
                        to: <?php echo $retorno[3]; ?>,
                        color: '#55BF3B' // green
                    }, {
                        from: <?php echo $retorno[3]; ?>,
                        to: <?php echo $retorno[4]; ?>,
                        color: '#DDDF0D' // yellow
                    }, {
                        from: <?php echo $retorno[4]; ?>,
                        to: <?php echo $retorno[5]; ?>,
                        color: '#DF5353' // red
                    }],
                    pane: 0,
                    title: {
                        text: '<br/><span style="font-size:20px">Entrada</span>',
                        y: -40
                    }
                }],
                plotOptions: {
                    gauge: {
                        dataLabels: {
                            enabled: false
                        },
                        dial: {
                            radius: '100%'
                        }
                    }
                },
                series: [{
                    data: [0],
                    yAxis: 0
                }]
            },

            // Let the music play
            function (chart) {
                var valor = 0;
                setInterval(function () {
                    if (chart.series) { // the chart may be destroyed
                        var url =  "<?php echo HOME_URI; ?>/classes/sincronizacaoGrafico/syncEntradaSaida.php?sim=<?php echo $nova_url[0];?>&entrada=1&callback=?";
                        $.getJSON(url,  function(data) {
                            valor = parseFloat(data[0]);
                        });

                        var left = chart.series[0].points[0],
                            //right = chart.series[1].points[0],
                            leftVal,
                            //rightVal,
                            inc = valor;
                        
                        leftVal =  inc;
                        //rightVal = inc;
                        
                        if (leftVal <= 0) {
                            leftVal = 0;
                            $("#sit-ent").removeClass('situacaoLigado');
                            $("#sit-ent").addClass('situacaoDesligado');
                            document.getElementById('sit-ent').innerHTML = 'Desligado';
                        }
                        else if (leftVal > <?php echo $retorno[6]; ?>) {
                            leftVal = <?php echo $retorno[6]; ?> // alterar para panes
                            $("#sit-ent").removeClass('situacaoDesligado');
                            $("#sit-ent").addClass('situacaoLigado');
                            document.getElementById('sit-ent').innerHTML = 'Ligado';
                        } else {
                            $("#sit-ent").removeClass('situacaoDesligado');
                            $("#sit-ent").addClass('situacaoLigado');
                            document.getElementById('sit-ent').innerHTML = 'Ligado';
                        }
                        left.update(leftVal, false);
                        document.getElementById('bat_e').innerHTML = leftVal + " ( v )";
                        chart.redraw();
                    }
                }, 2000);
            });
        });

        <?php } if ($nova_url[3] == 1) { ?>    
    
        /*
         *
         *      MEDIDOR DE TENSAO ANALOGICO DE SAIDA
         *
         */
        $(function () {
            $('#containerTensaSaida').highcharts({
                chart: {
                    type: 'gauge',
                    plotBorderWidth: 0,
                    plotBackgroundColor: {
                        linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
                        stops: [
                            [0, '#fff'],
                            [0.3, '#fff'],
                            [1, '#fff']
                        ]
                    },
                    plotBackgroundImage: null,
                    height: 210 // altura do painel
                },

                title: {
                    text: 'Medidor de Saída Analógico'
                },

                pane: [{
                    startAngle: -45,
                    endAngle: 45,
                    background: null,
                    center: ['50%', '145%'],
                    size: 285 // tamanho do painel
                }],

                yAxis: [{
                    min: 0,
                    max: <?php echo $retorno[6]; ?>,
                    minorTickPosition: 'outside',
                    tickPosition: 'outside',
                    labels: {
                        rotation: 'auto',
                        distance: 20
                    },
                    plotBands: [{
                        from: 0,
                        to: <?php echo $retorno[7]; ?>,
                        color: '#DF5353' // red
                    }, {
                        from: <?php echo $retorno[7]; ?>,
                        to: <?php echo $retorno[8]; ?>,
                        color: '#DDDF0D' // yellow
                    }, {
                        from: <?php echo $retorno[8]; ?>,
                        to: <?php echo $retorno[9]; ?>,
                        color: '#55BF3B' // green
                    }, {
                        from: <?php echo $retorno[9]; ?>,
                        to: <?php echo $retorno[10]; ?>,
                        color: '#DDDF0D' // yellow
                    }, {
                        from: <?php echo $retorno[10]; ?>,
                        to: <?php echo $retorno[11]; ?>,
                        color: '#DF5353' // red
                    }],
                    pane: 0,
                    title: {
                        text: '<br/><span style="font-size:20px">Saída</span>',
                        y: -40
                    }
                }],
                plotOptions: {
                    gauge: {
                        dataLabels: {
                            enabled: false
                        },
                        dial: {
                            radius: '100%'
                        }
                    }
                },
                series: [{
                    data: [0],
                    yAxis: 0
                }]
            },

            // Let the music play
            function (chart) {
                var valor = 0;
                setInterval(function () {
                    if (chart.series) { // the chart may be destroyed
                        var url =  "<?php echo HOME_URI; ?>/classes/sincronizacaoGrafico/syncEntradaSaida.php?entrada=2&sim=<?php echo $nova_url[0];?>&callback=?";
                        $.getJSON(url,  function(data) {
                            valor = parseFloat(data[0]);
                        });

                        var left = chart.series[0].points[0],
                            //right = chart.series[1].points[0],
                            leftVal,
                            //rightVal,
                            inc = valor;

                        leftVal =  inc;
                        //rightVal = inc;

                        if (leftVal <= 0) {
                            leftVal = 0;
                            $("#sit-sai").removeClass('situacaoLigado');
                            $("#sit-sai").addClass('situacaoDesligado');
                            document.getElementById('sit-sai').innerHTML = 'Desligado';
                        }
                        else if (leftVal > <?php echo $retorno[11]; ?>) {
                            leftVal = <?php echo $retorno[11]; ?> // alterar para panes
                            $("#sit-sai").removeClass('situacaoDesligado');
                            $("#sit-sai").addClass('situacaoLigado');
                            document.getElementById('sit-sai').innerHTML = 'Ligado';
                        } else {
                            $("#sit-sai").removeClass('situacaoDesligado');
                            $("#sit-sai").addClass('situacaoLigado');
                            document.getElementById('sit-sai').innerHTML = 'Ligado';
                        }
                        left.update(leftVal, false);
                        document.getElementById('bat_s').innerHTML = leftVal + " ( v )";
                        chart.redraw();
                    }
                }, 2000);
            });
        });
    <?php } ?>
</script>


<div class="container">
    
    <!-- grafico -->
    <div class="row">
        
        <?php if ($nova_url[4] == 1) { ?>
        <div class="col-md-12">
            <div id="container" style="min-width: 291px; height: 311px; margin-left: -15px;"></div>
        </div>

        <?php } if ($nova_url[1] == 1) { ?>

        <!-- bateria -->
        <div class="col-md-4">
            <div id="containerBat" style="width: 100%; margin: 0 auto"></div>
            <label id="bat_v" class="valorVindo">0 ( v )</label>
            <div id="sit-bat" class="situacaoDesligado">Carregando...</div>
        </div>

        <?php } if ($nova_url[2] == 1) { ?>
        
        <!-- entrada -->
        <div class="col-md-4">
            <div id="containerTensaEntrada" style="width: 100%; margin: 0 auto"></div>
            <label id="bat_e" class="valorVindo">0 ( v )</label>
            <div id="sit-ent" class="situacaoDesligado">Carregando...</div>
        </div>

        <?php } if ($nova_url[3] == 1) { ?>
        
        <!-- saida -->
        <div class="col-md-4">
            <div id="containerTensaSaida" style="width:100%; margin: 0 auto"></div>
            <label id="bat_s" class="valorVindo">0 ( v )</label>
            <div id="sit-sai" class="situacaoDesligado">Carregando...</div>
        </div>
        <?php } ?>
        
    </div><!-- grafico analogico -->
    
    
    
</div>
