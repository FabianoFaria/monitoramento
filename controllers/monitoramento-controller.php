<?php

/**
 * Classe de controle que gerencia o model
 * e a view do monitoramento
 */
class MonitoramentoController extends MainController
{
    /**
     * Funcao que gerencia a index do monitoramento
     */
    public function index ()
    {
        // Verifica se esta logado
        $this->check_login();

        // Define o titulo da pagina
        $this->title = "monitoramento";

        // Define os parametro da funcao
        $parametros = (func_num_args() >= 1) ? func_get_arg(0) : array();

        // Carrega o modelo
        $modelo         = $this->load_model('monitoramento/monitoramento-model');
        $modeloClie     = $this->load_model('cliente/cliente-model');
        $modeloEquip    = $this->load_model('equipamento/equipamento-model');

        // Carrega view
        require_once EFIPATH . "/views/_includes/header.php";
        require_once EFIPATH . "/views/_includes/menu.php";
        require_once EFIPATH . "/views/monitoramento/monitoramento-view.php";
        require_once EFIPATH . "/views/_includes/footer.php";
    }


    /**
     * unidades
     *
     * Funcao que monta a lista da matriz e suas filiais
     *
     * @accss public
     */
    public function unidades ()
    {
        // Verifica se esta logado
        $this->check_login();

        // Define o titulo da pagina
        $this->title = "monitoramento";

        // Define os parametro da funcao
        $parametros = (func_num_args() >= 1) ? func_get_arg(0) : array();

        // Carrega o modelo
        $modelo         = $this->load_model('monitoramento/monitoramento-model');
        $modeloEquip    = $this->load_model('equipamento/equipamento-model');
        $modeloClie     = $this->load_model('cliente/cliente-model');

        // Carrega view
        require_once EFIPATH . "/views/_includes/header.php";
        require_once EFIPATH . "/views/_includes/menu.php";
        require_once EFIPATH . "/views/monitoramento/monitoramentoListaFilial-view.php";
        require_once EFIPATH . "/views/_includes/footer.php";
    }


    /**
     * listaEquipamento
     *
     * Funcao que monta a lista de equipamento da unidade ou matriz
     *
     * @accss public
     */
    public function listaEquipamento ()
    {
        // Verifica se esta logado
        $this->check_login();

        // Define o titulo da pagina
        $this->title = "monitoramento";

        // Define os parametro da funcao
        $parametros = (func_num_args() >= 1) ? func_get_arg(0) : array();

        // Carrega o modelo
        $modelo = $this->load_model('monitoramento/monitoramento-model');

        // Carrega view
        require_once EFIPATH . "/views/_includes/header.php";
        require_once EFIPATH . "/views/_includes/menu.php";
        require_once EFIPATH . "/views/monitoramento/monitoramentoListaEquipamento-view.php";
        require_once EFIPATH . "/views/_includes/footer.php";
    }



    /**
     * Funcao de Gerador de grafico
     * mostra o grafico de barra ou analogico
     */
    public function gerarGrafico ()
    {
        // Verifica se esta login
        $this->check_login();

        // Define o titulo da pagina
        $this->title = "monitoramento";

        // Define os parametro da funcao
        $parametros = (func_num_args() >= 1) ? func_get_arg(0) : array();

        // Carrega o modelo
        $modelo         = $this->load_model('monitoramento/monitoramento-model');
        // Carrega os dados do equipamento
        $modeloEquip    = $this->load_model('equipamento/equipamento-model');

        // Carrega view
        require_once EFIPATH . "/views/_includes/header.php";
        require_once EFIPATH . "/views/_includes/menu.php";

        // Carrega a lista inicial de dados do grafico linha
        require_once EFIPATH . "/classes/sincronizacaoGrafico/listaInicial.php";

        // Inicia class da Lista inical
        //ESTE METODO TAMBEM PASSOU POR REFORMULAÇÕES
        // $limite     = 30;
        //$listaIni   = new ListaInicial($limite, $this->db, $this->parametros);

        // Carregando a view
        //require_once EFIPATH . "/views/monitoramento/monitoramentoGerarGrafico-view_back_up.php";
        require_once EFIPATH . "/views/monitoramento/monitoramentoGerarGrafico-view.php";
        require_once EFIPATH . "/views/_includes/footer.php";
    }

}

?>
