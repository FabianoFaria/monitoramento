<?php

/*
* SEXTA VERSÃO DO DATASYNC.
* CARACTERISTICAS DESTA VERSÃO:
* ATUALIZAÇÃO DE CONEXÃO DE BD COM PDO E PREPARED STATEMENT
* RECEBER E GUARDAR OS DADOS RECEBIDO DO EQUIPAMENTO
* CONFORME OS TIPOS DE ENTRADA E SAÍDA DO EQUIPAMENTO EFETUAR OS TESTES DOS PARAMETROS E GERAR ALARME
* CONFORME AS ENTRADAS E SAÍDAS, CALCULAR A POTENCIA CONSUMIDA E SALVAR NO BANCO
* QUANDO DETECTADO QUEDA DE ENERGIA, INICIAR PPROCESSO DE CALCULO DE AUTONOMIA DA BATERIA
* ADIÇÃO DE TESTE DE FALSO POSITIVO PARA OS ALARMES DE CRÍTICO BAIXO ( EVITAR O PROBLEMA DE HARDWARE MANDAR ZERO E LOGO EM SEGUIDA MANDAR OS DADOS CORRETAMENTE )
* FAZER DISCRIMINAÇÃO DO TIPO DE EQUIPAMENTO QUE ESTÁ MANDANDO DADOS.
*/

/*
* INCLUI A CLASSE DE CONEXA
*/

/* mostra todos os erros */
error_reporting(E_ALL);
ini_set("display_errors",1);



define('EFIPATH', dirname(__FILE__));
require_once EFIPATH ."/classes/class-EficazDB.php";
require_once EFIPATH ."/classes/class-email.php";

/*
* VALIDA OS CAMPOS DO POST
*/

//VERIFICA SE O CHIP SIM ESTÁ ATIVO NO SISTEMA ANTES DE INICIAR O PROCESSO DE VALIDAÇÃO DOS DADOS

if(isset($_POST['A']) && isset($_POST['B']) && isset($_POST['C']) && isset($_POST['D']) &&
   isset($_POST['E']) && isset($_POST['F']) && isset($_POST['G']) && isset($_POST['H']) &&
   isset($_POST['I']) && isset($_POST['J']) && isset($_POST['L']) && isset($_POST['M']) &&
   isset($_POST['N']) && isset($_POST['O']) && isset($_POST['P']) && isset($_POST['Q']) &&
   isset($_POST['R']) && isset($_POST['S']) && isset($_POST['T']) && isset($_POST['U'])){


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
    * EM FUTURAS VERSÕES, EFETUAR UM INCLUDE OU UMA QUERY DO BD
    */
    require_once EFIPATH."/protocolosDisponiveis.php";

    //VERIFICA SE CHIP SIM ESTÁ ATIVO NO SISTEMA

    $chipExiste = chipSimExistente($_POST['A']);


    if($chipExiste){

        // MONTA A QUERY PARA GUARDAR OS DADOS RECEBIDOS
        $valor = "insert into tb_dados (num_sim,b,c,d,e,f,g,h,i,j,l,m,n,o,p,q,r,s,t,u) values
                    ('{$_POST['A']}','{$_POST['B']}','{$_POST['C']}','{$_POST['D']}','{$_POST['E']}','{$_POST['F']}','{$_POST['G']}',
                    '{$_POST['H']}','{$_POST['I']}','{$_POST['J']}','{$_POST['L']}','{$_POST['M']}','{$_POST['N']}','{$_POST['O']}',
                    '{$_POST['P']}','{$_POST['Q']}','{$_POST['R']}','{$_POST['S']}','{$_POST['T']}','{$_POST['U']}')";

        /*
        * EXECUTA A QUERY NO BANCO E VERIFICA SE RETORNO ERRO
        */

        /* MONTA A RESULT */
        $result = $conn->query($valor);

        if (!$result)
        {
            // Monta a query de log
            $query = "insert into tb_log (log)  values ('Erro ao gravar os valores da tabela respota; SIM [{$_POST['A']}]')";

            // Grava o log
            $conn->query($query);

            // Retona o erro
            header('HTTP/1.1 404 Not Found');
            // Finaliza a execucao
            exit();
        }

        //FIM DO PROCESSO DE SALVAR OS DADOS RECEBIDOS.


        /*
        INICIA O PROCESSO DE VERIFICAÇÃO DE ALARME
        */

        /*
        * CARREGA OS TIPOS DE EQUIPAMENTOS CADASTRADOS COM O SIM
        */
        $equipamentosSim = carregaEquipamentosSim($_POST['A']);

        /*
        * CARREGA OS PARAMETROS DEFINIDOS PARA O SIM INFORMADO
        */
        $dados = carregaParamentrosSim($_POST['A']);

        //var_dump($equipamentosSim, $dados);


        /*
        * TESTA O TIPO DE EQUIPAMENTO QUE ENVIOU PARA ENTÃO EFETUAR O TRATAMENTO DE ALARMES
        */

        switch ($equipamentosSim[0]['tpEquipamento']) {
            case 'Medidor temperatura':
                require_once EFIPATH ."/tratamento_medidorTemperatura.php";
            break;

            case 'No-break':
                require_once EFIPATH ."/tratamento_nobreak.php";
            break;
        }

    }


}


