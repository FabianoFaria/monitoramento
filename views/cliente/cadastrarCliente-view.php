<!-- CADASTRAR CLIENTES VIEW -->
<?php
    if (! defined('EFIPATH')) exit;

    /* insere o modulo de gravacao */
    $modelo->cadastrarCliente();

?>

<script type="text/javascript">
    // gerenciador de link
    var menu = document.getElementById('listadir');
    menu.innerHTML = '<a href="<?php echo HOME_URI; ?>/home/" class="linkMenuSup">Home</a> / <a href="<?php echo HOME_URI; ?>/cadastrar/" class="linkMenuSup">Cadastrar</a> / <a href="<?php echo HOME_URI; ?>/cadastrar/cliente/" class="linkMenuSup">Cliente</a>';
</script>

<!-- Jquery file -->
<script src="<?php echo HOME_URI; ?>/views/_js/pages/jquery.js"></script>

<div class="row">
    <div class="col-md-12">
        <!-- Cadastra o contato com o cliente -->
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
                                      <label for="cliente">Nome do cliente</label>
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
                                <!-- cep -->
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="cep">CEP</label>
                                        <input type="text" class="form-control" id="txt_cep" name="txt_cep" placeholder="CEP" maxlength="9" >
                                    </div>
                                </div><!-- fim do cep -->

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
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="cidade">Cidade</label>
                                        <input type="text" class="form-control" id="txt_cidade" name="txt_cidade" placeholder="Cidade" maxlength="50" required>
                                    </div>
                                </div><!-- fim do campo Cidade -->


                            </div>

                            <div class="row">

                                <!-- pais -->
                                <div class="col-md-3 push-right">
                                    <div class="form-group">
                                        <label for="pais">Pais</label><br>
                                        <?php $modelo->listaPaises(); ?>
                                    </div>
                                </div><!-- fim do pais -->


                                <!-- estado -->
                                <div class="col-md-3 push-right">
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
                                <div class="col-md-4 ">
                                    <div class="form-group">
                                        <div class=" txt-center"><input type="submit" name="btn_salvar" class="btn btn-info" value="Salvar"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">


                                </div>
                            </div>
                      </form>

                  </div>
                </div>
            </div>
        </div>

        <!-- Cadastra os dados de determinado cliente -->
        <div class="panel-group" id="accordionCliente" role="tablist" aria-multiselectable="true">
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingTwo">
                  <h4 class="panel-title">
                    <a role="button" data-toggle="collapse" data-parent="#accordionContatoClie" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                      <i class="fa  fa-user "></i> Dados do contato do cliente
                    </a>
                  </h4>
                </div>
                <div id="collapseTwo" class="panel-cllapse collapse in" role="tabpanel" aria-labelledby="headingTwo">
                    <div class="panel-body">

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
                      Teste Cadastro de dados do cliente
                    </a>
                  </h4>
                </div>
                <div id="collapseThree" class="panel-cllapse collapse in" role="tabpanel" aria-labelledby="headingThree">
                    <div class="panel-body">
                      Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
