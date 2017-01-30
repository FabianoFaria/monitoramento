$().ready(function() {

    //Ajustes iniciais da página de cadastro
    var pathArray = window.location.href.split( '/' );
    var protocol = pathArray[0];
    var host = pathArray[2];
    var urlP = protocol + '//' + host;


    $('#txt_telefone_usuario').mask('(999) 9999-9999');
    $('#txt_celular_usuario').mask('(999) 9999-9999');


    /*
    * Função para atualizar o usuário
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



});
