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
$result = $cone->select("select {$param} from tb_dados where num_sim={$sim} and status_ativo=1 order by id desc limit 1");

$resultCali = $cone->select("SELECT cali.variavel_cal FROM tb_equipamento_calibracao cali JOIN tb_sim_equipamento simEquip ON simEquip.id_equipamento = cali.id_equip WHERE simEquip.id_sim = '{$sim}' AND cali.posicao_tab = '{$param}' AND simEquip.status_ativo = '1'");

/* verifica se existe conteudo no select */
// if (@mysql_num_rows($result) > 0)
// {
if(!empty($result)){
    /* coleta o conteudo que retornou do banco */
    // while($row = @mysql_fetch_array($result))
    //     /* armazena a resposta do array na varaiavel */
    //     $resp = $row[$param];

    //VERIFICA SE EXISTE VARIAVEL DE CALIBRAÇÃO
    if(!empty($resultCali)){

        foreach ($resultCali as $calibri) {
            $cal = $calibri;
        }
        //RECUPERA A VARIAVEL DE CALIBRAÇÃO
        $calibracao = $cal['variavel_cal'];

    }else{
        //CASO NÃO EXISTA UMA VARIAVEL DE CALIBRAÇÃO CADASTRADO PARA A POSIÇÃO
        $calibracao = 1;
    }

    foreach ($result as $row){
        $resp = $row[$param];
    }

    $resp = intval($resp) * $calibracao;

    /* converte a resposta em uma array */
    $array = array($resp);
    /* joga na funcao calback como encriptacao json */
    echo $_GET['callback']. '('. json_encode($array) . ')';
}
/* finaliza a conexao com o banco de dados */
//$cone->close();

?>
