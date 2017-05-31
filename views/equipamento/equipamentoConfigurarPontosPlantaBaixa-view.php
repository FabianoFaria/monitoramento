<?php

    if (! defined('EFIPATH')) exit;

    $dadosEquipamento   = $modelo->dadosEquipamentoCliente($this->parametros[0]);

    //var_dump($dadosEquipamento);

    $local              = (isset($dadosEquipamento['equipamento'][0]['filial']))? $dadosEquipamento['equipamento'][0]['filial'] : "Matriz";
    $local              = $dadosEquipamento['equipamento'][0]['cliente']." - ".$local;

    $idEquip            = $dadosEquipamento['equipamento'][0]['id'];

    $plantaBaixa        = $modelo->dadosEquipamentoPlantaBaixa($this->parametros[0]);

    //var_dump($plantaBaixa);

    $pontosCadastrados  = $modelo->carregarPontosPlantaBaixa($idEquip);

    //var_dump($pontosCadastrados);

?>

<link rel="stylesheet" type="text/css" href="<?php echo HOME_URI ?>/views/_css/jquery.qtip.min.css">

<script src="<?php echo HOME_URI ?>/views/_js/jquery.qtip.min.js" ></script>
<script src='<?php echo HOME_URI ?>/views/_js/cytoscape.min.js'></script>
<script src="<?php echo HOME_URI ?>/views/_js/cytoscape-qtip.js"></script>

<script type="text/javascript">
    // gerenciador de link
    var menu = document.getElementById('listadir');
    menu.innerHTML = '<a href="<?php echo HOME_URI; ?>/home/" class="linkMenuSup">Home</a> / <a href="<?php echo HOME_URI; ?>/equipamento"> Equipamentos </a> / <a href="<?php echo HOME_URI; ?>/equipamento/gerenciarPlantaBaixa/"> Listar locais </a> / <a href="<?php echo HOME_URI; ?>/equipamento/carregarPontosPlantaBaixa/<?php echo $this->parametros[0]; ?>">Configurar pontos planta baixa : <?php echo $local; ?></a>';

</script>

<div class="row">
    <div class="col-lg-12">
        <!-- TITULO PAGINA -->
        <label class="page-header"> Pontos configurados na planta baixa :</label><!-- Fim Titulo pagina -->
    </div>
</div>

