$(document).ready(function(){

	//Ajustes iniciais da página de cadastro
    var pathArray = window.location.href.split( '/' );
    var protocol = pathArray[0];
    var host = pathArray[2];
    var urlP = protocol + '//' + host;


	/*
	*	JSON Listener para listar as filiais do cliente caso existam
	*/

	$( "#clienteEquipamento" ).change(function() {

		var idCliente = $('#clienteEquipamento').val();

		//Ação ajax para buscar no BD as filiais cadastrada para o cliente
		//Efetua cadastro do cliente via JSON
            $.ajax({
             url: urlP+"/eficazmonitor/cliente/listarFiliaisClienteJson",
             secureuri: false,
             type : "POST",
             dataType: 'json',
             data      : {
              'idCliente' : idCliente,

              },
                   success : function(datra)
                    {	

                    	var statusCad   = datra.status;
                        var htmlFiliais	= datra.filiais;

                       //tempTest = JSON(datra);
                       if(datra.status == true)
                       {
                       	   
                       	   $('#filialEquipamento').append(htmlFiliais);
                       }
                       else
                       {
                           //Settar a mensagem de erro!
                       	   $('#filialEquipamento').append(htmlFiliais);
                       }
                    },
                   error: function(jqXHR, textStatus, errorThrown)
                    {
                    // Handle errors here
                    console.log('ERRORS: ' + textStatus +" "+errorThrown+" "+jqXHR);
                    // STOP LOADING SPINNER
                    }
            });
		
		
	});

	/*
	*	Cadastrar equipamento para o cliente
	*/

	$("#validarCadastroEquipamento").click(function() {

		$('#novoEquipamento').validate({
			rules: {
                clienteEquipamento:{
                    required : true
                },
              	txt_tipoEquip:{
              		required : true
              	},
              	txt_modeloEquip:{
              		required : true
              	},
              	txt_modeloEquip:{
              		required : true
              	},
              	txt_qntBateria:{
              		digits : true
              	}
            },
            messages: {
                clienteEquipamento: {
                    required : "Campo obrigatório"
                },
              	txt_tipoEquip:{
              		required : "Campo obrigatório"
              	},
              	txt_modeloEquip:{
              		required : "Campo obrigatório"
              	},
              	txt_modeloEquip:{
              		required : "Campo obrigatório"
              	},
              	txt_qntBateria:{
              		digits : "Apenas informar digitos!"
              	}
            }	
		});

		if($('#novoEquipamento').valid()){

			//$("#scope_input").val(ui.value).change();

			var idCliente 		= $('#clienteEquipamento').val();
			var idFilial  		= $('#filialEquipamento').val();
			var equipamento 	= $('#txt_tipoEquip').val();
			var modEquip 		= $('#txt_modeloEquip').val();
			var fabricante 		= $('[name=opc_fabricante]').val();
			var quantBateria	= $('#txt_qntBateria').val();
			var potencia		= $('#txt_potencia').val();
			var caracteristicas	= $('#txt_caracteristica').val();
			var amperagem 		= $('#txt_amperagem').val();
			var tipoBateria 	= $('#opc_tipoBateria').val();

			//Verifica se um fabricante foi selecionado!

			if($.isNumeric(fabricante)){
				
				//Efetua o registro do equipamento no BD

				$.ajax({
	             url: urlP+"/eficazmonitor/equipamento/registrarEquipamentoClienteJson",
	             secureuri: false,
	             type : "POST",
	             dataType: 'json',
	             data      : {
	              'idCliente' 		: idCliente,
	              'idFilial'  		: idFilial,
	              'equipamento'  	: equipamento,
	              'modEquip'  		: modEquip,
	              'fabricante'  	: fabricante,
	              'quantBateria'  	: quantBateria,
	              'caracteristicas' : caracteristicas,
	              'amperagem'  		: amperagem,
	              'tipoBateria'  	: tipoBateria,
	              'potencia'		: potencia

	              },
                   success : function(datra)
                    {	
                    	if(datra.status){
                    		alert("Equipamento cadastrado corretamente.");
                    		setTimeout(function(){
			                    window.location.replace(urlP +"/eficazmonitor/equipamento/");
			                }, 3000);
                    	}else{
                    		alert("Ocorreu um erro ao cadastrar o equipamento.");
                    	}
                    	//$array = array('status' => $result, 'idequipamento' => $idEquip);
                    	

                    },
                   error: function(jqXHR, textStatus, errorThrown)
                    {
                    // Handle errors here
                    console.log('ERRORS: ' + textStatus +" "+errorThrown+" "+jqXHR);
                    // STOP LOADING SPINNER
                    }
        });



			}else{
				alert('fabricante não foi selecionado!');
			}

			

		}


	});
  

  $('#nomeCliente').attr('readonly', true);
  $('#nomeFilial').attr('readonly', true);

  /*
  * Função para edição de equipamento 
  */

  $('#validarEdicaoEquipamento').click(function() {

    $('#editarEquipamento').validate({
      rules: {
        clienteEquipamento:{
          required : true
        },
        txt_tipoEquip:{
          required : true
        },
        txt_modeloEquip:{
          required : true
        },
        txt_modeloEquip:{
          required : true
        },
        txt_qntBateria:{
          digits : true
        }
      },
      messages: {
        clienteEquipamento: {
          required : "Campo obrigatório"
        },
        txt_tipoEquip:{
          required : "Campo obrigatório"
        },
        txt_modeloEquip:{
          required : "Campo obrigatório"
        },
        txt_modeloEquip:{
          required : "Campo obrigatório"
        },
        txt_qntBateria:{
          digits : "Apenas informar digitos!"
        }
      } 
    });

    if($('#editarEquipamento').valid()){
      //console.log('prossiga com a edição!!');

      //Efetua o registro do equipamento no BD

      $.ajax({
        url: urlP+"/eficazmonitor/equipamento/editarEquipamentoClienteJson",
        secureuri: false,
        type : "POST",
        dataType: 'json',
        data      : {
          'idCliente'     : idCliente,
          'idFilial'      : idFilial,
          'equipamento'   : equipamento,
          'modEquip'      : modEquip,
          'fabricante'    : fabricante,
          'quantBateria'    : quantBateria,
          'caracteristicas' : caracteristicas,
          'amperagem'     : amperagem,
          'tipoBateria'   : tipoBateria,
          'potencia'    : potencia

        },
        success : function(datra)
          { 
            if(datra.status){
                        alert("Equipamento cadastrado corretamente.");
                        setTimeout(function(){
                          window.location.replace(urlP +"/eficazmonitor/equipamento/");
              }, 3000);
            }else{
              alert("Ocorreu um erro ao cadastrar o equipamento.");
            }
            //$array = array('status' => $result, 'idequipamento' => $idEquip);
                      

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