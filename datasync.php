<?php

// Inclui a classe de conexa
require_once "classes/class-EficazDB.php";
require_once "classes/class-email.php";

// Valida os campos do post
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

    // VERIFICA SE EXISTE ERRO DE CONEXAO
    if (!$conn)
    {
        // Retorno erro
        header('HTTP/1.1 404 Not Found');
        // Finaliza a execucao
        exit();
    }

    // MONTA A QUERY
    $valor = "insert into tb_dados (num_sim,b,c,d,e,f,g,h,i,j,l,m,n,o,p,q,r,s,t,u) values
                  ('{$_POST['A']}','{$_POST['B']}','{$_POST['C']}','{$_POST['D']}','{$_POST['E']}','{$_POST['F']}','{$_POST['G']}',
                   '{$_POST['H']}','{$_POST['I']}','{$_POST['J']}','{$_POST['L']}','{$_POST['M']}','{$_POST['N']}','{$_POST['O']}',
                   '{$_POST['P']}','{$_POST['Q']}','{$_POST['R']}','{$_POST['S']}','{$_POST['T']}','{$_POST['U']}')";

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

    //VERIFICA OS PARAMETROS RECEBIDOS PARA IDENTIFICAR O EQUIPAMENTO
    $tipoEquipamento = 0;

    if(isset($_POST['B']) && $_POST['B'] != 0){
        //RECEBENDO DADOS DE NOBREAKS
        $tipoEquipamento = 1;

    }elseif((isset($_POST['P']) && ($_POST['P'] != 0)) || (isset($_POST['Q']) && ($_POST['Q'] != 0))){
        //RECEBENDO DE MEDIDORES DE TEMPERATURAS
        $tipoEquipamento = 2;

    }elseif(isset($_POST['R']) || isset($_POST['S']) || isset($_POST['T'])){
        //RECEBENDO DE ENTRADAS DIGITAIS
    }

    //CARREGA OS PARAMETROS DEFINIDOS PARA O SIM INFORMADO
    $simNumero  = $_POST['A'];

    $parametros = "SELECT parametro, num_sim, id_equipamento, id_sim_equipamento FROM tb_parametro WHERE num_sim = '$simNumero' AND status_ativo = '1'";

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

    /*
    * EXTRAIR APENAS OS PARAMETROS
    */
    if($dados){

        /*
        * DEVIDO AO FATO DE EXISTIR MAIS DE UM TIPO DE EQUIPAMENTO
        * IMPLEMENTAR UMA FORMA DE TRABALHAR COM OS DEMAIS TIPOS DE CONFIGURAÇÔES QUE PODERAM VIR
        */

        /*
        * VERIFICAR SE A VARIAVEL $dados[0]['id_sim_equipamento'] NÃO RESOLVE O PROBLEMA
        */

        /*
        * COM OS PARAMETROS CARREGADOS, INICIA A COMPARAÇÃO COM OS DADOS RECEBIDOS
        */
        $parametros = $dados[0]['parametro'];
        $idSimEquip = $dados[0]['id_sim_equipamento'];
        //var_dump($parametros);

        $configuracaoSalva = explode('|inicio|',$parametros);

        //var_dump($configuracaoSalva);
        $valoresEntrada         = explode('|', $configuracaoSalva[1]);

        //var_dump($valoresEntrada);

        //TESTA OS VALORES DE ENTRADA
        $statusB                = comparaParametrosEquipamento(($_POST['B']/10), $valoresEntrada, $idSimEquip, 'Tensão', 'b');
        $statusC                = comparaParametrosEquipamento(($_POST['C']/10), $valoresEntrada, $idSimEquip, 'Tensão', 'c');
        $statusD                = comparaParametrosEquipamento(($_POST['D']/10), $valoresEntrada, $idSimEquip, 'Tensão', 'd');

        $valoresSaida           = explode('|', $configuracaoSalva[2]);
        //TESTA OS VALORES DE SAÍDA
        $statusE                = comparaParametrosEquipamento(($_POST['E']/10), $valoresSaida, $idSimEquip, 'Saída tensão', 'e');
        $statusF                = comparaParametrosEquipamento(($_POST['F']/10), $valoresSaida, $idSimEquip, 'Saída tensão', 'f');
        $statusG                = comparaParametrosEquipamento(($_POST['G']/10), $valoresSaida, $idSimEquip, 'Saída tensão', 'g');

        $valoresBateria         = explode('|', $configuracaoSalva[3]);
        //TESTA OS VALORES DA BATERIA
        $statusH                = comparaParametrosEquipamento($_POST['I'], $valoresBateria, $idSimEquip, 'Bateria', 'h');

        $valoresCorrente        = explode('|', $configuracaoSalva[4]);
        //TESTA OS VALORES DE CORRENTE
        //$statusI                = comparaParametrosEquipamento(($_POST['I']/10), $valoresCorrente, $idSimEquip, 'Corrente', 'i');
        $statusJ                = comparaParametrosEquipamento(($_POST['J']/10), $valoresCorrente, $idSimEquip, 'Corrente', 'j');
        $statusL                = comparaParametrosEquipamento(($_POST['L']/10), $valoresCorrente, $idSimEquip, 'Corrente', 'l');

        $valoresCorrenteSaida   = explode('|', $configuracaoSalva[5]);
        //TESTA OS VALORES DE SAÍDA DE CORRENTE
        $statusM                = comparaParametrosEquipamento(($_POST['M']/10), $valoresCorrenteSaida, $idSimEquip, 'Saída corrente', 'm');
        $statusN                = comparaParametrosEquipamento(($_POST['N']/10), $valoresCorrenteSaida, $idSimEquip, 'Saída corrente', 'n');
        $statusO                = comparaParametrosEquipamento(($_POST['O']/10), $valoresCorrenteSaida, $idSimEquip, 'Saída corrente', 'o');

    }else{
        //var_dump($dados);
        $parametros = 0;
    }


    /*
    * EFETUA A AÇÃO DE ACORDO COM O RESULTADO DA COMPARAÇÃO
    */

    // Converte a entrada em inteiro
    $vint[] = intval($_POST['E']);
    $vint[] = intval($_POST['F']);
    $vint[] = intval($_POST['G']);

    /*
    * VERIFICA SE A ENTRADA ESTA ZERADA
    */
    if ($vint[0] == 0 && $vint[1] == 0 && $vint[2] == 0)
    {
        // Monta a query da ultama insercao do dado
        $query = "SELECT dt_criacao,e,f,g FROM tb_dados WHERE num_sim = {$_POST['A']} AND
                  E > 0 OR F > 0 OR G > 0 ORDER BY (dt_criacao) DESC LIMIT 1";
        // Busca a primeira data da insecao do ultimo dado
        $resp[] = verifiSele($query,$conn);

        // Monta a query para busca a data de insercao da ultima falta
        $query = "select dt_criacao from tb_numero_falta where id_num_sim = {$_POST['A']} order by (dt_criacao) desc limit 1";
        // Busca os valores da ultima insercao da ultima falta
        $resp[] = verifiSele($query, $conn);

        // Substitui os tracos por barra
        $resp[0][0] = strtotime(str_replace("-","/",$resp[0][0]));
        $resp[1][0] = strtotime(str_replace("-","/",$resp[1][0]));

        // Cria as datas
        $dt1 = date("Y/m/d H:i:s",$resp[0][0]);
        $dt2 = date("Y/m/d H:i:s",$resp[1][0]);

        // Verifica se a ultima falta eh menor que o ultimo dado
        if ($dt2 < $dt1 && isset($dt1) && !empty($dt1))
        {
            // Se a ultima falta for menor que o ultimo dado
            // Monta a query para salvar uma falta
            $query = "insert into tb_numero_falta (id_num_sim) values ('{$_POST['A']}')";

            // Executa a query
            if (!$conn->query($query))
            {
                // Monta a query de log
                $query = "insert into tb_log (log)  values ('Erro ao grava o numero de faltas; numero do sim [{$_POST['A']}]')";
                // Grava o log
                $conn->query($valor);
            }
        }
    }

    // Fecha a conexao
    $conn->close();

    // Retorna mensagem de sucesso
    //header ('HTTP/1.1 200 OK');
}
else
    // Retorna erro
    header('HTTP/1.1 404 Not Found');


