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
        echo "teste OK!";
    }
}

?>
