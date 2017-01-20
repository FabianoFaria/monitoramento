<?php

if (!defined('EFIPATH')) exit();

    $dadosCliente   = $modeloClie->carregarDadosCliente($this->parametros[0]);


    if($dadosCliente['status']){
        $listaFiliais   = $modeloClie->carregarFiliaisCliente($this->parametros[0]);
        $dadosCliente   = $dadosCliente['dados'][0];
        $nomeCliente    = $dadosCliente['nome'];
    }else{
        $listaFiliais   = false;
    }

    //var_dump($listaFiliais);

?>

<script src="<?php echo HOME_URI; ?>/views/_js/table/mustache.js" type="text/javascript"></script>
<script src="<?php echo HOME_URI; ?>/views/_js/table/stream_table.js" type="text/javascript"></script>

<?php
// chamando lista de valores
//$retorno = $modelo->buscaRelacaoFilial();
?>

<script type="text/javascript">
    // var Movies0 = [
    //     <?php
    //         /* se for um array */
    //         if (is_array($retorno))
    //         {
    //             $guarda = "";
    //
    //             for ($a = 0 ; $a < sizeof($retorno) ; $a++)
    //             {
    //                 if (!empty($retorno[$a]))
    //                 {
    //                     $statusVer = "Desativado";
    //                     if ($retorno[$a]['status_ativo'] == 1)
    //                         $statusVer = "Ativado";
    //
    //                     if ($retorno[$a]['nivel'] == 'c')
    //                         $nivel = "Matriz";
    //                     else if ($retorno[$a]['nivel'] == 'f')
    //                         $nivel = "Filial";
    //                     else
    //                         $nivel = '';
    //
    //                     /* convert data para o padrao brasileiro */
    //                     $tempo = explode(" ",$retorno[$a]['dt_criacao']);
    //                     $tempo = $tempo[0];
    //                     $tempo = explode("-",$tempo);
    //                     $tempo = $tempo[2]."/".$tempo[1]."/".$tempo[0];
    //
    //                     /* criptografa sim */
    //                     $chaveSim = base64_encode($retorno[$a]['num_sim']);
    //
    //
    //                     $guarda .= "{modelsh: '{$chaveSim}',
    //                                  num_sim: {$retorno[$a]['num_sim']},
    //                                  dataCriado: '{$tempo}',
    //                                  nivel: '{$nivel}',
    //                                  cliente: '{$modelo->converte($retorno[$a]['nome'],1)}',
    //                                  status: '{$statusVer}' },";
    //                 }
    //             }
    //
    //             $guarda .= ".";
    //             $guarda = str_replace(",.","",$guarda);
    //             echo $guarda;
    //
    //         }
    //     ?>
    // ];
    // var Movies = [Movies0];


    // gerenciador de link
    var menu = document.getElementById('listadir');
    menu.innerHTML = '<a href="<?php echo HOME_URI; ?>/home/" class="linkMenuSup">Home</a> / <a href="<?php echo HOME_URI; ?>/grafico/" class="linkMenuSup">Gr&aacute;fico</a> / <a href="<?php echo HOME_URI; ?>/grafico/listaFilial/<?php echo $this->parametros[0]; ?>"> Cliente :<?php echo $nomeCliente; ?></a>';
</script>


<script src="<?php echo HOME_URI; ?>/views/_js/table/index.js" type="text/javascript"></script>


<div class="row">
    <div class="col-md-12">
        <!-- Titulo pagina -->
        <label class="page-header">Relatorios para matriz/filiais</label><!-- Fim Titulo pagina -->
    </div>

</div>


<div class="container-fluid">

    <!-- Titulo pagina -->
    <label class="titulo-pagina-cliente"><?php echo $retorno[0]['nome']; ?></label>

    <label class="titulo-pagina">
        - GR&Aacute;FICO
    </label><!-- Fim Titulo pagina --><!-- Fim Titulo pagina -->



    <div class='table-responsive'>
        <table id="stream_table" class='table table-striped table-bordered'>
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Nivel</th>
                    <th>C&oacute;digo Sim</th>
                    <th>Status</th>
                    <th>Criado</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
        <div id="summary"><div></div></div>
    </div>
</div>

<!-- <script id="template" type="text/html">
    <tr>
        <td class="tdprim">
            <a href="<?php echo HOME_URI; ?>/grafico/listaEquipamento/{{record.modelsh}}" class="link-tabela-moni">
                {{record.cliente}}
            </a>
        </td>


        <td>
            <a href="<?php echo HOME_URI; ?>/grafico/listaEquipamento/{{record.modelsh}}" class="link-tabela-moni">
                {{record.nivel}}
            </a>
        </td>


        <td>
            <a href="<?php echo HOME_URI; ?>/grafico/listaEquipamento/{{record.modelsh}}" class="link-tabela-moni">
                {{record.num_sim}}
            </a>
        </td>


        <td>
            <a href="<?php echo HOME_URI; ?>/grafico/listaEquipamento/{{record.modelsh}}" class="link-tabela-moni">
                {{record.status}}
            </a>
        </td>
        <td>
            <a href="<?php echo HOME_URI; ?>/grafico/listaEquipamento/{{record.modelsh}}" class="link-tabela-moni">
                {{record.dataCriado}}
            </a>
        </td>
    </tr>
</script> -->
