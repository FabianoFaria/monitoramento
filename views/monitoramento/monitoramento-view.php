<?php
/* verifica se esta definido o path */
if (! defined('EFIPATH')) exit();
?>

<script src="<?php echo HOME_URI; ?>/views/_js/table/mustache.js" type="text/javascript"></script>
<script src="<?php echo HOME_URI; ?>/views/_js/table/stream_table.js" type="text/javascript"></script>

<?php
// chamando lista de valores
$retorno = $modelo->buscaRelacao();

// Retorna a lista de clientes

//Retorno sendo carregado direto da class.main
$lista = $modeloClie->listarCliente();

?>

<script type="text/javascript">
    var Movies0 = [
        <?php
            /* se for um array */
            if (is_array($retorno))
            {
                $guarda = "";
                foreach($retorno as $row)
                {
                    $statusVer = "Desativado";
                    if ($row['status_ativo'] == 1)
                        $statusVer = "Ativado";

                    /* convert data para o padrao brasileiro */
                    $tempo = date('d/m/Y', strtotime($row['dt_criacao']));

                    /* criptografa sim */
                    $chaveSim = base64_encode($row['num_sim']);


                    $guarda .= "{modelsh: '{$chaveSim}',
                                 num_sim: {$row['num_sim']},
                                 dataTmp: '{$tempo}',
                                 cliente: '{$modelo->converte($row['nome'],1)}',
                                 status: '{$statusVer}' },";
                }
                $guarda .= ".";
                $guarda = str_replace(",.","",$guarda);
                echo $guarda;
            }
        ?>
    ];
    var Movies = [Movies0];


    // gerenciador de link
    var menu = document.getElementById('listadir');
    menu.innerHTML = '<a href="<?php echo HOME_URI; ?>/home/" class="linkMenuSup">Home</a> / <a href="<?php echo HOME_URI; ?>/monitoramento/" class="linkMenuSup">Monitoramento</a>';
</script>


<script src="<?php echo HOME_URI; ?>/views/_js/table/index.js" type="text/javascript"></script>

<div class="row">
    <div class="col-md-12">
        <!-- Titulo pagina -->
        <label class="page-header">Clientes configurados para monitorar</label><!-- Fim Titulo pagina -->
    </div>
</div>

<div class="row">
    <div class="col-lg-12">

        <!-- TABELA CONTENDO TODOS OS CLIENTES -->
        <div class="panel panel-default">
            <div class="panel-heading">
            </div>

            <div class="panel-body">
                <div class='table-responsive'>
                    <table id="" class='table table-striped table-bordered'>
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Cidade</th>
                                <th>Telefone</th>
                                <th class="txt-center">Monitorar equipamentos</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                if($lista)
                                {
                                    foreach ($lista as $cliente){
                                ?>
                                    <tr>
                                        <td><?php echo $cliente['nome']; ?></td>
                                        <td><?php echo $cliente['cidade']; ?></td>
                                        <td><?php echo "(".$cliente['ddd'].") ".$cliente['telefone']; ?></td>
                                        <td><a href="<?php echo HOME_URI; ?>/monitoramento/unidades/<?php echo  $cliente['id']; ?>"><i class="fa  fa-camera-retro fa-2x"></i></a></td>
                                    </tr>
                                <?php
                                    }
                                }
                                else{
                                ?>
                                    <tr>
                                        <td colspan="4">Nenhum cliente cadastrado até o momento</td>
                                    </tr>
                                <?php
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

    </div>
</div>
