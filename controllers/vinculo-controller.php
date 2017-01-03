<?php

/**
 * Classe de controle que gerencia
 * o model e a view do vinculo
 */
class VinculoController extends MainController
{
    /**
     * Funcao que gerencia o index do vinculo
     */
    public function index()
    {
        // Verifica se esta logado
        $this->check_login();

        // Verifica as permissoes necessarias
        if ($_SESSION['userdata']['local'] != 1 && $_SESSION['userdata']['per_vi'] != 1 )
        {
            // Se nao possuir permissao
            // Redireciona para index
            $this->moveHome();
        }
        else
        {
            // Define o titulo da pagina
            $this->title = "Vinculo";

            // Define os parametro da funcao
            $parametros = (func_num_args() >= 1) ? func_get_arg(0) : array();

            // Carrega o modelo
            $modelo = $this->load_model('vinculo/vinculo-model');

            // Carrega view
            require_once EFIPATH . "/views/_includes/header.php";
            require_once EFIPATH . "/views/_includes/menu.php";
            require_once EFIPATH . "/views/vinculo/vinculo-view.php";
            require_once EFIPATH . "/views/_includes/footer.php";
        }
    }

    /*
    * Função para listar vinculos de um cliente
    */
    public function gerenciarVinculo(){

        // Verifica se esta logado
        $this->check_login();

        // Verifica as permissoes necessarias
        if ($_SESSION['userdata']['local'] != 1 && $_SESSION['userdata']['per_vi'] != 1 )
        {
            // Se nao possuir permissao
            // Redireciona para index
            $this->moveHome();
        }else{

            // Define o titulo da pagina
            $this->title = "vinculo";

            // Carrega o modelo
            $modeloCliente  = $this->load_model('cliente/cliente-model');
            $modelo         = $this->load_model('vinculo/vinculo-model');

            // Carrega view
            require_once EFIPATH . "/views/_includes/header.php";
            require_once EFIPATH . "/views/_includes/menu.php";
            require_once EFIPATH . "/views/vinculo/vinculoCliente-view.php";
            require_once EFIPATH . "/views/_includes/footer.php";

        }


    }


    /*
    * Função para registrar vinculo para cliente especifico
    */
    public function cadastrarVinculo()
    {
        // Verifica se esta logado
        $this->check_login();

        // Verifica as permissoes necessarias
        if ($_SESSION['userdata']['local'] != 1 && $_SESSION['userdata']['per_vi'] != 1 )
        {
            // Se nao possuir permissao
            // Redireciona para index
            $this->moveHome();
        }else{
            // Define o titulo da pagina
            $this->title = "vinculo";

            // Define os parametro da funcao
            $parametros = (func_num_args() >= 1) ? func_get_arg(0) : array();

            // Carrega o model
            $modelo = $this->load_model('cliente/cliente-model');

            // Carrega view
            require_once EFIPATH . "/views/_includes/header.php";
            require_once EFIPATH . "/views/_includes/menu.php";
            require_once EFIPATH . "/views/vinculo/vincularClienteSim-view.php";
            require_once EFIPATH . "/views/_includes/footer.php";

        }
    }

    /**
     * Funcao que gerencia o vinculo do
     * equipamento ou ambiente ao sim
     */
    public function vincular ()
    {
        // Verifica se esta logado
        $this->check_login();

        // Verifica as permissoes necessarias
        if ($_SESSION['userdata']['local'] != 1 && $_SESSION['userdata']['per_vi'] != 1 )
        {
            // Se nao possuir permissao
            // Redireciona para index
            $this->moveHome();
        }
        else
        {
            // Define o titulo da pagina
            $this->title = "Vincular Equipamento";

            // Define os parametro da funcao
            $parametros = (func_num_args() >= 1) ? func_get_arg(0) : array();

            // Carrega o model
            $modelo = $this->load_model('vinculo/vinculo-model');

            // Carrega view
            require_once EFIPATH . "/views/_includes/header.php";
            require_once EFIPATH . "/views/_includes/menu.php";
            require_once EFIPATH . "/views/vinculo/vinculoVincular-view.php";
            require_once EFIPATH . "/views/_includes/footer.php";
        }
    }

    /**
     * Funcao que gerencia o vinculo de sim ao cliente
     */
    public function vincularsim ()
    {
        // Verifica se esta logado
        $this->check_login();

        // Verifica as permissoes necessarias
        if ($_SESSION['userdata']['local'] != 1 && $_SESSION['userdata']['per_vi'] != 1 )
        {
            // Se nao possuir permissao
            // Redireciona para index
            $this->moveHome();
        }
        else
        {
            // Define o titulo da pagina
            $this->title = "Vincular SIM";

            // Define os parametro da funcao
            $parametros = (func_num_args() >= 1) ? func_get_arg(0) : array();

            // Carrega o model
            $modelo = $this->load_model('vinculo/vinculo-model');

            // Carrega view
            require_once EFIPATH . "/views/_includes/header.php";
            require_once EFIPATH . "/views/_includes/menu.php";
            require_once EFIPATH . "/views/vinculo/vinculoVincularSim-view.php";
            require_once EFIPATH . "/views/_includes/footer.php";
        }
    }

