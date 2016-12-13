<?php
    if (! defined('EFIPATH')) exit();
?>

<script type="text/javascript">
    // gerenciador de link
    var menu = document.getElementById('listadir');
    menu.innerHTML = '<a href="<?php echo HOME_URI; ?>/home/" class="linkMenuSup">Home</a> / <a href="<?php echo HOME_URI; ?>/vinculo/" class="linkMenuSup">Vinculo</a>';
</script>


<div class="container-fluid">
    <!-- Titulo pagina -->
    <label class="page-header">Selecione o tipo de vinculo a efetuar</label><!-- Fim Titulo pagina -->


    <div class="row">
        <!-- Cliente -->
        <div class="col-md-3 txt-center">
            <a href="<?php echo HOME_URI; ?>/vinculo/vincularsim/" class="linkCad">
                <div class="well">
                    <span class="iconTela"> <i class="fa fa-university fa-lg"></i><i class="fa fa-plug"></i></span><br>
                    <span class="textTela">Cliente ao SIM</span>
                </div>
            </a>
        </div><!-- Cliente Fim  -->

        <!-- Equipamento / Ambiente -->
        <div class="col-md-3 txt-center">
            <a href="<?php echo HOME_URI; ?>/vinculo/vincular/" class="linkCad">
                <div class="well">
                    <span class="iconTela"><i class="fa fa-hdd-o fa-lg"></i><i class="fa fa-plug"></i></span><br>
                    <span class="textTela">Equipamento ao SIM</span>
                </div>
            </a>
        </div><!-- Equipamento / Ambiente Fim  -->

        <!-- Tabela -->
        <div class="col-md-3 txt-center">
            <a href="<?php echo HOME_URI; ?>/vinculo/equipamentolista/" class="linkCad">
                <div class="well">
                    <span class="iconTela"><i class="fa fa-table fa-lg"></i></span><br>
                    <span class="textTela">Vincular Posi&ccedil;&atilde;o</span>
                </div>
            </a>
        </div><!-- Fim Tabela  -->
    </div>
</div>
