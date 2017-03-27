<?php
    if (! defined('EFIPATH')) exit;

    /*
    * VERIFICA O TIPO DE USUÁRIO E EFETUA AS RESPECTIVAS OPERAÇÕE
    */
    switch ($_SESSION['userdata']['tipo_usu']) {
        case 'Administrador':

            $dadosCliente   = $modeloClie->carregarDadosClienteEquipamento($this->parametros[0]);

            if($dadosCliente['status']){
                $dadosCliente   = $dadosCliente['dados'][0];

                $idClienteForm  = $dadosCliente['id'];

                $lista          = $modeloEquip->dadosEquipamentoCliente($this->parametros[0]);
                $lista          = $lista['equipamento'];
                $nomeCliente    = $dadosCliente['nome'];

                $listaContatosEquio = $modeloEquip->dadosContatosEquipamentos($this->parametros[0]);
            }else{
                $lista          = false;
            }
            $filiaisCliente     = $modeloClie->carregarFiliaisCliente($this->parametros[0]);

        break;
        case 'Tecnico':
        break;
        case 'Cliente':
            //RECEBE O PARAMETRO DO CLIENTE E VERIFICA SE O USUÁRIO TEM ACESSO E ELE
            $usuarioAutorizado  = false;
            $idcliente = $_SESSION['userdata']['cliente'];
            $usuariosCliente  = $modeloClie->carregarDadosClienteEquipamento($this->parametros[0]);

            //VERIFICA SE O USUAÁRIO PERTENCE AO CLIENTE QUE ESTÁ TENTANDO ACESSAR
            if($usuariosCliente['status']){

                foreach ($usuariosCliente['dados'] as $usuarioCliente){

                    if(intval($usuarioCliente['id']) == $idcliente){
                        $usuarioAutorizado  = true;
                    }
                }
            }

            if($usuarioAutorizado){
                $dadosCliente   = $modeloClie->carregarDadosCliente($idcliente);

                if($dadosCliente['status']){
                    $dadosCliente   = $dadosCliente['dados'][0];

                    $idClienteForm  = $idcliente;

                    $lista          = $modeloEquip->dadosEquipamentoCliente($this->parametros[0]);
                    $lista          = $lista['equipamento'];
                    $nomeCliente    = $dadosCliente['nome'];
                }else{
                    $lista          = false;
                }
            }else{
                $lista          = false;
            }

            $filiaisCliente     = $modeloClie->carregarFiliaisCliente($this->parametros[0]);

        break;
        case 'Visitante':
        break;
    }

    if($filiaisCliente['status']){
        $filiais = $filiaisCliente['filiais'];
    }else{
        $filiais = 0;
    }

    //var_dump($lista);

?>

<script type="text/javascript">
    // gerenciador de link
    var menu = document.getElementById('listadir');
    menu.innerHTML = '<a href="<?php echo HOME_URI; ?>/home/" class="linkMenuSup">Home</a> / <a href="<?php echo HOME_URI; ?>/alarme/alarmePorEquipamento" class="linkMenuSup">Alarmes por equipamento </a> / <a href="<?php echo HOME_URI; ?>/equipamento/gerenciarContatosEquipamentos/<?php echo $this->parametros[0]; ?>"> Cliente :<?php echo $nomeCliente; ?> - Equipamento : <?php echo $lista[0]['tipoEquip']." ".$lista[0]['nomeModeloEquipamento'];?></a>';
</script>


<!-- formulario de contatos -->
<div class="row">
    <div id="painelCadastro" class="col-lg-12">

        <!-- TITULO PAGINA -->
        <label class="page-header">Gerenciar recebimento de alarmes por equipamento</label><!-- Fim Titulo pagina -->

        <!-- TABELA CONTENDO TODOS OS CLIENTES -->
        <div class="panel panel-default">
            <div class="panel-heading">
                <a role="button" data-toggle="collapse" data-parent="#painelCadastro" href="" aria-expanded="true" aria-controls="collapseOne">
                  <i class="fa fa-user-md "></i> Cadastrar novo contato para alarme
                </a>
            </div>
            <div id="collapseCadastro" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
            <div class="panel-body">
                <!-- formulario de cadastro -->
                <form id="novoContatoAlarme" method="post">
                    <div class="row">

                        <input id="idMatriz" name="idMatriz" type="hidden" value="<?php echo $lista[0]['id_cliente']; ?>">
                        <input id="idFilial" name="idFilial" type="hidden" value="<?php echo $lista[0]['id_filial']; ?>">
                        <input id="idEquipamento" name="idEquipamento" type="hidden" value="<?php echo $this->parametros[0]; ?>" />

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Selecione o local do contato : </label>
                                <select class="form-control" id="sedeContato" name="sedeContato">
                                    <option value=" "> Selecione a matriz ou filial</option>
                                    <?php
                                        if($filiais !=0){
                                            echo "<option value='0'> Matriz </option>";
                                            foreach ($filiais as $filial) {
                                                echo "<option value='".$filial['id']."'> ".$filial['nome']." </option>";
                                            }
                                        }else{
                                            echo "<option value='0'> Contato matriz </option>";
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Nome do contato : </label>
                                <input type="text" class="form-control" id="txt_nomeContato" name="txt_nomeContato" placeholder="Nome para contato" maxlength="80" value="">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Função : </label>
                                <input type="text" class="form-control" id="txt_funcao" name="txt_funcao" placeholder="Função do contato" maxlength="80" value="">
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Email : </label>
                                <input type="text" class="form-control" id="txt_email" name="txt_email" placeholder="Email do contato" maxlength="80" value="">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Celular : </label>
                                <input type="text" class="form-control" id="txt_celular" name="txt_celular" placeholder="Celular do contato" maxlength="80" value="">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Observações : </label>
                                <textarea id="txt_obs" name="txt_obs" class="form-control" ></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">

                        </div>
                        <div class="col-md-4">
                            <button type="button" id="registrarContato" class="btn btn-info">Registrar contato para contato</button>
                        </div>
                    </div>
                </form>
            </dis>
        </div>

    </div>
</div>


<!-- Contatos de alarme já cadastrados -->
<div class="row">
    <div class="col-lg-12">
        <!-- TABELA CONTENDO TODOS OS CLIENTES -->
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-md-6">
                        <h5>
                            Contatos já cadastrados
                        </h5>
                    </div>
                    <div class="col-md-6">
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class='table-responsive'>
                        <table id="stream_table_contatos" class='table table-striped table-bordered'>
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Função</th>
                                    <th>Email</th>
                                    <th>Celular</th>
                                    <th>Cliente</th>
                                    <th>Local</th>
                                    <th class="txt-center">Editar</th>
                                    <th class="txt-center">Excluir</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                    if($listaContatosEquio['status']){

                                    }else{
                                        ?>
                                            <tr>
                                                <td colspan='8'>
                                                    Nenhum contato cadastrado no momento
                                                </td>
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
</div>

<?php

    var_dump($lista);

 ?>
