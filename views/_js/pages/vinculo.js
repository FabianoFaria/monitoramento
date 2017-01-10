$().ready(function() {

    //Ajustes iniciais da página de cadastro
    var pathArray = window.location.href.split( '/' );
    var protocol = pathArray[0];
    var host = pathArray[2];
    var urlP = protocol + '//' + host;


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
             url: urlP+"/eficazmonitor/vinculo/registrarVinculoClienteJson",
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
                        window.location.replace(urlP +"/eficazmonitor/vinculo/gerenciarVinculo/"+clienteVinculo+"/");
                    }, 3000);
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

                  //tempTest = JSON(datra);
                  if(datra.status == true)
                  {

                    //alert('Vinculo cadastrado com sucesso!');
                    swal("", "Vinculo cadastrado com sucesso!", "success");
                    setTimeout(function(){
                        window.location.replace(urlP +"/eficazmonitor/equipamento/");
                    }, 3000);
                  }
                  else
                  {
                    //Settar a mensagem de erro!
                    //alert('Ocorreu um ero ao tentar vincular!');
                    swal("", "Ocorreu um ero ao tentar vincular!", "error");
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
