<?php

/* verifica se esta definido o path */
if (! defined('EFIPATH')) exit();

/*
* VERIFICA O TIPO DE USUÁRIO E EFETUA AS RESPECTIVAS OPERAÇÕES
*/

switch ($_SESSION['userdata']['tipo_usu']) {
    case 'Administrador':
        //var_dump($_SESSION);
        $listaClientes = $modeloCliete->listarCliente();
    break;
    case 'Visitante':
        //RECEBE O PARAMETRO DO CLIENTE E VERIFICA SE O USUÁRIO TEM ACESSO E ELE
        $usuarioAutorizado  = false;
        $idcliente = $_SESSION['userdata']['cliente'];
        $usuariosCliente  = $modeloCliete->carregaDadosContato($_SESSION['userdata']['cliente']);

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
    case 'Cliente':
        //RECEBE O PARAMETRO DO CLIENTE E VERIFICA SE O USUÁRIO TEM ACESSO E ELE
        $usuarioAutorizado  = false;
        $idcliente = $_SESSION['userdata']['cliente'];
        $usuariosCliente  = $modeloCliete->carregaDadosContato($_SESSION['userdata']['cliente']);

        //VERIFICA SE O USUAÁRIO PERTENCE AO CLIENTE QUE ESTÁ TENTANDO ACESSAR
        if($usuariosCliente['status']){
            foreach ($usuariosCliente['dados'] as $usuarioCliente){
                if($usuarioCliente['id_cliente'] == $idcliente){
                    $usuarioAutorizado  = true;
                }
            }
        }

        if($usuarioAutorizado){
            $listaClientes = $modeloCliete->listarClienteUsuario($_SESSION['userdata']['cliente']);
        }else{
            $listaClientes = false;
        }
    break;
    case 'Tecnico':
        //var_dump($_SESSION);
        $listaClientes = $modeloCliete->listarCliente();
    break;

}

?>

<script type="text/javascript">

    // gerenciador de link
    var menu = document.getElementById('listadir');
    menu.innerHTML = '<a href="<?php echo HOME_URI; ?>/home/" class="linkMenuSup">Home</a> / <a href="<?php echo HOME_URI; ?>/alarme/alarmePorEquipamento/" class="linkMenuSup">Envio de alarmes por equipamentos </a>';

</script>


<div class="row">
    <div class="col-md-12">
        <!-- Titulo pagina -->
        <label class="page-header">Envio de alarmes por equipamento</label><!-- Fim Titulo pagina -->
    </div>

</div>

<div class="row">
    <div class="col-lg-12">

        <!-- TABELA CONTENDO O FILTRO DE CLIENTES, LOCAIS E TIPOS DE EQUIPAMENTOS -->
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <form id="filtroMonitoramento" class="">
                        <div class="col-md-3 form-group">
                            <p>
                                Cliente :
                                <select id="filtroClienteLista" class="form-control">
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
                                Local : <input type="text" class="form-control" id="filtroLocalAutoComplete" name="filtroLocalAutoComplete" value="">
                                <input type="hidden" id="localId" value="" />
                            </p>
                        </div>
                        <div class="col-md-3 form-group">
                            <p>
                                <?php
                                    $listaTipoEquip = $modeloEquip->listarTipoEquip();
                                ?>

                                Equipamento :
                                <select id="filtroEquipLista" class="form-control">

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
                <table class='table table-striped table-bordered' id="listaMonitoria">
                    <thead>
                        <tr>
                            <th class="tdbdbottom">Equipamento</th>
                            <th>Modelo</th>
                            <th>Cliente</th>
                            <th>local</th>
                            <th class="tdbdbottom">Gerenciar contatos</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
