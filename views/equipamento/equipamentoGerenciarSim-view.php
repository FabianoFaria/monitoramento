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
                                <th>Data teste</th>
                                <th>Data instalação</th>
                                <th>Data desativação</th>
                                <th>Editar chip</th>
                                <th>Desativar chip</th>
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


<!-- MODAL PARA EDIÇÃO DE CHIP SIM -->
<div id="modalEditChip" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel">Editar dados do SIM</h4>
            </div>
            <div class="modal-body">
                <form id="formEditChip" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Número do SIM</label>
                                <input type="hidden" id="chipId" name="chipId" value="" />
                                <input type="text" class="form-control" id="txt_chip_number" name="txt_chip_number" placeholder="Número Chip" value="" readonly>
                            </div>
                        </div><!-- fim nome do usuario -->

                        <!-- sobrenome do usuario -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Cliente</label>
                                <!-- <input type="text" class="form-control" id="txt_edit_sobrenome" name="txt_edit_sobrenome" placeholder="Sobrenome do Usu&aacute;rio" value=""> -->
                                <?php

                                    //var_dump($listaClientes);

                                    /*
                                    0 =>
                                        array (size=7)
                                          'id' => string '1' (length=1)
                                          'nome' => string 'Eficaz System' (length=13)
                                          'cidade' => string 'São José dos Pinhais' (length=22)
                                          'ddd' => string '41' (length=2)
                                          'telefone' => string '31551706' (length=8)
                                          'status_ativo' => string '1' (length=1)
                                          'dt_criacao' => string '2015-08-07 15:23:09' (length=19)

                                    */

                                ?>

                                <select class="form-control" id="text_cliente" name="text_cliente" disabled="disabled">
                                    <?php
                                        foreach ($listaClientes as $cliente) {
                                            ?>
                                                <option value="<?php echo $cliente['id']; ?>"><?php echo $cliente['nome']; ?></option>
                                            <?php
                                        }
                                    ?>
                                </select>
                            </div>
                        </div><!-- fim sobrenome do usuario -->

                        <!-- Filial -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Filial</label>
                                <!-- <input type="email" class="form-control" id="txt_edit_email" name="txt_edit_email" placeholder="E-mail" value=""> -->
                                <select class="form-control" id="text_filial" name="text_filial" disabled="disabled">

                                </select>
                            </div>
                        </div><!-- fim Filial -->

                    </div>

                    <div class="row">

                        <!-- E-mail -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Telefone</label>
                                <input type="tel" class="form-control" id="txt_edit_telefone_chip" name="txt_edit_telefone_chip" placeholder="Telefone" value="">
                            </div>
                        </div><!-- fim E-mail -->

                        <!-- modelo -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Modelo VM/VD</label>
                                <input type="text" class="form-control" id="txt_modelo_chip" name="txt_modelo_chip" placeholder="Verde ou vermelho" value="">
                            </div>
                        </div><!-- fim modelo -->

                        <!-- versão projeto -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Versão Projeto</label>
                                <input type="text" class="form-control" id="txt_versao_projeto" name="txt_versao_projeto" placeholder="Versão do projeto">

                            </div>
                        </div><!-- fim versão projeto -->

                    </div>

                    <div class="row">

                        <!-- data teste -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Data teste</label>
                                <input type="text" class="form-control" id="txt_data_teste" name="txt_data_teste" placeholder="Data teste">
                            </div>
                        </div><!-- fim data teste -->

                        <!-- data instalação -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Data instalação</label>
                                <input type="text" class="form-control" id="txt_data_instalacao" name="txt_data_instalacao" placeholder="Data Instalação" disabled="disabled">
                            </div>
                        </div><!-- fim data instalação -->

                        <!-- data desativação -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Data desativação</label>
                                <input type="text" class="form-control" id="txt_data_desativacao" name="txt_data_desativacao" placeholder="Data desativação" disabled="disabled">
                            </div>
                        </div><!-- fim data desativação -->

                    </div>

                    <div class="row">
                        <!-- nome da matiz -->
                        <div class="col-md-4">

                        </div><!-- fim do campo nome da matiz -->

                        <!-- permissao -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="tipoPermissao">SIM Ativado</label><br>
                                <input type="checkbox" id="simAtivado" name="simAtivado" disabled="disabled">
                            </div>
                        </div><!-- fim permissao -->

                        <!-- permissao -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="tipoPermissao">SIM instalado</label><br>
                                <input type="checkbox" id="simInstalado" name="simInstalado" disabled="disabled">
                            </div>
                        </div><!-- fim permissao -->
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="editarDadosSimBtn">Atualizar chip SIM</button>
            </div>
        </div>
    </div>
</div>
