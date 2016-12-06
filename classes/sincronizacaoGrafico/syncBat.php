<?php
header("content-type: application/json"); 
/* chama a classe de conexao com o banco */
require_once '../class-EficazDB.php';
/* instancia o objeto */
$cone = new EficazDB();

/* verifica se o prametro do sim nao esta vazio */
if(isset($_GET['sim']))
    /* decodifica o valor */
    $sim = base64_decode($_GET['sim']);
else
    /* apresenta mensagem de erro */
    echo "Erro, nenhum sim esta vinculado. ";

/* realiza um select no banco para buscar valores */
$result = $cone->select("select c from tb_dados where num_sim={$sim} and status_ativo=1 order by id desc limit 1");

/* verifica se existe conteudo no select */
if (@mysql_num_rows($result) > 0)
{
    /* coleta o conteudo que retornou do banco */
    while($row = @mysql_fetch_array($result))
        /* armazena a resposta do array na varaiavel */
        $resp = $row['c'];
    /* converte a resposta em uma array */
    $array = array($resp);
    /* joga na funcao calback como encriptacao json */
    echo $_GET['callback']. '('. json_encode($array) . ')';
}
/* finaliza a conexao com o banco de dados */
$cone->close();

?>