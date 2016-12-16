<?php

/**
 * Classe de controle que gerencia
 * o model e a view da home
 */
class HomeController extends MainController
{
    /**
     * Funcao que gerencia o index da home
     */
    public function index()
    {
        // Verifica se esta logado
        $this->check_login();

        // Define o titulo da pagina
        $this->title = "Home";

        // Define os parametro da funcao
        $parametros = (func_num_args() >= 1) ? func_get_arg(0) : array();

        // Carrega modelo
        $modelo         = $this->load_model('home/home-model');
        $modeloCliente  = $this->load_model('cliente/cliente-model');
        $modeloFilial   = $this->load_model('filial/filial-model');

        // Carrega view
        require_once EFIPATH . "/views/_includes/header.php";
        require_once EFIPATH . "/views/_includes/menu.php";

        // Verifica se o cliente eh externo ou interno
        if (($_SESSION['userdata']['local'] == 1) || ($_SESSION['userdata']['cliente'] == 0))
            // Chama view cliente interno
            require_once EFIPATH . "/views/home/home-view.php";
        else{
            // Chama view para cliente
            require_once EFIPATH . "/views/home/homeCliente-view.php";

        }

        require_once EFIPATH . "/views/_includes/footer.php";
    }

    /**
     * Funcao que gerencia as definecoes graficas
     */
    public function definicoesGrafico ()
    {
        // Verifica se esta logado
        $this->check_login();

        // Define o titulo da pagina
        $this->title = "Monitoramento Home";

        // Define os parametro da funcao
        $parametros = (func_num_args() >= 1) ? func_get_arg(0) : array();

        // Carrega modelo
        $modelo = $this->load_model('home/home-model');

        // Verifca se eh um usuario interno
        if ($_SESSION['userdata']['local'] != 0 )
        {
            // Se nao possuir permissao
            // Redireciona para index
            $this->moveHome();
        }
        else
        {
            // Carrega view
            require_once EFIPATH . "/views/_includes/header.php";
            require_once EFIPATH . "/views/_includes/menu.php";
            require_once EFIPATH . "/views/home/homeDefinicoesGrafico-view.php";
            require_once EFIPATH . "/views/_includes/footer.php";
        }
    }

    /**
     * Funcao que gerencia a gerecao do grafico
     */
    public function grafico ()
    {
        // Verifica se esta logado
        $this->check_login();

        // Define o titulo da pagina
        $this->title = "Monitoramento Home";

        // Define os parametro da funcao
        $parametros = (func_num_args() >= 1) ? func_get_arg(0) : array();

        // Carrega modelo
        $modelo = $this->load_model('home/home-model');

        // Verifca se eh um usuario interno
        if ($_SESSION['userdata']['local'] != 0 )
        {
            // Se nao possuir permissao
            // Redireciona para index
            $this->moveHome();
        }
        else
        {
            /* carrega view */
            require_once EFIPATH . "/views/_includes/header.php";
            require_once EFIPATH . "/views/_includes/menu.php";

            /* arquivo que carrega a lista inicial de dados do grafico */
            require_once EFIPATH . "/classes/sincronizacaoGrafico/listaInicial.php";

            // Inicia class da Lista inical
            $limite = 30;
            $listaIni = new ListaInicial($limite,$this->db,$this->parametros[0]);

            require_once EFIPATH . "/views/home/homeGerarGrafico-view.php";
            require_once EFIPATH . "/views/_includes/footer.php";
        }
    }
}

?>
