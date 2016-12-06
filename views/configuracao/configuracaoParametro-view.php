<?php

if (!defined('EFIPATH')) exit();

// Carrega os clientes
$retorno = $modelo->carregaParametroForm();

// Salva as configuracoes do cliente
$modelo->chamaSalvaParametro();

// Verifica se a respota nao esta vazia e existe
if (isset($retorno) && ! empty ($retorno) && is_array($retorno))
{
    // Separa os elementos da string em array
    $retorno = explode("|",$retorno[0]);
    
    // Quebra o retorno da tabela em uma array
    foreach($retorno as $row)
    {
        // Array auxiliar para separar os valores da tabela
        $row2 = explode("-",$row);
        // Armazena os dados na array
        $ret[] = $row2[2];
    }
    // Destroi a array auxiliar
    unset($row2);
}
?>

<script type="text/javascript">
    // Gerenciador de link
    var menu = document.getElementById('listadir');
    menu.innerHTML = '<a href="<?php echo HOME_URI; ?>/home/" class="linkMenuSup">Home</a> / <a href="<?php echo HOME_URI; ?>/configuracao/" class="linkMenuSup">Configura&ccedil;&atilde;o</a> / <a href="" class="linkMenuSup">Parametro</a>';
</script>


<div class="container fontPadrao">
    <form method="post">
        
        <?php
            $mult = 0;
            for ($a=1; $a<4; $a++)
            {
                // Variavel de controle
        ?>
        
        <!-- Entrada -->
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="exampleInputEmail1">Entrada <?php echo $a?> </label>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-2">
                <div class="form-group">
                    <label for="exampleInputEmail1" class="fontsub">Valor Baixo</label>
                    <input type="text" class="form-control" id="eb-<?php echo $a;?>" name="eb-<?php echo $a;?>" placeholder="000,00" maxlength="7" onkeypress="return onlyNumber2(event);" value="<?php if(isset($ret[$mult]) && !empty($ret[$mult])) echo $modelo->trataV($ret[$mult],1); ?>">
                </div>
            </div>
            
            <?php $mult++;?>
            
            <div class="col-md-2">
                <div class="form-group">
                    <label for="exampleInputEmail1" class="fontsub">Valor tolerância 1</label>
                    <input type="text" class="form-control" id="et-<?php echo $a;?>" name="et-<?php echo $a;?>" placeholder="000,00" maxlength="7" onkeypress="return onlyNumber2(event);" value="<?php if(isset($ret[$mult]) && !empty($ret[$mult])) echo $modelo->trataV($ret[$mult],1); ?>">
                </div>
            </div>
            
            <?php $mult++;?>
            
            <div class="col-md-2">
                <div class="form-group">
                    <label for="exampleInputEmail1" class="fontsub">Valor Ideal</label>
                    <input type="text" class="form-control" id="ei-<?php echo $a;?>" name="ei-<?php echo $a;?>" placeholder="000,00" maxlength="7" onkeypress="return onlyNumber2(event);" value="<?php if(isset($ret[$mult]) && !empty($ret[$mult])) echo $modelo->trataV($ret[$mult],1); ?>">
                </div>
            </div>
            
            <?php $mult++;?>
            
            <div class="col-md-2">
                <div class="form-group">
                    <label for="exampleInputEmail1" class="fontsub">Valor tolerância 2</label>
                    <input type="text" class="form-control" id="et2-<?php echo $a;?>" name="et2-<?php echo $a;?>" placeholder="000,00" maxlength="7" onkeypress="return onlyNumber2(event);" value="<?php if(isset($ret[$mult]) && !empty($ret[$mult])) echo $modelo->trataV($ret[$mult],1); ?>">
                </div>
            </div>
            
            <?php $mult++;?>
            
            <div class="col-md-2">
                <div class="form-group">
                    <label for="exampleInputEmail1" class="fontsub">Valor Alto</label>
                    <input type="text" class="form-control" id="ea-<?php echo $a;?>" name="ea-<?php echo $a;?>" placeholder="000,00" maxlength="7" onkeypress="return onlyNumber2(event);" value="<?php if(isset($ret[$mult]) && !empty($ret[$mult])) echo $modelo->trataV($ret[$mult],1); ?>">
                </div>
            </div>
        </div><!-- Fim entrada -->
        
        
        <?php
                $mult++;
            } for ($a=1; $a<4; $a++) {
        ?>
        
        
        <!-- saida -->
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="exampleInputEmail1">Sa&iacute;da <?php echo $a;?> </label>
                </div>
            </div>
            
            <?php ;?>
            
            <div class="col-md-2">
                <div class="form-group">
                    <label for="exampleInputEmail1" class="fontsub">Valor Baixo</label>
                    <input type="text" class="form-control" id="sb-<?php echo $a;?>" name="sb-<?php echo $a;?>" placeholder="000,00" maxlength="7" onkeypress="return onlyNumber2(event);" value="<?php if(isset($ret[$mult]) && !empty($ret[$mult])) echo $modelo->trataV($ret[$mult],1); ?>">
                </div>
            </div>
            
            <?php $mult++;?>
            
            <div class="col-md-2">
                <div class="form-group">
                    <label for="exampleInputEmail1" class="fontsub">Valor toler&acirc;ncia 1</label>
                    <input type="text" class="form-control" id="st1-<?php echo $a;?>" name="st1-<?php echo $a;?>" placeholder="000,00" maxlength="7" onkeypress="return onlyNumber2(event);" value="<?php if(isset($ret[$mult]) && !empty($ret[$mult])) echo $modelo->trataV($ret[$mult],1); ?>">
                </div>
            </div>
            
            <?php $mult++;?>
            
            <div class="col-md-2">
                <div class="form-group">
                    <label for="exampleInputEmail1" class="fontsub">Valor Ideal</label>
                    <input type="text" class="form-control" id="si-<?php echo $a;?>" name="si-<?php echo $a;?>" placeholder="000,00" maxlength="7" onkeypress="return onlyNumber2(event);" value="<?php if(isset($ret[$mult]) && !empty($ret[$mult])) echo $modelo->trataV($ret[$mult],1); ?>">
                </div>
            </div>
            
            <?php $mult++;?>
            
            <div class="col-md-2">
                <div class="form-group">
                    <label for="exampleInputEmail1" class="fontsub">Valor Toler&acirc;ncia 2</label>
                    <input type="text" class="form-control" id="st2-<?php echo $a;?>" name="st2-<?php echo $a;?>" placeholder="000,00" maxlength="7" onkeypress="return onlyNumber2(event);" value="<?php if(isset($ret[$mult]) && !empty($ret[$mult])) echo $modelo->trataV($ret[$mult],1); ?>">
                </div>
            </div>
            
            <?php $mult++;?>
        
            <div class="col-md-2">
                <div class="form-group">
                    <label for="exampleInputEmail1" class="fontsub">Valor Alto</label>
                    <input type="text" class="form-control" id="sa-<?php echo $a;?>" name="sa-<?php echo $a;?>" placeholder="000,00" maxlength="7" onkeypress="return onlyNumber2(event);" value="<?php if(isset($ret[$mult]) && !empty($ret[$mult])) echo $modelo->trataV($ret[$mult],1); ?>">
                </div>
            </div>
        </div><!-- Fim saida -->
        
        <?php 
            $mult++;
            }
        ?>
        
        
        
        <!-- botao de envio -->
        <div class="row">
            <div class="col-md-2 col-md-offset-5 txt-center">
                <input type="submit" class="btn btn-info" id="btn_enviarConf" name="btn_enviar" value="Salvar">
            </div>
        </div><!-- fim botao de envio -->
    </form>
</div>