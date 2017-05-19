//Ajustes iniciais da página de cadastro
var pathArray = window.location.href.split( '/' );
var protocol = pathArray[0];
var host = pathArray[2];
var urlP = protocol + '//' + host;

$(document).ready(function(){

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

    $('#txt_data_teste').mask('99/99/9999');
    $('#txt_edit_telefone_chip').mask('99 9999999999');

    $('#txt_telefone_number').mask('99999999999');
    $('#txt_chip_number').mask('999999999999999');
    $('.entradasMedidor').hide();

    /*
    * Adiciona datapicker ao formulario de data
    */
    var options = {
        dayNamesMin: [ "Dom", "Seg", "Ter", "Qua", "Qui", "Sex", "Sab" ],
        monthNames: [ "Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro" ],
        maxDate: "+0y +0m +0d",
        mindate: "-1y -6m",
        changeMonth: true,
        changeYear: true,
        yearRange: "c-1:c+1",
        monthRange: "c-6:c+0",
        dateFormat: "dd/mm/yy"
    }

     $("#txt_data_teste").datepicker(options);

    /*
    * Processo para ocultar ou exibir campos de cadastro de equipamento
    */
    $('#txt_tipoEquip').change(function() {

        var tipoEquipamento = $(this).val();

        /*
        * BUSCA PELO TIPO DE EQUIPAMENTO, PARA SUPORTAR OUTROS TIPOS DE EQUIPAMENTOS FUTURAMENTE
        */
        $.ajax({
            url: urlP+"/equipamento/buscaTipoEquipamentoJson",
            secureuri: false,
            type : "POST",
            dataType: 'json',
            data      : {
             'idTipoEquipamento' : tipoEquipamento,
            },
            success : function(datra)
            {
                if(datra.status){

                    switch (datra.tipoEquipamento) {
                        case 'Medidor temperatura':
                            $('.bateriaTipo').hide();
                            $('.quantidadesBateria').hide();
                            $('.bateriaTensao').hide();
                            $('.bateriaEquipamento').hide();
                            $('.entradaSaidaEquipamento').hide();
                            $('.fabricante').hide();
                            $('.entradasMedidorEditar').show();

                        break;
                        default:
                            $('.bateriaTipo').show();
                            $('.quantidadesBateria').show();
                            $('.bateriaTensao').show();
                            $('.bateriaEquipamento').show();
                            $('.entradaSaidaEquipamento').show();
                            $('.fabricante').show();
                            $('.entradasMedidorEditar').show();
                    
                        break;
                    }

                }else{
                    swal('','Tipo de equipamento não foi encontrado.','error');
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
	*	JSON Listener para listar as filiais do cliente caso existam
	*/

	$( "#clienteEquipamento" ).change(function() {

		var idCliente = $('#clienteEquipamento').val();

		//Ação ajax para buscar no BD as filiais cadastrada para o cliente
		//Efetua cadastro do cliente via JSON
            $.ajax({
             url: urlP+"/cliente/listarFiliaisClienteJson",
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
	             url: urlP+"/equipamento/registrarEquipamentoClienteJson",
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
			                    window.location.replace(urlP +"/equipamento/");
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

	/*
	* FUNÇÃO PARA SALVAR AS ALTERAÇÕES EFETUADAS NO CONTATO
	*/
	$('#registraAlteracao').click(function(){

		$('#edicaoContatoAlarme').validate({
			rules: {
				txt_nomeContato_edit : {
					required : true
				},
				txt_funcao_edit :{
					required : true
				},
				txt_email_edit : {
					required : true,
					email   : true
				},
				txt_celular_edit : {
					required : true
				}
			},
			messages: {
				txt_nomeContato_edit : {
					required : "Campo obrigatório"
				},
				txt_funcao_edit :{
					required : "Campo obrigatório"
				},
				txt_email_edit : {
					required : "Campo obrigatório",
					email   : "Favor informar um email válido!"
				},
				txt_celular_edit : {
					required : "Campo obrigatório"
				}
			}

		});

		if($('#edicaoContatoAlarme').valid()){

			var idEdit      = $('#idContatoEditar').val();
			var nomeEdit    = $('#txt_nomeContato_edit').val();
			var funcaoEdit  = $('#txt_funcao_edit').val();
			var emailEdit   = $('#txt_email_edit').val();
			var celularEdit = $('#txt_celular_edit').val();
			var obserEdit   = $('#txt_obs_edit').val();

			$.ajax({
			 url: urlP+"/equipamento/salvarEditContatoAlarmeJson",
			 secureuri: false,
			 type : "POST",
			 dataType: 'json',
			 data      : {
			  'idEdit' : idEdit,
			  'nomeEdit' : nomeEdit,
			  'funcaoEdit' : funcaoEdit,
			  'emailEdit' : emailEdit,
			  'celularEdit' : celularEdit,
			  'obserEdit' : obserEdit
			 },
			  success : function(datra)
			   {
				  //tempTest = JSON(datra);
				  if(datra.status == true)
				  {
					//alert('Vinculo cadastrado com sucesso!');
					swal("", "'Contato editado com sucesso!", "success");
					$('#editContato').modal('hide');
					setTimeout(function(){
						location.reload();
					}, 2000);
				  }
				  else
				  {
					//Settar a mensagem de erro!
					//alert('Ocorreu um ero ao tentar cadastrar!');
					swal("Oops...", "Ocorreu um ero ao tentar editar!", "error");
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

      var idEquip            = $('#idEquip').val();

      var idCliente 		 = $('#clienteEquipamento').val();
      var idFilial  		 = $('#filialEquipamento').val();

      var equipamento 	    = $('#txt_tipoEquip').val();
      var fabricante 		= $('#fabricante_opt').val();
      var nomeModelo        = $('#txt_nomeModeloEquip').val();

      var correnteBat       = $('#txt_correnteBat').val();
      var potencia          = $('#txt_potencia').val();
      var tensaoBanco       = $('#txt_tensao_bancoBat').val();
      var correnteBanco     = $('#txt_correnteBancoBat').val();

      var quantBat          = $('#txt_qntBateria').val();
      var quantBancoBat     = $('#txt_qntBancoBateria').val();
      var quantBatPorBanc   = $('#txt_qntBateriaPorBanco').val();

      var tipoBat           = $('#opc_tipoBateria').val();
      var localBat          = $('#opc_localBat').val();

	  var tipoEntrada       = $('#opc_tipoEntrada').val();
      var tipoSaida         = $('#opc_tipoSaida').val();

	  var tensaoMinBarramento = $('#txt_tensaoMinBarramentoBat').val();

      //Efetua o registro do equipamento no BD

      $.ajax({
        url: urlP+"/equipamento/editarEquipamentoClienteJson",
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
                          window.location.replace(urlP +"/equipamento/");
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
                  url: urlP+"/equipamento/removerEquipamentoJson",
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
             url: urlP+"/equipamento/registrarContatoAlarmeJson",
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

    /*
    * INICIA PROCESSO DE CADASTRO DE CHIP SIM
    */
    $('#adicionarNovoChipSim').click( function(){

        $('#modalCadastroChip').modal();

    });

    /*
    * RESETA OS DADOS DO CADASTRO AO FECHAR A MODAL
    */
    $('#modalCadastroChip').on('hidden.bs.modal', function (e) {
        $('#txt_chip_number').val('');
        $('#txt_telefone_number').val('');
        $('#txt_chip_modelo').val('');
    });

    /*
    * INICIA O PROCESSO DE CADASTRO DE NOVO CHIP
    */
    $('#cadastrarDadosSimBtn').click( function(){

        /*
        * INICIA VALIDAÇÃO DOS DADOS DO CHIP
        */
        $('#formCadChip').validate({
            rules: {
                txt_chip_number : {
                    required : true,
                    remote: {
                      url: urlP+"/vinculo/verificarSimExistente",
                      type: "post",
                      data: {
                        num_sim : function() {
                          //return  $("#txt_numSim" ).val();
                          return document.getElementById("txt_chip_number").value;
                        }
                      }
                    }
                },
                txt_telefone_number : {
                    required : true
                },
                txt_chip_modelo : {
                    required : true
                },
                txt_vercao_projeto : {
                    required : true
                }
            },
            messages: {
                txt_chip_number : {
                    required : "Campo é obrigatorio",
                    remote: "Número SIM já se encontra registrado no sistema!"
                },
                txt_telefone_number : {
                    required : "Campo é obrigatorio"
                },
                txt_chip_modelo : {
                    required : "Campo é obrigatorio"
                },
                txt_vercao_projeto : {
                    required : "Campo é obrigatorio"
                }
            }
        });
        /*
        * INICIA O CADASTRO EM CASO OS DADOS ESTIVEREM CORRETOS
        */
        if($('#formCadChip').valid()){

            /*
            * SOLICITA CONFIRMAÇÃO DO USUÁRIO, SOBRE OS DADOS DO CHIP A SER CADASTRADO.
            */
            swal({
              title: "Tem certeza?",
              text: "Os dados do chip cadastrado estão corretos?",
              type: "warning",
              showCancelButton: true,
              confirmButtonColor: "#DD6B55",
              confirmButtonText: "Sim, confirmo!",
              cancelButtonText: "Não, irei revisar!",
              closeOnConfirm: false,
              closeOnCancel: false
            },
            function(isConfirm){
              if (isConfirm) {

                /*
                * INICIA JSON PARA SALVAR OS DADO DO CHIP CADASTRADO
                */
                var numeroChip      = $('#txt_chip_number').val();
                var numeroTelefone  = $('#txt_telefone_number').val();
                var modeloChip      = $('#txt_chip_modelo').val();
                var versaoProjeto   = $('#txt_vercao_projeto').val();

                    $.ajax({
                     url: urlP+"/equipamento/registrarNovoChipJson",
                     secureuri: false,
                     type : "POST",
                     dataType: 'json',
                     data      : {
                      'numeroChip' : numeroChip,
        			  'numeroTelefone' : numeroTelefone,
        			  'modeloChip' : modeloChip,
                      'versaoProjeto' : versaoProjeto
                     },
                     success : function(datra)
                      {
                        if(datra.status){
                            swal('','Chip foi cadastrado corretamente.','success');
                            setTimeout(function(){
                                location.reload();
                            }, 2000);
                        }else{
                            swal("", "Não foi possivel completar o cadastro, tente novamente mais tarde.", "error");
                        }
                      },
                     error: function(jqXHR, textStatus, errorThrown)
                      {
                       // Handle errors here
                       console.log('ERRORS: ' + textStatus +" "+errorThrown+" "+jqXHR);
                       // STOP LOADING SPINNER
                      }
                    });
                } else {
                    swal("Cancelado", "Nenhum dado foi cadastrado ainda", "error");
                }
            });
        }

    });

    /*
    * FILTRO DE CHIP SIM
    */
    $('#filtroStatusChip').change(function() {

        $('#filtroClienteChip').val(' ');

        var statusChip = $(this).val();

        if(statusChip == 3){
            //$('#filtroClienteChip');
            $("#filtroClienteChip").prop('disabled', true);

        }else{
            $("#filtroClienteChip").prop('disabled', false);
        }

        $.ajax({
         url: urlP+"/equipamento/filtroStatusChipJson",
         secureuri: false,
         type : "POST",
         dataType: 'json',
         data      : {
          'statusChip' : statusChip
         },
          success : function(datra)
           {

              //tempTest = JSON(datra);
              if(datra.status == true)
              {
                  $('#stream_table tbody').html(datra.chipSims);
              }
              else
              {
                //Settar a mensagem de erro!
                //alert('Ocorreu um ero ao tentar cadastrar!');
                swal("Oops...", "Não foram encontrados SIMs na condição informada.", "error");
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
    * FILTRAR CHIPS POR STATUS DO CHIP E POR CLIENTE
    */
    $('#filtroClienteChip').change(function() {

        var clienteChip = $(this).val();

        var statusChip  = $('#filtroStatusChip').val();

        $.ajax({
            url: urlP+"/equipamento/filtroStatusChipClienteJson",
            secureuri: false,
            type : "POST",
            dataType: 'json',
            data      : {
             'statusChip' : statusChip,
             'idCliente'  : clienteChip
             },
             success : function(datra)
             {
                 //tempTest = JSON(datra);
                 if(datra.status == true)
                 {
                     $('#stream_table tbody').html(datra.chipSims);
                 }
                 else
                 {
                   //Settar a mensagem de erro!
                   //alert('Ocorreu um ero ao tentar cadastrar!');
                   swal("Oops...", "Não foram encontrados SIMs na condição informada.", "error");
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
    *  ATUALIZAR DADOS DO CHIP SIM
    */
    $('#editarDadosSimBtn').click(function(){

        var simChip         = $('#txt_chip_number').val();
        var telefoneChip    = $('#txt_edit_telefone_chip').val();
        var modeloChip      = $('#txt_modelo_chip').val();
        var versaoProjeto   = $('#txt_versao_projeto').val();
        var dataTeste       = $('#txt_data_teste').val();

        $.ajax({
            url: urlP+"/equipamento/atualizarDadosChipJson",
    		secureuri: false,
    		type : "POST",
    		dataType: 'json',
    		data      : {
    		  'simChip'        : simChip,
              'telefoneChip'   : telefoneChip,
              'modeloChip'     : modeloChip,
              'versaoProjeto'  : versaoProjeto,
              'dataTeste'      : dataTeste,
    		},
            success : function(datra)
            {
                if(datra.status == true){
                    swal('','Dados do chip atualizados com sucesso.','success');

                    setTimeout(function(){
                        location.reload();
                    }, 2000);

                }else{
                    swal('','Não foi póssivel atualizar os dados, favor verificar as informações.','error');

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

    // var options = {
    //     onText: "Ativado",
    //     onColor: 'primary',
    //     offColor: 'danger',
    //     offText: "Não ativo",
    //     animate: true,
    // };
    //
    // $("#simAtivado").bootstrapSwitch(options);
    // $("#simInstalado").bootstrapSwitch(options);

    /*
    * INICIA PROCESSO DE CADASTRAR CALIBRAÇÃO DO EQUIPAMENTO
    */
    // $('#validarCalibracaoEquipamento').click( function{
    //
    //
    //
    // });

    /*
    * INICIA PROCESSO DE FILTRAGEM DE EQUIPAMENTOS POR CLIENTE
    */
    $('#filtroClienteLista').change(function() {

        $('#filtroEstadoEquipamento').val(' ');

        var clienteId = $(this).val();

        $.ajax({
            url: urlP+"/equipamento/listarEquipamentosClienteJson",
    		secureuri: false,
    		type : "POST",
    		dataType: 'json',
            data      : {
                'idCliente' : clienteId
            },
            success : function(datra)
            {
                $('#stream_table_equipamentos tbody').html(' ');
                $('#stream_table_equipamentos tbody').html(datra.listaEquipamentos);

                $('#filtroEstadoEquipamento').html(' ');
                $('#filtroEstadoEquipamento').html(datra.estados);
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
    * INICIA PROCESSO DE FILTRO DE EQUIPAMENTOS POR ESTADOS QUE CONTÉM EQUIPAMENTOS
    */
    $('#filtroEstadoEquipamento').change(function() {

        var clienteId   = $('#filtroClienteLista').val();
        var estadoId    = $(this).val();

        $.ajax({
            url: urlP+"/equipamento/listarEquipamentosEstadoClienteJson",
    		secureuri: false,
    		type : "POST",
    		dataType: 'json',
            data      : {
                'idCliente' : clienteId,
                'idEstado' : estadoId
            },
            success : function(datra)
            {
                $('#stream_table_equipamentos tbody').html(' ');
                $('#stream_table_equipamentos tbody').html(datra.listaEquipamentos);
            },
            error: function(jqXHR, textStatus, errorThrown)
            {
              // Handle errors here
              console.log('ERRORS: ' + textStatus +" "+errorThrown+" "+jqXHR);
              // STOP LOADING SPINNER
            }
        });

    });

});

/*
* INICIA PROCESSO DE CARREGAR CONTATO PARA EDIÇÃO
*/
function atualizarContatoEquip(id_contatoAlerta){
	$.ajax({
		url: urlP+"/equipamento/carregarContatosAlarmesJson",
		secureuri: false,
		type : "POST",
		dataType: 'json',
		data      : {
		  'idContato' : id_contatoAlerta
		},
		success : function(datra)
		{
			//tempTest = JSON(datra);
			if(datra.status == true)
			{
				var id             	= datra.contato['id'];
				var nomeContato		= datra.contato['nome_contato'];
				var funcao	        = datra.contato['funcao'];
				var email	        = datra.contato['email'];
				var celular	    	= datra.contato['celular'];
				var observacao	    = datra.contato['observacao'];

			  $('#idContatoEditar').val(id);
			  $('#txt_nomeContato_edit').val(nomeContato);
			  $('#txt_funcao_edit').val(funcao);
			  $('#txt_email_edit').val(email);
			  $('#txt_celular_edit').val(celular);
			  $('#txt_obs_edit').val(observacao);

			   $('#editContato').modal();
			}
			else
			{
			  swal("", "Ocorreu um erro ao tentar recuperar os dados do contato, favor verificar o contato escolhido.", "error");

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

/*
* INICIA PROCESSO DE REMOVER CONTATO DA LISTA
*/
function removerContatoEquipamentoListaAlarmes(id_contatoAlerta){
	console.log(id_contatoAlerta);

    swal({
      title: "Tem certeza?",
      text: "Esta ação não podera ser desfeita!",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#DD6B55",
      confirmButtonText: "Sim, remover!",
      cancelButtonText: "Não, cancelar!",
      closeOnConfirm: false,
      closeOnCancel: false
    },
    function(isConfirm){
      if (isConfirm) {

        $.ajax({
         url: urlP+"/equipamento/removerContatosAlarmesJson",
         secureuri: false,
         type : "POST",
         dataType: 'json',
         data      : {
          'idContato' : id_contatoAlerta
         },
          success : function(datra)
           {
              //tempTest = JSON(datra);
              if(datra.status == true)
              {
                //alert('Vinculo cadastrado com sucesso!');
                swal("", "'Contato removido com sucesso!", "success");
                setTimeout(function(){
                    location.reload();
                }, 2000);
              }
              else
              {
                //Settar a mensagem de erro!
                //alert('Ocorreu um ero ao tentar cadastrar!');
                swal("Oops...", "Ocorreu um ero ao tentar remover!", "error");
              }
           },
          error: function(jqXHR, textStatus, errorThrown)
           {
           // Handle errors here
           console.log('ERRORS: ' + textStatus +" "+errorThrown+" "+jqXHR);
           // STOP LOADING SPINNER
           }
       });

      } else {
        swal("Cancelado", "Nenhuma ação foi aplicada.", "error");
      }
    });
}

/*
* CARREGA A MODAL COM OS DADOS DO CHIP SIM
*/
function carregarDadosChipSim(idChip){

    if(idChip > 0){

        $.ajax({
         url: urlP+"/equipamento/carregarDadosSIMJson",
         secureuri: false,
         type : "POST",
         dataType: 'json',
         data      : {
          'idChipSim' : idChip
         },
          success : function(datra)
           {
              //tempTest = JSON(datra);
              if(datra.status)
              {

                var idFilial    = datra.chipInformacao['id_filial'];
                var filial      = datra.chipInformacao['filial'];

                if(filial == null){
                    filial = 'Matriz';
                }

                var chipAtivo       = datra.chipInformacao['status_ativo'];
                var chipInstalado   = datra.chipInformacao['ativo_cliente'];


                // $(document).ready(function() {
                //     if(chipAtivo == 1){
                //         $("#simAtivado").bootstrapSwitch('setState', true);
                //     }else{
                //         $("#simAtivado").bootstrapSwitch('setState', false);
                //     }
                //
                //     if(chipInstalado == 1){
                //         $("#simInstalado").bootstrapSwitch('setState', true);
                //     }else{
                //         $("#simInstalado").bootstrapSwitch('setState', false);
                //     }
                // });

                if(chipAtivo == '1'){
                    //$("#simAtivado").bootstrapSwitch('setState', true);
                    $('#simAtivado').prop('checked', true);
                }else{
                    //$("#simAtivado").bootstrapSwitch('setState', false);
                    $('#simAtivado').prop('checked', false);
                }

                if(chipInstalado == '1'){
                    //$("#simInstalado").bootstrapSwitch('setState', true);
                    $('#simInstalado').prop('checked', true);
                }else{
                    //$("#simInstalado").bootstrapSwitch('setState', false);
                    $('#simInstalado').prop('checked', false);
                }

                $('#txt_data_desativacao').val(datra.dataDesativacao);
                $('#txt_data_instalacao').val(datra.dataAtivacao);
                $('#txt_data_teste').val(datra.dataTestes);

                $('#txt_chip_number').val(datra.chipInformacao['num_sim']);
                $('#text_cliente').val(datra.chipInformacao['id_cliente']);
                $('#text_filial').html("<option val='"+idFilial+"'>"+filial+"</option>" );
                $('#txt_versao_projeto').val(datra.chipInformacao['versao_projeto']);
                $('#txt_modelo_chip').val(datra.chipInformacao['modelo_chip']);
                $('#txt_edit_telefone_chip').val(datra.chipInformacao['telefone_chip']);


                $('#modalEditChip').modal();
              }
              else
              {
                //Settar a mensagem de erro!
                //alert('Ocorreu um ero ao tentar cadastrar!');
                swal("Oops...", "Ocorreu um ero ao tentar carregar os dados do chip!", "error");
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
}

/*
* INICIA PROCESSO DE CALIBRAÇÃO DE EQUIPAMENTO
*/
function calibrarequipamento(idEquipamento, posicao){

    /*
    * CARREGA OS DADOS DO EQUIPAMENTO
    */
    if(idEquipamento > 0){

        $.ajax({
            url: urlP+"/equipamento/carregarDadosPosicaoTabelaJson",
            secureuri: false,
            type : "POST",
            dataType: 'json',
            data      : {
             'idEquipamento' : idEquipamento,
             'posicao' : posicao
            },
            success : function(datra)
            {

                if(datra.status){

                    var ultimoDado = Number(datra.ultimoDado) / 100;
                    var n = ultimoDado.toFixed(2);
                    var registro = '';

                    //SWAL que exibirá um pronpt para o usuário informar o valor real recebido pelo medidor
                    swal({
                          customClass: "modCalibracao",
                          title: "Calibração!",
                          text: "Valor bruto enviado do equipamento na posição '"+posicao+"' : "+n+" ! Informe o valor real informado pelo medidor.",
                          type: "input",
                          showCancelButton: true,
                          closeOnConfirm: false,
                          animation: "slide-from-top",
                          inputPlaceholder: "000.00"
                        },
                        function(inputValue){
                          if (inputValue === false) return false;

                          if (inputValue === "") {
                            swal.showInputError("É necessario informar um valor!");
                            return false
                          }

                         //Função para cadastrar o valor de calibração da posição
                         registro = registrarCalibracaoEquipamento(idEquipamento, posicao, n, inputValue);

                         console.log(" Resultado calibracao "+ registro);

                        if(registro != false){
                            swal("Sucesso!", "Posição : " + posicao +" foi calibrada com sucesso, favor verificar os dados." , "success");
                        }else{
                            swal("Ops!", "Favor verificar o valor informado!", "error");
                        }

                          //swal("Nice!", "You wrote: " + inputValue, "success");
                    });
                }else{
                    swal('','Não foi possivel carragar este dado, favor verificar as informações e configuraçãoes do equipamento.','error');
                }

            },
            error: function(jqXHR, textStatus, errorThrown)
            {
                // Handle errors here
                console.log('ERRORS: ' + textStatus +" "+errorThrown+" "+jqXHR);
            }
        });

        //swal('','Teste ! '+idEquipamento,'success');

    }else{
        swal('','Favor verificar o equipamento que está tentando calibrar.','error');
    }


}

/*
* INICIA PROCESSO DE CADASTRO DE VALOR DE CALIBRAÇÂO
*/
function registrarCalibracaoEquipamento(idEquipamento, posicao, valorReal, valorRecebido){

    /*
    * VERIFICA SE O VALOR DIGITADO PELO USUÁRIO É VÁLIDO
    */
    if(isNaN(valorRecebido)){

        return false;
    }else{

        /*
            CAUCULO DA VARIAVEL DE CALIBRAÇÃO DE EQUIPAMENTO
            VALOR BRUTO VINDO DA TABELA  DIVIDIDO PELO VALOR REAL MEDIDO NO EQUIPAMENTO
            IGUAL A VARIAVEL DE CALIBRAÇÃO.
        */
        var calibracaoVal = valorRecebido / valorReal;

        //VARIAVEL DE CALIBRACAO É SALVO
        $.ajax({
            url: urlP+"/equipamento/salvarPosicaoTabelaJson",
            secureuri: false,
            type : "POST",
            dataType: 'json',
            data      : {
             'idEquipamento' : idEquipamento,
             'posicao' : posicao,
             'valorCalibracao' : calibracaoVal
            },
            success : function(datra)
            {
                if(datra.status){
                    return datra.resultado;
                }else{
                    return false;
                }
            },
            error: function(jqXHR, textStatus, errorThrown)
            {
                // Handle errors here
                console.log('ERRORS: ' + textStatus +" "+errorThrown+" "+jqXHR);

                return false;
            }
        });

        //return true;
    }

}

/*
* INICIA PROCESSO DE EXCLUSÃO DE EQUIPAMENTO
*/
function excluirEquipamentoBtn(idEquipamento){

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
                url: urlP+"/equipamento/removerEquipamentoJson",
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
}
