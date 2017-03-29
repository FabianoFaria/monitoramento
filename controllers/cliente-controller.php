<?php

/**
 * Classe de controle que gerencia
 * o model e a view dos clientes
 */
 class ClienteController extends MainController
 {

    public function index ()
    {
        // Verifica se esta logado
        $this->check_login();

        //VERIFICAÇÂO SE USUÁRIO TEM AUTORIZAÇÃO PARA ACESSAR CLIENTES
        if($_SESSION['userdata']['per_ca'] != 1){
            // Se nao possuir
            // Redireciona para index
            $this->moveHome();
        }else{
            // Define o titulo da pagina
            $this->title = "cliente";

            // Define os parametro da funcao
            $parametros = (func_num_args() >= 1) ? func_get_arg(0) : array();

            // CARREGA O MODELO DE USUÁRIO PARA CONTROLE DE LOGIN
            $modelo         = $this->load_model('usuario/usuario-model');
            // CARREGA O MODELO PARA ESTE VIEW
            $clienteModelo  = $this->load_model('cliente/cliente-model');

            // Carrega view
            require_once EFIPATH . "/views/_includes/header.php";
            require_once EFIPATH . "/views/_includes/menu.php";
            require_once EFIPATH . "/views/cliente/clienteLista-view.php";
            require_once EFIPATH . "/views/_includes/footer.php";
        }
    }

    public function cadastrar(){

        // Verifica o login
        $this->check_login();

        // Verifica as permissoes necessarias
        if ($_SESSION['userdata']['per_ca'] != 1 )
        {
            // Se nao possuir
            // Redireciona para index
            $this->moveHome();
        }else{

            // Define o titulo da pagina
            $this->title = "cliente";

            // Carrega os parametro da funcao
            $parametros = (func_num_args() >= 1) ? func_get_arg(0) : array();

            // Carrega o modelo para este view
            $modelo     = $this->load_model('cliente/cliente-model');

            // Carrega view
            require_once EFIPATH . "/views/_includes/header.php";
            require_once EFIPATH . "/views/_includes/menu.php";
            require_once EFIPATH . "/views/cliente/cadastrarCliente-view.php";
            require_once EFIPATH . "/views/_includes/footer.php";
        }

    }

    /*
    * REGISTRAR FILIAL DO CLIENTE JSON
    */
    public function cadastrarFilialClienteJson(){
        // CARREGA O MODELO PARA ESTE VIEW/OPERAÇÃO
        $filialModelo      = $this->load_model('filial/filial-model');

        $registraFilial     = $filialModelo->registroFilial($_POST['nomeFilial'], $_POST['dddFilial'], $_POST['telefoneFili'], $_POST['cepFilial'], $_POST['enderecoFilial'], $_POST['numeroFili'], $_POST['bairroFili'], $_POST['cidadeFili'], $_POST['estadosFili'], $_POST['paisFili'], $_POST['idCliente']);

        exit(json_encode(array('status' => $registraFilial['status'])));

    }

    /*
    * FUNÇÃO PARA CARREGAR DADOS DA FILIAL
    */
    public function carregarFilialClienteJson(){

        // CARREGA O MODELO PARA ESTE VIEW/OPERAÇÃO
        $filialModelo      = $this->load_model('filial/filial-model');

        $dadosFilial       = $filialModelo->filialEspecificaCliente($_POST['idFilail']);

        if(!empty($dadosFilial)){

            $dados          = array();

            $dados['id']        = $dadosFilial[0]['id'];
            $dados['estado']    = $dadosFilial[0]['id_estado'];
            $dados['pais']      = $dadosFilial[0]['id_pais'];
            $dados['nome']      = html_entity_decode($dadosFilial[0]['nome'], ENT_COMPAT, 'UTF-8');
            $dados['endereco']  = html_entity_decode($dadosFilial[0]['endereco'], ENT_COMPAT, 'UTF-8');
            $dados['numero']    = html_entity_decode($dadosFilial[0]['numero'], ENT_COMPAT, 'UTF-8');
            $dados['cep']       = html_entity_decode($dadosFilial[0]['cep'], ENT_COMPAT, 'UTF-8');
            $dados['cidade']    = html_entity_decode($dadosFilial[0]['cidade'], ENT_COMPAT, 'UTF-8');
            $dados['bairro']    = html_entity_decode($dadosFilial[0]['bairro'], ENT_COMPAT, 'UTF-8');
            $dados['ddd']       = html_entity_decode($dadosFilial[0]['ddd'], ENT_COMPAT, 'UTF-8');
            $dados['telefone']  = html_entity_decode($dadosFilial[0]['telefone'], ENT_COMPAT, 'UTF-8');

            exit(json_encode(array('status' => true, 'filial' => $dados)));
        }else{
            exit(json_encode(array('status' => false, 'filial' => '')));
        }
    }

    /*
    * CARREGAR FILIAIS DE ACORDO COM O CLIENTE VIA AUTOCOMPLETE VIA JSON
    */
    public function carregarListaFilialAutoCompleteJson(){

        // CARREGA O MODELO PARA ESTE VIEW/OPERAÇÃO
        $clienteModelo  = $this->load_model('cliente/cliente-model');

        $dadosFiliais   = $clienteModelo->carregarFiliaisAutoCompleteCliente($_GET['filtroClie'], $_GET['term']);

        if(!empty($dadosFiliais['status'])){

            $filiArry = array();

            $lista = $dadosFiliais['filiais'];

            foreach ($lista as $fili) {

                $filial = array('id' => $fili['id'], 'label' => html_entity_decode($fili['nome']));

                array_push($filiArry, $filial);
            }

            // $teste = json_encode($filiArry);
            // var_dump($teste);

            exit(json_encode($filiArry));
        }else{
            exit(json_encode(array('status' => false, 'filiais' => '')));
        }


    }

    /*
    * CARREGAR EQUIPAMENTOS E FILIAIS VIA JSON
    */
    public function carregarListaFilialClienteJson(){

        // CARREGA O MODELO PARA ESTE VIEW/OPERAÇÃO
        $clienteModelo  = $this->load_model('cliente/cliente-model');
        $equipeModelo   = $this->load_model('equipamento/equipamento-model');

        $dadosFiliais   = $clienteModelo->carregarFiliaisCliente($_POST['idCliente']);
        $dadosEquips    = $equipeModelo->listarEquipamentosCliente($_POST['idCliente']);

        //MONTA A TABELA DE EQUIPAMENTOS
        $listaEquip          = $dadosEquips['equipamentos'];

        $tabela         = "";
        $tabela         .="<thead><tr>
                            <th>Equipamento</th>
                            <th>Modelo</th>
                            <th>Unidade</th>
                            <th class='txt-center'>Monitorar</th>
                            </tr></thead>";

        if(!empty($dadosFiliais['status'])){

            //MONTA A LISTA PARA O SELECT
            $lista = "";
                $lista .= "<option value='0'> Matriz </option>";
            foreach ($dadosFiliais['filiais'] as $filial) {

                $idClie     = $filial['id'];
                $nomeFili   = $filial['nome'];

                $lista .= "<option value='".$idClie."'>".$nomeFili."</option>";
            }

            if($listaEquip){
                $tabela         .="<tbody>";

                foreach ($listaEquip as $equip) {

                    $tabela         .="<tr>";

                        $tabela         .="<td>";
                            $tabela     .= html_entity_decode($equip['tipoEquip']);
                        $tabela         .="</td>";
                        $tabela         .="<td>";
                            $tabela     .=html_entity_decode($equip['nomeModeloEquipamento']);
                        $tabela         .="</td>";
                        $tabela         .="<td>";
                            $tabela     .= (isset($equip['filial'])) ? html_entity_decode($equip['filial']) : "Matriz";
                        $tabela         .="</td>";
                        $tabela         .="<td>";
                            $link       = HOME_URI."/monitoramento/gerarGrafico/".$equip['id']."";
                            $tabela     .= "<a href='".$link."'><i class='fa fa-picture-o fa-2x'></i></a>";
                        $tabela         .="</td>";

                    $tabela         .="</tr>";
                }

                $tabela         .="</tbody>";

            }else{
                $tabela         .="<tbody>";
                    $tabela         .="<tr>";
                        $tabela         .="<td colspan='4'>Nenhum equipamento cadastrado até o momento</td>";
                    $tabela         .="</tr>";
                $tabela         .="</tbody>";

            }

            exit(json_encode(array('status' => true, 'filiais' => $lista, 'equipamentos' => $tabela)));
        }else{
            //GERA LISTA DE SELECT VAZIA
            $lista = "<option value='0'> Matriz </option>";

            if($listaEquip){
                $tabela         .="<tbody>";

                foreach ($listaEquip as $equip) {

                    $tabela         .="<tr>";

                        $tabela         .="<td>";
                            $tabela     .= html_entity_decode($equip['tipoEquip']);
                        $tabela         .="</td>";
                        $tabela         .="<td>";
                            $tabela     .=html_entity_decode($equip['nomeModeloEquipamento']);
                        $tabela         .="</td>";
                        $tabela         .="<td>";
                            $tabela     .= (isset($equip['filial'])) ? html_entity_decode($equip['filial']) : "Matriz";
                        $tabela         .="</td>";
                        $tabela         .="<td>";
                            $link       = HOME_URI."/monitoramento/gerarGrafico/".$equip['id']."";
                            $tabela     .= "<a href='".$link."'><i class='fa fa-picture-o fa-2x'></i></a>";
                        $tabela         .="</td>";

                    $tabela         .="</tr>";
                }

                $tabela         .="</tbody>";

            }else{
                $tabela         .="<tbody>";
                    $tabela         .="<tr>";
                        $tabela         .="<td colspan='4'>Nenhum equipamento cadastrado até o momento</td>";
                    $tabela         .="</tr>";
                $tabela         .="</tbody>";

            }

            exit(json_encode(array('status' => false, 'filiais' => $lista, 'equipamentos' => $tabela)));
        }
    }

    /*
    * CARREGAR EQUIPAMENTOS E FILIAIS VIA JSON PARA RELATORIOS
    */
    public function carregarListaFilialClienteRelatoriosJson(){
        // CARREGA O MODELO PARA ESTE VIEW/OPERAÇÃO
        $clienteModelo  = $this->load_model('cliente/cliente-model');
        $equipeModelo   = $this->load_model('equipamento/equipamento-model');

        $dadosFiliais   = $clienteModelo->carregarFiliaisCliente($_POST['idCliente']);
        $dadosEquips    = $equipeModelo->listarEquipamentosCliente($_POST['idCliente']);

        if(!empty($dadosFiliais['status'])){

            //MONTA A LISTA PARA O SELECT
            $lista = "";
            $lista .= "<option value='0'> Matriz </option>";
            foreach ($dadosFiliais['filiais'] as $filial) {

                $idClie     = $filial['id'];
                $nomeFili   = $filial['nome'];

                $lista .= "<option value='".$idClie."'>".$nomeFili."</option>";
            }

            //MONTA A TABELA DE EQUIPAMENTOS
            $listaEquip          = $dadosEquips['equipamentos'];

            $tabela         = "";
            $tabela         .="<thead><tr>
                                <th>Equipamento</th>
                                <th>Modelo</th>
                                <th>Unidade</th>
                                <th class='txt-center'>Monitorar</th>
                                </tr></thead>";

            if($listaEquip){
                $tabela         .="<tbody>";

                foreach ($listaEquip as $equip) {

                    $tabela         .="<tr>";

                        $tabela         .="<td>";
                            $tabela     .=html_entity_decode($equip['tipoEquip']);
                        $tabela         .="</td>";
                        $tabela         .="<td>";
                            $tabela     .=html_entity_decode($equip['nomeModeloEquipamento']);
                        $tabela         .="</td>";
                        $tabela         .="<td>";
                            $tabela     .= (isset($equip['filial'])) ? html_entity_decode($equip['filial']) : "Matriz";
                        $tabela         .="</td>";
                        $tabela         .="<td>";
                            $link       = HOME_URI."/grafico/opcaoVisualizacao/".$equip['id']."";
                            $tabela     .= "<a href='".$link."'><i class='fa fa-clipboard fa-2x'></i></a>";
                        $tabela         .="</td>";

                    $tabela         .="</tr>";
                }

                $tabela         .="</tbody>";

            }else{
                $tabela         .="<tbody>";
                    $tabela         .="<tr>";
                        $tabela         .="<td colspan='4'>Nenhum equipamento cadastrado até o momento</td>";
                    $tabela         .="</tr>";
                $tabela         .="</tbody>";

            }

            exit(json_encode(array('status' => true, 'filiais' => $lista, 'equipamentos' => $tabela)));
        }else{
            //GERA LISTA DE SELECT VAZIA
            $lista = "<option value='0'> Matriz </option>";

            //GERA TABELA VAZIA
            $tabela         ="<thead><tr>
                                <th>Equipamento</th>
                                <th>Modelo</th>
                                <th>Unidade</th>
                                <th class='txt-center'>Monitorar</th>
                                </tr></thead>";
            $tabela         .="<tbody>";
                $tabela         .="<tr>";
                    $tabela         .="<td colspan='4'>Nenhum equipamento cadastrado até o momento</td>";
                $tabela         .="</tr>";
            $tabela         .="</tbody>";

            exit(json_encode(array('status' => false, 'filiais' => $lista, 'equipamentos' => $tabela)));
        }
    }

    /*
    * CARREGA EQUIPAMENTOS E FILIAIS DE ACORDO COM O CLIENTE PARA ESTATISTICAS
    */
    public function carregarListaFilialClienteEstatisticaJson(){
        // CARREGA O MODELO PARA ESTE VIEW/OPERAÇÃO
        $clienteModelo  = $this->load_model('cliente/cliente-model');
        $equipeModelo   = $this->load_model('equipamento/equipamento-model');

        $dadosFiliais   = $clienteModelo->carregarFiliaisCliente($_POST['idCliente']);
        $dadosEquips    = $equipeModelo->listarEquipamentosCliente($_POST['idCliente']);

        //MONTA A TABELA DE EQUIPAMENTOS
        $listaEquip          = $dadosEquips['equipamentos'];

        $tabela         = "";
        $tabela         .="<thead><tr>
                            <th>Equipamento</th>
                            <th>Modelo</th>
                            <th>Unidade</th>
                            <th class='txt-center'>Relatôrio</th>
                            </tr></thead>";

        if(!empty($dadosFiliais['status'])){

            //MONTA A LISTA PARA O SELECT
            $lista = "";
                $lista .= "<option value='0'> Matriz </option>";
            foreach ($dadosFiliais['filiais'] as $filial) {

                $idClie     = $filial['id'];
                $nomeFili   = $filial['nome'];

                $lista .= "<option value='".$idClie."'>".$nomeFili."</option>";
            }

            if($listaEquip){
                $tabela         .="<tbody>";

                foreach ($listaEquip as $equip) {

                    $tabela         .="<tr>";

                        $tabela         .="<td>";
                            $tabela     .=html_entity_decode($equip['tipoEquip']);
                        $tabela         .="</td>";
                        $tabela         .="<td>";
                            $tabela     .=html_entity_decode($equip['nomeModeloEquipamento']);
                        $tabela         .="</td>";
                        $tabela         .="<td>";
                            $tabela     .= (isset($equip['filial'])) ? html_entity_decode($equip['filial']) : "Matriz";
                        $tabela         .="</td>";
                        $tabela         .="<td>";
                            $link       = HOME_URI."/grafico/graficoFisicoParametrosEquipamentoCliente/".$equip['id']."";
                            $tabela     .= "<a href='".$link."'><i class='fa fa-list-alt  fa-2x'></i></a>";
                        $tabela         .="</td>";

                    $tabela         .="</tr>";
                }

                $tabela         .="</tbody>";

            }else{
                $tabela         .="<tbody>";
                    $tabela         .="<tr>";
                        $tabela         .="<td colspan='4'>Nenhum equipamento cadastrado até o momento</td>";
                    $tabela         .="</tr>";
                $tabela         .="</tbody>";

            }

            exit(json_encode(array('status' => true, 'filiais' => $lista, 'equipamentos' => $tabela)));
        }else{
            //GERA LISTA DE SELECT VAZIA
            $lista = "<option value='0'> Matriz </option>";

            //GERA TABELA DE EQUIPAMENTOS
            if($listaEquip){
                $tabela         .="<tbody>";

                foreach ($listaEquip as $equip) {

                    $tabela         .="<tr>";

                        $tabela         .="<td>";
                            $tabela     .=html_entity_decode($equip['tipoEquip']);
                        $tabela         .="</td>";
                        $tabela         .="<td>";
                            $tabela     .=html_entity_decode($equip['nomeModeloEquipamento']);
                        $tabela         .="</td>";
                        $tabela         .="<td>";
                            $tabela     .= (isset($equip['filial'])) ? html_entity_decode($equip['filial']) : "Matriz";
                        $tabela         .="</td>";
                        $tabela         .="<td>";
                            $link       = HOME_URI."/grafico/graficoFisicoParametrosEquipamentoCliente/".$equip['id']."";
                            $tabela     .= "<a href='".$link."'><i class='fa fa-list-alt  fa-2x'></i></a>";
                        $tabela         .="</td>";

                    $tabela         .="</tr>";
                }

                $tabela         .="</tbody>";

            }else{
                $tabela         .="<tbody>";
                    $tabela         .="<tr>";
                        $tabela         .="<td colspan='4'>Nenhum equipamento cadastrado até o momento</td>";
                    $tabela         .="</tr>";
                $tabela         .="</tbody>";

            }

            exit(json_encode(array('status' => false, 'filiais' => $lista, 'equipamentos' => $tabela)));
        }
    }

    /*
    * CARREGA EQUIPAMENTOS E FILIAIS DE ACORDO COM O CLIENTE PARA ALARMES DETALHADOS
    */
    public function carregarListaFilialClienteAlarmesDetalhados(){

        // CARREGA O MODELO PARA ESTE VIEW/OPERAÇÃO
        $clienteModelo  = $this->load_model('cliente/cliente-model');
        $equipeModelo   = $this->load_model('equipamento/equipamento-model');

        $dadosFiliais   = $clienteModelo->carregarFiliaisCliente($_POST['idCliente']);
        $dadosEquips    = $equipeModelo->listarEquipamentosCliente($_POST['idCliente']);

        if(!empty($dadosFiliais['status'])){

            //MONTA A LISTA PARA O SELECT
            $lista = "";
                $lista .= "<option value='0'> Matriz </option>";
            foreach ($dadosFiliais['filiais'] as $filial) {

                $idClie     = $filial['id'];
                $nomeFili   = $filial['nome'];

                $lista .= "<option value='".$idClie."'>".$nomeFili."</option>";
            }

            //MONTA A TABELA DE EQUIPAMENTOS
            $listaEquip          = $dadosEquips['equipamentos'];

            $tabela         = "";
            $tabela         .="<thead><tr>
                                <th>Equipamento</th>
                                <th>Modelo</th>
                                <th>Unidade</th>
                                <th class='txt-center'>Relatôrio alarmes</th>
                                </tr></thead>";

            if($listaEquip){
                $tabela         .="<tbody>";

                foreach ($listaEquip as $equip) {

                    $tabela         .="<tr>";

                        $tabela         .="<td>";
                            $tabela     .=html_entity_decode($equip['tipoEquip']);
                        $tabela         .="</td>";
                        $tabela         .="<td>";
                            $tabela     .=html_entity_decode($equip['nomeModeloEquipamento']);
                        $tabela         .="</td>";
                        $tabela         .="<td>";
                            $tabela     .= (isset($equip['filial'])) ? html_entity_decode($equip['filial']) : "Matriz";
                        $tabela         .="</td>";
                        $tabela         .="<td>";
                            $link       = HOME_URI."/grafico/graficoFisicoParametrosEquipamentoAlarmeDetalhado/".$equip['id']."";
                            $tabela     .= "<a href='".$link."'><i class='fa fa-list-alt  fa-2x'></i></a>";
                        $tabela         .="</td>";

                    $tabela         .="</tr>";
                }

                $tabela         .="</tbody>";
            }else{
                $tabela         .="<tbody>";
                    $tabela         .="<tr>";
                        $tabela         .="<td colspan='4'>Nenhum equipamento cadastrado até o momento</td>";
                    $tabela         .="</tr>";
                $tabela         .="</tbody>";
            }

            exit(json_encode(array('status' => true, 'filiais' => $lista, 'equipamentos' => $tabela)));
        }else{
            //GERA LISTA DE SELECT VAZIA
            $lista = "<option value='0'> Matriz </option>";

            //GERA TABELA VAZIA
            $tabela         ="<thead><tr>
                                <th>Equipamento</th>
                                <th>Modelo</th>
                                <th>Unidade</th>
                                <th class='txt-center'>Estatistica</th>
                                </tr></thead>";
            $tabela         .="<tbody>";
                $tabela         .="<tr>";
                    $tabela         .="<td colspan='4'>Nenhum equipamento cadastrado até o momento</td>";
                $tabela         .="</tr>";
            $tabela         .="</tbody>";

            exit(json_encode(array('status' => false, 'filiais' => $lista, 'equipamentos' => $tabela)));
        }

    }

    /*
    * CARREGAR EQUIPAMENTOS DE FILIAL ESPECIFICA VIA JSON PARA ALARMES DETALHADOS
    */
    public function carregarListaEquipamentoFilialAlarmeDetalhadoJson(){
        // CARREGA O MODELO PARA ESTE VIEW/OPERAÇÃO
        $equipeModelo   = $this->load_model('equipamento/equipamento-model');
        $clienteModelo  = $this->load_model('cliente/cliente-model');

        $dadosEquips    = $equipeModelo->listarEquipamentosFilialCliente($_POST['idCliente'], $_POST['idFilial']);
        $dadosFiliais   = $clienteModelo->carregarFiliaisCliente($_POST['idCliente']);


        if(!empty($dadosEquips['status'])){

            //MONTA A TABELA DE EQUIPAMENTOS
            $listaEquip          = $dadosEquips['equipamentos'];

            $tabela         = "";
            $tabela         .="<thead><tr>
                                <th>Equipamento</th>
                                <th>Modelo</th>
                                <th>Unidade</th>
                                <th class='txt-center'>Alarmes detalhados</th>
                                </tr></thead>";
            if($listaEquip){
                $tabela         .="<tbody>";
                    foreach ($listaEquip as $equip) {

                        $tabela         .="<tr>";

                            $tabela         .="<td>";
                                $tabela     .=html_entity_decode($equip['tipoEquip']);
                            $tabela         .="</td>";
                            $tabela         .="<td>";
                                $tabela     .=html_entity_decode($equip['nomeModeloEquipamento']);
                            $tabela         .="</td>";
                            $tabela         .="<td>";
                                $tabela     .= (isset($equip['filial'])) ? html_entity_decode($equip['filial']) : "Matriz";
                            $tabela         .="</td>";
                            $tabela         .="<td>";
                                $link       = HOME_URI."/grafico/graficoFisicoParametrosEquipamentoAlarmeDetalhado/".$equip['id']."";
                                $tabela     .= "<a href='".$link."'><i class='fa fa-list-alt fa-2x'></i></a>";
                            $tabela         .="</td>";

                        $tabela         .="</tr>";
                    }
                $tabela         .="</tbody>";
            }else{
                $tabela         .="<tbody>";
                    $tabela         .="<tr>";
                        $tabela         .="<td colspan='4'>Nenhum equipamento cadastrado até o momento</td>";
                    $tabela         .="</tr>";
                $tabela         .="</tbody>";
            }

            if(!empty($dadosFiliais['status'])){
                //MONTA A LISTA PARA O SELECT
                $lista = "";
                    $lista .= "<option value='0'> Matriz </option>";
                foreach ($dadosFiliais['filiais'] as $filial) {

                    $idClie     = $filial['id'];
                    $nomeFili   = $filial['nome'];

                    $lista .= "<option value='".$idClie."'>".$nomeFili."</option>";
                }
            }else{
                $lista = "";
                    $lista .= "<option value='0'> Matriz </option>";
            }

            exit(json_encode(array('status' => true, 'equipamentos' => $tabela, 'filiais' => $lista)));
        }else{
            //GERA TABELA VAZIA
            $tabela         ="<thead><tr>
                                <th>Equipamento</th>
                                <th>Modelo</th>
                                <th>Unidade</th>
                                <th class='txt-center'>Estatisticas</th>
                                </tr></thead>";
            $tabela         .="<tbody>";
                $tabela         .="<tr>";
                    $tabela         .="<td colspan='4'>Nenhum equipamento cadastrado até o momento</td>";
                $tabela         .="</tr>";
            $tabela         .="</tbody>";

            if(!empty($dadosFiliais['status'])){
                //MONTA A LISTA PARA O SELECT
                $lista = "";
                    $lista .= "<option value='0'> Matriz </option>";
                foreach ($dadosFiliais['filiais'] as $filial) {

                    $idClie     = $filial['id'];
                    $nomeFili   = $filial['nome'];

                    $lista .= "<option value='".$idClie."'>".$nomeFili."</option>";
                }
            }else{
                $lista = "";
                    $lista .= "<option value='0'> Matriz </option>";
            }

            //exit(json_encode(array('status' => false, 'equipamentos' => $tabela)));
            exit(json_encode(array('status' => false, 'equipamentos' => $tabela, 'filiais' => $lista)));
        }

    }

    /*
    * CARREGAR EQUIPAMENTOS DE FILIAL ESPECIFICA VIA JSON
    */
    public function carregarListaEquipamentoFilialJson(){

        // CARREGA O MODELO PARA ESTE VIEW/OPERAÇÃO
        $equipeModelo   = $this->load_model('equipamento/equipamento-model');

        $dadosEquips    = $equipeModelo->listarEquipamentosFilialCliente($_POST['idCliente'], $_POST['idFilial']);

        if(!empty($dadosEquips['status'])){

            //MONTA A TABELA DE EQUIPAMENTOS
            $listaEquip          = $dadosEquips['equipamentos'];

            $tabela         = "";
            $tabela         .="<thead><tr>
                                <th>Equipamento</th>
                                <th>Modelo</th>
                                <th>Unidade</th>
                                <th class='txt-center'>Monitorar</th>
                                </tr></thead>";
            if($listaEquip){

                $tabela         .="<tbody>";
                    foreach ($listaEquip as $equip) {

                        $tabela         .="<tr>";

                            $tabela         .="<td>";
                                $tabela     .=html_entity_decode($equip['tipoEquip']);
                            $tabela         .="</td>";
                            $tabela         .="<td>";
                                $tabela     .=html_entity_decode($equip['nomeModeloEquipamento']);
                            $tabela         .="</td>";
                            $tabela         .="<td>";
                                $tabela     .= (isset($equip['filial'])) ? html_entity_decode($equip['filial']) : "Matriz";
                            $tabela         .="</td>";
                            $tabela         .="<td>";
                                $link       = HOME_URI."/monitoramento/gerarGrafico/".$equip['id']."";
                                $tabela     .= "<a href='".$link."'><i class='fa fa-picture-o fa-2x'></i></a>";
                            $tabela         .="</td>";

                        $tabela         .="</tr>";
                    }
                $tabela         .="</tbody>";


            }else{
                $tabela         .="<tbody>";
                    $tabela         .="<tr>";
                        $tabela         .="<td colspan='4'>Nenhum equipamento cadastrado até o momento</td>";
                    $tabela         .="</tr>";
                $tabela         .="</tbody>";
            }
            exit(json_encode(array('status' => true, 'equipamentos' => $tabela)));
        }else{

            //GERA TABELA VAZIA
            $tabela         ="<thead><tr>
                                <th>Equipamento</th>
                                <th>Modelo</th>
                                <th>Unidade</th>
                                <th class='txt-center'>Monitorar</th>
                                </tr></thead>";
            $tabela         .="<tbody>";
                $tabela         .="<tr>";
                    $tabela         .="<td colspan='4'>Nenhum equipamento cadastrado até o momento</td>";
                $tabela         .="</tr>";
            $tabela         .="</tbody>";

            exit(json_encode(array('status' => false, 'equipamentos' => $tabela)));
        }

    }

    /*
    * CARREGAR EQUIPAMENTOS DE FILIAL ESPECIFICA VIA JSON PARA RELATÔRIOS
    */
    public function carregarListaEquipamentoFilialRelatoriosJson(){
        // CARREGA O MODELO PARA ESTE VIEW/OPERAÇÃO
        $equipeModelo   = $this->load_model('equipamento/equipamento-model');

        $dadosEquips    = $equipeModelo->listarEquipamentosFilialCliente($_POST['idCliente'], $_POST['idFilial']);

        if(!empty($dadosEquips['status'])){

            //MONTA A TABELA DE EQUIPAMENTOS
            $listaEquip          = $dadosEquips['equipamentos'];

            $tabela         = "";
            $tabela         .="<thead><tr>
                                <th>Equipamento</th>
                                <th>Modelo</th>
                                <th>Unidade</th>
                                <th class='txt-center'>Monitorar</th>
                                </tr></thead>";
            if($listaEquip){

                $tabela         .="<tbody>";
                    foreach ($listaEquip as $equip) {

                        $tabela         .="<tr>";

                            $tabela         .="<td>";
                                $tabela     .=html_entity_decode($equip['tipoEquip']);
                            $tabela         .="</td>";
                            $tabela         .="<td>";
                                $tabela     .=html_entity_decode($equip['nomeModeloEquipamento']);
                            $tabela         .="</td>";
                            $tabela         .="<td>";
                                $tabela     .= (isset($equip['filial'])) ? html_entity_decode($equip['filial']) : "Matriz";
                            $tabela         .="</td>";
                            $tabela         .="<td>";
                                $link       = HOME_URI."/grafico/opcaoVisualizacao/".$equip['id']."";
                                $tabela     .= "<a href='".$link."'><i class='fa fa-clipboard fa-2x'></i></a>";
                            $tabela         .="</td>";

                        $tabela         .="</tr>";
                    }
                $tabela         .="</tbody>";


            }else{
                $tabela         .="<tbody>";
                    $tabela         .="<tr>";
                        $tabela         .="<td colspan='4'>Nenhum equipamento cadastrado até o momento</td>";
                    $tabela         .="</tr>";
                $tabela         .="</tbody>";
            }
            exit(json_encode(array('status' => true, 'equipamentos' => $tabela)));
        }else{

            //GERA TABELA VAZIA
            $tabela         ="<thead><tr>
                                <th>Equipamento</th>
                                <th>Modelo</th>
                                <th>Unidade</th>
                                <th class='txt-center'>Monitorar</th>
                                </tr></thead>";
            $tabela         .="<tbody>";
                $tabela         .="<tr>";
                    $tabela         .="<td colspan='4'>Nenhum equipamento cadastrado até o momento</td>";
                $tabela         .="</tr>";
            $tabela         .="</tbody>";

            exit(json_encode(array('status' => false, 'equipamentos' => $tabela)));
        }

    }

    /*
    * CARREGAR EQUIPAMENTOS DE FILIAL ESPECIFICA VIA JSON PARA ESTATISTICAS
    */
    public function carregarListaEquipamentoFilialEstatisticaJson(){
        // CARREGA O MODELO PARA ESTE VIEW/OPERAÇÃO
        $equipeModelo   = $this->load_model('equipamento/equipamento-model');

        $dadosEquips    = $equipeModelo->listarEquipamentosFilialCliente($_POST['idCliente'], $_POST['idFilial']);

        if(!empty($dadosEquips['status'])){

            //MONTA A TABELA DE EQUIPAMENTOS
            $listaEquip          = $dadosEquips['equipamentos'];

            $tabela         = "";
            $tabela         .="<thead><tr>
                                <th>Equipamento</th>
                                <th>Modelo</th>
                                <th>Unidade</th>
                                <th class='txt-center'>Estatisticas</th>
                                </tr></thead>";
            if($listaEquip){

                $tabela         .="<tbody>";
                    foreach ($listaEquip as $equip) {

                        $tabela         .="<tr>";

                            $tabela         .="<td>";
                                $tabela     .=html_entity_decode($equip['tipoEquip']);
                            $tabela         .="</td>";
                            $tabela         .="<td>";
                                $tabela     .=html_entity_decode($equip['nomeModeloEquipamento']);
                            $tabela         .="</td>";
                            $tabela         .="<td>";
                                $tabela     .= (isset($equip['filial'])) ? html_entity_decode($equip['filial']) : "Matriz";
                            $tabela         .="</td>";
                            $tabela         .="<td>";
                                $link       = HOME_URI."/grafico/graficoFisicoParametrosEquipamentoCliente/".$equip['id']."";
                                $tabela     .= "<a href='".$link."'><i class='fa fa-list-alt fa-2x'></i></a>";
                            $tabela         .="</td>";

                        $tabela         .="</tr>";
                    }
                $tabela         .="</tbody>";


            }else{
                $tabela         .="<tbody>";
                    $tabela         .="<tr>";
                        $tabela         .="<td colspan='4'>Nenhum equipamento cadastrado até o momento</td>";
                    $tabela         .="</tr>";
                $tabela         .="</tbody>";
            }
            exit(json_encode(array('status' => true, 'equipamentos' => $tabela)));
        }else{

            //GERA TABELA VAZIA
            $tabela         ="<thead><tr>
                                <th>Equipamento</th>
                                <th>Modelo</th>
                                <th>Unidade</th>
                                <th class='txt-center'>Estatisticas</th>
                                </tr></thead>";
            $tabela         .="<tbody>";
                $tabela         .="<tr>";
                    $tabela         .="<td colspan='4'>Nenhum equipamento cadastrado até o momento</td>";
                $tabela         .="</tr>";
            $tabela         .="</tbody>";

            exit(json_encode(array('status' => false, 'equipamentos' => $tabela)));
        }

    }

    /*
    * CARREGA LISTA DE EQUIPAMENTOS POR CLIENTE, FILIAL, TIPO
    */
    public function carregarListaEquipamentoFilialTipoJson(){
        // CARREGA O MODELO PARA ESTE VIEW/OPERAÇÃO
        $equipeModelo   = $this->load_model('equipamento/equipamento-model');

        if($_POST['idCliente'] == ""){
            $idClie = 0;
        }else{
            $idClie = $_POST['idCliente'];
        }

        if($_POST['idCliente'] == ""){
            $idFili = 0;
        }else{
            $idFili = $_POST['idFilial'];
        }

        if($_POST['idTipo'] == ""){
            $idTipo = 0;
        }else{
            $idTipo = $_POST['idTipo'];
        }

        $dadosEquips    = $equipeModelo->listarEquipamentosFilialClienteTipo($idClie, $idFili, $idTipo);

        if(!empty($dadosEquips['status'])){

            //MONTA A TABELA DE EQUIPAMENTOS
            $listaEquip          = $dadosEquips['equipamentos'];

            $tabela         = "";
            $tabela         .="<thead><tr>
                                <th>Equipamento</th>
                                <th>Modelo</th>
                                <th>Unidade</th>
                                <th>Estado</th>
                                <th class='txt-center'>Monitorar</th>
                                </tr></thead>";
            if($listaEquip){
                $tabela         .="<tbody>";
                    foreach ($listaEquip as $equip) {

                        $tabela         .="<tr>";

                            $tabela         .="<td>";
                                $tabela     .=$equip['tipoEquip'];
                            $tabela         .="</td>";
                            $tabela         .="<td>";
                                $tabela     .=$equip['nomeModeloEquipamento'];
                            $tabela         .="</td>";

                            $tabela         .="<td>";
                                $tabela     .= (isset($equip['filial'])) ? $equip['filial'] : "Matriz";
                            $tabela         .="</td>";

                            $tabela         .="<td>";
                                $tabela     .=$equip['estado'];
                            $tabela         .="</td>";
                            $tabela         .="<td>";
                                $link       = HOME_URI."/monitoramento/gerarGrafico/".$equip['id']."";
                                $tabela     .= "<a href='".$link."'><i class='fa fa-picture-o fa-2x'></i></a>";
                            $tabela         .="</td>";

                        $tabela         .="</tr>";
                    }
                $tabela         .="</tbody>";
            }else{
                $tabela         .="<tbody>";
                    $tabela         .="<tr>";
                        $tabela         .="<td colspan='4'>Nenhum equipamento cadastrado até o momento</td>";
                    $tabela         .="</tr>";
                $tabela         .="</tbody>";
            }

            exit(json_encode(array('status' => true, 'equipamentos' => $tabela)));
        }else{

            //GERA TABELA VAZIA
            $tabela         ="<thead><tr>
                                <th>Equipamento</th>
                                <th>Modelo</th>
                                <th>Unidade</th>
                                <th class='txt-center'>Monitorar</th>
                                </tr></thead>";
            $tabela         .="<tbody>";
                $tabela         .="<tr>";
                    $tabela         .="<td colspan='4'>Nenhum equipamento cadastrado até o momento</td>";
                $tabela         .="</tr>";
            $tabela         .="</tbody>";

            exit(json_encode(array('status' => false, 'equipamentos' => $tabela)));
        }

    }

    /*
    * CARREGA LISTA DE EQUIPAMENTOS POR CLIENTE, FILIAL, TIPO PARA RELATÔRIOS
    */
    public function carregarListaEquipamentoFilialTipoRelatorioJson(){
        // CARREGA O MODELO PARA ESTE VIEW/OPERAÇÃO
        $equipeModelo   = $this->load_model('equipamento/equipamento-model');

        if($_POST['idCliente'] == ""){
            $idClie = 0;
        }else{
            $idClie = $_POST['idCliente'];
        }

        if($_POST['idCliente'] == ""){
            $idFili = 0;
        }else{
            $idFili = $_POST['idFilial'];
        }

        if($_POST['idTipo'] == ""){
            $idTipo = 0;
        }else{
            $idTipo = $_POST['idTipo'];
        }

        $dadosEquips    = $equipeModelo->listarEquipamentosFilialClienteTipo($idClie, $idFili, $idTipo);

        if(!empty($dadosEquips['status'])){

            //MONTA A TABELA DE EQUIPAMENTOS
            $listaEquip          = $dadosEquips['equipamentos'];

            $tabela         = "";
            $tabela         .="<thead><tr>
                                <th>Equipamento</th>
                                <th>Modelo</th>
                                <th>Unidade</th>
                                <th>Estado</th>
                                <th class='txt-center'>Monitorar</th>
                                </tr></thead>";
            if($listaEquip){
                $tabela         .="<tbody>";
                    foreach ($listaEquip as $equip) {

                        $tabela         .="<tr>";

                            $tabela         .="<td>";
                                $tabela     .=$equip['tipoEquip'];
                            $tabela         .="</td>";
                            $tabela         .="<td>";
                                $tabela     .=$equip['nomeModeloEquipamento'];
                            $tabela         .="</td>";

                            $tabela         .="<td>";
                                $tabela     .= (isset($equip['filial'])) ? $equip['filial'] : "Matriz";
                            $tabela         .="</td>";

                            $tabela         .="<td>";
                                $tabela     .=$equip['estado'];
                            $tabela         .="</td>";

                            $tabela         .="<td>";
                                $link       = HOME_URI."/grafico/opcaoVisualizacao/".$equip['id']."";
                                $tabela     .= "<a href='".$link."'><i class='fa fa-clipboard fa-2x'></i></a>";
                            $tabela         .="</td>";

                        $tabela         .="</tr>";
                    }
                $tabela         .="</tbody>";
            }else{
                $tabela         .="<tbody>";
                    $tabela         .="<tr>";
                        $tabela         .="<td colspan='4'>Nenhum equipamento cadastrado até o momento</td>";
                    $tabela         .="</tr>";
                $tabela         .="</tbody>";
            }

            exit(json_encode(array('status' => true, 'equipamentos' => $tabela)));
        }else{

            //GERA TABELA VAZIA
            $tabela         ="<thead><tr>
                                <th>Equipamento</th>
                                <th>Modelo</th>
                                <th>Unidade</th>
                                <th class='txt-center'>Monitorar</th>
                                </tr></thead>";
            $tabela         .="<tbody>";
                $tabela         .="<tr>";
                    $tabela         .="<td colspan='4'>Nenhum equipamento cadastrado até o momento</td>";
                $tabela         .="</tr>";
            $tabela         .="</tbody>";

            exit(json_encode(array('status' => false, 'equipamentos' => $tabela)));
        }

    }

    /*
    * CARREGA LISTA DE EQUIPAMENTOS POR CLIENTE, FILIAL, TIPO PARA ESTATISTICA
    */
    public function carregarListaEquipamentoFilialTipoEstatisticaJson(){
        // CARREGA O MODELO PARA ESTE VIEW/OPERAÇÃO
        $equipeModelo   = $this->load_model('equipamento/equipamento-model');

        if($_POST['idCliente'] == ""){
            $idClie = 0;
        }else{
            $idClie = $_POST['idCliente'];
        }

        if($_POST['idCliente'] == ""){
            $idFili = 0;
        }else{
            $idFili = $_POST['idFilial'];
        }

        if($_POST['idTipo'] == ""){
            $idTipo = 0;
        }else{
            $idTipo = $_POST['idTipo'];
        }

        $dadosEquips    = $equipeModelo->listarEquipamentosFilialClienteTipo($idClie, $idFili, $idTipo);

        if(!empty($dadosEquips['status'])){

            //MONTA A TABELA DE EQUIPAMENTOS
            $listaEquip          = $dadosEquips['equipamentos'];

            $tabela         = "";
            $tabela         .="<thead><tr>
                                <th>Equipamento</th>
                                <th>Modelo</th>
                                <th>Unidade</th>
                                <th>Estado</th>
                                <th class='txt-center'>Estatistica</th>
                                </tr></thead>";
            if($listaEquip){
                $tabela         .="<tbody>";
                    foreach ($listaEquip as $equip) {

                        $tabela         .="<tr>";

                            $tabela         .="<td>";
                                $tabela     .=$equip['tipoEquip'];
                            $tabela         .="</td>";
                            $tabela         .="<td>";
                                $tabela     .=$equip['nomeModeloEquipamento'];
                            $tabela         .="</td>";

                            $tabela         .="<td>";
                                $tabela     .= (isset($equip['filial'])) ? $equip['filial'] : "Matriz";
                            $tabela         .="</td>";

                            $tabela         .="<td>";
                                $tabela     .=$equip['estado'];
                            $tabela         .="</td>";

                            $tabela         .="<td>";
                                $link       = HOME_URI."/grafico/graficoFisicoParametrosEquipamentoCliente/".$equip['id']."";
                                $tabela     .= "<a href='".$link."'><i class='fa fa-list-alt fa-2x'></i></a>";
                            $tabela         .="</td>";

                        $tabela         .="</tr>";
                    }
                $tabela         .="</tbody>";
            }else{
                $tabela         .="<tbody>";
                    $tabela         .="<tr>";
                        $tabela         .="<td colspan='4'>Nenhum equipamento cadastrado até o momento</td>";
                    $tabela         .="</tr>";
                $tabela         .="</tbody>";
            }

            exit(json_encode(array('status' => true, 'equipamentos' => $tabela)));
        }else{

            //GERA TABELA VAZIA
            $tabela         ="<thead><tr>
                                <th>Equipamento</th>
                                <th>Modelo</th>
                                <th>Unidade</th>
                                <th class='txt-center'>Estatistica</th>
                                </tr></thead>";
            $tabela         .="<tbody>";
                $tabela         .="<tr>";
                    $tabela         .="<td colspan='4'>Nenhum equipamento cadastrado até o momento</td>";
                $tabela         .="</tr>";
            $tabela         .="</tbody>";

            exit(json_encode(array('status' => false, 'equipamentos' => $tabela)));
        }

    }

    /*
    * CARREGA LISTA DE EQUIPAMENTOS POR CLIENTE, FILIAL, TIPO PARA DETALHAMENTO DE ALARME
    */
    public function carregarListaEquipamentoFilialTipoAlarmeDetalheJson(){
        // CARREGA O MODELO PARA ESTE VIEW/OPERAÇÃO
        $equipeModelo   = $this->load_model('equipamento/equipamento-model');

        if($_POST['idCliente'] == ""){
            $idClie = 0;
        }else{
            $idClie = $_POST['idCliente'];
        }

        if($_POST['idCliente'] == ""){
            $idFili = 0;
        }else{
            $idFili = $_POST['idFilial'];
        }

        if($_POST['idTipo'] == ""){
            $idTipo = 0;
        }else{
            $idTipo = $_POST['idTipo'];
        }

        $dadosEquips    = $equipeModelo->listarEquipamentosFilialClienteTipo($idClie, $idFili, $idTipo);

        if(!empty($dadosEquips['status'])){

            //MONTA A TABELA DE EQUIPAMENTOS
            $listaEquip          = $dadosEquips['equipamentos'];

            $tabela         = "";
            $tabela         .="<thead><tr>
                                <th>Equipamento</th>
                                <th>Modelo</th>
                                <th>Unidade</th>
                                <th>Estado</th>
                                <th class='txt-center'>Estatistica</th>
                                </tr></thead>";

            if($listaEquip){
                $tabela         .="<tbody>";
                    foreach ($listaEquip as $equip) {

                        $tabela         .="<tr>";

                            $tabela         .="<td>";
                                $tabela     .=$equip['tipoEquip'];
                            $tabela         .="</td>";
                            $tabela         .="<td>";
                                $tabela     .=$equip['nomeModeloEquipamento'];
                            $tabela         .="</td>";
                            $tabela         .="<td>";
                                $tabela     .= (isset($equip['filial'])) ? $equip['filial'] : "Matriz";
                            $tabela         .="</td>";
                            $tabela         .="<td>";
                                $tabela     .=$equip['estado'];
                            $tabela         .="</td>";
                            $tabela         .="<td>";
                                $link       = HOME_URI."/grafico/graficoFisicoParametrosEquipamentoAlarmeDetalhado/".$equip['id']."";
                                $tabela     .= "<a href='".$link."'><i class='fa fa-list-alt fa-2x'></i></a>";
                            $tabela         .="</td>";

                        $tabela         .="</tr>";
                    }
                $tabela         .="</tbody>";
            }else{
                $tabela         .="<tbody>";
                    $tabela         .="<tr>";
                        $tabela         .="<td colspan='4'>Nenhum equipamento cadastrado até o momento</td>";
                    $tabela         .="</tr>";
                $tabela         .="</tbody>";
            }

            exit(json_encode(array('status' => true, 'equipamentos' => $tabela)));

        }else{
            //GERA TABELA VAZIA
            $tabela         ="<thead><tr>
                                <th>Equipamento</th>
                                <th>Modelo</th>
                                <th>Unidade</th>
                                <th>Estado</th>
                                </tr></thead>";
            $tabela         .="<tbody>";
                $tabela         .="<tr>";
                    $tabela         .="<td colspan='4'>Nenhum equipamento cadastrado até o momento</td>";
                $tabela         .="</tr>";
            $tabela         .="</tbody>";

            exit(json_encode(array('status' => false, 'equipamentos' => $tabela)));
        }

    }


    /*
    * SALVAR EDIÇÕES NA FILIAL
    */
    public function editarFilialClienteJson(){
        // CARREGA O MODELO PARA ESTE VIEW/OPERAÇÃO
        $filialModelo      = $this->load_model('filial/filial-model');

        $registraFilial     = $filialModelo->editarFilialJson($_POST['nomeFilial'], $_POST['dddFilial'], $_POST['telefoneFili'], $_POST['cepFilial'], $_POST['enderecoFilial'], $_POST['numeroFili'], $_POST['cidadeFili'], $_POST['bairroFili'], $_POST['estadosFili'], $_POST['paisFili'], $_POST['idFilial']);

        exit(json_encode(array('status' => $registraFilial['status'])));

    }

    /*
    * Listar filiais do cliente
    */
    public function listarFiliaisCliente(){

        // Verifica o login
        $this->check_login();

         // Verifica as permissoes necessarias
        if($_SESSION['userdata']['per_ca'] != 1 )
        {
            // Se nao possuir
            // Redireciona para index
            $this->moveHome();
        }else{

            // Define o titulo da pagina
            $this->title = "cliente";

            // Carrega os parametro da funcao
            $parametros = (func_num_args() >= 1) ? func_get_arg(0) : array();

            // Carrega o modelo para este view
            $modelo = $this->load_model('cliente/cliente-model');

            // Carrega view
            require_once EFIPATH . "/views/_includes/header.php";
            require_once EFIPATH . "/views/_includes/menu.php";
            require_once EFIPATH . "/views/filial/filialCliente-view.php";
            require_once EFIPATH . "/views/_includes/footer.php";
        }

    }

    /*
    * EDITAR CLIENTE
    */
    public function editarCliente($id){

        // Verifica o login
        $this->check_login();

        // Verifica as permissoes necessarias
        if ($_SESSION['userdata']['per_ca'] != 1 )
        {
            // Se nao possuir
            // Redireciona para index
            $this->moveHome();
        }else{

            // Define o titulo da pagina
            $this->title = "cliente";

            // Carrega os parametro da funcao
            $parametros = (func_num_args() >= 1) ? func_get_arg(0) : array();

            // Carrega o modelo para este view
            $modelo     = $this->load_model('cliente/cliente-model');

            // Carrega view
            require_once EFIPATH . "/views/_includes/header.php";
            require_once EFIPATH . "/views/_includes/menu.php";
            require_once EFIPATH . "/views/cliente/editarCliente-view.php";
            require_once EFIPATH . "/views/_includes/footer.php";
        }

    }

    /*
    * FUNÇÕES PARA TRATAR DAS OPERAÇÕES VIA JSON
    */

    public function registrarClientes(){

        // CARREGA O MODELO PARA ESTE VIEW/OPERAÇÃO
        $clienteModelo      = $this->load_model('cliente/cliente-model');

        $registraClienteBd  = $clienteModelo->cadastrarClienteJson($_POST['nome_cliente'], $_POST['ddd'], $_POST['telefone'], $_POST['cep'], $_POST['endereco'], $_POST['numero'], $_POST['bairro'], $_POST['cidade'], $_POST['estado'], $_POST['pais'], $_FILES);

        if($registraClienteBd['status']){
            exit(json_encode(array('status' => $registraClienteBd['status'], 'idCliente' => $registraClienteBd['idCliente'])));
        }else{
            exit(json_encode(array('status' => $registraClienteBd['status'], 'idCliente' => $registraClienteBd['idCliente'])));
        }

    }

    /*
    * FUNÇÕES PARA TRATAR ATUALIZAR O CLIENTE
    */

    public function registrarEdicaoCliente(){

        // CARREGA O MODELO PARA ESTE VIEW/OPERAÇÃO
        $clienteModelo      = $this->load_model('cliente/cliente-model');

        $atualizarClientes  = $clienteModelo->atualizarClienteJson($_POST['idCliente'], $_POST['nome_cliente'], $_POST['ddd'], $_POST['telefone'], $_POST['cep'], $_POST['endereco'], $_POST['numero'], $_POST['bairro'], $_POST['cidade'], $_POST['estado'], $_POST['pais']);

        if($atualizarClientes['status']){
            exit(json_encode(array('status' => true)));
        }else{
            exit(json_encode(array('status' => false)));
        }
    }

    /*
    * FUNÇÃO PARA RECUPERAR AS FILIAIS DO CLIENTES CASO EXISTAM
    */

    public function listarFiliaisClienteJson(){

        // CARREGA O MODELO PARA ESTE VIEW/OPERAÇÃO
        $clienteModelo      = $this->load_model('cliente/cliente-model');

        $filiaisCliente     = $clienteModelo->carregarFiliaisCliente($_POST['idCliente']);

        $filiaisClienteHtml = "";

        if($filiaisCliente['status']){

            $filiaisClienteHtml .= "<option value='0'>Selecione a filial</option>";

            foreach ($filiaisCliente['filiais'] as $filiais) {

                $filiaisClienteHtml .= "<option value='".$filiais['id']."'>".$filiais['nome']."</option>";

            }

            exit(json_encode(array('status' => true, 'filiais' => $filiaisClienteHtml)));
        }else{

            $filiaisClienteHtml = "<option value='0'>Não há filiais cadastradas </option>";

            exit(json_encode(array('status' => false, 'filiais' => $filiaisClienteHtml)));
        }

    }

    /*
    * FUNÇÃO PARA REMOVER CLIENTE DO SISTEMA
    */
    public function excluirClienteJson(){
        // CARREGA O MODELO PARA ESTE VIEW/OPERAÇÃO
        $clienteModelo          = $this->load_model('cliente/cliente-model');

        $clienteRemovidoJSON    = $clienteModelo->excluirClienteViaJson($_POST['idCliente']);

        if($clienteRemovidoJSON['status']){
            exit(json_encode(array('status' => true)));
        }else{
            exit(json_encode(array('status' => false)));
        }
    }
 }

 ?>
