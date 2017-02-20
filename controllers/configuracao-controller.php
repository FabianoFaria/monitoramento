<?php

/**
 * Classe de controle que gerencia
 * a View e o model das configuracoes
 */
class ConfiguracaoController extends MainController
{
    /**
     * Funcao indexa das configuracoes
     */
    public function index()
    {
        // Verifica se esta logado
        $this->check_login();

        // Verifica as permissoes necessarias
        if ($_SESSION['userdata']['per_co'] == 1 )
        {
            // Define o titulo da pagina
            $this->title = "Configuracao";

            // Define os parametros da funcao
            $parametros = (func_num_args() >= 1) ? func_get_arg(0) : array();

            // Carrega o model
            $modelo = $this->load_model('configuracao/configuracao-model');

            // Carrega a view
            require_once EFIPATH . "/views/_includes/header.php";
            require_once EFIPATH . "/views/_includes/menu.php";
            require_once EFIPATH . "/views/configuracao/configuracao-view.php";
            require_once EFIPATH . "/views/_includes/footer.php";
        }
        else
        {
            // Se nao possuir permissao
            // Redireciona para index
            $this->moveHome();
        }
    }

    /**
     * Funcao que gerencia os parametros
     */
    public function parametro ()
    {
        // Verifica se esta logado
        $this->check_login();

        // Verifica as permissoes necessarias
        if ($_SESSION['userdata']['per_co'] == 1 )
        {
            // Define titulo da pagina
            $this->title = "Configuracao";

            // Define os parametro da funcao
            $parametros = (func_num_args() >= 1) ? func_get_arg(0) : array();

            // Carrega o modelo
            $modelo = $this->load_model('configuracao/configuracao-model');

            // Carrega a view
            require_once EFIPATH . "/views/_includes/header.php";
            require_once EFIPATH . "/views/_includes/menu.php";
            require_once EFIPATH . "/views/configuracao/configuracaoParametro-view.php";
            require_once EFIPATH . "/views/_includes/footer.php";
        }
        else
        {
            // Se nao possuir permissao
            // Redireciona para index
            $this->moveHome();
        }
    }


    /**
     * listaClienteFilial
     *
     * Busca o modelo e a view da lista de filial
     *
     * @access public
     */
    public function listaClienteFilial ()
    {
        // Verifica se esta logado
        $this->check_login();

        // Verifica as permissoes necessarias
        if ($_SESSION['userdata']['per_co'] == 1 )
        {
            // Define titulo da pagina
            $this->title = "Configuracao";

            // Define os parametro da funcao
            $parametros = (func_num_args() >= 1) ? func_get_arg(0) : array();

            // Carrega o modelo
            $modelo = $this->load_model('configuracao/configuracao-model');

            // Carrega a view
            require_once EFIPATH . "/views/_includes/header.php";
            require_once EFIPATH . "/views/_includes/menu.php";
            require_once EFIPATH . "/views/configuracao/configuracaoListaFilial-view.php";
            require_once EFIPATH . "/views/_includes/footer.php";
        }
        else
        {
            // Se nao possuir permissao
            // Redireciona para index
            $this->moveHome();
        }
    }


    /**
     * listaEquipamento
     *
     * Busca o modelo e a view da lista de filial
     *
     * @access public
     */
    public function listaEquipamento ()
    {
        // Verifica se esta logado
        $this->check_login();

        // Verifica as permissoes necessarias
        if ($_SESSION['userdata']['per_co'] == 1 )
        {
            // Define titulo da pagina
            $this->title = "Configuracao";

            // Define os parametro da funcao
            $parametros = (func_num_args() >= 1) ? func_get_arg(0) : array();

            // Carrega o modelo
            $modelo = $this->load_model('configuracao/configuracao-model');

            // Carrega a view
            require_once EFIPATH . "/views/_includes/header.php";
            require_once EFIPATH . "/views/_includes/menu.php";
            require_once EFIPATH . "/views/configuracao/configuracaoListaEquipamento-view.php";
            require_once EFIPATH . "/views/_includes/footer.php";
        }
        else
        {
            // Se nao possuir permissao
            // Redireciona para index
            $this->moveHome();
        }
    }


    /*
    *  CARREGA A VIEW DE CONFIGURAÇÃO DO EQUIPAMENTO SELECIONADO
    */
    public function configurarEquipamentoCliente()
    {
        // VERIFICA SE ESTA LOGADO
        $this->check_login();

        // VERIFICA AS PERMISSOES NECESSARIAS
        if ($_SESSION['userdata']['per_ed'] != 1 )
        {
            // SE NAO POSSUIR PERMISSAO
            // REDIRECIONA PARA INDEX
            $this->moveHome();
        }else
        {
            //DEFINE O TITULO DA PAGINA
            $this->title = "configuracao";

            // DEFINE OS PARAMETRO DA FUNCAO
            $parametros = (func_num_args() >= 1) ? func_get_arg(0) : array();

            // CARREGA O MODELO PARA ESTE VIEW
            $modelo         = $this->load_model('configuracao/configuracao-model');
            $modeloEquip    = $this->load_model('equipamento/equipamento-model');
            $modeloClie     = $this->load_model('cliente/cliente-model');
            $modeloAlarm    = $this->load_model('alarme/alarme-model');

            // CARREGA A VIEW
            require_once EFIPATH . "/views/_includes/header.php";
            require_once EFIPATH . "/views/_includes/menu.php";
            require_once EFIPATH . "/views/configuracao/configuracaoParametro-view.php";
            require_once EFIPATH . "/views/_includes/footer.php";

        }

    }

    /*
    * Efetua o cadastro da configuração do equipamento
    */
    public function cadastrarConfiguracaoEquipamentoJson()
    {
        // CARREGA O MODELO PARA ESTE VIEW/OPERAÇÃO
        $modelConfiguracao = $this->load_model('configuracao/configuracao-model');

        $configuracaoSalva = $modelConfiguracao->cadastrarConfiguracaoEquip($_POST['parametros'], $_POST['id_sim_equipamento'], $_POST['id_equipamento'], $_POST['numeroSim']);

        if($configuracaoSalva['status']){
            exit(json_encode(array('status' => true)));
        }else{
            exit(json_encode(array('status' => false)));
        }
    }

    /*
    * Efetua a atualização da configuração do equipamento
    */
    public function editarConfiguracaoEquipamentoJson()
    {
        // CARREGA O MODELO PARA ESTE VIEW/OPERAÇÃO
        $modelConfiguracao = $this->load_model('configuracao/configuracao-model');

        $configuracaoAtualizada = $modelConfiguracao->editarConfiguracaoEquip($_POST['idParametros'], $_POST['parametros'], $_POST['id_sim_equipamento'], $_POST['id_equipamento'], $_POST['numeroSim']);

        if($configuracaoAtualizada['status']){
            exit(json_encode(array('status' => true)));
        }else{
            exit(json_encode(array('status' => false)));
        }

    }


    /*
    *  Trata as strings dos valores das configurações dos equipamento
    */
    public function trataValor($valor){

        //Formato da string esperado : 'et1-2-0'
        $temp = explode('-', $valor);
        return str_replace('.',',',$temp[1]);
    }

}

?>
