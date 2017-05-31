<?php
/* verifica se esta definido o path */
if (! defined('EFIPATH')) exit();

/*
* VERIFICA O TIPO DE USUÁRIO E EFETUA AS RESPECTIVAS OPERAÇÕES
*/
switch ($_SESSION['userdata']['tipo_usu']) {
    case 'Administrador':
        //var_dump($_SESSION);
        $lista = $modeloClie->listarCliente();


    break;

    case 'Cliente':

        $lista = $modeloClie->listarClienteUsuario($_SESSION['userdata']['cliente']);

    break;

    case 'Visitante':

        $lista = $modeloClie->listarClienteUsuario($_SESSION['userdata']['cliente']);

    break;

    case 'Tecnico':
        //RETORNO SENDO CARREGADO DIRETO DA CLASS.MAIN
        $lista = $modeloClie->listarCliente();


    break;
}

?>

<script type="text/javascript">

    // GERENCIADOR DE LINK
    var menu = document.getElementById('listadir');
    menu.innerHTML = '<a href="<?php echo HOME_URI; ?>/home/" class="linkMenuSup">Home</a> / <a href="<?php echo HOME_URI; ?>/equipamentoPlantaBaixa/" class="linkMenuSup">Monitoramento planta baixa</a>';

</script>

<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-4 pull-left">
                <!-- Titulo pagina -->
                <label class="page-header">Clientes configurados para monitorar</label><!-- Fim Titulo pagina -->
            </div>
            <div class="col-md-4">

            </div>
            <div class="col-md-4">

            </div>
        </div>

    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <!-- TABELA CONTENDO TODOS OS CLIENTES -->
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <form id="filtroMonitoramento" class="">
                        <div class="col-md-3 form-group">
                            <p>
                                Cliente : <select id="filtroClienteListaPlanta" class="form-control">
                                                <?php
                                                    if($lista){
                                                        echo "<option value=''>Selecione... </option>";
                                                        foreach ($lista as $cliente){
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
                                Unidade : <select id="filtroLocalListaPlanta" class="form-control">
                                            <option value="0">Selecione... </option>
                                        </select>
                                <input type="hidden" id="localId" value="" />
                            </p>
                        </div>
                        <div class="col-md-3 form-group">
                            <p>
                                <?php
                                    $listaTipoEquip = $modeloEquip->listarTipoEquip();
                                ?>

                                Equipamento : <select id="filtroEquipListaPlanta" class="form-control">

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
                    </form>
                </div>
            </div>
            <div class="panel-body">
                <div class='table-responsive'>
                    <table id="listaMonitoria" class='table table-striped table-bordered'>
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Cidade</th>
                                <th>Telefone</th>
                                <th class="txt-center">Monitorar equipamentos</th>
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
