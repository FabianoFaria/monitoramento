<?php

// Verifica se esta definido o path
if (! defined('EFIPATH')) exit();

// Aqui está sendo simplificado o processo de coleta de dados do equipamento para geração de gráficos
$dadosEquipamento   = $modeloEquip->dadosEquipamentoCliente($this->parametros[0]);
$dadosEquipamento   = $dadosEquipamento['equipamento'][0];

$dadosCliente       = $modeloClie->carregarDadosCliente($dadosEquipamento['id_cliente']);
$dadosCliente       = $dadosCliente['dados'][0];

?>

<script>

    /*
    * REFORMULAÇÂO DO GRÁFICO
    */

    <?php

        // var_dump($modelo->respData);
        //
        // var_dump($modelo->respDate);
        //
        //var_dump($modelo->respRawDate);
        //
        // var_dump($modelo->respDiference);

        $parametrosSelecionados = $modelo->respData;

        $dataMedida = str_replace("[",",",$modelo->respDate);
        $dataMedida = str_replace("]",",",$dataMedida);
        $dataMedida = explode(",",$dataMedida);
        //$dataMedida = $modelo->respData;

        $testeJon  =    $modelo->respData;



    //VERIFICA SE EXITEM DADOS PARA SEREM EXIBIDOS DO EQUIPAMENTO SELECIONADO
    if($modelo->respDate != "[]"){

    ?>
            $(function() {

            //var d = [[1196463600000, 0], [1196550000000, 0], [1196636400000, 0], [1196722800000, 77], [1196809200000, 3636], [1196895600000, 3575], [1196982000000, 2736], [1197068400000, 1086], [1197154800000, 676], [1197241200000, 1205], [1197327600000, 906], [1197414000000, 710], [1197500400000, 639], [1197586800000, 540], [1197673200000, 435], [1197759600000, 301], [1197846000000, 575], [1197932400000, 481], [1198018800000, 591], [1198105200000, 608], [1198191600000, 459], [1198278000000, 234], [1198364400000, 1352], [1198450800000, 686], [1198537200000, 279], [1198623600000, 449], [1198710000000, 468], [1198796400000, 392], [1198882800000, 282], [1198969200000, 208], [1199055600000, 229], [1199142000000, 177], [1199228400000, 374], [1199314800000, 436], [1199401200000, 404], [1199487600000, 253], [1199574000000, 218], [1199660400000, 476], [1199746800000, 462], [1199833200000, 448], [1199919600000, 442], [1200006000000, 403], [1200092400000, 204], [1200178800000, 194], [1200265200000, 327], [1200351600000, 374], [1200438000000, 507], [1200524400000, 546], [1200610800000, 482], [1200697200000, 283], [1200783600000, 221], [1200870000000, 483], [1200956400000, 523], [1201042800000, 528], [1201129200000, 483], [1201215600000, 452], [1201302000000, 270], [1201388400000, 222], [1201474800000, 439], [1201561200000, 559], [1201647600000, 521], [1201734000000, 477], [1201820400000, 442], [1201906800000, 252], [1201993200000, 236], [1202079600000, 525], [1202166000000, 477], [1202252400000, 386], [1202338800000, 409], [1202425200000, 408], [1202511600000, 237], [1202598000000, 193], [1202684400000, 357], [1202770800000, 414], [1202857200000, 393], [1202943600000, 353], [1203030000000, 364], [1203116400000, 215], [1203202800000, 214], [1203289200000, 356], [1203375600000, 399], [1203462000000, 334], [1203548400000, 348], [1203634800000, 243], [1203721200000, 126], [1203807600000, 157], [1203894000000, 288]];

            // first correct the timestamps - they are recorded as the daily
            // midnights in UTC+0100, but Flot always displays dates in UTC
            // so we have to add one hour to hit the midnights in the plot

            // for (var i = 0; i < d.length; ++i) {
            // 	d[i][0] += 60 * 60 * 1000;
            // }
            function getFormattedDate(x) {
                var date = new Date(x * 1000);

                var month = date.getMonth();
                var day = date.getDate();
                var hour = date.getHours();
                var min = date.getMinutes();
                var sec = date.getSeconds();

                month = (month < 10 ? "0" : "") + month;
                day = (day < 10 ? "0" : "") + day;
                hour = (hour < 10 ? "0" : "") + hour;
                min = (min < 10 ? "0" : "") + min;
                sec = (sec < 10 ? "0" : "") + sec;

                var str =  day + "-" + month + "-" + date.getFullYear() + " " +  hour + ":" + min + ":" + sec;

                /*alert(str);*/

                return str;
            }

            // helper for returning the weekends in a period

            var axisMax = 0;
            var axisMin = 0;

            function weekendAreas(axes) {

                var markings = [],
                    d = new Date(<?php echo $dataMedida[1]; ?> * 1000);

                // go to the first Saturday
                //A CADA 2 DIAS CRIA UMA MARCAÇÃO
                d.setUTCDate(d.getUTCDate() - ((d.getUTCDay() + 1) % 7))
                d.setUTCSeconds(0);
                d.setUTCMinutes(0);
                d.setUTCHours(0);

                var i = d.getTime();

                // when we don't set yaxis, the rectangle automatically
                // extends to infinity upwards and downwards

                do {
                    markings.push({ xaxis: { from: i, to: i + 2 * 24 * 60 * 60 * 1000 } });
                    i += 7 * 24 * 60 * 60 * 1000;

                } while (i < axes.xaxis.max);

                return markings;
            }

            var options = {
                xaxis: {
                    show : true,
                    mode : "time",
                    timeformat: "<div class='dateLabel'>%d / %m / %y <br /> %H:%M:%S</div>",
                    timezone: "America/Sao_Paulo",
                    /*
                        Como o xaxis está em milisegundos, nada mais certo que configurar o zoomRange em milisegundos também
                    */
                    // set the lowest (zoomed all the way in) range on the x axis to 2 hours
                    zoomRange: [60000, 600000000],
                    // set the pan limits slightly outside the data range
                    //panRange: [axisMin*0.9, axisMax*1.1]
    			},
    			yaxis: {
                    zoomRange: [1, 250],
				    panRange: [-5, 230]
                    // set the lowest range on the y-axis to 5 dollars
                    // zoomRange: [5, null],
                    // // set the pan limits slightly outside the data range
                    // panRange: [30, 90]
    			},
                // selection: {
                //     mode: "xy"
                // },
                grid: {
                    hoverable: true,
                    markings: weekendAreas
                },
                series: {
                    lines: {
                        show: true
                    },
                    points: {
                        show: true
                    }
                },
    			zoom: {
    				interactive: true
    			},
    			pan: {
    				interactive: true
    			}
                // ,
                // legend:{
                //      margin:30,
                //     container: $("#legendPlace")
                // }
            };

            var plot = $.plot("#placeholder", [
                //{   //data: d, label: "sin(x)"
                    <?php
                        foreach ($testeJon as $jon) {

                            $amostra = explode("data:", $jon[0]);

                            $nomeSerie = $amostra[0];

                            $nomeSerie = str_replace("{name:'"," ",$nomeSerie);
                            $nomeSerie = str_replace("',"," ",$nomeSerie);

                            $amostra = str_replace("]"," ",$amostra[1]);
                            $amostra = str_replace("["," ",$amostra);
                            $amostra = str_replace("}"," ",$amostra);

                            $dataAmostra = explode(",",$amostra);

                            //Inicia a montagem da série
                            $i     = 0;
                            $j     = 0;
                            $serie = "[";



                            foreach ($dataAmostra as $valorX) {
                                $i++;
                                $j++;
                                // if($j == 60){
                                //     $serie .= "[".$dataMedida[$i].",".$valorX."],";
                                //     $j = 0;
                                // }
                                $dataTemp = gmdate("d-m-Y H:i:s", $modelo->respRawDate[($i - 1)]);
                                //
                                $datahora = explode(" ", $dataTemp);
                                $dias     = explode("-", $datahora[0]);
                                $horas    = explode(":", $datahora[1]);
                                // [Date.UTC(2011, 2, 12, 14, 0, 0), 28],

                                 $serie .= "[ Date.UTC(".$dias[2].", ".($dias[1] - 1).", ".$dias[0].", ".($horas[0] - 3).", ".$horas[1].", ".$horas[2]."),".$valorX."],";
                                 //var_dump(gmdate("d-m-Y H:i:s", $dataMedida[$i]));
                                 //var_dump($dataMedida[$i]);
                            }
                            $serie .= "]";

                            // var_dump($serie);
                            // var_dump($nomeSerie);
                            ?>
                        {    data : <?php echo $serie; ?>, label : "<?php echo $nomeSerie; ?>" },
                            <?php
                        }
                    ?>
                //}
            ], options);

            //Trata a implementação da tooltip

            $("<div id='tooltip' class='panel panel-info'></div>").css({
                position: "absolute",
                display: "none",
                //border: "1px solid #fdd",
                padding: "2px",
                //"background-color": "#fee",
                opacity: 0.80
            }).appendTo("body");

            $("#placeholder").bind("plothover", function (event, pos, item) {

                if (item) {
                    var x = item.datapoint[0],
                        y = item.datapoint[1].toFixed(2);

                    var date = new Date(x);
                    var year = date.getFullYear();
                    var month = date.getMonth() + 1;
                    if(month < 10){
                        month = "0"+month;
                    }

                    var day = date.getDate();
                    if(day < 10){
                        day = "0"+day;
                    }

                    //var hour = date.getHours();
                    var hour = date.getHours() + 3;
                    var min = date.getMinutes();
                    if(min < 10){
                        min = "0"+min;
                    }
                    var sec = date.getSeconds();
                    if(sec < 10){
                        sec = "0"+sec;
                    }

                    if(hour > 23){
                        hour = hour - 24;
                    }

                    var tipoMedidaTemp = item.series.label.split(" ");
                    var tipoMedida     = tipoMedidaTemp[1];
                    var notacaoToolTip = "";
                    
                    if(tipoMedida == "Bateria"){
                        notacaoToolTip = "(V)";
                    }
                    else if(tipoMedida == "Corrente"){
                        notacaoToolTip = "(A)";
                    }else{
                        notacaoToolTip = "(V)";
                    }

                    $("#tooltip").html("<p>"+item.series.label + " " + day +"/"+month+"/"+year+" às "+hour+":"+min+":"+sec+"</p><p><b>"+y+" "+notacaoToolTip+"</b></p>")
                    .css({top: item.pageY+5, left: item.pageX+5})
                    .fadeIn(200);
                } else {
                    $("#tooltip").hide();
                }

            });

            /*
                Overview sendo colocado em desuso
            */
            // var overview = $.plot("#overview",
            //     [
            //         <?php
            //             foreach ($testeJon as $jon) {
            //
            //                 $amostra = explode("data:", $jon[0]);
            //
            //                 $nomeSerie = $amostra[0];
            //
            //                 $nomeSerie = str_replace("{name:'"," ",$nomeSerie);
            //                 $nomeSerie = str_replace("',"," ",$nomeSerie);
            //
            //                 $amostra = str_replace("]"," ",$amostra[1]);
            //                 $amostra = str_replace("["," ",$amostra);
            //                 $amostra = str_replace("}"," ",$amostra);
            //
            //                 $dataAmostra = explode(",",$amostra);
            //
            //                 //Inicia a montagem da série
            //                 $i     = 0;
            //                 $j     = 0;
            //                 $serie = "[";
            //                 foreach ($dataAmostra as $valorX) {
            //                     $i++;
            //                     $j++;
            //                     /*
            //                     * Devido ao fato de exitir registros no BD a cada 30 segundos, foi implementado esse código para exibir no gráfico somente leituras a cada 1 min
            //                     */
            //                     // if($j == 60){
            //                     //     $serie .= "[".$dataMedida[$i].",".$valorX."],";
            //                     //     $j = 0;
            //                     // }
            //
            //                     $dataTemp = gmdate("d-m-Y H:i:s", $modelo->respRawDate[($i - 1)]);
            //                     //
            //                     $datahora = explode(" ", $dataTemp);
            //                     $dias     = explode("-", $datahora[0]);
            //                     $horas    = explode(":", $datahora[1]);
            //                     // [Date.UTC(2011, 2, 12, 14, 0, 0), 28],
            //
            //                     $serie .= "[ Date.UTC(".$dias[2].", ".($dias[1] - 1).", ".$dias[0].", ".($horas[0] - 3).", ".$horas[1].", ".$horas[2]."),".$valorX."],";
            //
            //
            //                     //$serie .= "[".$dataMedida[$i].",".$valorX."],";
            //
            //                     //$valorX
            //
            //                 }
            //                 $serie .= "]";
            //
            //                 // var_dump($serie);
            //                 // var_dump($nomeSerie);
            //                 ?>
            //             {    data : <?php //echo $serie; ?>, label : "<?php //echo $nomeSerie; ?>"},
            //                 <?php
            //             }
            //         ?>
            //     ],
            //     {
            //     series: {
            //         lines: {
            //             show: true,
            //             lineWidth: 1
            //         },
            //         shadowSize: 0
            //     },
            //     xaxis: {
            //         ticks: [],
            //         // mode: "time",
            //         timezone: "America/Sao_Paulo"
            //     },
            //     yaxis: {
            //         ticks: [],
            //         min: 0,
            //         autoscaleMargin: 0.1
            //     }
            //     // ,
            //     // selection: {
            //     //     mode: "x"
            //     // }
            // });

            // now connect the two

            $("#placeholder").bind("plotselected", function (event, ranges) {

                // do the zooming
                $.each(plot.getXAxes(), function(_, axis) {
                    var opts = axis.options;
                    opts.min = ranges.xaxis.from;
                    opts.max = ranges.xaxis.to;
                });
                plot.setupGrid();
                plot.draw();
                plot.clearSelection();

                // don't fire event on the overview to prevent eternal loop

                //overview.setSelection(ranges, true);
            });


            // $("#overview").bind("plotselected", function (event, ranges) {
            //     plot.setSelection(ranges);
            // });

        });
    <?php
    }

    ?>


    // gerenciador de link
    var menu = document.getElementById('listadir');
    menu.innerHTML = '<a href="<?php echo HOME_URI; ?>/home/" class="linkMenuSup">Home</a> / ' +
                    '<a href="<?php echo HOME_URI; ?>/grafico/" class="linkMenuSup">Relatôrio</a> / ' +
                    '<a href="<?php echo HOME_URI; ?>/grafico/listaFilial/<?php echo $dadosEquipamento['id_cliente']; ?>"> Cliente : <?php echo $dadosCliente['nome']; ?></a>' +
                    '/<a href="<?php echo HOME_URI; ?>/grafico/opcaoVisualizacao/<?php echo $this->parametros[0]; ?>"> Equipamento : <?php echo $dadosEquipamento['tipoEquip']." ".$dadosEquipamento['nomeModeloEquipamento']; ?> </a>';
