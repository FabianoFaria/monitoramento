$().ready(function() {



	//Collapse dados do usuário
    $('#accordionCliente').hide();


    $('#salvarFabricante').click(function(){

    	$('#cadFabricanet').validate({
    		rules: {
			txt_fabricante: {
                    required: true
			    },
			txt_ddd:{
				required : true
				}

       		},
        	messages: {
	    		txt_fabricante: {
	    			required: "Nome do cliente é oblrigatorio."
	    		},
	    	txt_ddd:{
				required : "Campo é obrigatorio"
				}
            
    		}

    	});

    });


});
