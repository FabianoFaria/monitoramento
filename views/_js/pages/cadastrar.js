$().ready(function() {

    //Ajustes iniciais da página de cadastro

    //Collapse dados do usuário
    $('#accordionCliente').hide();

    //Collapse dos dados de filiais
    $('#accordionFiliais').hide();

    // validate signup form on keyup and submit
	$("#cadCliete").validate({
		rules: {
			txt_cliente: {
                    required: true
			    },
            txt_ddd:{
                required: true
            },
            txt_telefone:{
                required: true
            },
            txt_cep:{
                required: true
            },
            txt_bairro:{
                required: true
            },
            txt_cidade:{
                required:true
            },
            opc_pais:{
                required:true
            }

			},
        messages: {
    		txt_cliente: {
    			required: "Nome do cliente é oblrigatorio."
    		},
            txt_ddd: {
                required: "DDD deve ser informado!"
            },
            txt_telefone: {
                required: "Telefone deve ser informado!"
            },
            txt_cep: {
                required: "CEP deve ser informado."
            },
            txt_bairro: {
                required: "Bairro deve ser informado"
            },
            txt_cidade:{
                required: "Favor informar uma cidade"
            },
            opc_pais:{
                required: "Favor informar o país"
            }
    	}
    });

    if($("#cadCliete").valid()){
        console.log("prossiga!");
    }

});
