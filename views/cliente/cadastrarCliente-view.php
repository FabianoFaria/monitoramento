<!-- CADASTRAR CLIENTES VIEW -->
<?php
    if (! defined('EFIPATH')) exit;

    /* insere o modulo de gravacao */
    $modelo->cadastrarCliente();

?>

<script type="text/javascript">
    // gerenciador de link
    var menu = document.getElementById('listadir');
    menu.innerHTML = '<a href="<?php echo HOME_URI; ?>/home/" class="linkMenuSup">Home</a> / <a href="<?php echo HOME_URI; ?>/cliente/" class="linkMenuSup">Listar Clientes</a> / <a href="<?php echo HOME_URI; ?>/cliente/cadastrar/" class="linkMenuSup">Cadastrar Cliente</a>';
</script>

<!-- Jquery file -->
<script src="<?php echo HOME_URI; ?>/views/_js/pages/jquery.js"></script>

<div class="row">
    <div class="col-md-12">

        <!-- TITULO PAGINA --><!-- TITULO PAGINA -->
       <label class="page-header">Cadastro de novo cliente</label><!-- Fim Titulo pagina -->

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
                <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                  <div class="panel-body">

                      <!-- form contendo os dados do cliente -->
                      <form id="cadCliete" method="post">

                          <div class="row">
                              <!-- nome do cliente -->
                              <div class="col-md-4">
                                  <div class="form-group">
                                      <label for="cliente">Nome da empresa do cliente</label>
                                      <input type="text" class="form-control" id="txt_cliente" name="txt_cliente" placeholder="Nome do cliente" maxlength="100">
                                  </div>
                              </div><!-- fim do campo nome do cliente -->


                              <!-- DDD -->
                              <div class="col-md-2">
                                  <div class="form-group">
                                      <label for="ddd">C&oacute;digo de &Aacute;rea</label>
                                      <input type="text" class="form-control" id="txt_ddd" name="txt_ddd" placeholder="DDD (000)" maxlength="3" onkeypress="return onlyNumber(event);">
                                  </div>
                              </div><!-- fim do ddd -->
                              <!-- telefone -->
                              <div class="col-md-4">
                                  <div class="form-group">
                                      <label for="telefone">Telefone</label>
                                      <input type="text" class="form-control" id="txt_telefone" name="txt_telefone" placeholder="Telefone" maxlength="10" onkeypress="return onlyNumber(event);">
                                  </div>
                              </div><!-- fim do telefone -->
                            </div>
                            <div class="row">
                                <!-- endereco do cliente -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="endereco">Endere&ccedil;o</label>
                                        <input type="text" class="form-control" id="txt_endereco" name="txt_endereco" placeholder="Rua, Avenida e etc" maxlength="200" required>
                                    </div>
                                </div><!-- fim do endereco do cliente -->

                                <!-- cep -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="cep">CEP</label>
                                        <input type="text" class="form-control" id="txt_cep" name="txt_cep" placeholder="CEP" maxlength="9" >
                                    </div>
                                </div><!-- fim do cep -->
                            </div>
                            <div class="row">

                                <!-- numero -->
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="numero">N&uacute;mero</label>
                                        <input type="text" class="form-control" id="txt_numero" name="txt_numero" placeholder="N&uacute;mero" maxlength="10">
                                    </div>
                                </div><!-- fim do numero -->

                                <!-- Bairro -->
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="bairro">Bairro</label>
                                        <input type="text" class="form-control" id="txt_bairro" name="txt_bairro" placeholder="Cidade" maxlength="50" required>
                                    </div>
                                </div><!-- fim do campo Bairro -->

                                <!-- Cidade -->
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="cidade">Cidade</label>
                                        <input type="text" class="form-control" id="txt_cidade" name="txt_cidade" placeholder="Cidade" maxlength="50" required>
                                    </div>
                                </div><!-- fim do campo Cidade -->


                            </div>

                            <div class="row">

                                <!-- pais -->
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="pais">Pais</label><br>
                                        <?php $modelo->listaPaises(); ?>
                                    </div>
                                </div><!-- fim do pais -->


                                <!-- estado -->
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="estado">Estado</label><br>
                                        <?php $modelo->listaEstado(); ?>
                                    </div>
                                </div><!-- fim do estado -->

                            </div>

                            <div class="row">
                                <!-- foto -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="foto">Logo / Foto cliente</label>
                                        <input type="file" name="file_foto" id="file_foto" class="filestyle" data-icon="false">
                                    </div>
                                </div><!-- Fim fotos -->
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
                                        <div class=" txt-center"><button id="validarResponsavel" type="button" name="btn_salvar" class="btn btn-info" value="Salvar">Salvar cliente</button</div>
                                        <input id="resultadoCadastro" name="resultadoCadastro" type="hidden" value="">
                                    </div>
                                </div>
                            </div>

                      </form>

                  </div>
                </div>
            </div>
        </div>

        <!-- Cadastra os dados de contato do cliente -->
        <div class="panel-group" id="accordionCliente" role="tablist" aria-multiselectable="true">
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingTwo">
                  <h4 class="panel-title">
                    <a role="button" data-toggle="collapse" data-parent="#accordionContatoClie" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                      <i class="fa  fa-user "></i> Dados para contato com o cliente
                    </a>
                  </h4>
                </div>
                <div id="collapseTwo" class="panel-cllapse collapse in" role="tabpanel" aria-labelledby="headingTwo">
                    <div class="panel-body">
                        <!-- form contendo os dados do cliente -->
                        <form id="cadContatoCliente" method="post">
                            <div class="row">
                                <!-- nome do usuario -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Nome do Contato</label>
                                        <input type="text" class="form-control" id="txt_nome_contato" name="txt_nome_contato" placeholder="Nome do contato" maxlength="50" required
                                        value="">
                                    </div>
                                </div><!-- fim nome do usuario -->

                                <!-- sobrenome do contato -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Sobrenome do contato</label>
                                        <input type="text" class="form-control" id="txt_sobrenome_contato" name="txt_sobrenome_contato" placeholder="Sobrenome do contato" maxlength="90" required
                                        value="">
                                    </div>
                                </div><!-- fim sobrenome do usuario -->

                                <!-- E-mail -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">E-mail</label>
                                        <input type="email" class="form-control" id="txt_email_contato" name="txt_email_contato" placeholder="E-mail" maxlength="50" required
                                        value="">
                                    </div>
                                </div><!-- fim E-mail -->
                            </div>

                            <div class="row">
                                <!-- Telefone -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Telefone</label>
                                        <input type="text" class="form-control" id="txt_telefone_contato" name="txt_telefone_contato" placeholder="Telefone contato" maxlength="50" required
                                        value="">
                                    </div>
                                </div><!-- fim telefone -->

                                <!-- Celular -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Celular</label>
                                        <input type="text" class="form-control" id="txt_celular_contato" name="txt_celular_contato" placeholder="Celular contato" maxlength="50" required
                                        value="">
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
                                        <div class=" txt-center"><button id="validarContatoCliente" type="button" name="btn_salvar" class="btn btn-info" value="Salvar">Salvar dados contato</button</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cadastra as filiais do cliente se existir -->
        <div class="panel-group" id="accordionFiliais" role="tablist" aria-multiselectable="true">
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingThree">
                  <h4 class="panel-title">
                    <a role="button" data-toggle="collapse" data-parent="#accordionFiliais" href="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
                      <i class="fa fa-sitemap"></i>Filiais do cliente
                    </a>
                  </h4>
                </div>
                <div id="collapseThree" class="panel-cllapse collapse in" role="tabpanel" aria-labelledby="headingThree">
                    <div class="panel-body">
                        <!-- Contem botão para adicionar novos formularios de filiais! -->
                        <div class="row">
                            <div class="col-md-4">

                            </div>
                            <div class="col-md-4">
                                <p class="page-header">
                                    <input id="temFiliais" type="checkbox" name="temFiliais" value="filiais"> Cliente possue filiais?<br>
                                </p>
                                <input type="hidden" id="countFiliais" name="countFiliais" value="1" style="display:none">
                            </div>
                        </div>

                        <!-- Trecho de template para filiais adicionais -->
                        <div class="row">
                            <div class="templateHtml" style="display:none;">
                                <div class="filiais col-md-12">
                                    <!-- Titulo da filial -->
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h3 class="page-header">Nova filial</h3>
                                        </div>
                                    </div>
                                    <!-- Primeiro linha de inputs -->
                                    <div class="row">
                                        <!-- nome da filial -->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Nome da Filial</label>
                                                <input type="text" class="form-control"  name="txt_filial" placeholder="Nome da Filial" maxlength="100" required value="">
                                            </div>
                                        </div><!-- fim do campo nome da filial -->

                                        <!-- DDD -->
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">C&oacute;digo de &Aacute;rea</label>
                                                <input type="text" class="form-control"  name="txt_ddd" placeholder="DDD (000)" maxlength="3" onkeypress="" value="">
                                            </div>
                                        </div><!-- fim do ddd -->

                                        <!-- telefone -->
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Telefone</label>
                                                <input type="text" class="form-control" name="txt_telefone" placeholder="Telefone" maxlength="9" onkeypress="" value="">
                                            </div>
                                        </div><!-- fim do telefone -->
                                    </div>

                                    <!-- Segunda linha de output -->
                                    <div class="row">
                                        <!-- CEP da filial -->
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">CEP</label>
                                                <input type="text" class="form-control" name="txt_cep" placeholder="CEP" maxlength="9" required onkeypress="" value="">
                                            </div>
                                        </div><!-- fim do cep -->
                                        <!-- endereco do cliente -->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Endere&ccedil;o</label>
                                                <input type="text" class="form-control" name="txt_endereco" placeholder="Rua, Avenida e etc" maxlength="200" required value="">
                                            </div>
                                        </div><!-- fim do endereco do cliente -->

                                        <!-- numero -->
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">N&uacute;mero</label>
                                                <input type="text" class="form-control" name="txt_numero" placeholder="N&uacute;mero" maxlength="10" onkeypress="" value="">
                                            </div>
                                        </div><!-- fim do numero -->
                                    </div>

                                    <div class="row">
                                        <!-- Bairro -->
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Bairro</label>
                                                <input type="text" class="form-control" name="txt_bairro" placeholder="Cidade" maxlength="50" required value="">
                                            </div>
                                        </div><!-- fim do campo Bairro -->

                                        <!-- Cidade -->
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Cidade</label>
                                                <input type="text" class="form-control" name="txt_cidade" placeholder="Cidade" maxlength="50" required value="">
                                            </div>
                                        </div><!-- fim do campo Cidade -->

                                        <!-- estado -->
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Estado</label><br>
                                                <?php $modelo->listaEstado(); ?>
                                            </div>
                                        </div><!-- fim do estado -->
                                    </div>


                                </div>
                            </div>
                        </div>
                        <!-- Fim do trecho de amostra para filiais adicionais -->


                        <div id="listaFiliais" class="row" style="display:none">
                            <div class="filiais col-md-12">

                                <div class="row">
                                    <div class="col-md-4">

                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class=" txt-center"><button id="adicionarNovaFilial" type="button" name="btn_adicionar" class="btn btn-info" value="Adicionar filial">Adicionar nova filial</button></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">

                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class=" txt-center"><button id="concluirCadastro" type="button" name="btn_concluirCadastro" class="btn btn-success" value="Concluir cadastro">Concluir cadastro de cliente</button</div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">

                            </div>
                            <div class="col-md-4">
                                <div id="resultadoPositivo" class="panel panel-green" style="display:none;">
                                    <div class="panel-heading">
                                        Cadastro concluido
                                    </div>
                                    <div class="panel-body">
                                        <p>
                                            Cadastro de cliente foi concluido com susceso! Você será redirecionando em breve.
                                        </p>
                                    </div>
                                    <div class="panel-footer">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