</script>

<!-- scripts do grafico -->
<script src="<?php echo HOME_URI; ?>/views/_js/highcharts/highcharts.js"></script>
<script src="<?php echo HOME_URI; ?>/views/_js/highcharts/highcharts-more.js"></script>


<?php

    $infoCli = $modelo->buscaDadosClinte($this->parametros[0]);

?>

<div class="container-fluid">

    <!-- Valida se há dados para serem exibido -->
    <?php

        //
        //var_dump($modelo->respDiference);
        // echo $modelo->respDiference->format("%R%a days");

        //var_dump($modelo->respDate);

        if($modelo->respDate != "[]"){
            ?>
            <!-- <div class="row">
                <div class="col-md-12">
                    <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
                </div>
            </div> -->

            <div class="row">
                <h4 class="text-header"> Gráfico com os dados gerados pelo equipamento</h4>
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <?php
                                echo $dadosEquipamento['tipoEquip']." ";
                                echo $dadosEquipamento['nomeModeloEquipamento']." ";
                                //echo $dadosEquipamento['modelo'];
                            ?>
                        </div>
                        <div class="panel-body">

                            <div class="row">
                                <div class="demo-container">
                                    <div id="placeholder" class="demo-placeholder col-md-12" style="height:510px;background-color:#ffffff;">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div id="legendPlace" class="col-md-12">

                                </div>
                            </div>
                            <!-- Gráfico de #overview caiu em desuso pois se mostrou desnecessario para o atual formato do gráfico -->
                            <!-- <div class="row">
                                <div class="col-md-1"></div>
                                <div id="overview" class="col-md-10" style="margin-top:30px;height:150px;background-color: #635757cc;color:#ffffff;">


                                </div>
                                <div class="col-md-1"></div>
                            </div> -->




                        </div>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="well">
                        <p class="message"></p>

                        <p class="text-left"><i class="fa fa-dribbble -up fa-1x"></i> Roda do mouse : Zoom +, Zoom -</p>
                        <p class="text-left"><i class="fa fa-hand-o-up fa-1x"></i> Botão principal do mouse : Arrastar gráfico</p>

                    </div>

                </div>
                <div class="col-md-6">
                </div>
            </div>

            <?php

        }else{

            //Mensagem de aviso caso o equipamento não possua nenhum dado geristrado
            ?>

                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-yellow">
                          <div class="panel-heading">
                               <i class='fa fa-exclamation-triangle  fa-2x' style='color:red'></i>  Nenhum dado encontrado!
                          </div>
                          <div class="panel-body">
                              <p>O equipamento ou o período selecionado, não retornou nenhum dado. Favor selecionar outro equipamento ou período de tempo.</p>
                              <p>
                                  <a href="<?php echo HOME_URI ?>/grafico/listaFilial/<?php echo $dadosEquipamento['id_cliente']; ?>">Escolher outro equipamento.</a>
                              </p>
                              <p>
                                  <a href="<?php echo HOME_URI ?>/grafico/opcaoVisualizacao/<?php echo $this->parametros[0]; ?>">Escolher outro período.</a>
                              </p>
                          </div>
                          <div class="panel-footer">

                          </div>
                      </div>
                    </div>
                </div>

            <?php
        }

     ?>

</div>
