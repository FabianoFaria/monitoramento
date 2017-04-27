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
    <div class="col-md-12">
        <!-- TITULO PAGINA -->
        <label class="page-header">Fabricantes registrados até o momento</label><!-- Fim Titulo pagina -->
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <div class="btn-group">
            <a href="<?php echo HOME_URI; ?>/fabricante/cadastrar/" class="btn btn-primary">
                <i class="fa fa-plus fa-lg"> </i>Adicionar novo fabricante
            </a>
        </div>
    </div>
</div>

 <div class="row">
    <div class="col-lg-12">

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
                                        <button class="btn link-tabela-moni editFabricante" value="<?php echo $fabricante['id']; ?>"><i class="fa fa-pencil-square-o fa-lg"></i></button>
                                    </td>
                                    <td>
                                        <button class="btn removerFabricante" value="<?php echo $fabricante['id']; ?>"><i class="fa  fa-times fa-lg"></i></button>
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

<!-- MODAL PARA EDIÇÃO DE FABRICANTES -->

<div id="modalCadFabricantes" class="modal fade" tabindex="-1" role="dialog" >
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel">Editar Fabricante</h4>
            </div>
            <div class="modal-body">

                <!-- form contendo os dados do cliente -->
              <form id="editFabrica" method="post" action="#">
                   <div class="row">
                      <!-- nome do fabricante -->
                      <div class="col-md-6">
                          <div class="form-group">
                              <input type="hidden" id="idFabricante" value="" />
                              <label for="exampleInputEmail1">Nome do Fabricante</label>
                              <input type="text" class="form-control" id="txt_fabricante" name="txt_fabricante" placeholder="Nome do Equipamento" maxlength="80" required>
                          </div>
                      </div><!-- fim nome do fabricante -->

                      <!-- DDD -->
                      <div class="col-md-2">
                          <div class="form-group">
                              <label for="exampleInputEmail1">C&oacute;digo de &Aacute;rea</label>
                              <input type="text" class="form-control" id="txt_ddd" name="txt_ddd" placeholder="DDD (000)" maxlength="3" onkeypress="return onlyNumber(event);">
                          </div>
                      </div><!-- fim do ddd -->

                      <!-- telefone -->
                      <div class="col-md-4">
                          <div class="form-group">
                              <label for="exampleInputEmail1">Telefone</label>
                              <input type="text" class="form-control" id="txt_telefone" name="txt_telefone" placeholder="Telefone" maxlength="10" onkeypress="return onlyNumber(event);">
                          </div>
                      </div><!-- fim do telefone -->
                   </div>

                   <div class="row">
                       <div class="col-md-6">
                           <div class="form-group">
                             <label for="exampleInputEmail1">Email do Fabricante</label>
                             <input type="text" class="form-control" id="txt_email" name="txt_email" placeholder="Email Fabricante" maxlength="80" required>
                         </div>
                       </div>
                   </div>

                   <div class="row">

                      <!-- cep -->
                      <div class="col-md-2">
                          <div class="form-group">
                              <label for="exampleInputEmail1">CEP</label>
                              <input type="text" class="form-control" id="txt_cep" name="txt_cep" placeholder="CEP">
                          </div>
                      </div><!-- fim do cep -->


                      <!-- endereco do cliente -->
                      <div class="col-md-6">
                          <div class="form-group">
                              <label for="exampleInputEmail1">Endere&ccedil;o</label>
                              <input type="text" class="form-control" id="txt_endereco" name="txt_endereco" placeholder="Rua, Avenida e etc" maxlength="200" required>
                          </div>
                      </div><!-- fim do endereco do cliente -->

                      <!-- numero -->
                      <div class="col-md-2">
                          <div class="form-group">
                              <label for="exampleInputEmail1">N&uacute;mero</label>
                              <input type="text" class="form-control" id="txt_numero" name="txt_numero" placeholder="000" maxlength="9"  onkeypress="return onlyNumber(event);">
                          </div>
                      </div><!-- fim do numero -->

                   </div>

                   <div class="row">
                      <!-- Cidade -->
                      <div class="col-md-3">
                          <div class="form-group">
                              <label for="exampleInputEmail1">Cidade</label>
                              <input type="text" class="form-control" id="txt_cidade" name="txt_cidade" placeholder="Cidade" maxlength="50" required>
                          </div>
                      </div><!-- fim do campo Cidade -->

                      <!-- Bairro -->
                      <div class="col-md-3">
                          <div class="form-group">
                              <label for="exampleInputEmail1">Bairro</label>
                              <input type="text" class="form-control" id="txt_bairro" name="txt_bairro" placeholder="Cidade" maxlength="50" required>
                          </div>
                      </div><!-- fim do campo Bairro -->
                  </div>
                  <div class="row">

                      <!-- pais -->
                      <div class="col-md-4">
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
                   </div>

                   <div class="row">
                      <!-- <div class="col-md-4">
                      </div>
                      <div class="col-md-4">
                           <buttom type="button" id="salvarEditFabricante" name="btn_salvar" class="btn btn-info" value="Salvar">Salvar</button>
                      </div> -->
                   </div>
              </form>

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
              <button type="button" class="btn btn-primary" id="editFilialBtn">Salvar alterações</button>
            </div>
        </div>
    </div>
</div>
