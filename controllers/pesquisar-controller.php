<?php

/**
 * Classe de controle que gerencia o model e a view da pesquisa
 */
class PesquisarController extends MainController
{
    /**
     * Funcao que gerencia o sistema de pesquisa do cliente
     */
    public function clientecadastrado ()
    {
        // Verifica se esta logado
        $this->check_login();
        
        // Verifica as permissoes necessarias
        if ($_SESSION['userdata']['local'] != 1 && $_SESSION['userdata']['per_pe'] != 1 )
        {
            // Se nao possuir permissao
            // Redireciona para index
            $this->moveHome();
        }
        else
        {
            // Define o titulo da pagina
            $this->title = "Cliente Cadastrado";

            // Define os parametro da funcao
            $parametros = (func_num_args() >= 1) ? func_get_arg(0) : array();

            // Carrega o modelo para este view
            $modelo = $this->load_model('pesquisa/pesquisar-model');

            // Carrega view
            require_once EFIPATH . "/views/_includes/header.php";
            require_once EFIPATH . "/views/_includes/menu.php";
            require_once EFIPATH . "/views/pesquisar/pesquisaCliente-view.php";
            require_once EFIPATH . "/views/_includes/footer.php";
        }
    }
    
    /**
     * Funcao que gerencia o sistema de pesquisa da filial
     */
    public function filialcadastrado ()
    {
        // Verifica se esta logado
        $this->check_login();
        
        // Verifica as permissoes necessarias
        if ($_SESSION['userdata']['local'] != 1 && $_SESSION['userdata']['per_pe'] != 1 )
        {
            // Se nao possuir permissao
            // Redireciona para index
            $this->moveHome();
        }
        else
        {
            // Define o titulo da pagina
            $this->title = "Filial Cadastrado";

            // Define os parametro da funcao
            $parametros = (func_num_args() >= 1) ? func_get_arg(0) : array();

            // Carrega o modelo para este view
            $modelo = $this->load_model('pesquisa/pesquisar-model');

            // Carrega view
            require_once EFIPATH . "/views/_includes/header.php";
            require_once EFIPATH . "/views/_includes/menu.php";
            require_once EFIPATH . "/views/pesquisar/pesquisaFilial-view.php";
            require_once EFIPATH . "/views/_includes/footer.php";
        }
    }
    
    /**
     * Funcao que gerencia o sistema de pesquisa do fabricante
     */
    public function fabricantecadastrado ()
    {
        // Verifica se esta logado
        $this->check_login();
        
        // Verifica as permissoes necessarias
        if ($_SESSION['userdata']['local'] != 1 && $_SESSION['userdata']['per_pe'] != 1 )
        {
            // Se nao possuir permissao
            // Redireciona para index
            $this->moveHome();
        }
        else
        {
            // Define o titulo da pagina
            $this->title = "Fabricante Cadastrado";

            // Define os parametro da funcao
            $parametros = (func_num_args() >= 1) ? func_get_arg(0) : array();

            // Carrega o modelo para este view
            $modelo = $this->load_model('pesquisa/pesquisar-model');

            // Carrega view
            require_once EFIPATH . "/views/_includes/header.php";
            require_once EFIPATH . "/views/_includes/menu.php";
            require_once EFIPATH . "/views/pesquisar/pesquisaFabricante-view.php";
            require_once EFIPATH . "/views/_includes/footer.php";
        }
    }
    
    /**
     * Funcao que gerencia o sistema de pesquisa do equipamento
     */
    public function equipamentocadastrado ()
    {
        // Verifica se esta logado
        $this->check_login();
        
        // Verifica as permissoes necessarias
        if ($_SESSION['userdata']['local'] != 1 && $_SESSION['userdata']['per_pe'] != 1 )
        {
            // Se nao possuir permissao
            // Redireciona para index
            $this->moveHome();
        }
        else
        {
            // Define o titulo da pagina
            $this->title = "Equipamento Cadastrado";

            // Define os parametro da funcao
            $parametros = (func_num_args() >= 1) ? func_get_arg(0) : array();

            // Carrega o modelo para este view
            $modelo = $this->load_model('pesquisa/pesquisar-model');

            // Carrega view
            require_once EFIPATH . "/views/_includes/header.php";
            require_once EFIPATH . "/views/_includes/menu.php";
            require_once EFIPATH . "/views/pesquisar/pesquisaEquipamento-view.php";
            require_once EFIPATH . "/views/_includes/footer.php";
        }
    }
}

?>