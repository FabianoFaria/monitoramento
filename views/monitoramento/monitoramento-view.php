<?php
/* verifica se esta definido o path */
if (! defined('EFIPATH')) exit();
?>

<script src="<?php echo HOME_URI; ?>/views/_js/table/mustache.js" type="text/javascript"></script>
<script src="<?php echo HOME_URI; ?>/views/_js/table/stream_table.js" type="text/javascript"></script>

<?php
// chamando lista de valores
$retorno = $modelo->buscaRelacao();

//Retorno sendo carregado direto da class.main

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
        <label class="page-header">Monitoramento</label><!-- Fim Titulo pagina -->
    </div>

</div>
<div class="row">

        <div class="col-lg-12">
            <div class="panel panel-info" id="accordionFiltro">
                <div class="panel-heading">
                    <a data-toggle="collapse" data-parent="#accordionFiltro" href="#filtroCollapse"><h5><i class="fa fa-search-plus "></i> Filtro de alarmes</h5></a>
                </div>
                <div id="filtroCollapse" class="panel-body panel-collapse collapse in">
                    <form method="post">
                        <div class="row">
                            <!-- Status do alarme -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Status do alarme</label>
                                    <select class="form-control">
                                        <option value="">Selecione...</option>
                                        <option value="">Todos</option>
                                        <option value="">Alarme gerado</option>
                                        <option value="">Alarme reconhecido</option>
                                        <option value="">Alarme solucionado</option>
                                        <option value="">Alarme finalizado</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Nome do cliente -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Nome do cliente</label>
                                    <select class="form-control">
                                        <option value="">Selecione...</option>
                                        <option value="">Todos</option>
                                    </select>
                                </div>
                            </div>


                            <div class="col-md-4 ">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Filial</label>
                                    <select class="form-control">
                                        <option value="">Selecione...</option>
                                        <option value="">Todos</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-md-4 ">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Equipamento</label>
                                    <select class="form-control">
                                        <option value="">Selecione...</option>
                                        <option value="">Todos</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4 pull-right">
                                <button class="btn btn-info pull-right" type="button">Filtrar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

</div>

<div class="row">
    <div class="col-md-12">

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
</div>


<script id="template" type="text/html">
    <tr>
        <td class="tdprim">
            <a href="<?php echo HOME_URI; ?>/monitoramento/unidades/{{record.modelsh}}" class="link-tabela-moni">
                {{record.cliente}}
            </a>
        </td>
        <td class="">
            <a href="<?php echo HOME_URI; ?>/monitoramento/unidades/{{record.modelsh}}" class="link-tabela-moni">
                {{record.dataTmp}}
            </a>
        </td>
        <td class="">
            <a href="<?php echo HOME_URI; ?>/monitoramento/unidades/{{record.modelsh}}" class="link-tabela-moni">
                {{record.status}}
            </a>
        </td>
    </tr>
</script>

<script type="text/javascript">
$(document).ready(function() {
    $('#filtroCollapse').collapse("hide");
  });
</script>
