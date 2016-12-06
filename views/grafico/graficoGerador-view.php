<?php

// Verifica se esta definido o path
if (! defined('EFIPATH')) exit();

?>

<script>
    $(function () {
        $('#container').highcharts({
            title: {
                text: 'Grafico de tempo',
                x: -20 //center
            },
            subtitle: {
                text: '',
                x: -20
            },
            xAxis: {
                categories:
                <?php
                    echo $modelo->respDate;
                ?>
            },
            yAxis: {
                title: {
                    text: ''
                },
                plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                }]
            },
            
            tooltip: {
                valueSuffix: '(V)'
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'middle',
                borderWidth: 1
            },
                plotOptions: {
                spline: {
                    lineWidth: 2,
                    states: {
                        hover: {
                            lineWidth: 10
                        }
                    },
                    marker: {
                        enabled: true
                    }
                }
            },
            series: [
                <?php
                    $guarda = "";
                    foreach($modelo->respData as $row)
                    {
                        $guarda .= $row[0].",";
                    }
                    $guarda .= ".";
                    $guarda = str_replace(",.","",$guarda);
                    echo $guarda;
                ?>
            ]
        });
    });

    
    
    
    // gerenciador de link
    var menu = document.getElementById('listadir');
    menu.innerHTML = '<a href="<?php echo HOME_URI; ?>/home/" class="linkMenuSup">Home</a> / ' + 
                     '<a href="<?php echo HOME_URI; ?>/grafico/" class="linkMenuSup">Gr&aacute;fico</a>';
</script>

<!-- scripts do grafico --> 
<script src="<?php echo HOME_URI; ?>/views/_js/highcharts/highcharts.js"></script>
<script src="<?php echo HOME_URI; ?>/views/_js/highcharts/highcharts-more.js"></script>


<?php

$infoCli = $modelo->buscaDadosClinte ($this->parametros[0]);

?>

<div class="container-fluid">

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
                <?php 
                    echo $infoCli['nomeEquip'];
                    echo $infoCli['nomeFabri'];
                    echo $infoCli['modeloEquip'];
                ?>
            </label>
        </div><!-- Fim Informacoes Equipamento -->
    </div><!-- Fim Dados do cliente -->


    <div class="row">
        <div class="col-md-12">
            <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
        </div>
    </div>
</div>













