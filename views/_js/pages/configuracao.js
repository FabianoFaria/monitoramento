$().ready(function(){

    //Ajustes iniciais da página de cadastro
    var pathArray = window.location.href.split( '/' );
    var protocol = pathArray[0];
    var host = pathArray[2];
    var urlP = protocol + '//' + host;

    //Adição de máscara de edição

    $('#formConfiguracaoParametros input').mask('999,99');

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


});
