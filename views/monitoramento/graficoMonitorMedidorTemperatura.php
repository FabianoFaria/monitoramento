<?php

    //INICIA CLASS DA LISTA INICAL
    $parametroListaIni  = array();
    array_push($parametroListaIni, $idSim);
    $limite             = 30;
    $listaIni           = new ListaInicial($limite, $this->db, $parametroListaIni);

    // CARREGA OS PARAMETROS CONFIGURADOS PARA O EQUIPAMENTO
    //$retorno = $modelo->loadGraficoParam($idEquip, $idSimEquip, $idSim);

    $retorno = $modelo->loadGraficoParamMedidorTemp($idEquip, $idSimEquip, $idSim);


    //var_dump($retorno);
    if (empty($retorno) && isset($retorno))
    {
        // Caso nao exista valor
        // Apresenta mensagem e link informando que nao ha resultado
        echo "<div class='mensagem-semvalor'>
                <label class='mensagem-texto'>Verifique se os parametros est&atilde;o configurados.<br>
                    <a href='".HOME_URI."/configuracao/configurarEquipamentoCliente/".$this->parametros[0]."' class='link-mensagem'>Clique aqui para voltar</a>
                </label></div>";
    }else{

        // carrega os dados
        $cValor = $modelo->insereDadosGrafico($listaIni->carregaValorTri());
        $cValor2 = $modelo->insereDadosGrafico($listaIni->carregaValorTri("saida"));

        // Busca informacoes sobre o cliente e equipamento, alterando o parametro de '$nova_url[0]' para '$idSim'
        $infoCli = $modelo->buscaDadosClinte($idSim);

        //var_dump($infoCli);

        // Carrega a data, para realizar a comparacao de tempo ligado , alterando o parametro de '$nova_url[0]' para '$idSim'
        $respData = $modelo->verificaTempoOperacao($idSim);

        //var_dump($respData);

        // Variavel que monitora se existe data como parametro
        // Se existir desabilita os graficos do multimetro
        // Inicia a variavel
        $data_rel = 0;

        // Tamanho do grafico de linha
        $tamanho_grafico = "311px";

        // Verifica se existe os parametros da data, COMENTANDO DEVIDO A FATO DE ESSE TRECHO NÃO ESTAR SENDO UTILIZADO
        // if (isset($this->parametros[4]) && !empty($this->parametros[4]) && isset($this->parametros[5]) && !empty($this->parametros[5]))
        // {
        //     // Oculta os graficos de multimetro
        //     $data_rel = 1;
        //
        //     // Aumenta o tamanho do grafico
        //     $tamanho_grafico = "580px";
        // }

        //var_dump($this->parametros);

        ?>
            <script>
                // GERENCIADOR DE LINK NO TOPO DA PÁGINA
                var menu = document.getElementById('listadir');
                menu.innerHTML = '<a href="<?php echo HOME_URI; ?>/home/" class="linkMenuSup">Home</a> / ' +
                                 '<a href="<?php echo HOME_URI; ?>/monitoramento/" class="linkMenuSup">Monitoramento</a> / ' +
                                 '<a href="<?php echo HOME_URI; ?>/monitoramento/unidades/<?php echo $idClie ?>"> Unidade :<?php echo (isset($dadosEquipamento['filial'])) ? $dadosEquipamento['filial'] :"Matriz"; ?></a>' +
                                 '/<a href="<?php echo HOME_URI; ?>/monitoramento/gerarGrafico/<?php echo $this->parametros[0]; ?>"> <?php echo $equipamentoMonitorado; ?> </a>';
            </script>

            <!-- Custom CSS -->
            <link href="<?php echo HOME_URI; ?>/views/_css/grafics.css" rel="stylesheet" type="text/css">


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
        }else{

            //var_dump($cValor);

            // TABELA UTILIZADAS PARA TENSÃO E CORRENTE
            $tabela = array("b","c","d","e","f","g","i","j","l","m","n","o","p","q","r","s","t","u");
            $nomes = array ("tenperatura");

            $id = $idSim;

            //var_dump($dadosEquipamento);

            // 'tipo_entrada' => string '3' (length=1)
            // 'tipo_saida' => string '3' (length=1)
            //VERIFICA O TIPO DE SAIDA E ENTRADA PARA EXIBIR NA TELA
            $tipoEntrada    = $dadosEquipamento['tipo_entrada'];
            $tipoSaida      = $dadosEquipamento['tipo_saida'];

            ?>

            <script type="text/javascript">

                <?php
                    // LOOP PARA CRIAR O GRAFICO
                    for($p=0;$p < $tipoEntrada;$p++)
                    {
                        // COLETA OS DADOS
                        $dadosMoni = $modelo->carregaDadosGrafico($tabela[$p], $nomes[0], $id);
                        $dadosMoni = explode(";",$dadosMoni);


                    ?>
                        // EFETUA A BUSCA POR DADOS VIA JSON
                        $(function () {

                            var valor = 0;

                            setInterval(function () {


                                var url =  "<?php echo HOME_URI; ?>/classes/sincronizacaoGrafico/syncEntradaSaida.php?6e756d65726f=<?php echo $idSim;?>&656e7472616461=1&706f73546162656c61=<?php echo $tabela[$p];?>&callback=?";
                                $.getJSON(url,  function(data) {
                                    valor = parseFloat(data[0]);
                                });

                                // console.log('Teste : <?php echo $tabela[$p]; ?> '+valor+' ');

                                var inc = parseFloat(valor/100);
                                var valorPreciso = inc.toFixed(2);
                                var leftVal =  valorPreciso;

                                // VERIFICA SE A TEMPERATURA ESTÁ OU NÃO DE ACORDO COM OS PARAMETOS
                                if (leftVal <= 0) {

                                    leftVal = 0;
                                    $("#sit-cor-temp<?php echo $tabela[$p];?>").removeClass('situacaoLigado');
                                    $("#sit-cor-temp<?php echo $tabela[$p];?>").addClass('situacaoDesligado');

                                }else if(leftVal < <?php echo $retorno[0]; ?>){

                                    //console.log('Teste : <?php echo $retorno[0]; ?> '+leftVal+' ');
                                    $("#sit-cor-temp<?php echo $tabela[$p];?>").removeClass('situacaoLigado');
                                    $("#sit-cor-temp<?php echo $tabela[$p];?>").removeClass('situacaoAtencao');
                                    $("#sit-cor-temp<?php echo $tabela[$p];?>").addClass('situacaoDesligado well-blink');
                                    document.getElementById('sit-cor-temp<?php echo $tabela[$p];?>').innerHTML = 'Nível baixo!';
                                }else if(leftVal < <?php echo $retorno[1]; ?>){

                                    $("#sit-cor-temp<?php echo $tabela[$p];?>").removeClass('situacaoLigado');
                                    $("#sit-cor-temp<?php echo $tabela[$p];?>").removeClass('situacaoDesligado');
                                    $("#sit-cor-temp<?php echo $tabela[$p];?>").removeClass('well-blink');
                                    $("#sit-cor-temp<?php echo $tabela[$p];?>").addClass('situacaoAtencao');
                                    document.getElementById('sit-cor-temp<?php echo $tabela[$p];?>').innerHTML = 'Atenção';
                                }else if(leftVal > <?php echo $retorno[4]; ?>){

                                    leftVal = <?php echo $retorno[4]; ?> // alterar para panes
                                    $("#sit-cor-temp<?php echo $tabela[$p];?>").removeClass('situacaoLigado');
                                    $("#sit-cor-temp<?php echo $tabela[$p];?>").removeClass('situacaoAtencao');
                                    $("#sit-cor-temp<?php echo $tabela[$p];?>").addClass('situacaoDesligado');
                                    document.getElementById('sit-cor-temp<?php echo $tabela[$p];?>').innerHTML = 'Crítico!';
                                }else if((leftVal > <?php echo $retorno[3]; ?>) && (leftVal < <?php echo $retorno[4]; ?>)){

                                    $("#sit-cor-temp<?php echo $tabela[$p];?>").removeClass('situacaoLigado');
                                    $("#sit-cor-temp<?php echo $tabela[$p];?>").removeClass('situacaoDesligado');
                                    $("#sit-cor-temp<?php echo $tabela[$p];?>").removeClass('well-blink');
                                    $("#sit-cor-temp<?php echo $tabela[$p];?>").addClass('situacaoAtencao');
                                    document.getElementById('sit-cor-temp<?php echo $tabela[$p];?>').innerHTML = 'Atenção';
                                }else{
                                    $("#sit-cor-temp<?php echo $tabela[$p];?>").removeClass('situacaoDesligado');
                                    $("#sit-cor-temp<?php echo $tabela[$p];?>").removeClass('well-blink');
                                    $("#sit-cor-temp<?php echo $tabela[$p];?>").removeClass('situacaoAtencao');
                                    $("#sit-cor-temp<?php echo $tabela[$p];?>").addClass('situacaoLigado');
                                    document.getElementById('sit-cor-temp<?php echo $tabela[$p];?>').innerHTML = 'Normal';
                                }

                                //Atualiza o valor da temperatura
                                document.getElementById('cor_temp<?php echo $tabela[$p];?>').innerHTML = leftVal + "";

                            }, 5000);

                        });

                    <?php

                    }

                //var_dump($dadosMoni);

                /*
                * SAIR DO PHP PARA EXECUTAR FUNÇÃO JAVASCRIPT PARA ALIMENTAR OS GRÁFICOS
                */
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

                                <input type="hidden" id="tipoEntrada" value="<?php echo $tipoEntrada; ?>" />
                                <input type="hidden" id="tipoSaida" value="<?php echo $tipoSaida; ?>" />

                                <div class="row">
                                    <div class="panel panel-info">
                                        <div class="panel-heading">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h4>Temperaturas</h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel-body">
                                            <div class="row">

                                                <div class="well">

                                                    <div class="row">
                                                        <?php

                                                            /*
                                                            * INICIA O PROCESSO DE MONTAR AS TABELAS DE MONITORAMENTO DE PONTOS DO EQUIPAMENTO DE MEDIDAS
                                                            */

                                                            for($i = 0; $i < $tipoEntrada; $i++){

                                                                ?>


                                                                    <div class="col-lg-3">
                                                                        <h4>Ponto <?php echo strtoupper($tabela[$i]); ?></h4>
                                                                        <!-- Medidor temperatura 1 -->
                                                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                                                            <div id="containerTemperatura<?php echo $tabela[$i]; ?>" style="width:100%; margin: 0 auto"></div>
                                                                            <label class="valorVindo"><span id="cor_temp<?php echo $tabela[$i]; ?>"> 0</span> ( °C )</label>
                                                                            <div id="sit-cor-temp<?php echo $tabela[$i]; ?>" class="situacaoDesligado">Carregando...</div>
                                                                        </div><!-- Saida S/T -->
                                                                    </div>



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
                    </div>
                </div>

            <?php


        }

    }

?>
