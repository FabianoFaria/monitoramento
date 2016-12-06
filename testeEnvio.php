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

        require_once "classes/class-EficazDB.php";

        $conn = new EficazDB();

        $query = "select * from tb_dados order by (dt_criacao) desc limit 1440";

        $res = $conn->select($query);
        
        if (@mysql_num_rows($res) > 0)
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
            while ($row = @mysql_fetch_assoc($res))
            {
                $t = date_create($row['dt_criacao']);
                $tempo = date_format($t, "d/m/Y - H:i:s");
                echo "<tr >";
                echo "<td >{$row['num_sim']}</td>";
                echo "<td >{$row['b']}</td>";
                echo "<td >{$row['c']}</td>";
                echo "<td >{$row['d']}</td>";
                echo "<td >{$row['e']}</td>";
                echo "<td >{$row['f']}</td>";
                echo "<td >{$row['g']}</td>";
                echo "<td >{$row['h']}</td>";
                echo "<td >{$row['i']}</td>";
                echo "<td >{$row['j']}</td>";
                echo "<td >{$row['l']}</td>";
                echo "<td >{$row['m']}</td>";
                echo "<td >{$row['n']}</td>";
                echo "<td >{$row['o']}</td>";
                echo "<td >{$row['p']}</td>";
                echo "<td >{$row['q']}</td>";
                echo "<td >{$row['r']}</td>";
                echo "<td >{$row['s']}</td>";
                echo "<td >{$row['t']}</td>";
                echo "<td >{$row['u']}</td>";
                echo "<td >{$tempo}</td>";
                echo "</tr>";
            }
            echo "</table>";
        }
        

        ?>
        
    </body>
</html>