<?php

/**
 * Classe que gerencia o controle
 * da view e model da edicao
 */
class EditarController extends MainController
{
    /**
     * Funcao que gerencia a edicao das informacoes do cliente
     */
    public function editarCliente ()
    {
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
            $this->title = "Editar Cliente";

            // Define os parametro da funcao
            $parametros = (func_num_args() >= 1) ? func_get_arg(0) : array();

            // Carrega o modelo para este view
            $modelo = $this->load_model('editar/editar-model');

            // Carrega view
            require_once EFIPATH . "/views/_includes/header.php";
            require_once EFIPATH . "/views/_includes/menu.php";
            require_once EFIPATH . "/views/editar/editarCliente-view.php";
            require_once EFIPATH . "/views/_includes/footer.php";
        }
    }

    /**
     * Funcao que gerencia a edicao das informacoes da filial
     */
    public function editarFilial ()
    {
        // Verifica se esta logado
        $this->check_login();

        // Verifica as permissoes necessarias
        if ($_SESSION['userdata']['local'] != 1 && $_SESSION['userdata']['per_ed'] != 1 )
        {
            // Se nao possuir permissao
            // Redireciona para index
            $this->moveHome();
        }
        else
        {
            // Define o titulo da pagina
            $this->title = "Editar Filial";

            // Define os parametro da funcao
            $parametros = (func_num_args() >= 1) ? func_get_arg(0) : array();

            // Carrega o modelo para este view
            $modelo = $this->load_model('editar/editar-model');

            // Carrega view
            require_once EFIPATH . "/views/_includes/header.php";
            require_once EFIPATH . "/views/_includes/menu.php";
            require_once EFIPATH . "/views/editar/editarFilial-view.php";
            require_once EFIPATH . "/views/_includes/footer.php";
        }
    }

    /**
     * Funcao que gerencia a edicao das informacoes dos equipamentos
     */
    public function editarEquipamento ()
    {
        // Verifica se esta logado
        $this->check_login();

        // Verifica as permissoes necessarias
        if ($_SESSION['userdata']['local'] != 1 && $_SESSION['userdata']['per_ed'] != 1 )
        {
            // Se nao possuir permissao
            // Redireciona para index
            $this->moveHome();
        }
        else
        {
            // Define o titulo da pagina
            $this->title = "Editar Equipamento";

            /* parametro da funcao */
            $parametros = (func_num_args() >= 1) ? func_get_arg(0) : array();

            // Carrega o modelo para este view
            $modelo = $this->load_model('editar/editar-model');

            // Carrega view
            require_once EFIPATH . "/views/_includes/header.php";
            require_once EFIPATH . "/views/_includes/menu.php";
            require_once EFIPATH . "/views/editar/editarEquipamento-view.php";
            require_once EFIPATH . "/views/_includes/footer.php";
        }
    }

    /**
     * Funcao que gerencia a edicao das informacoes do fabricante
     */
    public function editarFabricante ()
    {
        // Verifica se esta logado
        $this->check_login();

        // Verifica as permissoes necessarias
        if ($_SESSION['userdata']['local'] != 1 && $_SESSION['userdata']['per_ed'] != 1 )
        {
            // Se nao possuir permissao
            // Redireciona para index
            $this->moveHome();
        }
        else
        {
            // Define o titulo da pagina
            $this->title = "Editar Fabricante";

            // Define os parametro da funcao
            $parametros = (func_num_args() >= 1) ? func_get_arg(0) : array();

            // Carrega o modelo para este view
            $modelo = $this->load_model('editar/editar-model');

            // Carrega view
            require_once EFIPATH . "/views/_includes/header.php";
            require_once EFIPATH . "/views/_includes/menu.php";
            require_once EFIPATH . "/views/editar/editarFabricante-view.php";
            require_once EFIPATH . "/views/_includes/footer.php";
        }
    }
}

?>
