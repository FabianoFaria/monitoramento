<!-- LISTAR FILIAIS VIEW -->
<?php
    if (! defined('EFIPATH')) exit;
?>

<script type="text/javascript">
    // gerenciador de link
    var menu = document.getElementById('listadir');
    menu.innerHTML = '<a href="<?php echo HOME_URI; ?>/home/" class="linkMenuSup">Home</a> / <a href="<?php echo HOME_URI; ?>/filial">Listar filiais</a>';
</script>

<?php

    $lista = $modeloFilial->listarFiliais();

 ?>

 <div class="row">
    <div class="col-lg-12">
        <!-- TITULO PAGINA -->
        <label class="page-header">Filiais registrados até o momento</label><!-- Fim Titulo pagina -->

        <div class="pull-right">
            <div class="btn-group">
                <a href="<?php echo HOME_URI; ?>/cadastrar/filial/" class="btn btn-primary">
                    <i class="fa fa-plus fa-lg"> </i>Adicionar nova filial
                </a>
            </div>
        </div>

        <!-- TABELA CONTENDO TODOS OS CLIENTES -->
        <div class="panel panel-default">
            <div class="panel-heading">
            </div>

            <div class="panel-body">
                <div class='table-responsive'>
                    <table id="stream_table" class='table table-striped table-bordered'>
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Matriz</th>
                                <th>Endereço</th>
                                <th>Telefone</th>
                                <th>Cidade</th>
                                <th>Estado</th>
                                <th>País</th>
                                <th class="txt-center">Editar</th>
                                <th class="txt-center">Excluir</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                if($lista)
                                {
                                    foreach ($lista as $filia){
                                ?>
                                    <tr>
                                        <td><?php echo $filia['nome']; ?></td>
                                        <td><?php echo $filia['matriz']; ?></td>
                                        <td><?php echo $filia['endereco']; ?></td>
                                        <td><?php echo "(".$filia['ddd'].") ".$filia['telefone']; ?></td>
                                        <td><?php echo $filia['cidade']; ?></td>
                                        <td><?php echo $filia['estado']; ?></td>
                                        <td><?php echo $filia['pais']; ?></td>
                                        <td>
                                            <a href="<?php echo HOME_URI; ?>/editar/editarFilial/<?php echo $filia['id']; ?>" class="link-tabela-moni">
                                                <i class="fa fa-pencil-square-o fa-lg"></i>
                                            </a>
                                        </td>
                                        <td>
                                            <a href="<?php echo HOME_URI; ?>/cliente/removerCliente/<?php echo $filia['id']; ?>" class="link-tabela-moni">
                                                <i class="fa  fa-times fa-lg"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php
                                    }
                                }
                                else{
                                ?>
                                    <tr>
                                        <td colspan="9">Nenhuma filial cadastrado até o momento</td>
                                    </tr>
                                <?php
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

    </div>
</div>