/**
 * Funcao que verifica se existe valores no select
 *
 * @param string $query - recebe uma string  com a query que sera realizada
 * @param array $conn   - recebe a conexao como parametro
 *
 * @return array $retorno - resultado do select
 */
function verifiSele($query,$conn)
{
    // Monta a result
    $result = $conn->select($query);

    // Verifica se existe valor de retorno
    if (@mysql_num_rows ($result) > 0)
    {
        // Coleta os dados
        while ($row = @mysql_fetch_assoc($result))
            $retorno[] = $row['dt_criacao'];
    }
    // Se nao existir valor de retorno
    // Armazena 0 no vetor
    $retorno[] = 0;

    // Retorna o resultado
    return $retorno;
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
* FUNÇÃO PARA RELATAR QUEDA NO EQUIPAMENTO EM CASO DE BAIXA OU ALTA TENSÃO
*/
function registraFalhaEquipamento($idSim){

    // MONTA A QUERY PARA SALVAR UMA FALTA
    $query = "insert into tb_numero_falta (id_num_sim) values ('$idSim')";

    // Executa a query
    if (!$conn->query($query))
    {
        // Monta a query de log
        $query = "insert into tb_log (log)  values ('Erro ao grava o numero de faltas; numero do sim [{$_POST['A']}]')";
        // Grava o log
        $conn->query($valor);
    }
}

/*
* RECEBE A ARRAY COM OS PARAMETROS DE DETERMINADA ENTRADA DE TENSÃO VARIAVEL PARA COMPARAÇÃO
*/
function comparaParametrosEquipamento($parametro, $configuacoes, $idSimEquip, $ParametroVerificado, $pontoTabela){

    //var_dump($configuacoes);

    /*
    * TESTA OS PARAMETROS ATRAVÉS DE IF E ELSES
    */
    if($parametro > (float) trataValorDataSync($configuacoes[4])){
        /*
        * GERAR ALERTA
        */
        $alarmeExiste = verificarAlarmeExistente($idSimEquip, 2);

        //var_dump($alarmeExiste);

        if(!$alarmeExiste){
            gerarAlarmeEquipamento($idSimEquip, $parametro, (float) trataValorDataSync($configuacoes[3]), $ParametroVerificado, 3, 2, $pontoTabela);

            /*
            * REGISTRA FALHA
            */
            //registraFalhaEquipamento($_POST['A']);

            /*
            * INICIA O PROCESSO DE ENVIO DE EMAIL PARA O RESPONSAVEL
            */

            //Carrega a mensagem de alerta
            $msgAlerta          = carregarMensagemAlerta(3);
            $msgAlerta          = $msgAlerta[0]['mensagem'];
            //Parametros violados
            $indiceRecebido     = $parametro;
            $indiceUltrapassado = (float) trataValorDataSync($configuacoes[3]);

            //Carrega as informações do equipamento que gerou o alarme
            $equipamentoAlerta  = carregarDadosEquip($idSimEquip);

            // var_dump($msgAlerta);

            //Procura os contatos para envio de alerta da tabela tb_contato_alerta
            $listaContatos      = carregarContatosAlerta($idSimEquip);

            //var_dump($listaContatos);

            // Cria um objeto de da classe de email
            $mailer        = new email;

            /*
            * VERIFICA SE A LISTA DE CONTATOS NÃO ESTÁ VAZIA, ENTÃO INICIA O ENVIO DE EMAILS
            */
            if(!empty($listaContatos)){
                var_dump($listaContatos);

                foreach ($listaContatos as $contato) {

                    //CHAMA A FUNÇÃO PARA EFETUAR O ENVIO DE EMAIL PARA CADA UM DOS CONTATOS

                    $localEquip = (isset($equipamentoAlerta[0]['filial'])) ? ' filial '.$equipamentoAlerta[0]['filial'] : 'Matriz';

                    $resultadoEnvio = $mailer->envioEmailAlertaEquipamento($contato['email'], $contato['nome_contato'], $equipamentoAlerta[0]['tipo_equipamento'], $equipamentoAlerta[0]['nomeEquipamento'], $equipamentoAlerta[0]['modelo'], $equipamentoAlerta[0]['ambiente'], $msgAlerta, $equipamentoAlerta[0]['cliente'], $localEquip, $indiceRecebido, $indiceUltrapassado);

                    //POSIBILIDADE DE CADASTRO NO LOG EM CASO DE FALHA DE ENVIO


                    echo $resultadoEnvio;
                }
            }
            /*
            * Implementar função para enviar emails para os contatos da empresas caso não tenha nenhum contato cadastrado na tela de alarme
            */

        }

        // echo "Crítico Alto !".$parametro." ".$configuacoes[4]."<br>";
    }elseif($parametro > (float) trataValorDataSync($configuacoes[3])){
        /*
        * GERAR ALARME
        */
        $alarmeExiste = verificarAlarmeExistente($idSimEquip, 1);

            //var_dump($alarmeExiste);
        if(!$alarmeExiste){

            gerarAlarmeEquipamento($idSimEquip, $parametro, (float) trataValorDataSync($configuacoes[3]), $ParametroVerificado, 5, 1, $pontoTabela);
        }

        //echo "Alto !".$parametro." -- ".$configuacoes[3]." <br>";
    }elseif($parametro < (float) trataValorDataSync($configuacoes[0])){
        /*
        * GERAR ALERTA
        */
        $alarmeExiste = verificarAlarmeExistente($idSimEquip, 3);

        if(!$alarmeExiste){

            /*
            * GERAR ALARME
            */
            gerarAlarmeEquipamento($idSimEquip, $parametro, (float) trataValorDataSync($configuacoes[1]), $ParametroVerificado, 2 ,2, $pontoTabela);

            /*
            * REGISTRA FALHA
            */
            //registraFalhaEquipamento($_POST['A']);

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

            // Cria um objeto de da classe de email
            $mailer             = new email;
            /*
            * Verifica se a lista de contatos não está vazia, então inicia o envio de emails
            */
            if(!empty($listaContatos)){
                var_dump($retorno);

                foreach ($listaContatos as $contato) {

                    //CHAMA A FUNÇÃO PARA EFETUAR O ENVIO DE EMAIL PARA CADA UM DOS CONTATOS

                    $localEquip = (isset($equipamentoAlerta[0]['filial'])) ? ' filial '.$equipamentoAlerta[0]['filial'] : 'Matriz';

                    $mailer->envioEmailAlertaEquipamento($contato['email'], $contato['nome_contato'], $equipamentoAlerta[0]['tipo_equipamento'], $equipamentoAlerta[0]['nomeEquipamento'], $equipamentoAlerta[0]['modelo'], $equipamentoAlerta[0]['ambiente'], $msgAlerta, $equipamentoAlerta[0]['cliente'], $localEquip, $indiceRecebido, $indiceUltrapassado);
                }
            }

        }

        //echo "Critico baixo!".$parametro." ".$configuacoes[0]."<br>";
    }elseif($parametro < (float) trataValorDataSync($configuacoes[1])){

        $alarmeExiste = verificarAlarmeExistente($idSimEquip, 4);

        if(!$alarmeExiste){

            /*
            * GERAR ALARME
            */
            gerarAlarmeEquipamento($idSimEquip, $parametro, (float) trataValorDataSync($configuacoes[1]), $ParametroVerificado, 4, 1, $pontoTabela);
        }

        //echo "Baixo !".$parametro." ".$configuacoes[1]."<br>";
    }else{
        //Nada acontece
        //echo "OK ! ".$parametro."<br>";
    }

    //var_dump($configuacoes);

    //echo "recebi entrada de tensão ".$parametro." </br>";
}

/*
* CARREGA A MENSAGEM DE ALERTA
*/
function carregarMensagemAlerta($idMensagem){

    // Cria um objeto de da classe de conexao
    $connBase    = new EficazDB;

    // Um alerta com status 5 sinaliza que está finalizado, abixo disso, ainda está ativo
    $queryAlarme = "SELECT mensagem FROM tb_msg_alerta WHERE id = '$idMensagem'";

    //var_dump($queryAlarme);

    // Monta a result com os parametros
    $result = $connBase->select($queryAlarme);

    if($result){
        //var_dump($result);

        // Verifica se existe valor de retorno
        if (@mysql_num_rows ($result) > 0)
        {
            /* ARMAZENA NA ARRAY */
            while ($row = @mysql_fetch_assoc ($result))
            {
                $retorno[] = $row;
            }

            return $retorno;

        }else{
            return false;
        }

        // Fecha a conexao
        $connBase->close();

    }else{
        // echo  "Nada encontrado";
        return false;

        // Fecha a conexao
        $connBase->close();
    }

}

/*
* VERIFICA SE JÁ EXISTE ALGUM ALARME ATIVO PARA O EQUIPAMENTO
*/
function verificarAlarmeExistente($idEquipSim, $tipoAlerta){

    //PROCURA NA TABELA DE ALARME, ALGUM REGISTRO DO EQUIPAMENTO COMPROMETIDO
    // Cria um objeto de da classe de conexao
    $connBase    = new EficazDB;


    // Um alerta com status 5 sinaliza que está finalizado, abixo disso, ainda está ativo
    $queryAlarme = "SELECT id FROM tb_alerta WHERE id_sim_equipamento = '$idEquipSim' AND  status_ativo < 5";

    //var_dump($queryAlarme);

    // Monta a result com os parametros
    $result = $connBase->select($queryAlarme);

    if($result){
        //var_dump($result);

        // Verifica se existe valor de retorno
        if (@mysql_num_rows ($result) > 0)
        {
            return true;
        }else{
            return false;
        }

        // Fecha a conexao
        $connBase->close();

    }else{
        // echo  "Nada encontrado";
        return false;

        // Fecha a conexao
        $connBase->close();
    }

}

/*
* INICIA O PROCESSO DE REGISTRO DE ALARME
*/
function gerarAlarmeEquipamento($idEquipSim, $parametroEnviado, $parametroViolado, $parametroAvaliado, $tipoAlarme, $nivelAlarme, $pontoTabela){

    // Cria um objeto de da classe de conexao
    $connBase = new EficazDB;

    // echo "id equipamento </br>".$idEquipSim;
    // echo "parametro avaliado </br>".$parametroAvaliado;
    // echo "tipo alarme </br>".$tipoAlarme;
    $data = date('Y-m-d h:i:s');

    //REGISTRA O ALARME NO SISTEMA
    $queryAlarme = "INSERT INTO tb_alerta(id_sim_equipamento, id_msg_alerta, nivel_alerta, dt_criacao)
                    VALUES ('$idEquipSim', '$tipoAlarme', '$nivelAlarme', '$data')";

    $result = $connBase->query($queryAlarme);

    $idGerada  = mysql_insert_id();

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

    $idAlarme = mysql_insert_id();

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
* INICIA O PROCESSO DE EMISSÃO DE ALERTA
*/
function gerarAlertaEquipamento(){

    //NÃO APENAS GERA UM ALARME, COMO DISPARA EMAILS OU MENSAGENS PARA OS CONTATOS RESPONSAVEIS PELO EQUIPAMENTO



}

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
* CARREGAR DADOS DO EQUIPAMENTO QUE GEROU O ALERTA
*/
function carregarDadosEquip($idSimEquip){

    // CRIA UM OBJETO DE DA CLASSE DE CONEXAO
    $connBase   = new EficazDB;

    // $query      = "SELECT equip.nomeEquipamento, equip.modelo, tipoEquip.tipo_equipamento, simEquip.ambiente,clieInfo.nome AS ´cliente´, fili.nome AS 'filial'
    //                 FROM tb_equipamento equip
    //                 JOIN tb_sim_equipamento simEquip ON equip.id = simEquip.id_equipamento
    //                 JOIN tb_cliente clieInfo ON clieInfo.id = equip.id_cliente
    //                 LEFT JOIN tb_filial fili ON equip.id_filial = fili.id_matriz
    //                 JOIN tb_tipo_equipamento tipoEquip ON equip.tipo_equipamento = tipoEquip.id
    //                 WHERE simEquip.id = '$idSimEquip'";

    $query      = "SELECT equip.nomeEquipamento, equip.modelo, tipoEquip.tipo_equipamento, simEquip.ambiente,clieInfo.nome AS 'cliente', fili.nome AS 'filial'
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
* RECEBE OS DADOS DO EQUIPAMENTO E EFETUA O CALCULO DE POTENCIA SIMPLES
*/
function calculaPotenciaSimples($idSim, $paramTensao, $paramCorren, $sentido, $param){
    /*
    * $sentido = ENTRADA OU SAIDA, $param = R,S,T
    */

    // CRIA UM OBJETO DE DA CLASSE DE CONEXAO
    $connBase   = new EficazDB;


    // Fecha a conexao
    $connBase->close();

    return $retorno;
}



?>
