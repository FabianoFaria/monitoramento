<?php

/**
 * GraficoController
 *
 * Controle que gerencia o model e a view do grafico
 */
class GraficoController extends MainController
{
    /**
     * index
     *
     * Funcao inicial que carrega
     *
     * @access public
     */
    public function index ()
    {
        // Verifica se esta logado
        $this->check_login();

        //Define o titulo da pagina
        $this->title = "grafico";

        // Define os parametro da funcao
        $parametros = (func_num_args() >= 1) ? func_get_arg(0) : array();

        // Carrega o modelo para este view
        $modelo         = $this->load_model('grafico/grafico-model');
        $modeloEquip    = $this->load_model('equipamento/equipamento-model');
        $modeloClie     = $this->load_model('cliente/cliente-model');

        // Carrega view
        require_once EFIPATH . "/views/_includes/header.php";
        require_once EFIPATH . "/views/_includes/menu.php";
        require_once EFIPATH . "/views/grafico/grafico-view.php";
        require_once EFIPATH . "/views/_includes/footer.php";
    }


    /**
     * listaFilial
     *
     * Controle que gerencia o modelo e a view da lista de filiais
     *
     * @access public
     */
    public function listaFilial ()
    {
        // Verifica se esta logado
        $this->check_login();

        //Define o titulo da pagina
        $this->title = "grafico";

        // Define os parametro da funcao
        $parametros = (func_num_args() >= 1) ? func_get_arg(0) : array();

        // Carrega o modelo para este view
        $modelo         = $this->load_model('grafico/graficoListaFilial-model');
        $modeloClie     = $this->load_model('cliente/cliente-model');
        $modeloEquip    = $this->load_model('equipamento/equipamento-model');

        // Carrega view
        require_once EFIPATH . "/views/_includes/header.php";
        require_once EFIPATH . "/views/_includes/menu.php";
        require_once EFIPATH . "/views/grafico/graficoListaEquipamento-view.php";
        require_once EFIPATH . "/views/_includes/footer.php";
    }


    /**
     * listaEquipamento
     *
     * Controle responsavel por gerencia o modelo e a view
     * da listagem dos equipamentos
     *
     * @access public
     */
    public function listaEquipamento ()
    {
        // Verifica se esta logado
        $this->check_login();

        //Define o titulo da pagina
        $this->title = "grafico";

        // Define os parametro da funcao
        $parametros = (func_num_args() >= 1) ? func_get_arg(0) : array();

        // Carrega o modelo para este view
        $modelo = $this->load_model('grafico/graficoListaEquipamento-model');

        // Carrega view
        require_once EFIPATH . "/views/_includes/header.php";
        require_once EFIPATH . "/views/_includes/menu.php";
        require_once EFIPATH . "/views/grafico/graficoListaEquipamento-view.php";
        require_once EFIPATH . "/views/_includes/footer.php";
    }

    /*
    * FUNÇÃO PARA LISTAR OS EQUIPAMENTOS ALOCADOS PARA O CLIENTE E SUAS RESPECTIVAS FILIAIS
    */
    public function graficoFisicoEquipamentoCliente(){

        // Verifica se esta logado
        $this->check_login();

        // Verifica as permissoes necessarias
        if ($_SESSION['userdata']['local'] != 1 && $_SESSION['userdata']['per_ca'] != 1 )
        {
            // Se nao possuir
            // Redireciona para index
            $this->moveHome();
        }else{

            //DEFINE O TITULO DA PAGINA
            $this->title = "grafico";

            // DEFINE OS PARAMETRO DA FUNCAO
            $parametros = (func_num_args() >= 1) ? func_get_arg(0) : array();

            // Carrega o modelo para este view
            $modelo         = $this->load_model('grafico/graficoOpcaoVisualizacao-model');
            $modeloClie     = $this->load_model('cliente/cliente-model');
            $modeloEquip    = $this->load_model('equipamento/equipamento-model');

            // Carrega view
            require_once EFIPATH . "/views/_includes/header.php";
            require_once EFIPATH . "/views/_includes/menu.php";
            require_once EFIPATH . "/views/grafico/graficoParametrosRelatorio-view.php";
            require_once EFIPATH . "/views/_includes/footer.php";
        }
    }

    /*
    * FUNÇÃO PARA CARREGAR TELA DE PARAMENTROS DE ESTATISTICA PARA EQUIPAMENTO SELECIONADO
    */
    public function graficoFisicoParametrosEquipamentoCliente(){

        // Verifica se esta logado
        $this->check_login();

        // Verifica as permissoes necessarias
        if ($_SESSION['userdata']['local'] != 1 && $_SESSION['userdata']['per_ca'] != 1 )
        {
            // Se nao possuir
            // Redireciona para index
            $this->moveHome();
        }else{
            //DEFINE O TITULO DA PAGINA
            $this->title = "grafico";

            // DEFINE OS PARAMETRO DA FUNCAO
            $parametros = (func_num_args() >= 1) ? func_get_arg(0) : array();

            // Carrega o modelo para este view
            $modelo         = $this->load_model('grafico/graficoOpcaoVisualizacao-model');
            $modeloClie     = $this->load_model('cliente/cliente-model');
            $modeloEquip    = $this->load_model('equipamento/equipamento-model');

            // Carrega view
            require_once EFIPATH . "/views/_includes/header.php";
            require_once EFIPATH . "/views/_includes/menu.php";
            require_once EFIPATH . "/views/grafico/graficoFisicoEquipamentoParametroRelatorio-view.php";
            require_once EFIPATH . "/views/_includes/footer.php";
        }
    }

