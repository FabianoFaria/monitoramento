<?php

    /* VERIFICA SE ESTA DEFINIDO O PATH */
    if (! defined('EFIPATH')) exit();

    /*
    * VERIFICA O TIPO DE USUÁRIO E EFETUA AS RESPECTIVAS OPERAÇÕES
    */

    switch ($_SESSION['userdata']['tipo_usu']) {

        case 'Administrador':
            $dadosCliente   = $modeloClie->carregarDadosClienteEquipamento($this->parametros[0]);

            if($dadosCliente['status']){
                $dadosCliente   = $dadosCliente['dados'][0];
                $lista          = $modeloEquip->dadosEquipamentoCliente($this->parametros[0]);
                $lista          = $lista['equipamento'];
                $nomeCliente    = $dadosCliente['nome'];
            }else{
                $lista          = false;
            }

        break;

        case 'Cliente':
            //RECEBE O PARAMETRO DO CLIENTE E VERIFICA SE O USUÁRIO TEM ACESSO E ELE
            $usuarioAutorizado  = false;
            $idcliente = $_SESSION['userdata']['cliente'];
            $usuariosCliente  = $modeloClie->carregarDadosClienteEquipamento($this->parametros[0]);

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
                    $lista          = $modeloEquip->dadosEquipamentoCliente($this->parametros[0]);
                    $lista          = $lista['equipamento'];
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

            if($usuarioAutorizado){
                $dadosCliente   = $modeloClie->carregarDadosClienteEquipamento($this->parametros[0]);

                if($dadosCliente['status']){
                    $dadosCliente   = $dadosCliente['dados'][0];
                    $lista          = $modeloEquip->dadosEquipamentoCliente($this->parametros[0]);
                    $lista          = $lista['equipamento'];
                    $nomeCliente    = $dadosCliente['nome'];
                }else{
                    $lista          = false;
                }
            }else{
                $lista          = false;
            }

        break;

        case 'Tecnico':

            $dadosCliente   = $modeloClie->carregarDadosClienteEquipamento($this->parametros[0]);

            if($dadosCliente['status']){
                $dadosCliente   = $dadosCliente['dados'][0];
                $lista          = $modeloEquip->dadosEquipamentoCliente($this->parametros[0]);
                $lista          = $lista['equipamento'];
                $nomeCliente    = $dadosCliente['nome'];
            }else{
                $lista          = false;
            }

        break;
    }

?>

<script src="<?php echo HOME_URI; ?>/views/_js/table/mustache.js" type="text/javascript"></script>
<script src="<?php echo HOME_URI; ?>/views/_js/table/stream_table.js" type="text/javascript"></script>

<script type="text/javascript">
    // gerenciador de link
    var menu = document.getElementById('listadir');
    menu.innerHTML = '<a href="<?php echo HOME_URI; ?>/home/" class="linkMenuSup">Home</a> / <a href="<?php echo HOME_URI; ?>/grafico/graficoFisicoGerador" class="linkMenuSup">Relatôrio fisico </a> / <a href="<?php echo HOME_URI; ?>/grafico/graficoFisicoEquipamentoCliente/<?php echo $this->parametros[0]; ?>"> Cliente :<?php echo $nomeCliente; ?></a>';
</script>

<?php

    if($lista){

        ?>
        <div class="row">
            <div class="col-md-12">
                <!-- Titulo pagina -->
                <label class="page-header">Relatôrios para equipamentos da matriz/filiais</label><!-- Fim Titulo pagina -->
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6">

            </div>
            <div class="col-lg-6">
                <form id="periodoRelatorio" method=post>
                    <!-- Formulario a seleção de data para o relatôrio -->
                    <input id="idcliente" type="hidden" value="<?php echo $dadosCliente['id']; ?>" />
                    <input id="idEquip" type="hidden" value="<?php echo $this->parametros[0]; ?>" />
                    <div class="panel panel-info">
                        <div class="panel-heading">Período relatôrio</div>
                        <div class="panel-body">

                            <div class="row borda-01">
                                <div class="col-md-3">
                                    <label class="font-texto-02">Desde :</label>
                                </div>
                                <div class="col-md-6 txt-center">
                                    <label class="font-texto-02">
                                        <input class="form-control" type="text" id="data_inicio_relatorio" name="data_inicio_relatorio" val="">
                                    </label>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <label class="font-texto-02">Até :</label>
                                </div>

                                <div class="col-md-6 txt-center">
                                    <label class="font-texto-02">
                                        <input class="form-control" type="text" id="data_fim_relatorio" name="data_fim_relatorio" val="">
                                    </label>
                                </div>

                                <div class="col-md-3">
                                    <button type="button" id="confirmParametrosRelatorioEquipamento" class="btn btn-primary">Gerar</button>
                                </div>
                            </div>


                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">

                <!-- TABELA CONTENDO OS USUÁRIOS CADASTRADOS -->
                <div class="panel panel-default">
                    <div class="panel-heading">
                    </diV>
                    <div class="panel-body">
                        <table id="stream_table" class='table table-striped table-bordered'>
                            <thead>
                                <tr>
                                    <th>Equipamento</th>
                                    <th>Modelo</th>
                                    <th>Cliente</th>
                                    <th>local</th>
                                    <!-- <th>Potencia</th>-->
                                    <!-- <th>Tipo bateria</th> -->
                                    <th class="txt-center"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    if($lista){

                                        foreach ($lista as $equipamento) {
                                ?>
                                    <tr>
                                        <td><?php echo $equipamento['tipoEquip']; ?></td>
                                        <td><?php echo $equipamento['modelo']; ?></td>
                                        <td><?php echo $equipamento['cliente']?></td>
                                        <td>
                                            <?php echo (isset($equipamento['filial'])) ? $equipamento['filial'] : "Matriz"; ?>
                                        </td>

                                        <!-- <td><?php //echo $equipamento['qnt_bateria']; ?></td> -->
                                        <!-- <td><?php //echo $equipamento['caracteristica_equip']; ?></td> -->
                                        <!-- <td><?php //echo $equipamento['tipo_bateria']; ?></td> -->
                                        <!-- <td><?php //echo $equipamento['amperagem_bateria']; ?>
                                            <a href="<?php //echo HOME_URI; ?>/grafico/opcaoVisualizacao/<?php //echo $equipamento['id'] ?>" class="link-tabela-moni">
                                                <i class="fa fa-clipboard  fa-2x "></i>
                                            </a>
                                        </td> -->
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

        <?php

    }else{
        ?>
        <div class="row">
            <div class="col-md-12">
                <!-- Titulo pagina -->
                <label class="page-header">Equipamento da Matriz / Filial não foi encontrado</label><!-- Fim Titulo pagina -->
            </div>
        </div>
        <?php
    }

?>
