<?php

/**
 * Classe de controle que gerencia
 * a view do sistema de login
 */
class LoginController extends MainController
{
    /**
     * Fucao index da pagina de logina
     */
    public function index()
    {
        // Define o titulo da pagina
        $this->title = "Login Monitoramento";

        // Chama o metodo para realizar o login
        $this->logar();

        // Define os parametros da funcao
        $parametros = (func_num_args() >= 1) ? func_get_arg(0) : array();

        // Carregando a view
        require_once EFIPATH . "/views/login/login-view.php";
    }

    /**
     * Funcao que redireciona para o logout
     */
    public function sair()
    {
        // Chama o metodo de logout
        $this->logout();
    }


    /**
     * Fucao para recuperação de senhas
     */
    public function recuperarSenha()
    {
        //Recebe o token gerado anteriormente
        $token = $_GET['token'];

        $this->verificaPedidoSenha($token);

        //Carrega a página para atualizar a senha para o usuáRedireciona

        // Carregando a view
        require_once EFIPATH . "/views/login/login-view.php";

    }

    /**
     * Função para validar nova senha solicitada pelo usuário
     */
    public function validarNovaSenha()
    {
        //Efetua a validação da nova senha e conforme o resultado retorna para a tela correta

        $idUsuario      = $this->tratamento($_POST['usuarioIdenctificado'], 1);
        $usuarioToken   = $_POST['token'];
        $novoPass       = $this->tratamento($_POST['novaSenha'], 1);
        $confirmPass    = $this->tratamento($_POST['confirmarNovaSenha'], 1);

        $resultadoAtualizado = $this->registraNovaSenha($novoPass, $confirmPass, $usuarioToken, $idUsuario);

        if($resultadoAtualizado){
            $this->goto_login();
        }

        // Carregando a view
        require_once EFIPATH . "/views/login/login-view.php";
    }

}

?>
