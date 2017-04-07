<?php

    if (! defined('EFIPATH')) exit;

    //CARREGAR LISTA DE CHIPS EXISTEM

    $listaChipSim   = $modelo->listaChipsSimAtivos();
    $listaClientes  = $modeloClie->listarCliente();

    //var_dump($listaClientes);

?>

<script type="text/javascript">
    // gerenciador de link
    var menu = document.getElementById('listadir');
    menu.innerHTML = '<a href="<?php echo HOME_URI; ?>/home/" class="linkMenuSup">Home</a> / <a href="<?php echo HOME_URI; ?>/equipamento/gerenciarChips">Listar chips SIM</a> ';
</script>

<div class="row">
    <div class="col-lg-12">
        <!-- TITULO PAGINA -->
        <label class="page-header">Lista de chip SIM </label><!-- Fim Titulo pagina -->
    </div>
</div>

<div class="row">
	<div class="col-lg-12">

        <!-- TABELA CONTENDO OS USUÁRIOS CADASTRADOS -->
        <div class="panel panel-default">
            <div class="panel-heading">

                <!-- formulario de cadastro -->
                <form id="filtroChips" method="post">

                    <div class="row">
                        <div class="col-md-3 form-group">
                            <p>
                                Status : <select id="filtroStatusChip" class="form-control">
                                            <option value=" ">Selecione</option>
                                            <option value="0">Ativo</option>
                                            <option value="1">Desativado</option>
                                            <option value="2">Alocado cliente</option>
                                            <option value="3">Não alocado cliente</option>
                                        </select>
                            </p>
                        </div>
                        <div class="col-md-3 form-group">
                            <p>
                                Cliente : <select id="filtroClienteChip" name="filtroClienteChip" class="form-control">
                                            <option value=" ">Selecione</option>
                                    <?php

                                        if($listaClientes){

                                            foreach ($listaClientes as $cliente) {

                                                ?>
                                                    <option value="<?php echo $cliente['id'] ?>"><?php echo $cliente['nome'] ?></option>
                                                <?php

                                            }

                                        }

                                     ?>
                                </select>
                            </p>
                        </div>

                    </div>

                </form>

            </div>
            <div class="panel-body">
                <div class='table-responsive'>
                    <table id="stream_table" class='table table-striped table-bordered'>
                        <thead>
                            <tr>
                                <th>Número SIM</th>
                                <th>Cliente Atual</th>
                                <th>Filial Atual</th>
                                <th>Versão projeto</th>
                                <th>Modelo chip</th>
                                <th>Data teste</th>
                                <th>Data instalação</th>
                                <th>Data desativação</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="8">
                                    Selecione o filtro desejado
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
