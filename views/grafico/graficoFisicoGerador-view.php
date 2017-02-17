<?php
    /* verifica se esta definido o path */
    if (! defined('EFIPATH')) exit();

    //$listaClientes = $modeloClie->listarCliente();

    /*
    * VERIFICA O TIPO DE USUÁRIO E EFETUA AS RESPECTIVAS OPERAÇÕES
    */
    switch ($_SESSION['userdata']['tipo_usu']) {
        case 'Administrador':
            //var_dump($_SESSION);
            $listaClientes = $modeloClie->listarCliente();


        break;

        case 'Cliente':

            //RECEBE O PARAMETRO DO CLIENTE E VERIFICA SE O USUÁRIO TEM ACESSO E ELE
            $usuarioAutorizado  = false;
            $idcliente = $_SESSION['userdata']['cliente'];
            $usuariosCliente  = $modeloClie->carregaDadosContato($_SESSION['userdata']['cliente']);

            //VERIFICA SE O USUAÁRIO PERTENCE AO CLIENTE QUE ESTÁ TENTANDO ACESSAR
            if($usuariosCliente['status']){
                foreach ($usuariosCliente['dados'] as $usuarioCliente){
                    if($usuarioCliente['id_cliente'] == $idcliente){
                        $usuarioAutorizado  = true;
                    }
                }
            }

            if($usuarioAutorizado){
                $listaClientes = $modeloClie->listarClienteUsuario($_SESSION['userdata']['cliente']);
            }else{
                $listaClientes = false;
            }


        break;

        case 'Visitante':

            //RECEBE O PARAMETRO DO CLIENTE E VERIFICA SE O USUÁRIO TEM ACESSO E ELE
            $usuarioAutorizado  = false;
            $idcliente = $_SESSION['userdata']['cliente'];
            $usuariosCliente  = $modeloClie->carregaDadosContato($_SESSION['userdata']['cliente']);

            //VERIFICA SE O USUAÁRIO PERTENCE AO CLIENTE QUE ESTÁ TENTANDO ACESSAR
            if($usuariosCliente['status']){
                foreach ($usuariosCliente['dados'] as $usuarioCliente){
                    if($usuarioCliente['id_cliente'] == $idcliente){
                        $usuarioAutorizado  = true;
                    }
                }
            }

            if($usuarioAutorizado){
                $listaClientes = $modeloClie->listarClienteUsuario($_SESSION['userdata']['cliente']);
            }else{
                $listaClientes = false;
            }

        break;

        case 'Tecnico':

            $listaClientes = $modeloClie->listarCliente();

        break;
    }

?>

<script src="<?php echo HOME_URI; ?>/views/_js/table/mustache.js" type="text/javascript"></script>
<script src="<?php echo HOME_URI; ?>/views/_js/table/stream_table.js" type="text/javascript"></script>

<?php
// chamando lista de valores
$retorno = $modelo->buscaRelacao();
?>

<script type="text/javascript">

    // GERENCIADOR DE LINK
    var menu = document.getElementById('listadir');
    menu.innerHTML = '<a href="<?php echo HOME_URI; ?>/home/" class="linkMenuSup">Home</a> / <a href="<?php echo HOME_URI; ?>/grafico/graficoFisicoGerador/" class="linkMenuSup">Relatôrio fisico</a>';
</script>

<script src="<?php echo HOME_URI; ?>/views/_js/table/index.js" type="text/javascript"></script>

<div class="row">
    <div class="col-md-12">
        <!-- Titulo pagina -->
        <label class="page-header">Selecione cliente para gerar relatôrio</label><!-- Fim Titulo pagina -->
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
                                Cliente : <select id="filtroClienteListaEstatistica" class="form-control">
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
                        <div class="col-md-3">
                            <!-- <p>
                                Local : <select id="filtroLocalLista" class="form-control">
                                            <option value="0">Selecione... </option>
                                        </select>
                            </p> -->
                            <p>
                                Local : <input type="text" class="form-control" id="filtroLocalAutoCompleteEstatistica" name="filtroLocalAutoCompleteEstatistica" value="">
                                <input type="hidden" id="localId" value="" />
                            </p>
                        </div>
                        <div class="col-md-3">
                            <p>
                                <?php
                                    $listaTipoEquip = $modeloEquip->listarTipoEquip();
                                ?>

                                Equipamento : <select id="filtroEquipListaEstatistica" class="form-control">

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
                            <th class="tdbdbottom">Parametros para relatôrio</th>
                        </tr>
                    </thead>
                    <tbdoy>
                        <?php

                            if($listaClientes){

                                foreach ($listaClientes as $cliente) {

                                    $data           = explode(" ",$cliente['dt_criacao']);
                                    $dataCliente    = $data[0];

                                    ?>
                                    <tr>
                                        <td><?php echo $cliente['nome']?></td>
                                        <td><?php echo implode("/", array_reverse(explode("-", $dataCliente))); ?></td>
                                        <td><?php echo ($cliente['status_ativo'] == 1) ? "Ativo": "Desativado" ; ?></td>
                                        <td><a href="<?php echo HOME_URI; ?>/grafico/graficoFisicoEquipamentoCliente/<?php echo $cliente['id']; ?>"><i class="fa fa-file-text-o fa-2x"></i></a></td>
                                    </tr>
                                    <?php
                                }

                            }else{
                                echo "<tr><td colspan='4'>Nenhum cliente disponivel. </td></tr>";
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
