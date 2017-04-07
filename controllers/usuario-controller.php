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

            // Verifica as permissoes necessaris
            if ($_SESSION['userdata']['per_pe'] != 1 )
            {
                 // Se nao possuir permissao
                 // Redireciona para index
                 $this->moveHome();
            }
            else
            {
                //Define o titulo da pagina
                $this->title = "usuario";

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

        }


        /**
         * Funcao que leva a tela com a lista de usuários
         */
        public function listar ()
        {
            // Verifica se esta logado
            $this->check_login();

            // Verifica as permissoes necessaris
            if ($_SESSION['userdata']['per_pe'] != 1 )
            {
                 // Se nao possuir permissao
                 // Redireciona para index
                 $this->moveHome();
            }
            else
            {
                //Define o titulo da página
                $this->title = "usuario";

                // Define os parametro da funcao
                $parametros = (func_num_args() >= 1) ? func_get_arg(0) : array();

                // Carrega o modelo para este view
                $modelo = $this->load_model('usuario/usuario-model');
                // Carrega o modelo de cadastro para este view
                $modeloCadastro = $this->load_model('cadastrar/cadastro-model');
                // Carrega o modelo de clientes para este view
                $modeloClie     = $this->load_model('cliente/cliente-model');

                // Carrega view
                require_once EFIPATH . "/views/_includes/header.php";
                require_once EFIPATH . "/views/_includes/menu.php";
                require_once EFIPATH . "/views/usuario/usuarioLista-view.php";
                require_once EFIPATH . "/views/_includes/footer.php";
            }

        }

        /*
        * Função para listar as ulstimas atividades do usuário selecionado
        */
        public function listarAtividades(){

            // Verifica se esta logado
            $this->check_login();

            // Verifica as permissoes necessaris
            if ($_SESSION['userdata']['per_pe'] != 1 )
            {
                 // Se nao possuir permissao
                 // Redireciona para index
                 $this->moveHome();

            }else{

                //Define o titulo da página
                $this->title = "usuario";

                // Define os parametro da funcao
                $parametros = (func_num_args() >= 1) ? func_get_arg(0) : array();

                // Carrega o modelo para este view
                $modelo = $this->load_model('usuario/usuario-model');
                // Carrega o modelo de cadastro para este view
                $modeloLog = $this->load_model('log/log-model');

                // Carrega view
                require_once EFIPATH . "/views/_includes/header.php";
                require_once EFIPATH . "/views/_includes/menu.php";
                require_once EFIPATH . "/views/usuario/usuarioListaAtividades-view.php";
                require_once EFIPATH . "/views/_includes/footer.php";
            }

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
                 $this->title = "usuario";

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
          * Funcao que cadastra uma usuário para o cliente, durante o cadastro de clientes
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

        /*
        * FUNÇÃO QUE CADASTRA OS USUARIOS DOS SISTEMA NO PAINEL DE USUÁRIOS
        */
        public function registraUsuarioPorSistema(){
            //CARREGA MODELO PARA ESTA FUNÇÃO
            $UsuarioModelo    = $this->load_model('usuario/usuario-model');

            //FAZ TRATAMENTO DE DADOS RECEBIDOS ANTES DE ENVIAR PARA A MODEL
            $senha            = $_POST['senha'];
            $confirmaSenha    = $_POST['confirmaS'];

            if($senha == $confirmaSenha){
                $senha = md5($senha);
            }else{
                $senha = md5('12345');
            }

            $registraUsuario  = $UsuarioModelo->registrarUsuarioParaSistema($_POST['nome'], $_POST['sobrenome'], $_POST['email'], $_POST['celular'], $_POST['telefone'], $senha, $_POST['cliente'], $_POST['acesso']);

            if($registraUsuario){
                exit(json_encode(array('status' => $registraUsuario['status'])));
            }else{
                exit(json_encode(array('status' => $registraUsuario['status'])));
            }

        }

        /*
        * Função para atualizar o contato do cliente
        */
        public function registraAtualizacaoUsuario()
        {

            // CARREGA O MODELO PARA ESTE VIEW/OPERAÇÃO
            $usuarioModelo     = $this->load_model('usuario/usuario-model');

            $atualizarContato  = $usuarioModelo->atualizarUsuarioJson($_POST['id_usuario'], $_POST['nome'], $_POST['sobrenome'], $_POST['email'], $_POST['celular'], $_POST['telefone'], $_POST['confirmaS'], $_POST['idCliente']);

            if($atualizarContato['status']){
                exit(json_encode(array('status' => true)));
            }else{
                exit(json_encode(array('status' => false)));
            }
        }

        /*
        * FUNÇÃO PARA ATUALIZAR USUÁRIO ATUALIZAR OS PRÓPIOS DADOS VIA JSON
        */
        public function atualizarUsuarioManual(){

            // CARREGA O MODELO PARA ESTE VIEW/OPERAÇÃO
            $usuarioModelo          = $this->load_model('usuario/usuario-model');

            /*
            'txt_userId' <font color='#888a85'>=&gt;</font> <small>string</small> <font color='#cc0000'>'5'</font> <i>(length=1)</i>
              'opc_local' <font color='#888a85'>=&gt;</font> <small>string</small> <font color='#cc0000'>'1'</font> <i>(length=1)</i>
              'txt_nome' <font color='#888a85'>=&gt;</font> <small>string</small> <font color='#cc0000'>'Sistema2'</font> <i>(length=8)</i>
              'txt_sobrenome' <font color='#888a85'>=&gt;</font> <small>string</small> <font color='#cc0000'>'Eficaz'</font> <i>(length=6)</i>
              'txt_telefone_usuario' <font color='#888a85'>=&gt;</font> <small>string</small> <font color='#cc0000'>'(012) 3323-2222'</font> <i>(length=15)</i>
              'txt_celular_usuario' <font color='#888a85'>=&gt;</font> <small>string</small> <font color='#cc0000'>'(041) 2312-3123'</font> <i>(length=15)</i>
              'txt_email' <font color='#888a85'>=&gt;</font> <small>string</small> <font color='#cc0000'>'sistemaeficaz@sistema.eficazsystem.com.br'</font> <i>(length=41)</i>
              'txt_senha' <font color='#888a85'>=&gt;</font> <small>string</small> <font color='#cc0000'>''</font> <i>(length=0)</i>
              'txt_cfsenha' <font color='#888a85'>=&gt;</font> <small>string</small> <font color='#cc0000'>''</font> <i>(length=0)</i>
            */

            //var_dump($_POST);

            //var_dump($_FILES);

            //TESTA SE FOI COLOCADO ALGUM ARQUIVO PARA SER SALVO
            // if(file_exists($_FILES['file_foto']['tmp_name']) && is_uploaded_file($_FILES['file_foto']['tmp_name'])){
            //
            //
            //     //EFETUA O UPLOAD DA IMAGEM SELECIONADA
            //     $arquivoEnviado = $this->upload_avatar($_FILES, UP_USER_IMG_PATH, 'user');
            //
            // }else{
                $arquivoEnviado = null;
            // }

            // if(!file_exists($_FILES['myfile']['tmp_name']) || !is_uploaded_file($_FILES['myfile']['tmp_name'])) {
            //     echo 'No upload';
            // }

            $atualizarUsuarioJson   = $usuarioModelo->atualizarUsuarioJson($_POST['txt_userId'], $_POST['txt_nome'], $_POST['txt_sobrenome'], $_POST['txt_email'], $_POST['txt_celular_usuario'], $_POST['txt_telefone_usuario'], $_POST['txt_senha'], $_POST['txt_cfsenha'], $arquivoEnviado);

            if($atualizarUsuarioJson['status']){

                //VERIFICAR O AVATAR ANTIGO DO USUÁRIO E REMOVER A IMAGEM ANTIGA DO USUÁRIO
                if($arquivoEnviado != null){
                    var_dump($arquivoEnviado);
                }

                exit(json_encode(array('status' => true)));
            }else{
                exit(json_encode(array('status' => false)));
            }
        }

        /*
        * FUNÇÃO PARA CARREGAR USÁRIO PARA EDIÇÃO
        */
        public function carregarDadosUsuariosJson(){

            // CARREGA O MODELO PARA ESTE VIEW/OPERAÇÃO
            $usuarioModelo          = $this->load_model('usuario/usuario-model');

            $carregarDadosUsuario   = $usuarioModelo->dadosUsuario($_POST['idUsuario']);

            if($carregarDadosUsuario != false){

                $usuario['id'] = html_entity_decode($carregarDadosUsuario['id'], ENT_COMPAT, 'UTF-8');
                $usuario['nome'] = html_entity_decode($carregarDadosUsuario['nome'], ENT_COMPAT, 'UTF-8');
                $usuario['sobrenome'] = html_entity_decode($carregarDadosUsuario['sobrenome'], ENT_COMPAT, 'UTF-8');
                $usuario['email'] = html_entity_decode($carregarDadosUsuario['email'], ENT_COMPAT, 'UTF-8');
                $usuario['telefone'] = html_entity_decode($carregarDadosUsuario['telefone'], ENT_COMPAT, 'UTF-8');
                $usuario['celular'] = html_entity_decode($carregarDadosUsuario['celular'], ENT_COMPAT, 'UTF-8');
                $usuario['id_cliente'] = html_entity_decode($carregarDadosUsuario['id_cliente'], ENT_COMPAT, 'UTF-8');
                $usuario['id_perfil_acesso'] = html_entity_decode($carregarDadosUsuario['id_perfil_acesso'], ENT_COMPAT, 'UTF-8');

                exit(json_encode(array('status' => true, 'usuario' => $usuario)));
            }else{
                exit(json_encode(array('status' => false, 'usuario' => '')));
            }

        }

        /*
        * FUNÇÃO PARA SALVAR OS DADOS DO USUÁRIO
        */

        public function atualizarUsuarioPorSistema(){
            // CARREGA O MODELO PARA ESTE VIEW/OPERAÇÃO
            $usuarioModelo          = $this->load_model('usuario/usuario-model');

            $atualizarUsuarioJson   = $usuarioModelo->atualizarUsuarioViaSistema($_POST['idUser'], $_POST['nome'], $_POST['sobrenome'], $_POST['email'], $_POST['celular'], $_POST['telefone'], $_POST['senha'], $_POST['confirmaS'], $_POST['cliente'], $_POST['acesso']);

            if($atualizarUsuarioJson['status']){
                exit(json_encode(array('status' => true)));
            }else{
                exit(json_encode(array('status' => false)));
            }

        }

        /*
        * FUNÇÃO PARA EXCLUIR O USUÁRIO
        */
        public function excluirUsuariosJson(){
            // CARREGA O MODELO PARA ESTE VIEW/OPERAÇÃO
            $usuarioModelo          = $this->load_model('usuario/usuario-model');

            $usuarioUsuarioJson     = $usuarioModelo->excluirUsuarioViaJson($_POST['idUsuario']);

            if($usuarioUsuarioJson['status']){
                exit(json_encode(array('status' => true)));
            }else{
                exit(json_encode(array('status' => false)));
            }
        }

        /*
        * FUNÇÃO PARA FILTRAR OS USUÁRIOS POR CLIENTE
        */
        public function filtrarUsuariosClienteJson(){

            // CARREGA O MODELO PARA ESTE VIEW/OPERAÇÃO
            $usuarioModelo          = $this->load_model('usuario/usuario-model');

            $listaUsuarios          = $usuarioModelo->listagemUsuarioCliente($_POST['idCliente']);

            if($listaUsuarios){

                $listaUsuariosTabela      = '';

                foreach ($listaUsuarios as $usuario) {

                    $dataTemp       = explode(' ', $usuario['dt_criaco']);

                    $dataCriacao    = implode("/", array_reverse(explode("-", $dataTemp[0])));

                    if($_POST['tipoUser'] == 'Administrador'){
                        $atividades = "<td>
                            <a href='".HOME_URI."/usuario/listarAtividades/".$usuario['id']." class='btn button link-tabela-moni'>
                                <i class='fa fa-file-text-o fa-l'></i>
                            </a>
                        </td>";

                    }else{
                        $atividades = "";
                    }

                    $listaUsuariosTabela .="<tr>
                                            <td>".$usuario['nome']." ".$usuario['sobrenome']."</td>
                                            <td>".$usuario['email']."</td><td>".$usuario['email']."</td>
                                            <td>".$dataCriacao."</td>
                                            ".$atividades."
                                            <td>
                                                <button class='btnEditUser btn link-tabela-moni' value='".$usuario['id']."'>
                                                     <i class='fa fa-pencil-square-o fa-lg'></i>
                                                </button>
                                            </td>
                                            <td>
                                                <button class='btnRemoveUser btn link-tabela-moni' value='".$usuario['id']."'>
                                                    <i class='fa  fa-times fa-lg'></i>
                                                </button>
                                            </td>
                                            </tr>";
                }

                exit(json_encode(array('status' => true, 'usuarios' => $listaUsuariosTabela)));
            }else{
                $listaUsuariosTabela      = '<tr><td colspan="6">Nenhum Usuário cadastrado para o cliente !</td></tr>';

                exit(json_encode(array('status' => false, 'usuarios' => $listaUsuariosTabela)));
            }
        }

        /*
        * FUNÇÃO PARA FILTRAR OS USUÁRIOS POR CLIENTE E POR TIPO
        */
        // public function filtrarUsuariosClienteJson(){
        //
        // }
    }


 ?>