<div class="row" >

    <div class="col-lg-12">

        <?php

            //VERIFICA SE HÁ PLANTA BAIXA CADASTRADA
            if(!$plantaBaixa['status']){

            ?>
                <div class="row">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            Equipamento sem planta baixa registrada
                        </div>
                        <div class="panel-body">
                            <p>Favor registrar uma planta baixa antes de configurar os pontos do equipamento!</p>
                            <p>
                                <a href="<?php echo HOME_URI ?>/equipamento/configurarPlantaBaixa/<?php echo $this->parametros[0]; ?>"><b>Registrar planta baixa!</b></a>
                            </p>
                        </div>
                        <div class="panel-footer">

                        </div>
                    </div>
                </div>

            <?php

            }else{

                $idPlantaBaixa      = $plantaBaixa['dadosPlanta'][0]['id_planta'];
                //var_dump($idPlantaBaixa);

            ?>

                <div class="row">

                    <div class="col-md-6">
                        <div class="form-group">
                            <!-- <label for="exampleInputEmail1">Descrição da planta baixa cadastrada atualmente</label> -->
                            <input type="text" class="form-control" id="txt_planta" name="txt_planta" value="<?php echo $plantaBaixa['dadosPlanta'][0]['descricao_imagem']; ?>" readonly="true">
                            <input type="hidden" id="plantaId" name="plantaId" value="<?php echo $idPlantaBaixa; ?>" />
                        </div>

                    </div>

                </div>

                <div class="row">

                    <?php

                        /*
                        * VARIAVEIS PARA SEREM USADAS NA MONTAGEM DAS PLANTA BAIXA
                        */
                        $tipoEquip          = $dadosEquipamento['equipamento'][0]['tipoEquip'];
                        $numerosEntradas    = $dadosEquipamento['equipamento'][0]['tipo_entrada'];

                    ?>

                    <div class="col-md-8">

                        <div id="sample">
                          <div id="myDiagramDiv" style="border: solid 1px black; width:100%; height:600px; background:url(<?php echo HOME_URI; ?>/views/_uploads/plantas/<?php echo $plantaBaixa['dadosPlanta'][0]['imagem_planta']; ?>) no-repeat; background-position:5px 5px;"></div>
                          <!-- <p>This diagram displays a monitored floor plan with several nodes (representing kittens) to view in real-time.</p>
                          <p>Every two seconds the kitten positions are updated</p>
                          <p>The <a href="../intro/toolTips.html">Tooltip</a> for each kitten shows its name and photo.</p>
                          <p>There is a custom <a>Diagram.scaleComputation</a> that limits the <a>Diagram.scale</a> values to multiples of 0.1.</p> -->
                        </div>

                    </div>

                    <div class="col-md-4">
                        <input type='button' id='advance' class="btn btn-primary" value='Salvar posições'>

                        <div id="png-eg2">
                            <img id="png-eg" />
                        </div>
                    </div>

                    <script  type="text/javascript">

                        //Pontos da tabela que serão representados na planta baixa
                        var pontosTabela = ['b','c','d','e','f','g','h','j','l','m','n','o','p','q','r','s','t','u'];

                        var cy = cytoscape({
                            container: document.getElementById('myDiagramDiv'),
                            elements: [

                                <?php
                                    if($pontosCadastrados['status']){

                                        $posicoes = $pontosCadastrados['pontosPLanta'];

                                        foreach ($posicoes as $ponto) {
                                            if($ponto['ponto_tabela'] == 'Mestre'){
                                                ?>
                                                    { data:
                                                        { id: '<?php echo $ponto['ponto_tabela']; ?>',
                                                          equipamento: 'Equipamento mestre',
                                                          image: '<?php echo HOME_URI; ?>/views/_images/equipamento.png'
                                                        },
                                                      position:
                                                        {
                                                            x: <?php echo $ponto['coordenada_x']; ?>,
                                                            y: <?php echo $ponto['coordenada_y']; ?>
                                                        }
                                                    },
                                                <?php
                                            }
                                        }
                                    }else{
                                    ?>
                                        { data: {
                                                id: 'Mestre',
                                                equipamento: 'Equipamento mestre',
                                                image: '<?php echo HOME_URI; ?>/views/_images/equipamento.png'
                                            },
                                         position:
                                              {
                                                  x: 200,
                                                  y: 200
                                              }
                                        },
                                    <?php
                                    }
                                ?>

                            ],
                            style: [ // the stylesheet for the graph
                                {
                                  selector: 'node',
                                  style: {
                                      'label': 'data(equipamento)',
                                      'width': '64px',
                                      'height': '64px',
                                      'background-opacity': 0,
                                      'background-image': 'data(image)',
                                      'background-fit': 'contain',
                                      'background-image-opacity': 1,
                                      'shape' : 'roundrectangle'
                                  }
                                },

                                {
                                  selector: 'edge',
                                  style: {
                                    'width': 3,
                                    'line-color': '#ccc',
                                    'target-arrow-color': '#ccc',
                                    'target-arrow-shape': 'triangle',
                                    'line-style': 'dashed'
                                  }
                                }
                            ],
                            layout: {
                                name: 'preset',
                                rows: 1
                            },
                            zoomingEnabled: false,
                            boxSelectionEnabled : false,
                            panningEnabled :false
                        });

                        <?php

                            switch($tipoEquip) {
                                case 'Medidor temperatura':
                                    // Irá Adicionar os pontos configurados para o medidor de temperatura
                                    if($pontosCadastrados['status']){
                                        //Há posições cadastradas ainda
                                        $posicoes = $pontosCadastrados['pontosPLanta'];

                                        foreach ($posicoes as $ponto) {

                                            if($ponto['ponto_tabela'] != 'Mestre'){

                                                ?>
                                                    cy.add({
                                                        data: {
                                                            id: '<?php echo $ponto['ponto_tabela']; ?>',
                                                            equipamento: 'Ponto : <?php echo strtoupper($ponto['ponto_tabela']); ?>',
                                                            image: '<?php echo HOME_URI; ?>/views/_images/scale.png'
                                                            },
                                                        position: { x: <?php echo $ponto['coordenada_x']; ?>, y: <?php echo $ponto['coordenada_y']; ?> }

                                                        }
                                                    );
                                                    var source = '<?php echo $ponto['ponto_tabela']; ?>';
                                                    cy.add({
                                                        data: {
                                                            id: 'edge<?php echo $ponto['ponto_tabela']; ?>',
                                                            source: source,
                                                            target: 'Mestre'
                                                        }
                                                    });
                                                <?php
                                            }
                                        }

                                    }else{
                                        //Não há posições cadastradas ainda
                                        ?>

                                            for (var i = 0; i < <?php echo $numerosEntradas; ?>; i++) {
                                                cy.add({
                                                    data: {
                                                        id: pontosTabela[i],
                                                        equipamento: 'Ponto : '+pontosTabela[i].toUpperCase(),
                                                        image: '<?php echo HOME_URI; ?>/views/_images/scale.png'
                                                    },
                                                    position: {
                                                            x: 150,
                                                            y: 150
                                                        }
                                                    }
                                                );
                                                var source = pontosTabela[i];
                                                cy.add({
                                                    data: {
                                                        id: 'edge' + i,
                                                        source: source,
                                                        target: 'Mestre'
                                                    }
                                                });
                                            }

                                        <?php
                                    }

                                break;

                                default:
                                    // Irá Adicionar o medidor de temperatura ambiente

                                    // Irá Adicionar os pontos configurados para o medidor de temperatura
                                    if($pontosCadastrados['status']){
                                        //Há posições cadastradas ainda
                                        $posicoes = $pontosCadastrados['pontosPLanta'];

                                        foreach ($posicoes as $ponto) {
                                            if($ponto['ponto_tabela'] != 'Mestre'){
                                                ?>
                                                    cy.add({
                                                        data: {
                                                            id: '<?php echo $ponto['ponto_tabela']; ?>',
                                                            equipamento: 'Ponto : <?php echo strtoupper($ponto['ponto_tabela']); ?>',
                                                            image: '<?php echo HOME_URI; ?>/views/_images/scale.png'
                                                            },
                                                        position: { x: <?php echo $ponto['coordenada_x']; ?>, y: <?php echo $ponto['coordenada_y']; ?> }

                                                        }
                                                    );
                                                    var source = '<?php echo $ponto['ponto_tabela']; ?>';
                                                    cy.add({
                                                        data: {
                                                            id: 'edge<?php echo $ponto['ponto_tabela']; ?>',
                                                            source: source,
                                                            target: 'Mestre'
                                                        }
                                                    });
                                                <?php
                                            }
                                        }

                                    }else{
                                        ?>
                                            cy.add({
                                                data: {
                                                    id: 'q',
                                                    equipamento: 'Temperatura ambiente',
                                                    image: '<?php echo HOME_URI; ?>/views/_images/scale.png'
                                                },
                                                position: {
                                                        x: 150,
                                                        y: 150
                                                    }
                                            });
                                            var source = 'q';
                                            cy.add({
                                                    data: {
                                                        id: 'edge',
                                                        source: source,
                                                        target: 'Mestre'
                                                }
                                            });
                                        <?php
                                    }

                                break;
                            }

                        ?>

                        // cy.on('tap', 'node', function(evt){
                        //     // var node = evt.target;
                        //     //     console.log( 'tapped ' + node.id() );
                        //
                        //     var node = evt.target;
                        //     node.qtip({
                        //         content: function(){ return 'Example qTip on ele ' + this.data('equipamento') },
                        //         show: {
                        //             evt: evt.type,
                        //             ready: true
                        //         },
                        //         hide: {
                        //                evt: 'mouseout unfocus'
                        //         },
                        //         style: {
                        //            	classes: 'qtip-bootstrap',
                        //            	tip: {
                        //            		width: 16,
                        //            		height: 8
                        //            	}
                        //         }
                        //     }, evt);


                            // node.qtip({ // Grab some elements to apply the tooltip to
                            //     content: {
                            //         text: 'My common piece of text here'
                            //     }
                            // })

                        //});

                        $('#advance').click(function(){

                            //var cyc = cytoscape({ container: document.getElementById('myDiagramDiv') });
                            var result = false;
                                <?php

                                    //VERIFICA O TIPO DE EQUIPAMENTO
                                    switch ($tipoEquip) {
                                        case 'Medidor temperatura':
                                            ?>
                                                var allElements         = cy.elements();
                                                var allNodes            = allElements.filter('node');

                                                for(var i=0; i<allNodes.size(); i++){

                                                    var objTemp = allNodes[i].json()
                                                    var objId   = objTemp['data']['id'];
                                                    var objX   = objTemp['position']['x'];
                                                    var objY   = objTemp['position']['y'];
                                                    //console.log(objTemp);
                                                    // console.log(objTemp['data']['id']);
                                                    // console.log(objTemp['position']['x']);
                                                    // console.log(objTemp['position']['y']);

                                                    result = salvarPontosPlantaBaixa(objId, objX, objY);
                                                    //resultadoInsercao.push(result);
                                                }

                                                // if(!resultadoInsercao){
                                                //     swal('','Posições não foram atualizadas!','error');
                                                // }else{
                                                //     swal('','Posições foram atualizadas!','success');
                                                // }

                                            <?php
                                        break;
                                        default:
                                            ?>
                                                var allElements = cy.elements();
                                                var allNodes = allElements.filter('node');
                                                var resultadoInsercao = false;
                                                var nodes = [];

                                                for(var i=0; i<allNodes.size(); i++){

                                                    var objTemp = allNodes[i].json()
                                                    var objId   = objTemp['data']['id'];
                                                    var objX   = objTemp['position']['x'];
                                                    var objY   = objTemp['position']['y'];
                                                    // console.log(objTemp['data']['id']);
                                                    // console.log(objTemp['position']['x']);
                                                    // console.log(objTemp['position']['y']);

                                                    //Efetua chamada JSON para efetuar o cadastro da posição do equipamento
                                                    //resultadoInsercao = salvarPontosPlantaBaixa(objId, objX, objY);
                                                    result = salvarPontosPlantaBaixa(objId, objX, objY);
                                                    //resultadoInsercao.push(result);
                                                }

                                            <?php
                                        break;
                                    }

                                ?>
                            swal({
                              title: "Salvando posições!",
                              text: "Essa mensagem se fechará após a conclusão.",
                              timer: 4000,
                              showConfirmButton: false
                            });

                        });

                        /*
                        * FUNÇÃO QUE IRÁ REALIZAR O CADASTRO OU ATUALIZAÇÃO DOS PONTOS NA PLANTA BAIXA
                        */
                        function salvarPontosPlantaBaixa(id, posx, posy){

                            var idEquip = "<?php echo $idEquip; ?>";
                            var idPLantaBaixa = $('#plantaId').val();

                            $.ajax({
                                url: urlP+"/equipamento/salvarPontosTabelaJson",
                        		secureuri: false,
                        		type : "POST",
                        		dataType: 'json',
                                data      : {
                                    'idEquip' : idEquip,
                                    'idPlantaBaixa' : idPLantaBaixa,
                                    'idPosicao' : id,
                                    'posx' : posx,
                                    'posy' : posy
                                },
                                success : function(datra)
                                 {

                                    if(datra.status){
                                        // swal("", "'Posições atualizadas com sucesso!", "success");
                    					// setTimeout(function(){
                    					// 	location.reload();
                    					// }, 2000);
                                        console.log("Posição : "+id+" Foi atualizada!");
                                        return true;
                                    }else{
                                        //swal("Oops...", "Ocorreu um ero ao tentar editar!", "error");
                                        console.log("Posição : "+id+" Não foi atualizada!");
                                        return false;
                                    }

                                 },
                                 error: function(jqXHR, textStatus, errorThrown)
                                  {
                                  // Handle errors here
                                  console.log('ERRORS: ' + textStatus +" "+errorThrown+" "+jqXHR);
                                  // STOP LOADING SPINNER
                                  }
                            });

                            //console.log('Função sendo chamada!! '+idEquip+' id da planta : '+idPLantaBaixa);
                        }

                    </script>

                </div>

            <?php

            }

        ?>

    </div>

</div>
