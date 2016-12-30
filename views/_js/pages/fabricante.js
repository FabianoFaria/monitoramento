$().ready(function() {

    //Ajustes iniciais da página de cadastro
    var pathArray = window.location.href.split( '/' );
    var protocol = pathArray[0];
    var host = pathArray[2];
    var urlP = protocol + '//' + host;

    //Adição de máscara de edição

    $('#txt_ddd').mask('(999)');
    $('#txt_telefone').mask('9999-9999');
    $('#txt_cep').mask('9999-999');


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
                },
                txt_telefone:{
    				required : true
                },
                txt_cep:{
    				required : true
                },
                txt_endereco:{
                    required : true
                },
                txt_cidade:{
                    required : true
                },
                txt_bairro:{
                    required : true
                },
                txt_email:{
                    required : true
                }
       		},
        	messages: {
	    		txt_fabricante: {
	    			required: "Nome do cliente é oblrigatorio."
	    		},
	    	    txt_ddd:{
				    required : "Campo é obrigatorio"
				},
                txt_telefone:{
				    required : "Campo é obrigatorio"
				},
                txt_cep:{
				    required : "Campo é obrigatorio"
				},
                txt_endereco:{
				    required : "Campo é obrigatorio"
				},
                txt_cidade:{
				    required : "Campo é obrigatorio"
				},
                txt_bairro:{
				    required : "Campo é obrigatorio"
				},
                txt_email:{
				    required : "Campo é obrigatorio"
				}

    		}

    	});

        if($("#cadFabricanet").valid()){

            var novoFabricante  = $('#txt_fabricante').val();
            var ddd             = $('#txt_ddd').val();
            var telefone        = $('#txt_telefone').val();
            var email           = $('#txt_email').val();
            var cep             = $('#txt_cep').val();
            var endereco        = $('#txt_endereco').val();
            var cidade          = $('#txt_cidade').val();
            var bairro          = $('#txt_bairro').val();
            var numero          = $('#txt_numero').val();

            //Efetua o cadastro via JSON
            //Efetua cadastro do cliente via JSON
            $.ajax({
             url: urlP+"/eficazmonitor/fabricante/registraFabricanteJSON",
             secureuri: false,
             type : "POST",
             dataType: 'json',
             data      : {
              'novoFabricante' : novoFabricante,
              'ddd' : ddd,
              'telefone' : telefone,
              'cep' : cep,
              'endereco' : endereco,
              'numero' : numero,
              'bairro' : bairro,
              'cidade' : cidade,
              'estado' : 5,
              'pais'   : 36
              },
                success : function(datra)
                {
                    //tempTest = JSON(datra);
                    if(datra.status == true)
                    {
                       	var statusCad      = datra.status;
                       	$('#resultadoPositivo').fadeIn();
                        setTimeout(function(){
                            window.location.replace(urlP +"/eficazmonitor/fabricante/");
                        }, 3000);
                    }
                    else
                    {
                        //Settar a mensagem de erro!
                       	$('#resultadoCadastro').html("Algo não foi registrado!" +  statusCad);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown)
                {
                    // Handle errors here
                    console.log('ERRORS: ' + textStatus +" "+errorThrown+" "+jqXHR);
                    // STOP LOADING SPINNER
                }
            });
        }

    });


});
