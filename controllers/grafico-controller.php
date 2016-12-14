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
        $this->title = "Grafico";

        // Define os parametro da funcao
        $parametros = (func_num_args() >= 1) ? func_get_arg(0) : array();

        // Carrega o modelo para este view
        $modelo = $this->load_model('grafico/grafico-model');

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
        $this->title = "Grafico";

        // Define os parametro da funcao
        $parametros = (func_num_args() >= 1) ? func_get_arg(0) : array();

        // Carrega o modelo para este view
        $modelo = $this->load_model('grafico/graficoListaFilial-model');

        // Carrega view
        require_once EFIPATH . "/views/_includes/header.php";
        require_once EFIPATH . "/views/_includes/menu.php";
        require_once EFIPATH . "/views/grafico/graficoListaFilial-view.php";
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
        $this->title = "Grafico";

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
        $this->title = "Grafico";

        // Define os parametro da funcao
        $parametros = (func_num_args() >= 1) ? func_get_arg(0) : array();

        // Carrega o modelo para este view
        $modelo = $this->load_model('grafico/graficoOpcaoVisualizacao-model');

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
        $this->title = "Grafico";

        // Define os parametro da funcao
        $parametros = (func_num_args() >= 1) ? func_get_arg(0) : array();

        // Carrega o modelo para este view
        $modelo = $this->load_model('grafico/graficoGerador-model');

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
         $this->title = "Grafico";

         // Define os parametro da funcao
         $parametros = (func_num_args() >= 1) ? func_get_arg(0) : array();

         // Carrega o modelo para este view
         $modelo = $this->load_model('grafico/grafico-model');

         // Carrega view
         require_once EFIPATH . "/views/_includes/header.php";
         require_once EFIPATH . "/views/_includes/menu.php";
         require_once EFIPATH . "/views/grafico/graficoFisicoGerador-view.php";
         require_once EFIPATH . "/views/_includes/footer.php";
     }
}
?>
