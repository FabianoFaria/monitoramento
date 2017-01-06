<!-- GERENCIAR ALERTAS CLIENTE VIEW -->
<?php
    if (! defined('EFIPATH')) exit;

    $filiaisCliente     = $modelo->carregarFiliaisCliente($this->parametros[0]);
    $contatosCliente    = $modeloAlarm->listarContatoAlarmes($this->parametros[0]);


    if($filiaisCliente['status']){
        $filiais = $filiaisCliente['filiais'];
    }else{
        $filiais = 0;
    }

    if($contatosCliente['status']){
        $contatos = $contatosCliente['contatos'][0];
    }else{
        $contatos = 0;
    }

    //var_dump($filiais);
?>

<script type="text/javascript">
    // gerenciador de link
    var menu = document.getElementById('listadir');
    menu.innerHTML = '<a href="<?php echo HOME_URI; ?>/home/" class="linkMenuSup">Home</a> / <a href="<?php echo HOME_URI; ?>/alarme">Listar alarmes</a> / <a href="<?php echo HOME_URI; ?>/alarme/gerenciarAlertas/<?php echo $this->parametros[0]; ?>">Gerenciar alarmes</a>';
</script>

<!-- formulario de contatos -->
<div class="row">
    <div id="painelCadastro" class="col-lg-12">

        <!-- TITULO PAGINA -->
        <label class="page-header">Gerenciar recebimento de alarmes</label><!-- Fim Titulo pagina -->

        <!-- TABELA CONTENDO TODOS OS CLIENTES -->
        <div class="panel panel-default">
            <div class="panel-heading">
                <a role="button" data-toggle="collapse" data-parent="#painelCadastro" href="#collapseCadastro" aria-expanded="true" aria-controls="collapseOne">
                  <i class="fa fa-user-md "></i> Cadastrar novo contato para alarme
                </a>
            </div>
            <div id="collapseCadastro" class="panel-collapse collapse out" role="tabpanel" aria-labelledby="headingOne">
                <div class="panel-body">
                    <!-- formulario de cadastro -->
                    <form id="novoContatoAlarme" method="post">
                        <div class="row">

                            <input id="idMatriz" name="idMatriz" type="hidden" value="<?php echo $this->parametros[0]; ?>" />

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Selecione o local do contato : </label>
                                    <select class="form-control" id="sedeContato">
                                        <option value=""> Selecione a matriz ou filial</option>
                                        <?php
                                            if($filiais !=0){
                                                echo "<option value='0'> Matriz </option>";
                                                foreach ($filiais as $filial) {
                                                    echo "<option value='".$filial['id']."'> ".$filial['nome']." </option>";
                                                }
                                            }else{
                                                echo "<option value='0'> Contato matriz </option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Nome do contato : </label>
                                    <input type="text" class="form-control" id="txt_nomeContato" name="txt_nomeContato" placeholder="Nome para contato" maxlength="80" value="">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Função : </label>
                                    <input type="text" class="form-control" id="txt_funcao" name="txt_funcao" placeholder="Função do contato" maxlength="80" value="">
                                </div>
                            </div>

                        </div>
                        <div class="row">

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Email : </label>
                                    <input type="text" class="form-control" id="txt_email" name="txt_email" placeholder="Email do contato" maxlength="80" value="">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Celular : </label>
                                    <input type="text" class="form-control" id="txt_celular" name="txt_celular" placeholder="Celular do contato" maxlength="80" value="">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Observações : </label>
                                    <textarea id="txt_obs" name="txt_obs" class="form-control" ></textarea>
                                </div>
                            </div>



                        </div>
                        <div class="row">
                            <div class="col-md-4">

                            </div>
                            <div class="col-md-4">
                                <button type="button" id="registrarContato" class="btn btn-info">Registrar contato para alarme</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Contatos de alarme já cadastrados -->
<div class="row">
    <div class="col-lg-12">
        <!-- TABELA CONTENDO TODOS OS CLIENTES -->
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-md-6">
                        <h5>
                            Contatos já cadastrados
                        </h5>
                    </div>
                    <div class="col-md-6">
                        <select class="form-control" id="listarSedes">
                            <option value=""> Selecione a matriz ou filial</option>
                            <?php
                                if($filiais !=0){
                                    echo "<option value='0'> Matriz </option>";
                                    foreach ($filiais as $filial) {
                                        echo "<option value='".$filial['id']."'> ".$filial['nome']." </option>";
                                    }
                                }else{
                                    echo "<option value='0'> Contato matriz </option>";
                                }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="panel-body">

                <div class="row">
                    <div class='table-responsive'>
                        <table id="stream_table_contatos" class='table table-striped table-bordered'>
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Função</th>
                                    <th>Email</th>
                                    <th>Celular</th>
                                    <th>Observação</th>
                                    <th class="txt-center">Editar</th>
                                    <th class="txt-center">Excluir</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODAL PARA A EDIÇÃO DE CONTATO PARA RECEBER ALERTA -->

<div  id="editContato" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Editar contato</h4>
      </div>
      <div class="modal-body">
          <div class="panel panel-default">
              <div class="panel-heading">
                <i class="fa fa-user-md "></i> Dados do contato para alarme
              </div>
              <div class="panel-body">
                  <form id="edicaoContatoAlarme" method="post">
                      <div class="row">
                          <input id="idContatoEditar" name="idContatoEditar" type="hidden" value="" />

                          <div class="col-md-4">
                              <div class="form-group">
                                  <label for="exampleInputEmail1">Nome do contato : </label>
                                  <input type="text" class="form-control" id="txt_nomeContato_edit" name="txt_nomeContato_edit" placeholder="Nome para contato" maxlength="80" value="">
                              </div>
                          </div>

                          <div class="col-md-4">
                              <div class="form-group">
                                  <label for="exampleInputEmail1">Função : </label>
                                  <input type="text" class="form-control" id="txt_funcao_edit" name="txt_funcao_edit" placeholder="Função do contato" maxlength="80" value="">
                              </div>
                          </div>

                          <div class="col-md-4">
                              <div class="form-group">
                                  <label for="exampleInputEmail1">Email : </label>
                                  <input type="text" class="form-control" id="txt_email_edit" name="txt_email_edit" placeholder="Email do contato" maxlength="80" value="">
                              </div>
                          </div>
                      </div>

                      <div class="row">
                          <div class="col-md-4">
                              <div class="form-group">
                                  <label for="exampleInputEmail1">Celular : </label>
                                  <input type="text" class="form-control" id="txt_celular_edit" name="txt_celular_edit" placeholder="Celular do contato" maxlength="80" value="">
                              </div>
                          </div>

                          <div class="col-md-4">
                              <div class="form-group">
                                  <label for="exampleInputEmail1">Observações : </label>
                                  <textarea id="txt_obs_edit" name="txt_obs_edit" class="form-control" ></textarea>
                              </div>
                          </div>

                      </div>
                  </form>
              </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button id="registraAlteracao" type="button" class="btn btn-primary">Salvar alterações</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
