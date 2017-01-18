$().ready(function() {


	$('#salvar_edicao').click(function(){

		//valida se as regras para cadastro do contato estão corretas
                $('#edit_usuario').validate({

                        rules: {
                                txt_nome : true
                	},
                	 messages:{
                                txt_nome : "Campo obrigatório"
                	 }
                });

                 //Ao verificar se os dados de contato do usuário 
                if($('#edit_usuario').valid()){

                        console.log('Continue...');
                	
                }

	});



});
