<?php
//1 – Definimos Para quem vai ser enviado o email
$emailenviar = "sistemaeficaz@eficazsystem.com.br";
$destino = $emailenviar;
$assunto = "Contato pelo Site";

// É necessário indicar que o formato do e-mail é html
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= 'From: $nome <$email>';
//$headers .= "Bcc: $EmailPadrao\r\n";
$arquivo = '';
$enviaremail = mail($destino, $assunto, $arquivo, $headers);
if($enviaremail){
    $mgm = "E-MAIL ENVIADO COM SUCESSO! <br> O link será enviado para o e-mail fornecido no formulário";
    //echo " <meta http-equiv='refresh' content='10;URL=contato.php'>";
    echo $mgm;
} else {
    $mgm = "ERRO AO ENVIAR E-MAIL!";
    echo $mgm;
}
echo "<p>teste email</p>";
?>