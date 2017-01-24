<?php
// Inclui o cabecalho informando que eh um JSON
header("content-type: application/json");

// Inclui a classe de conexao com o banco
require_once '../class-EficazDB.php';
$conn = new EficazDB();

//$select = $conn->selectGrafico();
$select = $conn->select("SELECT * FROM tb_dados ORDER BY dt_criacao DESC LIMIT 20 ");

// Verifica se existe valor no select
if (@mysql_num_rows($select) > 0)
{
    // Converte a resposta do select em array
    while($row = @mysql_fetch_array($select))
    {
        // Separa a data da hora
        $separando = explode(' ',$row['dt_insercao']);
        // Separa os valores da data em dia , mes e ano em array
        $sepData = explode('-',$separando['0']);
        // Separa a hora em hora e min em array
        $sepHora = explode(':',$separando['1']);
        // Monta o array com o formato de dado do grafico
        $data[] = "Date.UTC({$sepData[0]}, {$sepData[1]}, {$sepData[2]}, {$sepHora[0]} , {$sepHora[1]}, {$sepHora[2]})";
        // Armazena o valor
        $data[] = $row['c'];

    }

    //$array = array($resp);
    echo $_GET['callback']. '('. json_encode($data) . ')';
    //print_r($data);
    return
}
// Fecha a conexao com o banco de dados
$conn->close();

?>
