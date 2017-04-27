//Ajustes iniciais da página de cadastro
var pathArray = window.location.href.split( '/' );
var protocol = pathArray[0];
var host = pathArray[2];
var urlP = protocol + '//' + host;

/*
* Função ativada para quando a modal se torna oculta
*/
$('#myModal').on('hidden.bs.modal', function (e) {
    $('#idContatoEditar').val('');
    $('#txt_nomeContato_edit').val('');
    $('#txt_funcao_edit').val('');
    $('#txt_email_edit').val('');
    $('#txt_celular_edit').val('');
    $('#txt_obs_edit').val('');
})

    $('#txt_celular').mask('999 999999999');
    $('#txt_celular_edit').mask('999 999999999');
/*
* CARREGA OS DADOS PARA POSTERIOR CAHAMDA DE MODAL PARA EDIÇÃO
*/
function atualizarContato(id_contatoAlerta)
{
    $.ajax({
        url: urlP+"/alarme/carregarContatosAlarmesJson",
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
              var id             = datra.contato['id'];
              var nomeContato	= datra.contato['nome_contato'];
              var funcao	        = datra.contato['funcao'];
              var email	        = datra.contato['email'];
              var celular	    = datra.contato['celular'];
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
* REMOVE O CONTATO DA LISTA DE RECEBIMENTO
*/
function removerContatoListaAlarmes(id_contatoAlerta)
{
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
         url: urlP+"/alarme/removerContatosAlarmesJson",
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


$().ready(function() {

    /*
    * Efetua a listagem de contatos para receber alarmes de acordo com a filial ou matriz
    */

    $( "#listarSedes").change(function() {

        var idCliente     = $('#idMatriz').val();
        var sedeEscolhida = $('#listarSedes').val();

        $.ajax({
            url: urlP+"/alarme/listarContatosAlarmesJson",
            secureuri: false,
            type : "POST",
            dataType: 'json',
            data      : {
              'idCliente' : idCliente,
              'idFilial'  : sedeEscolhida
          },
             success : function(datra)
              {
                var statusCad       = datra.status;
                var htmlContatos	= datra.contatos;

                 //tempTest = JSON(datra);
                 if(datra.status == true)
                 {
                    $('#stream_table_contatos tbody').html('');
                    $('#stream_table_contatos tbody').append(htmlContatos);
                 }
                 else
                 {
                     //Settar a mensagem de erro!
                     $('#stream_table_contatos tbody').html('');

                     $('#stream_table_contatos tbody').append("<tr><td colspan='7'>Nenhum contato registrado para está filial/matriz </td></tr>");
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
    * Efetua o cadastro de contatos para receber os alarmes
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

            var idMatriz    = $('#idMatriz').val();
            var sedeContato = $('#sedeContato').val();
            var nomeContato = $('#txt_nomeContato').val();
            var funcaoContato = $('#txt_funcao').val();
            var emailContato = $('#txt_email').val();
            var celularContato = $('#txt_celular').val();
            var obsContato = $('#txt_obs').val();

            $.ajax({
             url: urlP+"/alarme/registrarContatoAlarmeJson",
             secureuri: false,
             type : "POST",
             dataType: 'json',
             data      : {
              'idMatriz' : idMatriz,
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
             url: urlP+"/alarme/salvarEditContatoAlarmeJson",
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

    /*
    * FUNÇÃO PARA FILTRAR OS EQUIPAMENTOS POR CLIENTES
    */
    $('#filtroClienteLista').change(function() {

        var idCliente = $(this).val();

        if(idCliente != ''){

            $('#filtroLocalAutoComplete').val("");

            //EFETUA O CARREGAMENTO DOS DADOS DA FILIAL
            $.ajax({
                url: urlP+"/equipamento/filtrarEquipamentosPorCliente",
                secureuri: false,
                type : "POST",
                dataType: 'json',
                data      : {
                    'idCliente' : idCliente
                },
                success : function(datra)
                {
                    if(datra.status){

                        /*
                        * PREENCHE O SELECT ALVO
                        */
                        //$('#filtroLocalLista').html(datra.filiais);

                        /*
                        * PREENCHE TABELA COM EQUIPAMENTOS
                        */
                        $('#listaMonitoria').html(datra.equipamentos);

                        /*
                        * RETIRA O VALOR DO ID DE FILIAL
                        */
                        $('#localId').val(0);

                    }else{
                        //$('#filtroLocalLista').html(datra.filiais);
                        // swal("", "Ocorreu um erro ao tentar carregar os dados, favor verificar os dados enviados!", "error");
                        $('#listaMonitoria').html(datra.equipamentos);
                        $('#localId').val(0);
                    }

                },
                error: function(jqXHR, textStatus, errorThrown)
                {

                    //Settar a mensagem de erro!
                          // alert("Ocorreu um erro ao atualizar o cliente, favor verificar os dados informados!");
                        swal("Oops...", "Ocorreu um erro ao carregar as filiais, favor verificar os dados informados!", "error");
                 // Handle errors here
                 console.log('ERRORS: ' + textStatus +" "+errorThrown+" "+jqXHR);
                 // STOP LOADING SPINNER
                }
            });

        }else{
            $('#filtroLocalLista').html("<option value=''> Selecione...</option>");
        }

    });

    /*
    * FUNÇÃO PARA FILTRAR OS EQUIPAMENTOS POR FILIAL DE CLIENTE
    * DEMANDA AS FUNÇÕES SPLIT E AUTOCOMPLETE
    */
    $("#filtroLocalAutoComplete")
        .on( "keydown", function( event ) {

            var idClie = $('#filtroClienteLista').val();

            /*
            * VERIFICA SE FOI SELECIONADO UM CLIENTE
            */
            if(idClie != ''){
                if ( event.keyCode === $.ui.keyCode.TAB &&
                    $( this ).autocomplete( "instance" ).menu.active ) {
                  event.preventDefault();
                }
            }else{
               swal('','Selecione um cliente antes!','info');
            }
        })
        .autocomplete({
          source: function( request, response ) {
            $.getJSON( urlP+"/cliente/carregarListaFilialAutoCompleteJson/?filtroClie="+ $("#filtroClienteLista").val(), {
              term: extractLast( request.term )
            }, response
        );
        },
        search: function() {
          // custom minLength
          var term = extractLast( this.value );
          if ( term.length < 2 ) {
            return false;
          }
        },
        focus: function() {
          // prevent value inserted on focus
          return false;
        },
        select: function( event, ui ) {

           $('#localId').val(ui.item.id);

           //GERA A TABELA DE EQUIPAMENTOS CONFORME O LOCAL ESCOLHIDO
           var idFilial    = ui.item.id;
           var idCliente   = $('#filtroClienteLista').val();

           if(idFilial != ''){
               //EFETUA O CARREGAMENTO DOS DADOS DA FILIAL
               $.ajax({
                   url: urlP+"/equipamento/carregarListaEquipamentoFilialRelatoriosJson",
                   secureuri: false,
                   type : "POST",
                   dataType: 'json',
                   data      : {
                       'idCliente' : idCliente,
                       'idFilial' : idFilial
                   },
                   success : function(datra)
                   {
                       if(datra.status){

                           /*
                           * PREENCHE TABELA COM EQUIPAMENTOS
                           */
                           $('#listaMonitoria').html(datra.equipamentos);

                       }else{

                           // swal("", "Ocorreu um erro ao tentar carregar os dados, favor verificar os dados enviados!", "error");
                           $('#listaMonitoria').html(datra.equipamentos);
                       }

                   },
                   error: function(jqXHR, textStatus, errorThrown)
                   {
                       //Settar a mensagem de erro!
                       // alert("Ocorreu um erro ao atualizar o cliente, favor verificar os dados informados!");
                       swal("Oops...", "Ocorreu um erro ao carregar os equipamentos, favor verificar os dados informados!", "error");
                        // Handle errors here
                        console.log('ERRORS: ' + textStatus +" "+errorThrown+" "+jqXHR);
                        // STOP LOADING SPINNER
                   }
               });
           }
       }
    });

    /*
    * FUNÇÕES ADICIONAIS DE AUTOCOMPLETE
    */
    function extractLast( term ) {
      return spliter( term ).pop();
    }
    function spliter( val ) {
        var valTemp = val;
      return valTemp.split( /,\s*/ );
    }

    /*
    * FILTRAR EQUIPAMENTOS DE ACORDO COM O CLIENTE, FILIAL E O TIPO DE EQUIPAMENTO PARA RELATORIO
    */
    $('#filtroEquipLista').change(function() {

        var idTipoEquip = $(this).val();
        var idCliente   = $('#filtroClienteLista').val();
        var idFilial    = $('#localId').val();

        if(idTipoEquip != ''){
            //EFETUA O CARREGAMENTO DOS DADOS DOS EQUIPAMENTOS POR TIPO
            $.ajax({
                url: urlP+"/equipamento/carregarListaEquipamentoFilialTipoRelatorioJson",
                secureuri: false,
                type : "POST",
                dataType: 'json',
                data      : {
                    'idCliente': idCliente,
                    'idFilial' : idFilial,
                    'idTipo'   : idTipoEquip
                },
                success : function(datra)
                {
                    if(datra.status){

                        /*
                        * PREENCHE TABELA COM EQUIPAMENTOS
                        */
                        $('#listaMonitoria').html(datra.equipamentos);

                    }else{

                        // swal("", "Ocorreu um erro ao tentar carregar os dados, favor verificar os dados enviados!", "error");
                        $('#listaMonitoria').html(datra.equipamentos);
                    }

                },
                error: function(jqXHR, textStatus, errorThrown)
                {

                    //Settar a mensagem de erro!
                        // alert("Ocorreu um erro ao atualizar o cliente, favor verificar os dados informados!");
                        swal("Oops...", "Ocorreu um erro ao carregar os equipamentos, favor verificar os dados informados!", "error");
                 // Handle errors here
                 console.log('ERRORS: ' + textStatus +" "+errorThrown+" "+jqXHR);
                 // STOP LOADING SPINNER
                }
            });
        }

    });

});
