<!-- EDITAR CLIENTES VIEW -->
<?php
    if (! defined('EFIPATH')) exit;

    /* Carrega os dados do cliente */
    $dados    = $modelo->carregarDadosCliente($this->parametros[0]);
    $contato  = $modelo->carregaDadosContato($this->parametros[0]);

    //var_dump($dados);

    /*
		  array(2) { ["status"]=> bool(true) ["dados"]=> array(2) { [0]=> array(7) { ["id"]=> string(1) "3" ["nome"]=> string(8) "Fabiano " ["sobrenome"]=> string(6) "Hatori" ["email"]=> string(27) "fabiano@eficazSystem.com.br" ["telefone"]=> string(0) "" ["celular"]=> string(1) "0" ["id_cliente"]=> string(1) "1" } [1]=> array(7) { ["id"]=> string(1) "4" ["nome"]=> string(6) "Allan " ["sobrenome"]=> string(5) "Lima " ["email"]=> string(30) "allan.lima@eficazsystem.com.br" ["telefone"]=> string(0) "" ["celular"]=> string(1) "0" ["id_cliente"]=> string(1) "1" } } }
    */

	if($dados['status']){
		$dadosCliente = $dados['dados'][0];

	}else{
	 	$dadosCliente = null;

	}

    if($contato['status']){
        $dadosContato = $contato['dados'][0];
    }else{
        $dadosContato = null;
    }

?>

<script type="text/javascript">
    // gerenciador de link
    var menu = document.getElementById('listadir');
    menu.innerHTML = '<a href="<?php echo HOME_URI; ?>/home/" class="linkMenuSup">Home</a> / <a href="<?php echo HOME_URI; ?>/cliente/" class="linkMenuSup">Listar Clientes</a> / <a href="<?php echo HOME_URI; ?>/cliente/editarCliente/<?php echo $this->parametros[0]; ?>" class="linkMenuSup">Editar Cliente</a>';
</script>


<!-- Jquery file -->
<script src="<?php echo HOME_URI; ?>/views/_js/pages/jquery.js"></script>

