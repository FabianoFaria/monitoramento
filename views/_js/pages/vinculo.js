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
        url: urlP+"/vinculo/posicoesOcupadasTabela",
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
                    required : true
                }
            },
            messages: {
                txt_numSim: {
                    required : "Campo é obrigatorio"
                }
            }
        });

        if($("#vincularSimCliente").valid()){

            //Coleta os dados necessarios para o vinculo

            var clienteVinculo  = $('#idCliente').val();
            var flilialOpt      = $('#filialVincular').val();
            var num_sim         = $('#txt_numSim').val();

            //Efetua o cadastro via JSON

            $.ajax({
             url: urlP+"/vinculo/registrarVinculoClienteJson",
             secureuri: false,
             type : "POST",
             dataType: 'json',
             data      : {
              'idCliente' : clienteVinculo,
              'idFilial' : flilialOpt,
              'num_sim' : num_sim
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
                        window.location.replace(urlP +"/vinculo/gerenciarVinculo/"+clienteVinculo+"/");
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
                },
                txt_ambiente :{
                    required : true
                 }
            },
            messages: {
                simVinculadoCliente: {
                    required : "Campo é obrigatorio"
                },
                txt_numeroSerie :{
                    required : "Campo é obrigatorio"
                },
                txt_ambiente :{
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
             url: urlP+"/vinculo/registrarVinculoEquipamentoJson",
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
                    swal("", resposta, "info");
                    setTimeout(function(){
                        window.location.replace(urlP +"/equipamento/");
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



});
