<!-- LISTAR USUÁRIOS VIEW -->
<?php
    if (! defined('EFIPATH')) exit;
?>

<script type="text/javascript">
    // gerenciador de link
    var menu = document.getElementById('listadir');
    menu.innerHTML = '<a href="<?php echo HOME_URI; ?>/home/" class="linkMenuSup">Home</a> / <a href="<?php echo HOME_URI; ?>/home/usuario/listar">Listar usuários</a>';
</script>

<?php

    $lista = $modelo->listagemUsuario();

 ?>

<div class="row">
    <div class="col-lg-12">

        <!-- TITULO PAGINA -->
        <label class="page-header">Usuários registrados até o momento</label><!-- Fim Titulo pagina -->

        <div class="pull-right">
            <div class="btn-group">
                <a href="<?php echo HOME_URI; ?>/cadastrar/usuario/" class="btn btn-primary">
                    <i class="fa fa-plus fa-lg"> </i>Adicionar novo usuário
                </a>
            </div>
        </div>

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
                                       <a href="<?php echo HOME_URI; ?>/usuario/editarUsuario/<?php echo $usuario['id']; ?>" class="link-tabela-moni">
                                           <i class="fa fa-pencil-square-o fa-lg"></i>
                                       </a>
                                   </td>
                                   <td>
                                       <a href="<?php echo HOME_URI; ?>/usuario/removerUsuario/<?php echo $usuario['id']; ?>" class="link-tabela-moni">
                                           <i class="fa  fa-times fa-lg"></i>
                                       </a>
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
