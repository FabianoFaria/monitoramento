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

        //print_r($this->pedidoSenha_info);
    }
}

/*

LoginController Object (
[db] => EficazDB Object (
    [host:private] => mysql03.eficazsystem2.hospedagemdesites.ws
    [dbname:private] => eficazsystem22
    [username:private] => eficazsystem22
    [userpass:private] => monitor2981 )
[title] => [login_required] => [parametros] => [login_error] => [login_info] => [pedidoSenha_error] => [pedidoSenha_info] => 5
[mailer] => email Object (
    [remetente] => sistemaeficaz@sistema.eficazsystem.com.br )

*/


?>
