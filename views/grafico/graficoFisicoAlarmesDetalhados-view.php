<?php

    /* verifica se esta definido o path */
    if (! defined('EFIPATH')) exit();


    /*
    * VERIFICA O TIPO DE USUÁRIO E EFETUA AS RESPECTIVAS OPERAÇÕES
    */
    switch ($_SESSION['userdata']['tipo_usu']) {

        case 'Administrador':

            //var_dump($_SESSION);
            $listaClientes = $modeloClie->listarCliente();

        break;

        case 'Cliente':
            $listaClientes = $modeloClie->listarClienteUsuario($_SESSION['userdata']['cliente']);
        break;

        case 'Visitante':
            $listaClientes = $modeloClie->listarClienteUsuario($_SESSION['userdata']['cliente']);
        break;

        case 'Tecnico':
            //RETORNO SENDO CARREGADO DIRETO DA CLASS.MAIN
            $listaClientes = $modeloClie->listarCliente();
        break;

    }



?>

<script type="text/javascript">

    // gerenciador de link
    var menu = document.getElementById('listadir');
    menu.innerHTML = '<a href="<?php echo HOME_URI; ?>/home/" class="linkMenuSup">Home</a> / <a href="<?php echo HOME_URI; ?>/grafico/graficoTratamentoAlarme" class="linkMenuSup">Relatôrios alarme detalhado</a>';
</script>


<div class="row">
    <div class="col-md-12">
        <!-- Titulo pagina -->
        <label class="page-header">Relatórios detalhados de alarmes</label><!-- Fim Titulo pagina -->
    </div>

</div>

<div class="row">
    <div class="col-lg-12">

        <!-- TABELA CONTENDO OS USUÁRIOS CADASTRADOS -->
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <form id="filtroMonitoramento" class="">
                        <div class="col-md-3 form-group">
                            <p>
                                Cliente :
                                <select id="filtroClienteAlarmeDetalhado" class="form-control">
                                    <?php
                                        if($listaClientes){
                                            echo "<option value=''>Selecione... </option>";
                                            foreach ($listaClientes as $cliente){
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
                            <p>
                                Local : <input type="text" class="form-control" id="filtroLocalAutoCompleteAlarmeDetalhado" name="filtroLocalAutoCompleteAlarmeDetalhado" value="">
                                <input type="hidden" id="localId" value="" />
                            </p>
                        </div>
                        <div class="col-md-3 form-group">
                            <p>
                                <?php
                                    $listaTipoEquip = $modeloEquip->listarTipoEquip();
                                ?>

                                Equipamento :
                                <select id="filtroEquipAlarmeDetalhado" class="form-control">

                                    <?php
                                        if($listaTipoEquip['status']){

                                            echo "<option value='0'>Todos </option>";

                                            foreach ($listaTipoEquip['equipamento'] as $typeEquipe) {
                                                $idType     = $typeEquipe['id'];
                                                $nomeType   = $typeEquipe['tipo_equipamento'];

                                                echo "<option value='".$idType."'>".$nomeType."</option>";
                                            }

                                        }else{
                                            ?>
                                                <option value="">Selecione... </option>
                                            <?php
                                        }
                                    ?>
                                </select>
                            </p>
                        </div>
                        <div class="col-md-3 form-group">
                            <p>
                                <br />
                                <button class="btn btn-primary" id="limparFiltro">Limpar filtro</button>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
            <div class="panel-body">
                <table class='table table-striped table-bordered' id="listaMonitoria">
                    <thead>
                        <tr>
                            <th class="tdbdbottom">Cliente</th>
                            <th class="tdbdbottom">Data ativa&ccedil;&atilde;o</th>
                            <th class="tdbdbottom">Status</th>
                            <th class="tdbdbottom">Equipamentos para relatôrio</th>
                        </tr>
                    </thead>
                    <tbdoy>
                        <tr>
                            <td colspan="4">
                                Selecione um cliente
                            </td>
                        </tr>
                    </tbdoy>
                </table>
            </div>
        </div>

    </div>
</div>
