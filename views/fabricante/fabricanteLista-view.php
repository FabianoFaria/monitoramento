<!-- LISTAR FABRICANTES VIEW -->
<?php
    if (! defined('EFIPATH')) exit;
?>

<script type="text/javascript">
    // gerenciador de link
    var menu = document.getElementById('listadir');
    menu.innerHTML = '<a href="<?php echo HOME_URI; ?>/home/" class="linkMenuSup">Home</a> / <a href="<?php echo HOME_URI; ?>/fabricante">Listar fabricante</a>';
</script>

<?php

    $lista = $modelo->listarFabricantes();

 ?>

 <div class="row">
    <div class="col-lg-12">

        <!-- TITULO PAGINA -->
        <label class="page-header">Fabricantes registrados até o momento</label><!-- Fim Titulo pagina -->

        <div class="pull-right">
            <div class="btn-group">
                <a href="<?php echo HOME_URI; ?>/fabricante/cadastrar/" class="btn btn-primary">
                    <i class="fa fa-plus fa-lg"> </i>Adicionar novo fabricante
                </a>
            </div>
        </div>

        <!-- TABELA CONTENDO OS CLIENTES CADASTRADOS -->
        <div class="panel panel-default">
            <div class="panel-heading">
            </div>
            <div class="panel-body">
                <div class='table-responsive'>
                    <table id="stream_table" class='table table-striped table-bordered'>
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Telefone</th>
                                <th>Endereço</th>
                                <th>Cidade</th>
                                <th>Estado</th>
                                <th>País</th>
                                <th class="txt-center">Editar</th>
                                <th class="txt-center">Excluir</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                                if($lista){

                                    foreach ($lista as $fabricante) {
                            ?>
                                <tr>
                                    <td><?php echo $fabricante['nome']; ?></td>
                                    <?php
                                        if($fabricante['telefone'] == "0"){
                                    ?>
                                        <td></td>
                                    <?php
                                        }else{
                                    ?>
                                        <td><?php echo "(".$fabricante['ddd'].") ".$fabricante['telefone']; ?></td>
                                    <?php
                                        }
                                    ?>

                                    <td><?php echo $fabricante['endereco']; ?></td>
                                    <td><?php echo $fabricante['cidade']; ?></td>
                                    <td><?php echo $fabricante['estado']; ?></td>
                                    <td><?php echo $fabricante['pais']; ?></td>
                                    <td>
                                        <a href="<?php echo HOME_URI; ?>/editar/editarFabricante/<?php echo $fabricante['id']; ?>" class="link-tabela-moni">
                                            <i class="fa fa-pencil-square-o fa-lg"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="<?php echo HOME_URI; ?>/editar/removerUsuario/<?php echo $fabricante['id']; ?>" class="link-tabela-moni">
                                            <i class="fa  fa-times fa-lg"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php
                                    }
                                }else{
                            ?>
                                <tr>
                                    <td colspan="8">Nenhum fabricante cadastrado até o momento</td>
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
