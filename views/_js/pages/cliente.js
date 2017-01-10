$().ready(function() {

    //Ajustes iniciais da página de cadastro
    var pathArray = window.location.href.split( '/' );
    var protocol = pathArray[0];
    var host = pathArray[2];
    var urlP = protocol + '//' + host;


    /*
    * Função para iniciar o processo de exclusão de clientes
    */
    function iniciarExclusaoCliente(idClienteExcluir)
    {
        swal({
          title: "Tem certeza?",
          text: "Este processo não pode ser revertido!",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Sim, ecluir cliente!",
          closeOnConfirm: false
        },
        function(){
          swal("Apagado!", "Cliente imaginario apagado!", "success");
        });
    }

    //Adição de máscara de edição

    $('#txt_ddd').mask('(999)');
    $('#txt_telefone').mask('9999-9999');
    $('#txt_cep').mask('99999-999');
    $('#txt_telefone_contato').mask('(999) 9999-9999');
    $('#txt_celular_contato').mask('(999) 9999-9999');

    $('.telefonaFilial').mask('9999-9999');

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
            var estado          = $('#estados').val();
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
      $html.find('[name=estados]')[0].name="estados" + len;
      $html.find('[name=paises]')[0].name="paises" + len;
      //$html.find('[onBlur=validaCEP()]')[0].onBlur="validaCEP("+len+")"



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
                    var estado      = $('[name=estados'+i+']').val();
                    var pais        = $('[name=paises'+i+']').val();

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
                                'idEstado'  : estado,
                                'idPais'    : pais,
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

                // $('#resultadoPositivo').fadeIn();
                swal("","Cliente cadastrado corretamente!","success");

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


    //Apaga os textos no formulario de cadastro de cliente
    function limpa_formulário_cep() {
        // Limpa valores do formulário de cep.
        $("#txt_endereco").val("");
        $("#txt_bairro").val("");
        $("#txt_cidade").val("");
        $("#estados").val(16);
        $("#pais").val(36);
    }

    //Efetua a validação do CEP do cliente

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

    function limpa_formulário_cep_filial(numero){
        //Preenche os campos com "..." enquanto consulta webservice.
        $('[name=txt_endereco'+numero+']').val("...");
        $('[name=txt_bairro'+numero+']').val("...");
        $('[name=txt_cidade'+numero+']').val("...");
        $('[name=estados'+numero+']').val(16);
        $('[name=paises'+numero+']').val(36);
    }

    //Função para buscar o CEP de determinada filial
    function buscaCep(numeroId, cepInformado){

        //Nova variável "cep" somente com dígitos.
        var cep = cepInformado.replace(/\D/g, '');

        //Verifica se campo cep possui valor informado.
        if (cep != ""){

            //Expressão regular para validar o CEP.
            var validacep = /^[0-9]{8}$/;

            //Valida o formato do CEP.
            if(validacep.test(cep)){

                /*
                var estado      = $('[name=estados'+i+']').val();
                */

                //Preenche os campos com "..." enquanto consulta webservice.
                $('[name=txt_endereco'+numeroId+']').val("...");
                $('[name=txt_bairro'+numeroId+']').val("...");
                $('[name=txt_cidade'+numeroId+']').val("...");
                $('[name=estados'+numeroId+']').val(16);
                $('[name=paises'+numeroId+']').val(36);

                //Consulta o webservice viacep.com.br/
                $.getJSON("//viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {

                    if (!("erro" in dados)) {
                        //Atualiza os campos com os valores da consulta.
                        $('[name=txt_endereco'+numeroId+']').val(dados.logradouro);
                        $('[name=txt_bairro'+numeroId+']').val(dados.bairro);
                        $('[name=txt_cidade'+numeroId+']').val(dados.localidade);

                        //console.log(dados.uf);
                        switch (dados.uf) {
                            case 'AC':
                                $('[name=estados'+numeroId+']').val(1);
                            break;
                            case 'AL':
                                $('[name=estados'+numeroId+']').val(2);
                            break;
                            case 'AP':
                                $('[name=estados'+numeroId+']').val(3);
                            break;
                            case 'AM':
                                $('[name=estados'+numeroId+']').val(4);
                            break;
                            case 'BA':
                                $('[name=estados'+numeroId+']').val(5);
                            break;
                            case 'CE':
                                $('[name=estados'+numeroId+']').val(5);
                            break;
                            case 'DF':
                                $('[name=estados'+numeroId+']').val(7);
                            break;
                            case 'ES':
                                $('[name=estados'+numeroId+']').val(8);
                            break;
                            case 'GO':
                                $('[name=estados'+numeroId+']').val(9);
                            break;
                            case 'MA':
                                $('[name=estados'+numeroId+']').val(10);
                            break;
                            case 'MT':
                                $('[name=estados'+numeroId+']').val(11);
                            break;
                            case 'MS':
                                $('[name=estados'+numeroId+']').val(12);
                            break;
                            case 'MG':
                                $('[name=estados'+numeroId+']').val(13);
                            break;
                            case 'PA':
                                $('[name=estados'+numeroId+']').val(14);
                            break;
                            case 'PB':
                                $('[name=estados'+numeroId+']').val(15);
                            break;
                            case 'PR':
                                $('[name=estados'+numeroId+']').val(16);
                            break;
                            case 'PE':
                                $('[name=estados'+numeroId+']').val(17);
                            break;
                            case 'PI':
                                $('[name=estados'+numeroId+']').val(18);
                            break;
                            case 'RJ':
                                $('[name=estados'+numeroId+']').val(19);
                            break;
                            case 'RN':
                                $('[name=estados'+numeroId+']').val(20);
                            break;
                            case 'RS':
                                $('[name=estados'+numeroId+']').val(21);
                            break;
                            case 'RO':
                                $('[name=estados'+numeroId+']').val(22);
                            break;
                            case 'RR':
                                $('[name=estados'+numeroId+']').val(23);
                            break;
                            case 'SC':
                                $('[name=estados'+numeroId+']').val(24);
                            break;
                            case 'SP':
                                $('[name=estados'+numeroId+']').val(25);
                            break;
                            case 'SE':
                                $('[name=estados'+numeroId+']').val(26);
                            break;
                            case 'TO':
                                $('[name=estados'+numeroId+']').val(27);
                            break;
                            default:
                                $('[name=estados'+numeroId+']').val(999);
                            break;
                        }

                    }else{

                        //CEP pesquisado não foi encontrado.
                        limpa_formulário_cep_filial(numeroId);
                        swal("","CEP não encontrado.","error");
                    }

                });

            }else{
                //cep é inválido.
                limpa_formulário_cep_filial(numeroId);
                swal("","Formato de CEP inválido.","error");
            }

        }else{
            //cep sem valor, limpa formulário da filial.
            limpa_formulário_cep_filial(numeroId);
        }
    }

    /*
    * Função para validar o CEP das filiais
    */
    $(document).on('blur','.cepFilial',function(){

        var cepFilial       = $(this).val();
        var numeroFilial    = $(this).attr('name');
        var numero          = numeroFilial.substr(numeroFilial.length - 1);

        console.log(cepFilial+ " - " +numero);

        buscaCep(numero, cepFilial);

    });



});
