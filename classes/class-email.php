<?php
// //1 – Definimos Para quem vai ser enviado o email
// $emailenviar = "sistemaeficaz@eficazsystem.com.br";
// $destino = $emailenviar;
// $assunto = "Contato pelo Site";
//
// // É necessário indicar que o formato do e-mail é html
// $headers  = 'MIME-Version: 1.0' . "\r\n";
// $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
// $headers .= 'From: $nome <$email>';
// //$headers .= "Bcc: $EmailPadrao\r\n";
// $arquivo = '';
// $enviaremail = mail($destino, $assunto, $arquivo, $headers);
// if($enviaremail){
//     $mgm = "E-MAIL ENVIADO COM SUCESSO! <br> O link será enviado para o e-mail fornecido no formulário";
//     //echo " <meta http-equiv='refresh' content='10;URL=contato.php'>";
//     echo $mgm;
// } else {
//     $mgm = "ERRO AO ENVIAR E-MAIL!";
//     echo $mgm;
// }
// echo "<p>teste email</p>";


/**
 * Classe para confexão e envio de emails
 *
 * Responsavel por gerenciar toda a montagem
 * e configuração de mensagens de email.
 */
 class email
 {


    /**
     * Metodo de contrucao
     * da classe
    */
    public function __construct()
    {
        // Armazena os dados de envio de email
        $this->remetente =  defined('REMETENTE') ? REMETENTE : "sistemaeficaz@sistema.eficazsystem.com.br ";
    }

    /**
     * Funcao que realizao do envio para recuperação de senhas
     *
     * @param string $query - Recebe o endereço do usuário e o token para recuperação
     */
    public function email_recuperacao($solicitante, $email, $token)
    {
        //Definimos Para quem vai ser enviado o email
        $remetente = $this->remetente;
        $destino = $email;
        $assunto = "Solicitação de nova senha!";

        // É necessário indicar que o formato do e-mail é html
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        //$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8"."\r\n";
        //$headers .= 'From: "Sistema monitoramento" <'.$remetente.'>';

        $mensagem = "<h3>Olá, ".$solicitante."</h3>";
        $mensagem .= "<p>";
        $mensagem .= "Foi solicitado a recuperação de senha para o seu acesso ao sistema de monitoramento.";

        $mensagem .= "</p>";
        $mensagem .= "";
        $mensagem .= "<p>";
        $mensagem .= "Se você realmente solicitou uma nova senha, favor clicar no link abaixo:";
        $mensagem .= "</p>";
        $mensagem .= "<p>";
        $mensagem .= "<a href='".HOME_URI."/login/recuperarSenha?token=".$token."' target='_blank'>Solicitar nova senha!</a>";
        $mensagem .= "</p>";
        $mensagem .= "<p>";
        $mensagem .= "Att.";
        $mensagem .= "</p";


        //$headers .= "Bcc: $EmailPadrao\r\n";
        $arquivo = '';
        $enviaremail = mail($destino, $assunto, $mensagem, $headers,"-f sistemaeficaz@sistema.eficazsystem.com.br");
        if($enviaremail){
            return true;
        } else {
            return false;
        }
    }
}

?>
