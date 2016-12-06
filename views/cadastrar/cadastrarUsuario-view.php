<?php
// Verfica link
if (! defined('EFIPATH')) exit();

// Sempre que acontecer um acao no botao de salvar
$modelo->cadastrarUsuario();


?>

<script type="text/javascript">
    // Gerenciador de link
    var menu = document.getElementById('listadir');
    menu.innerHTML = '<a href="<?php echo HOME_URI; ?>/home/" class="linkMenuSup">Home</a> / <a href="<?php echo HOME_URI; ?>/cadastrar/" class="linkMenuSup">Cadastrar</a> / <a href="<?php echo HOME_URI; ?>/cadastrar/usuario/" class="linkMenuSup">Usu&aacute;rio</a>';
</script>


<div class="container-fluid fontPadrao">
    <!-- Titulo pagina -->
    <label class="titulo-pagina">USU&Aacute;RIO</label><!-- Fim Titulo pagina -->
    
    
    <!-- formulario de cadastro -->
    <form method="post">
        <div class="row">
            <!-- nome do usuario -->
            <div class="col-md-4">
                <div class="form-group">
                    <label for="exampleInputEmail1">Nome do Usu&aacute;rio</label>
                    <input type="text" class="form-control" id="txt_nome" name="txt_nome" placeholder="Nome do Usu&aacute;rio" maxlength="50" required
                    value="<?php if (isset($_POST['txt_nome'])) echo $_POST['txt_nome']; ?>">
                </div>
            </div><!-- fim nome do usuario -->
            
            <!-- sobrenome do usuario -->
            <div class="col-md-4">
                <div class="form-group">
                    <label for="exampleInputEmail1">Sobrenome do Usu&aacute;rio</label>
                    <input type="text" class="form-control" id="txt_sobrenome" name="txt_sobrenome" placeholder="Sobrenome do Usu&aacute;rio" maxlength="90" required
                    value="<?php if (isset($_POST['txt_sobrenome'])) echo $_POST['txt_sobrenome']; ?>">
                </div>
            </div><!-- fim sobrenome do usuario -->
            
            <!-- E-mail -->
            <div class="col-md-4">
                <div class="form-group">
                    <label for="exampleInputEmail1">E-mail</label>
                    <input type="email" class="form-control" id="txt_email" name="txt_email" placeholder="E-mail" maxlength="50" required
                    value="<?php if (isset($_POST['txt_email'])) echo $_POST['txt_email']; ?>">
                </div>
            </div><!-- fim E-mail -->
        </div>
         
        
        <div class="row">
            <!-- senha -->
            <div class="col-md-4">
                <div class="form-group">
                    <label for="exampleInputEmail1">Senha</label>
                    <input type="password" class="form-control" id="txt_senha" name="txt_senha" placeholder="Senha" maxlength="30" required>
                    <span class="senhaPerm">Caracteres permitidos !,-,#,+,=,*</span>
                </div>
            </div><!-- fim senha -->
            
            <!-- confirma senha -->
            <div class="col-md-4">
                <div class="form-group">
                    <label for="exampleInputEmail1">Confirma senha</label>
                    <input type="password" class="form-control" id="txt_cfsenha" name="txt_cfsenha" placeholder="Confirma senha" maxlength="30" required>
                </div>
            </div><!-- fim confirma senha -->
            
            <!-- Usuario interno ou externo -->
            <div class="col-md-4">
                <div class="form-group">
                    <label for="exampleInputEmail1">Usu&aacute;rio interno ou externo</label>
                    <select id="opc_local" name="opc_local" required class="form-control">
                        <option value=3>Selecione</option>
                        <option value=1>Interno</option>
                        <option value=0>Externo</option>
                    </select>
                </div>
            </div><!-- fim Usuario interno ou externo -->
        </div>
        
        
        <div class="row">
            <!-- nome da matiz -->
            <div class="col-md-4">
                <div class="form-group">
                    <label for="tiposDeCliente">Cliente</label><br>
                    <?php $modelo->loadClienteFilial(); ?>
                </div>
            </div><!-- fim do campo nome da matiz -->
            
            <!-- permissao -->
            <div class="col-md-4">
                <div class="form-group">
                    <label for="tipoPermissao">Permiss&atilde;o</label><br>
                    <?php $modelo->loadPerfilAcesso(); ?>
                </div>
            </div><!-- fim permissao -->
        </div>
        
        
        <!-- botao de enviar -->
        <div class="row">
            <div class="col-md-2 col-md-offset-5 txt-center"><input type="submit" id="btn_salvar" name="btn_salvar" class="btn btn-info" value="Salvar"></div>
        </div><!-- fim do botao de envio -->
        
    </form><!-- fim do formulario de cadastro -->
</div>