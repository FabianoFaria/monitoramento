<?php

    define('EFIPATH', dirname(__DIR__)."/eficazmonitor");

?>
<html>
    <head>
        <title>Teste</title>
        <link href="views/_css/bootstrap.css" rel="stylesheet" type="text/css">
        <script src="views/_js/jquery.js"></script>
        <script src="views/_js/bootstrap-filestyle.min.js"> </script>
        <style type="text/css">
            td { border: 1px solid #333; text-align: center; font-size: 12px; }
        </style>
    </head>

    <body>

        <?php

        include($_SERVER["DOCUMENT_ROOT"]."/classes/class-EficazDB.php");

        $conn = new EficazDB();

        //Var_dump($conn);

        $query = "select * from tb_dados order by (dt_criacao) desc limit 1440";

        //$pdo = $conn->connect();

        // o método PDO::prepare() retorna um objeto da classe PDOStatement ou FALSE se ocorreu algum erro (neste caso use $pdo->errorInfo() para descobrir o que deu errado)
        $stmt = $conn->select($query);

        //var_dump($stmt);

        //$res = $conn->select($query);

        //if (mysql_num_rows($res) > 0)
        if(!empty($stmt))
        {
            echo "<table class='table table-bordered table-font'>";
            echo "<tr>
                <td><b>Numero sim</b></td>
                <td><b>B</b></td>
                <td><b>C</b></td>
                <td><b>D</b></td>
                <td><b>E</b></td>
                <td><b>F</b></td>
                <td><b>G</b></td>
                <td><b>H</b></td>
                <td><b>I</b></td>
                <td><b>J</b></td>
                <td><b>L</b></td>
                <td><b>M</b></td>
                <td><b>N</b></td>
                <td><b>O</b></td>
                <td><b>P</b></td>
                <td><b>Q</b></td>
                <td><b>R</b></td>
                <td><b>S</b></td>
                <td><b>T</b></td>
                <td><b>U</b></td>
                <td><b>DATA ENVIO</b></td>
            </tr>";
            foreach($stmt as $fila){

                $t = date_create($fila['dt_criacao']);
                $tempo = date_format($t, "d/m/Y - H:i:s");

                echo "<tr >";
                echo "<td >{$fila['num_sim']}</td>";
                echo "<td >{$fila['b']}</td>";
                echo "<td >{$fila['c']}</td>";
                echo "<td >{$fila['d']}</td>";
                echo "<td >{$fila['e']}</td>";
                echo "<td >{$fila['f']}</td>";
                echo "<td >{$fila['g']}</td>";
                echo "<td >{$fila['h']}</td>";
                echo "<td >{$fila['i']}</td>";
                echo "<td >{$fila['j']}</td>";
                echo "<td >{$fila['l']}</td>";
                echo "<td >{$fila['m']}</td>";
                echo "<td >{$fila['n']}</td>";
                echo "<td >{$fila['o']}</td>";
                echo "<td >{$fila['p']}</td>";
                echo "<td >{$fila['q']}</td>";
                echo "<td >{$fila['r']}</td>";
                echo "<td >{$fila['s']}</td>";
                echo "<td >{$fila['t']}</td>";
                echo "<td >{$fila['u']}</td>";
                echo "<td >{$tempo}</td>";
                echo "</tr>";
            }
            echo "</table>";
        }


        ?>

    </body>
</html>
