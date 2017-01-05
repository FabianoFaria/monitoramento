<?php

/**
 * Classe de controle que registra, exibe, gera relatorio
 * e controla demais operações sobre alarmes
 */
 class AlarmeController extends MainController
 {
    /**
     * Funcao que gerencia o index dos alarmes
     */
    public function index()
    {
        // Verifica se esta logado
        $this->check_login();

        // Define o titulo da pagina
        $this->title = "Alarmes";

        // Define os parametro da funcao
        $parametros = (func_num_args() >= 1) ? func_get_arg(0) : array();

        $modelo         = $this->load_model('usuario/usuario-model');
        $modeloCliete   = $this->load_model('cliente/cliente-model');
        // CARREGA O MODELO PARA ESTE VIEW
        $alarmeModelo  = $this->load_model('alarme/alarme-model');
        $modeloEdicao  = $this->load_model('editar/editar-model');

        // Carrega view
        require_once EFIPATH . "/views/_includes/header.php";
        require_once EFIPATH . "/views/_includes/menu.php";
        require_once EFIPATH . "/views/alarme/alarmeLista-view.php";
        require_once EFIPATH . "/views/_includes/footer.php";
    }

    public function alarmeStatus(){
        // Verifica se esta logado
        $this->check_login();

        // Define o titulo da pagina
        $this->title = "Alarmes";

        // Define os parametro da funcao
        $parametros = (func_num_args() >= 1) ? func_get_arg(0) : array();

        $modelo         = $this->load_model('usuario/usuario-model');
        // CARREGA O MODELO PARA ESTE VIEW
        $alarmeModelo  = $this->load_model('alarme/alarme-model');
        $modeloEdicao  = $this->load_model('editar/editar-model');

        // Carrega view
        require_once EFIPATH . "/views/_includes/header.php";
        require_once EFIPATH . "/views/_includes/menu.php";
        require_once EFIPATH . "/views/alarme/alarmeLista-view.php";
        require_once EFIPATH . "/views/_includes/footer.php";
    }

    public function gerenciarAlertas(){

        // Verifica se esta logado
        $this->check_login();

        // Verifica as permissoes necessaris
        if ($_SESSION['userdata']['local'] != 1 && $_SESSION['userdata']['per_ed'] != 1 )
        {
            // Se nao possuir permissao
            // Redireciona para index
            $this->moveHome();
        }
        else
        {
            //Define o titulo da pagina
            $this->title = "alarme";

            // Define os parametro da funcao
            $parametros = (func_num_args() >= 1) ? func_get_arg(0) : array();

            // Carrega o modelo para este view
            $modelo         = $this->load_model('cliente/cliente-model');
            $modeloAlarm    = $this->load_model('alarme/alarme-model');

            // Carrega view
            require_once EFIPATH . "/views/_includes/header.php";
            require_once EFIPATH . "/views/_includes/menu.php";
            require_once EFIPATH . "/views/alarme/gerenciarAlarmeCliente-view.php";
            require_once EFIPATH . "/views/_includes/footer.php";

        }

    }
 }

 ?>
