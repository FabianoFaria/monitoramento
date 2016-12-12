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
        $this->title = "Clientes";

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
 }

 ?>
