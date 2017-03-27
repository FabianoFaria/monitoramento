$(document).ready(function(){

	//Ajustes iniciais da página de cadastro
    var pathArray = window.location.href.split( '/' );
    var protocol = pathArray[0];
    var host = pathArray[2];
    var urlP = protocol + '//' + host;

    /*
    * APLICAÇÃO DE MASCARAS PARA OS CAMPOS DO FORMULARIOS
    */

    $('#txt_correnteBat').mask('999.99');
    $('#txt_potencia').mask('999.99');
    $('#txt_tensao_bancoBat').mask('999.99');
    $('#txt_correnteBancoBat').mask('999.99');
    $('#txt_qntBateria').mask('999');
    $('#txt_qntBancoBateria').mask('999');
    $('#txt_qntBateriaPorBanco').mask('999');
	$('#txt_tensaoMinBarramentoBat').mask('99.9');

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
                           $('#filialEquipamento').html('');
                       	   $('#filialEquipamento').append(htmlFiliais);
                       }
                       else
                       {
                           //Settar a mensagem de erro!
                           $('#filialEquipamento').html('');

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
                txt_nomeModeloEquip:{
                    required : true
                },
                txt_tipoEquip:{
              		required : true
              	},
                fabricante_opt:{
                    required : true
                },
                txt_correnteBat:{
                    required : true
                },
                txt_potencia : {
                    required : true
                },
                txt_tensao_bancoBat :{
                    required : true
                },
                txt_correnteBancoBat :{
                    required : true
                },
                opc_tipoBateria :{
                    required : true
                },
                opc_localBat :{
                    required : true
                },
				opc_tipoEntrada :{
                    required : true
                },
				opc_tipoSaida :{
                    required : true
                },
				txt_qntBateria :{
					required : true
				},
				txt_qntBancoBateria :{
					required : true
				},
				txt_qntBateriaPorBanco :{
					required : true
				},
				txt_tensaoMinBarramentoBat : {
					min: 10.0
				}

            },
            messages: {
                clienteEquipamento:{
                    required : "Campo obrigatório"
                },
                txt_nomeModeloEquip:{
                    required : "Campo obrigatório"
                },
                txt_tipoEquip:{
                    required : "Campo obrigatório"
                },
                fabricante_opt:{
                    required : "Campo obrigatório"
                },
                txt_correnteBat:{
                    required : "Campo obrigatório"
                },
                txt_potencia : {
                    required : "Campo obrigatório"
                },
                txt_tensao_bancoBat :{
                    required : "Campo obrigatório"
                },
                txt_correnteBancoBat :{
                    required : "Campo obrigatório"
                },
                opc_tipoBateria :{
                    required : "Campo obrigatório"
                },
                opc_localBat :{
                    required : "Campo obrigatório"
                },
				opc_tipoEntrada :{
                    required : "Campo obrigatório"
                },
				opc_tipoSaida :{
                    required : "Campo obrigatório"
                },
				txt_qntBateria :{
					required : "Campo obrigatório"
				},
				txt_qntBancoBateria :{
					required : "Campo obrigatório"
				},
				txt_qntBateriaPorBanco :{
					required : "Campo obrigatório"
				},
				txt_tensaoMinBarramentoBat : {
					min: "Valor minimo é de 10.0"
				}
            }
		});

		if($('#novoEquipamento').valid()){

            /*
            * Remove o botão #validarCadastroEquipamento
            */
            $('#validarCadastroEquipamento').unbind();
			//$("#scope_input").val(ui.value).change();

            var idCliente 		= $('#clienteEquipamento').val();
            var idFilial  		= $('#filialEquipamento').val();

            var equipamento 	= $('#txt_tipoEquip').val();
            var fabricante 		= $('#fabricante_opt').val();
            var nomeModelo      = $('#txt_nomeModeloEquip').val();

            var correnteBat     = $('#txt_correnteBat').val();
            var potencia        = $('#txt_potencia').val();
            var tensaoBanco     = $('#txt_tensao_bancoBat').val();
            var correnteBanco   = $('#txt_correnteBancoBat').val();

			var tensaoMinBarramento = $('#txt_tensaoMinBarramentoBat').val();

            var quantBat        = $('#txt_qntBateria').val();
            var quantBancoBat   = $('#txt_qntBancoBateria').val();
            var quantBatPorBanc = $('#txt_qntBateriaPorBanco').val();

            var tipoBat         = $('#opc_tipoBateria').val();
            var localBat        = $('#opc_localBat').val();

			var tipoEntrada  	= $('#opc_tipoEntrada').val();
			var tipoSaida  		= $('#opc_tipoSaida').val();

			//Verifica se um fabricante foi selecionado!

			//if($.isNumeric(fabricante)){

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
                  'fabricante'  	: fabricante,
                  'nomeModelo'      : nomeModelo,
                  'correnteBateria' : correnteBat,
                  'potencia'        : potencia,
                  'tensaoBancoBat'  : tensaoBanco,
                  'correnteBanco'   : correnteBanco,
                  'quantBat'        : quantBat,
                  'quantBancoBat'   : quantBancoBat,
                  'quantBatPorBanc' : quantBatPorBanc,
                  'tipoBateria'     : tipoBat,
                  'localBateria'    : localBat,
				  'tipoEntrada'  	: tipoEntrada,
				  'tipoSaida'  		: tipoSaida,
				  'tensaoMinBarramento' : tensaoMinBarramento
                },

                   success : function(datra)
                    {
                    	if(datra.status){
                    		//alert("Equipamento cadastrado corretamente.");
                            swal("", "Equipamento cadastrado corretamente!", "success");
                    		setTimeout(function(){
			                    window.location.replace(urlP +"/eficazmonitor/equipamento/");
			                }, 3000);
                    	}else{
                    		//alert("Ocorreu um erro ao cadastrar o equipamento.");
                            swal("Oops...!", "Ocorreu um erro ao cadastrar o equipamento!", "error");
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

			// }else{
			// 	//alert('fabricante não foi selecionado!');
            //     swal("", "Favor selecionar um fabricante!", "info");
			// }

		}


	});


  $('#nomeCliente').attr('readonly', true);
  $('#nomeFilial').attr('readonly', true);
  $('#txt_tipoEquip').attr('readonly', true);

  /*
  * Função para edição de equipamento
  */

  $('#validarEdicaoEquipamento').click(function() {

    $('#editarEquipamento').validate({
      rules: {
          clienteEquipamento:{
              required : true
          },
          txt_nomeModeloEquip:{
              required : true
          },
          txt_tipoEquip:{
              required : true
          },
          fabricante_opt:{
              required : true
          },
          txt_correnteBat:{
              required : true
          },
          txt_potencia : {
              required : true
          },
          txt_tensao_bancoBat :{
              required : true
          },
          txt_correnteBancoBat :{
              required : true
          },
          opc_tipoBateria :{
              required : true
          },
          opc_localBat :{
              required : true
          },
		  opc_tipoEntrada :{
			  required : true
		  },
		  opc_tipoSaida :{
			  required : true
		  },
		  txt_qntBateria :{
			  required : true
		  },
		  txt_qntBancoBateria :{
			  required : true
		  },
		  txt_qntBateriaPorBanco :{
			  required : true
		  },
		  txt_tensaoMinBarramentoBat : {
				min: 10.0
		  }
      },
      messages: {
          clienteEquipamento:{
              required : "Campo obrigatório"
          },
          txt_nomeModeloEquip:{
              required : "Campo obrigatório"
          },
          txt_tipoEquip:{
              required : "Campo obrigatório"
          },
          fabricante_opt:{
              required : "Campo obrigatório"
          },
          txt_correnteBat:{
              required : "Campo obrigatório"
          },
          txt_potencia : {
              required : "Campo obrigatório"
          },
          txt_tensao_bancoBat :{
              required : "Campo obrigatório"
          },
          txt_correnteBancoBat :{
              required : "Campo obrigatório"
          },
          opc_tipoBateria :{
              required : "Campo obrigatório"
          },
          opc_localBat :{
              required : "Campo obrigatório"
          },
		  opc_tipoEntrada :{
			 required : "Campo obrigatório"
		 },
		 opc_tipoSaida :{
			 required : "Campo obrigatório"
		 },
		 txt_qntBateria :{
			 required : "Campo obrigatório"
		 },
		 txt_qntBancoBateria :{
			 required : "Campo obrigatório"
		 },
		 txt_qntBateriaPorBanco :{
			 required : "Campo obrigatório"
		 },
		 txt_tensaoMinBarramentoBat : {
			   min: "Valor minimo é de 10.0"
		 }
      }
    });

    if($('#editarEquipamento').valid()){
      //console.log('prossiga com a edição!!');

      var idEquip           = $('#idEquip').val();

      var idCliente 		= $('#clienteEquipamento').val();
      var idFilial  		= $('#filialEquipamento').val();

      var equipamento 	 = $('#txt_tipoEquip').val();
      var fabricante 		= $('#fabricante_opt').val();
      var nomeModelo      = $('#txt_nomeModeloEquip').val();

      var correnteBat     = $('#txt_correnteBat').val();
      var potencia        = $('#txt_potencia').val();
      var tensaoBanco     = $('#txt_tensao_bancoBat').val();
      var correnteBanco   = $('#txt_correnteBancoBat').val();

      var quantBat        = $('#txt_qntBateria').val();
      var quantBancoBat   = $('#txt_qntBancoBateria').val();
      var quantBatPorBanc = $('#txt_qntBateriaPorBanco').val();

      var tipoBat         = $('#opc_tipoBateria').val();
      var localBat        = $('#opc_localBat').val();

	  var tipoEntrada     = $('#opc_tipoEntrada').val();
      var tipoSaida      = $('#opc_tipoSaida').val();

	  var tensaoMinBarramento = $('#txt_tensaoMinBarramentoBat').val();

      //Efetua o registro do equipamento no BD

      $.ajax({
        url: urlP+"/eficazmonitor/equipamento/editarEquipamentoClienteJson",
        secureuri: false,
        type : "POST",
        dataType: 'json',
        data      : {
          'idEquip'         : idEquip,
          'idCliente' 		: idCliente,
          'idFilial'  		: idFilial,
          'equipamento'  	: equipamento,
          'fabricante'  	: fabricante,
          'nomeModelo'      : nomeModelo,
          'correnteBateria' : correnteBat,
          'potencia'        : potencia,
          'tensaoBancoBat'  : tensaoBanco,
          'correnteBanco'   : correnteBanco,
          'quantBat'        : quantBat,
          'quantBancoBat'   : quantBancoBat,
          'quantBatPorBanc' : quantBatPorBanc,
          'tipoBateria'     : tipoBat,
          'localBateria'    : localBat,
		  'tipoEntrada'     : tipoEntrada,
          'tipoSaida'    	: tipoSaida,
		  'tensaoMinBarramento' : tensaoMinBarramento
        },
        success : function(datra)
          {
            if(datra.status){
                        //alert("Equipamento editado corretamente.");
                        swal("", "Equipamento editado corretamente.", "success");
                        setTimeout(function(){
                          window.location.replace(urlP +"/eficazmonitor/equipamento/");
              }, 3000);
            }else{
              //alert("Ocorreu um erro ao editar o equipamento.");
              swal("Oops...", "Ocorreu um erro ao editar o equipamento.", "error");
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

  /*
  * REMOVER EQUIPAMENTO VIA JSON
  */
  $('.btnRemoveEquip').click(function(){

      var idEquipamento = $(this).val();

      swal({
        title: "Tem certeza?",
        text: "Está ação não poderá ser desfeita!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Sim, deletar!",
        cancelButtonText: "Não, cancelar!",
        closeOnConfirm: false,
        closeOnCancel: false
      },
      function(isConfirm){
        if (isConfirm) {

              //Efetua o carregamento dos dados da filial
              $.ajax({
                  url: urlP+"/eficazmonitor/equipamento/removerEquipamentoJson",
                  secureuri: false,
                  type : "POST",
                  dataType: 'json',
                  data      : {
                      'idEquipamento' : idEquipamento
                  },
                  success : function(datra)
                  {
                      if(datra.status){
                          swal("Removido!", "Equipamento foi desativado no sistema!", "success");
                          setTimeout(function(){
                              location.reload();
                          }, 2000);
                      }else{
                          //swal("Deleted!", "Your imaginary file has been deleted.", "success");
                          swal("Oops!", "Ocorreu um erro ao tentar remover equipamento do sistema, tente novamente mais tarde!", "error");
                      }
                  },
                  error: function(jqXHR, textStatus, errorThrown)
                  {

                      //Settar a mensagem de erro!
                            // alert("Ocorreu um erro ao atualizar o cliente, favor verificar os dados informados!");
                          swal("Oops...", "Ocorreu um erro ao carregar, favor verificar os dados informados!", "error");
                   // Handle errors here
                   console.log('ERRORS: ' + textStatus +" "+errorThrown+" "+jqXHR);
                   // STOP LOADING SPINNER
                  }
              });

        } else {
          swal("Cancelado", "Nenhuma ação ocorreu!", "error");
        }
      });

  });


	/*
	* INICIA PROCESSO DE CADASTRO DE CONTATO DE EQUIPAMENTO
	*/
	$('#registrarContato').click(function(){

		$('#novoContatoAlarme').validate({
			rules: {
				sedeContato: {
					required : true
				},
				txt_nomeContato : {
					required : true
				},
				txt_funcao :{
					required : true
				},
				txt_email : {
					required : true,
					email   : true
				},
				txt_celular : {
					required : true
				}
			},
			messages: {
				sedeContato: {
                    required : "Campo é obrigatorio"
                },
                txt_nomeContato : {
                    required : "Campo é obrigatorio"
                },
                txt_funcao : {
                    required : "Campo é obrigatorio"
                },
                txt_email : {
                    required : "Campo é obrigatorio",
                    email : "Email deve estar no formato correto!"
                },
                txt_celular : {
                    required : "Campo é obrigatorio"
                }
			}
		});

		if($('#novoContatoAlarme').valid()){

            var idMatriz    	= $('#idMatriz').val();
			var id_filial    	= $('#idFilial').val();
			var idEquipamento 	= $('#idEquipamento').val();
            var sedeContato 	= $('#sedeContato').val();
            var nomeContato	 	= $('#txt_nomeContato').val();
            var funcaoContato 	= $('#txt_funcao').val();
            var emailContato 	= $('#txt_email').val();
            var celularContato 	= $('#txt_celular').val();
            var obsContato 		= $('#txt_obs').val();

            $.ajax({
             url: urlP+"/eficazmonitor/equipamento/registrarContatoAlarmeJson",
             secureuri: false,
             type : "POST",
             dataType: 'json',
             data      : {
              'idMatriz' : idMatriz,
			  'idFilial' : id_filial,
			  'idEquipamento' : idEquipamento,
              'sedeContato' : sedeContato,
              'nomeContato' : nomeContato,
              'funcaoContato' : funcaoContato,
              'emailContato' : emailContato,
              'celularContato' : celularContato,
              'obsContato' : obsContato
             },
              success : function(datra)
               {

                  //tempTest = JSON(datra);
                  if(datra.status == true)
                  {

                    //alert('Vinculo cadastrado com sucesso!');
                    swal("", "'Contato registrado com sucesso!", "success");
                    setTimeout(function(){
                        location.reload();
                    }, 2000);
                  }
                  else
                  {
                    //Settar a mensagem de erro!
                    //alert('Ocorreu um ero ao tentar cadastrar!');
                    swal("Oops...", "Ocorreu um ero ao tentar cadastrar!", "error");
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
