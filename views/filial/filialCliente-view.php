<!-- LISTAR FILIAIS DO CLIENTE VIEW -->
<?php
    if (! defined('EFIPATH')) exit;

    /* Carrega os dados do cliente */
    $dados    = $modelo->carregarDadosCliente($this->parametros[0]);
    $filiais  = $modelo->carregarFiliaisCliente($this->parametros[0]);

    if($dados['status']){
		$dadosCliente = $dados['dados'][0];
    	$dadosFiliais = $filiais['filiais'];
	}else{
	 	$dadosCliente = null;
    	$dadosFiliais = null;
	}

	//var_dump($dadosFiliais);

?>

<script type="text/javascript">
    // gerenciador de link
    var menu = document.getElementById('listadir');
    menu.innerHTML = '<a href="<?php echo HOME_URI; ?>/home/" class="linkMenuSup">Home</a> / <a href="<?php echo HOME_URI; ?>/cliente">Listar cliente</a> / <a href="<?php echo HOME_URI; ?>/cliente/listarFiliaisCliente/<?php echo $this->parametros[0]; ?>">Filiais do cliente : <?php echo $dadosCliente['nome']; ?></a>';
</script>

<div class="row">
    <div class="col-lg-12">
        <!-- TITULO PAGINA -->
        <label class="page-header">Filiais registrados até o momento para o cliente : <?php echo $dadosCliente['nome']; ?></label><!-- Fim Titulo pagina -->

    </div>
</div>

<div class="row">
    <div class="col-lg-4">
        <button id="btnAddFilial" class="btn btn-primary"><i class="fa fa-plus fa-lg"></i>Adicionar nova filial</button>
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
                                if($dadosFiliais != '')
                                {

                                    foreach ($dadosFiliais as $filia){
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

<!-- MODAL PARA ADIÇÃO DE NOVA FILIAL -->
<div id="modalCadFilial" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">Cadastrar Filial</h4>
        </div>
        <div class="modal-body">
            <form id="formCadFilial" method="post">

                <input type="hidden" id="idMatriz" value="" />

                <div class="row">
                    <!-- nome da filial -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Nome da Filial</label>
                            <input type="text" class="form-control" id="txt_filial" name="txt_filial" placeholder="Nome da Filial" maxlength="100" required value="">
                        </div>
                    </div><!-- fim do campo nome da filial -->

                </div>

                <div class="row">
                    <!-- DDD -->
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="exampleInputEmail1">C&oacute;digo de &Aacute;rea</label>
                            <input type="text" class="form-control" id="txt_ddd" name="txt_ddd" placeholder="DDD (000)" maxlength="3" onkeypress="" value="">
                        </div>
                    </div><!-- fim do ddd -->

                    <!-- telefone -->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Telefone</label>
                            <input type="text" class="form-control" id="txt_telefone" name="txt_telefone" placeholder="Telefone" maxlength="9" onkeypress="" value="">
                        </div>
                    </div><!-- fim do telefone -->

                </div>

                <div class="row">

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="exampleInputEmail1">CEP</label>
                            <input type="text" class="form-control" id="txt_cep" name="txt_cep" placeholder="CEP" maxlength="9" required onkeypress="" value="">
                        </div>
                    </div><!-- fim do cep -->

                    <!-- endereco do cliente -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Endere&ccedil;o</label>
                            <input type="text" class="form-control" id="txt_endereco" name="txt_endereco" placeholder="Rua, Avenida e etc" maxlength="200" required value="">
                        </div>
                    </div><!-- fim do endereco do cliente -->

                    <!-- numero -->
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="exampleInputEmail1">N&uacute;mero</label>
                            <input type="text" class="form-control" id="txt_numero" name="txt_numero" placeholder="N&uacute;mero" maxlength="10" onkeypress="" value="">
                        </div>
                    </div><!-- fim do numero -->
                </div>

                <div class="row">
                    <!-- Cidade -->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Cidade</label>
                            <input type="text" class="form-control" id="txt_cidade" name="txt_cidade" placeholder="Cidade" maxlength="50" required value="">
                        </div>
                    </div><!-- fim do campo Cidade -->

                    <!-- Bairro -->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Bairro</label>
                            <input type="text" class="form-control" id="txt_bairro" name="txt_bairro" placeholder="Cidade" maxlength="50" required value="">
                        </div>
                    </div><!-- fim do campo Bairro -->

                    <!-- estado -->
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Estado</label><br>
                                <select id="estados" name="estados" class="form-control">
                                    <?php

                                        $estados = $modelo->listaEstadosSimples();
                                        //$modelo->listaEstado(); listaEstadosSimples
                                        foreach ($estados as $estado) {
                                            if($estado['id'] == 16){
                                                echo "<option value='".$estado['id']."' selected>".$estado['nome']."</option>";
                                            }else{
                                                echo "<option value='".$estado['id']."'>".$estado['nome']."</option>";
                                            }
                                        }
                                        echo "<option value='999'>Estado ou condado fora do país</option>";
                                    ?>
                                </select>
                        </div>
                    </div><!-- fim do estado -->

                    <!-- pais -->
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="pais">Pais</label><br>
                            <select id="pais" name="pais" class="form-control">
                                <?php
                                    //$modelo->listaPaises();
                                    $paises = $modelo->listaPaisesSimples();

                                    foreach ($paises as $pais) {
                                        if($pais['id'] == 36){
                                            echo "<option value='".$pais['id']."' selected>".$pais['pais']."</option>";
                                        }else{
                                            echo "<option value='".$pais['id']."'>".$pais['pais']."</option>";
                                        }
                                    }

                                ?>

                            </select>

                        </div>
                    </div><!-- fim do pais -->

                </div>

            </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
          <button type="button" class="btn btn-primary">Cadastrar filial</button>
        </div>
      </div>
  </div>
</div>
