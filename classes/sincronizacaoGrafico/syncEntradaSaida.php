<?php

header("content-type: application/json"); 
// Chama a classe de conexao com o banco de dados
require_once '../class-EficazDB.php';
// Cria o objeto
$conn = new EficazDB();

/**
 * 656e7472616461 - entrada 
 * 6e756d65726f   - numero sim
 * 706f73546162656c61 - Posicao na tabela
 * 
 * 
 */

// Verifica se a entrada esta setada
if (isset($_GET['656e7472616461']))
    // se estiver setada coleta os dados
    $entrada = $_GET['656e7472616461'];
else
    // Se nao insere 0
    $entrada = 0;


// Verifica se o numero do sim existe
if (isset($_GET['6e756d65726f']))
    // Decodifica e coleta o numero do sim
    $sim = base64_decode($_GET['6e756d65726f']);
else
    $sim = 0;


// Verifica se existe o valor da tabela
// Posicao de tabela
if (isset($_GET['706f73546162656c61']))
    // Se existir o valor
    // Armazena o valor
    $tb = $_GET['706f73546162656c61'];
else
    // Caso nao exista uma posicao na tabela setada
    // Insere 0
    $tb = 0;




// Verifica se a entrada nao eh nula
if ($entrada == 0)
{
    // Se nao existir uma entrada
    // Mostra uma mensagem
    echo "nenhuma entrada";
    return;
}
else if ($entrada == 1)
{
    // Atualiza o grafico de tensao analogica
    // Verificando a entrada do nobreak e a saida
    verificaEntradaSaida($conn,$tb,$sim);
}
else if ($entrada == 2)
{
    // Verifica o status do nobreak
    // Para saber se esta ligado ou desligado
    verificaLigado($conn,$sim);
}
else if ($entrada == 3)
{
    // Verifica o numero de faltas
    verificaFaltas($conn,$sim);
}
else if ($entrada == 4)
{
    // Verifica o tempo de operacao
    verificaTempoOperacao($conn,$sim);
}
else if ($entrada == 5)
{
    // Verifica a carga da bateria
    verificaBateria ($conn,$sim,$tb);
}





/**
 * Funcao que verifica se as saidas do nobreak estao ligadas
 * Caso estejam desligadas, muda o status informando o estado do nobreak
 */
function verificaLigado($conn,$sim)
{
    // Monta a query para pegar os valores da entrada
    $query = "select e,f,g from tb_dados where num_sim={$sim} and status_ativo = 1 order by (dt_criacao) desc limit 1";

    // Executa a query
    $result = $conn->select($query);

    // Verifica se existe valor na result
    if (@mysql_num_rows($result) > 0)
    {
        // Converte os valores da result em array
        while ($row = @mysql_fetch_assoc($result))
            $resultado[] = $row;
    }
    
    // Verifica se esta em branco 
    if (intval($resultado[0]['e']) == 0 && intval($resultado[0]['f']) == 0 && intval($resultado[0]['g']) == 0)
    {
        // Se os valores estiverem zerados
        // Marca como nobreak desligado
        $resp = 0;
    }
    else
    {
        // Caso os 3 nao estejam zerados
        // Marca como nobreak ligado
        $resp = 1;
    }
    
    // Devolve a resposta por callback
    echo $_GET['callback']. '(['. json_encode($resp) . '])';
    // Fim
    return;
}

/**
 * Verifica a entrada ou saida, para saber se esta ligada ou desligada
 * Atualiza no grafico de tensao analogico
 */
function verificaEntradaSaida ($conn,$tb,$sim)
{
    // Coleta os dados
    $result = $conn->select ("select {$tb} from tb_dados where num_sim={$sim} and status_ativo=1 order by (dt_criacao) desc limit 1");
    // Verifica se existe uma resposta
    if ($result)
    {
        // Verifica se existe conteudo */
        if (@mysql_num_rows($result) > 0)
        {
            // Coleta o valor e insere na variavel de resposta
            while($row = @mysql_fetch_assoc($result))
            {
                // Insere na variavel de resposta
                $resp = $row[$tb];
                // Retorna o tamanho da string
                $tamResp = strlen($resp);
                // Convert a string em vetor
                $resp = intval($resp);
            }
            // Devolve a resposta por callback
            echo $_GET['callback']. '(['. json_encode($resp) . '])';
        }
    }
}


/**
 * Funcao que verifica o total de faltas
 * 
 */
function verificaFaltas($conn,$sim)
{
    // Monta a query para pegar os valores da entrada
    $query = "select count(id) as n_falta from tb_numero_falta where id_num_sim = {$sim}";
    
    // Realiza a pesquisa no banco
    $result = $conn->select($query);
    
    // Verifica se existe resultado
    if (@mysql_num_rows ($result) > 0)
    {
        // Coleta dos dados
        while ($row = @mysql_fetch_assoc($result))
            $resp[] = $row;
    }
    // converte para inteiro
    $resultado = intval($resp[0]['n_falta']);
    // Devolve a resposta por callback
    echo $_GET['callback']. '(['. json_encode($resultado) . '])';
}



/**
 * Funcao que verifica o tempo de operacao
 */
function verificaTempoOperacao($conn,$sim)
{
    // Monta a query para pegar os valores da entrada
    $query = "select dt_criacao from tb_numero_falta where id_num_sim = {$sim} order by (dt_criacao) desc limit 1";
    
    // Realiza a pesquisa no banco
    $result = $conn->select($query);
    
    // Verifica se existe resultado
    if (@mysql_num_rows ($result) > 0)
    {
        // Coleta dos dados
        while ($row = @mysql_fetch_assoc($result))
            $resp[] = $row;
    }
    else
    {
        // Se nao existir faltas
        // Monta a query para pegar os valores da entrada
        $query = "select dt_criacao from tb_dados where num_sim = {$sim} order by (dt_criacao) asc limit 1";

        // Realiza a pesquisa no banco
        $result = $conn->select($query);
        if (@mysql_num_rows ($result) > 0)
        {
            // Coleta dos dados
            while ($row = @mysql_fetch_assoc($result))
                $resp[] = $row;
        }
        else
            $resultdo = 0;
    }
    
    // Coleta a data de retorno
    $resultado = strval($resp[0]['dt_criacao']);
    
    // Devolve a resposta por callback
    echo $_GET['callback']. '(['. json_encode($resultado) . '])';
}


/**
 * Funcao que verifica a carga da bateria
 */
function verificaBateria ($conn,$sim,$tb)
{
    // Monta a query
    $query = "select {$tb} from tb_dados where num_sim = {$sim} order by (dt_criacao) desc limit 1 ";
    
    // Monta a result
    $result = $conn->select($query);
    
    // Verifica se existe valor
    if (@mysql_num_rows($result) > 0)
    {
        // Pega os valores
        while ($row = @mysql_fetch_assoc($result))
            $resp[] = $row;
    }
    else
        $resp = 0;
    
    // Coleta a data de retorno
    $resultado = floatval($resp[0][$tb]);
    
    // Devolve a resposta por callback
    echo $_GET['callback']. '(['. json_encode($resultado) . '])';
}

// Fecha a conexao com o banco
$conn->close();
?>