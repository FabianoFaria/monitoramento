<?php
/*
 *      pagina de vinculo do SIM ao Cliente
 *      
 */

// verfica link
if (! defined('EFIPATH')) exit();

/* sempre que existir uma acao de cadastro */
$modelo->vincularSim();

?>

<script type="text/javascript">
    // gerenciador de link
    var menu = document.getElementById('listadir');
    menu.innerHTML = '<a href="<?php echo HOME_URI; ?>/home/" class="linkMenuSup">Home</a> / <a href="<?php echo HOME_URI; ?>/vinculo/" class="linkMenuSup">Vinculo</a> / <a href="<?php echo HOME_URI; ?>/vinculo/vincularsim/" class="linkMenuSup">Vincular SIM</a>';
</script>


<div class="container-fluid fontPadrao">
    <!-- Titulo pagina -->
    <label class="titulo-pagina">CLIENTE AO SIM</label><!-- Fim Titulo pagina -->
    
    
    <!-- formulario de cadastro -->
    <form method="post">
        
        <div class="row">
            <!-- nome da matiz -->
            <div class="col-md-4">
                <div class="form-group">
                    <label for="exampleInputEmail1">Cliente</label><br>
                    <?php $modelo->loadClienteFilial(); ?>
                </div>
            </div><!-- fim do campo nome da matiz -->
            
            <!-- Codigo SIM -->
            <div class="col-md-4">
                <div class="form-group">
                    <label for="exampleInputEmail1">C&oacute;digo do SIM</label>
                    <input type="text" class="form-control" id="txt_numSim" name="txt_numSim" placeholder="C&oacute;digo do SIM" maxlength="14" onkeypress="return onlyNumber(event);" required>
                </div>
            </div><!-- fim do Codigo SIM -->
        </div>
        
        
        <!-- botao de envio -->
        <div class="row">
            <div class="col-md-2 col-md-offset-5 txt-center">
                <input type="submit" class="btn btn-info" name="btn_vicular" value="Vicular SIM"></div>
        </div><!-- fim botao de envio -->
        
    </form><!-- fim do formulario -->
</div>