/*
*
* FUNÇÕES QUE SERÃO UTILIZADAS NESTA ROTINA
*
*/


    /*
    * INICIA O PROCESSO DE PROCURA DE CONTATOS PARA ENVIO DE ALERTA
    */
    function carregarContatosAlerta($idSimEquipamento){
        // CRIA UM OBJETO DE DA CLASSE DE CONEXAO
        $connBase      = new EficazDB;

        $queryContatos = "SELECT contAlert.id_cliente, contAlert.id_filial, contAlert.nome_contato, contAlert.email, contAlert.celular
                            FROM tb_contato_alerta contAlert
                            JOIN tb_sim sim ON sim.id_cliente = contAlert.id_cliente
                            JOIN tb_sim_equipamento simEquip ON simEquip.id_sim = sim.num_sim
                            WHERE simEquip.id = '$idSimEquipamento'";

        // Monta a result
        $result = $connBase->select($queryContatos);

        // // Verifica se existe valor de retorno
        // if (@mysql_num_rows ($result) > 0)
        // {
        if(!empty($result)){

            // /* ARMAZENA NA ARRAY */
            // while ($row = @mysql_fetch_assoc ($result))
            // {
            //     $retorno[] = $row;
            // }
            foreach ($result as $row) {
                $retorno[] = $row;
            }

        }else{
            // Se nao existir valor de retorno
            // Armazena 0 no vetor
            $retorno[] = 0;
        }

        // Fecha a conexao
        //$connBase->close();

        return $retorno;
    }

    /*
    * INICIA O PROCESSO DE PROCURA DE CONTATOS PARA ENVIO DE ALERTA DE DETERMINADO EQUIPAMENTO
    */
    function carregarContatosAlertaEquipamento($idSimEquipamento){

        // CRIA UM OBJETO DE DA CLASSE DE CONEXAO
        $connBase      = new EficazDB;

        $queryContatos = "SELECT contAlert.id_cliente, contAlert.id_filial, contAlert.nome_contato, contAlert.email, contAlert.celular
                            FROM tb_contato_alerta_equip contAlert
                            JOIN tb_sim sim ON sim.id_cliente = contAlert.id_cliente
                            JOIN tb_sim_equipamento simEquip ON simEquip.id_sim = sim.num_sim
                            WHERE simEquip.id = '$idSimEquipamento'";

        // Monta a result
        $result = $connBase->select($queryContatos);

        // Verifica se existe valor de retorno
        //if (@mysql_num_rows ($result) > 0){
        if(!empty($result)){
            /* ARMAZENA NA ARRAY */
            // while ($row = @mysql_fetch_assoc ($result))
            // {
            //     $retorno[] = $row;
            // }
            foreach ($result as $row) {
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
    * INICIA O PROCESSO DE REGISTRO DE ALARME
    */
    function gerarAlarmeEquipamento($idEquipSim, $parametroEnviado, $parametroViolado, $parametroAvaliado, $tipoAlarme, $nivelAlarme, $pontoTabela){

        // Cria um objeto de da classe de conexao
        $connBase = new EficazDB;

        $data = date('Y-m-d H:i:s');

        //REGISTRA O ALARME NO SISTEMA
        $queryAlarme = "INSERT INTO tb_alerta(id_sim_equipamento, id_msg_alerta, nivel_alerta, dt_criacao)
                        VALUES ('$idEquipSim', '$tipoAlarme', '$nivelAlarme', '$data')";

        $result = $connBase->query($queryAlarme);

        //$idGerada  = mysql_insert_id();

        if(is_numeric($result)){
            $idGerada = $result;
        }else{
            $idGerada = null;
        }

        //$idGerada = $connBase->lastInsertId();

        if(!$result)
        {
            // Monta a query de log
            $query = "insert into tb_log (log)  values ('Erro ao tentar registrar um alerta para o equipamento de id_sim :".$idEquipSim."')";

            // Grava o log
            $connBase->query($query);

            // Retona o erro
            header('HTTP/1.1 404 Not Found');
            // Finaliza a execucao
            exit();
        }

        //$idAlarme = mysql_insert_id();
        //$idAlarme = $connBase->lastInsertId();
        if(is_numeric($result)){
            $idAlarme = $result;
        }else{
            $idAlarme = null;
        }

        //REGISTRA OS DETALHES DO ALARME PARA CONSULTA PELO MONITOR
        $queryDetalheAlarme = "INSERT INTO tb_tratamento_alerta(id_alerta, parametro, parametroMedido, parametroAtingido, pontoTabela)
                                VALUES ('$idAlarme', '$parametroAvaliado', '$parametroEnviado', '$parametroViolado', '$pontoTabela')";

        // Grava no DB
        $resultadoDetalhes = $connBase->query($queryDetalheAlarme);

        if(!$resultadoDetalhes)
        {
            // Monta a query de log
            $query = "insert into tb_log (log)  values ('Erro ao tentar registrar um alerta para o equipamento de id_sim :".$idEquipSim."')";

            // Grava o log
            $connBase->query($query);

            // Retona o erro
            header('HTTP/1.1 404 Not Found');
            // Finaliza a execucao
            exit();
        }else{

            // Fecha a conexao
            $connBase->close();

            // Retorna mensagem de sucesso
            //header ('HTTP/1.1 200 OK');
        }
    }

    /*
    * CARREGA A MENSAGEM DE ALERTA
    */
    function carregarMensagemAlerta($idMensagem){

        // Cria um objeto de da classe de conexao
        $connBase    = new EficazDB;

        // Um alerta com status 5 sinaliza que está finalizado, abixo disso, ainda está ativo
        $queryAlarme = "SELECT mensagem FROM tb_msg_alerta WHERE id = '$idMensagem'";

        // Monta a result com os parametros
        $result = $connBase->select($queryAlarme);

        if(!empty($result)){

            foreach ($result as $row) {
                $retorno[] = $row;
            }

            return $retorno;

        }else{

            // echo  "Nada encontrado";
            return false;
        }
    }

    /*
    * VERIFICA SE JÁ EXISTE ALGUM ALARME ATIVO PARA O EQUIPAMENTO
    */
    function verificarAlarmeExistente($idEquipSim, $tipoAlerta){

        //PROCURA NA TABELA DE ALARME, ALGUM REGISTRO DO EQUIPAMENTO COMPROMETIDO
        // Cria um objeto de da classe de conexao
        $connBase    = new EficazDB;

        $queryAlarme = "SELECT alert.id
                        FROM tb_alerta alert
                        JOIN tb_tratamento_alerta trat_alert ON trat_alert.id_alerta = alert.id
                        WHERE id_sim_equipamento = '$idEquipSim' AND  status_ativo < 4 AND trat_alert.pontoTabela = '$tipoAlerta'";

        // Monta a result com os parametros
        $result = $connBase->select($queryAlarme);

        if(!empty($result)){

            return true;

        }else{

            // echo  "Nada encontrado";
            return false;
        }

    }

    /*
    *  Trata as strings dos valores das configurações dos equipamento
    */
    function trataValorDataSync($valor){
        //Formato da string esperado : 'et1-2-0'
        $temp = explode("-", $valor);
        return (float) $temp[1];
    }

    /*
    * RECEBE A ARRAY COM OS PARAMETROS DE DETERMINADA ENTRADA DE TENSÃO, CORRENTE, BATERIA E TEMPERATURA VARIAVEL PARA COMPARAÇÃO
    * AQUI OCORRE A VERIFICAÇÃO SE O PARAMETRO GEROU ALARME OU NÃO
    */
    function comparaParametrosEquipamento($parametro, $configuacoes, $idSimEquip, $ParametroVerificado, $pontoTabela){

        /*
        * TESTA OS PARAMETROS ATRAVÉS DE IF E ELSES
        */
        if($parametro > (float) trataValorDataSync($configuacoes[4])){
            /*
            * VERIFICA ALERTA EXISTNTE E TENTA GERAR ALERTA PARA ALTO
            */
            $alarmeExiste = verificarAlarmeExistente($idSimEquip, $pontoTabela);

            if(!$alarmeExiste){

                gerarAlarmeEquipamento($idSimEquip, $parametro, (float) trataValorDataSync($configuacoes[3]), $ParametroVerificado, 5, 1, $pontoTabela);
            }
        }elseif($parametro < (float) trataValorDataSync($configuacoes[0])){
            /*
            * VERIFICA ALERTA EXISTNTE E TENTA GERAR ALERTA PARA CRITICO BAIXO
            */
            $alarmeExiste = verificarAlarmeExistente($idSimEquip, $pontoTabela);

            /*
            * CARREGA O PEULTIMO DADO PARA CONFIMAR SE NÃO SE TRATA DE UM FALSO POSITIVO
            */
            $penultimoDado  = identificarFalsoPositivo($idSimEquip, $pontoTabela);

            //COMPARA O PENULTIMO DADO COM O PARAMETRO ATUAL
            if(($penultimoDado[0][$pontoTabela] / 100) < (float) trataValorDataSync($configuacoes[0])){
                $falsoPositivo = true;
            }else{
                $falsoPositivo = false;
            }

            // CASO NÃO EXISTA UM ALARME REGISTRADO E NÃO SEJA CASO DE FALSO POSITIVO
            if(!$alarmeExiste && $falsoPositivo){

                /*
                * GERAR ALARME
                */
                gerarAlarmeEquipamento($idSimEquip, $parametro, (float) trataValorDataSync($configuacoes[1]), $ParametroVerificado, 2 ,2, $pontoTabela);

                /*
                * INICIA O PROCESSO DE ENVIO DE EMAIL PARA O RESPONSAVEL
                */
                //Carrega a mensagem de alerta
                $msgAlerta          = carregarMensagemAlerta(2);
                $msgAlerta          = $msgAlerta[0]['mensagem'];
                //Parametros violados
                $indiceRecebido     = $parametro;
                $indiceUltrapassado = (float) trataValorDataSync($configuacoes[1]);

                //Carrega as informações do equipamento que gerou o alarme
                $equipamentoAlerta  = carregarDadosEquip($idSimEquip);

                //var_dump($equipamentoAlerta);

                //Procura os contatos para envio de alerta da tabela tb_contato_alerta
                $listaContatos      = carregarContatosAlerta($idSimEquip);

                $listaContatosEquip = carregarContatosAlertaEquipamento($idSimEquip);

                // Cria um objeto de da classe de email
                $mailer             = new email;

                /*
                * Verifica se a lista de contatos não está vazia, então inicia o envio de emails
                */
                if(!empty($listaContatos)){
                    //var_dump($retorno);

                    foreach ($listaContatos as $contato) {

                        //CHAMA A FUNÇÃO PARA EFETUAR O ENVIO DE EMAIL PARA CADA UM DOS CONTATOS

                        $localEquip = (isset($equipamentoAlerta[0]['filial'])) ? ' filial '.$equipamentoAlerta[0]['filial'] : 'Matriz';

                        $mailer->envioEmailAlertaEquipamento($contato['email'], $contato['nome_contato'], $equipamentoAlerta[0]['tipo_equipamento'], $equipamentoAlerta[0]['nomeModeloEquipamento'], "", $equipamentoAlerta[0]['ambiente'], $msgAlerta, $equipamentoAlerta[0]['cliente'], $localEquip, $indiceRecebido, $indiceUltrapassado, $ParametroVerificado, $pontoTabela);
                    }
                }

                /*
                * Verifica se a lista de contatos do equipamento não está vazia, então inicia o envio de emails
                */
                if(!empty($listaContatosEquip)){

                    foreach ($listaContatosEquip as $contato) {
                        //CHAMA A FUNÇÃO PARA EFETUAR O ENVIO DE EMAIL PARA CADA UM DOS CONTATOS

                        var_dump($contato);

                        $localEquip = (isset($equipamentoAlerta[0]['filial'])) ? ' filial '.$equipamentoAlerta[0]['filial'] : 'Matriz';

                        $mailer->envioEmailAlertaEquipamento($contato['email'], $contato['nome_contato'], $equipamentoAlerta[0]['tipo_equipamento'], $equipamentoAlerta[0]['nomeModeloEquipamento'], "", $equipamentoAlerta[0]['ambiente'], $msgAlerta, $equipamentoAlerta[0]['cliente'], $localEquip, $indiceRecebido, $indiceUltrapassado, $ParametroVerificado, $pontoTabela);
                    }
                }
            }
        }elseif($parametro < (float) trataValorDataSync($configuacoes[1])){

            $alarmeExiste = verificarAlarmeExistente($idSimEquip, $pontoTabela);

            if(!$alarmeExiste){

                /*
                * GERAR ALARME
                */
                gerarAlarmeEquipamento($idSimEquip, $parametro, (float) trataValorDataSync($configuacoes[1]), $ParametroVerificado, 4, 1, $pontoTabela);
            }
        }else{
            //Nada acontece
            echo "OK ! ".$parametro."<br>";
        }

    }

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
                    tbEquip.tipo_equipamento AS 'tpEquipamento',
                    simEquip.id AS 'simIdEquip'
                    FROM tb_equipamento equip
                    JOIN tb_sim_equipamento simEquip ON simEquip.id_equipamento = equip.id
                    LEFT JOIN tb_tipo_equipamento tbEquip ON tbEquip.id = equip.tipo_equipamento
                    WHERE simEquip.id_sim = $numSim AND equip.status_ativo = '1'";

        // CRIA UM OBJETO DE DA CLASSE DE CONEXAO
        $connBase   = new EficazDB;

        // MONTA A RESULT
        $result = $connBase->select($query);

        // Verifica se existe valor de retorno
        // if (@mysql_num_rows ($result) > 0)
        // {
        if(!empty($result)){
            /* ARMAZENA NA ARRAY */
            // while ($row = @mysql_fetch_assoc ($result))
            // {
            //     $retorno[] = $row;
            // }
            foreach ($result as $row) {
                $retorno[] = $row;
            }

        }else{
            // Se nao existir valor de retorno
            // Armazena 0 no vetor
            $retorno[] = 0;
        }

        // Fecha a conexao
        //$connBase->close();

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
        if(!empty($result))
        {
            // /* VERIFICA SE EXISTE VALOR */
            // if (@mysql_num_rows($result) > 0)
            // {
            //     /* ARMAZENA NA ARRAY */
            //     while ($row = @mysql_fetch_assoc ($result))
            //     {
            //         $retorno[] = $row;
            //     }
            //
            //     $dados = $retorno;
            // }
            foreach ($result as $row) {
                $retorno[] = $row;
            }

             $dados = $retorno;

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
        // if (@mysql_num_rows ($result) > 0)
        // {
        if(!empty($result)){

            /* ARMAZENA NA ARRAY */
            // while ($row = @mysql_fetch_assoc ($result))
            // {
            //     $retorno[] = $row;
            // }
            foreach ($result as $row) {
                $retorno[] = $row;
            }
        }else{
            // Se nao existir valor de retorno
            // Armazena 0 no vetor
            $retorno[] = 0;
        }

        // Fecha a conexao
        //$connBase->close();

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
    function salvarDadosPotenciaConsmida($numeroSim, $idEquipamento, $totalPotenciaConsumida, $statusEntrada, $tempoEstHora, $potenciaEntradaR, $potenciaEntradaS, $potenciaEntradaT, $potenciaR, $potenciaS, $potenciaT){

        // CRIA UM OBJETO DE DA CLASSE DE CONEXAO
        $connBase   = new EficazDB;

        $query  = "INSERT INTO tb_dados_potencia
                    ( id_equipamento, num_sim, potencia_saida, tempoEstimadoHora, status_entrada , er, es, et, cr, cs, ct)
                    VALUES
                    ('$idEquipamento', '$numeroSim', '$totalPotenciaConsumida', '$tempoEstHora', '$statusEntrada', '$potenciaEntradaR', '$potenciaEntradaS','$potenciaEntradaT','$potenciaR','$potenciaS','$potenciaT')";

        $connBase->query($query);

        // Fecha a conexao
        //$connBase->close();
    }

    /*
    * FUNÇÃO PARA RECUPERAR O PENULTIMO DADO PARA COMPARACAO E POSSIVEL CONFIRMAÇÂO DE FALSO POSITIVO
    */
    function identificarFalsoPositivo($sim_num, $posicao){

        // CRIA UM OBJETO DE DA CLASSE DE CONEXAO
        $connBase     = new EficazDB;

        $queryPosicao = "SELECT $posicao
                         FROM tb_dados dados
                         JOIN tb_sim_equipamento simEquip ON dados.num_sim = simEquip.id_sim
                         WHERE simEquip.id = '$sim_num' AND simEquip.status_ativo = '1'
                         GROUP BY dados.id DESC
                         LIMIT 1,1";

        //var_dump($queryPosicao);

        // Monta a result
        $result = $connBase->select($queryPosicao);

        // Verifica se existe valor de retorno
        //if (@mysql_num_rows ($result) > 0)
        //{
        if(!empty($result)){

            /* ARMAZENA NA ARRAY */
            // while ($row = @mysql_fetch_assoc ($result))
            // {
            //     $retorno[] = $row;
            // }
            foreach ($result as $row) {
                $retorno[] = $row;
            }

        }else{
            // Se nao existir valor de retorno
            // Armazena 0 no vetor
            $retorno[] = 0;
        }

        // Fecha a conexao
        //$connBase->close();


        return $retorno;
    }

    /*
    * FUNÇÃO PARA VERIFICAR A EXISTENCIA DO CHIP SIM QUE ESTÀ TENTANDO ENVIAR DADOS
    */
    function chipSimExistente($sim_num){

        // CRIA UM OBJETO DE DA CLASSE DE CONEXAO
        $connBase       = new EficazDB;

        //Exemplo
        $query = "SELECT num_sim FROM tb_sim WHERE num_sim = '$sim_num' AND status_ativo = '1'";
        //$query = $connBase->prepare("SELECT num_sim FROM tb_sim WHERE num_sim = ? AND status_ativo = ?");

        //$stmt->execute(array($_GET['name'])

        // $query->execute(array($sim_num, '1'));
        // Monta a result
        $result = $connBase->select($query);

        if(!empty($result)){

            return true;

        }else{

            return false;

        }

        // // executamos o statement
        // $ok = $stmt->execute();
        //
        // // agora podemos pegar os resultados (partimos do pressuposto que não houve erro)
        // $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    }


?>
