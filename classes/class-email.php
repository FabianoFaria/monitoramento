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
        $this->remetente =  defined('REMETENTE') ? REMETENTE : "monitoramento@sistema.eficazsystem.com.br";
    }

    /*
    * Função para efetuar o envio de email para eventual DISPARO DE ALERTA
    *
    *
    *@param
    */
    public function envioEmailAlertaEquipamento($email, $nomeContato, $tipoEquip, $nomeEquip, $modeloEquip, $ambiente, $msg, $cliente, $sede, $indiceRecebido, $indiceUltrapassado){

        //require_once('PHPMailerAutoload.php');

        // $mailer = new PHPMailer();
        //
        // $mailer->FromName = 'Monitoramento Eficaz'; //Nome que será exibido para o destinatário
        // $mailer->From = 'monitoramento@sistema.eficazsystem.com.br'; //Obrigatório ser a mesma caixa postal configurada no remetente do SMTP
        // $mailer->isSendmail();

        //Definimos Para quem vai ser enviado o email
        $remetente = $this->remetente;
        $destino = $email;

        $assunto = "ALERTA, ".$tipoEquip." ".$nomeEquip." da ".$cliente." se encontra em estado crítico!";

        // É necessário indicar que o formato do e-mail é html
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        //$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8"."\r\n";
        // para enviar a mensagem em prioridade máxima
        //$headers .= "X-Priority: 1\n";
        $headers .= 'From: "Sistema monitoramento Infraweb" <'.$remetente.'>';
        //$headers .= "Return-Path: monitoramento@sistema.eficazsystem.com.br\r\n"; // return-path

        //$mail->addCustomHeader('X-custom-header', 'custom-value');

        //CARREGANDO FOLHA DE ESTILO E AFINS
        $mensagem = "";
        $mensagem .= '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">';
        $mensagem .= '<html xmlns="http://www.w3.org/1999/xhtml">';

        $mensagem .= "<head>";
            $mensagem .= '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    		<meta name="viewport" content="width=device-width, initial-scale=1.0">
    		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    		<meta name="format-detection" content="telephone=no" />';
        $mensagem .= "</head>";

        $mensagem .= '<style type="text/css">
			/* RESET STYLES */
			html { background-color:#E1E1E1; margin:0; padding:0; }
			body, #bodyTable, #bodyCell, #bodyCell{height:100% !important; margin:0; padding:0; width:100% !important;font-family:Helvetica, Arial, "Lucida Grande", sans-serif;}
			table{border-collapse:collapse;}
			table[id=bodyTable] {width:100%!important;margin:auto;max-width:500px!important;color:#7A7A7A;font-weight:normal;}
			img, a img{border:0; outline:none; text-decoration:none;height:auto; line-height:100%;}
			a {text-decoration:none !important;border-bottom: 1px solid;}
			h1, h2, h3, h4, h5, h6{color:#5F5F5F; font-weight:normal; font-family:Helvetica; font-size:20px; line-height:125%; text-align:Left; letter-spacing:normal;margin-top:0;margin-right:0;margin-bottom:10px;margin-left:0;padding-top:0;padding-bottom:0;padding-left:0;padding-right:0;}

			/* CLIENT-SPECIFIC STYLES */
			.ReadMsgBody{width:100%;} .ExternalClass{width:100%;} /* Force Hotmail/Outlook.com to display emails at full width. */
			.ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div{line-height:100%;} /* Force Hotmail/Outlook.com to display line heights normally. */
			table, td{mso-table-lspace:0pt; mso-table-rspace:0pt;} /* Remove spacing between tables in Outlook 2007 and up. */
			#outlook a{padding:0;} /* Force Outlook 2007 and up to provide a "view in browser" message. */
			img{-ms-interpolation-mode: bicubic;display:block;outline:none; text-decoration:none;} /* Force IE to smoothly render resized images. */
			body, table, td, p, a, li, blockquote{-ms-text-size-adjust:100%; -webkit-text-size-adjust:100%; font-weight:normal!important;} /* Prevent Windows- and Webkit-based mobile platforms from changing declared text sizes. */
			.ExternalClass td[class="ecxflexibleContainerBox"] h3 {padding-top: 10px !important;} /* Force hotmail to push 2-grid sub headers down */

			/* /\/\/\/\/\/\/\/\/ TEMPLATE STYLES /\/\/\/\/\/\/\/\/ */

			/* ========== Page Styles ========== */
			h1{display:block;font-size:26px;font-style:normal;font-weight:normal;line-height:100%;}
			h2{display:block;font-size:20px;font-style:normal;font-weight:normal;line-height:120%;}
			h3{display:block;font-size:17px;font-style:normal;font-weight:normal;line-height:110%;}
			h4{display:block;font-size:18px;font-style:italic;font-weight:normal;line-height:100%;}
			.flexibleImage{height:auto;}
			.linkRemoveBorder{border-bottom:0 !important;}
			table[class=flexibleContainerCellDivider] {padding-bottom:0 !important;padding-top:0 !important;}

			body, #bodyTable{background-color:#E1E1E1;}
			#emailHeader{background-color:#E1E1E1;}
			#emailBody{background-color:#FFFFFF;}
			#emailFooter{background-color:#E1E1E1;}
			.nestedContainer{background-color:#F8F8F8; border:1px solid #CCCCCC;}
			.emailButton{background-color:#205478; border-collapse:separate;}
			.buttonContent{color:#FFFFFF; font-family:Helvetica; font-size:18px; font-weight:bold; line-height:100%; padding:15px; text-align:center;}
			.buttonContent a{color:#FFFFFF; display:block; text-decoration:none!important; border:0!important;}
			.emailCalendar{background-color:#FFFFFF; border:1px solid #CCCCCC;}
			.emailCalendarMonth{background-color:#205478; color:#FFFFFF; font-family:Helvetica, Arial, sans-serif; font-size:16px; font-weight:bold; padding-top:10px; padding-bottom:10px; text-align:center;}
			.emailCalendarDay{color:#205478; font-family:Helvetica, Arial, sans-serif; font-size:60px; font-weight:bold; line-height:100%; padding-top:20px; padding-bottom:20px; text-align:center;}
			.imageContentText {margin-top: 10px;line-height:0;}
			.imageContentText a {line-height:0;}
			#invisibleIntroduction {display:none !important;} /* Removing the introduction text from the view */

			/*FRAMEWORK HACKS & OVERRIDES */
			span[class=ios-color-hack] a {color:#275100!important;text-decoration:none!important;} /* Remove all link colors in IOS (below are duplicates based on the color preference) */
			span[class=ios-color-hack2] a {color:#205478!important;text-decoration:none!important;}
			span[class=ios-color-hack3] a {color:#8B8B8B!important;text-decoration:none!important;}
			/* A nice and clean way to target phone numbers you want clickable and avoid a mobile phone from linking other numbers that look like, but are not phone numbers.  Use these two blocks of code to "unstyle" any numbers that may be linked.  The second block gives you a class to apply with a span tag to the numbers you would like linked and styled.

			*/
			.a[href^="tel"], a[href^="sms"] {text-decoration:none!important;color:#606060!important;pointer-events:none!important;cursor:default!important;}
			.mobile_link a[href^="tel"], .mobile_link a[href^="sms"] {text-decoration:none!important;color:#606060!important;pointer-events:auto!important;cursor:default!important;}


			/* MOBILE STYLES */
			@media only screen and (max-width: 480px){
				/*////// CLIENT-SPECIFIC STYLES //////*/
				body{width:100% !important; min-width:100% !important;} /* Force iOS Mail to render the email at full width. */

				/* FRAMEWORK STYLES */
				/*
				CSS selectors are written in attribute
				selector format to prevent Yahoo Mail
				from rendering media query styles on
				desktop.
				*/
				/*td[class="textContent"], td[class="flexibleContainerCell"] { width: 100%; padding-left: 10px !important; padding-right: 10px !important; }*/
				table[id="emailHeader"],
				table[id="emailBody"],
				table[id="emailFooter"],
				table[class="flexibleContainer"],
				td[class="flexibleContainerCell"] {width:100% !important;}
				td[class="flexibleContainerBox"], td[class="flexibleContainerBox"] table {display: block;width: 100%;text-align: left;}
				/*
				The following style rule makes any

				fluid when the query activates.
				Make sure you add an inline max-width
				to those images to prevent them
				from blowing out.
				*/
				td[class="imageContent"] img {height:auto !important; width:100% !important; max-width:100% !important; }
				img[class="flexibleImage"]{height:auto !important; width:100% !important;max-width:100% !important;}
				img[class="flexibleImageSmall"]{height:auto !important; width:auto !important;}


				/*
				Create top space for every second element in a block
				*/
				table[class="flexibleContainerBoxNext"]{padding-top: 10px !important;}

				/*
				Make buttons in the email span the
				full width of their container, allowing
				for left- or right-handed ease of use.
				*/
				table[class="emailButton"]{width:100% !important;}
				td[class="buttonContent"]{padding:0 !important;}
				td[class="buttonContent"] a{padding:15px !important;}

			}

			@media only screen and (-webkit-device-pixel-ratio:.75){
				/* Put CSS for low density (ldpi) Android layouts in here */
			}

			@media only screen and (-webkit-device-pixel-ratio:1){
				/* Put CSS for medium density (mdpi) Android layouts in here */
			}

			@media only screen and (-webkit-device-pixel-ratio:1.5){
				/* Put CSS for high density (hdpi) Android layouts in here */
			}
			/* end Android targeting */

			/* CONDITIONS FOR IOS DEVICES ONLY
			=====================================================*/
			@media only screen and (min-device-width : 320px) and (max-device-width:568px) {

			}
			/* end IOS targeting */
		</style>';

        $mensagem .= '<body bgcolor="#E1E1E1" leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0">';

            $mensagem .= '<center style="background-color:#E1E1E1;">';

                $mensagem .= '<table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="bodyTable" style="table-layout: fixed;max-width:100% !important;width: 100% !important;min-width: 100% !important;">';

                    $mensagem .= '<tr>';
                        $mensagem .= '<td align="center" valign="top" id="bodyCell">';

                            $mensagem .= '<table bgcolor="#FFFFFF"  border="0" cellpadding="0" cellspacing="0" width="500" id="emailBody">';

                                $mensagem .= '<tr>';
                                    $mensagem .= '<td align="center" valign="top">';
                                        $mensagem .= '<table border="0" cellpadding="0" cellspacing="0" width="500" class="flexibleContainer">';

                                            $mensagem .= '<tr>';
                                                $mensagem .= '<td align="center" valign="top" width="500" class="flexibleContainerCell">';
                                                    $mensagem .= '<table border="0" cellpadding="30" cellspacing="0" width="100%">';

                                                        $mensagem .= '<tr>';
                                                            $mensagem .= '<td align="center" valign="top" class="textContent">';
                                                                //MENSAGEM DO EMAIL
                                                                $mensagem .= '<h3 style="color:#5F5F5F;line-height:125%;font-family:Helvetica,Arial,sans-serif;font-size:20px;font-weight:normal;margin-top:0;margin-bottom:3px;text-align:left;">';
                                                                $mensagem .= "Olá, ".$nomeContato."";
                                                                $mensagem .= '</h3>';

                                                                $mensagem .= '<div mc:edit="body" style="text-align:left;font-family:Helvetica,Arial,sans-serif;font-size:15px;margin-bottom:0;color:#5F5F5F;line-height:135%;">';
                                                                    $mensagem .= "<p>";
                                                                    $mensagem .= "".$tipoEquip." ".$nomeEquip." de modelo ".$modeloEquip."  ";
                                                                    $mensagem .= " localizado na sede : ".$cliente." - ".$sede." ";
                                                                    $mensagem .= "</p>";
                                                                    $mensagem .= "<p>";
                                                                    $mensagem .= "Apresenta a seguinte mensagem de erro : ";
                                                                    $mensagem .= "</p>";
                                                                    $mensagem .= "<p>";
                                                                    $mensagem .= $msg;
                                                                    $mensagem .= "</p>";
                                                                    $mensagem .= "<p> Foi registrado uma medida de ".$indiceRecebido." no equipamento onde o limite seguro era de : ".$indiceUltrapassado." ";
                                                                    $mensagem .= "</p>";
                                                                    $mensagem .= "<p>";
                                                                    $mensagem .= "Favor solicitar verificação do equipamento o mais rapido possível.";
                                                                    $mensagem .= "</p>";
                                                                    $mensagem .= "<p>";
                                                                    $mensagem .= "Att.";
                                                                    $mensagem .= "</p>";
                                                                $mensagem .= '</div>';



                                                                $mensagem .= '';

                                                            $mensagem .= '</td>';
                                                        $mensagem .= '</tr>';

                                                    $mensagem .= '</table';
                                                $mensagem .= '</td>';
                                            $mensagem .= '</tr>';

                                        $mensagem .= '</table';
                                    $mensagem .= '</td>';
                                $mensagem .= '</tr>';

                            $mensagem .= '</table';

                        $mensagem .= '';

                        $mensagem .= '</td>';
                    $mensagem .= '</tr>';

                $mensagem .= '</table>';


            $mensagem .= '</center';


        $mensagem .= "</body>";

        $mensagem .= '</html>';


        // $mailer->AddAddress( $email, $nomeContato); //Destinatários
        // $mailer->Subject = $assunto;
        // $mailer->Body = $mensagem;


        // if(!$mailer->Send())
        // {
        // echo "Message was not sent";
        // echo "Mailer Error: " . $mailer->ErrorInfo; exit; }
        // print "E-mail enviado!";

        // $headers .= "Bcc: $EmailPadrao\r\n";
        $arquivo = '';
        $enviaremail = mail($destino, $assunto, $mensagem, $headers,"-r monitoramento@sistema.eficazsystem.com.br");
        if($enviaremail){
            return true;
        } else {
            return false;
        }


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
        $headers .= 'From: "Sistema monitoramento Infraweb" <'.$remetente.'>';

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
        $mensagem .= "</p>";


        //$headers .= "Bcc: $EmailPadrao\r\n";
        $arquivo = '';
        $enviaremail = mail($destino, $assunto, $mensagem, $headers,"-r".$remetente);
        if($enviaremail){
            return true;
        } else {
            return false;
        }
    }

    /**
     * Funcao para amostra de montagem de email
     *
     * @param Nenhum
     */
    public function email_template()
    {
        //Definimos Para quem vai ser enviado o email
        $remetente = $this->remetente;
        $destino = $email;

        $assunto = "ALERTA, ".$tipoEquip." ".$nomeEquip." da ".$cliente." se encontra em estado crítico!";

        // É necessário indicar que o formato do e-mail é html
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        //$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8"."\r\n";
        //$headers .= 'From: "Sistema monitoramento" <'.$remetente.'>';

        //CARREGANDO FOLHA DE ESTILO E AFINS
        $mensagem = "";
        $mensagem .= '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">';
        $mensagem .= '<html xmlns="http://www.w3.org/1999/xhtml">';

        $mensagem .= "<head>";
            $mensagem .= '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    		<meta name="viewport" content="width=device-width, initial-scale=1.0">
    		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    		<meta name="format-detection" content="telephone=no" />';
        $mensagem .= "</head>";

        $mensagem .= '<style type="text/css">
			/* RESET STYLES */
			html { background-color:#E1E1E1; margin:0; padding:0; }
			body, #bodyTable, #bodyCell, #bodyCell{height:100% !important; margin:0; padding:0; width:100% !important;font-family:Helvetica, Arial, "Lucida Grande", sans-serif;}
			table{border-collapse:collapse;}
			table[id=bodyTable] {width:100%!important;margin:auto;max-width:500px!important;color:#7A7A7A;font-weight:normal;}
			img, a img{border:0; outline:none; text-decoration:none;height:auto; line-height:100%;}
			a {text-decoration:none !important;border-bottom: 1px solid;}
			h1, h2, h3, h4, h5, h6{color:#5F5F5F; font-weight:normal; font-family:Helvetica; font-size:20px; line-height:125%; text-align:Left; letter-spacing:normal;margin-top:0;margin-right:0;margin-bottom:10px;margin-left:0;padding-top:0;padding-bottom:0;padding-left:0;padding-right:0;}

			/* CLIENT-SPECIFIC STYLES */
			.ReadMsgBody{width:100%;} .ExternalClass{width:100%;} /* Force Hotmail/Outlook.com to display emails at full width. */
			.ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div{line-height:100%;} /* Force Hotmail/Outlook.com to display line heights normally. */
			table, td{mso-table-lspace:0pt; mso-table-rspace:0pt;} /* Remove spacing between tables in Outlook 2007 and up. */
			#outlook a{padding:0;} /* Force Outlook 2007 and up to provide a "view in browser" message. */
			img{-ms-interpolation-mode: bicubic;display:block;outline:none; text-decoration:none;} /* Force IE to smoothly render resized images. */
			body, table, td, p, a, li, blockquote{-ms-text-size-adjust:100%; -webkit-text-size-adjust:100%; font-weight:normal!important;} /* Prevent Windows- and Webkit-based mobile platforms from changing declared text sizes. */
			.ExternalClass td[class="ecxflexibleContainerBox"] h3 {padding-top: 10px !important;} /* Force hotmail to push 2-grid sub headers down */

			/* /\/\/\/\/\/\/\/\/ TEMPLATE STYLES /\/\/\/\/\/\/\/\/ */

			/* ========== Page Styles ========== */
			h1{display:block;font-size:26px;font-style:normal;font-weight:normal;line-height:100%;}
			h2{display:block;font-size:20px;font-style:normal;font-weight:normal;line-height:120%;}
			h3{display:block;font-size:17px;font-style:normal;font-weight:normal;line-height:110%;}
			h4{display:block;font-size:18px;font-style:italic;font-weight:normal;line-height:100%;}
			.flexibleImage{height:auto;}
			.linkRemoveBorder{border-bottom:0 !important;}
			table[class=flexibleContainerCellDivider] {padding-bottom:0 !important;padding-top:0 !important;}

			body, #bodyTable{background-color:#E1E1E1;}
			#emailHeader{background-color:#E1E1E1;}
			#emailBody{background-color:#FFFFFF;}
			#emailFooter{background-color:#E1E1E1;}
			.nestedContainer{background-color:#F8F8F8; border:1px solid #CCCCCC;}
			.emailButton{background-color:#205478; border-collapse:separate;}
			.buttonContent{color:#FFFFFF; font-family:Helvetica; font-size:18px; font-weight:bold; line-height:100%; padding:15px; text-align:center;}
			.buttonContent a{color:#FFFFFF; display:block; text-decoration:none!important; border:0!important;}
			.emailCalendar{background-color:#FFFFFF; border:1px solid #CCCCCC;}
			.emailCalendarMonth{background-color:#205478; color:#FFFFFF; font-family:Helvetica, Arial, sans-serif; font-size:16px; font-weight:bold; padding-top:10px; padding-bottom:10px; text-align:center;}
			.emailCalendarDay{color:#205478; font-family:Helvetica, Arial, sans-serif; font-size:60px; font-weight:bold; line-height:100%; padding-top:20px; padding-bottom:20px; text-align:center;}
			.imageContentText {margin-top: 10px;line-height:0;}
			.imageContentText a {line-height:0;}
			#invisibleIntroduction {display:none !important;} /* Removing the introduction text from the view */

			/*FRAMEWORK HACKS & OVERRIDES */
			span[class=ios-color-hack] a {color:#275100!important;text-decoration:none!important;} /* Remove all link colors in IOS (below are duplicates based on the color preference) */
			span[class=ios-color-hack2] a {color:#205478!important;text-decoration:none!important;}
			span[class=ios-color-hack3] a {color:#8B8B8B!important;text-decoration:none!important;}
			/* A nice and clean way to target phone numbers you want clickable and avoid a mobile phone from linking other numbers that look like, but are not phone numbers.  Use these two blocks of code to "unstyle" any numbers that may be linked.  The second block gives you a class to apply with a span tag to the numbers you would like linked and styled.

			*/
			.a[href^="tel"], a[href^="sms"] {text-decoration:none!important;color:#606060!important;pointer-events:none!important;cursor:default!important;}
			.mobile_link a[href^="tel"], .mobile_link a[href^="sms"] {text-decoration:none!important;color:#606060!important;pointer-events:auto!important;cursor:default!important;}


			/* MOBILE STYLES */
			@media only screen and (max-width: 480px){
				/*////// CLIENT-SPECIFIC STYLES //////*/
				body{width:100% !important; min-width:100% !important;} /* Force iOS Mail to render the email at full width. */

				/* FRAMEWORK STYLES */
				/*
				CSS selectors are written in attribute
				selector format to prevent Yahoo Mail
				from rendering media query styles on
				desktop.
				*/
				/*td[class="textContent"], td[class="flexibleContainerCell"] { width: 100%; padding-left: 10px !important; padding-right: 10px !important; }*/
				table[id="emailHeader"],
				table[id="emailBody"],
				table[id="emailFooter"],
				table[class="flexibleContainer"],
				td[class="flexibleContainerCell"] {width:100% !important;}
				td[class="flexibleContainerBox"], td[class="flexibleContainerBox"] table {display: block;width: 100%;text-align: left;}
				/*
				The following style rule makes any

				fluid when the query activates.
				Make sure you add an inline max-width
				to those images to prevent them
				from blowing out.
				*/
				td[class="imageContent"] img {height:auto !important; width:100% !important; max-width:100% !important; }
				img[class="flexibleImage"]{height:auto !important; width:100% !important;max-width:100% !important;}
				img[class="flexibleImageSmall"]{height:auto !important; width:auto !important;}


				/*
				Create top space for every second element in a block
				*/
				table[class="flexibleContainerBoxNext"]{padding-top: 10px !important;}

				/*
				Make buttons in the email span the
				full width of their container, allowing
				for left- or right-handed ease of use.
				*/
				table[class="emailButton"]{width:100% !important;}
				td[class="buttonContent"]{padding:0 !important;}
				td[class="buttonContent"] a{padding:15px !important;}

			}

			@media only screen and (-webkit-device-pixel-ratio:.75){
				/* Put CSS for low density (ldpi) Android layouts in here */
			}

			@media only screen and (-webkit-device-pixel-ratio:1){
				/* Put CSS for medium density (mdpi) Android layouts in here */
			}

			@media only screen and (-webkit-device-pixel-ratio:1.5){
				/* Put CSS for high density (hdpi) Android layouts in here */
			}
			/* end Android targeting */

			/* CONDITIONS FOR IOS DEVICES ONLY
			=====================================================*/
			@media only screen and (min-device-width : 320px) and (max-device-width:568px) {

			}
			/* end IOS targeting */
		</style>';

        $mensagem .= '<body bgcolor="#E1E1E1" leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0">';

            $mensagem .= '<center style="background-color:#E1E1E1;">';

                $mensagem .= '<table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="bodyTable" style="table-layout: fixed;max-width:100% !important;width: 100% !important;min-width: 100% !important;">';

                    $mensagem .= '<tr>';
                        $mensagem .= '<td align="center" valign="top" id="bodyCell">';


                        $mensagem .= '</td>';
                    $mensagem .= '</tr>';

                $mensagem .= '</table>';


            $mensagem .= '</center';


        $mensagem .= "</body>";

        $mensagem .= '</html>';


    $mensagem .= "";


    }

    /*
    * FUNÇÃO PARA TESTE DE PHPMAILER
    */
    public function enviarAvisoNormalidade($nomeContato, $emailDestino, $tipoEquip, $nomeEquipamento){

        //Definimos Para quem vai ser enviado o email
        $remetente = $this->remetente;
        $destino = $emailDestino;
        $assunto = "Equipamento ".$tipoEquip." ".$nomeEquipamento." retornou ao funcionamento normal!";

        // É necessário indicar que o formato do e-mail é html
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        //$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8"."\r\n";
        $headers .= 'From: "Sistema monitoramento Infraweb" <'.$remetente.'>';

        $mensagem = "<h3>Olá, ".$nomeContato."</h3>";
        $mensagem .= "<p>";
        $mensagem .= "Foi detectado que o equipamento ".$tipoEquip." ".$nomeEquipamento.", voltou ao seu funcionamento em nível normal.";
        $mensagem .= "</p>";
        $mensagem .= "";
        $mensagem .= "<p>";
        $mensagem .= "Os dados do alerta já foram registrados e podem ser acessados através do sistema.";
        $mensagem .= "</p>";

        $mensagem .= "<p>";
        $mensagem .= "Att.";
        $mensagem .= "</p>";

        $mensagem .= "<p>";
        $mensagem .= "Eficaz system - Sistema de monitoramento";
        $mensagem .= "</p>";


        //$headers .= "Bcc: $EmailPadrao\r\n";
        $arquivo = '';
        $enviaremail = mail($destino, $assunto, $mensagem, $headers,"-r sistemaeficaz@sistema.eficazsystem.com.br");
        if($enviaremail){
            return true;
        } else {
            return false;
        }

    }

    /*
    * TESTE DE FUNÇÃO PHP MAILER
    */
    public function enviaPhpMailer($nomeContato, $emailDestino, $tipoEquip, $nomeEquipamento){

        // Inclui o arquivo class.phpmailer.php localizado na pasta phpmailer
        require_once("class.phpmailer.php");

        // Inicia a classe PHPMailer
        $mail = new PHPMailer();

        $mail->SetLanguage("br");
        $mail->IsMail();

        $Email->From = "sistemaeficaz@sistema.eficazsystem.com.br";
        $Email->FromName = "Sistema de monitoramento - Eficaz System";

        // Define os destinatário(s)
        // =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
        $mail->AddAddress(  $emailDestino, $nomeContato);
        //$mail->AddAddress('ciclano@site.net');

        // Define os dados técnicos da Mensagem
        // =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
        $mail->IsHTML(true); // Define que o e-mail será enviado como HTML
        //$mail->CharSet = 'iso-8859-1'; // Charset da mensagem (opcional)

        // Define a mensagem (Texto e Assunto)
        // =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
        $mail->Subject  = "Mensagem Teste"; // Assunto da mensagem
        $mail->Body = "Este é o corpo da mensagem de teste, em <b>HTML</b>!  :)";
        $mail->AltBody = "Este é o corpo da mensagem de teste, em Texto Plano! \r\n :)";

        // Envia o e-mail
        $enviado = $mail->Send();
        // Limpa os destinatários e os anexos
        $mail->ClearAllRecipients();
        $mail->ClearAttachments();
        // Exibe uma mensagem de resultado
        if ($enviado) {
          echo "E-mail enviado com sucesso!";
        } else {
          echo "Não foi possível enviar o e-mail.";
          echo "<b>Informações do erro:</b> " . $mail->ErrorInfo;
        }

    }

    /*
    * FUNÇÃO PARA ENVIO DE EMAIL PARA NOTIFICAR APARELHO NÃO RESPONDENDO
    */
    public function envioEmailAlertaEquipamentoNaoResponde($email, $nome_contato, $tipo_equipamento, $nomeModeloEquipamento, $ambiente, $nomeClie){

        //Definimos Para quem vai ser enviado o email
        $remetente = $this->remetente;
        $destino = $email;
        $assunto = "ALERTA - Equipamento mestre não está respondendo!";

        // É necessário indicar que o formato do e-mail é html
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        //$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8"."\r\n";
        $headers .= 'From: "Sistema monitoramento Infraweb" <'.$remetente.'>';

        $mensagem = "<h3>Olá, ".$nome_contato."</h3>";
        $mensagem .= "<p>";
        $mensagem .= "Foi detectado que o equipamento responsável pelo monitoramento do  ".$tipo_equipamento." ".$nomeModeloEquipamento.", não está enviando dados.";
        $mensagem .= "</p>";
        $mensagem .= "";
        $mensagem .= "<p>";
        $mensagem .= "Os dados do alerta já foram registrados e podem ser acessados através do sistema.";
        $mensagem .= "</p>";

        $mensagem .= "<p>";
        $mensagem .= "Att.";
        $mensagem .= "</p>";

        $mensagem .= "<p>";
        $mensagem .= "Eficaz system - Sistema de monitoramento Infraweb";
        $mensagem .= "</p>";

        //$headers .= "Bcc: $EmailPadrao\r\n";
        $arquivo = '';
        $enviaremail = mail($destino, $assunto, $mensagem, $headers,"-r monitoramento@sistema.eficazsystem.com.br");
        if($enviaremail){
            return true;
        } else {
            return false;
        }
    }
}

?>
