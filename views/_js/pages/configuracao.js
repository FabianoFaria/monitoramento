//AJUSTES INICIAIS DA PÁGINA DE CADASTRO
var pathArray = window.location.href.split( '/' );
var protocol = pathArray[0];
var host = pathArray[2];
var urlP = protocol + '//' + host;

//CONFIGURA AS MASCARAS
$('#txt_celular').mask('(99) 9999-99999');

/*
* CARREGA OS DADOS PARA POSTERIOR CAHAMDA DE MODAL PARA EDIÇÃO
*/
function atualizarContato(id_contatoAlerta)
{
    $.ajax({
        url: urlP+"/eficazmonitor/alarme/carregarContatosAlarmesJson",
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
* EXCLUI O CONTATO SELECIONADO DA LISTA DE EMAILS DO EQUIPAMENTO
*/
function removerContato(id_contatoAlerta){

    swal({
      title: "Tem certeza?",
      text: "Essa ação não poderá ser desfeita!",
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
              url: urlP+"/eficazmonitor/alarme/removerContatosAlarmesJson",
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
                  swal('','Contato removido com sucesso!','info');
                  setTimeout(function(){
                      location.reload();
                  }, 2000);
                }
                else
                {
                  swal("", "Ocorreu um erro ao tentar remover contato, favor verificar o contato escolhido.", "error");

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
    	swal("Cancelado", "Nenhuma ação foi tomada!", "error");
      }
    });
}



$().ready(function(){

    //Ajustes iniciais da página de cadastro
    var pathArray = window.location.href.split( '/' );
    var protocol = pathArray[0];
    var host = pathArray[2];
    var urlP = protocol + '//' + host;

    //Adição de máscara de edição

    $('#formConfigDiferenciado input').mask('999,99');


    $('#salvarConfiguracaoParametros').click(function(){

        var paramConcatenados = "";

        //Recupera os valores de tensão de entrada
        var ecb = $('#ecb').val();
        var eb  = $('#eb').val();
        var ei  = $('#ei').val();
        var ea  = $('#ea').val();
        var eca = $('#eca').val();

        paramConcatenados = paramConcatenados.concat('|inicio|ecb-'+ecb+'|eb-'+eb+'|ei-'+ei+'|ea-'+ea+'|eca-'+eca+'|');

        //Recupera os valores de tensão de saída
        var scb = $('#scb').val();
        var sb  = $('#sb').val();
        var si  = $('#si').val();
        var sa  = $('#sa').val();
        var sca = $('#sca').val();

        paramConcatenados = paramConcatenados.concat('|inicio|scb-'+scb+'|sb-'+sb+'|si-'+si+'|sa-'+sa+'|sca-'+sca+'|');

        //Recupera os valores de bateria
        var tbcb = $('#tbcb').val();
        var tbb  = $('#tbb').val();
        var tbi  = $('#tbi').val();
        var tba  = $('#tba').val();
        var tbca = $('#tbca').val();

        paramConcatenados = paramConcatenados.concat('|inicio|tbcb-'+tbcb+'|tbb-'+tbb+'|tbi-'+tbi+'|tba-'+tba+'|tbca-'+tbca+'|');

        //Recupera os valores de corrente de entrada
        var ccb = $('#ccb').val();
        var cb  = $('#cb').val();
        var ci  = $('#ci').val();
        var ca  = $('#ca').val();
        var cca = $('#cca').val();

        paramConcatenados = paramConcatenados.concat('|inicio|ccb-'+ccb+'|cb-'+cb+'|ci-'+ci+'|ca-'+ca+'|cca-'+cca+'|');

        //Recupera os valores de corrente de saída
        var cscb = $('#cscb').val();
        var csb  = $('#csb').val();
        var csi  = $('#csi').val();
        var csa  = $('#csa').val();
        var csca = $('#csca').val();

        paramConcatenados = paramConcatenados.concat('|inicio|cscb-'+cscb+'|csb-'+csb+'|csi-'+csi+'|csa-'+csa+'|csca-'+csca+'|');

        //Recupera os valores de temperatura ambiente
        var tacb  = $('#tacb').val();
        var tasb  = $('#tasb').val();
        var tasi  = $('#tasi').val();
        var tasa  = $('#tasa').val();
        var tasca = $('#tasca').val();

        paramConcatenados = paramConcatenados.concat('|inicio|tacb-'+tacb+'|tasb-'+tasb+'|tasi-'+tasi+'|tasa-'+tasa+'|tasca-'+tasca+'|');

        //Recupera os valores de temperatura banco de bateria
        var tbbcb  = $('#tbbcb').val();
        var tbbb   = $('#tbbb').val();
        var tbbsi  = $('#tbbsi').val();
        var tbbsa  = $('#tbbsa').val();
        var tbbsca = $('#tbbsca').val();

        paramConcatenados = paramConcatenados.concat('|inicio|tbbcb-'+tbbcb+'|tbbb-'+tbbb+'|tbbsi-'+tbbsi+'|tbbsa-'+tbbsa+'|tbbsca-'+tbbsca+'|');


        var configCarregador    = $('#valorCarregadorBateriaTemp').html();
        paramConcatenados       = paramConcatenados.concat(configCarregador);

        var idCOnfiguracao = $('#idParametros').val();
        /*
        * Verificação se á sendo esta sendo efetuado uma edição ou cadastro de uma nova configuração
        */
        if(idCOnfiguracao == ""){
            var parametros          = paramConcatenados;
            var id_sim_equipamento  = $('#id_sim_equip').val();
            var id_equipamento      = $('#id_equip').val();
            var numeroSim           = $('#num_sim').val();

            $.ajax({
                url: urlP+"/eficazmonitor/configuracao/cadastrarConfiguracaoEquipamentoJson",
                secureuri: false,
                type : "POST",
                dataType: 'json',
                data      : {
                    'parametros' : parametros,
                    'id_sim_equipamento' : id_sim_equipamento,
                    'id_equipamento' : id_equipamento,
                    'numeroSim' : numeroSim
                },
                success : function(datra)
                {
                    if(datra.status){
                        //alert('Configuração salva corretamente!');
                        swal("", "Configuração cadastrada com sucesso!", "success")
                    }else{
                        //alert('Ocorreu um erro ao salvar a configuração, verifique os dados enviados etente novamente!');
                        swal("Oops...", "Ocorreu um erro ao salvar a configuração, verifique os dados enviados e tente novamente!", "error");
                    }
                },
                error: function(jqXHR, textStatus, errorThrown)
                {
                 // Handle errors here
                 console.log('ERRORS: ' + textStatus +" "+errorThrown+" "+jqXHR);
                 // STOP LOADING SPINNER
                }
            });

        }else{
            /*
            * Efetua a atualização das configurações do equipamento
            */
            var idParametros        = $('#idParametros').val();
            var parametros          = paramConcatenados;
            var id_sim_equipamento  = $('#id_sim_equip').val();
            var id_equipamento      = $('#id_equip').val();
            var numeroSim           = $('#num_sim').val();

            $.ajax({
                url: urlP+"/eficazmonitor/configuracao/editarConfiguracaoEquipamentoJson",
                secureuri: false,
                type : "POST",
                dataType: 'json',
                data      : {
                    'idParametros' : idParametros,
                    'parametros' : parametros,
                    'id_sim_equipamento' : id_sim_equipamento,
                    'id_equipamento' : id_equipamento,
                    'numeroSim' : numeroSim
                },
                success : function(datra)
                {
                    if(datra.status){
                        //alert('Configuração salva corretamente!');
                        swal("", "Configuração atualizada com sucesso!", "success");
                        setTimeout(function(){
                            location.reload();
                        }, 2000);
                    }else{
                        //alert('Ocorreu um erro ao salvar a configuração, verifique os dados enviados etente novamente!');
                        swal("Oops...", "Ocorreu um erro ao editar a configuração, verifique os dados enviados e tente novamente!", "error");
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

    //
    // DESATUALIZADO
    //
    $('#salvarConfiguracaoParam').click(function(){

        var paramConcatenados = "";

        //Recupera os valores de entrada

        //var res = str1.concat(str2);

        for(var i = 1; i < 4; i++){

            var eb  = ($('#eb-'+i+'').val() != "") ? $('#eb-'+i+'').val().replace(',','.') : 0;
            var et1 = ($('#et-'+i+'').val() != "") ? $('#et-'+i+'').val().replace(',','.') : 0;
            var ei  = ($('#ei-'+i+'').val() != "") ? $('#ei-'+i+'').val().replace(',','.') : 0;
            var et2 = ($('#et2-'+i+'').val() != "") ? $('#et2-'+i+'').val().replace(',','.') : 0;
            var ea  = ($('#ea-'+i+'').val() != "") ? $('#ea-'+i+'').val().replace(',','.') : 0;

            paramConcatenados = paramConcatenados.concat('|inicio|eb-'+i+'-'+eb+'|et1-'+i+'-'+et1+'|ei-'+i+'-'+ei+'|et2-'+i+'-'+et2+'|ea-'+i+'-'+ea+'|');
        }

        //Recupera os valores de saida

        for(var i = 1; i < 4; i++){

            var sb  = ($('#sb-'+i+'').val() != "") ? $('#sb-'+i+'').val().replace(',','.') : 0;
            var st1 = ($('#st1-'+i+'').val() != "") ? $('#st1-'+i+'').val().replace(',','.') : 0;
            var si  = ($('#si-'+i+'').val() != "") ? $('#si-'+i+'').val().replace(',','.') : 0;
            var st2 = ($('#st2-'+i+'').val() != "") ? $('#st2-'+i+'').val().replace(',','.') : 0;
            var sa  = ($('#sa-'+i+'').val() != "") ? $('#sa-'+i+'').val().replace(',','.') : 0;

            paramConcatenados = paramConcatenados.concat('|inicio|sb-'+i+'-'+sb+'|st1-'+i+'-'+st1+'|si-'+i+'-'+si+'|st2-'+i+'-'+st2+'|sa-'+i+'-'+sa+'|');
        }

        //Recupera os valores de tensão

        for(var i = 1; i < 3; i++){

            var tb  = ($('#tb-'+i+'').val() != "") ? $('#tb-'+i+'').val().replace(',','.') : 0;
            var tt1 = ($('#tt1-'+i+'').val() != "") ? $('#tt1-'+i+'').val().replace(',','.') : 0;
            var ti  = ($('#ti-'+i+'').val() != "") ? $('#ti-'+i+'').val().replace(',','.') : 0;
            var tt2 = ($('#tt2-'+i+'').val() != "") ? $('#tt2-'+i+'').val().replace(',','.') : 0;
            var ta  = ($('#ta-'+i+'').val() != "") ? $('#ta-'+i+'').val().replace(',','.') : 0;

            paramConcatenados = paramConcatenados.concat('|inicio|tb-'+i+'-'+tb+'|tt1-'+i+'-'+tt1+'|ti-'+i+'-'+ti+'|tt2-'+i+'-'+tt2+'|ta-'+i+'-'+ta+'|');
        }

        //var res = paramConcatenados.split("|inicio|");

        //console.log(res[8]);
        var idCOnfiguracao = $('#idParametros').val();
        /*
        * Verificação se á sendo esta sendo efetuado uma edição ou cadastro de uma nova configuração
        */
        if(idCOnfiguracao == ""){

            var parametros          = paramConcatenados;
            var id_sim_equipamento  = $('#id_sim_equip').val();
            var id_equipamento      = $('#id_equip').val();
            var numeroSim           = $('#num_sim').val();

            $.ajax({
                url: urlP+"/eficazmonitor/configuracao/cadastrarConfiguracaoEquipamentoJson",
                secureuri: false,
                type : "POST",
                dataType: 'json',
                data      : {
                    'parametros' : parametros,
                    'id_sim_equipamento' : id_sim_equipamento,
                    'id_equipamento' : id_equipamento,
                    'numeroSim' : numeroSim
                },
                success : function(datra)
                {
                    if(datra.status){
                        //alert('Configuração salva corretamente!');
                        swal("", "Configuração cadastrada com sucesso!", "success")
                    }else{
                        //alert('Ocorreu um erro ao salvar a configuração, verifique os dados enviados etente novamente!');
                        swal("Oops...", "Ocorreu um erro ao salvar a configuração, verifique os dados enviados e tente novamente!", "error");
                    }
                },
                error: function(jqXHR, textStatus, errorThrown)
                {
                 // Handle errors here
                 console.log('ERRORS: ' + textStatus +" "+errorThrown+" "+jqXHR);
                 // STOP LOADING SPINNER
                }
            });

        }else{

            /*
            * Efetua a atualização das configurações do equipamento
            */
            var idParametros        = $('#idParametros').val();
            var parametros          = paramConcatenados;
            var id_sim_equipamento  = $('#id_sim_equip').val();
            var id_equipamento      = $('#id_equip').val();
            var numeroSim           = $('#num_sim').val();

            //console.log(parametros.length);

            $.ajax({
                url: urlP+"/eficazmonitor/configuracao/editarConfiguracaoEquipamentoJson",
                secureuri: false,
                type : "POST",
                dataType: 'json',
                data      : {
                    'idParametros' : idParametros,
                    'parametros' : parametros,
                    'id_sim_equipamento' : id_sim_equipamento,
                    'id_equipamento' : id_equipamento,
                    'numeroSim' : numeroSim
                },
                success : function(datra)
                {
                    if(datra.status){
                        //alert('Configuração salva corretamente!');
                        swal("", "Configuração atualizada com sucesso!", "success");
                        setTimeout(function(){
                            location.reload();
                        }, 2000);
                    }else{
                        //alert('Ocorreu um erro ao salvar a configuração, verifique os dados enviados etente novamente!');
                        swal("Oops...", "Ocorreu um erro ao editar a configuração, verifique os dados enviados e tente novamente!", "error");
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
             url: urlP+"/eficazmonitor/alarme/salvarEditContatoAlarmeJson",
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
    * EFETUA O CADASTRO DE CONTATOS PARA RECEBER OS ALARMES
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
             url: urlP+"/eficazmonitor/alarme/registrarContatoAlarmeJson",
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



});
