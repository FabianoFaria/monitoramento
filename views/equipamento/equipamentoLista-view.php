<!-- LISTAR EQUIPAMENTOS VIEW -->
<?php
    if (! defined('EFIPATH')) exit;
?>

<script type="text/javascript">
    // gerenciador de link
    var menu = document.getElementById('listadir');
    menu.innerHTML = '<a href="<?php echo HOME_URI; ?>/home/" class="linkMenuSup">Home</a> / <a href="<?php echo HOME_URI; ?>/equipamento">Listar equipamentos</a>';
</script>


<?php

    $lista = $modeloEquipamento->listarEquipamentos();

 ?>

<div class="row">
    <div class="col-lg-12">
        <!-- TITULO PAGINA -->
        <label class="page-header">Equipamentos registrados até o momento</label><!-- Fim Titulo pagina -->
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <div class="btn-group">
            <a href="<?php echo HOME_URI; ?>/equipamento/cadastrarEquipamento/" class="btn btn-primary">
                <i class="fa fa-plus fa-lg"> </i>Adicionar novo equipamento
            </a>
        </div>
    </div>
</div>

 <div class="row">
    <div class="col-lg-12">

        <!-- TABELA CONTENDO OS USUÁRIOS CADASTRADOS -->
        <div class="panel panel-default">
            <div class="panel-heading">

            </div>
            <div class="panel-body">
                <div class='table-responsive'>
                    <table id="stream_table" class='table table-striped table-bordered'>
                        <thead>
                            <tr>
                                <th>Equipamento</th>
                                <th>Modelo</th>
                                <th>Fabricante</th>
                                <!-- <th>Potencia</th>-->
                                <th>Cliente</th>
                                <th>Local</th>
                                <!-- <th>Quantidade baterias</th> -->
                                <th>N° SIM</th>
                                <!-- <th>Tipo bateria</th> -->
                                <th class="txt-center">Configurar parametros</th>
                                <th class="txt-center">Editar equipamento</th>
                                <th class="txt-center">Excluir</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                if($lista){

                                    foreach ($lista as $equipamento) {
                            ?>
                                <tr>
                                    <td><?php echo $equipamento['tipo_equipamento']; ?></td>
                                    <td><?php echo $equipamento['nomeModeloEquipamento']; ?></td>
                                    <td><?php echo $equipamento['fabricante']; ?></td>
                                    <!-- <td><?php //echo $equipamento['potencia']; ?></td> -->
                                    <td><?php echo $equipamento['cliente']?></td>
                                    <td><?php

                                            if(isset($equipamento['filial'])){
                                                echo $equipamento['filial'];
                                            }else{
                                                echo 'Matriz';
                                            }

                                        ?>
                                    </td>
                                    <!-- <td><?php //echo $equipamento['qnt_bateria']; ?></td> -->
                                    <td><?php echo (isset($equipamento['sim_clie'])) ? $equipamento['sim_clie'] : "<a href='".HOME_URI."/vinculo/vincularEquipamentoSim/".$equipamento['id']."'> Vincular N° SIM </a>"; ?></td>

                                    <!-- <td><?php //echo $equipamento['tipo_bateria']; ?></td> -->
                                    <td><?php //echo $equipamento['amperagem_bateria']; ?>
                                        <a href="<?php echo HOME_URI; ?>/configuracao/configurarEquipamentoCliente/<?php echo $equipamento['id'] ?>" class="link-tabela-moni">
                                            <i class="fa fa-wrench "></i>
                                        </a>
                                    </td>
                                    <td>
                                        <!-- <a href="<?php echo HOME_URI; ?>/editar/editarEquipamento/<?php echo $equipamento['id']; ?>" class="link-tabela-moni">
                                            <i class="fa fa-pencil-square-o fa-lg"></i>
                                        </a> -->

                                        <a href="<?php echo HOME_URI; ?>/equipamento/editarEquipamentoCliente/<?php echo $equipamento['id']; ?>" class="link-tabela-moni">
                                            <i class="fa fa-pencil-square-o fa-lg"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <button class="btn btnRemoveEquip" value="<?php echo $equipamento['id']; ?>"><i class="fa  fa-times fa-lg"></i></button>
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
