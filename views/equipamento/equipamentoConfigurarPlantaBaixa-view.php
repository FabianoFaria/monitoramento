<?php

    if (! defined('EFIPATH')) exit;

    $dadosEquipamento   = $modelo->dadosEquipamentoCliente($this->parametros[0]);

    //var_dump($dadosEquipamento);

    $local              = (isset($dadosEquipamento['equipamento'][0]['filial']))? $dadosEquipamento['equipamento'][0]['filial'] : "Matriz";
    $local              = $dadosEquipamento['equipamento'][0]['cliente']." - ".$local;
    $idClie             = $dadosEquipamento['equipamento'][0]['id_cliente'];
    $idFili             = $dadosEquipamento['equipamento'][0]['id_filial'];
    $idEquip            = $dadosEquipamento['equipamento'][0]['id'];

    // CARREGA OS DADOS DA PLANTA BAIXA

    $plantaBaixa        = $modelo->dadosEquipamentoPlantaBaixa($this->parametros[0]);

    //var_dump($plantaBaixa);
 ?>


 <script type="text/javascript">
     // gerenciador de link
     var menu = document.getElementById('listadir');
     menu.innerHTML = '<a href="<?php echo HOME_URI; ?>/home/" class="linkMenuSup">Home</a> / <a href="<?php echo HOME_URI; ?>/equipamento"> Equipamentos </a> / <a href="<?php echo HOME_URI; ?>/equipamento/gerenciarPlantaBaixa/"> Listar locais </a> / <a href="<?php echo HOME_URI; ?>/equipamento/configurarPlantaBaixa/<?php echo $this->parametros[0]; ?>">Configurar planta baixa : <?php echo $local; ?></a>';
 </script>
 <div class="row">
     <div class="col-lg-12">
         <!-- TITULO PAGINA -->
         <label class="page-header"> Planta baixa configurada para o equipamento :</label><!-- Fim Titulo pagina -->
     </div>
 </div>

 <div class="row">

    <div class="col-lg-12">

        <!-- TABELA CONTENDO OS USUÁRIOS CADASTRADOS -->
        <div class="panel panel-default">
            <div class="panel-heading">
            </div>
            <div class="panel-body">

                <!--
                    VERIFICA SE EXISTE OU NÃO UMA PLANTA BAIXA EXISTENTE
                -->
                <?php

                    //var_dump($plantaBaixa);

                    if($plantaBaixa['status']){

                        // var_dump($plantaBaixa);
                ?>
                    <form id="uploadPlanta" enctype="multipart/form-data">

                        <input type="hidden" class="form-control" id="txt_planta" name="txt_planta" value="<?php echo $plantaBaixa['dadosPlanta'][0]['id_planta']; ?>">
                        <input type="hidden" class="form-control" id="txt_img" name="txt_img" value="<?php echo $plantaBaixa['dadosPlanta'][0]['imagem_planta']; ?>">

                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Descrição da planta baixa cadastrada atualmente</label>

                                    <input type="text" class="form-control" id="txt_planta" name="txt_planta" value="<?php echo $plantaBaixa['dadosPlanta'][0]['descricao_imagem']; ?>" readonly="true">

                                </div>

                            </div>

                        </div>

                        <div class="row">

                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Imagem atual da planta</label>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <img src="<?php echo HOME_URI; ?>/views/_uploads/plantas/<?php echo $plantaBaixa['dadosPlanta'][0]['imagem_planta']; ?>" alt="Imagem da planta baixa!" class="">
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                            </div>
                            <div class="col-md-4">
                                <button type="button" class="btn btn-danger btn-lg btn-block" id="removerPlantaBaixa">Remover planta baixa</button>
                            </div>
                        </div>
                    </form>
                <?php

                    }else{

                        //EXIBE FORMULARIO PARA EXIBIÇÃO DE UPLOAD DE PLANTA BAIXA

                    ?>
                        <form id="uploadPlanta" enctype="multipart/form-data">

                            <div class="row">

                                <!-- nome do usuario -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Descrição planta</label>
                                        <input type="hidden" class="form-control" id="txt_clie" name="txt_clie" value="<?php echo $idClie; ?>">
                                        <input type="hidden" class="form-control" id="txt_filial" name="txt_filial" value="<?php echo $idFili; ?>">
                                        <input type="hidden" class="form-control" id="txt_equip" name="txt_equip" value="<?php echo $idEquip; ?>">
                                        <input type="text" class="form-control" id="txt_planta" name="txt_planta" placeholder="Nome da planta" maxlength="50"
                                        value="">
                                    </div>
                                </div><!-- fim nome do usuario -->

                            </div>

                            <div class="row">

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Imagem da planta baixa (Imagem deve ter no mínimo 500 x 500 de tamanho.)</label>

                                        <div class="form-group">
                                            <input id="file_planta" name="file_planta" type="file" />
                                        </div>

                                    </div>

                                </div>

                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                </div>
                                <div class="col-md-4">

                                    <!-- <input type="submit" id="btn_salvar" name="btn_salvar" class="btn btn-info" value="Atualizar"> -->
                                    <button type="button" class="btn btn-info btn-lg btn-block" id="cadastrarPlantaBaixa">Cadastrar planta baixa</button>

                                </div>
                            </div>
                        </form>

                    <?php
                    }

                ?>

            </div>
        </div>

    </div>

</div>
