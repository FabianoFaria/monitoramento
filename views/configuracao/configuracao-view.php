<?php

/* verifica se esta definido o path */
if (! defined('EFIPATH')) exit();

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
    menu.innerHTML = '<a href="<?php echo HOME_URI; ?>/home/" class="linkMenuSup">Home</a> / <a href="<?php echo HOME_URI; ?>/configuracao/" class="linkMenuSup">Configura&ccedil;&atilde;o</a>';
</script>


<script src="<?php echo HOME_URI; ?>/views/_js/table/index.js" type="text/javascript"></script>


<div class="container-fluid">
    <!-- Titulo pagina -->
    <label class="page-header">CONFIGURA&Ccedil;&Atilde;O</label><!-- Fim Titulo pagina -->

    <div class='table-responsive'>
        <table id="stream_table" class='table table-striped table-bordered'>
            <thead>
                <tr>
                    <th class="tdbdbottom">Cliente</th>
                    <th class="tdbdbottom">Data ativa&ccedil;&atilde;o</th>
                    <th class="tdbdbottom">Status</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
        <div id="summary"><div></div></div>
    </div>
</div>

<script id="template" type="text/html">
    <tr>
        <td class="tdprim">
            <a href="<?php echo HOME_URI; ?>/configuracao/listaClienteFilial/{{record.modelsh}}" class="link-tabela-moni">
                {{record.cliente}}
            </a>
        </td>
        <td class="">
            <a href="<?php echo HOME_URI; ?>/configuracao/listaClienteFilial/{{record.modelsh}}" class="link-tabela-moni">
                {{record.dataTmp}}
            </a>
        </td>
        <td class="">
            <a href="<?php echo HOME_URI; ?>/configuracao/listaClienteFilial/{{record.modelsh}}" class="link-tabela-moni">
                {{record.status}}
            </a>
        </td>
    </tr>
</script>
