<?php
// verfica link
if (! defined('EFIPATH')) exit();

// carrega a funcao de cadastro
$modelo->cadastrarFilial();


if (isset($_POST))
{
    $nFilia = !empty ($_POST['txt_filial']) ? $_POST['txt_filial'] : '';
    $nDdd = !empty ($_POST['txt_ddd']) ? $_POST['txt_ddd'] : '';
    $nTelefone = !empty ($_POST['txt_telefone']) ? $_POST['txt_telefone'] : '';
    $nCep = !empty ($_POST['txt_cep']) ? $_POST['txt_cep'] : '';
    $nEndereco = !empty ($_POST['txt_endereco']) ? $_POST['txt_endereco'] : '';
    $nNumero = !empty ($_POST['txt_numero']) ? $_POST['txt_numero'] : '';
    $nCidade = !empty ($_POST['txt_cidade']) ? $_POST['txt_cidade'] : '';
    $nBairro = !empty ($_POST['txt_bairro']) ? $_POST['txt_bairro'] : '';
}
else
{
    $nFilia = '';
    $nDdd = '';
    $nTelefone = '';
    $nCep = '';
    $nEndereco = '';
    $nNumero = '';
    $nCidade = '';
    $nBairro = '';
}


?>

<script type="text/javascript">
    // gerenciador de link
    var menu = document.getElementById('listadir');
    menu.innerHTML = '<a href="<?php echo HOME_URI; ?>/home/" class="linkMenuSup">Home</a> / <a href="<?php echo HOME_URI; ?>/cadastrar/" class="linkMenuSup">Cadastrar</a> / <a href="<?php echo HOME_URI; ?>/cadastrar/filial/" class="linkMenuSup">Filial</a>';
</script>


<div class="container-fluid fontPadrao">
    <!-- Titulo pagina -->
    <label class="titulo-pagina">FILIAL</label><!-- Fim Titulo pagina -->
    
    
    <!-- formulario de cadastro -->
    <form method="post" enctype="multipart/form-data">
        
        <div class="row">
            <!-- nome da filial -->
            <div class="col-md-6">
                <div class="form-group">
                    <label for="exampleInputEmail1">Nome da Filial</label>
                    <input type="text" class="form-control" id="txt_filial" name="txt_filial" placeholder="Nome da Filial" maxlength="100" required value="<?php echo $nFilia; ?>">
                </div>
            </div><!-- fim do campo nome da filial -->
            
            
            <!-- nome da matiz -->
            <div class="col-md-6">
                <div class="form-group">
                    <label for="exampleInputEmail1">Matriz</label><br>
                    <?php $modelo->listaMatriz(); ?>
                
                </div>
            </div><!-- fim do campo nome da matiz -->
        </div>
        
        
        <div class="row">
            <!-- DDD -->
            <div class="col-md-2">
                <div class="form-group">
                    <label for="exampleInputEmail1">C&oacute;digo de &Aacute;rea</label>
                    <input type="text" class="form-control" id="txt_ddd" name="txt_ddd" placeholder="DDD (000)" maxlength="3" onkeypress="return onlyNumber(event);" value="<?php echo $nDdd; ?>">
                </div>
            </div><!-- fim do ddd -->
            
            <!-- telefone -->
            <div class="col-md-3">
                <div class="form-group">
                    <label for="exampleInputEmail1">Telefone</label>
                    <input type="text" class="form-control" id="txt_telefone" name="txt_telefone" placeholder="Telefone" maxlength="9" onkeypress="return onlyNumber(event);" value="<?php echo $nTelefone; ?>">
                </div>
            </div><!-- fim do telefone -->
            
            <!-- foto -->
            <div class="col-md-4">
                <div class="form-group">
                    <label for="foto">Logo / Foto cliente</label>
                    <input type="file" name="file_foto" id="file_foto" class="filestyle" data-icon="false">
                </div>
            </div><!-- Fim fotos -->
        </div>
        
        
        <div class="row">
            <!-- cep -->
            <div class="col-md-2">
                <div class="form-group">
                    <label for="exampleInputEmail1">CEP</label>
                    <input type="text" class="form-control" id="txt_cep" name="txt_cep" placeholder="CEP" maxlength="9" required onkeypress="return onlyNumber(event);" value="<?php echo $nCep; ?>">
                </div>
            </div><!-- fim do cep -->
            
            <!-- endereco do cliente -->
            <div class="col-md-6">
                <div class="form-group">
                    <label for="exampleInputEmail1">Endere&ccedil;o</label>
                    <input type="text" class="form-control" id="txt_endereco" name="txt_endereco" placeholder="Rua, Avenida e etc" maxlength="200" required value="<?php echo $nEndereco;?>">
                </div>
            </div><!-- fim do endereco do cliente -->
            
            <!-- numero -->
            <div class="col-md-2">
                <div class="form-group">
                    <label for="exampleInputEmail1">N&uacute;mero</label>
                    <input type="text" class="form-control" id="txt_numero" name="txt_numero" placeholder="N&uacute;mero" maxlength="10" onkeypress="return onlyNumber(event);" value="<?php echo $nNumero;?>">
                </div>
            </div><!-- fim do numero -->
        </div>
        
        
        
        <div class="row">
            <!-- Cidade -->
            <div class="col-md-3">
                <div class="form-group">
                    <label for="exampleInputEmail1">Cidade</label>
                    <input type="text" class="form-control" id="txt_cidade" name="txt_cidade" placeholder="Cidade" maxlength="50" required value="<?php echo $nCidade;?>">
                </div>
            </div><!-- fim do campo Cidade -->
            
            <!-- Bairro -->
            <div class="col-md-3">
                <div class="form-group">
                    <label for="exampleInputEmail1">Bairro</label>
                    <input type="text" class="form-control" id="txt_bairro" name="txt_bairro" placeholder="Cidade" maxlength="50" required value="<?php echo $nBairro;?>">
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
        
        
        
        <!-- botao de envio -->
        <div class="row">
            <div class="col-md-2 col-md-offset-5 txt-center"><input type="submit" class="btn btn-info" name="btn_enviar" value="Salvar"></div>
        </div><!-- fim botao de envio -->
        
    </form><!-- fim do formulario -->
</div>