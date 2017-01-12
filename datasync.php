<?php

// Valida os campos do post
if(isset($_POST['A']) && isset($_POST['B']) && isset($_POST['C']) && isset($_POST['D']) &&
   isset($_POST['E']) && isset($_POST['F']) && isset($_POST['G']) && isset($_POST['H']) &&
   isset($_POST['I']) && isset($_POST['J']) && isset($_POST['L']) && isset($_POST['M']) &&
   isset($_POST['N']) && isset($_POST['O']) && isset($_POST['P']) && isset($_POST['Q']) &&
   isset($_POST['R']) && isset($_POST['S']) && isset($_POST['T']) && isset($_POST['U']))
{

    // Inclui a classe de conexa
    require_once "classes/class-EficazDB.php";

    // Cria um objeto de da classe de conexao
    $conn = new EficazDB;

    // Verifica se existe erro de conexao
    if (!$conn)
    {
        // Retorno erro
        header('HTTP/1.1 404 Not Found');
        // Finaliza a execucao
        exit();
    }

    // Monta a query
    $valor = "insert into tb_dados (num_sim,b,c,d,e,f,g,h,i,j,l,m,n,o,p,q,r,s,t,u) values
                  ('{$_POST['A']}','{$_POST['B']}','{$_POST['C']}','{$_POST['D']}','{$_POST['E']}','{$_POST['F']}','{$_POST['G']}',
                   '{$_POST['H']}','{$_POST['I']}','{$_POST['J']}','{$_POST['L']}','{$_POST['M']}','{$_POST['N']}','{$_POST['O']}',
                   '{$_POST['P']}','{$_POST['Q']}','{$_POST['R']}','{$_POST['S']}','{$_POST['T']}','{$_POST['U']}')";

    // Executa a query no banco e verifica se retorno erro
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

        //COM OS PARAMETROS CARREGADOS, INICIA A COMPARAÇÃO COM OS DADOS RECEBIDOS
        $parametros = $dados[0]['parametro'];
        $idSimEquip = $dados[0]['id_sim_equipamento'];
        //var_dump($parametros);

        $configuracaoSalva = explode('|inicio|',$parametros);

        //var_dump($configuracaoSalva);
        $valoresEntrada         = explode('|', $configuracaoSalva[1]);

        //var_dump($valoresEntrada);

        //TESTA OS VALORES DE ENTRADA
        $statusB                = comparaParametrosEquipamento(($_POST['B']/10), $valoresEntrada, $idSimEquip);
        $statusC                = comparaParametrosEquipamento(($_POST['C']/10), $valoresEntrada, $idSimEquip);
        $statusD                = comparaParametrosEquipamento(($_POST['D']/10), $valoresEntrada, $idSimEquip);

        $valoresSaida           = explode('|', $configuracaoSalva[2]);
        //TESTA OS VALORES DE SAÍDA
        $statusE                = comparaParametrosEquipamento(($_POST['E']/10), $valoresSaida, $idSimEquip);
        $statusF                = comparaParametrosEquipamento(($_POST['F']/10), $valoresSaida, $idSimEquip);
        $statusG                = comparaParametrosEquipamento(($_POST['G']/10), $valoresSaida, $idSimEquip);

        $valoresBateria         = explode('|', $configuracaoSalva[3]);
        //TESTA OS VALORES DA BATERIA
        $statusH                = comparaParametrosEquipamento($_POST['H'], $valoresBateria, $idSimEquip);

        $valoresCorrente        = explode('|', $configuracaoSalva[4]);
        //TESTA OS VALORES DE CORRENTE
        $statusI                = comparaParametrosEquipamento(($_POST['I']/10), $valoresCorrente, $idSimEquip);
        $statusJ                = comparaParametrosEquipamento(($_POST['J']/10), $valoresCorrente, $idSimEquip);
        $statusL                = comparaParametrosEquipamento(($_POST['L']/10), $valoresCorrente, $idSimEquip);

        $valoresCorrenteSaida   = explode('|', $configuracaoSalva[5]);
        //TESTA OS VALORES DE SAÍDA DE CORRENTE
        $statusM                = comparaParametrosEquipamento(($_POST['M']/10), $valoresCorrenteSaida, $idSimEquip);
        $statusN                = comparaParametrosEquipamento(($_POST['N']/10), $valoresCorrenteSaida, $idSimEquip);
        $statusO                = comparaParametrosEquipamento(($_POST['O']/10), $valoresCorrenteSaida, $idSimEquip);

    }else{
        //var_dump($dados);
        $parametros = 0;
    }


    //EFETUA A AÇÃO DE ACORDO COM O RESULTADO DA COMPARAÇÃO


    // Converte a entrada em inteiro
    $vint[] = intval($_POST['E']);
    $vint[] = intval($_POST['F']);
    $vint[] = intval($_POST['G']);

    // Verifica se a entrada esta zerada
    if ($vint[0] == 0 && $vint[1] == 0 && $vint[2] == 0)
    {
        // Monta a query da ultama insercao do dado
        $query = "select dt_criacao,e,f,g from tb_dados where num_sim = {$_POST['A']} and
                  E != '00000' or F != '00000' or G != '00000' order by (dt_criacao) desc limit 1";
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
    header ('HTTP/1.1 200 OK');
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
* Recebe a array com os parametros de determinada entrada de tensão variavel para comparação
*/
function comparaParametrosEquipamento($parametro, $configuacoes, $idSimEquip){

    //var_dump($configuacoes);

    switch ($parametro) {
        case $parametro < trataValorDataSync($configuacoes[0]):
            echo "Critico baixo!".$parametro." ".$configuacoes[0]."<br>";
        break;
        case $parametro < trataValorDataSync($configuacoes[1]):
            echo "Baixo !".$parametro." ".$configuacoes[1]."<br>";
        break;
        case $parametro > trataValorDataSync($configuacoes[4]):
            echo "Crítico Alto !".$parametro." ".$configuacoes[4]."<br>";
        break;
        case $parametro > trataValorDataSync($configuacoes[3]):
            echo "Alto !".$parametro." -- ".$configuacoes[3]." <br>";
        break;
        default:
            echo "Switch OK ! ".$parametro."<br>";
        break;
    }


    //var_dump($configuacoes);

    //echo "recebi entrada de tensão ".$parametro." </br>";
}

/*
* Recebe a array com os parametros de determinada entrada de tensão variavel para comparação
*/
function comparaParametrosEntradaEquipamento($parametro, $configuacoes){

    //$valorReal = $parametro/10;

    switch ($parametro) {
        case $parametro < trataValorDataSync($configuacoes[0]):
            echo "Critico baixo!<br>";
        break;
        case $parametro < trataValorDataSync($configuacoes[1]):
            echo "Baixo !<br>";
        break;
        case $parametro > trataValorDataSync($configuacoes[3]):
            echo "Crítico Alto !<br>";
        break;
        case $parametro > (float) trataValorDataSync($configuacoes[2]):
            echo "Alto !".$parametro." <br>";
        break;
        default:
            echo "Switch OK !<br>";
        break;
    }
}

/*
* Recebe a array com os parametros de determinado saída de tensão e a variavel para comparação
*/
function comparaParametrosSaidaEquipamento($parametro, $configuacoes){
    echo "recebi saída de tensão ".$parametro." </br>";
}

/*
* Recebe a array com os parametros de determinado bateria e a variavel para comparação
*/
function comparaParametrosBateriaEquipamento($parametro, $configuacoes){
    echo "recebi bateria ".$parametro." </br>";
}

/*
* Recebe a array com os parametros de determinado entrada de corrente e a variavel para comparação
*/
function comparaParametrosCorrenteEquipamento($parametro, $configuacoes){
    echo "recebi corrente ".$parametro." </br>";
}

/*
* Recebe a array com os parametros de determinado saída de corrente e a variavel para comparação
*/
function comparaParametrosSaidaCorrenteEquipamento($parametro, $configuacoes){
    echo "recebi saída de corrente ".$parametro." </br>";
}

?>
