//Ajustes iniciais da página de cadastro
var pathArray = window.location.href.split( '/' );
var protocol = pathArray[0];
var host = pathArray[2];
var urlP = protocol + '//' + host;

/*
* Exibe o posicionamento da tabela conforme o SIM informado
*/
function detalhesPosicao(simNumber){

    //Efetua a consulta na tabela de posicionamento
    $.ajax({
        url: urlP+"/eficazmonitor/vinculo/posicoesOcupadasTabela",
        secureuri: false,
        type : "POST",
        dataType: 'json',
        data      : {
            'numeroSim' : simNumber
        },
        success : function(datra)
        {
            $('#posOcupadas').html(datra.html);
            $('#posicoesTabela').modal();
        },
        error: function(jqXHR, textStatus, errorThrown)
        {

            //Settar a mensagem de erro!
            // alert("Ocorreu um erro ao atualizar o cliente, favor verificar os dados informados!");
            swal("Oops...", "Número SIM não retornou posições!", "error");
            // Handle errors here
            console.log('ERRORS: ' + textStatus +" "+errorThrown+" "+jqXHR);
            // STOP LOADING SPINNER
        }

    });
}

/*
* INICIA PROCESSO DE DESATIVAÇÃO DE DE SIM
*/
function removerSim(simNumber){

    swal({
      title: "Tem certeza?",
      text: "Esta ação não poderá ser desfeita!!",
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

          //Requisita chamada AJAX para efetuar remoção do vinculo
          //Efetua a consulta na tabela de posicionamento
          $.ajax({
              url: urlP+"/eficazmonitor/vinculo/removerVinculoSim",
              secureuri: false,
              type : "POST",
              dataType: 'json',
              data      : {
                  'numeroSim' : simNumber
              },
              success : function(datra)
              {
                  // $('#posOcupadas').html(datra.html);
                  // $('#posicoesTabela').modal();
                  swal('','SIM foi removido com suscceso!','success');
              },
              error: function(jqXHR, textStatus, errorThrown)
              {
                  //Settar a mensagem de erro!
                  // alert("Ocorreu um erro ao atualizar o cliente, favor verificar os dados informados!");
                  swal("Oops...", "Número SIM não foi encontrado! Verifique os dados informados.", "error");
                  // Handle errors here
                  console.log('ERRORS: ' + textStatus +" "+errorThrown+" "+jqXHR);
                  // STOP LOADING SPINNER
              }

          });

      } else {
    	swal("Cancelado", "Nenhuma ação foi executada!", "error");
      }
    });
}

$('#posicoesTabela').on('hidden.bs.modal', function (e) {
    $('#posOcupadas').html('');
})


