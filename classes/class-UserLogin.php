<?php

/**
 * Classe que gerencia o login
 */
class UserLogin
{
    /**
     * $login_error
     *
     * Recebe valor informando se existe erro no login
     *
     * @access public
     */
    public $login_error = null;
    public $login_info  = null;
    public $pedidoSenha_error = null;
    public $pedidoSenha_info  = null;
    public $pedidoSenha_token = null;

    /**
     * Funcao que verifica se o usuario esta logado
     */
    public function check_login()
    {
        // Verifica se esta na sessao
        if (!isset($_SESSION['userdata']) || empty ($_SESSION['userdata']))
        {
            // Se nao estiver
            // Remove qualquer dado existente
            $this->logout();
        }
    }

    /**
     * Funcao que gerencia o login do usuario no sistema
     */
    public function logar ()
    {
        // Verifica se existe dados na sessao
        if (isset($_SESSION['userdata']) && ! empty ($_SESSION))
        {
            // Armazena o link
            $login_uri = HOME_URI;

            // Redireciona
            echo '<script type="text/javascript">window.location.href = "' . $login_uri . '";</script>';
        }

        // Verifica se eh metodo post para efetuar o login normal
        if (isset($_POST['userdata']) && ! empty ($_POST['userdata']) && is_array($_POST['userdata']))
        {
            // Armazena o post
            $userdata = $_POST['userdata'];

            // Extrai as posicoes do array e converte em variaveis
            extract($userdata);
            $user       = $this->tratamento($user, 0);
            $userpass   = $this->tratamento($userpass, 1);

            // Criptografa senha
            $userpass = md5($userpass);

            // Realiza a verificacao do usuario
            $query = "select
                          u.id , u.nome, u.sobrenome, u.local_usu, u.id_cliente, u.tipo_inst,
                          pe.nome as tipo_usu , pe.cadastro , pe.pesquisa, pe.vinculo, pe.configuracao, pe.monitoramento, pe.editar
                      from tb_users u
                      inner join tb_perfil_acesso pe on pe.id = u.id_perfil_acesso
                      where u.email = '{$user}' and u.senha = '{$userpass}' and u.status_ativo = 1 limit 1 ";

            // Executa a query
            $result = $this->db->select($query);

            // Verifica se existe algum erro na query
            // if ($result)
            // {
            //     // Verifica se o usuario existe
            //     if (@mysql_num_rows($result) > 0)
            //     {
            //         // Se o usuario existir
            //         while ($row = @mysql_fetch_assoc($result))
            //         {
            //             $_SESSION['userdata']['firstname']  = $row['nome'];
            //             $_SESSION['userdata']['secondname'] = $row['sobrenome'];
            //             $_SESSION['userdata']['userId']     = $row['id'];
            //             $_SESSION['userdata']['per_ca']     = $row['cadastro'];
            //             $_SESSION['userdata']['per_pe']     = $row['pesquisa'];
            //             $_SESSION['userdata']['per_vi']     = $row['vinculo'];
            //             $_SESSION['userdata']['per_co']     = $row['configuracao'];
            //             $_SESSION['userdata']['per_mo']     = $row['monitoramento'];
            //             $_SESSION['userdata']['per_ed']     = $row['editar'];
            //             $_SESSION['userdata']['local']      = $row['local_usu'];
            //             $_SESSION['userdata']['cliente']    = $row['id_cliente'];
            //             $_SESSION['userdata']['tipo']       = $row['tipo_inst'];
            //             $_SESSION['userdata']['tipo_usu']   = $row['tipo_usu'];
            //
            //             // Registra que o usuario esta logado
            //             $this->logged_in = true;
            //             // Regista a sessao
            //             $this->userdata = $_SESSION['userdata'];
            //
            //             // Armazena o link
            //             $login_uri = HOME_URI;
            //
            //             //registro de atividade na tabela de LogModel
            //             $idUsuarioLog   = $row['id'];
            //
            //             $queryAtividade = "INSERT INTO tb_atividades_usuarios (id_usuario, id_atividade) VALUES ('$idUsuarioLog', 1)";
            //
            //             // Executa a query
            //             $resultLog = $this->db->select($queryAtividade);
            //
            //             // Redireciona via javascript
            //             echo '<script type="text/javascript">window.location.href = "' . $login_uri . '";</script>';
            //         }
            //     }
            //     // Se o usuario nao for encontrao
            //     else
            //     {
            //         // Apresenta mensagem informado que nao achou
            //         $this->login_error = "Usu&aacute;rio e/ou senha incorreto(s).";
            //     }
            // }

            if(!empty($result)){

                /*
                    array(1) { [0]=> array(13) { ["id"]=> string(1) "5" ["nome"]=> string(8) "Sistema2" ["sobrenome"]=> string(6) "Eficaz" ["local_usu"]=> string(1) "1" ["id_cliente"]=> string(2) "59" ["tipo_inst"]=> string(1) "0" ["tipo_usu"]=> string(13) "Administrador" ["cadastro"]=> string(1) "1" ["pesquisa"]=> string(1) "1" ["vinculo"]=> string(1) "1" ["configuracao"]=> string(1) "1" ["monitoramento"]=> string(1) "1" ["editar"]=> string(1) "1" } }
                */
                $row = $result[0];

                            $_SESSION['userdata']['firstname']  = $row['nome'];
                            $_SESSION['userdata']['secondname'] = $row['sobrenome'];
                            $_SESSION['userdata']['userId']     = $row['id'];
                            $_SESSION['userdata']['per_ca']     = $row['cadastro'];
                            $_SESSION['userdata']['per_pe']     = $row['pesquisa'];
                            $_SESSION['userdata']['per_vi']     = $row['vinculo'];
                            $_SESSION['userdata']['per_co']     = $row['configuracao'];
                            $_SESSION['userdata']['per_mo']     = $row['monitoramento'];
                            $_SESSION['userdata']['per_ed']     = $row['editar'];
                            $_SESSION['userdata']['local']      = $row['local_usu'];
                            $_SESSION['userdata']['cliente']    = $row['id_cliente'];
                            $_SESSION['userdata']['tipo']       = $row['tipo_inst'];
                            $_SESSION['userdata']['tipo_usu']   = $row['tipo_usu'];

                // Registra que o usuario esta logado
                $this->logged_in = true;
                // Regista a sessao
                $this->userdata = $_SESSION['userdata'];

                // Armazena o link
                $login_uri = HOME_URI;

                //registro de atividade na tabela de LogModel
                $idUsuarioLog   = $row['id'];

                $queryAtividade = "INSERT INTO tb_atividades_usuarios (id_usuario, id_atividade) VALUES ('$idUsuarioLog', 1)";

                // Executa a query
                $resultLog = $this->db->select($queryAtividade);

                // Redireciona via javascript
                echo '<script type="text/javascript">window.location.href = "' . $login_uri . '";</script>';

            }
            else
            {
                // Caso ocorra algum erro na hora de executar a query
                // Apresentar uma mensagem informando o erro
                $this->login_error = "Ocorreu um erro interno, entre em contato com o Administrador do site.";
            }
        }

        //Caso tenha sido requisitado recuperar senha
        if(isset($_POST['userEmail']) && isset($_POST['solicitarSenha'])){

            //verifica se o email existe no Banco de dados
            $emailSolicitado = $this->tratamento($_POST['userEmail'],1);


            $query = "SELECT id, nome, sobrenome, email,senha  FROM tb_users WHERE email = '{$emailSolicitado}'";

            // Executa a query
            $result = $this->db->select($query);

            if($result){

                $id     = "";
                $nome   = "";
                $email  = "";
                $senha  = "";

                //Inicia o tratamento da rquisição de nova senha!
                if (@mysql_num_rows($result) > 0)
                {
                    // Se o usuario existir
                    while ($row = @mysql_fetch_assoc($result))
                    {
                        $id     = $row['id'];
                        $nome   = $row['nome']." ".$row['sobrenome'];
                        $email  = $row['email'];
                        $senha  = $row['senha'];

                    }
                }

                $data_solicitação   = date('Y-m-d');
                $id_criptografada   = sha1($id);
                $data_criptografada = sha1(date('Y-m-d h:i:s'));
                $token_criptografado = $id_criptografada."_".$data_criptografada;

                //Salva a solicitação no banco de dados para verificação posterior
                $querySolicitacao = "INSERT INTO tb_recuperacao (id_recuperar, token_validador, data_solicitacao) VALUES('$id', '$token_criptografado', '$data_solicitação')";

                $result_solicitacao = $this->db->query($querySolicitacao);

                //Com a solicitação registrada, é efetuado o envio do email ao usuário
                if($result_solicitacao){

                    //valida o resultado do envio de email
                    $envioEmail = $this->mailer->email_recuperacao($nome, $email, $token_criptografado);
                    //envio com sucesso
                    if($envioEmail)
                    {
                        $this->login_info = "Solicitação de nova senha concluida, verifique sua caixa de email mais mais informações!";
                        $this->login_error= "";
                    } //erro no envio
                    else{
                        $this->login_error = "Não foi possivel solicitar nova senha, tente novamente mais tarde ou contate o administrador!";
                    }
                }
                else{
                    $this->login_error = "Ocorreu um erro ao tentar solicitar nova senha, favor solicitar auxilio com o administrador.";
                }

            }else{
                $this->login_error = "Favor verificar o email informado.";
            }

        }


    }

