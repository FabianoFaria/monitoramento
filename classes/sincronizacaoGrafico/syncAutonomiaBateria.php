<?php
// Inclui o cabecalho informando que eh um JSON
header("content-type: application/json");
/* chama a classe de conexao com o banco */
require_once '../class-EficazDB.php';
/* instancia o objeto */
$cone = new EficazDB();

/* verifica se o prametro do sim nao esta vazio */
if(isset($_GET['6e756d65726f'])){
    /* decodifica o valor */
    //$sim = base64_decode($_GET['sim']);
    $sim    = $_GET['6e756d65726f'];
    $param  = $_GET['706f73546162656c61'];
}else{
    /* apresenta mensagem de erro */
    echo "Erro, nenhum sim esta vinculado. ";
}

/* realiza um select no banco para buscar valores */
$result = $cone->select("SELECT dadosPot.id, dadosPot.tempoEstimadoHora, dadosPot.status_entrada, dadosPot.data_registro, equip.id,equip.correnteBancoBateria
                        FROM tb_dados_potencia dadosPot
                        JOIN tb_equipamento equip ON dadosPot.id_equipamento = equip.id
                        WHERE dadosPot.id_equipamento = '{$param}' AND dadosPot.num_sim = '{$sim}' AND dadosPot.status_entrada = '1' ORDER BY dadosPot.id DESC LIMIT 1 ");

/* verifica se existe conteudo no select */
if (@mysql_num_rows($result) > 0){
    /* coleta o conteudo que retornou do banco */
    while($row = @mysql_fetch_array($result))
        /* armazena a resposta do array na varaiavel */
        $resp = $row;
        /* converte a resposta em uma array */
        //$array = array($resp);
    /* joga na funcao calback como encriptacao json */
    echo $_GET['callback']. '('. json_encode($resp) . ')';
}

/* finaliza a conexao com o banco de dados */
$cone->close();

?>
