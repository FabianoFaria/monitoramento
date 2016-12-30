<!-- LISTAR CLIENTES VIEW -->
<?php
    if (! defined('EFIPATH')) exit;
?>

<script type="text/javascript">
    // gerenciador de link
    var menu = document.getElementById('listadir');
    menu.innerHTML = '<a href="<?php echo HOME_URI; ?>/home/" class="linkMenuSup">Home</a> / <a href="<?php echo HOME_URI; ?>/cliente">Listar clientes</a>';
</script>

<?php

    $lista = $clienteModelo->listarCliente();

 ?>

 <div class="row">
     <div class="col-lg-12">
         <!-- TITULO PAGINA -->
         <label class="page-header">Clientes registrados até o momento</label><!-- Fim Titulo pagina -->

     </div>

 </div>
 <div class="row">
     <div class="col-md-4">

        <div class="btn-group">
            <a href="<?php echo HOME_URI; ?>/cliente/cadastrar/" class="btn btn-primary">
                <i class="fa fa-plus fa-lg"> </i> Adicionar novo cliente
            </a>
        </div>

     </div>
 </div>

 <div class="row">
    <div class="col-lg-12">

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
                                <th>Cidade</th>
                                <th>Telefone</th>
                                <th class="txt-center">Editar</th>
                                <th class="txt-center">Filiais</th>
                                <th class="txt-center">Excluir</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                if($lista)
                                {
                                    foreach ($lista as $cliente){
                                ?>
                                    <tr>
                                        <td><?php echo $cliente['nome']; ?></td>
                                        <td><?php echo $cliente['cidade']; ?></td>
                                        <td><?php echo "(".$cliente['ddd'].") ".$cliente['telefone']; ?></td>
                                        <td>
                                            <a href="<?php echo HOME_URI; ?>/cliente/editarCliente/<?php echo $cliente['id']; ?>" class="link-tabela-moni">
                                                <i class="fa fa-pencil-square-o fa-lg"></i>
                                            </a>
                                        </td>
                                        <td>
                                            <a href="<?php echo HOME_URI; ?>/cliente/listarFiliaisCliente/<?php echo $cliente['id']; ?>" class="link-tabela-moni">
                                                <i class="fa fa-sitemap  fa-lg"></i>
                                            </a>
                                        </td>
                                        <td>
                                            <a href="<?php echo HOME_URI; ?>/cliente/removerCliente/<?php echo $cliente['id']; ?>" class="link-tabela-moni">
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
                                        <td colspan="4">Nenhum cliente cadastrado até o momento</td>
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
