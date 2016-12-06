    <?php

if (! defined('EFIPATH')) exit();

// verifica se existe acao do post
$modelo->gravarEquipamento();

?>

<script type="text/javascript">
    // gerenciador de link
    var menu = document.getElementById('listadir');
    menu.innerHTML = '<a href="<?php echo HOME_URI; ?>/home/" class="linkMenuSup">Home</a> / <a href="<?php echo HOME_URI; ?>/cadastrar/" class="linkMenuSup">Cadastrar</a> / <a href="<?php echo HOME_URI; ?>/cadastrar/equipamento/" class="linkMenuSup">Equipamento</a>';
</script>


<div class="container-fluid fontPadrao">
    <!-- Titulo pagina -->
    <label class="titulo-pagina">EQUIPAMENTO</label><!-- Fim Titulo pagina -->
    
    
    <!-- formulario de cadastro -->
    <form method="post">
        <div class="row">
            <!-- fabricante -->
            <div class="col-md-3">
                <div class="form-group">
                    <label for="exampleInputEmail1">Nome do Fabricante</label>
                    <?php $modelo->listaFabricante(); ?>
                </div>
            </div><!-- fim fabricante -->
            
            <!-- Tipo de equipamento -->
            <div class="col-md-3">
                <div class="form-group">
                    <label for="tipoEquipamento">Tipo de Equipamento</label>
                    <input type="text" class="form-control" id="txt_tipoEquip" name="txt_tipoEquip" placeholder="Tipo de Equipamento" maxlength="80" required
                    value="<?php if (isset($_POST['txt_tipoEquip'])) echo $_POST['txt_tipoEquip']; ?>">
                </div>
            </div><!-- fim tipo do equipamento -->
            
            
            <!-- Modelo de equipamento -->
            <div class="col-md-3">
                <div class="form-group">
                    <label for="modeloEquipamento">Modelo de Equipamento</label>
                    <input type="text" class="form-control" id="txt_modeloEquip" name="txt_modeloEquip" placeholder="Modelo de Equipamento" maxlength="80"
                    required value="<?php if (isset($_POST['txt_modeloEquip'])) echo $_POST['txt_modeloEquip']; ?>">
                </div>
            </div><!-- fim modelo do equipamento -->
            
            
            <!-- Quantidade de bateria -->
            <div class="col-md-3">
                <div class="form-group">
                    <label for="qntBateria">Quantidade de bateria (Opcional)</label>
                    <input type="text" class="form-control" id="txt_qntBateria" name="txt_qntBateria" placeholder="Quantidade de bateria" maxlength="5"
                    onkeypress="return onlyNumber(event);" value="<?php if (isset($_POST['txt_qntBateria'])) echo $_POST['txt_qntBateria']; ?>">
                </div>
            </div><!-- fim quantidade de bateria -->
            
        </div>
        
        
        
        <div class="row">
            
            <!-- Potencia -->
            <div class="col-md-3">
                <div class="form-group">
                    <label for="Potencia">Pot&ecirc;ncia (Opcional)</label>
                    <input type="text" class="form-control" id="txt_potencia" name="txt_potencia" placeholder="Pot&ecirc;ncia" maxlength="15"
                    value="<?php if (isset($_POST['txt_potencia'])) echo $_POST['txt_potencia']; ?>">
                </div>
            </div><!-- fim potencia -->
            
            
            <!-- Caracteristica do equipamento -->
            <div class="col-md-3">
                <div class="form-group">
                    <label for="caracteristica">Caracter&iacute;sticas equipamento (Opcional)</label>
                    <input type="text" class="form-control" id="txt_caracteristica" name="txt_caracteristica" placeholder="Caracter&iacute;sticas equipamento" 
                    maxlength="30" value="<?php if (isset($_POST['txt_caracteristica'])) echo $_POST['txt_caracteristica']; ?>">
                </div>
            </div><!-- fim Caracteristica do equipamento -->
            
            <!-- Amperagem bateria -->
            <div class="col-md-3">
                <div class="form-group">
                    <label for="Amperagem">Amperagem bateria (Opcional)</label>
                    <input type="text" class="form-control" id="txt_amperagem" name="txt_amperagem" placeholder="Amperagem bateria" maxlength="10"
                    value="<?php if (isset($_POST['txt_amperagem'])) echo $_POST['txt_amperagem']; ?>">
                </div>
            </div><!-- fim Amperagem bateria -->
            
            <!-- Tipo de bateria -->
            <div class="col-md-3">
                <div class="form-group">
                    <label for="tipoBateria">Tipo de bateria (Opcional)</label>
                    <select id="opc_tipoBateria" name="opc_tipoBateria" spellcheck="false" class="form-control">
                        <option value=''>Selecione um tipo de bateria</option>
                        <option value='Selada'>Selada</option>
                        <option value='Automotiva'>Automotiva</option>
                        <option value='Estacion&aacute;ria'>Estacion&aacute;ria</option>
                    </select>
                </div>
            </div><!-- fim Tipo de bateria -->
            
        </div>
        
        
        
        <!-- botao de enviar -->
        <div class="row">
            <div class="col-md-2 col-md-offset-5 txt-center"><input type="submit" name="btn_salvar" class="btn btn-info" value="Salvar"></div>
        </div><!-- fim do botao de envio -->
        
    </form><!-- fim do formulario de cadastro -->
</div>