    /**
     * opcaoVisualizacao
     *
     * Controle que gerenia o modelo e a view das opcoes de contrução do grafico
     *
     * @access public
     */
    public function opcaoVisualizacao ()
    {
        // Verifica se esta logado
        $this->check_login();

        //Define o titulo da pagina
        $this->title = "grafico";

        // Define os parametro da funcao
        $parametros = (func_num_args() >= 1) ? func_get_arg(0) : array();

        // Carrega o modelo para este view
        $modelo         = $this->load_model('grafico/graficoOpcaoVisualizacao-model');
        $modeloClie     = $this->load_model('cliente/cliente-model');
        $modeloEquip    = $this->load_model('equipamento/equipamento-model');

        // Carrega view
        require_once EFIPATH . "/views/_includes/header.php";
        require_once EFIPATH . "/views/_includes/menu.php";
        require_once EFIPATH . "/views/grafico/graficoOpcaoVisualizacao-view.php";
        require_once EFIPATH . "/views/_includes/footer.php";
    }

    /**
     * graficoGerador
     *
     * Funcao que gera o grafico de linha
     *
     * @access public
     */
    public function graficoGerador()
    {
        // Verifica se esta logado
        $this->check_login();

        //Define o titulo da pagina
        $this->title = "grafico";

        // Define os parametro da funcao
        $parametros = (func_num_args() >= 1) ? func_get_arg(0) : array();

        // Carrega o modelo para este view
        $modelo         = $this->load_model('grafico/graficoGerador-model');
        $modeloEquip    = $this->load_model('equipamento/equipamento-model');
        $modeloClie     = $this->load_model('cliente/cliente-model');

        // Carrega view
        require_once EFIPATH . "/views/_includes/header.php";
        require_once EFIPATH . "/views/_includes/menu.php";
        require_once EFIPATH . "/views/grafico/graficoGerador-view.php";
        require_once EFIPATH . "/views/_includes/footer.php";
    }

    /**
     * graficoFisicoGerador
     *
     * Funcao que gera o grafico de em tabelas para impressão
     *
     * @access public
     */
     public function graficoFisicoGerador()
     {
         // Verifica se esta logado
         $this->check_login();

         //Define o titulo da pagina
         $this->title = "grafico";

         // Define os parametro da funcao
         $parametros = (func_num_args() >= 1) ? func_get_arg(0) : array();

         // Carrega o modelo para este view
         $modelo        = $this->load_model('grafico/grafico-model');
         $modeloClie    = $this->load_model('cliente/cliente-model');
         $modeloEquip   = $this->load_model('equipamento/equipamento-model');

         // Carrega view
         require_once EFIPATH . "/views/_includes/header.php";
         require_once EFIPATH . "/views/_includes/menu.php";
         require_once EFIPATH . "/views/grafico/graficoFisicoGerador-view.php";
         require_once EFIPATH . "/views/_includes/footer.php";
     }


     /*
     * Carrega a view e os dados de acordo com o cliente e data selecionados
     */
     public function  gerarRelatorioCliente(){

        // Verifica se esta logado
        $this->check_login();

        // Verifica as permissoes necessarias
        if ($_SESSION['userdata']['local'] != 1 && $_SESSION['userdata']['per_ca'] != 1 )
        {
            // Se nao possuir
            // Redireciona para index
            $this->moveHome();
        }else{

            //DEFINE O TITULO DA PAGINA
            $this->title = "grafico";

            // DEFINE OS PARAMETRO DA FUNCAO
            $parametros = (func_num_args() >= 1) ? func_get_arg(0) : array();

            // Carrega o modelo para este view
            $modelo         = $this->load_model('grafico/graficoOpcaoVisualizacao-model');
            $modeloClie     = $this->load_model('cliente/cliente-model');
            $modeloEquip    = $this->load_model('equipamento/equipamento-model');
            $modeloAlarme   = $this->load_model('alarme/alarme-model');

            // Carrega view
            require_once EFIPATH . "/views/_includes/header.php";
            require_once EFIPATH . "/views/_includes/menu.php";
            require_once EFIPATH . "/views/grafico/graficoFisicoVisualizador-view.php";
            require_once EFIPATH . "/views/_includes/footer.php";
        }

     }

