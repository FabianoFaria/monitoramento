<?php

    if (! defined('EFIPATH')) exit;




?>

<script type="text/javascript">
    // gerenciador de link
    var menu = document.getElementById('listadir');
    menu.innerHTML = '<a href="<?php echo HOME_URI; ?>/home/" class="linkMenuSup">Home</a> / <a href="<?php echo HOME_URI; ?>/equipamento"> Equipamentos </a> / <a href="<?php echo HOME_URI; ?>/equipamento/gerenciarPlantaBaixa/"> Listar locais </a>';
</script>


<?php

    $lista      = $modeloEquipamento->listarEquipamentos();
    $listaClie  = $modeloCliente->listarCliente();

 ?>

 <div class="row">
     <div class="col-lg-12">
         <!-- TITULO PAGINA -->
         <label class="page-header"> Clientes com locais registrados até o momento</label><!-- Fim Titulo pagina -->
     </div>
 </div>
 <div class="row">
     <!-- <div class="col-md-4">
         <div class="btn-group">
             <a href="<?php echo HOME_URI; ?>/equipamento/cadastrarEquipamento/" class="btn btn-primary">
                 <i class="fa fa-plus fa-lg"> </i>Adicionar novo equipamento
             </a>
         </div>
     </div> -->
 </div>

 <div class="row">

    <div class="col-lg-12">

        <!-- TABELA CONTENDO OS USUÁRIOS CADASTRADOS -->
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">

                    <form id="filtroEquipamento" class="">

                        <div class="col-md-3 form-group">
                            <p>
                                Cliente :   <select id="filtroClientePlanta" class="form-control">
                                                <?php
                                                    if($listaClie){
                                                        echo "<option value=''>Selecione... </option>";
                                                        foreach ($listaClie as $cliente){
                                                            $idClie = $cliente['id'];
                                                            $nomeClie = $cliente['nome'];
                                                            echo "<option value='".$idClie."'>".$nomeClie."</option>";
                                                        }
                                                    }else{
                                                ?>
                                                    <option value="0">Selecione... </option>
                                                <?php
                                                    }
                                                ?>
                                            </select>
                            </p>
                        </div>

                        <div class="col-md-3 form-group">

                            Estado :   <select id="filtroEstadoPlanta" class="form-control">
                                       </select>

                        </div>

                    </form>

                </div>
            </div>
            <div class="panel-body">
                <div class='table-responsive'>
                    <table id="stream_table_equipamentos_planta" class='table table-striped table-bordered'>
                        <thead>
                            <tr>
                                <th>Equipamento</th>
                                <th>Modelo/Fabricante</th>
                                <th>Cliente</th>
                                <th>Unidade</th>
                                <th class="txt-center">Ajustar pontos do equipamento</th>
                                <th class="txt-center">Configurar planta</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                if($lista){

                                    foreach ($lista as $equipamento) {
                            ?>
                                <tr>
                                    <td><?php echo $equipamento['tipo_equipamento']; ?></td>
                                    <td>
                                        <b><?php echo $equipamento['nomeModeloEquipamento']; ?></b> / <?php echo $equipamento['fabricante']; ?>
                                    </td>

                                    <!-- <td><?php //echo $equipamento['potencia']; ?></td> -->
                                    <td><?php echo $equipamento['cliente']?></td>
                                    <td>
                                        <?php

                                            if(isset($equipamento['filial'])){
                                                echo $equipamento['filial'];
                                            }else{
                                                echo 'Matriz';
                                            }

                                        ?>
                                    </td>

                                    <td>
                                        <!-- <a href="javascript:void(0)" onclick="calibrarequipamento(<?php //echo $equipamento['id'] ?>)"> -->
                                        <a href="<?php echo HOME_URI; ?>/equipamento/carregarPontosPlantaBaixa/<?php echo $equipamento['id']; ?>" class="link-tabela-moni">
                                            <i class="fa fa-map-marker "></i>
                                        </a>
                                    </td>

                                    <!-- <td><?php // echo $equipamento['tipo_bateria']; ?></td> -->
                                    <td><?php //echo $equipamento['amperagem_bateria']; ?>
                                        <a href="<?php echo HOME_URI; ?>/equipamento/configurarPlantaBaixa/<?php echo $equipamento['id'] ?>" class="link-tabela-moni">
                                            <i class="fa fa-picture-o "></i>
                                        </a>
                                    </td>

                                </tr>
                            <?php
                                    }
                                }else{
                             ?>
                                 <tr>
                                     <td colspan="10">Nenhum equipamento cadastrado até o momento</td>
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