    /**
     * Função que valida o pedido de nova senha
     */
    public function verificaPedidoSenha($token)
    {

        if(isset($token) && $token != ""){

            //Efetuar uma busca no BD pelo token do pedido
            $query = "SELECT id_recuperar, token_validador, status FROM tb_recuperacao WHERE token_validador = '$token'";

            // Executa a query
            $result = $this->db->select($query);

            $idUsuario      = "";
            $statusToken    = "";

            //validação dos resultados da query
            if(@mysql_num_rows($result) > 0){

                // Se o usuario existir
                while ($row = @mysql_fetch_assoc($result))
                {
                    $idUsuario      = $row['id_recuperar'];
                    $statusToken    = $row['token_validador'];
                }

                $this->pedidoSenha_info     = $idUsuario;
                $this->pedidoSenha_token    = $statusToken;
                $this->pedidoSenha_error    = "_";

            }else{
                $this->pedidoSenha_error = "Dados do pedido de nova senha inválidos.";
            }

        }
        else{
            $this->pedidoSenha_error = "Dados do pedido de nova senha não foram encontrados.";
        }
    }

    /**
     * Funcao que efetua a validação da nova senha
     */
    public function registraNovaSenha($novoPass, $confirmPass, $usuarioToken, $idUsuario)
    {
        //Valida se as senha estão iguais
        if($novoPass == $confirmPass)
        {
            //Efetua o tratamento da nova senha
            $senhaParaSalvar = md5($novoPass);

            //Efetuar o update no Banco de dados
            $query = "UPDATE tb_users SET senha = '$senhaParaSalvar' WHERE id = '$idUsuario'";

            $result = $this->db->query($query);

            return true;

            /**
             * FUNCIONALIDADE FUTURA, ENVIO DE EMAIL AVISANDO SOBRE A NOVA SENHA CADATRADA
             */

            // if($result){
            //     $this->login_info = "";
            // }

        }else{

            //Retorna para a página de cadastro de login

            $this->pedidoSenha_info     = $idUsuario;
            $this->pedidoSenha_token    = $usuarioToken;
            $this->pedidoSenha_error    = "_";

            //return false;
        }
    }

