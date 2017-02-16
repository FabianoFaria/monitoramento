<?php
/* verifica se esta definido o path */
if (! defined('EFIPATH')) exit();
?>

<script src="<?php echo HOME_URI; ?>/views/_js/table/mustache.js" type="text/javascript"></script>
<script src="<?php echo HOME_URI; ?>/views/_js/table/stream_table.js" type="text/javascript"></script>

<?php
// chamando lista de valores
//$retorno = $modelo->buscaRelacao();

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
    menu.innerHTML = '<a href="<?php echo HOME_URI; ?>/home/" class="linkMenuSup">Home</a> / <a href="<?php echo HOME_URI; ?>/monitoramento/" class="linkMenuSup">Monitoramento</a>';
</script>


<script src="<?php echo HOME_URI; ?>/views/_js/table/index.js" type="text/javascript"></script>

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
                                Cliente : <select id="filtroClienteLista" class="form-control">
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
                        <div class="col-md-3">
                            <!-- <p>
                                Local : <select id="filtroLocalLista" class="form-control">
                                            <option value="0">Selecione... </option>
                                        </select>
                            </p> -->
                            <p>
                                Local : <input type="text" class="form-control" id="filtroLocalAutoComplete" name="filtroLocalAutoComplete" value="">
                                <input type="hidden" id="localId" value="" />
                            </p>
                        </div>
                        <div class="col-md-3">
                            <p>
                                <?php
                                    $listaTipoEquip = $modeloEquip->listarTipoEquip();
                                ?>

                                Equipamento : <select id="filtroEquipLista" class="form-control">

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
                        <div class="col-md-3">
                            <p>
                                <br />
                                <button class="btn btn-primary" id="aplicarFiltro">Filtrar</button>
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
                            <?php
                                if($lista)
                                {
                                    foreach ($lista as $cliente){
                                ?>
                                    <tr>
                                        <td><?php echo $cliente['nome']; ?></td>
                                        <td><?php echo $cliente['cidade']; ?></td>
                                        <td><?php echo "(".$cliente['ddd'].") ".$cliente['telefone']; ?></td>
                                        <td><a href="<?php echo HOME_URI; ?>/monitoramento/unidades/<?php echo  $cliente['id']; ?>"><i class="fa  fa-camera-retro fa-2x"></i></a></td>
                                    </tr>
                                <?php
                                    }
                                }
                                else{
                                ?>
                                    <tr>
                                        <td colspan="4">Nenhum cliente cadastrado até o momento</td>
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
