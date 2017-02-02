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

 }

 ?>
