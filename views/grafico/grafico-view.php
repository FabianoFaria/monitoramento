<?php
/* verifica se esta definido o path */
if (! defined('EFIPATH')) exit();


    $listaClientes = $modeloClie->listarCliente();

    //var_dump($listaClientes);

?>


<script src="<?php echo HOME_URI; ?>/views/_js/table/mustache.js" type="text/javascript"></script>
<script src="<?php echo HOME_URI; ?>/views/_js/table/stream_table.js" type="text/javascript"></script>


<?php
// chamando lista de valores
$retorno = $modelo->buscaRelacao();
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
    menu.innerHTML = '<a href="<?php echo HOME_URI; ?>/home/" class="linkMenuSup">Home</a> / <a href="<?php echo HOME_URI; ?>/grafico/" class="linkMenuSup">Relatôrios </a>';
</script>


<script src="<?php echo HOME_URI; ?>/views/_js/table/index.js" type="text/javascript"></script>

<div class="row">
    <div class="col-md-12">
        <!-- Titulo pagina -->
        <label class="page-header">Relatorios</label><!-- Fim Titulo pagina -->
    </div>

</div>

<div class="row">
    <div class="col-lg-12">

        <!-- TABELA CONTENDO OS USUÁRIOS CADASTRADOS -->
        <div class="panel panel-default">
            <div class="panel-heading">

            </div>
            <div class="panel-body">

                <table class='table table-striped table-bordered'>
                    <thead>
                        <tr>
                            <th class="tdbdbottom">Cliente</th>
                            <th class="tdbdbottom">Data ativa&ccedil;&atilde;o</th>
                            <th class="tdbdbottom">Status</th>
                            <th class="tdbdbottom">Equipamentos para relatôrio</th>
                        </tr>
                    </thead>
                    <tbdoy>
                        <?php
                            if($listaClientes){

                                foreach ($listaClientes as $cliente) {

                                    $data           = explode(" ",$cliente['dt_criacao']);
                                    $dataCliente    = $data[0];

                                    ?>
                                    <tr>
                                        <td><?php echo $cliente['nome']?></td>
                                        <td><?php echo implode("/", array_reverse(explode("-", $dataCliente))); ?></td>
                                        <td><?php echo ($cliente['status_ativo'] == 1) ? "Ativo": "Desativado" ; ?></td>
                                        <td><a href="<?php echo HOME_URI; ?>/grafico/listaFilial/<?php echo $cliente['id']; ?>"><i class="fa fa-file-text-o fa-2x"></i></a></td>
                                    </tr>
                                    <?php
                                }

                            }else{
                                echo "<tr><td colspan='4'>Nenhum cliente disponivel. </td></tr>";
                            }
                        ?>
                    </tbdoy>
                </table>

            </div>
        </div>

    </div>
</div>
