<?php

    if (! defined('EFIPATH')) exit;

    $dadosEquipamento   = $modelo->dadosEquipamentoCliente($this->parametros[0]);

    var_dump($dadosEquipamento);

    $local              = (isset($dadosEquipamento['equipamento'][0]['filial']))? $dadosEquipamento['equipamento'][0]['filial'] : "Matriz";
    $local              = $dadosEquipamento['equipamento'][0]['cliente']." - ".$local;

    $plantaBaixa        = $modelo->dadosEquipamentoPlantaBaixa($this->parametros[0]);

    //var_dump($plantaBaixa);
?>

<!-- <script src="<?php echo HOME_URI ?>/views/_js/go.js" ></script> -->
<script src='<?php echo HOME_URI ?>/views/_js/cytoscape.min.js'></script>

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

            ?>

                <div class="row">

                    <div class="col-md-6">
                        <div class="form-group">
                            <!-- <label for="exampleInputEmail1">Descrição da planta baixa cadastrada atualmente</label> -->
                            <input type="text" class="form-control" id="txt_planta" name="txt_planta" value="<?php echo $plantaBaixa['dadosPlanta'][0]['descricao_imagem']; ?>" readonly="true">

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

                    <div class="col-md-12">

                        <div id="sample">
                          <div id="myDiagramDiv" style="border: solid 1px black; width:100%; height:600px; background:url(<?php echo HOME_URI; ?>/views/_uploads/plantas/<?php echo $plantaBaixa['dadosPlanta'][0]['imagem_planta']; ?>) no-repeat; background-position:5px 5px;"></div>
                          <!-- <p>This diagram displays a monitored floor plan with several nodes (representing kittens) to view in real-time.</p>
                          <p>Every two seconds the kitten positions are updated</p>
                          <p>The <a href="../intro/toolTips.html">Tooltip</a> for each kitten shows its name and photo.</p>
                          <p>There is a custom <a>Diagram.scaleComputation</a> that limits the <a>Diagram.scale</a> values to multiples of 0.1.</p> -->
                        </div>

                    </div>

                    <script  type="text/javascript">

                        var cy = cytoscape({
                            container: document.getElementById('myDiagramDiv'),
                            elements: [
                                { data: { id: 'Equipamento A', equipamento: 'Mestre', image: '<?php echo HOME_URI; ?>/views/_images/equipamento.png'} },
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
                                name: 'grid',
                                rows: 1
                            },
                            zoomingEnabled: false
                        });

                        <?php

                            switch ($tipoEquip) {
                                case 'Medidor temperatura':
                                    // Irá Adicionar os pontos configurados para o medidor de temperatura
                                    ?>

                                        for (var i = 0; i < <?php echo $numerosEntradas; ?>; i++) {
                                            cy.add({
                                                data: { id: 'Medidor :' + i, equipamento: 'Ponto :'+i, image: '<?php echo HOME_URI; ?>/views/_images/scale.png' }
                                                }
                                            );
                                            var source = 'Medidor :' + i;
                                            cy.add({
                                                data: {
                                                    id: 'edge' + i,
                                                    source: source,
                                                    target: 'Equipamento A'
                                                }
                                            });
                                        }

                                    <?php
                                break;

                                default:
                                    // Irá Adicionar o medidor de temperatura ambiente
                                    ?>
                                        cy.add({
                                            data: { id: 'tempAmb', equipamento: 'Temperatura ambiente', image: '<?php echo HOME_URI; ?>/views/_images/scale.png' }
                                            }
                                        );
                                        var source = 'tempAmb';
                                        cy.add({
                                                data: {
                                                    id: 'edge',
                                                    source: source,
                                                    target: 'Equipamento A'
                                            }
                                        });
                                    <?php

                                break;
                            }

                        ?>

                        // cy.on('tap', 'node', function(evt){
                        //     //var node = evt.target;
                        //         //console.log( 'tapped ' + node.id() );
                        //
                        //         var node = evt.target;
                        //        node.qtip({
                        //             content: 'hello world <br /> Teste',
                        //             show: {
                        //                evt: evt.type,
                        //                ready: true
                        //             },
                        //             hide: {
                        //                evt: 'mouseout unfocus'
                        //             }
                        //        }, evt);
                        // });

                    </script>

                </div>

            <?php

            }

        ?>

    </div>

</div>
