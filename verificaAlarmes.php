<?php

    /*
        Arquivo para efetuar a verificação dos alarmes e se possivel fechar os alarmes que voltaram ao normal.
    */

    // Inclui a classe de conexa
    require_once "classes/class-EficazDB.php";
    require_once "classes/class-email.php";

    echo "verificador de Alarmes!";


    /*
        CARREGA OS ALARMES COM STATUS NOVO
    */

    $alarmesNovos = carregaAlarmesNovo();


    if($alarmesNovos){

        foreach ($alarmesNovos as $alarme) {

            $id_sim_equipamento = $alarme['id_sim_equipamento'];
            $id_alerta          = $alarme['id'];
            //var_dump($alarme);
            /*
            'id' => string '158' (length=3)
            'id_sim_equipamento' => string '16' (length=2)
            'pontoTabela' => string 'e' (length=1)
            'parametroMedido' => string '90' (length=2)
            */


            /*
                CARREGA O EQUIPAMENTO QUE GEROU O ALARME
            */
            $equipamento = carregaEquipamento($id_sim_equipamento);

            if($equipamento){

                $dadosEquip = $equipamento[0];
                //var_dump($equipamento);

                /*
                'id' => string '16' (length=2)
                 'id_equipamento' => string '22' (length=2)
                 'id_sim' => string '999999888433' (length=12)
                 'nomeModeloEquipamento' => string 'Gh' (length=2)
                 'id_cliente' => string '50' (length=2)
                 'nome' => string 'Nacional Industrias' (length=19)
                 'id_filial' => null
                 'filial' => null
                */

                $idEquipamento  = $equipamento[0]['id_equipamento'];
                $idClie         = $equipamento[0]['id_cliente'];
                $idFili         = (isset($equipamento[0]['id_filial'])) ? $equipamento[0]['id_filial'] : 0;
                $equipamento    = $equipamento[0]['nomeModeloEquipamento'];
                $tipoEquip        = $dadosEquip['typeEquip'];

                /*
                    CARREGA OS PARAMETROS DO EQUIPAMENTO
                */
                $parametros     = carregarParametrosEquip($idEquipamento);

                if($parametros){

                    $numeroSim              = $parametros[0]['num_sim'];
                    $parametroEquipamento   = $parametros[0]['parametro'];

                    //var_dump($parametroEquipamento);

                    /*
                      CARREGA A ÚLTIMA MEDIDA GERADA PELO EQUIPAMENTO
                    */
                    $ultimosDadosEnviados   = carregaUltimaMedicao($numeroSim);
                    $dadosCarragados        = $ultimosDadosEnviados[0];

                    //var_dump($dadosCarragados);

                    /*
                        INICIA A COMPARAÇÃO DOS DADOS COM OS PARAMETROS PARA VERIFICAR SE EQUIPAMENTO VOLTOU AO NORMAL
                    */

                        $configuracaoSalva = explode('|inicio|',$parametroEquipamento);

                        $valoresEntrada         = explode('|', $configuracaoSalva[1]);
                        //TESTA OS VALORES DE ENTRADA
                        $statusB                = comparaParametrosEquipamento(($dadosCarragados['b']/10), $valoresEntrada, $id_sim_equipamento, 'Tensão', 'b');
                        $statusC                = comparaParametrosEquipamento(($dadosCarragados['c']/10), $valoresEntrada, $id_sim_equipamento, 'Tensão', 'c');
                        $statusD                = comparaParametrosEquipamento(($dadosCarragados['d']/10), $valoresEntrada, $id_sim_equipamento, 'Tensão', 'd');

                        $valoresSaida           = explode('|', $configuracaoSalva[2]);
                        //TESTA OS VALORES DE SAÍDA
                        $statusE                = comparaParametrosEquipamento(($dadosCarragados['e']/10), $valoresSaida, $id_sim_equipamento, 'Saída tensão', 'e');
                        $statusF                = comparaParametrosEquipamento(($dadosCarragados['f']/10), $valoresSaida, $id_sim_equipamento, 'Saída tensão', 'f');
                        $statusG                = comparaParametrosEquipamento(($dadosCarragados['g']/10), $valoresSaida, $id_sim_equipamento, 'Saída tensão', 'g');

                        $valoresBateria         = explode('|', $configuracaoSalva[3]);
                        //TESTA OS VALORES DA BATERIA
                        $statusH                = comparaParametrosEquipamento($dadosCarragados['i'], $valoresBateria, $id_sim_equipamento, 'Bateria', 'h');

                        $valoresCorrente        = explode('|', $configuracaoSalva[4]);
                        //TESTA OS VALORES DE CORRENTE
                        $statusI                = comparaParametrosEquipamento(($dadosCarragados['h']/10), $valoresCorrente, $id_sim_equipamento, 'Corrente', 'i');
                        $statusJ                = comparaParametrosEquipamento(($dadosCarragados['j']/10), $valoresCorrente, $id_sim_equipamento, 'Corrente', 'j');
                        $statusL                = comparaParametrosEquipamento(($dadosCarragados['l']/10), $valoresCorrente, $id_sim_equipamento, 'Corrente', 'l');

                        $valoresCorrenteSaida   = explode('|', $configuracaoSalva[5]);
                        //TESTA OS VALORES DE SAÍDA DE CORRENTE
                        $statusM                = comparaParametrosEquipamento(($dadosCarragados['m']/10), $valoresCorrenteSaida, $id_sim_equipamento, 'Saída corrente', 'm');
                        $statusN                = comparaParametrosEquipamento(($dadosCarragados['n']/10), $valoresCorrenteSaida, $id_sim_equipamento, 'Saída corrente', 'n');
                        $statusO                = comparaParametrosEquipamento(($dadosCarragados['o']/10), $valoresCorrenteSaida, $id_sim_equipamento, 'Saída corrente', 'o');


                        if(($statusB) && ($statusC) && ($statusD) && ($statusE) && ($statusF) && ($statusG) && ($statusH) && ($statusI) && ($statusJ) && ($statusL) && ($statusM) && ($statusN) && ($statusO)){

                            echo "Equipamento voltou ao normal!";

                            $equipOK = true;

                        }else{
                            echo "Equipamento ainda com problemas!";

                            $equipOK = false;
                        }

                        /*
                            AÇÃO TOMADA AO SE CONFIRMAR QUE O EQUIPAMENTO ESTÁ NORMALIZADO.
                        */
                        if($equipOK){

                            /*
                                ATUALIZA O STATUS DO ALARME
                            */
                            // $statusAtualizado = atualizarStatusAlarme($id_alerta);
                            // $statusTratamento = atualizaTratamentoAlarme($id_alerta);

                            /*
                                APÓS ATUALIZAR STATUS DOS ALARMES, ENVIAR EMAIL CONFIRMANDO O RETORNO DO EQUIPAMENTP A NORMALIZADE
                            */

                            $listaContatos = carregarContatosEquiapemtno($idClie, $idFili);

                            if($listaContatos){
                                // var_dump($listaContatos);
                                /*
                                    GERA UM EMAIL PARA CADA CONTATO GERADO
                                */

                                /*
                                array (size=1)
                                    0 =>
                                    array (size=2)
                                      'nome_contato' => string 'Contato A' (length=9)
                                      'email' => string 'contatoa@email.com' (length=18)
                                */
                                foreach ($listaContatos as $contato) {

                                    $mailer = new email;

                                    $nome = $contato['nome_contato'];
                                    $email = $contato['email'];

                                    $emailEnviado = $mailer->enviarAvisoNormalidade($nome, $email, $tipoEquip, $equipamento);

                                }

                            }
                        }


                    /*
                        FIM DO PROCESSO DE VERIFICAÇÃO DOS PARAMETROS DO EQUIPAMENTO
                    */
                }else{
                    echo "Parametros não encontrados!";
                }

            }else{
                echo "Equipamento não encontrado!";
            }
        }

    }else{
        echo 'Nenhum alarme para verificar !';
    }

    // FIM DA VERIFICAÇÂO DE ALARMES NOVOS


    /*
        CARREGA OS ALARMES COM STATUS "NOVO"
    */
    function carregaAlarmesNovo(){

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


        //QUERY PARA TRAZER OS ALARMES COM STATUS 'NOVO'
        $alarmes = "SELECT alert.id, alert.id_sim_equipamento, trat.pontoTabela, trat.parametroMedido
                    FROM tb_alerta alert
                    JOIN tb_tratamento_alerta trat ON alert.id = trat.id_alerta
                    WHERE status_ativo = '1'";

        /*
        * EXECUTA A QUERY NO BANCO E VERIFICA SE RETORNO ERRO
        */
        $result = $conn->select($alarmes);

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

        // Fecha a conexao
        $conn->close();

        return $dados;

    }

    /*
        CARREGA OS DADOS DO EQUIPAMENTO
    */
    function carregaEquipamento($id_sim_equip){

        if(is_numeric($id_sim_equip)){

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

            /*
                CARREGA OS DADOS DO EQUIPAMENTO
            */
            $queryEquipamento = "SELECT sim_equip.id, sim_equip.id_equipamento, sim_equip.id_sim, tpEquip.tipo_equipamento AS 'typeEquip', equip.nomeModeloEquipamento,clie.id as 'id_cliente', clie.nome, fili.id as 'id_filial', fili.nome AS 'filial'
                                FROM tb_sim_equipamento sim_equip
                                JOIN tb_equipamento equip ON equip.id = sim_equip.id_equipamento
                                JOIN tb_tipo_equipamento tpEquip ON equip.tipo_equipamento = tpEquip.id
                                JOIN tb_cliente clie ON clie.id = equip.id_cliente
                                LEFT JOIN tb_filial fili ON fili.id = equip.id_filial
                                WHERE sim_equip.id = '$id_sim_equip'";

            /*
            * EXECUTA A QUERY NO BANCO E VERIFICA SE RETORNO ERRO
            */
            $dadosEquip = $conn->select($queryEquipamento);

            /* VERIFICA SE EXISTE VALOR */
            if (@mysql_num_rows($dadosEquip) > 0)
            {
                /* ARMAZENA NA ARRAY */
                while ($rowEquip = @mysql_fetch_assoc ($dadosEquip))
                {
                    $retornoEquip[] = $rowEquip;
                }

                $equipamento = $retornoEquip;

                $array = $equipamento;

                // Fecha a conexao
                $conn->close();

            }else{
                $array = false;
            }

        }else{

            $array = false;

        }

        return $array;
    }


    /*
    * FUNÇÃO PARA CARREGAR OS PARAMETROS DE DETERMINADO EQUIPAMENTO
    */
    function carregarParametrosEquip($idEquipamento){

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


        if(is_numeric($idEquipamento)){
            $query = "SELECT param.parametro, param.num_sim
                        FROM tb_parametro param
                        WHERE param.id_equipamento = '$idEquipamento'";

            /*
            * EXECUTA A QUERY NO BANCO E VERIFICA SE RETORNO ERRO
            */
            $paramEquip = $conn->select($query);

            /* VERIFICA SE EXISTE VALOR */
            if (@mysql_num_rows($paramEquip) > 0)
            {
                /* ARMAZENA NA ARRAY */
                while ($rowEquip = @mysql_fetch_assoc ($paramEquip))
                {
                    $retornoEquip[] = $rowEquip;
                }

                $parametros = $retornoEquip;

                // Fecha a conexao
                $conn->close();

            }else{
                $parametros = false;
            }

        }else{
            $parametros = false;
        }

        return $parametros;

    }

    /*
    * CARREGA OS ÚLTIMOS DADOS ENVIADOS PELO EQUIPAMENTO
    */
    function carregaUltimaMedicao($simEquipamento){

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

        $query = "SELECT dat.id, dat.num_sim, dat.b, dat.c,dat.d,dat.e,dat.f,dat.g,dat.h,dat.i,dat.j,dat.l,dat.m,dat.n,dat.o,dat.p,dat.q,dat.r,dat.s,dat.t,dat.u
                FROM  tb_dados dat
                WHERE dat.num_sim = '$simEquipamento'
                ORDER BY dat.id DESC LIMIT 1";

        /*
        * EXECUTA A QUERY NO BANCO E VERIFICA SE RETORNO ERRO
        */
        $dadosEquip = $conn->select($query);

        /* VERIFICA SE EXISTE VALOR */
        if (@mysql_num_rows($dadosEquip) > 0)
        {
            /* ARMAZENA NA ARRAY */
            while ($rowEquip = @mysql_fetch_assoc ($dadosEquip))
            {
                $retornoEquip[] = $rowEquip;
            }

            $dados = $retornoEquip;

            // Fecha a conexao
            $conn->close();

        }else{
            $dados = false;
        }

        return $dados;
    }

    /*
    * EFETUA A COMPARAÇÃO DE PARAMETROS SALVOS COM OS DADOS RECEBIDOS
    */
    function comparaParametrosEquipamento($parametro, $configuacoes, $idSimEquip, $ParametroVerificado, $pontoTabela){

        if($parametro > (float) trataValorDataSync($configuacoes[4])){
            //TRECHO DE CRITICO ALTO;

            // echo " </br> ".$pontoTabela." Crítico alto <br />";
            $result = false;
        }
        elseif($parametro > (float) trataValorDataSync($configuacoes[3])){
            //TRECHO DE NÍVEL ALTO;
            // echo " </br> ".$pontoTabela."alto <br />";
            $result = false;
        }
        elseif($parametro < (float) trataValorDataSync($configuacoes[0])){
            //TRECHO DE CRITICO BAIXO;

            // echo " </br> ".$pontoTabela."Crítico baixo <br />";
            $result = false;
        }
        elseif($parametro < (float) trataValorDataSync($configuacoes[1])){
            //TRECHO DE NÍVEL BAIXO;

            // echo " </br> ".$pontoTabela."Baixo <br />";

            $result = false;
        }
        else{
            // echo "<br /> Equipamento com alarme OK!";
            $result = true;
        }

        return $result;
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
    * ATUALIZA O STATUS DO EQUIPAMENTO
    */

    function atualizarStatusAlarme($idAlerta){

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

        $query = "UPDATE tb_alerta SET status_ativo = '4' WHERE id = '$idAlerta'";

        /* monta result */
        $result = $this->db->query($query);

        if ($result){
          $array = array('status' => true);
        }else{
          $array = array('status' => false);
        }

        // Fecha a conexao
        $conn->close();

        return $array;

    }

    /*
    * ATUALIZA O STATUS DO TRATAMENTO DO ALARME
    */
    function atualizaTratamentoAlarme($idAlerta){

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

        $query = "UPDATE tb_tratamento_alerta SET tratamento_aplicado = 'Nível de alimentação do equipamento voltou ao normal.' WHERE id_alerta = '$idAlerta'";

        /* monta result */
        $result = $this->db->query($query);

        if ($result){
          $array = array('status' => true);
        }else{
          $array = array('status' => false);
        }

        // Fecha a conexao
        $conn->close();

        return $array;

    }

    /*
    * CARREGA OS CONTATOS DE EMAIL DO EQUIPAMENTO
    */
    function carregarContatosEquiapemtno($idClie, $idFili){

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

        $query = "SELECT nome_contato, email FROM tb_contato_alerta WHERE id_cliente = '$idClie' AND id_filial = '$idFili'";

        /* monta result */
        $result =  $conn->select($query);

        /* VERIFICA SE EXISTE VALOR */
        if (@mysql_num_rows($result) > 0)
        {
            /* ARMAZENA NA ARRAY */
            while ($rowEquip = @mysql_fetch_assoc ($result))
            {
                $retornoEquip[] = $rowEquip;
            }

            $dados = $retornoEquip;

            // Fecha a conexao
            $conn->close();

        }else{
            $dados = false;
        }

        return $dados;
    }

?>
