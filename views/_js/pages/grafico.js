//AJUSTES INICIAIS DA PÁGINA DE CADASTRO
var pathArray = window.location.href.split( '/' );
var protocol = pathArray[0];
var host = pathArray[2];
var urlP = protocol + '//' + host;

/*
* FUNÇÃO PARA VALIDAR SE PELO MENOS UM PARAMETRO FOI SELECIONADO
*/
function geraGrafico(link)
{
    // Coleta os dados do checkbox
    var entr1t = $("#chk_entrada_r1t").is(":checked");
    var ents1t = $("#chk_entrada_s1t").is(":checked");
    var entt1t = $("#chk_entrada_t1t").is(":checked");
    var entr1c = $("#chk_entrada_r1c").is(":checked");
    var ents1c = $("#chk_entrada_s1c").is(":checked");
    var entt1c = $("#chk_entrada_t1c").is(":checked");

    var entr1tc = $("#chk_entrada_r1tc").is(":checked");
    var ents1tc = $("#chk_entrada_s1tc").is(":checked");
    var entt1tc = $("#chk_entrada_t1tc").is(":checked");
    var entr1cc = $("#chk_entrada_r1cc").is(":checked");
    var ents1cc = $("#chk_entrada_s1cc").is(":checked");
    var entt1cc = $("#chk_entrada_t1cc").is(":checked");
    var batent = $("#bat_entrada_r1tc").is(":checked");

    var from    = $("#data_inicio_rel").val().split("/");
    var dataIni = from[2]+"-"+from[1]+"-"+from[0];

    var to    = $("#data_fim_rel").val().split("/");
    var dataFim = to[2]+"-"+to[1]+"-"+to[0];


    if (!entr1t) entr1t = 0; else entr1t = 1;
    if (!ents1t) ents1t = 0; else ents1t = 1;
    if (!entt1t) entt1t = 0; else entt1t = 1;
    if (!entr1c) entr1c = 0; else entr1c = 1;
    if (!ents1c) ents1c = 0; else ents1c = 1;
    if (!entt1c) entt1c = 0; else entt1c = 1;

    if (!entr1tc) entr1tc = 0; else entr1tc = 1;
    if (!ents1tc) ents1tc = 0; else ents1tc = 1;
    if (!entt1tc) entt1tc = 0; else entt1tc = 1;
    if (!entr1cc) entr1cc = 0; else entr1cc = 1;
    if (!ents1cc) ents1cc = 0; else ents1cc = 1;
    if (!entt1cc) entt1cc = 0; else entt1cc = 1;
    if (!batent) batent = 0; else batent = 1;

    var url = entr1t + "," + ents1t + "," + entt1t + "," + entr1c + "," + ents1c + "," + entt1c+ "," + entr1tc + "," + ents1tc + "," + entt1tc + "," + entr1cc + "," + ents1cc + "," + entt1cc + "," + batent + "," + dataIni + "," + dataFim;
    window.location.href = link + url;
    
}

$().ready(function() {

    //TORNA OBRIGATORIO INFORMAR DATA AO FORMULARIO DE RELATORIO

    $('#data_inicio_rel').mask('99/99/9999');
    $('#data_fim_rel').mask('99/99/9999');

    $('#btn_gerarGrafico').click(function(){

        	$("#formularioGeradorGrafico").validate({

                rules: {

                    data_fim_rel : {
                        required : true,
                        dateBR : true,
                        greaterThan : "#data_inicio_rel"
                    },
                    data_inicio_rel : {
                        required : true,
                        dateBR : true
                    }
                },
                messages: {

                    data_fim_rel : {
                        required : "Campo obrigatôrio.",
                        dateBR : "Favor informar uma data válida!",
                        greaterThan : "Data final deve ser maior que a data inicial!"
                    },
                    data_inicio_rel : {
                        required : "Campo obrigatôrio.",
                        dateBR : "Favor informar uma data válida!"
                    }
                }

        	});

            if($("#formularioGeradorGrafico").valid()){

                //Valida se pelo menos um parametro foi selecionado!
                var geraGraficoParam = $('#geraGrafico').val();
                var checkboxs=document.getElementsByName("parametrosGraficos");
                var okay=false;
                for(var i=0,l=checkboxs.length;i<l;i++)
                {
                    if(checkboxs[i].checked)
                    {
                        okay=true;
                        break;
                    }
                }
                if(okay)geraGrafico(geraGraficoParam);
                else $('#nadaSelecionado').modal();

            }

    });

});