    /**
     * Funcao que gerencia o logout do usuario
     */
    protected function logout()
    {
        // Apaga qualquer valor
        $_SESSION['userdata'] = array();

        // Destroi a sessao
        unset ($_SESSION);

        // Apaga qualquer valor
        $_SESSION['userdata'] = array();

        // Destroi toda sessao
        session_destroy();

        // Regenera o id da sessao
        session_regenerate_id();

        // Redireciona para a pagina de login
        $this->goto_login();
    }

    /**
     * Funcao que redireciona para a pagina de login
     */
    public function goto_login()
    {
        // Verifica se o path esta definido
        if (defined('HOME_URI'))
        {
            // Configura a url do login
            $login_uri = HOME_URI . '/login/';

            //var_dump($login_uri);

            // Redireciona via javascript
            echo '<meta http-equiv="Refresh" content="0; url=' . $login_uri . '">';
			echo '<script type="text/javascript">window.location.href = "' . $login_uri . '";</script>';
        }
    }

    /**
     * Funcao que trata os caracteres que sao inseridos
     * nos campos de login do sistema
     *
     * @param string  $palavra - Recebe a palavra que sera tratada
     * @param numeric $regra   - Define o tipo de tratamento
     *
     */
    public function tratamento ($palavra = null, $regra = 0)
    {
        // Verifica se existe a palavra
        if ($palavra != null)
        {
            // Se existir
            // Armazena a palavra
            $novaFrase = $palavra;

            // Verifica a regra de tratamento
            if ($regra == 0)
            {
                // Se for 0
                // Realiza o tratamento para o nome do usuario
                // Cria um array com os caracteres que sera substituidos
                $lista = array("'","(",")","[","]","{","}","+","=","$","#","&","/","*",'"',"´","^","°","ª","º",
                               "<",">","%","!","?",";",":","`","~",",");

                // Realiza o loop para substituir os caracteres
                foreach($lista as $sub)
                {
                    //Substitui os caracteres
                    $novaFrase = str_replace($sub, "", $novaFrase);
                }

                // Retorna a string tratada
                return $novaFrase;
            }

            // Verifica se a regra eh para senha
            if ($regra == 1)
            {
                // Se for tratamento de senha
                // Cria um array com os caracters que sera substuidos
                $lista = array("'","/",'"',"´","^","°","ª","º","<",">","`","~",";",":");

                // Realiza o loop para substituir os caracteres
                foreach($lista as $sub)
                {
                    // Substitui os caracteres
                    $novaFrase = str_replace($sub, "", $novaFrase);
                }

                // Retorna a string tratada
                return $novaFrase;
            }
        }
        // Caso nao exista valor na palavra
        // Retorna false
        return false;
    }
}

?>
