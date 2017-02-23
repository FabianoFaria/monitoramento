<?php

if (!defined('EFIPATH')) exit();

    /*
    * VERIFICA O TIPO DE USUÁRIO E EFETUA AS RESPECTIVAS OPERAÇÕES
    */
    switch ($_SESSION['userdata']['tipo_usu']) {
        case 'Administrador':
            //var_dump($_SESSION);

            $dadosCliente   = $modeloClie->carregarDadosCliente($this->parametros[0]);

            if($dadosCliente['status']){
                $dadosCliente   = $dadosCliente['dados'][0];
                $lista          = $modeloEquip->listarEquipamentosCliente($this->parametros[0]);
                $lista          = $lista['equipamentos'];
                $nomeCliente    = $dadosCliente['nome'];
            }else{
                $lista          = false;
            }

        break;

        case 'Cliente':

            //RECEBE O PARAMETRO DO CLIENTE E VERIFICA SE O USUÁRIO TEM ACESSO E ELE
            $usuarioAutorizado  = false;
            $idcliente = $_SESSION['userdata']['cliente'];
            $usuariosCliente  = $modeloClie->carregaDadosContato($this->parametros[0]);

            //VERIFICA SE O USUAÁRIO PERTENCE AO CLIENTE QUE ESTÁ TENTANDO ACESSAR
            if($usuariosCliente['status']){
                foreach ($usuariosCliente['dados'] as $usuarioCliente){
                    if($usuarioCliente['id_cliente'] == $idcliente){
                        $usuarioAutorizado  = true;
                    }
                }
            }

            if($usuarioAutorizado){

                $dadosCliente   = $modeloClie->carregarDadosCliente($this->parametros[0]);

                if($dadosCliente['status']){
                    $dadosCliente   = $dadosCliente['dados'][0];
                    $lista          = $modeloEquip->listarEquipamentosCliente($this->parametros[0]);
                    $lista          = $lista['equipamentos'];
                    $nomeCliente    = $dadosCliente['nome'];
                }else{
                    $lista          = false;
                }
            }else{
                $lista          = false;
            }

        break;

        case 'Visitante':

            //RECEBE O PARAMETRO DO CLIENTE E VERIFICA SE O USUÁRIO TEM ACESSO E ELE
            $usuarioAutorizado  = false;
            $idcliente = $_SESSION['userdata']['cliente'];
            $usuariosCliente  = $modeloClie->carregaDadosContato($this->parametros[0]);

            //VERIFICA SE O USUAÁRIO PERTENCE AO CLIENTE QUE ESTÁ TENTANDO ACESSAR
            if($usuariosCliente['status']){
                foreach ($usuariosCliente['dados'] as $usuarioCliente){
                    if($usuarioCliente['id_cliente'] == $idcliente){
                        $usuarioAutorizado  = true;
                    }
                }

            }

        break;

        case 'Tecnico':
            $dadosCliente   = $modeloClie->carregarDadosCliente($this->parametros[0]);

            if($dadosCliente['status']){
                $dadosCliente   = $dadosCliente['dados'][0];
                $lista          = $modeloEquip->listarEquipamentosCliente($this->parametros[0]);
                $lista          = $lista['equipamentos'];
                $nomeCliente    = $dadosCliente['nome'];
            }else{
                $lista          = false;
            }
        break;
    }


?>

<script src="<?php echo HOME_URI; ?>/views/_js/table/mustache.js" type="text/javascript"></script>
<script src="<?php echo HOME_URI; ?>/views/_js/table/stream_table.js" type="text/javascript"></script>

<?php
// chamando lista de valores
// $retorno = $modelo->buscaRelacaoEquipamento();
// $retorno2 = $modelo->buscaClienteFilial();


?>

<script type="text/javascript">
    // gerenciador de link
    var menu = document.getElementById('listadir');
    menu.innerHTML = '<a href="<?php echo HOME_URI; ?>/home/" class="linkMenuSup">Home</a> / <a href="<?php echo HOME_URI; ?>/grafico/" class="linkMenuSup">Relatôrio </a> / <a href="<?php echo HOME_URI; ?>/grafico/listaFilial/<?php echo $this->parametros[0]; ?>"> Cliente :<?php echo $nomeCliente; ?></a>';
</script>


<script src="<?php echo HOME_URI; ?>/views/_js/table/index.js" type="text/javascript"></script>

<div class="row">
    <div class="col-md-12">
        <!-- Titulo pagina -->
        <label class="page-header">Relatôrios para equipamentos da matriz/filiais</label><!-- Fim Titulo pagina -->
    </div>

</div>

<div class="row">
    <div class="col-lg-12">

        <!-- TABELA CONTENDO OS USUÁRIOS CADASTRADOS -->
        <div class="panel panel-default">
            <div class="panel-heading">
            </diV>

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
                                <th>Sede</th>

                                <!-- <th>Caracteristica</th> -->
                                <!-- <th>Tipo bateria</th> -->
                                <th class="txt-center">Verificar relatôrio equipamento</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                if($lista){

                                    foreach ($lista as $equipamento) {
                            ?>
                                <tr>
                                    <td><?php echo $equipamento['tipoEquip']; ?></td>
                                    <td><?php echo $equipamento['nomeModeloEquipamento']; ?></td>
                                    <td><?php echo $equipamento['fabricante']; ?></td>
                                    <!-- <td><?php //echo $equipamento['potencia']; ?></td> -->
                                    <td><?php echo $equipamento['cliente']?></td>
                                    <td>
                                        <?php echo (isset($equipamento['filial'])) ? $equipamento['filial'] : "Matriz"; ?>
                                    </td>
                                    
                                    <td><?php //echo $equipamento['amperagem_bateria']; ?>
                                        <a href="<?php echo HOME_URI; ?>/grafico/opcaoVisualizacao/<?php echo $equipamento['id'] ?>" class="link-tabela-moni">
                                            <i class="fa fa-clipboard  fa-2x "></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php
                                    }
                                }else{
                            ?>
                                 <tr>
                                     <td colspan="6">Nenhum equipamento cadastrado até o momento</td>
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
