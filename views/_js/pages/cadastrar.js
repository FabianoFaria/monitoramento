$().ready(function() {

    //Ajustes iniciais da página de cadastro

    //Collapse dados do usuário
    $('#accordionCliente').hide();

    //Collapse dos dados de filiais
    $('#accordionFiliais').hide();

    //Processo de validação de cadastro de cliente
    $('#validarResponsavel').click(function() {

        // validate signup form on keyup and submit
    	$("#cadCliete").validate({
    		rules: {
    			txt_cliente: {
                        required: true
    			    },
                txt_ddd:{
                    required: true,
                    digits:true
                },
                txt_telefone:{
                    required: true,
                    digits:true
                },
                txt_endereco:{
                    required : true
                },
                txt_cep:{
                    required: true,
                    digits:true
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
                    required: "DDD deve ser informado!",
                    digits: "Somente números permitidos"
                },
                txt_endereco: {
                    required: "Favor informar um endereço!"
                },
                txt_telefone: {
                    required: "Telefone deve ser informado!",
                    digits: "Somente números permitidos"
                },
                txt_cep: {
                    required: "CEP deve ser informado.",
                    digits: "Somente números permitidos"
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

            $('#cadCliete input').prop('readonly', true);

            $('#accordionCliente').fadeIn();
        }
    });

    //valida os dados do contato do cliete
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
                    required:true,
                    digits: true
                },
                txt_celular_contato:{
                    required : true,
                    digits : true
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
                    required : "Campo obrigatório",
                    digits  : "Campo deve conter apneas números"
                },
                txt_celular_contato:{
                    required : "Campo obrigatório",
                    digits : "Campo deve conter apenas números"
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


    // $('<div/>', {
    //  'class' : 'filiais', html: GetHtml()
    // }).appendTo('#listaFiliais');

    //Adiciona novo formulario para cadastro de filial
    $('#adicionarNovaFilial').click(function(){

        $('<div/>', {
            'class' : 'filiais', html: GetHtml()
        }).hide().appendTo('#listaFiliais').slideDown('slow');

    });

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


      $('#countFiliais').val(len);

      return $html.html();
    }


    //Testar validação dos dados das filiais cadastradas antes de enviar
    $(document).ready(function (){
        $('#concluirCadastro').click(function() {

            var pathArray = window.location.href.split( '/' );
            var protocol = pathArray[0];
            var host = pathArray[2];
            var urlP = protocol + '//' + host;

            //Dados do contato do cliente

            var nomeContato     = $('#txt_nome_contato').val();
            var sobrenome       = $('#txt_sobrenome_contato').val();
            var emailContato    = $('#txt_email_contato').val();
            var celularContato  = $('#txt_celular_contato').val();
            var telefoneContato = $('#txt_telefone_contato').val();
            var senhaContato    = $('#txt_senha_contato').val();
            var confirmaSenha   = $('#txt_cfsenha_contato').val();

            //Efetua o cadastro do contato do cliente via JSON
            $.ajax({
                url: urlP+"/eficazmonitor/usuario/registrarClientes",
                secureuri: false,
                type : "POST",
                dataType: 'text',
                data      : {
                    'nome'      : nomeContato,
                    'sobrenome' : sobrenome,
                    'email'     : emailContato,
                    'celular'   : celularContato,
                    'telefone'  : telefoneContato,
                    'senha'     : senhaContato,
                    'confirmaS' : confirmaSenha
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


            //Dados da empresa do cliente
            var nomeCliente     = $('#txt_cliente').val();
            var ddd             = $('#txt_ddd').val();
            var telefone        = $('#txt_telefone').val();
            var cep             = $('#txt_cep').val();
            var endereco        = $('#txt_endereco').val();
            var numero          = $('#txt_numero').val();
            var bairro          = $('#txt_bairro').val();
            var cidade          = $('#txt_cidade').val();
            var estado          = 1;
            var pais            = 36;
            var idCliente       = "";

            //Efetua cadastro do cliente via JSON
            $.ajax({
             url: urlP+"/eficazmonitor/cliente/registrarClientes",
             secureuri: false,
             type : "POST",
              dataType: 'text',
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
                           var idClienteCad   =  datra.idCliente;
                       	   $('#resultadoCadastro').html("Cliente salvo com sucesso!" + idClienteCad);
                       }
                       else
                       {
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


            //Após o cadastro do cliente, salva o contato do cliente também via JSON

            //VERIFICA SE CLIENTE POSSUI FILIAIS
            var check=$('input:checkbox[name=temFiliais]').is(':checked');

            if(check == true){
                console.log("Possui filiais!" + host);
            }else{
                console.log("Não possui filiais!" + urlP);
            }

        });


    });


});
