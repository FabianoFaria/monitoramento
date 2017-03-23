<?php

    /*
    * TERCEIRA VERSÃO DO DATASYNC.
    * CARACTERISTICAS DESTA VERSÃO:
    * RECEBER E GUARDAR OS DADOS RECEBIDO DO EQUIPAMENTO
    * CONFORME OS TIPOS DE ENTRADA E SAÍDA DO EQUIPAMENTO EFETUAR OS TESTES DOS PARAMETROS E GERAR ALARME
    * CONFORME AS ENTRADAS E SAÍDAS, CALCULAR A POTENCIA CONSUMIDA E SALVAR NO BANCO
    * QUANDO DETECTADO QUEDA DE ENERGIA, INICIAR PPROCESSO DE CALCULO DE AUTONOMIA DA BATERIA
    */

    /*
    * INCLUI A CLASSE DE CONEXA
    */
    require_once "classes/class-EficazDB.php";
    require_once "classes/class-email.php";


    /*
    * VALIDA OS CAMPOS DO POST
    */

    if(isset($_POST['A']) && isset($_POST['B']) && isset($_POST['C']) && isset($_POST['D']) &&
       isset($_POST['E']) && isset($_POST['F']) && isset($_POST['G']) && isset($_POST['H']) &&
       isset($_POST['I']) && isset($_POST['J']) && isset($_POST['L']) && isset($_POST['M']) &&
       isset($_POST['N']) && isset($_POST['O']) && isset($_POST['P']) && isset($_POST['Q']) &&
       isset($_POST['R']) && isset($_POST['S']) && isset($_POST['T']) && isset($_POST['U']))
    {
        /*
        *  CRIA UM OBJETO DE DA CLASSE DE CONEXAO
        */
        $conn = new EficazDB;

        /*
        * VERIFICA SE EXISTE ERRO DE CONEXAO
        */
        if (!$conn)
        {
            // Retorno erro
            header('HTTP/1.1 404 Not Found');
            // Finaliza a execucao
            exit();
        }

        /*
        * LISTA DE PROTOCOLOS
        */
        $protocolos    = array(
                            '65534' => 'Alerta Y',
                            '65533' => 'Alerta Z'
                        );

        /*
        * CADA UM DOS POSTS SERÁ VERIFICADO PARA PROCURAR ALGUM TIPO DE PROTOCOLO ENVIADO PELO EQUIPAMENTO
        * EM CASO DE PROTOCOLO ENCONTRADO, IRÁ SALVAR UM ZERO no LUGAR DO CÓDIGO DO PROTOCOLO
        */
        $postB = verificaValorPosicaoQuery($_POST['B'],$protocolos);
        $postC = verificaValorPosicaoQuery($_POST['C'],$protocolos);
        $postD = verificaValorPosicaoQuery($_POST['C'],$protocolos);

        $postE = verificaValorPosicaoQuery($_POST['E'],$protocolos);
        $postF = verificaValorPosicaoQuery($_POST['F'],$protocolos);
        $postG = verificaValorPosicaoQuery($_POST['G'],$protocolos);

        $postH = verificaValorPosicaoQuery($_POST['H'],$protocolos);

        $postI = verificaValorPosicaoQuery($_POST['I'],$protocolos);
        $postJ = verificaValorPosicaoQuery($_POST['J'],$protocolos);
        $postL = verificaValorPosicaoQuery($_POST['L'],$protocolos);

        $postM = verificaValorPosicaoQuery($_POST['M'],$protocolos);
        $postN = verificaValorPosicaoQuery($_POST['N'],$protocolos);
        $postO = verificaValorPosicaoQuery($_POST['O'],$protocolos);

        $postP = verificaValorPosicaoQuery($_POST['P'],$protocolos);

        $postQ = verificaValorPosicaoQuery($_POST['Q'],$protocolos);
        $postR = verificaValorPosicaoQuery($_POST['R'],$protocolos);
        $postS = verificaValorPosicaoQuery($_POST['S'],$protocolos);
        $postT = verificaValorPosicaoQuery($_POST['T'],$protocolos);
        $postU = verificaValorPosicaoQuery($_POST['U'],$protocolos);

        /*
        * MONTA A QUERY
        */
        $valor = "insert into tb_dados (num_sim,b,c,d,e,f,g,h,i,j,l,m,n,o,p,q,r,s,t,u) values
                      ('{$_POST['A']}','{$postB}','{$postC}','{$postD}','{$postE}','{$postF}','{$postG}',
                       '{$postH}','{$postI}','{$postJ}','{$postL}','{$postM}','{$postN}','{$postO}',
                       '{$postP}','{$postQ}','{$postR}','{$postS}','{$postT}','{$postU}')";

        /*
        * EXECUTA A QUERY NO BANCO E VERIFICA SE RETORNO ERRO
        */
        if (!$conn->query($valor))
        {
            // Monta a query de log
            $query = "insert into tb_log (log)  values ('Erro ao gravar os valores da tabela respota; SIM [{$_POST['A']}]')";

            // Grava o log
            $conn->query($valor);

            // Retona o erro
            header('HTTP/1.1 404 Not Found');
            // Finaliza a execucao
            exit();
        }

        /*
        * CARREGA OS TIPOS DE EQUIPAMENTOS CADASTRADOS COM O SIM
        */

        $equipamentosSim = carregaEquipamentosSim($_POST['A']);

        var_dump($equipamentosSim);

        /*
        * CARREGA OS PARAMETROS DEFINIDOS PARA O SIM INFORMADO
        */

        $dados = carregaParamentrosSim($_POST['A']);

        var_dump($dados);

        /*
        * CASO EXISTA PARAMETROS CONFIGURADOS
        */
        if($dados){

            /*
            * DEVIDO AO FATO DE EXISTIR MAIS DE UM TIPO DE EQUIPAMENTO, EFETUANDO A LISTAGEM E TRATAMENTO DE CADA UM DOS EQUIAPMENTOS CADASTRADOS PARA O SIM
            */

            /*
            * COM OS PARAMETROS CARREGADOS, INICIA A COMPARAÇÃO COM OS DADOS RECEBIDOS
            */
            $parametros = $dados[0]['parametro'];
            $idSimEquip = $dados[0]['id_sim_equipamento'];

            $configuracaoSalva = explode('|inicio|',$parametros);

            $valoresEntrada    = explode('|', $configuracaoSalva[1]);

            foreach ($equipamentosSim as $equipamento) {

                switch ($equipamento['tipo_equipamento']) {

                    case '1':
                        /*
                        * Equipamento é um No-break
                        * Carrega os dados de equipamentos para verificar as saídas e entradas corretas
                        * Efetua o calculo de potência consumida
                        */
                        $equipamentoAnalizado = carregarDadosEquip($equipamento['simIdEquip']);

                        var_dump($equipamentoAnalizado);

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
                                if((isset($_POST['E']) && ($_POST['E'] != 0)) && (isset($_POST['M']) && ($_POST['M'] != 0))){

                                    $potenciaR = ($_POST['E'] / 100 ) * ($_POST['M'] / 100 );

                                }
                            }else{
                                var_dump($valorE, $valorM);
                            }

                            $valorF = verificaProtocoloPosicaoTebela($_POST['F'], $protocolos);
                            $valorN = verificaProtocoloPosicaoTebela($_POST['N'], $protocolos);

                            if($valorF && $valorN){
                                //Testa se é possivel calcular a potência S
                                if((isset($_POST['F']) && ($_POST['F'] != 0)) && (isset($_POST['N']) && ($_POST['N'] != 0))){

                                    $potenciaS = ($_POST['F'] / 100 ) * ($_POST['N'] / 100 );

                                }
                            }else{
                                var_dump($valorF, $valorN);
                            }

                            $valorF = verificaProtocoloPosicaoTebela($_POST['F'], $protocolos);
                            $valorN = verificaProtocoloPosicaoTebela($_POST['N'], $protocolos);

                            if($valorF && $valorN){
                                //Testa se é possivel calcular a potência T
                                if((isset($_POST['G']) && ($_POST['G'] != 0)) && (isset($_POST['O']) && ($_POST['O'] != 0))){

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
                            //((potenciaEquip * 1000) * 0.85);


                            /*
                            //SOMA DE SAÍDA DE POTÊNCIA
                            var totalSaidaPot       = potSaiR + potSaiS + potSaiT;
                            var percentualSaidaPot  = (totalSaidaPot * 100) / ((potenciaEquip * 1000) * 0.85);
                            var percentualDisponivel = 100 - percentualSaidaPot;

                            //VALOR DE POTENCIA SENDO CONSUMIDA ATUALMENTE

                            var potenciaConsumida  =  (((potenciaEquip * 100) * percentualSaidaPot) / 100) / 100;
                            */

                        /*
                        * VERIFICA O STATUS DE RECEBIMENTO DE ENTRADA
                        */
                        $statusEntrada = 0;
                        switch ($equipamentoAnalizado[0]['tipo_entrada']) {
                            case '1':
                                if(isset($_POST['B']) && ($_POST['B'] != 0)){
                                    $statusEntrada = 1;
                                }
                            default;
                            case '2':
                                if(isset($_POST['B']) && ($_POST['B'] != 0) && isset($_POST['C']) && ($_POST['C'] != 0)){
                                    $statusEntrada = 1;
                                }
                            default;
                            case '3':
                                if(isset($_POST['B']) && ($_POST['B'] != 0) && isset($_POST['C']) && ($_POST['C'] != 0) && isset($_POST['D']) && ($_POST['D'] != 0)){
                                    $statusEntrada = 1;
                                }
                            default;
                        }

                        echo "<p> Fim potência consumida --> </p> ";
                        /*
                        * CALCULA O VALOR DO TEMPO ESTIMADO POR HORA, BASEADO NA POTENCIA DE SAÍDA
                        */

                        $tempoEstimadoHora = calcularTempoEstimadoHora($potenciaConsumida, $equipamentoAnalizado[0]['quantidade_bateria_por_banco'], $equipamentoAnalizado[0]['tensaoMinBarramento'], 1.5);

                        /*
                        * SALVA NO BANCO A POTENCIA CONSUMIDA JUNTAMENTE COM O HORARIO E O NUM_SIM
                        */

                        $salvarPotencia = salvarDadosPotenciaConsmida($_POST['A'], $equipamentoAnalizado[0]['id'], $potenciaConsumida, $statusEntrada, $tempoEstimadoHora);

                            //($numeroSim, $idEquipamento, $totalPotenciaConsumida, $statusEntrada, $tempoEstHora

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
                        * Verifica o tipo de entrada do equipamento e então efetua a verificação dos parametros
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
                                }

                                $valoresCorrente        = explode('|', $configuracaoSalva[4]);
                                # VERIFICA ENTRADA CORRENTE R ()
                                $valorValidoI =  verificaProtocoloPosicaoTebela($_POST['I'], $protocolos);
                                if($valorValidoI > 0){
                                    $statusI  = comparaParametrosEquipamento(($_POST['I']/100), $valoresCorrente, $idSimEquip, 'Corrente', 'i');
                                }else{
                                    //GERA ALARME DE PROTOCOLO
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
                                }

                                if($valorValidoC > 0){
                                    $statusC                = comparaParametrosEquipamento(($_POST['C']/100), $valoresEntrada, $idSimEquip, 'Tensão', 'c');
                                }else{
                                    //GERA ALARME DE PROTOCOLO
                                }

                                $valoresCorrente        = explode('|', $configuracaoSalva[4]);
                                # Verifica entrada corrente R e S()
                                $valorValidoI =  verificaProtocoloPosicaoTebela($_POST['I'], $protocolos);
                                $valorValidoJ =  verificaProtocoloPosicaoTebela($_POST['J'], $protocolos);

                                if($valorValidoI > 0){
                                    $statusI  = comparaParametrosEquipamento(($_POST['I']/100), $valoresCorrente, $idSimEquip, 'Corrente', 'i');
                                else{
                                    //GERA ALARME DE PROTOCOLO
                                }

                                if($valorValidoJ > 0){
                                    $statusJ   = comparaParametrosEquipamento(($_POST['J']/100), $valoresCorrente, $idSimEquip, 'Corrente', 'j');
                                }else{
                                    //GERA ALARME DE PROTOCOLO
                                }

                            break;
                            case '3':

                                $valorValidoB =  verificaProtocoloPosicaoTebela($_POST['B'], $protocolos);
                                $valorValidoC =  verificaProtocoloPosicaoTebela($_POST['C'], $protocolos);
                                $valorValidoD =  verificaProtocoloPosicaoTebela($_POST['D'], $protocolos);

                                if($valorValidoB > 0){
                                    $statusB                = comparaParametrosEquipamento(($_POST['B']/100), $valoresEntrada, $idSimEquip, 'Tensão', 'b');
                                }else{
                                    //GERA ALARME DE PROTOCOLO
                                }

                                if($valorValidoC > 0){
                                    $statusC                = comparaParametrosEquipamento(($_POST['C']/100), $valoresEntrada, $idSimEquip, 'Tensão', 'c');
                                }else{
                                    //GERA ALARME DE PROTOCOLO
                                }

                                if($valorValidoD > 0){
                                    $statusD                = comparaParametrosEquipamento(($_POST['D']/100), $valoresEntrada, $idSimEquip, 'Tensão', 'd');
                                }else{
                                    //GERA ALARME DE PROTOCOLO
                                }

                                $valorValidoI =  verificaProtocoloPosicaoTebela($_POST['I'], $protocolos);
                                $valorValidoJ =  verificaProtocoloPosicaoTebela($_POST['J'], $protocolos);
                                $valorValidoL =  verificaProtocoloPosicaoTebela($_POST['L'], $protocolos);

                                if($valorValidoI > 0){
                                    $statusI  = comparaParametrosEquipamento(($_POST['I']/100), $valoresCorrente, $idSimEquip, 'Corrente', 'i');
                                else{
                                    //GERA ALARME DE PROTOCOLO
                                }

                                if($valorValidoJ > 0){
                                    $statusJ   = comparaParametrosEquipamento(($_POST['J']/100), $valoresCorrente, $idSimEquip, 'Corrente', 'j');
                                }else{
                                    //GERA ALARME DE PROTOCOLO
                                }

                                if($valorValidoL > 0){
                                    $statusL   = comparaParametrosEquipamento(($_POST['L']/100), $valoresCorrente, $idSimEquip, 'Corrente', 'l');
                                }else{
                                    //GERA ALARME DE PROTOCOLO
                                }

                            break;

                        }

                        /*
                        * Verifica o tipo de saída do equipamento e então efetua a verificação dos parametros
                        */
                        switch ($equipamentoAnalizado[0]['tipo_saida']) {

                            case '1':
                                # Equipamento trifásico
                                $valoresSaida           = explode('|', $configuracaoSalva[2]);

                                $valorValidoE =  verificaProtocoloPosicaoTebela($_POST['E'], $protocolos);

                                if($valorValidoE > 0){
                                    $statusE  = comparaParametrosEquipamento(($_POST['E']/100), $valoresCorrente, $idSimEquip, 'Saída tensão', 'e');
                                else{
                                    //GERA ALARME DE PROTOCOLO
                                }

                                $valoresCorrenteSaida   = explode('|', $configuracaoSalva[5]);

                                $valorValidoM =  verificaProtocoloPosicaoTebela($_POST['M'], $protocolos);

                                if($valorValidoM > 0){
                                    $statusM  = comparaParametrosEquipamento(($_POST['M']/100), $valoresCorrente, $idSimEquip, 'Saída corrente', 'm');
                                else{
                                    //GERA ALARME DE PROTOCOLO
                                }

                            break;

                            case '2':
                                # Equipamento trifásico
                                $valoresSaida           = explode('|', $configuracaoSalva[2]);

                                $valorValidoE =  verificaProtocoloPosicaoTebela($_POST['E'], $protocolos);
                                $valorValidoF =  verificaProtocoloPosicaoTebela($_POST['F'], $protocolos);

                                if($valorValidoE > 0){
                                    $statusE  = comparaParametrosEquipamento(($_POST['E']/100), $valoresCorrente, $idSimEquip, 'Saída tensão', 'e');
                                else{
                                    //GERA ALARME DE PROTOCOLO
                                }

                                if($valorValidoF > 0){
                                    $statusF  = comparaParametrosEquipamento(($_POST['F']/100), $valoresCorrente, $idSimEquip, 'Saída tensão', 'f');
                                }else{
                                    //GERA ALARME DE PROTOCOLO
                                }

                                $valoresCorrenteSaida   = explode('|', $configuracaoSalva[5]);

                                $valorValidoM =  verificaProtocoloPosicaoTebela($_POST['M'], $protocolos);
                                $valorValidoN =  verificaProtocoloPosicaoTebela($_POST['N'], $protocolos);

                                if($valorValidoM > 0){
                                    $statusM  = comparaParametrosEquipamento(($_POST['M']/100), $valoresCorrente, $idSimEquip, 'Saída corrente', 'm');
                                else{
                                    //GERA ALARME DE PROTOCOLO
                                }

                                if($valorValidoN > 0){
                                    $statusN   = comparaParametrosEquipamento(($_POST['N']/100), $valoresCorrente, $idSimEquip, 'Saída corrente', 'n');
                                }else{
                                    //GERA ALARME DE PROTOCOLO
                                }

                            break;

                            case '3':
                                # Equipamento trifásico
                                $valoresSaida           = explode('|', $configuracaoSalva[2]);

                                $valorValidoE =  verificaProtocoloPosicaoTebela($_POST['E'], $protocolos);
                                $valorValidoF =  verificaProtocoloPosicaoTebela($_POST['F'], $protocolos);
                                $valorValidoG =  verificaProtocoloPosicaoTebela($_POST['G'], $protocolos);

                                if($valorValidoE > 0){
                                    $statusE  = comparaParametrosEquipamento(($_POST['E']/100), $valoresCorrente, $idSimEquip, 'Saída tensão', 'e');
                                else{
                                    //GERA ALARME DE PROTOCOLO
                                }

                                if($valorValidoF > 0){
                                    $statusF  = comparaParametrosEquipamento(($_POST['F']/100), $valoresCorrente, $idSimEquip, 'Saída tensão', 'f');
                                }else{
                                    //GERA ALARME DE PROTOCOLO
                                }

                                if($valorValidoG > 0){
                                    $statusG   = comparaParametrosEquipamento(($_POST['G']/100), $valoresSaida, $idSimEquip, 'Saída tensão', 'g');
                                }else{
                                    //GERA ALARME DE PROTOCOLO
                                }

                                $valoresCorrenteSaida   = explode('|', $configuracaoSalva[5]);

                                $valorValidoM =  verificaProtocoloPosicaoTebela($_POST['M'], $protocolos);
                                $valorValidoN =  verificaProtocoloPosicaoTebela($_POST['N'], $protocolos);
                                $valorValidoO =  verificaProtocoloPosicaoTebela($_POST['O'], $protocolos);

                                if($valorValidoM > 0){
                                    $statusM  = comparaParametrosEquipamento(($_POST['M']/100), $valoresCorrente, $idSimEquip, 'Saída corrente', 'm');
                                else{
                                    //GERA ALARME DE PROTOCOLO
                                }

                                if($valorValidoN > 0){
                                    $statusN   = comparaParametrosEquipamento(($_POST['N']/100), $valoresCorrente, $idSimEquip, 'Saída corrente', 'n');
                                }else{
                                    //GERA ALARME DE PROTOCOLO
                                }

                                if($valorValidoO > 0){
                                    $statusO    = comparaParametrosEquipamento(($_POST['O']/100), $valoresCorrenteSaida, $idSimEquip, 'Saída corrente', 'o');
                                }else{
                                    //GERA ALARME DE PROTOCOLO
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
                            $statusH   = comparaParametrosEquipamento(($_POST['H']/100), $valoresCorrente, $idSimEquip, 'Saída corrente', 'h');
                        }else{
                            //GERA ALARME DE PROTOCOLO
                        }

                        if($valorValidoP > 0){
                            $statusP    = comparaParametrosEquipamento(($_POST['P']/100), $valoresCorrenteSaida, $idSimEquip, 'Saída corrente', 'p');
                        }else{
                            //GERA ALARME DE PROTOCOLO
                        }

                        /*
                        * VERIFICA AS MEDIDAS DAS TEMPERATURAS
                        */

                        #Temperatura ambiente q
                        $valoresTeperaturaAmbiente         = explode('|', $configuracaoSalva[6]);
                        $valorValidoQ =  verificaProtocoloPosicaoTebela($_POST['Q'], $protocolos);

                        if($valorValidoQ > 0){
                            $statusQ    = comparaParametrosEquipamento(($_POST['Q']/100), $valoresCorrenteSaida, $idSimEquip, 'Temperatura ambiente', 'q');
                        }else{
                            //GERA ALARME DE PROTOCOLO
                        }

                        #Temperatura banco bateria r
                        $valoresTemperaturaBancoBat        = explode('|', $configuracaoSalva[7]);
                        $valorValidoR =  verificaProtocoloPosicaoTebela($_POST['R'], $protocolos);

                        if($valorValidoR > 0){
                            $statusR    = comparaParametrosEquipamento(($_POST['R']/100), $valoresCorrenteSaida, $idSimEquip, 'Temperatura Banco de bateria', 'r');
                        }else{
                            //GERA ALARME DE PROTOCOLO
                        }

                    break;
                }

            }

        }

        /*
        * FECHA A CONEXAO
        */
        $conn->close();


    }else{
        /*
        * RETORNA ERRO
        */
        header('HTTP/1.1 404 Not Found');
    }



/*
*
* FUNÇÕES QUE SERÃO UTILIZADAS NESTA ROTINA
*
*/

    /*
    * RETORNA VALOR CORRETO PARA A QUERY, CASO SEJA ENCONTRADO UM PROTOCOLO, IRÁ RETORNAR ZERO
    */
    function verificaValorPosicaoQuery($valor, $protocolos){
        if (array_key_exists($valor,$protocolos)){
            //Retorna o valor da array em caso o valor tenha sido retornado um dos protocolos
            return 0;
        }else{
            return $valor;
        }
    }

    /*
    * VERIFICA SE NÃO FOI PASSADO UM PROTOCOLO NO LUGAR DO VALOR
    */
    function verificaProtocoloPosicaoTebela($valor, $protocolos){

        //Procura na array de protocolos o valor passado pelo
        if (array_key_exists($valor,$protocolos)){
            //Retorna o valor da array em caso o valor tenha sido retornado um dos protocolos
            return $protocolos[$valor];
        }else{
            return 1;
        }
    }

    /*
    * CARREGAR OS EQUIPAMENTOS CADASTRADOS PELOS NÚMERO DE SIM
    */
    function carregaEquipamentosSim($numSim){

        $query = "SELECT
                    equip.id AS 'idEquipamento',
                    equip.tipo_equipamento,
                    equip.nomeModeloEquipamento,
                    simEquip.id AS 'simIdEquip'
                    FROM tb_equipamento equip
                    JOIN tb_sim_equipamento simEquip ON simEquip.id_equipamento = equip.id
                    WHERE simEquip.id_sim = $numSim AND equip.status_ativo = '1'";

        // CRIA UM OBJETO DE DA CLASSE DE CONEXAO
        $connBase   = new EficazDB;

        // MONTA A RESULT
        $result = $connBase->select($query);

        // Verifica se existe valor de retorno
        if (@mysql_num_rows ($result) > 0)
        {
            /* ARMAZENA NA ARRAY */
            while ($row = @mysql_fetch_assoc ($result))
            {
                $retorno[] = $row;
            }

        }else{
            // Se nao existir valor de retorno
            // Armazena 0 no vetor
            $retorno[] = 0;
        }

        // Fecha a conexao
        $connBase->close();

        return $retorno;

    }

    /*
    * CARREGA OS PARAMETROS DEFINIDOS PARA O SIM INFORMADO
    */
    function carregaParamentrosSim($simNumero){

        $parametros = "SELECT parametro, num_sim, id_equipamento, id_sim_equipamento FROM tb_parametro WHERE num_sim = '$simNumero' AND status_ativo = '1'";

        // CRIA UM OBJETO DE DA CLASSE DE CONEXAO
        $conn   = new EficazDB;

        // Monta a result com os parametros
        $result = $conn->select($parametros);

        /*
        * VERIFICA SE EXISTE RESPOSTA
        */
        if ($result)
        {
            /* VERIFICA SE EXISTE VALOR */
            if (@mysql_num_rows($result) > 0)
            {
                /* ARMAZENA NA ARRAY */
                while ($row = @mysql_fetch_assoc ($result))
                {
                    $retorno[] = $row;
                }

                $dados = $retorno;
            }
        }else{
            $dados = false;
        }

        return $dados;
    }

    /*
    * CARREGAR DADOS DO EQUIPAMENTO DE NO BREAK, PARA VERIFICAÇÂO DE TIPOS DE ENTRADA
    */
    function carregarDadosEquip($idSimEquip){

        // CRIA UM OBJETO DE DA CLASSE DE CONEXAO
        $connBase   = new EficazDB;

        $query  = "SELECT
                    equip.id,
                    equip.nomeModeloEquipamento,
                    tipoEquip.tipo_equipamento,
                    simEquip.ambiente,
                    clieInfo.nome AS 'cliente',
                    fili.nome AS 'filial',
                    equip.tipo_entrada,
                    equip.tipo_saida,
                    equip.quantidade_bateria_por_banco,
                    equip.tensaoMinBarramento,
                    equip.correnteBancoBateria,
                    equip.potencia
                    FROM tb_equipamento equip
                    JOIN tb_sim_equipamento simEquip ON equip.id = simEquip.id_equipamento
                    JOIN tb_cliente clieInfo ON clieInfo.id = equip.id_cliente
                    LEFT JOIN tb_filial fili ON equip.id_filial = fili.id_matriz
                    JOIN tb_tipo_equipamento tipoEquip ON equip.tipo_equipamento = tipoEquip.id
                    WHERE simEquip.id = '$idSimEquip'";

        // Monta a result
        $result = $connBase->select($query);

        // Verifica se existe valor de retorno
        if (@mysql_num_rows ($result) > 0)
        {
            /* ARMAZENA NA ARRAY */
            while ($row = @mysql_fetch_assoc ($result))
            {
                $retorno[] = $row;
            }

        }else{
            // Se nao existir valor de retorno
            // Armazena 0 no vetor
            $retorno[] = 0;
        }

        // Fecha a conexao
        $connBase->close();

        return $retorno;
    }

    /*
    * EFETUA O CALCULO DO VALOR DE TEMPO ESTIMADO POR HORA PARA BATERIAS
    * Esta função devolve o valor da corrente continua que o No BREAK
    * necessita para manter a carga durante 1 hora
    */
    function calcularTempoEstimadoHora($potenciaSaida, $quantidadeBateria, $tensaoMinBat, $fatorErro = 1.5){

        $tempoEstimadoPorHora = (($potenciaSaida * 1000) * $fatorErro) / ($quantidadeBateria * $tensaoMinBat);

        return $tempoEstimadoPorHora;
    }

    /*
    * RECEBE OS DADOS DE POTENCIA DE SAIDA PARA SALVAR NO BANCO DE DADOS
    * O NÚMERO SIM, A POTÊNCIA, DATA E HORA E O STATUS DE VALOR DE ENTRADA
    */
    function salvarDadosPotenciaConsmida($numeroSim, $idEquipamento, $totalPotenciaConsumida, $statusEntrada, $tempoEstHora){

        // CRIA UM OBJETO DE DA CLASSE DE CONEXAO
        $connBase   = new EficazDB;

        $query  = "INSERT INTO tb_dados_potencia
                    ( id_equipamento, num_sim, potencia_saida, tempoEstimadoHora, status_entrada )
                    VALUES
                    ('$idEquipamento', '$numeroSim', '$totalPotenciaConsumida', '$tempoEstHora', '$statusEntrada')";

        $connBase->query($query);

        // Fecha a conexao
        $connBase->close();

    }
?>
