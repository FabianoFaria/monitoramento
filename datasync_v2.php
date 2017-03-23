<?php

/*
* NOVA VERSÃO DO DATASYNC QUE AGORA PASSA A VERIFICAR OS TIPOS DE ENTRADAS E SAIDAS DO EQUIPAMENTO.
* TAMBÉM SERÁ IDENTIFICADO O TIPO DE EQUIPAMENTO E O TRATAMENTO DE ACORDO COM CADA CONFIGURAÇÃO.
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
    * MONTA A QUERY
    */
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


    /*
    * CARREGA OS TIPOS DE EQUIPAMENTOS CADASTRADOS COM O SIM
    */

    $equipamentosSim = carregaEquipamentosSim($_POST['A']);

    /*
    * CARREGA OS PARAMETROS DEFINIDOS PARA O SIM INFORMADO
    */

    $dados = carregaParamentrosSim($_POST['A']);

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

        //var_dump($configuracaoSalva);
        $valoresEntrada         = explode('|', $configuracaoSalva[1]);


        foreach ($equipamentosSim as $equipamento) {

            //var_dump($equipamento);

            switch ($equipamento['tipo_equipamento']) {

                /*
                * Equipamento é um No-break
                */

                case '1':

                    /*
                    * Carrega os dados de equipamentos para verificar as saídas e entradas corretas
                    */
                    $equipamentoAnalizado = carregarDadosEquip($equipamento['simIdEquip']);

                    var_dump($equipamentoAnalizado);
                    /*
                    * Verifica o tipo de entrada do equipamento e então efetua a verificação dos parametros
                    */
                    switch ($equipamentoAnalizado['tipo_entrada']) {
                        case '1':
                            # Equipamento monofásico
                            $valoresEntrada         = explode('|', $configuracaoSalva[1]);
                            # Verifica entrada R ()
                            //TESTA OS VALORES DE ENTRADA
                            $statusB                = comparaParametrosEquipamento(($_POST['B']/10), $valoresEntrada, $idSimEquip, 'Tensão', 'b');


                            $valoresCorrente        = explode('|', $configuracaoSalva[4]);
                            # Verifica entrada corrente R ()
                            $statusI                = comparaParametrosEquipamento(($_POST['I']/10), $valoresCorrente, $idSimEquip, 'Corrente', 'i');

                        break;
                        case '2':
                            # Equipamento bifásico
                            $valoresEntrada         = explode('|', $configuracaoSalva[1]);
                            # Verifica entrada R e S ()
                            $statusB                = comparaParametrosEquipamento(($_POST['B']/10), $valoresEntrada, $idSimEquip, 'Tensão', 'b');
                            $statusC                = comparaParametrosEquipamento(($_POST['C']/10), $valoresEntrada, $idSimEquip, 'Tensão', 'c');

                            $valoresCorrente        = explode('|', $configuracaoSalva[4]);
                            # Verifica entrada corrente R e S()
                            $statusI                = comparaParametrosEquipamento(($_POST['I']/10), $valoresCorrente, $idSimEquip, 'Corrente', 'i');
                            $statusJ                = comparaParametrosEquipamento(($_POST['J']/10), $valoresCorrente, $idSimEquip, 'Corrente', 'j');


                        break;
                        case '3':
                            # Equipamento trifásico
                            $valoresEntrada         = explode('|', $configuracaoSalva[1]);
                            # Verifica entrada R, S e T ()
                            $statusB                = comparaParametrosEquipamento(($_POST['B']/10), $valoresEntrada, $idSimEquip, 'Tensão', 'b');
                            $statusC                = comparaParametrosEquipamento(($_POST['C']/10), $valoresEntrada, $idSimEquip, 'Tensão', 'c');
                            $statusD                = comparaParametrosEquipamento(($_POST['D']/10), $valoresEntrada, $idSimEquip, 'Tensão', 'd');

                            $valoresCorrente        = explode('|', $configuracaoSalva[4]);
                            # Verifica entrada corrente R, S e T()
                            $statusI                = comparaParametrosEquipamento(($_POST['I']/10), $valoresCorrente, $idSimEquip, 'Corrente', 'i');
                            $statusJ                = comparaParametrosEquipamento(($_POST['J']/10), $valoresCorrente, $idSimEquip, 'Corrente', 'j');
                            $statusL                = comparaParametrosEquipamento(($_POST['L']/10), $valoresCorrente, $idSimEquip, 'Corrente', 'l');


                        break;

                    }

                    /*
                    * Verifica o tipo de saída do equipamento e então efetua a verificação dos parametros
                    */

                    switch ($equipamentoAnalizado['tipo_saida']) {
                        case '1':
                            # Equipamento monofásico
                            $valoresSaida           = explode('|', $configuracaoSalva[2]);
                            # Verifica saída R ()
                            $statusE                = comparaParametrosEquipamento(($_POST['E']/10), $valoresSaida, $idSimEquip, 'Saída tensão', 'e');

                            $valoresCorrenteSaida   = explode('|', $configuracaoSalva[5]);
                            # Verifica saída corrente R ()
                            $statusM                = comparaParametrosEquipamento(($_POST['M']/10), $valoresCorrenteSaida, $idSimEquip, 'Saída corrente', 'm');

                        break;
                        case '2':
                            # Equipamento bifásico
                            $valoresSaida           = explode('|', $configuracaoSalva[2]);
                            # Verifica saída R e S ()
                            $statusE                = comparaParametrosEquipamento(($_POST['E']/10), $valoresSaida, $idSimEquip, 'Saída tensão', 'e');
                            $statusF                = comparaParametrosEquipamento(($_POST['F']/10), $valoresSaida, $idSimEquip, 'Saída tensão', 'f');

                            $valoresCorrenteSaida   = explode('|', $configuracaoSalva[5]);
                            # Verifica saída corrente R e S()
                            $statusM                = comparaParametrosEquipamento(($_POST['M']/10), $valoresCorrenteSaida, $idSimEquip, 'Saída corrente', 'm');
                            $statusN                = comparaParametrosEquipamento(($_POST['N']/10), $valoresCorrenteSaida, $idSimEquip, 'Saída corrente', 'n');
                        break;
                        case '3':
                            # Equipamento trifásico

                            $valoresSaida           = explode('|', $configuracaoSalva[2]);
                            # Verifica saída R, S e T ()
                            $statusE                = comparaParametrosEquipamento(($_POST['E']/10), $valoresSaida, $idSimEquip, 'Saída tensão', 'e');
                            $statusF                = comparaParametrosEquipamento(($_POST['F']/10), $valoresSaida, $idSimEquip, 'Saída tensão', 'f');
                            $statusG                = comparaParametrosEquipamento(($_POST['G']/10), $valoresSaida, $idSimEquip, 'Saída tensão', 'g');


                            $valoresCorrenteSaida   = explode('|', $configuracaoSalva[5]);
                            # Verifica saída corrente R, S e T()
                            $statusM                = comparaParametrosEquipamento(($_POST['M']/10), $valoresCorrenteSaida, $idSimEquip, 'Saída corrente', 'm');
                            $statusN                = comparaParametrosEquipamento(($_POST['N']/10), $valoresCorrenteSaida, $idSimEquip, 'Saída corrente', 'n');
                            $statusO                = comparaParametrosEquipamento(($_POST['O']/10), $valoresCorrenteSaida, $idSimEquip, 'Saída corrente', 'o');

                        break;
                    }

                    /*
                    * VERIFICA AS MEDIDAS DAS BATERIAS
                    */
                    $valoresBateria         = explode('|', $configuracaoSalva[3]);
                    //TESTA OS VALORES DA BATERIA
                    $statusH                = comparaParametrosEquipamento($_POST['H'], $valoresBateria, $idSimEquip, 'Bateria', 'h');


                break;

                /*
                * Demais equipamentos, carregar os dados do equipamentos e verificar as posições na
                * tabela, de acordo com o tipo de equiapemnto.
                */

                default:

                    $equipamentoAnalizado = carregarDadosEquipDiversos($equipamento['simIdEquip']);

                    //var_dump($equipamentoAnalizado);

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
    * CARREGAR OS EQUIPAMENTOS CADASTRADOS PELOS NÚMERO DE SIM
    */

    function carregaEquipamentosSim($numSim){

        $query = "SELECT equip.id AS 'idEquipamento', equip.tipo_equipamento, equip.nomeModeloEquipamento, simEquip.id AS 'simIdEquip'
                    FROM tb_equipamento equip
                    JOIN tb_sim_equipamento simEquip ON simEquip.id_equipamento = equip.id
                    WHERE simEquip.id_sim = $numSim";

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
    * CARREGAR DADOS DO EQUIPAMENTO DE NO BREAK, PARA VERIFICAÇÂO DE TIPOS DE ENTRADA
    */

    function carregarDadosEquip($idSimEquip){

        // CRIA UM OBJETO DE DA CLASSE DE CONEXAO
        $connBase   = new EficazDB;

        $query  = "SELECT
                    equip.nomeModeloEquipamento,
                    tipoEquip.tipo_equipamento,
                    simEquip.ambiente,
                    clieInfo.nome AS 'cliente',
                    fili.nome AS 'filial',
                    equip.tipo_entrada,
                    equip.tipo_saida
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
    * CARREGAR DADOS DO EQUIPAMENTOS DIVERSOS, PARA VERIFICAÇÃO DE PARAMETROS
    */
    function carregarDadosEquipDiversos($idSimEquip){

        // CRIA UM OBJETO DE DA CLASSE DE CONEXAO
        $connBase   = new EficazDB;

        $query  = "SELECT equip.nomeModeloEquipamento, tipoEquip.tipo_equipamento, tipoEquip.posicoes_tabela, simEquip.ambiente, clieInfo.nome AS 'cliente', fili.nome AS 'filial',equip.tipo_entrada, equip.tipo_saida
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
    * CARREGA OS PARAMETROS DEFINIDOS PARA O SIM INFORMADO
    */
    function carregaParamentrosSim($simNumero){

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

        return $dados;

    }

    /*
    * RECEBE A ARRAY COM OS PARAMETROS DE DETERMINADA ENTRADA DE TENSÃO VARIAVEL PARA COMPARAÇÃO
    */
    function comparaParametrosEquipamento($parametro, $configuacoes, $idSimEquip, $ParametroVerificado, $pontoTabela){
        /*
        * TESTA OS PARAMETROS ATRAVÉS DE IF E ELSES
        */
        if($parametro > (float) trataValorDataSync($configuacoes[4])){
            /*
            * GERAR ALERTA
            */
            $alarmeExiste = verificarAlarmeExistente($idSimEquip, 2);

            if(!$alarmeExiste){

                gerarAlarmeEquipamento($idSimEquip, $parametro, (float) trataValorDataSync($configuacoes[3]), $ParametroVerificado, 3, 2, $pontoTabela);

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

                //Procura os contatos para envio de alerta da tabela tb_contato_alerta
                $listaContatos      = carregarContatosAlerta($idSimEquip);

                // Cria um objeto de da classe de email
                $mailer        = new email;

                /*
                * VERIFICA SE A LISTA DE CONTATOS NÃO ESTÁ VAZIA, ENTÃO INICIA O ENVIO DE EMAILS
                */
                if(!empty($listaContatos)){
                    foreach ($listaContatos as $contato) {

                        //CHAMA A FUNÇÃO PARA EFETUAR O ENVIO DE EMAIL PARA CADA UM DOS CONTATOS

                        $localEquip = (isset($equipamentoAlerta[0]['filial'])) ? ' filial '.$equipamentoAlerta[0]['filial'] : 'Matriz';

                        $resultadoEnvio = $mailer->envioEmailAlertaEquipamento($contato['email'], $contato['nome_contato'], $equipamentoAlerta[0]['tipo_equipamento'], $equipamentoAlerta[0]['nomeModeloEquipamento'], " ", $equipamentoAlerta[0]['ambiente'], $msgAlerta, $equipamentoAlerta[0]['cliente'], $localEquip, $indiceRecebido, $indiceUltrapassado);

                        //POSIBILIDADE DE CADASTRO NO LOG EM CASO DE FALHA DE ENVIO


                        echo $resultadoEnvio;
                    }
                }

                /*
                * Implementar função para enviar emails para os contatos da empresas caso não tenha nenhum contato cadastrado na tela de alarme
                */

            }

        }elseif($parametro > (float) trataValorDataSync($configuacoes[3])){

            /*
            * GERAR ALARME
            */
            $alarmeExiste = verificarAlarmeExistente($idSimEquip, 1);

            if(!$alarmeExiste){

                gerarAlarmeEquipamento($idSimEquip, $parametro, (float) trataValorDataSync($configuacoes[3]), $ParametroVerificado, 5, 1, $pontoTabela);
            }



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

                        $mailer->envioEmailAlertaEquipamento($contato['email'], $contato['nome_contato'], $equipamentoAlerta[0]['tipo_equipamento'], $equipamentoAlerta[0]['nomeModeloEquipamento'], "", $equipamentoAlerta[0]['ambiente'], $msgAlerta, $equipamentoAlerta[0]['cliente'], $localEquip, $indiceRecebido, $indiceUltrapassado);
                    }
                }
            }
        }

    }elseif($parametro < (float) trataValorDataSync($configuacoes[1])){

        $alarmeExiste = verificarAlarmeExistente($idSimEquip, 4);

        if(!$alarmeExiste){

            /*
            * GERAR ALARME
            */
            gerarAlarmeEquipamento($idSimEquip, $parametro, (float) trataValorDataSync($configuacoes[1]), $ParametroVerificado, 4, 1, $pontoTabela);
        }
    }

    /*
    * INICIA O PROCESSO DE REGISTRO DE ALARME
    */
    function gerarAlarmeEquipamento($idEquipSim, $parametroEnviado, $parametroViolado, $parametroAvaliado, $tipoAlarme, $nivelAlarme, $pontoTabela){

        // Cria um objeto de da classe de conexao
        $connBase = new EficazDB;

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
?>
