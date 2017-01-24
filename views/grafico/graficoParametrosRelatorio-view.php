<?php
    /* verifica se esta definido o path */
    if (! defined('EFIPATH')) exit();

    $dadosCliente   = $modeloClie->carregarDadosCliente($this->parametros[0]);

    if($dadosCliente['status']){
        $dadosCliente   = $dadosCliente['dados'][0];
        $lista          = $modeloEquip->listarEquipamentosCliente($this->parametros[0]);
        $lista          = $lista['equipamentos'];
        $nomeCliente    = $dadosCliente['nome'];
    }else{
        $lista          = false;
    }

?>

<script src="<?php echo HOME_URI; ?>/views/_js/table/mustache.js" type="text/javascript"></script>
<script src="<?php echo HOME_URI; ?>/views/_js/table/stream_table.js" type="text/javascript"></script>


<script type="text/javascript">
    // gerenciador de link
    var menu = document.getElementById('listadir');
    menu.innerHTML = '<a href="<?php echo HOME_URI; ?>/home/" class="linkMenuSup">Home</a> / <a href="<?php echo HOME_URI; ?>/grafico/" class="linkMenuSup">Relatôrio </a> / <a href="<?php echo HOME_URI; ?>/grafico/listaFilial/<?php echo $this->parametros[0]; ?>"> Cliente :<?php echo $nomeCliente; ?></a>';
</script>

<div class="row">
    <div class="col-md-12">
        <!-- Titulo pagina -->
        <label class="page-header">Relatôrios para equipamentos da matriz/filiais</label><!-- Fim Titulo pagina -->
    </div>
</div>

<div class="row">
    <div class="col-lg-12">

        <!-- TABELA CONTENDO OS USUÁRIOS CADASTRADOS -->
        <div class="panel panel-default">
            <div class="panel-heading">
            </diV>

        </div>
    </div>
</div>
