<?php


    /*
    * COM OS PARAMETROS CARREGADOS, INICIA A COMPARAÇÃO COM OS DADOS RECEBIDOS
    */
    $parametros = $dados[0]['parametro'];
    $idSimEquip = $dados[0]['id_sim_equipamento'];

    $configuracaoSalva = explode('|inicio|',$parametros);

    $valoresEntrada    = explode('|', $configuracaoSalva[1]);


    foreach ($equipamentosSim as $equipamento) {


                /*
                * Equipamento é um No-break
                * Carrega os dados de equipamentos para verificar as saídas e entradas corretas
                * Efetua o calculo de potência consumida
                */
                $equipamentoAnalizado = carregarDadosEquip($equipamento['simIdEquip']);

                var_dump($equipamentoAnalizado);

                /*
                * CALCULA A POTENCIA DE ENTRADA CONSUMIDA
                */
                echo "<p> Inicio potência entrada consumida --> </p>";
                $potenciaEntradaR = 0;
                $potenciaEntradaS = 0;
                $potenciaEntradaT = 0;

                $valorB = verificaProtocoloPosicaoTebela($_POST['B'], $protocolos);
                $valorI = verificaProtocoloPosicaoTebela($_POST['I'], $protocolos);

                if($valorB == 1 && $valorI == 1){
                    //Testa se é possivel calcular a potência R
                    if((isset($_POST['B']) && ($_POST['B'] > 0)) && (isset($_POST['I']) && ($_POST['I'] > 0))){

                        $potenciaEntradaR = ($_POST['B'] / 100 ) * ($_POST['I'] / 100 );

                    }
                }else{
                    var_dump($valorB, $valorI);
                }

                $valorC = verificaProtocoloPosicaoTebela($_POST['C'], $protocolos);
                $valorJ = verificaProtocoloPosicaoTebela($_POST['J'], $protocolos);

                if($valorC == 1 && $valorJ == 1){
                    //Testa se é possivel calcular a potência R
                    if((isset($_POST['C']) && ($_POST['J'] > 0)) && (isset($_POST['C']) && ($_POST['J'] > 0))){

                        $potenciaEntradaS = ($_POST['C'] / 100 ) * ($_POST['J'] / 100 );

                    }
                }else{
                    var_dump($valorC, $valorJ);
                }

                $valorD = verificaProtocoloPosicaoTebela($_POST['D'], $protocolos);
                $valorL = verificaProtocoloPosicaoTebela($_POST['L'], $protocolos);

                if($valorD == 1 && $valorL == 1){
                    //Testa se é possivel calcular a potência R
                    if((isset($_POST['D']) && ($_POST['L'] > 0)) && (isset($_POST['D']) && ($_POST['L'] > 0))){

                        $potenciaEntradaT = ($_POST['D'] / 100 ) * ($_POST['L'] / 100 );

                    }
                }else{
                    var_dump($valorD, $valorL);
                }

                echo "<p> Fim potência entrada consumida --> </p>";

                /*
                * CALCULA A POTENCIA DE SAÍDA CONSUMIDA
                */
                echo "<p> Inicio potência consumida --> </p>";

                $potenciaR = 0;
                $potenciaS = 0;
                $potenciaT = 0;

                $valorE = verificaProtocoloPosicaoTebela($_POST['E'], $protocolos);
                $valorM = verificaProtocoloPosicaoTebela($_POST['M'], $protocolos);

                if($valorE && $valorM){
                    //Testa se é possivel calcular a potência R
                    if((isset($_POST['E']) && ($_POST['E'] > 0)) && (isset($_POST['M']) && ($_POST['M'] > 0))){

                        $potenciaR = ($_POST['E'] / 100 ) * ($_POST['M'] / 100 );

                    }
                }else{
                    var_dump($valorE, $valorM);
                }

                $valorF = verificaProtocoloPosicaoTebela($_POST['F'], $protocolos);
                $valorN = verificaProtocoloPosicaoTebela($_POST['N'], $protocolos);

                if($valorF && $valorN){
                    //Testa se é possivel calcular a potência S
                    if((isset($_POST['F']) && ($_POST['F'] > 0)) && (isset($_POST['N']) && ($_POST['N'] > 0))){

                        $potenciaS = ($_POST['F'] / 100 ) * ($_POST['N'] / 100 );

                    }
                }else{
                    var_dump($valorF, $valorN);
                }

                $valorG = verificaProtocoloPosicaoTebela($_POST['G'], $protocolos);
                $valorO = verificaProtocoloPosicaoTebela($_POST['O'], $protocolos);

                if($valorG && $valorO){
                    //Testa se é possivel calcular a potência T
                    if((isset($_POST['G']) && ($_POST['G'] > 0)) && (isset($_POST['O']) && ($_POST['O'] > 0))){

                        $potenciaT = ($_POST['G'] / 100 ) * ($_POST['O'] / 100 );

                    }
                }else{
                    var_dump($valorF, $valorN);
                }

                $potenciaEquip      = $equipamentoAnalizado[0]['potencia'];
                //Substituir 0.85 pelo valor de "fator de potência" que será implementado no cadastro de equipamento
                $totalSaidaPot      = $potenciaR + $potenciaS + $potenciaT;

                $percentualSaidaPot = ($totalSaidaPot * 100) / (($potenciaEquip * 1000) * 0.85);

                $potenciaConsumida  = ((($potenciaEquip * 100) * $percentualSaidaPot) / 100) / 100;
                var_dump($potenciaConsumida);

                /*
                * VERIFICA O STATUS DE RECEBIMENTO DE ENTRADA
                */

                $statusEntrada = 0;
                switch ($equipamentoAnalizado[0]['tipo_entrada']) {
                    case '1':
                        if(isset($_POST['B']) && ($_POST['B'] > 15)){
                            $statusEntrada = 1;
                        }
                    break;
                    case '2':
                        if(isset($_POST['B']) && ($_POST['B'] > 15) && isset($_POST['C']) && ($_POST['C'] > 15)){
                            $statusEntrada = 1;
                        }
                    break;
                    case '3':
                        if(isset($_POST['B']) && ($_POST['B'] > 15) && isset($_POST['C']) && ($_POST['C'] > 15) && isset($_POST['D']) && ($_POST['D'] > 15)){
                            $statusEntrada = 1;
                        }
                    break;
                }

                echo "<p> Fim potência consumida --> </p> ";
                /*
                * CALCULA O VALOR DO TEMPO ESTIMADO POR HORA, BASEADO NA POTENCIA DE SAÍDA
                */

                $tempoEstimadoHora = calcularTempoEstimadoHora($potenciaConsumida, $equipamentoAnalizado[0]['quantidade_bateria_por_banco'], $equipamentoAnalizado[0]['tensaoMinBarramento'], 1.5);

                /*
                * SALVA NO BANCO A POTENCIA CONSUMIDA JUNTAMENTE COM O HORARIO E O NUM_SIM
                * ATUALIZAR FUNÇÃO PARA SALVAR AS POTÊNCIAS E ENTADAS DO EQUIPAMENTO
                */

                $salvarPotencia = salvarDadosPotenciaConsmida($_POST['A'], $equipamentoAnalizado[0]['id'], $potenciaConsumida, $statusEntrada, $tempoEstimadoHora, number_format($potenciaEntradaR, 2, '.', ''), number_format($potenciaEntradaS, 2, '.', ''), number_format($potenciaEntradaT, 2, '.', ''), number_format($potenciaR, 2, '.', ''),  number_format($potenciaS, 2, '.', ''), number_format($potenciaT, 2, '.', ''));

                /*
                * SE O STATUS DA ENTRADA ESTIVER ATIVADO, CALCULAR E SALVAR O VALOR DO TEMPO DE ESTIMATIVA DA BATERIA
                * UTILIZADO O TEMPO ESTIMADO EM HORAS ($tempoEstimadoHora) PARA CALCULAR A ESTIMATIVA DE DURAÇÃO DA BATERIA
                */
                if($statusEntrada == 1){

                    $correnteBat = $equipamentoAnalizado[0]['correnteBancoBateria'];

                    $tempoEstimadoBateria = (60 * $correnteBat) / $tempoEstimadoHora;

                    //var_dump('Tempo estimado Bateria ', $tempoEstimadoBateria);

                    /*
                    * Var_dump DO VALOR GERADO
                    */
                }

                /*
                * PROSEGUIR COM VERIFICAÇÃO DE ALARMES
                */

                /*
                * VERIFICA O TIPO DE ENTRADA DO EQUIPAMENTO E ENTÃO EFETUA A VERIFICAÇÃO DOS PARAMETROS
                */

                switch ($equipamentoAnalizado[0]['tipo_entrada']) {
                    case '1':
                        # Equipamento monofásico
                        $valoresEntrada         = explode('|', $configuracaoSalva[1]);
                        /*
                        *  VERIFICA ENTRADA R ()
                        * TESTA OS VALORES DE ENTRADA
                        */
                        $valorValidoB =  verificaProtocoloPosicaoTebela($_POST['B'], $protocolos);

                        if($valorValidoB > 0){
                            $statusB                = comparaParametrosEquipamento(($_POST['B']/100), $valoresEntrada, $idSimEquip, 'Tensão', 'b');
                        }else{
                            //GERA ALARME DE PROTOCOLO
                            gerarAlarmeEquipamento($idSimEquip, 0, 0, 'Tensão', 9, 1, 'b');
                        }

                        $valoresCorrente        = explode('|', $configuracaoSalva[4]);
                        # VERIFICA ENTRADA CORRENTE R ()
                        $valorValidoI =  verificaProtocoloPosicaoTebela($_POST['I'], $protocolos);
                        if($valorValidoI > 0){
                            $statusI  = comparaParametrosEquipamento(($_POST['I']/100), $valoresCorrente, $idSimEquip, 'Corrente', 'i');
                        }else{
                            //GERA ALARME DE PROTOCOLO
                            gerarAlarmeEquipamento($idSimEquip, 0, 0, 'Corrente', 9, 1, 'i');
                        }

                    break;
                    case '2':
                        # Equipamento bifásico
                        $valoresEntrada         = explode('|', $configuracaoSalva[1]);

                        # Verifica entrada R e S ()
                        $valorValidoB =  verificaProtocoloPosicaoTebela($_POST['B'], $protocolos);
                        $valorValidoC =  verificaProtocoloPosicaoTebela($_POST['C'], $protocolos);

                        if($valorValidoB > 0){
                            $statusB                = comparaParametrosEquipamento(($_POST['B']/100), $valoresEntrada, $idSimEquip, 'Tensão', 'b');
                        }else{
                            //GERA ALARME DE PROTOCOLO
                            gerarAlarmeEquipamento($idSimEquip, 0, 0, 'Tensão', 9, 1, 'b');
                        }

                        if($valorValidoC > 0){
                            $statusC                = comparaParametrosEquipamento(($_POST['C']/100), $valoresEntrada, $idSimEquip, 'Tensão', 'c');
                        }else{
                            //GERA ALARME DE PROTOCOLO
                            gerarAlarmeEquipamento($idSimEquip, 0, 0, 'Tensão', 9, 1, 'c');
                        }

                        $valoresCorrente        = explode('|', $configuracaoSalva[4]);
                        # Verifica entrada corrente R e S()
                        $valorValidoI =  verificaProtocoloPosicaoTebela($_POST['I'], $protocolos);
                        $valorValidoJ =  verificaProtocoloPosicaoTebela($_POST['J'], $protocolos);

                        if($valorValidoI > 0){
                            $statusI  = comparaParametrosEquipamento(($_POST['I']/100), $valoresCorrente, $idSimEquip, 'Corrente', 'i');
                        }else{
                            //GERA ALARME DE PROTOCOLO
                            gerarAlarmeEquipamento($idSimEquip, 0, 0, 'Corrente', 9, 1, 'i');
                        }

                        if($valorValidoJ > 0){
                            $statusJ   = comparaParametrosEquipamento(($_POST['J']/100), $valoresCorrente, $idSimEquip, 'Corrente', 'j');
                        }else{
                            //GERA ALARME DE PROTOCOLO
                            gerarAlarmeEquipamento($idSimEquip, 0, 0, 'Corrente', 9, 1, 'j');
                        }

                    break;
                    case '3':

                        $valoresEntrada = explode('|', $configuracaoSalva[1]);

                        $valorValidoB   =  verificaProtocoloPosicaoTebela($_POST['B'], $protocolos);
                        $valorValidoC   =  verificaProtocoloPosicaoTebela($_POST['C'], $protocolos);
                        $valorValidoD   =  verificaProtocoloPosicaoTebela($_POST['D'], $protocolos);

                        if($valorValidoB > 0){
                            $statusB    = comparaParametrosEquipamento(($_POST['B']/100), $valoresEntrada, $idSimEquip, 'Tensão', 'b');
                        }else{
                            //GERA ALARME DE PROTOCOLO

                            gerarAlarmeEquipamento($idSimEquip, 0, 0, 'Tensão', 9, 1, 'b');

                        }

                        if($valorValidoC > 0){
                            $statusC    = comparaParametrosEquipamento(($_POST['C']/100), $valoresEntrada, $idSimEquip, 'Tensão', 'c');
                        }else{
                            //GERA ALARME DE PROTOCOLO
                            gerarAlarmeEquipamento($idSimEquip, 0, 0, 'Tensão', 9, 1, 'c');
                        }

                        if($valorValidoD > 0){
                            $statusD    = comparaParametrosEquipamento(($_POST['D']/100), $valoresEntrada, $idSimEquip, 'Tensão', 'd');
                        }else{
                            //GERA ALARME DE PROTOCOLO
                            gerarAlarmeEquipamento($idSimEquip, 0, 0, 'Tensão', 9, 1, 'd');
                        }

                        $valoresCorrente        = explode('|', $configuracaoSalva[4]);

                        $valorValidoI =  verificaProtocoloPosicaoTebela($_POST['I'], $protocolos);
                        $valorValidoJ =  verificaProtocoloPosicaoTebela($_POST['J'], $protocolos);
                        $valorValidoL =  verificaProtocoloPosicaoTebela($_POST['L'], $protocolos);

                        if($valorValidoI > 0){
                            $statusI  = comparaParametrosEquipamento(($_POST['I']/100), $valoresCorrente, $idSimEquip, 'Corrente', 'i');
                        }else{
                            //GERA ALARME DE PROTOCOLO
                            gerarAlarmeEquipamento($idSimEquip, 0, 0, 'Corrente', 9, 1, 'i');
                        }

                        if($valorValidoJ > 0){
                            $statusJ   = comparaParametrosEquipamento(($_POST['J']/100), $valoresCorrente, $idSimEquip, 'Corrente', 'j');
                        }else{
                            //GERA ALARME DE PROTOCOLO
                            gerarAlarmeEquipamento($idSimEquip, 0, 0, 'Corrente', 9, 1, 'j');
                        }

                        if($valorValidoL > 0){
                            $statusL   = comparaParametrosEquipamento(($_POST['L']/100), $valoresCorrente, $idSimEquip, 'Corrente', 'l');
                        }else{
                            //GERA ALARME DE PROTOCOLO
                            gerarAlarmeEquipamento($idSimEquip, 0, 0, 'Corrente', 9, 1, 'l');
                        }

                    break;
                }

                /*
                * VERIFICA O TIPO DE SAÍDA DO EQUIPAMENTO E ENTÃO EFETUA A VERIFICAÇÃO DOS PARAMETROS
                */

                switch ($equipamentoAnalizado[0]['tipo_saida']) {

                    case '1':
                        # Equipamento trifásico
                        $valoresSaida           = explode('|', $configuracaoSalva[2]);

                        $valorValidoE =  verificaProtocoloPosicaoTebela($_POST['E'], $protocolos);

                        if($valorValidoE > 0){
                            $statusE  = comparaParametrosEquipamento(($_POST['E']/100), $valoresSaida, $idSimEquip, 'Saída tensão', 'e');
                        }else{
                            //GERA ALARME DE PROTOCOLO
                            gerarAlarmeEquipamento($idSimEquip, 0, 0, 'Saída tensão', 9, 1, 'e');
                        }

                        $valoresCorrenteSaida   = explode('|', $configuracaoSalva[5]);

                        $valorValidoM =  verificaProtocoloPosicaoTebela($_POST['M'], $protocolos);

                        if($valorValidoM > 0){
                            $statusM  = comparaParametrosEquipamento(($_POST['M']/100), $valoresCorrenteSaida, $idSimEquip, 'Saída corrente', 'm');
                        }else{
                            //GERA ALARME DE PROTOCOLO
                            gerarAlarmeEquipamento($idSimEquip, 0, 0, 'Saída corrente', 9, 1, 'm');
                        }

                    break;

                    case '2':
                        # Equipamento trifásico
                        $valoresSaida           = explode('|', $configuracaoSalva[2]);

                        $valorValidoE =  verificaProtocoloPosicaoTebela($_POST['E'], $protocolos);
                        $valorValidoF =  verificaProtocoloPosicaoTebela($_POST['F'], $protocolos);

                        if($valorValidoE > 0){
                            $statusE  = comparaParametrosEquipamento(($_POST['E']/100), $valoresSaida, $idSimEquip, 'Saída tensão', 'e');
                        }else{
                            //GERA ALARME DE PROTOCOLO
                            gerarAlarmeEquipamento($idSimEquip, 0, 0, 'Saída tensão', 9, 1, 'e');
                        }

                        if($valorValidoF > 0){
                            $statusF  = comparaParametrosEquipamento(($_POST['F']/100), $valoresSaida, $idSimEquip, 'Saída tensão', 'f');
                        }else{
                            //GERA ALARME DE PROTOCOLO
                            gerarAlarmeEquipamento($idSimEquip, 0, 0, 'Saída tensão', 9, 1, 'f');
                        }

                        $valoresCorrenteSaida   = explode('|', $configuracaoSalva[5]);

                        $valorValidoM =  verificaProtocoloPosicaoTebela($_POST['M'], $protocolos);
                        $valorValidoN =  verificaProtocoloPosicaoTebela($_POST['N'], $protocolos);

                        if($valorValidoM > 0){
                            $statusM  = comparaParametrosEquipamento(($_POST['M']/100), $valoresCorrenteSaida, $idSimEquip, 'Saída corrente', 'm');
                        }else{
                            //GERA ALARME DE PROTOCOLO
                            gerarAlarmeEquipamento($idSimEquip, 0, 0, 'Saída corrente', 9, 1, 'm');
                        }

                        if($valorValidoN > 0){
                            $statusN   = comparaParametrosEquipamento(($_POST['N']/100), $valoresCorrenteSaida, $idSimEquip, 'Saída corrente', 'n');
                        }else{
                            //GERA ALARME DE PROTOCOLO
                            gerarAlarmeEquipamento($idSimEquip, 0, 0, 'Saída corrente', 9, 1, 'n');
                        }

                    break;

                    case '3':
                        # Equipamento trifásico
                        $valoresSaida           = explode('|', $configuracaoSalva[2]);

                        $valorValidoE =  verificaProtocoloPosicaoTebela($_POST['E'], $protocolos);
                        $valorValidoF =  verificaProtocoloPosicaoTebela($_POST['F'], $protocolos);
                        $valorValidoG =  verificaProtocoloPosicaoTebela($_POST['G'], $protocolos);

                        if($valorValidoE > 0){
                            $statusE  = comparaParametrosEquipamento(($_POST['E']/100), $valoresSaida, $idSimEquip, 'Saída tensão', 'e');
                        }else{
                            //GERA ALARME DE PROTOCOLO
                            gerarAlarmeEquipamento($idSimEquip, 0, 0, 'Saída tensão', 9, 1, 'e');
                        }

                        if($valorValidoF > 0){
                            $statusF  = comparaParametrosEquipamento(($_POST['F']/100), $valoresSaida, $idSimEquip, 'Saída tensão', 'f');
                        }else{
                            //GERA ALARME DE PROTOCOLO
                            gerarAlarmeEquipamento($idSimEquip, 0, 0, 'Saída tensão', 9, 1, 'f');
                        }

                        if($valorValidoG > 0){
                            $statusG   = comparaParametrosEquipamento(($_POST['G']/100), $valoresSaida, $idSimEquip, 'Saída tensão', 'g');
                        }else{
                            //GERA ALARME DE PROTOCOLO
                            gerarAlarmeEquipamento($idSimEquip, 0, 0, 'Saída tensão', 9, 1, 'g');
                        }

                        $valoresCorrenteSaida   = explode('|', $configuracaoSalva[5]);

                        $valorValidoM =  verificaProtocoloPosicaoTebela($_POST['M'], $protocolos);
                        $valorValidoN =  verificaProtocoloPosicaoTebela($_POST['N'], $protocolos);
                        $valorValidoO =  verificaProtocoloPosicaoTebela($_POST['O'], $protocolos);

                        if($valorValidoM > 0){
                            $statusM  = comparaParametrosEquipamento(($_POST['M']/100), $valoresCorrenteSaida, $idSimEquip, 'Saída corrente', 'm');
                        }else{
                            //GERA ALARME DE PROTOCOLO
                            gerarAlarmeEquipamento($idSimEquip, 0, 0, 'Saída corrente', 9, 1, 'm');
                        }

                        if($valorValidoN > 0){
                            $statusN   = comparaParametrosEquipamento(($_POST['N']/100), $valoresCorrenteSaida, $idSimEquip, 'Saída corrente', 'n');
                        }else{
                            //GERA ALARME DE PROTOCOLO
                            gerarAlarmeEquipamento($idSimEquip, 0, 0, 'Saída corrente', 9, 1, 'n');
                        }

                        if($valorValidoO > 0){
                            $statusO    = comparaParametrosEquipamento(($_POST['O']/100), $valoresCorrenteSaida, $idSimEquip, 'Saída corrente', 'o');
                        }else{
                            //GERA ALARME DE PROTOCOLO
                            gerarAlarmeEquipamento($idSimEquip, 0, 0, 'Saída corrente', 9, 1, 'o');
                        }

                    break;

                }

                /*
                * VERIFICA AS MEDIDAS DAS BATERIAS
                */
                $valoresBateria         = explode('|', $configuracaoSalva[3]);

                $valorValidoH =  verificaProtocoloPosicaoTebela($_POST['H'], $protocolos);
                $valorValidoP =  verificaProtocoloPosicaoTebela($_POST['P'], $protocolos);


                if($valorValidoH > 0){
                    $statusH   = comparaParametrosEquipamento(($_POST['H']/100), $valoresBateria, $idSimEquip, 'Bateria', 'h');
                }else{
                    //GERA ALARME DE PROTOCOLO
                    gerarAlarmeEquipamento($idSimEquip, 0, 0, 'Bateria', 9, 1, 'h');
                }

                /*
                * VERIFICA AS MEDIDAS DAS TEMPERATURAS
                */

                #Temperatura ambiente q
                $valoresTeperaturaAmbiente         = explode('|', $configuracaoSalva[6]);
                $valorValidoQ =  verificaProtocoloPosicaoTebela($_POST['Q'], $protocolos);

                if($valorValidoQ > 0){
                    $statusQ    = comparaParametrosEquipamento(($_POST['Q']/100), $valoresTeperaturaAmbiente, $idSimEquip, 'Temperatura ambiente', 'q');
                }else{
                    //GERA ALARME DE PROTOCOLO
                    gerarAlarmeEquipamento($idSimEquip, 0, 0, 'Temperatura ambiente', 9, 1, 'q');
                }

                #Temperatura banco bateria r
                $valoresTemperaturaBancoBat        = explode('|', $configuracaoSalva[7]);
                $valorValidoR =  verificaProtocoloPosicaoTebela($_POST['R'], $protocolos);

                if($valorValidoR > 0){
                    $statusR    = comparaParametrosEquipamento(($_POST['R']/100), $valoresTemperaturaBancoBat, $idSimEquip, 'Temperatura Banco de bateria', 'r');
                }else{
                    //GERA ALARME DE PROTOCOLO
                    gerarAlarmeEquipamento($idSimEquip, 0, 0, 'Temperatura Banco de bateria', 9, 1, 'r');
                }

    }






?>
