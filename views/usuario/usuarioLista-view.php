<!-- LISTAR USUÁRIOS VIEW -->
<?php
    if (! defined('EFIPATH')) exit;
?>

<script type="text/javascript">
    // gerenciador de link
    var menu = document.getElementById('listadir');
    menu.innerHTML = '<a href="<?php echo HOME_URI; ?>/home/" class="linkMenuSup">Home</a> / <a href="<?php echo HOME_URI; ?>/usuario/listar">Listar usuários</a>';
</script>

<?php

    $lista      = $modelo->listagemUsuario();
    $listaClie  = $modelo->listarClientesUsuario();
    $listaAcess = $modelo->listarAcessosUsuario();

 ?>

<div class="row">
    <div class="col-lg-12">

        <!-- TITULO PAGINA -->
        <label class="page-header">Usuários registrados até o momento</label><!-- Fim Titulo pagina -->

        <div class="pull-right">
            <div class="btn-group">
                <!-- <a href="<?php echo HOME_URI; ?>/cadastrar/usuario/" class="btn btn-primary">
                    <i class="fa fa-plus fa-lg"> </i>Adicionar novo usuário
                </a> -->
                <button id="addNovoUser" class="btn btn-primary">Adicionar novo usuário</button>
            </div>
        </div>
        <!-- TABELA CONTENDO OS USUÁRIOS CADASTRADOS -->
        <div class="panel panel-default">
            <div class="panel-heading">

            </div>
            <div class="panel-body">
                <div class='table-responsive'>
                    <table id="stream_table" class='table table-striped table-bordered'>
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Email</th>
                                <th>Data criação</th>
                                <th class="txt-center">Editar</th>
                                <th class="txt-center">Excluir</th>
                            </tr>
                        </thead>
                        <tbody>
                           <?php
                               if($lista){

                                   foreach ($lista as $usuario) {
                           ?>
                               <tr>
                                   <td><?php echo $usuario['nome']." ".$usuario['sobrenome']; ?></td>
                                   <td><?php echo $usuario['email']; ?></td>
                                   <td><?php echo implode("/", array_reverse(explode("-", $usuario['dt_criaco']))); ?></td>
                                   <td>
                                       <!-- <a href="<?php //echo HOME_URI; ?>/usuario/editarTerceiros/<?php //echo $usuario['id']; ?>" class="link-tabela-moni">
                                           <i class="fa fa-pencil-square-o fa-lg"></i>
                                       </a> -->
                                       <button class="btnEditUser btn link-tabela-moni" value="<?php echo $usuario['id']; ?>">
                                            <i class="fa fa-pencil-square-o fa-lg"></i>
                                       </button>
                                   </td>
                                   <td>
                                       <!-- <a href="<?php //echo HOME_URI; ?>/usuario/removerUsuario/<?php //echo $usuario['id']; ?>" class="link-tabela-moni">
                                           <i class="fa  fa-times fa-lg"></i>
                                       </a> -->
                                       <button class="btnRemoveUser btn link-tabela-moni" value="<?php echo $usuario['id']; ?>">
                                            <i class="fa  fa-times fa-lg"></i>
                                       </button>
                                   </td>
                               </tr>
                           <?php
                                   }
                               }else{
                           ?>
                               <tr>
                                   <td colspan="4">Nenhum usuário cadastrado até o momento</td>
                               </tr>
                           <?php
                               }
                           ?>
                        </tbody>
                    </table>
                    <div id="summary"><div></div></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODAL PARA ADIÇÃO DE NOVO USUÁRIO -->
