$().ready(function() {

    //Ajustes iniciais da página de cadastro
    var pathArray = window.location.href.split( '/' );
    var protocol = pathArray[0];
    var host = pathArray[2];
    var urlP = protocol + '//' + host;

    //Adição de máscara de edição

    $('#txt_ddd').mask('(999)');
    $('#txt_telefone').mask('9999-9999');
    $('#txt_cep').mask('99999-999');


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
                },
                txt_numero:{
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
				},
                txt_numero:{
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
            var estado          = $('#estados').val();
            var pais            = $('#pais').val();

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
              'estado' : estado,
              'pais'   : pais
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


    /*
    * APAGA OS TEXTOS NO FORMULARIO DE CADASTRO DE CLIENTE
    */
    function limpa_formulário_cep() {
        // Limpa valores do formulário de cep.
        $("#txt_endereco").val("");
        $("#txt_bairro").val("");
        $("#txt_cidade").val("");
        $("#estados").val(16);
        $("#pais").val(36);
    }

    /*
    * FUNÇÃO DE AUTOCOMPLETE VIA CEP
    */
    $('#txt_cep').blur(function() {

        //Nova variável "cep" somente com dígitos.
        var cep = $(this).val().replace(/\D/g, '');

        //Verifica se campo cep possui valor informado.
        if (cep != ""){

            //Expressão regular para validar o CEP.
            var validacep = /^[0-9]{8}$/;

            //Valida o formato do CEP.
            if(validacep.test(cep)){

                //Preenche os campos com "..." enquanto consulta webservice.
                $("#txt_endereco").val("...");
                $("#txt_bairro").val("...");
                $("#txt_cidade").val("...");
                $("#estados").val(16);
                $("#pais").val(36);

                //Consulta o webservice viacep.com.br/
                $.getJSON("//viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {

                    if (!("erro" in dados)) {
                        //Atualiza os campos com os valores da consulta.
                        $("#txt_endereco").val(dados.logradouro);
                        $("#txt_bairro").val(dados.bairro);
                        $("#txt_cidade").val(dados.localidade);

                        //console.log(dados.uf);
                        switch (dados.uf) {
                            case 'AC':
                                $("#estados").val(1);
                            break;
                            case 'AL':
                                $("#estados").val(2);
                            break;
                            case 'AP':
                                $("#estados").val(3);
                            break;
                            case 'AM':
                                $("#estados").val(4);
                            break;
                            case 'BA':
                                $("#estados").val(5);
                            break;
                            case 'CE':
                                $("#estados").val(5);
                            break;
                            case 'DF':
                                $("#estados").val(7);
                            break;
                            case 'ES':
                                $("#estados").val(8);
                            break;
                            case 'GO':
                                $("#estados").val(9);
                            break;
                            case 'MA':
                                $("#estados").val(10);
                            break;
                            case 'MT':
                                $("#estados").val(11);
                            break;
                            case 'MS':
                                $("#estados").val(12);
                            break;
                            case 'MG':
                                $("#estados").val(13);
                            break;
                            case 'PA':
                                $("#estados").val(14);
                            break;
                            case 'PB':
                                $("#estados").val(15);
                            break;
                            case 'PR':
                                $("#estados").val(16);
                            break;
                            case 'PE':
                                $("#estados").val(17);
                            break;
                            case 'PI':
                                $("#estados").val(18);
                            break;
                            case 'RJ':
                                $("#estados").val(19);
                            break;
                            case 'RN':
                                $("#estados").val(20);
                            break;
                            case 'RS':
                                $("#estados").val(21);
                            break;
                            case 'RO':
                                $("#estados").val(22);
                            break;
                            case 'RR':
                                $("#estados").val(23);
                            break;
                            case 'SC':
                                $("#estados").val(24);
                            break;
                            case 'SP':
                                $("#estados").val(25);
                            break;
                            case 'SE':
                                $("#estados").val(26);
                            break;
                            case 'TO':
                                $("#estados").val(27);
                            break;
                            default:
                                $("#estados").val(999);
                            break;
                        }

                    } //end if.
                    else {
                        //CEP pesquisado não foi encontrado.
                        limpa_formulário_cep();
                        swal("","CEP não encontrado.","error");
                    }
                });

            } //end if.
            else {
                //cep é inválido.
                limpa_formulário_cep();
                swal("","Formato de CEP inválido.","error");
            }

        }
        else{
            //cep sem valor, limpa formulário.
            limpa_formulário_cep();
        }

    });


    /*
    * INICIA O PROCESSO DE ATUALIZAÇÂO DO PERSONAGEM
    */
    $('.editFabricante').click(function(){

        var fabricante = $(this).val();
        console.log(fabricante);

        //EFETUA O CARREGAMENTO DOS DADOS DA FILIAL
        $.ajax({
            url: urlP+"/eficazmonitor/fabricante/carregarFabricanteJson",
            secureuri: false,
            type : "POST",
            dataType: 'json',
            data      : {
                'idFabricante' : fabricante
            },
            success : function(datra)
            {
                if(datra.status){

                    /*
                    * MASCARA PARA INPUTS DE EDIÇÂO
                    */
                    $('#txt_ddd').mask('(999)');
                    $('#txt_telefone').mask('9999-9999');
                    $('#txt_cep').mask('99999-999');

                    //alert("Cliente atualizado com sucesso!");

                    $('#idFabricante').val(datra.fabricante['id']);
                    $('#txt_fabricante').val(datra.fabricante['nome']);
                    $('#txt_ddd').val(datra.fabricante['ddd']);
                    $('#txt_telefone').val(datra.fabricante['telefone']);
                    $('#txt_email').val('');
                    $('#txt_cep').val(datra.fabricante['cep']);
                    $('#txt_endereco').val(datra.fabricante['endereco']);
                    $('#txt_numero').val(datra.fabricante['numero']);
                    $('#txt_cidade').val(datra.fabricante['cidade']);
                    $('#txt_bairro').val(datra.fabricante['bairro']);
                    $('#estados').val(datra.fabricante['id_estado']);
                    $('#pais').val(datra.fabricante['id_pais']);

                    $('#modalCadFabricantes').modal();

                    /*
                    'id' <font color='#888a85'>=&gt;</font> <small>string</small> <font color='#cc0000'>'5'</font> <i>(length=1)</i>
                    'id_estado' <font color='#888a85'>=&gt;</font> <small>string</small> <font color='#cc0000'>'8'</font> <i>(length=1)</i>
                    'id_pais' <font color='#888a85'>=&gt;</font> <small>string</small> <font color='#cc0000'>'36'</font> <i>(length=2)</i>
                    'nome' <font color='#888a85'>=&gt;</font> <small>string</small> <font color='#cc0000'>'No breaks ficticios'</font> <i>(length=19)</i>
                    'ddd' <font color='#888a85'>=&gt;</font> <small>string</small> <font color='#cc0000'>'41'</font> <i>(length=2)</i>
                    'telefone' <font color='#888a85'>=&gt;</font> <small>string</small> <font color='#cc0000'>'88888999'</font> <i>(length=8)</i>
                    'cep' <font color='#888a85'>=&gt;</font> <small>string</small> <font color='#cc0000'>'29105060'</font> <i>(length=8)</i>
                    'endereco' <font color='#888a85'>=&gt;</font> <small>string</small> <font color='#cc0000'>'Rua Seis'</font> <i>(length=8)</i>
                    'numero' <font color='#888a85'>=&gt;</font> <small>string</small> <font color='#cc0000'>'0'</font> <i>(length=1)</i>
                    'cidade' <font color='#888a85'>=&gt;</font> <small>string</small> <font color='#cc0000'>'Vila Velha'</font> <i>(length=10)</i>
                    'bairro' <font color='#888a85'>=&gt;</font> <small>string</small> <font color='#cc0000'>'Vila Nova'</font> <i>(length=9)</i>
                    */

                }else{
                    swal("", "Ocorreu um erro ao tentar carregar os dados filial, favor verificar os dados enviados!", "error");
                }

            },
            error: function(jqXHR, textStatus, errorThrown)
            {

                //Settar a mensagem de erro!
                      // alert("Ocorreu um erro ao atualizar o cliente, favor verificar os dados informados!");
                    swal("Oops...", "Ocorreu um erro ao carregar os dados, favor verificar mais tarde!", "error");
             // Handle errors here
             console.log('ERRORS: ' + textStatus +" "+errorThrown+" "+jqXHR);
             // STOP LOADING SPINNER
            }
        });

    });


});
