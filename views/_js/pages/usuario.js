$().ready(function() {


	$('#salvar_edicao').click(function(){

		//valida se as regras para cadastro do contato estão corretas
                $('#edit_usuario').validate({

                        rules: {
                                txt_nome : true
                	},
                	 messages:{
                                txt_nome : "Campo obrigatório"
                	 }
                });

                 //Ao verificar se os dados de contato do usuário
                if($('#edit_usuario').valid()){

                        console.log('Continue...');

                }

	});


    //Ajustes iniciais da página de cadastro
    var pathArray = window.location.href.split( '/' );
    var protocol = pathArray[0];
    var host = pathArray[2];
    var urlP = protocol + '//' + host;


    $('#txt_telefone_usuario').mask('(999) 9999-9999');
    $('#txt_celular_usuario').mask('(999) 99999-9999');

    /*
    * FUNÇÃO PARA ATUALIZAR O USUÁRIO
    */
    $('#atualizarUsuario').click(function(){

        $('#edicao_usuario').validate({

            rules: {
    			txt_nome: {
                    required: true
                },
                txt_sobrenome: {
                    required: true
                },
                txt_telefone_usuario: {
                    required: true
                },
                txt_celular_usuario: {
                    required: true
                },
                txt_email: {
                    required: true,
                    email: true
                },
                txt_cfsenha: {
                    equalTo  : "#txt_senha"
                }
            },
            messages: {
                txt_nome: {
                    required : "Campo obrigatôrio."
                },
                txt_sobrenome: {
                    required : "Campo obrigatôrio."
                },
                txt_telefone_usuario: {
                    required : "Campo obrigatôrio."
                },
                txt_celular_usuario: {
                    required : "Campo obrigatôrio."
                },
                txt_email: {
                    required : "Campo obrigatôrio.",
                    email : "favor informar email válido!"
                },
                txt_cfsenha: {
                    equalTo : "Senhas para usuário devem ser identicas"
                }
            }

        });

        if($('#edicao_usuario').valid()){

            //EFETUA A REQUISIÇÃO PARA JSON PARA ATUALIZAR

            var nomeContato     = $('#txt_nome').val();
            var sobrenome       = $('#txt_sobrenome').val();
            var emailContato    = $('#txt_email').val();
            var celularContato  = $('#txt_celular_usuario').val();
            var telefoneContato = $('#txt_telefone_usuario').val();
            var senhaContato    = $('#txt_senha').val();
            var confirmaSenha   = $('#txt_cfsenha').val();
            var idUser          = $('#txt_userId').val();

            $.ajax({
                url: urlP+"/eficazmonitor/usuario/atualizarUsuarioManual",
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
                    'idUser'    : idUser
                },
                success : function(datra)
                {
                    if(datra.status){
                        swal('','Dados atualizados com suscesso !','success');
                        setTimeout(function(){
                            location.reload();
                        }, 2000);
                    }else{
                        swal('','Ocorreu um erro ao tentar atualizar, tente novamente mais tarde!','error');
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
    * LANÇAR MODAL PARA CADASTRAR NOVO USUÁRIO
    */
    $('#addNovoUser').click(function(){

        //APAGA TODOS OS INPUTS POR DEFAULT

        $('#txt_nome').val('');
        $('#txt_sobrenome').val('');
        $('#txt_email').val('');
        $('#txt_telefone_usuario').val('');
        $('#txt_celular_usuario').val('');
        $('#txt_senha').val('');
        $('#txt_cfsenha').val('');


        $('#modalCadUsuario').modal();

    });

    /*
    * INICIA PROCESSO DE CADASTRO DE USUÁRIO
    */
    $('#cadUsuarioBtn').click(function(){

        $('#formCadUser').validate({
            rules: {
                txt_nome : {
                    required : true
                },
                txt_sobrenome : {
                    required : true
                },
                txt_email : {
                    required : true,
                    email : true
                },
                txt_telefone_usuario : {
                    required : true
                },
                txt_celular_usuario : {
                    required : true
                },
                txt_senha : {
                    required : true
                },
                txt_cfsenha : {
                    required : true,
                    equalTo : "#txt_senha"
                },
                nomeCliente : {
                    required : true
                },
                acessoCliente : {
                    required : true
                }
            },
            messages: {
                txt_nome : {
                    required : "Campo obrigatório!"
                },
                txt_sobrenome : {
                    required : "Campo obrigatório!"
                },
                txt_email : {
                    required : "Campo obrigatório!",
                    email : "Favor informar email correto"
                },
                txt_telefone_usuario : {
                    required : "Campo obrigatório!"
                },
                txt_celular_usuario : {
                    required : "Campo obrigatório!"
                },
                txt_senha : {
                    required : "Campo obrigatório!"
                },
                txt_cfsenha : {
                    required : "Campo obrigatório!",
                    equalTo : "Senha devem ser iguais"
                },
                nomeCliente : {
                    required : "Campo obrigatório!"
                },
                acessoCliente : {
                    required : "Campo obrigatório!"
                }
            }
        });

        if($('#formCadUser').valid()){

            var nome        = $('#txt_nome').val();
            var sobrenome   = $('#txt_sobrenome').val();
            var email       = $('#txt_email').val();
            var telefone    = $('#txt_telefone_usuario').val();
            var celular     = $('#txt_celular_usuario').val();
            var senha       = $('#txt_senha').val();
            var cSenha      = $('#txt_cfsenha').val();
            var cliente     = $('#nomeCliente').val();
            var acesso      = $('#acessoCliente').val();

            $.ajax({
                url: urlP+"/eficazmonitor/usuario/registraUsuarioPorSistema",
                secureuri: false,
                type : "POST",
                dataType: 'json',
                data      : {
                    'nome'      : nome,
                    'sobrenome' : sobrenome,
                    'email'     : email,
                    'telefone'  : telefone,
                    'celular'   : celular,
                    'senha'     : senha,
                    'confirmaS' : cSenha,
                    'cliente'   : cliente,
                    'acesso'    : acesso
                },
                success : function(datra)
                {
                    if(datra.status){
                        swal('','Dados cadastrados com suscesso !','success');
                        setTimeout(function(){
                            location.reload();
                        }, 2000);
                    }else{
                        swal('','Ocorreu um erro ao tentar cadastrar, tente novamente mais tarde!','error');
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
    * INICIA PROCESSO DE EDIÇÂO DE USUÁRIO
    */
    $('.btnEditUser').click(function(){

        var usuario = $(this).val();

        //Efetua o carregamento dos dados da filial
        $.ajax({
            url: urlP+"/eficazmonitor/usuario/carregarDadosUsuariosJson",
            secureuri: false,
            type : "POST",
            dataType: 'json',
            data      : {
                'idUsuario' : usuario
            },
            success : function(datra)
            {
                if(datra.status){

                    /*
                    * MASCARA PARA INPUTS DE EDIÇÂO
                    */
                    $('#txt_edit_telefone_usuario').mask('(999) 9999-9999');
                    $('#txt_edit_celular_usuario').mask('(999) 9999-9999');

                    //alert("Cliente atualizado com sucesso!");

                    $('#usuarioId').val(datra.usuario['id']);
                    $('#txt_edit_nome').val(datra.usuario['nome']);
                    $('#txt_edit_sobrenome').val(datra.usuario['sobrenome']);
                    $('#txt_edit_email').val(datra.usuario['email']);
                    $('#txt_edit_telefone_usuario').val(datra.usuario['telefone']);
                    $('#txt_edit_celular_usuario').val(datra.usuario['celular']);
                    $('#nomeClienteEdit').val(datra.usuario['id_cliente']);
                    $('#acessoUsuarioEdit').val(datra.usuario['id_perfil_acesso']);

                    $('#modalEditUsuario').modal();

                }else{
                    swal("", "Ocorreu um erro ao tentar carregar os dados do usuário, favor verificar os dados enviados!", "error");
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

    });


    /*
    * INICIA O PROCESSO DE SALVAR ALTERAÇÕES DO USUÁRIO
    */
    $('#editUsuarioBtn').click(function(){

        $('#formEditUser').validate({
            rules: {
                txt_edit_nome : {
                    required : true
                },
                txt_edit_sobrenome : {
                    required : true
                },
                txt_edit_email : {
                    required : true,
                    email : true
                },
                txt_edit_telefone_usuario : {
                    required : true
                },
                txt_edit_celular_usuario : {
                    required : true
                },
                txt_edit_senha : {
                    required : false
                },
                txt_edit_cfsenha : {
                    equalTo : "#txt_edit_senha"
                },
                nomeClienteEdit : {
                    required : true
                },
                acessoUsuarioEdit : {
                    required : true
                }
            },
            messages: {
                txt_edit_nome : {
                    required : "Campo obrigatório!"
                },
                txt_edit_sobrenome : {
                    required : "Campo obrigatório!"
                },
                txt_edit_email : {
                    required : "Campo obrigatório!",
                    email : "Favor informar email correto"
                },
                txt_edit_telefone_usuario : {
                    required : "Campo obrigatório!"
                },
                txt_edit_celular_usuario : {
                    required : "Campo obrigatório!"
                },
                txt_edit_senha : {
                    required : "Campo obrigatório!"
                },
                txt_edit_cfsenha : {
                    equalTo : "Senha devem ser iguais"
                },
                nomeClienteEdit : {
                    required : "Campo obrigatório!"
                },
                acessoUsuarioEdit : {
                    required : "Campo obrigatório!"
                }
            }
        });

        if($('#formEditUser').valid()){

            var idUser      = $('#usuarioId').val();
            var nome        = $('#txt_edit_nome').val();
            var sobrenome   = $('#txt_edit_sobrenome').val();
            var email       = $('#txt_edit_email').val();
            var telefone    = $('#txt_edit_telefone_usuario').val();
            var celular     = $('#txt_edit_celular_usuario').val();
            var senha       = $('#txt_edit_senha').val();
            var cSenha      = $('#txt_edit_cfsenha').val();
            var cliente     = $('#nomeClienteEdit').val();
            var acesso      = $('#acessoUsuarioEdit').val();

            $.ajax({
                url: urlP+"/eficazmonitor/usuario/atualizarUsuarioPorSistema",
                secureuri: false,
                type : "POST",
                dataType: 'json',
                data      : {
                    'idUser'    : idUser,
                    'nome'      : nome,
                    'sobrenome' : sobrenome,
                    'email'     : email,
                    'telefone'  : telefone,
                    'celular'   : celular,
                    'senha'     : senha,
                    'confirmaS' : cSenha,
                    'cliente'   : cliente,
                    'acesso'    : acesso
                },
                success : function(datra)
                {
                    if(datra.status){
                        swal('','Dados atualizados com suscesso !','success');
                        setTimeout(function(){
                            location.reload();
                        }, 2000);
                    }else{
                        swal('','Ocorreu um erro ao tentar atualizar, tente novamente mais tarde!','error');
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
    * INICIA O PROCESSO DE EXCLUSÃO DE USUÁRIO
    */
    $('.btnRemoveUser').click(function(){

        var idUser = $(this).val();

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
                    url: urlP+"/eficazmonitor/usuario/excluirUsuariosJson",
                    secureuri: false,
                    type : "POST",
                    dataType: 'json',
                    data      : {
                        'idUsuario' : idUser
                    },
                    success : function(datra)
                    {
                        if(datra.status){
                            swal("Removido!", "Usuário foi desativado no sistema!", "success");
                            setTimeout(function(){
                                location.reload();
                            }, 2000);
                        }else{
                            //swal("Deleted!", "Your imaginary file has been deleted.", "success");
                            swal("Oops!", "Ocorreu um erro ao tentar remover usuário do sistema, tente novamente mais tarde!", "error");
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

});
