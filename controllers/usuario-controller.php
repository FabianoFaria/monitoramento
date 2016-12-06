<?php

    /**
    * Classe que gerencia o controle
    * da view e model dos dados do usuário
    */

    class UsuarioController extends MainController
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
             $this->title = "Usuário";

             // Define os parametro da funcao
             $parametros = (func_num_args() >= 1) ? func_get_arg(0) : array();

             // Carrega o modelo para este view
             $modelo = $this->load_model('usuario/usuario-model');
             // Carrega o modelo de cadastro para este view
             $modeloCadastro = $this->load_model('cadastrar/cadastro-model');

             // Carrega view
             require_once EFIPATH . "/views/_includes/header.php";
             require_once EFIPATH . "/views/_includes/menu.php";
             require_once EFIPATH . "/views/usuario/usuarioDados-view.php";
             require_once EFIPATH . "/views/_includes/footer.php";

        }


        /**
         * Funcao que gerencia a edicao das informacoes do Usuário
         */


    }





 ?>
