<?php
if (!defined("EFIPATH")) exit();

// chamando lista de valores
$retorno = $modelo->pesquisaRelacao();

?>

<script src="<?php echo HOME_URI; ?>/views/_js/table/mustache.js" type="text/javascript"></script>
<script src="<?php echo HOME_URI; ?>/views/_js/table/stream_table.js" type="text/javascript"></script>

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
                    if ($row['situacao'] == 1)
                        $statusVer = "Ativado";

                    $codCli = base64_encode($row['codCliente']);

                    /* monta a array */
                    $guarda .= "{
                        codigo: '{$codCli}' ,
                        nome  : '{$modelo->converte($row['nome'])}' ,
                        status: '{$statusVer}'
                    } ,";
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
    menu.innerHTML = '<a href="<?php echo HOME_URI; ?>/home/" class="linkMenuSup">Home</a> / <a href="" class="linkMenuSup">Editar Cliente</a>';
</script>

<script src="<?php echo HOME_URI; ?>/views/_js/table/index.js" type="text/javascript"></script>


<div class="container-fluid">
    <!-- Titulo pagina -->
    <label class="titulo-pagina">CLIENTE CADASTRADO</label><!-- Fim Titulo pagina -->
    
    
    <div class='table-responsive'>
        <table id="stream_table" class='table table-striped table-bordered'>
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Status</th>
                    <th class="txt-center">Editar</th>
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
            <a href="<?php echo HOME_URI; ?>/editar/editarCliente/{{record.codigo}}" class="link-tabela-moni">
                {{record.nome}}</td>
            </a>
        <td class="link-tabela-moni">
            <a href="<?php echo HOME_URI; ?>/editar/editarCliente/{{record.codigo}}" class="link-tabela-moni">
                {{record.status}}</td>
            </a>
        <td class="tdsec txt-center">
            <a href="<?php echo HOME_URI; ?>/editar/editarCliente/{{record.codigo}}" class="link-tabela-moni">
                <i class="fa fa-pencil-square-o fa-lg"></i>
            </a>
        </td>
    </tr>
</script>