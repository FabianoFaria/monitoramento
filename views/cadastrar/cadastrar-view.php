<?php
    if (! defined('EFIPATH')) exit();
?>


<script type="text/javascript">
    // gerenciador de link
    var menu = document.getElementById('listadir');
    menu.innerHTML = '<a href="<?php echo HOME_URI; ?>/home/" class="linkMenuSup">Home</a> / <a href="<?php echo HOME_URI; ?>/cadastrar/" class="linkMenuSup">Cadastrar</a>';
</script>


<div class="container-fluid">
    <!-- Titulo pagina -->
    <label class="titulo-pagina">CADASTRO</label><!-- Fim Titulo pagina -->
    
    
    <div class="row">
        <!-- Cliente -->
        <div class="col-md-2 txt-center">
            <a href="<?php echo HOME_URI; ?>/cadastrar/cliente/" class="linkCad">
                <span class="iconTela"><i class="fa fa-university fa-lg"></i></span><br>
                <span class="textTela">Cliente</span></a>
        </div><!-- Fim Cliente -->
        
        
        <!-- Filial -->
        <div class="col-md-2 txt-center">
            <a href="<?php echo HOME_URI; ?>/cadastrar/filial/" class="linkCad">
            <span class="iconTela"><i class="fa fa-building-o fa-lg"></i></span><br>
            <span class="textTela">Filial</span></a>
        </div><!-- Fim Filial -->
        
        
        <!-- Fabricante -->
        <div class="col-md-2 txt-center">
            <a href="<?php echo HOME_URI; ?>/cadastrar/fabricante/" class="linkCad">
                <span class="iconTela"><i class="fa fa-gavel fa-lg"></i></span><br>
                <span class="textTela">Fabricante</span></a>
        </div><!-- Fim Fabricante -->
        
        
        <!--Equipamento -->
        <div class="col-md-2 txt-center">
            <a href="<?php echo HOME_URI; ?>/cadastrar/equipamento/" class="linkCad">
                <span class="iconTela"><i class="fa fa-hdd-o fa-lg"></i></span><br>
                <span class="textTela">Equipamento</span></a>
        </div><!-- Fim Equipamento -->
        
        
        <!-- Usuario -->
        <div class="col-md-2 txt-center">
            <a href="<?php echo HOME_URI; ?>/cadastrar/usuario/" class="linkCad">
                <span class="iconTela"><i class="fa fa-user-plus fa-lg"></i></span><br>
                <span class="textTela">Usu&aacute;rio</span></a>
        </div><!-- FIm Usuario -->
    </div>
</div>