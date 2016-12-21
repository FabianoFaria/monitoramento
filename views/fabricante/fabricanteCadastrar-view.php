<!-- CADASTRAR CLIENTES VIEW -->
<?php
    if (! defined('EFIPATH')) exit;

?>

<script type="text/javascript">
    // gerenciador de link
    var menu = document.getElementById('listadir');
    menu.innerHTML = '<a href="<?php echo HOME_URI; ?>/home/" class="linkMenuSup">Home</a> / <a href="<?php echo HOME_URI; ?>/fabricante/" class="linkMenuSup">Listar fabricante</a> / <a href="<?php echo HOME_URI; ?>/fabricante/cadastrar/" class="linkMenuSup">Cadastrar Fabricante</a>';
</script>

<!-- Jquery file -->
<script src="<?php echo HOME_URI; ?>/views/_js/pages/jquery.js"></script>

<div class="row">
    <div class="col-md-12">

    	 <!-- TITULO PAGINA -->
        <label class="page-header">Cadastro de novo fabricante</label><!-- Fim Titulo pagina -->


    	<!-- Cadastra o contato com o cliente -->
        <div class="panel-group" id="accordionContatoClie" role="tablist" aria-multiselectable="true">
            <div class="panel panel-default">

            	<div class="panel-heading" role="tab" id="headingOne">
                  <h4 class="panel-title">
                    <a role="button" data-toggle="collapse" data-parent="#accordionContatoClie" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                      <i class="fa  fa-building-o  "></i> Dados do fabricante
                    </a>
                  </h4>
                </div>
                <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                  <div class="panel-body">

                  	<!-- form contendo os dados do cliente -->
                    <form id="cadFabricanet" method="post">
                    	 <div class="row">
                    	 	<!-- nome do fabricante -->
				            <div class="col-md-6">
				                <div class="form-group">
				                    <label for="exampleInputEmail1">Nome do Fabricante</label>
				                    <input type="text" class="form-control" id="txt_fabricante" name="txt_fabricante" placeholder="Nome do Equipamento" maxlength="80" required>
				                </div>
				            </div><!-- fim nome do fabricante -->

                    	 	<!-- DDD -->
				            <div class="col-md-2">
				                <div class="form-group">
				                    <label for="exampleInputEmail1">C&oacute;digo de &Aacute;rea</label>
				                    <input type="text" class="form-control" id="txt_ddd" name="txt_ddd" placeholder="DDD (000)" maxlength="3" onkeypress="return onlyNumber(event);">
				                </div>
				            </div><!-- fim do ddd -->
            
				            <!-- telefone -->
				            <div class="col-md-4">
				                <div class="form-group">
				                    <label for="exampleInputEmail1">Telefone</label>
				                    <input type="text" class="form-control" id="txt_telefone" name="txt_telefone" placeholder="Telefone" maxlength="10" onkeypress="return onlyNumber(event);">
				                </div>
				            </div><!-- fim do telefone -->
                    	 </div>

                    	 <div class="row">

                    	 	<!-- cep -->
				            <div class="col-md-2">
				                <div class="form-group">
				                    <label for="exampleInputEmail1">CEP</label>
				                    <input type="text" class="form-control" id="txt_cep" name="txt_cep" placeholder="CEP" maxlength="9" required onkeypress="return onlyNumber(event);">
				                </div>
				            </div><!-- fim do cep -->
            
            
				            <!-- endereco do cliente -->
				            <div class="col-md-6">
				                <div class="form-group">
				                    <label for="exampleInputEmail1">Endere&ccedil;o</label>
				                    <input type="text" class="form-control" id="txt_endereco" name="txt_endereco" placeholder="Rua, Avenida e etc" maxlength="200" required>
				                </div>
				            </div><!-- fim do endereco do cliente -->
            
				            <!-- numero -->
				            <div class="col-md-2">
				                <div class="form-group">
				                    <label for="exampleInputEmail1">N&uacute;mero</label>
				                    <input type="text" class="form-control" id="txt_numero" name="txt_numero" placeholder="N&uacute;mero" maxlength="9"  onkeypress="return onlyNumber(event);">
				                </div>
				            </div><!-- fim do numero -->

                    	 </div>

                    	 <div class="row">
                    	 	<!-- Cidade -->
				            <div class="col-md-3">
				                <div class="form-group">
				                    <label for="exampleInputEmail1">Cidade</label>
				                    <input type="text" class="form-control" id="txt_cidade" name="txt_cidade" placeholder="Cidade" maxlength="50" required>
				                </div>
				            </div><!-- fim do campo Cidade -->
            
				            <!-- Bairro -->
				            <div class="col-md-3">
				                <div class="form-group">
				                    <label for="exampleInputEmail1">Bairro</label>
				                    <input type="text" class="form-control" id="txt_bairro" name="txt_bairro" placeholder="Cidade" maxlength="50" required>
				                </div>
				            </div><!-- fim do campo Bairro -->
            			</div>
            			<div class="row">
            
				            <!-- pais -->
				            <div class="col-md-4">
				                <div class="form-group">
				                    <label for="exampleInputEmail1">Pais</label><br>
				                    <?php $modelo->listaPaises(); ?>
				                </div>
				            </div><!-- fim do pais -->
            
            
				            <!-- estado -->
				            <div class="col-md-4">
				                <div class="form-group">
				                    <label for="exampleInputEmail1">Estado</label><br>
				                    <?php $modelo->listaEstado(); ?>
				                </div>
				            </div><!-- fim do estado -->
                    	 </div>
                    	 <div class="row">
                    	 	<div class="col-md-4">
                    	 	</div>
                    	 	<div class="col-md-4">
                    	 		 <button id="salvarFabricante" name="btn_salvar" class="btn btn-info" value="Salvar">Salvar</button>
                    	 	</div>
                    	 </div>
                    </form>

                  </div>
                </div>

            </div>
        </div>

    </div>
</div>