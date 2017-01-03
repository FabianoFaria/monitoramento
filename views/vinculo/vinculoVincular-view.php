<?php
/*
 *      pagina de vinculo do Equipamento o SIM
 *
 */


/* verifica se esta definido o path */
if (! defined('EFIPATH')) exit();

/* quando existir uma acao de cadastro */
$modelo->cad_sim_equip();

?>


<script type="text/javascript">
    // gerenciador de link
    var menu = document.getElementById('listadir');
    menu.innerHTML = '<a href="<?php echo HOME_URI; ?>/home/" class="linkMenuSup">Home</a> / <a href="<?php echo HOME_URI; ?>/vinculo/" class="linkMenuSup">Vinculo</a> / <a href="<?php echo HOME_URI; ?>/vinculo/vincular/" class="linkMenuSup">Vincular Equipamento</a>';
</script>


<div class="container-fluid fontPadrao">
    <!-- Titulo pagina -->
    <label class="titulo-pagina">EQUIPAMENTO AO SIM</label><!-- Fim Titulo pagina -->


    <!-- formulario de cadastro -->
    <form method="post">
        <div class="row">
            <!-- Codigo SIM -->
            <div class="col-md-3">
                <div class="form-group">
                    <label for="exampleInputEmail1">C&oacute;digo do SIM</label><br>
                    <?php $modelo->listaClienteSim(); ?>
                </div>
            </div><!-- fim do Codigo SIM -->

            <!-- equipamentos -->
            <div class="col-md-3">
                <div class="form-group">
                    <label for="exampleInputEmail1">Equipamento</label><br>
                    <?php $modelo->listaEquipamento(); ?>
                </div>
            </div><!-- fim dos equipamentos -->

            <!-- Numero de serie -->
            <div class="col-md-3">
                <div class="form-group">
                    <label for="numeroSerie">N&uacute;mero de s&eacute;rie (Opcional)</label>
                    <input type="text" class="form-control" id="txt_numeroSerie" name="txt_numeroSerie" placeholder="N&uacute;mero de s&eacute;rie"
                    maxlength="30" onkeypress="return onlyNumber(event);" value="<?php if (isset($_POST['txt_numeroSerie'])) echo $_POST['txt_numeroSerie']; ?>">
                </div>
            </div><!-- fim Numero de serie -->


            <!-- Ambiente -->
            <div class="col-md-3">
                <div class="form-group">
                    <label for="ambiente">Ambiente (Opcional)</label>
                    <input type="text" class="form-control" id="txt_ambiente" name="txt_ambiente" placeholder="Ambiente" maxlength="50"
                    value="<?php if (isset($_POST['txt_ambiente'])) echo $_POST['txt_ambiente']; ?>">
                </div>
            </div><!-- fim Ambiente -->
        </div>

        <!-- botao de envio -->
        <div class="row">
            <div class="col-md-2 col-md-offset-5 txt-center">
                <input type="submit" class="btn btn-info" name="btn_vicular" value="Vicular"></div>
        </div><!-- fim botao de envio -->
    </form><!-- fim do formulario -->
</div>