    /**
     * Funcao que gerencia o vinculo
     * do equipamento e sim a uma tabela
     */
    public function vincularposicao ()
    {
        // Verifica se esta logado
        $this->check_login();

        // Verifica as permissoes necessarias
        if ($_SESSION['userdata']['local'] != 1 && $_SESSION['userdata']['per_vi'] != 1 )
        {
            // Se nao possuir permissao
            // Redireciona para index
            $this->moveHome();
        }
        else
        {
            // Define o titulo da pagina
            $this->title = "Vincular Posi&ccedil;&atilde;o";

            // Define os parametro da funcao
            $parametros = (func_num_args() >= 1) ? func_get_arg(0) : array();

            // Carrega o model
            $modelo = $this->load_model('vinculo/vinculo-model');

            // Carrega view
            require_once EFIPATH . "/views/_includes/header.php";
            require_once EFIPATH . "/views/_includes/menu.php";
            require_once EFIPATH . "/views/vinculo/vinculoVincularPosicao-view.php";
            require_once EFIPATH . "/views/_includes/footer.php";
        }
    }

    /**
     * Funcao que gerencia todos os equipamentos
     * esperando vinculo na tabela
     */
    public function equipamentolista ()
    {
        // Verifica se esta logado
        $this->check_login();

        // Verifica as permissoes necessarias
        if ($_SESSION['userdata']['local'] != 1 && $_SESSION['userdata']['per_vi'] != 1 )
        {
            // Se nao possuir permissao
            // Redireciona para index
            $this->moveHome();
        }
        else
        {
            // Define o titulo da pagina
            $this->title = "Vincular Posi&ccedil;&atilde;o";

            // Define os parametro da funcao
            $parametros = (func_num_args() >= 1) ? func_get_arg(0) : array();

            // Carrega o model
            $modelo = $this->load_model('vinculo/vinculo-model');

            // Carrega view
            require_once EFIPATH . "/views/_includes/header.php";
            require_once EFIPATH . "/views/_includes/menu.php";
            require_once EFIPATH . "/views/vinculo/vinculoVincularLista-view.php";
            require_once EFIPATH . "/views/_includes/footer.php";
        }
    }


    /*
    * Função para carregar a tela de vinculo do equipamento com o SIM
    */
    public function vincularEquipamentoSim()
    {
        // Verifica se esta logado
        $this->check_login();

        // Verifica as permissoes necessarias
        if ($_SESSION['userdata']['local'] != 1 && $_SESSION['userdata']['per_vi'] != 1 )
        {
            // Se nao possuir permissao
            // Redireciona para index
            $this->moveHome();
        }
        else
        {
            // Define o titulo da pagina
            $this->title = "vinculo";

            // Define os parametro da funcao
            $parametros = (func_num_args() >= 1) ? func_get_arg(0) : array();

            // Carrega o model
            $modelo         = $this->load_model('equipamento/equipamento-model');
            $modeloClie     = $this->load_model('cliente/cliente-model');

            // Carrega view
            require_once EFIPATH . "/views/_includes/header.php";
            require_once EFIPATH . "/views/_includes/menu.php";
            require_once EFIPATH . "/views/vinculo/vincularSimEquipamento-view.php";
            require_once EFIPATH . "/views/_includes/footer.php";
        }
    }

    /*
    * Função para registrar vinculo entre SIM e cliente via JSON
    */

    public function registrarVinculoClienteJson(){

        // CARREGA O MODELO PARA ESTE VIEW/OPERAÇÃO
        $vinculoModelo      = $this->load_model('vinculo/vinculo-model');

        $vinculoRegistrado  = $vinculoModelo->cadastrarVinculoCliente($_POST['idCliente'],$_POST['idFilial'],$_POST['num_sim']);

        if($vinculoRegistrado['status']){
            exit(json_encode(array('status' => $vinculoRegistrado['status'])));
        }else{
            exit(json_encode(array('status' => $vinculoRegistrado['status'])));
        }

    }

    /*
    * Função para registrar o vinculo entre um equipamento e um SIM
    */
    public function registrarVinculoEquipamentoJson(){

        // CARREGA O MODELO PARA ESTE VIEW/OPERAÇÃO
        $vinculoModelo      = $this->load_model('vinculo/vinculo-model');

        $vinculoEquipamento = $vinculoModelo->cadastrarVinculoEquipamento($_POST['idEquipamento'], $_POST['simVinculado'], $_POST['numero_serie'], $_POST['ambiente']);

        if($vinculoEquipamento['status']){
            exit(json_encode(array('status' => $vinculoEquipamento['status'])));
        }else{
            exit(json_encode(array('status' => $vinculoEquipamento['status'])));
        }
    }
}

?>
