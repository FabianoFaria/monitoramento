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
         * Funcao que leva a tela com a lista de usuários
         */
        public function listar ()
        {
            // Verifica se esta logado
            $this->check_login();

            //Define o titulo da página
            $this->title = "Lista usuário";

            // Define os parametro da funcao
            $parametros = (func_num_args() >= 1) ? func_get_arg(0) : array();

            // Carrega o modelo para este view
            $modelo = $this->load_model('usuario/usuario-model');
            // Carrega o modelo de cadastro para este view
            $modeloCadastro = $this->load_model('cadastrar/cadastro-model');

            // Carrega view
            require_once EFIPATH . "/views/_includes/header.php";
            require_once EFIPATH . "/views/_includes/menu.php";
            require_once EFIPATH . "/views/usuario/usuarioLista-view.php";
            require_once EFIPATH . "/views/_includes/footer.php";

        }

        /**
         * Funcao que leva a tela de edição de outro usuário
         */
         public function editarTerceiros(){

             // VERIFICA SE ESTA LOGADO
             $this->check_login();

             // Verifica as permissoes necessaris
             if ($_SESSION['userdata']['local'] != 1 && $_SESSION['userdata']['per_ed'] != 1 )
             {
                 // Se nao possuir permissao
                 // Redireciona para index
                 $this->moveHome();
             }else
             {
                 //Define o titulo da pagina
                 $this->title = "Editar usuário";

                 // Define os parametro da funcao
                 $parametros = (func_num_args() >= 1) ? func_get_arg(0) : array();

                 // Carrega o modelo para este view
                 $modelo        = $this->load_model('usuario/usuario-model');
                 $modeloEdicao  = $this->load_model('editar/editar-model');
                 // Carrega o modelo de cadastro para este view
                 $modeloCadastro = $this->load_model('cadastrar/cadastro-model');

                 // Carrega view
                 require_once EFIPATH . "/views/_includes/header.php";
                 require_once EFIPATH . "/views/_includes/menu.php";
                 require_once EFIPATH . "/views/usuario/usuarioEditar-view.php";
                 require_once EFIPATH . "/views/_includes/footer.php";
             }
         }


         //Efetua o tratamento das funções passadas via JSON

         /**
          * Funcao que cadastra uma usuário para o cliente
          */
          public function registraUsuario(){

              //CARREGA MODELO PARA ESTA FUNÇÃO
              $UsuarioModelo    = $this->load_model('usuario/usuario-model');

              //Faz tratamento de dados recebidos antes de enviar para a model

              $senha            = $_POST['senha'];
              $confirmaSenha    = $_POST['confirmaS'];


              if($senha == $confirmaSenha){
                  $senha = md5($senha);
              }else{
                  $senha = md5('12345');
              }

              $registraUsuario  = $UsuarioModelo->registrarUsuarioParaCliente($_POST['nome'], $_POST['sobrenome'], $_POST['email'], $_POST['celular'], $_POST['telefone'], $senha, $_POST['idCliente']);

              if($registraUsuario){
                  exit(json_encode(array('status' => $registraUsuario['status'], 'idUsuario' => $registraUsuario['idUsuario'])));
              }else{
                  exit(json_encode(array('status' => $registraUsuario['status'], 'idUsuario' => $registraUsuario['idUsuario'])));
              }

          }


    }





 ?>
