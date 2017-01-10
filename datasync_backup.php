<?php

// Valida os campos do post
if(isset($_POST['A']) && isset($_POST['B']) && isset($_POST['C']) && isset($_POST['D']) &&
   isset($_POST['E']) && isset($_POST['F']) && isset($_POST['G']) && isset($_POST['H']) &&
   isset($_POST['I']) && isset($_POST['J']) && isset($_POST['L']) && isset($_POST['M']) &&
   isset($_POST['N']) && isset($_POST['O']) && isset($_POST['P']) && isset($_POST['Q']) &&
   isset($_POST['R']) && isset($_POST['S']) && isset($_POST['T']) && isset($_POST['U']))
{
    // Inclui a classe de conexao
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


?>