     /*
     * CARREGAR OS DADOS E A TELA DO RELATORIO ESTATISTICO DE DETERMINADO EQUIPAMENTO DO CLIENTE
     */
     public function gerarRelatorioEquipamentoCliente(){
         // Verifica se esta logado
         $this->check_login();

         // Verifica as permissoes necessarias
         if ($_SESSION['userdata']['local'] != 1 && $_SESSION['userdata']['per_ca'] != 1 )
         {
             // Se nao possuir
             // Redireciona para index
             $this->moveHome();

         }else{
             //DEFINE O TITULO DA PAGINA
             $this->title = "grafico";

             // DEFINE OS PARAMETRO DA FUNCAO
             $parametros = (func_num_args() >= 1) ? func_get_arg(0) : array();

             // Carrega o modelo para este view
             $modelo         = $this->load_model('grafico/graficoOpcaoVisualizacao-model');
             $modeloClie     = $this->load_model('cliente/cliente-model');
             $modeloEquip    = $this->load_model('equipamento/equipamento-model');
             $modeloAlarme   = $this->load_model('alarme/alarme-model');

             // Carrega view
             require_once EFIPATH . "/views/_includes/header.php";
             require_once EFIPATH . "/views/_includes/menu.php";
             require_once EFIPATH . "/views/grafico/graficoFisicoVisualizador-view.php";
             require_once EFIPATH . "/views/_includes/footer.php";
         }

     }

     /*
     * Carrega os dados necessarios e a viem para o relatôrio de impresão
     */
    public function exibirImpressaoRelatorio(){

        // Verifica se esta logado
        $this->check_login();

        // Verifica as permissoes necessarias
        if ($_SESSION['userdata']['local'] != 1 && $_SESSION['userdata']['per_ca'] != 1 )
        {
            // Se nao possuir
            // Redireciona para index
            $this->moveHome();
        }else{

            //DEFINE O TITULO DA PAGINA
            $this->title = "grafico";

            // DEFINE OS PARAMETRO DA FUNCAO
            $parametros = (func_num_args() >= 1) ? func_get_arg(0) : array();

            // Carrega o modelo para este view
            $modelo         = $this->load_model('grafico/graficoOpcaoVisualizacao-model');
            $modeloClie     = $this->load_model('cliente/cliente-model');
            $modeloEquip    = $this->load_model('equipamento/equipamento-model');
            $modeloAlarme   = $this->load_model('alarme/alarme-model');

            require_once EFIPATH . "/views/grafico/visualizadorGraficoImpressao-view.php";

        }

    }

    /*
    * CARREGA OS DADOS NECESSARIOS E A VIEM PARA O RELATÔRIO DO EQUIPAMENTO -  IMPRESÃO
    */
    public function exibirImpressaoRelatorioEquipamento(){
        // Verifica se esta logado
        $this->check_login();

        // Verifica as permissoes necessarias
        if ($_SESSION['userdata']['local'] != 1 && $_SESSION['userdata']['per_ca'] != 1 )
        {
            // Se nao possuir
            // Redireciona para index
            $this->moveHome();
        }else{

            //DEFINE O TITULO DA PAGINA
            $this->title = "grafico";

            // DEFINE OS PARAMETRO DA FUNCAO
            $parametros = (func_num_args() >= 1) ? func_get_arg(0) : array();

            // Carrega o modelo para este view
            $modelo         = $this->load_model('grafico/graficoOpcaoVisualizacao-model');
            $modeloClie     = $this->load_model('cliente/cliente-model');
            $modeloEquip    = $this->load_model('equipamento/equipamento-model');
            $modeloAlarme   = $this->load_model('alarme/alarme-model');

            require_once EFIPATH . "/views/grafico/visualizadorGraficoEquipamentoImpressao-view.php";

        }

    }

    /*
    * CARREGA OS DADOS NECESSARIOS PARA TRAZER OS ALARMES COM DETALHES DE TRATAMENTO
    */
    public function graficoTratamentoAlarme(){

        // Verifica se esta logado
        $this->check_login();

        // Verifica as permissoes necessarias
        if ($_SESSION['userdata']['local'] != 1 && $_SESSION['userdata']['per_ca'] != 1 )
        {
            // Se nao possuir
            // Redireciona para index
            $this->moveHome();

        }else{

            //DEFINE O TITULO DA PAGINA
            $this->title = "grafico";

            // DEFINE OS PARAMETRO DA FUNCAO
            $parametros = (func_num_args() >= 1) ? func_get_arg(0) : array();

            // Carrega o modelo para este view
            $modeloClie     = $this->load_model('cliente/cliente-model');
            $modeloEquip    = $this->load_model('equipamento/equipamento-model');
            $modeloAlarme   = $this->load_model('alarme/alarme-model');

            // Carrega view
            require_once EFIPATH . "/views/_includes/header.php";
            require_once EFIPATH . "/views/_includes/menu.php";
            require_once EFIPATH . "/views/grafico/graficoFisicoVisualizador-view.php";
            require_once EFIPATH . "/views/_includes/footer.php";

        }

    }
}
?>
