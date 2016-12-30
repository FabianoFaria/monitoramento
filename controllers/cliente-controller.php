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

    public function cadastrar(){

        // Verifica o login
        $this->check_login();

        // Verifica as permissoes necessarias
        if ($_SESSION['userdata']['local'] != 1 && $_SESSION['userdata']['per_ca'] != 1 )
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

    //Listar filiais do cliente

    public function listarFiliaisCliente(){

        // Verifica o login
        $this->check_login();

         // Verifica as permissoes necessarias
        if ($_SESSION['userdata']['local'] != 1 && $_SESSION['userdata']['per_ca'] != 1 )
        {
            // Se nao possuir
            // Redireciona para index
            $this->moveHome();
        }else{

            // Define o titulo da pagina
            $this->title = "filial";

            // Carrega os parametro da funcao
            $parametros = (func_num_args() >= 1) ? func_get_arg(0) : array();

            // Carrega o modelo para este view
            $modelo     = $this->load_model('cliente/cliente-model');

            // Carrega view
            require_once EFIPATH . "/views/_includes/header.php";
            require_once EFIPATH . "/views/_includes/menu.php";
            require_once EFIPATH . "/views/filial/filialCliente-view.php";
            require_once EFIPATH . "/views/_includes/footer.php";
        }

    }

    //Editar cliente

    public function editarCliente($id){

        // Verifica o login
        $this->check_login();

        // Verifica as permissoes necessarias
        if ($_SESSION['userdata']['local'] != 1 && $_SESSION['userdata']['per_ca'] != 1 )
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

    //Funções para tratar das operações via JSON

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

    //Funções para tratar atualizar o cliente

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

    //Função para recuperar as filiais do clientes caso existam

    public function listarFiliaisClienteJson(){

        // CARREGA O MODELO PARA ESTE VIEW/OPERAÇÃO
        $clienteModelo      = $this->load_model('cliente/cliente-model');

        $filiaisCliente     = $clienteModelo->carregarFiliaisCliente($_POST['idCliente']);

        $filiaisClienteHtml = "<option value='0'>Não há filiais cadastradas </option>";

        if($filiaisCliente['status']){

            $filiaisClienteHtml = "<option value='0'>Selecione a filial</option>";

            foreach ($filiaisCliente['filiais'] as $filiais) {
                
                $filiaisClienteHtml .= "<option value='".$filiais['id']."'>".$filiais['nome']."</option>";

            }

            exit(json_encode(array('status' => true, 'filiais' => $filiaisClienteHtml)));
        }else{
            exit(json_encode(array('status' => false, 'filiais' => $filiaisClienteHtml)));
        }

    }

 }

 ?>
