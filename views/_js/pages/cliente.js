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
    $('#txt_telefone_contato').mask('(999) 9999-9999');
    $('#txt_celular_contato').mask('(999) 9999-9999');


    //Collapse dados do usuário
    $('#accordionCliente').hide();

    //Collapse dos dados de filiais
    $('#accordionFiliais').hide();

    //PROCESSO DE VALIDAÇÃO DE CADASTRO DE CLIENTE
    $('#validarResponsavel').click(function() {

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
                txt_endereco:{
                    required : true
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
                txt_endereco: {
                    required: "Favor informar um endereço!"
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

        //Caso os dados estejam corretos, será exibido o formulario seguinte e o formulario atual se tornara readOnly
        if($("#cadCliete").valid()){

            //Efetua o cadastro da empresa cliente

            //Dados da empresa do cliente
            var nomeCliente     = $('#txt_cliente').val();
            var ddd             = $('#txt_ddd').val();
            var telefone        = $('#txt_telefone').val();
            var cep             = $('#txt_cep').val();
            var endereco        = $('#txt_endereco').val();
            var numero          = $('#txt_numero').val();
            var bairro          = $('#txt_bairro').val();
            var cidade          = $('#txt_cidade').val();
            var estado          = $('#estado').val();
            var pais            = $('#pais').val();

            //Efetua cadastro do cliente via JSON
            $.ajax({
             url: urlP+"/eficazmonitor/cliente/registrarClientes",
             secureuri: false,
             type : "POST",
             dataType: 'json',
             data      : {
              'nome_cliente' : nomeCliente,
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
                           var idClienteCad   = datra.idCliente;
                       	   $('#resultadoCadastro').val(idClienteCad);
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

            //Após concluir o cadastro, trava os campos do formulario da empresa cliente

            $('#cadCliete input').prop('readonly', true);

            $('#accordionCliente').fadeIn();
        }
    });

    //VALIDA OS DADOS DO CONTATO DO CLIETE
    $('#validarContatoCliente').click(function(){

        //valida se as regras para cadastro do contato estão corretas
        $('#cadContatoCliente').validate({
            rules: {
                txt_nome_contato:{
                    required : true
                },
                txt_sobrenome_contato: {
                    required : true
                },
                txt_email_contato:{
                    required: true,
                    email: true
                },
                txt_telefone_contato:{
                    required:true

                },
                txt_celular_contato:{
                    required : true

                },
                txt_senha_contato : {
                    required : true

                },
                txt_cfsenha_contato : {
                    required : true,
                    equalTo  : "#txt_senha_contato"
                }
            },
            messages: {
                txt_nome_contato: {
                    required : "Campo obrigatório"
                },
                txt_sobrenome_contato :{
                    required : "Campo obrigatório"
                },
                txt_email_contato:{
                    required : "Campo obrigatório",
                    email : "Favor informar um endereço válido"
                },
                txt_telefone_contato:{
                    required : "Campo obrigatório"

                },
                txt_celular_contato:{
                    required : "Campo obrigatório"

                },
                txt_senha_contato:{
                    required : "Campo obrigatório"
                },
                txt_cfsenha_contato : {
                    required : "Campo obrigatório",
                    equalTo : "Senhas para usuário devem ser identicas"
                }
            }


        });
        //Ao verificar se os dados de contato do cliente estão válidas e então procegue o cadastro do cliente
        if($('#cadContatoCliente').valid()){

            //Efetua o cadastro do usuário para o o cliente cadastrado no processo anterior

            //Dados do contato do cliente

            var nomeContato     = $('#txt_nome_contato').val();
            var sobrenome       = $('#txt_sobrenome_contato').val();
            var emailContato    = $('#txt_email_contato').val();
            var celularContato  = $('#txt_celular_contato').val();
            var telefoneContato = $('#txt_telefone_contato').val();
            var senhaContato    = $('#txt_senha_contato').val();
            var confirmaSenha   = $('#txt_cfsenha_contato').val();
            var idCliente       = $('#resultadoCadastro').val();

            //Efetua o cadastro do contato do cliente via JSON
            $.ajax({
                url: urlP+"/eficazmonitor/usuario/registraUsuario",
                secureuri: false,
                type : "POST",
                dataType: 'json',
                data      : {
                    'nome'      : nomeContato,
                    'sobrenome' : sobrenome,
                    'email'     : emailContato,
                    'celular'   : celularContato,
                    'telefone'  : telefoneContato,
                    'senha'     : senhaContato,
                    'confirmaS' : confirmaSenha,
                    'idCliente' : idCliente
                },
                success : function(datra)
                {
                    console.log("Prossiga!");
                },
                error: function(jqXHR, textStatus, errorThrown)
                {
                 // Handle errors here
                 console.log('ERRORS: ' + textStatus +" "+errorThrown+" "+jqXHR);
                 // STOP LOADING SPINNER
                }
            });

            $('#cadContatoCliente input').prop('readonly', true);

            $('#accordionFiliais').fadeIn();
        }

        //Verifica se o cliente possui filiais
        $('#temFiliais').click(function() {
            if(this.checked) {
                $('#listaFiliais').fadeIn();
            }else{
                $('#listaFiliais').fadeOut();
            }
        });

    });

    //Adiciona novo formulario para cadastro de filial
    $('#adicionarNovaFilial').click(function(){

        $('<div/>', {
            'class' : 'filiais', html: GetHtml()
        }).hide().appendTo('#listaFiliais').slideDown('slow');

    });

    //Efetua a numeração dos formularios de filiais conforme forem sendo gerados
    function GetHtml()
    {
      var len = $('#countFiliais').val();
      len++;
      var $html = $('.templateHtml').clone();
      $html.find('[name=txt_filial]')[0].name="txt_filial" + len;
      $html.find('[name=txt_ddd]')[0].name="txt_ddd" + len;
      $html.find('[name=txt_telefone]')[0].name="txt_telefone" + len;
      $html.find('[name=txt_cep]')[0].name="txt_cep" + len;
      $html.find('[name=txt_endereco]')[0].name="txt_endereco" + len;
      $html.find('[name=txt_numero]')[0].name="txt_numero" + len;
      $html.find('[name=txt_bairro]')[0].name="txt_bairro" + len;
      $html.find('[name=txt_cidade]')[0].name="txt_cidade" + len;

      //setta no html a contagem atual de formularios de filiais adicionados
      $('#countFiliais').val(len);
      //Retorna o formulario gerado com a numeração especificada
      return $html.html();
    }


    //Testar validação dos dados das filiais cadastradas antes de enviar
    //$(document).ready(function (){

        $('#concluirCadastro').click(function() {

            //VERIFICA SE CLIENTE POSSUI FILIAIS
            var check = $('input:checkbox[name=temFiliais]').is(':checked');

            console.log('verificando check : '+ check);

            if(check == true){

                console.log("Prossiga !");

                //INICIA O TRATAMENTO DOS FORMULARIOS DE FILIAIS

                var quantidadeFiliais = $('#countFiliais').val();


                //INICIA O LOOP DE CADASTRO DE FILIAIS

                for(var i = 1; i <= quantidadeFiliais; i++){

                    console.log("Cadastrando a filial : "+i);

                    var idMatriz    = $('#resultadoCadastro').val();
                    var nomeFilial  = $('[name=txt_filial'+i+']').val();
                    var codigoArea  = $('[name=txt_ddd'+i+']').val();
                    var telefone    = $('[name=txt_telefone'+i+']').val();
                    var cepFilial   = $('[name=txt_cep'+i+']').val();
                    var endereco    = $('[name=txt_endereco'+i+']').val();
                    var numero      = $('[name=txt_numero'+i+']').val();
                    var bairro      = $('[name=txt_bairro'+i+']').val();
                    var cidade      = $('[name=txt_cidade'+i+']').val();
                    var estado      = $('[name=opc_estado'+i+']').val();

                    if((nomeFilial != " " && endereco != " ")){


                        //Envio de dados para cadastro de filial via JSON
                        $.ajax({
                            url: urlP+"/eficazmonitor/filial/registraFilial",
                            secureuri: false,
                            type : "POST",
                            dataType: 'json',
                            data      : {
                                'nomeFilial': nomeFilial,
                                'codigoArea': codigoArea,
                                'telefone'  : telefone,
                                'cepFilial' : cepFilial,
                                'endereco'  : endereco,
                                'numero'    : numero,
                                'bairro'    : bairro,
                                'cidade'    : cidade,
                                'idEstado'  : 3,
                                'idPais'    : 36,
                                'idMatriz'  : idMatriz
                            },
                            success : function(datra)
                            {
                                console.log("Prossiga com o for!");
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

                $('#resultadoPositivo').fadeIn();

                setTimeout(function(){
                    window.location.replace(urlP +"/eficazmonitor/cliente/");
                }, 3000);

            }else{
                //FINALIZA O PROCESSO DE CADASTRO DE EMPRESAS CLIENTES

                setTimeout(function(){
                        window.location.replace(urlP +"/eficazmonitor/cliente/");
                    }, 1500);

            }

        });


    //});

    //Efetua a validação dos dados antes de efetua a atualização dos dados do Cliente

    $('#editarClienteExistente').click(function() {

       // validate signup form on keyup and submit
        $("#editCliete").validate({
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
                txt_endereco:{
                    required : true
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
                txt_endereco: {
                    required: "Favor informar um endereço!"
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

        if($("#editCliete").valid()){

            //Dados da empresa do cliente
            var idCliente       = $('#txt_idCliente').val();
            var nomeCliente     = $('#txt_cliente').val();
            var ddd             = $('#txt_ddd').val();
            var telefone        = $('#txt_telefone').val();
            var cep             = $('#txt_cep').val();
            var endereco        = $('#txt_endereco').val();
            var numero          = $('#txt_numero').val();
            var bairro          = $('#txt_bairro').val();
            var cidade          = $('#txt_cidade').val();
            var estado          = $('#estado').val();
            var pais            = $('#pais').val();

            //Efetua cadastro do cliente via JSON
            $.ajax({
             url: urlP+"/eficazmonitor/cliente/registrarEdicaoCliente",
             secureuri: false,
             type : "POST",
             dataType: 'json',
             data      : {
              'idCliente' : idCliente,
              'nome_cliente' : nomeCliente,
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
                           //alert("Cliente atualizado com sucesso!");
                           swal("", "Cliente atualizado com sucesso!", "success");
                           location.reload();
                       }
                       else
                       {
                           //Settar a mensagem de erro!
                           //alert("Ocorreu um erro ao atualizar o cliente, favor verificar os dados informados!");
                           swal("Oops...", "Ocorreu um erro ao atualizar o cliente, favor verificar os dados informados!", "error");
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

    //Efetua a validação dos dados antes de efetuar a atualização do contato do cliente

    $('#editarContatoCliente').click(function(){

        //valida se as regras para cadastro do contato estão corretas
        $('#editContatoCliente').validate({
            rules: {
                txt_nome_contato:{
                    required : true
                },
                txt_sobrenome_contato: {
                    required : true
                },
                txt_email_contato:{
                    required: true,
                    email: true
                },
                txt_telefone_contato:{
                    required:true

                },
                txt_celular_contato:{
                    required : true

                },
                txt_senha_contato : {
                    required : false

                },
                txt_cfsenha_contato : {
                    required : false,
                    equalTo  : "#txt_senha_contato"
                }
            },
            messages: {
                txt_nome_contato: {
                    required : "Campo obrigatório"
                },
                txt_sobrenome_contato :{
                    required : "Campo obrigatório"
                },
                txt_email_contato:{
                    required : "Campo obrigatório",
                    email : "Favor informar um endereço válido"
                },
                txt_telefone_contato:{
                    required : "Campo obrigatório"

                },
                txt_celular_contato:{
                    required : "Campo obrigatório"

                },
                txt_senha_contato:{
                    required : "Campo obrigatório"
                },
                txt_cfsenha_contato : {
                    required : "Campo obrigatório",
                    equalTo : "Senhas para usuário devem ser identicas"
                }
            }


        });

        //Ao verificar se os dados de contato do cliente estão válidas e então procegue o cadastro do cliente
        if($('#editContatoCliente').valid()){

            var id_usuario      = $('#txt_idUsuario').val();
            var nomeContato     = $('#txt_nome_contato').val();
            var sobrenome       = $('#txt_sobrenome_contato').val();
            var emailContato    = $('#txt_email_contato').val();
            var celularContato  = $('#txt_celular_contato').val();
            var telefoneContato = $('#txt_telefone_contato').val();
            var senhaContato    = $('#txt_senha_contato').val();
            var confirmaSenha   = $('#txt_cfsenha_contato').val();
            var idCliente       = $('#resultadoCadastro').val();

            //Efetua o cadastro do contato do cliente via JSON
            $.ajax({
                url: urlP+"/eficazmonitor/usuario/registraAtualizacaoUsuario",
                secureuri: false,
                type : "POST",
                dataType: 'json',
                data      : {
                    'id_usuario': id_usuario,
                    'nome'      : nomeContato,
                    'sobrenome' : sobrenome,
                    'email'     : emailContato,
                    'celular'   : celularContato,
                    'telefone'  : telefoneContato,
                    'senha'     : senhaContato,
                    'confirmaS' : confirmaSenha,
                    'idCliente' : idCliente
                },
                success : function(datra)
                {
                    //alert("Cliente atualizado com sucesso!");
                    swal("", "Contato com o cliente atualizado com sucesso!", "success");
                    location.reload();
                },
                error: function(jqXHR, textStatus, errorThrown)
                {

                    //Settar a mensagem de erro!
                          // alert("Ocorreu um erro ao atualizar o cliente, favor verificar os dados informados!");
                        swal("Oops...", "Ocorreu um erro ao atualizar o contato, favor verificar os dados informados!", "error");
                 // Handle errors here
                 console.log('ERRORS: ' + textStatus +" "+errorThrown+" "+jqXHR);
                 // STOP LOADING SPINNER
                }
            });

        }

    });


});
