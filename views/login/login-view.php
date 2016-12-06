<!doctype html>

<?php
    if (! defined('EFIPATH')) exit;
?>

<html>
    <head>
        
        <title>Login Monitor</title>
        <!-- Font files -->
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600,700' rel='stylesheet' type='text/css'>
        
        <!-- CSS files -->
        <link rel="stylesheet" href="<?php echo HOME_URI; ?>/views/_css/login.css">
    </head>
    
    <body>
        <div class="container">
            <div class="imgLogin"><img src="<?php echo HOME_URI; ?>/views/_images/logo.png"></div>
            
            <div class="campoForm">
                <form method="post">
                    <p><input type="text" name="userdata[user]" placeholder="USU&Aacute;RIO" class="txt_form"></p>
                    <p><input type="password" name="userdata[userpass]" placeholder="SENHA" class="txt_form"></p>
                    <p><input type="submit" name="btnenviar" value="ENTRAR" class="btn_form"></p>
                </form>
            </div>
            <p><a href="" class="esquecisenha">Esqueci a senha ?</a></p>
        </div>
        
        <?php
            if (isset($_POST['btnenviar']))
            {
                if (isset($this->login_error))
                {
                    echo "<div class='div-respostaLogin'><span>{$this->login_error}</span></div>";
                }
            }
        ?>
        
    </body>
</html>