$().ready(function() {

    /*
    * Função para efetuar o registro do vinculo do SIM com o cliente
    */
    $('#salvarVinculo').click(function(){

        $('#vincularSimCliente').validate({
            rules: {
                txt_numSim: {
                    required : true,
                    remote: {
                      url: urlP+"/eficazmonitor/vinculo/verificarSimExistente",
                      type: "post",
                      data: {
                        num_sim : function() {
                          //return  $("#txt_numSim" ).val();
                          return document.getElementById("txt_numSim").value;
                        }
                      }
                    }

                },
                filialVincular: {
                    required : true
                }
            },
            messages: {
                txt_numSim: {
                    required : "Campo é obrigatorio",
                    remote: "Número SIM já se encontra registrado no sistema!"
                },
                filialVincular: {
                    required : "Campo é obrigatorio"
                }
            }
        });

        if($("#vincularSimCliente").valid()){

            //Coleta os dados necessarios para o vinculo

            var clienteVinculo  = $('#idCliente').val();
            var flilialOpt      = $('#filialVincular').val();
            var num_sim         = $('#txt_numSim').val();
            var ambiente        = $('#ambienteSim').val()

            //Efetua o cadastro via JSON

            $.ajax({
             url: urlP+"/eficazmonitor/vinculo/registrarVinculoClienteJson",
             secureuri: false,
             type : "POST",
             dataType: 'json',
             data      : {
              'idCliente' : clienteVinculo,
              'idFilial' : flilialOpt,
              'num_sim' : num_sim,
              'ambiente' : ambiente
              },
              success : function(datra)
               {

                 var statusCad   = datra.status;

                  //tempTest = JSON(datra);
                  if(datra.status == true)
                  {

                    //alert('Vinculo cadastrado com sucesso!');
                    swal("", "'Vinculo cadastrado com sucesso!", "success");
                    setTimeout(function(){
                        window.location.replace(urlP +"/eficazmonitor/vinculo/gerenciarVinculo/"+clienteVinculo+"/");
                    }, 2500);
                  }
                  else
                  {
                    //Settar a mensagem de erro!
                    //alert('Ocorreu um ero ao tentar cadastrar!');
                    swal("Oops...", "Não foi possivel cadastrar, verifique o sim para possivel duplicação!", "error");
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
    * Função para efetuar o vinculo entre um equipamento e o SIM
    */
    $('#btnVincularEquipamento').click(function(){

        $('#novoEquipamento').validate({
            rules: {
                simVinculadoCliente: {
                    required : true
                },
                txt_numeroSerie :{
                    required : true
                }
            },
            messages: {
                simVinculadoCliente: {
                    required : "Campo é obrigatorio"
                },
                txt_numeroSerie :{
                    required : "Campo é obrigatorio"
                }
            }
        });

        if($("#novoEquipamento").valid()){

            var idEquipamento   = $('#idEquipamento').val();
            var simVinculado    = $('#simVinculadoCliente').val();
            var numero_serie    = $('#txt_numeroSerie').val();
            var ambiente        = $('#txt_ambiente').val();
            var tipoEquipamento = $('#idTipoEquipamento').val();

            $.ajax({
             url: urlP+"/eficazmonitor/vinculo/registrarVinculoEquipamentoJson",
             secureuri: false,
             type : "POST",
             dataType: 'json',
             data : {
                'tipoEquipamento'   : tipoEquipamento,
                'idEquipamento'     : idEquipamento,
                'simVinculado'      : simVinculado,
                'numero_serie'      : numero_serie,
                'ambiente'          : ambiente
              },
              success : function(datra)
               {

                 var statusCad   = datra.status;
                 var resposta = datra.msg;
                  //tempTest = JSON(datra);
                  if(datra.status == true)
                  {
                    //alert('Vinculo cadastrado com sucesso!');
                    swal("", resposta, "success");
                    setTimeout(function(){
                        window.location.replace(urlP +"/eficazmonitor/equipamento/");
                    }, 3000);
                  }
                  else
                  {
                    //Settar a mensagem de erro!
                    //alert('Ocorreu um ero ao tentar vincular!');
                    swal("", resposta, "error");
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
    * FILTRA OS LOCAIS ATRAVES DE AUTO COMPLETE
    */
     $("#filtroLocalAutoComplete")
       // don't navigate away from the field on tab when selecting an item
       .on( "keydown", function( event ) {

         var idClie = $('#idCliente').val();

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
         /*
         * RETORNA OS EQUIPAMENTOS DA MATRIZ
         */
        //  if(){
        //      console.log('Chamando a matriz');
        //  } IMPLEMENTAR

       })
       .autocomplete({
         source: function( request, response ) {
           $.getJSON( urlP+"/eficazmonitor/cliente/carregarListaFilialAutoCompleteJson/?filtroClie="+ $("#idCliente").val(), {
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
            var idCliente   = $('#idCliente').val();

            if(idFilial != ''){
                //EFETUA O CARREGAMENTO DOS DADOS DA FILIAL
                $.ajax({
                    url: urlP+"/eficazmonitor/vinculo/carregarListaSimFilialJson",
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
                            $('#listaSims').html(datra.html);

                        }else{

                            // swal("", "Ocorreu um erro ao tentar carregar os dados, favor verificar os dados enviados!", "error");
                            $('#listaSims').html(datra.html);
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

     /* FUNÇÕES ADICIONAIS DE AUTOCOMPLETE
     */
     function split( val ) {
       return val.split( /,\s*/ );
     }
     function extractLast( term ) {
       return split( term ).pop();
     }

});
