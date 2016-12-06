<?php

if (! defined('EFIPATH')) exit();

// insere o modulo de gravacao 
$modelo->cadastrarFabricante();

?>

<script type="text/javascript">
    // gerenciador de link
    var menu = document.getElementById('listadir');
    menu.innerHTML = '<a href="<?php echo HOME_URI; ?>/home/" class="linkMenuSup">Home</a> / <a href="<?php echo HOME_URI; ?>/cadastrar/" class="linkMenuSup">Cadastrar</a> / <a href="<?php echo HOME_URI; ?>/cadastrar/fabricante/" class="linkMenuSup">Fabricante</a>';
</script>


<div class="container-fluid fontPadrao">
    <!-- Titulo pagina -->
    <label class="titulo-pagina">FABRICANTE</label><!-- Fim Titulo pagina -->
    
    
    <!-- formulario de cadastro -->
    <form method="post">
        <div class="row">
            <!-- nome do fabricante -->
            <div class="col-md-6">
                <div class="form-group">
                    <label for="exampleInputEmail1">Nome do Fabricante</label>
                    <input type="text" class="form-control" id="txt_fabricante" name="txt_fabricante" placeholder="Nome do Equipamento" maxlength="80" required>
                </div>
            </div><!-- fim nome do fabricante -->
            
            
            <!-- DDD -->
            <div class="col-md-2">
                <div class="form-group">
                    <label for="exampleInputEmail1">C&oacute;digo de &Aacute;rea</label>
                    <input type="text" class="form-control" id="txt_ddd" name="txt_ddd" placeholder="DDD (000)" maxlength="3" onkeypress="return onlyNumber(event);">
                </div>
            </div><!-- fim do ddd -->
            
            <!-- telefone -->
            <div class="col-md-4">
                <div class="form-group">
                    <label for="exampleInputEmail1">Telefone</label>
                    <input type="text" class="form-control" id="txt_telefone" name="txt_telefone" placeholder="Telefone" maxlength="10" onkeypress="return onlyNumber(event);">
                </div>
            </div><!-- fim do telefone -->
        </div>
        
        
        
        <div class="row">
            <!-- cep -->
            <div class="col-md-2">
                <div class="form-group">
                    <label for="exampleInputEmail1">CEP</label>
                    <input type="text" class="form-control" id="txt_cep" name="txt_cep" placeholder="CEP" maxlength="9" required onkeypress="return onlyNumber(event);">
                </div>
            </div><!-- fim do cep -->
            
            
            <!-- endereco do cliente -->
            <div class="col-md-6">
                <div class="form-group">
                    <label for="exampleInputEmail1">Endere&ccedil;o</label>
                    <input type="text" class="form-control" id="txt_endereco" name="txt_endereco" placeholder="Rua, Avenida e etc" maxlength="200" required>
                </div>
            </div><!-- fim do endereco do cliente -->
            
            <!-- numero -->
            <div class="col-md-2">
                <div class="form-group">
                    <label for="exampleInputEmail1">N&uacute;mero</label>
                    <input type="text" class="form-control" id="txt_numero" name="txt_numero" placeholder="N&uacute;mero" maxlength="9"  onkeypress="return onlyNumber(event);">
                </div>
            </div><!-- fim do numero -->
        </div>
        
        
        <div class="row">
            <!-- Cidade -->
            <div class="col-md-3">
                <div class="form-group">
                    <label for="exampleInputEmail1">Cidade</label>
                    <input type="text" class="form-control" id="txt_cidade" name="txt_cidade" placeholder="Cidade" maxlength="50" required>
                </div>
            </div><!-- fim do campo Cidade -->
            
            <!-- Bairro -->
            <div class="col-md-3">
                <div class="form-group">
                    <label for="exampleInputEmail1">Bairro</label>
                    <input type="text" class="form-control" id="txt_bairro" name="txt_bairro" placeholder="Cidade" maxlength="50" required>
                </div>
            </div><!-- fim do campo Bairro -->
            
            
            <!-- pais -->
            <div class="col-md-3">
                <div class="form-group">
                    <label for="exampleInputEmail1">Pais</label><br>
                    <?php $modelo->listaPaises(); ?>
                </div>
            </div><!-- fim do pais -->
            
            
            <!-- estado -->
            <div class="col-md-3">
                <div class="form-group">
                    <label for="exampleInputEmail1">Estado</label><br>
                    <?php $modelo->listaEstado(); ?>
                </div>
            </div><!-- fim do estado -->
        </div>
        
        
        
        <!-- botao de enviar -->
        <div class="row">
            <div class="col-md-2 col-md-offset-5 txt-center"><input type="submit" name="btn_salvar" class="btn btn-info" value="Salvar"></div>
        </div><!-- fim do botao de envio -->
        
    </form><!-- fim do formulario de cadastro -->
</div>