<div id="modalCadUsuario" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel">Cadastrar Usuário</h4>
            </div>
            <div class="modal-body">
                <form id="formCadUser" method="post">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Nome do Usu&aacute;rio</label>
                                <input type="text" class="form-control" id="txt_nome" name="txt_nome" placeholder="Nome do Usu&aacute;rio" value="">
                            </div>
                        </div><!-- fim nome do usuario -->

                        <!-- sobrenome do usuario -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Sobrenome do Usu&aacute;rio</label>
                                <input type="text" class="form-control" id="txt_sobrenome" name="txt_sobrenome" placeholder="Sobrenome do Usu&aacute;rio" value="">
                            </div>
                        </div><!-- fim sobrenome do usuario -->

                        <!-- E-mail -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">E-mail</label>
                                <input type="email" class="form-control" id="txt_email" name="txt_email" placeholder="E-mail" value="">
                            </div>
                        </div><!-- fim E-mail -->

                    </div>

                    <div class="row">

                        <!-- E-mail -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Telefone</label>
                                <input type="tel" class="form-control" id="txt_telefone_usuario" name="txt_telefone_usuario" placeholder="Telefone" value="">
                            </div>
                        </div><!-- fim E-mail -->

                        <!-- E-mail -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Celular</label>
                                <input type="tel" class="form-control" id="txt_celular_usuario" name="txt_celular_usuario" placeholder="Celular" value="">
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
                    </div>

                    <div class="row">
                        <!-- nome da matiz -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="tiposDeCliente">Cliente</label><br>
                                <select id="nomeCliente" name="nomeCliente" class="form-control">
                                    <?php
                                        //$modelo->loadClienteFilial();
                                        echo "<option value=''> Selecione... </option>";
                                        foreach ($listaClie as $cliente) {
                                            echo "<option value='".$cliente['id']."'>".$cliente['nome']."</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                        </div><!-- fim do campo nome da matiz -->

                        <!-- permissao -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="tipoPermissao">Permiss&atilde;o</label><br>
                                <select id="acessoCliente" name="acessoCliente" class="form-control">
                                    <?php
                                        //$modelo->loadClienteFilial();
                                        echo "<option value=''> Selecione... </option>";
                                        foreach ($listaAcess as $acesso) {
                                            echo "<option value='".$acesso['id']."'>".$acesso['nome']."</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                        </div><!-- fim permissao -->
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="cadUsuarioBtn">Cadastrar usuário</button>
            </div>
        </div>
    </div>
</div>


<!-- MODAL PARA EDIÇÃO DE NOVO USUÁRIO -->
<div id="modalEditUsuario" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel">Editar Usuário</h4>
            </div>
            <div class="modal-body">
                <form id="formEditUser" method="post">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Nome do Usu&aacute;rio</label>
                                <input type="hidden" id="usuarioId" name="usuarioId" value="" />
                                <input type="text" class="form-control" id="txt_edit_nome" name="txt_edit_nome" placeholder="Nome do Usu&aacute;rio" value="">
                            </div>
                        </div><!-- fim nome do usuario -->

                        <!-- sobrenome do usuario -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Sobrenome do Usu&aacute;rio</label>
                                <input type="text" class="form-control" id="txt_edit_sobrenome" name="txt_edit_sobrenome" placeholder="Sobrenome do Usu&aacute;rio" value="">
                            </div>
                        </div><!-- fim sobrenome do usuario -->

                        <!-- E-mail -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">E-mail</label>
                                <input type="email" class="form-control" id="txt_edit_email" name="txt_edit_email" placeholder="E-mail" value="">
                            </div>
                        </div><!-- fim E-mail -->

                    </div>

                    <div class="row">

                        <!-- E-mail -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Telefone</label>
                                <input type="tel" class="form-control" id="txt_edit_telefone_usuario" name="txt_edit_telefone_usuario" placeholder="Telefone" value="">
                            </div>
                        </div><!-- fim E-mail -->

                        <!-- E-mail -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Celular</label>
                                <input type="tel" class="form-control" id="txt_edit_celular_usuario" name="txt_edit_celular_usuario" placeholder="Celular" value="">
                            </div>
                        </div><!-- fim E-mail -->


                    </div>

                    <div class="row">
                        <!-- senha -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Senha</label>
                                <input type="password" class="form-control" id="txt_edit_senha" name="txt_edit_senha" placeholder="Senha">
                                <span class="senhaPerm">Caracteres permitidos !,-,#,+,=,*</span>
                            </div>
                        </div><!-- fim senha -->

                        <!-- confirma senha -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Confirma senha</label>
                                <input type="password" class="form-control" id="txt_edit_cfsenha" name="txt_edit_cfsenha" placeholder="Confirma senha">
                            </div>
                        </div><!-- fim confirma senha -->
                    </div>

                    <div class="row">
                        <!-- nome da matiz -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="tiposDeCliente">Cliente</label><br>
                                <select id="nomeClienteEdit" name="nomeClienteEdit" class="form-control">
                                    <?php
                                        //$modelo->loadClienteFilial();
                                        foreach ($listaClie as $cliente) {
                                            echo "<option value='".$cliente['id']."'>".$cliente['nome']."</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                        </div><!-- fim do campo nome da matiz -->

                        <!-- permissao -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="tipoPermissao">Permiss&atilde;o</label><br>
                                <select id="acessoUsuarioEdit" name="acessoUsuarioEdit" class="form-control">
                                    <?php
                                        //$modelo->loadClienteFilial();
                                        foreach ($listaAcess as $acesso) {
                                            echo "<option value='".$acesso['id']."'>".$acesso['nome']."</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                        </div><!-- fim permissao -->
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="editUsuarioBtn">Atualizar usuário</button>
            </div>
        </div>
    </div>
</div>
