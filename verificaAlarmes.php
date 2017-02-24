<?php


    /*
    * Arquivo para efetuar a verificação dos alarmes e se possivel fechar os alarmes que voltaram ao normal.
    */


    // Inclui a classe de conexa
    require_once "classes/class-EficazDB.php";
    require_once "classes/class-email.php";


    echo "verificador de Alarmes!";

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
    $alarmes = "SELECT alert.id, alert.id_sim_equipamento, trat.pontoTabela, trat.
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


    var_dump($dados);
?>