<div class="row">
    <div class="col-md-12">

    	<!-- TITULO PAGINA -->
       <label class="page-header">Editar cliente</label><!-- Fim Titulo pagina -->

       	<!-- Cadastra do cliente -->
       	<div class="panel-group" id="accordionContatoClie" role="tablist" aria-multiselectable="true">
            <div class="panel panel-default">
            	<div class="panel-heading" role="tab" id="headingOne">
                  <h4 class="panel-title">
                    <a role="button" data-toggle="collapse" data-parent="#accordionContatoClie" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                      <i class="fa  fa-building-o  "></i> Dados do cliente
                    </a>
                  </h4>
                </div>
            </div>

            <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                <div class="panel-body">

                	<!-- form contendo os dados do cliente -->
                    <form id="editCliete" method="post" enctype="multipart/form-data">
                    	<div class="row">
                    		 <!-- nome do cliente -->
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="cliente">Nome da empresa do cliente</label>
                              <input type="hidden" id="txt_idCliente" name="txt_idCliente" value="<?php echo $this->parametros[0]; ?>">
                              <input type="text" class="form-control" id="txt_cliente" name="txt_cliente" placeholder="Nome do cliente" maxlength="100" value="<?php echo ($dados['status']) ? $dadosCliente['nome'] : ""; ?>">
                            </div>
                          </div><!-- fim do campo nome do cliente -->
                          <!-- DDD -->
                          <div class="col-md-2">
                            <div class="form-group">
                              <label for="ddd">C&oacute;digo de &Aacute;rea</label>
                              <input type="text" class="form-control" id="txt_ddd" name="txt_ddd" placeholder="DDD (000)" maxlength="3" value="<?php echo ($dados['status']) ? $dadosCliente['ddd'] : ""; ?>">
                            </div>
                          </div><!-- fim do ddd -->
                          <!-- telefone -->
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="telefone">Telefone</label>
                              <input type="text" class="form-control" id="txt_telefone" name="txt_telefone" placeholder="Telefone" maxlength="10" value="<?php echo ($dados['status']) ? $dadosCliente['telefone'] : ""; ?>">
                            </div>
                          </div><!-- fim do telefone -->
                        </div>
                        <!-- imagem cliente -->
                        <!-- <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="imputImageImgUser">Imagem do cliente</label>
                                    <input type="file" id="imputImageImgUser" name="imputImageImgUser" />
                                </div>
                            </div>
                        </div> -->
                        <div class="row">
                          <!-- endereco do cliente -->
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="endereco">Endere&ccedil;o</label>
                              <input type="text" class="form-control" id="txt_endereco" name="txt_endereco" placeholder="Rua, Avenida e etc" maxlength="200" value="<?php echo ($dados['status']) ? $dadosCliente['endereco'] : ""; ?>">
                            </div>
                          </div><!-- fim do endereco do cliente -->

                          <!-- cep -->
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="cep">CEP</label>
                              <input type="text" class="form-control" id="txt_cep" name="txt_cep" placeholder="CEP" maxlength="9" value="<?php echo ($dados['status']) ? $dadosCliente['cep'] : ""; ?>">
                            </div>
                          </div><!-- fim do cep -->
                        </div>

                        <div class="row">
                          <!-- numero -->
                          <div class="col-md-2">
                            <div class="form-group">
                              <label for="numero">N&uacute;mero</label>
                              <input type="text" class="form-control" id="txt_numero" name="txt_numero" placeholder="N&uacute;mero" maxlength="10" value="<?php echo ($dados['status']) ? $dadosCliente['numero'] : ""; ?>">
                            </div>
                          </div><!-- fim do numero -->

                          <!-- Bairro -->
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="bairro">Bairro</label>
                              <input type="text" class="form-control" id="txt_bairro" name="txt_bairro" placeholder="Cidade" maxlength="50" value="<?php echo ($dados['status']) ? $dadosCliente['bairro'] : ""; ?>">
                            </div>
                          </div><!-- fim do campo Bairro -->

                          <!-- Cidade -->
                          <div class="col-md-5">
                            <div class="form-group">
                              <label for="cidade">Cidade</label>
                              <input type="text" class="form-control" id="txt_cidade" name="txt_cidade" placeholder="Cidade" maxlength="50" value="<?php echo ($dados['status']) ? $dadosCliente['cidade'] : ""; ?>">
                            </div>
                          </div><!-- fim do campo Cidade -->

                        </div>

                        <div class="row">

                          <!-- pais -->
                          <div class="col-md-5">
                            <div class="form-group">
                              <label for="paises">Pais</label><br>
                              <select id="paises" name="paises" class="form-control">
                              <?php
                                //$modelo->listaPaises();

                                    $paises = $modelo->listaPaisesSimples();

                                    foreach ($paises as $pais) {
                                        if($pais['id'] == $dadosCliente['idpais']){
                                            echo "<option value='".$pais['id']."' selected>".$pais['pais']."</option>";
                                        }else{
                                            echo "<option value='".$pais['id']."'>".$pais['pais']."</option>";
                                        }
                                    }

                                ?>
                                </select>
                            </div>
                          </div><!-- fim do pais -->


                          <!-- estado -->
                          <div class="col-md-5">
                            <div class="form-group">
                              <label for="estados">Estado</label><br>
                              <select id="estados" name="estados" class="form-control">
                                  <?php

                                      $estadosFili = $modelo->listaEstadosSimples();
                                      //$modelo->listaEstado(); listaEstadosSimples
                                      foreach ($estadosFili as $estado) {
                                          if($estado['id'] == $dadosCliente['idestado']){
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

                        </div>

                        <div class="row">
                          <!-- foto -->
                        <!--   <div class="col-md-4">
                            <div class="form-group">
                              <label for="foto">Logo / Foto cliente</label>
                              <input type="file" name="file_foto" id="file_foto" class="filestyle" data-icon="false">
                            </div>
                          </div> --><!-- Fim fotos -->
                        </div>

                        <div class="row">
                          <div class="col-md-4">


                          </div>
                        </div>

                        <div class="row">
                          <div class="col-md-4">
                          </div>
                          <div class="col-md-4 ">
                            <div class="form-group">
                              <button id="editarClienteExistente" type="button" name="btn_salvar" class="btn btn-info" value="Salvar">Salvar cliente</button</div>
                              <input id="resultadoCadastro" name="resultadoCadastro" type="hidden" value="<?php echo $this->parametros[0]; ?>">
                            </div>
                        </div>



                        </div>

                    </form>

                </div>
            </div>

        </div>

    </div>
</div>

<div class="row">
  <div class="col-md-12">
    <!-- TITULO PAGINA -->
    <label class="page-header">Editar contato cliente</label><!-- Fim Titulo pagina -->

    <!-- Cadastra do cliente -->
    <div class="panel-group" id="accordionContatoClie" role="tablist" aria-multiselectable="true">
      <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="headingOne">
          <h4 class="panel-title">
            <a role="button" data-toggle="collapse" data-parent="#accordionContatoClie" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
              <i class="fa  fa-user  "></i> Dados contato cliente
            </a>
          </h4>
        </div>
      </div>
      <div id="collapseTwo" class="panel-cllapse collapse in" role="tabpanel" aria-labelledby="headingTwo">
        <div class="panel-body">
          <!-- form contendo os dados do cliente -->
          <form id="editContatoCliente" method="post">
            <div class="row">
              <!-- nome do usuario -->
              <div class="col-md-4">
                <div class="form-group">
                  <label for="exampleInputEmail1">Nome do Contato</label>
                  <input type="hidden" id="txt_idUsuario" name="txt_idUsuario" value="<?php echo ($dados['status']) ? $dadosContato['id'] : ""; ?>">
                  <input type="text" class="form-control" id="txt_nome_contato" name="txt_nome_contato" placeholder="Nome do contato" maxlength="50" value="<?php echo ($dados['status']) ? $dadosContato['nome'] : ""; ?>">
                </div>
              </div><!-- fim nome do usuario -->

              <!-- sobrenome do contato -->
              <div class="col-md-4">
                <div class="form-group">
                  <label for="exampleInputEmail1">Sobrenome do contato</label>
                  <input type="text" class="form-control" id="txt_sobrenome_contato" name="txt_sobrenome_contato" placeholder="Sobrenome do contato" maxlength="90" value="<?php echo ($dados['status']) ? $dadosContato['sobrenome'] : ""; ?>">
                </div>
              </div><!-- fim sobrenome do usuario -->

              <!-- E-mail -->
              <div class="col-md-4">
                <div class="form-group">
                  <label for="exampleInputEmail1">E-mail</label>
                  <input type="email" class="form-control" id="txt_email_contato" name="txt_email_contato" placeholder="E-mail" maxlength="50" value="<?php echo ($dados['status']) ? $dadosContato['email'] : ""; ?>">
                </div>
              </div><!-- fim E-mail -->
            </div>
            <div class="row">
              <!-- Telefone -->
              <div class="col-md-4">
                <div class="form-group">
                  <label for="exampleInputEmail1">Telefone</label>
                  <input type="text" class="form-control" id="txt_telefone_contato" name="txt_telefone_contato" placeholder="Telefone contato" maxlength="50" value="<?php echo ($dados['status']) ? $dadosContato['telefone'] : ""; ?>">
                </div>
              </div><!-- fim telefone -->

              <!-- Celular -->
              <div class="col-md-4">
                <div class="form-group">
                  <label for="exampleInputEmail1">Celular</label>
                  <input type="text" class="form-control" id="txt_celular_contato" name="txt_celular_contato" placeholder="Celular contato" maxlength="50" value="<?php echo ($dados['status']) ? $dadosContato['celular'] : ""; ?>">
                </div>
              </div><!-- fim celular -->
            </div>
            <div class="row">
              <!-- senha -->
              <div class="col-md-4">
                <div class="form-group">
                  <label for="exampleInputEmail1">Senha acesso do contato</label>
                  <input type="password" class="form-control" id="txt_senha_contato" name="txt_senha_contato" placeholder="Senha" maxlength="30" required>
                  <span class="senhaPerm">Caracteres permitidos !,-,#,+,=,*</span>
                </div>
              </div><!-- fim senha -->

              <!-- confirma senha -->
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Confirma senha do contato</label>
                    <input type="password" class="form-control" id="txt_cfsenha_contato" name="txt_cfsenha_contato" placeholder="Confirma senha" maxlength="30" required>
                  </div>
                </div><!-- fim confirma senha -->

            </div>
            <div class="row">
              <div class="col-md-4">

              </div>
              <div class="col-md-4 ">
                <div class="form-group">
                  <button id="editarContatoCliente" type="button" name="btn_salvar" class="btn btn-info" value="Salvar">Salvar edição de contato</button>
                </div>
              </div>
            </div>

          </form>
        </div>
      </div>
    </div>

  </div>
</div>
