<?php

    // Verifica se esta definido o path
    if (! defined('EFIPATH')) exit();

    if(is_numeric($this->parametros[0])){

        /*
        * TESTA SE USUÁRIO TEM PERMISSÃO PARA VISUALIZAR O EQUIPAMENTO ESPECIFICADO
        */
        switch ($_SESSION['userdata']['tipo_usu']) {

            case 'Administrador':

                $dadosCliente   = $modeloClie->carregarDadosClienteEquipamento($this->parametros[0]);

                if($dadosCliente['status']){
                    $dadosCliente   = $dadosCliente['dados'][0];

                    $idClienteForm  = $dadosCliente['id'];

                    $lista          = $modeloEquip->dadosEquipamentoCliente($this->parametros[0]);
                    $lista          = $lista['equipamento'];
                    $nomeCliente    = $dadosCliente['nome'];
                }else{
                    $lista          = false;
                }

            break;
            case 'Cliente':
                //RECEBE O PARAMETRO DO CLIENTE E VERIFICA SE O USUÁRIO TEM ACESSO E ELE
                $usuarioAutorizado  = false;
                $idcliente = $_SESSION['userdata']['cliente'];
                $usuariosCliente  = $modeloClie->carregarDadosClienteEquipamento($this->parametros[0]);

                //VERIFICA SE O USUAÁRIO PERTENCE AO CLIENTE QUE ESTÁ TENTANDO ACESSAR
                if($usuariosCliente['status']){

                    foreach ($usuariosCliente['dados'] as $usuarioCliente){

                        if(intval($usuarioCliente['id']) == $idcliente){
                            $usuarioAutorizado  = true;
                        }
                    }
                }

                if($usuarioAutorizado){
                    $dadosCliente   = $modeloClie->carregarDadosCliente($idcliente);

                    if($dadosCliente['status']){
                        $dadosCliente   = $dadosCliente['dados'][0];

                        $idClienteForm  = $idcliente;

                        $lista          = $modeloEquip->dadosEquipamentoCliente($this->parametros[0]);
                        $lista          = $lista['equipamento'];
                        $nomeCliente    = $dadosCliente['nome'];
                    }else{
                        $lista          = false;
                    }
                }else{
                    $lista          = false;
                }

            break;
            case 'Visitante':
                //RECEBE O PARAMETRO DO CLIENTE E VERIFICA SE O USUÁRIO TEM ACESSO E ELE
                $usuarioAutorizado  = false;
                $idcliente = $_SESSION['userdata']['cliente'];
                $usuariosCliente  = $modeloClie->carregaDadosContato($this->parametros[0]);

                //VERIFICA SE O USUAÁRIO PERTENCE AO CLIENTE QUE ESTÁ TENTANDO ACESSAR
                if($usuariosCliente['status']){
                    foreach ($usuariosCliente['dados'] as $usuarioCliente){
                        if($usuarioCliente['id_cliente'] == $idcliente){
                            $usuarioAutorizado  = true;
                        }
                    }
                }

                if($usuarioAutorizado){
                    $dadosCliente   = $modeloClie->carregarDadosClienteEquipamento($this->parametros[0]);

                    if($dadosCliente['status']){

                        $idClienteForm  = $idcliente;

                        $dadosCliente   = $dadosCliente['dados'][0];
                        $lista          = $modeloEquip->dadosEquipamentoCliente($this->parametros[0]);
                        $lista          = $lista['equipamento'];
                        $nomeCliente    = $dadosCliente['nome'];
                    }else{
                        $lista          = false;
                    }
                }else{
                    $lista          = false;
                }

            break;
            case 'Tecnico':
                $dadosCliente   = $modeloClie->carregarDadosClienteEquipamento($this->parametros[0]);

                if($dadosCliente['status']){
                    $dadosCliente   = $dadosCliente['dados'][0];
                    $lista          = $modeloEquip->dadosEquipamentoCliente($this->parametros[0]);
                    $lista          = $lista['equipamento'];
                    $nomeCliente    = $dadosCliente['nome'];
                    $idClienteForm  = $dadosCliente['id'];
                }else{
                    $lista          = false;
                }
            break;
        }


        if($lista){

            ?>

                <script type="text/javascript">

                    // GERENCIADOR DE LINK
                    var menu = document.getElementById('listadir');
                    menu.innerHTML = '<a href="<?php echo HOME_URI; ?>/home/" class="linkMenuSup">Home</a> / <a href="<?php echo HOME_URI; ?>/monitoramento/equipamentoPlantaBaixa/" class="linkMenuSup">Monitoramento planta baixa</a> / <a href="<?php echo HOME_URI; ?>/monitoramento/monitorarPlantaBaixa/<?php echo $this->parametros[0]; ?>"> Planta baixa da unidade : <?php echo $lista[0]['cliente']; ?> - <?php echo (isset($lista[0]['filial'])) ? $lista[0]['filial'] :"Matriz"; ?> </a>';

                </script>

                <link rel="stylesheet" type="text/css" href="<?php echo HOME_URI ?>/views/_css/jquery.qtip.min.css">

                <script src="<?php echo HOME_URI ?>/views/_js/jquery.qtip.min.js" ></script>
                <script src='<?php echo HOME_URI ?>/views/_js/cytoscape.min.js'></script>
                <script src="<?php echo HOME_URI ?>/views/_js/cytoscape-qtip.js"></script>

                <div class="row">
                    <div class="col-lg-12">
                        <!-- TITULO PAGINA -->
                        <label class="page-header"> Pontos configurados na planta baixa :</label><!-- Fim Titulo pagina -->
                    </div>
                </div>


                <div class="row" >

                    <div class="col-lg-12">
                        <?php
                            $idEquip = $lista[0]['id'];
                            //var_dump($lista);

                            $plantaBaixa        = $modeloEquip->dadosEquipamentoPlantaBaixa($idEquip);

                            //var_dump($plantaBaixa);

                            $pontosCadastrados  = $modeloEquip->carregarPontosPlantaBaixa($idEquip);

                            //var_dump($pontosCadastrados);

                            $dadosEquipamento   = $modeloEquip->dadosEquipamentoCliente($idEquip);

                            //var_dump($dadosEquipamento);

                            /*
                            * VERIFICA SE FOI CONFIGURADO UMA PLANTA BAIXA E PONTOS PARA O EQUIPAMENTO
                            */
                            if($pontosCadastrados['status'] && $plantaBaixa['status']){

                                /*
                                * VARIAVEIS PARA SEREM USADAS NA MONTAGEM DAS PLANTA BAIXA
                                */
                                $idEquip            = $dadosEquipamento['equipamento'][0]['id'];
                                $idSim              = $dadosEquipamento['equipamento'][0]['id_sim'];
                                $idSimEquip         = $dadosEquipamento['equipamento'][0]['id_sim_equip'];
                                $tipoEquip          = $dadosEquipamento['equipamento'][0]['tipoEquip'];
                                $numerosEntradas    = $dadosEquipamento['equipamento'][0]['tipo_entrada'];
                                $tipoEquip          = $dadosEquipamento['equipamento'][0]['tipoEquip'];

                                /*
                                * Inicia a construção do gráfico com os pontos do equipamento cadastrado.
                                */
                                ?>
                                    <div class="row">
                                        <div class="col-md-3">

                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <!-- <label for="exampleInputEmail1">Descrição da planta baixa cadastrada atualmente</label> -->
                                                <input type="text" class="form-control" id="txt_planta" name="txt_planta" value="<?php echo $plantaBaixa['dadosPlanta'][0]['descricao_imagem']; ?>" readonly="true">
                                                <input type="hidden" id="idEquip" name="idEquip" value="<?php echo $idEquip; ?>" />
                                                <input type="hidden" id="idSim" name="idSim" value="<?php echo $idSim; ?>" />
                                                <input type="hidden" id="idSimEquip" name="idSimEquip" value="<?php echo $idSimEquip; ?>" />
                                                <input type="hidden" id="tipoEquip" name="tipoEquip" value="<?php echo $tipoEquip; ?>" />
                                            </div>

                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                        </div>
                                        <div class="col-md-8">

                                            <div id="sample">
                                              <div id="myDiagramDiv" style="border: solid 1px black; width:100%; height:600px; background:url(<?php echo HOME_URI; ?>/views/_uploads/plantas/<?php echo $plantaBaixa['dadosPlanta'][0]['imagem_planta']; ?>) no-repeat; background-position:5px 5px;"></div>
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
                                                autoungrabify: true,
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

                                                                        });

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

                                            cy.on('tap', 'node', function(evt){
                                                // var node = evt.target;
                                                //     console.log( 'tapped ' + node.id() );

                                                var node        = evt.target;

                                                var idSim       = $('#idSim').val();
                                                var idSimEquip  = $('#idSimEquip').val();
                                                var tipoEquip   = $('#tipoEquip').val();
                                                var pontoReal   = this.id().split(" "); //this.data('equipamento')
                                                var pontoEquip  = pontoReal[pontoReal.length - 1].toLowerCase();
                                                var ultimoValor = 0;
                                                //console.log('teste de id : '+pontoEquip);
                                                $.ajax({
                                                    url: urlP+"/monitoramento/carregarUltimoDadoPosicaoPlantaBaixaJson",
                                                    secureuri: false,
                                                    type : "POST",
                                                    dataType: 'json',
                                                    data      : {
                                                        'idSim' : idSim,
                                                        'idSimEquip' : idSimEquip,
                                                        'pontoEquip' : pontoEquip,
                                                        'tipoEquip'  : tipoEquip
                                                    },
                                                    success : function(datra)
                                                    {
                                                        if(datra.status){
                                                            ultimoValor = "<p>Ponto :"+pontoEquip.toUpperCase()+"</p>"+datra.dados+"";
                                                        }else{
                                                            ultimoValor = "<p>Ponto :"+pontoEquip.toUpperCase()+"</p><p><span class='text-danger'>"+datra.dados+"</span></p>";
                                                        }

                                                        node.qtip({
                                                            content: function(){ return ultimoValor },
                                                            show: {
                                                                evt: evt.type,
                                                                ready: true
                                                            },
                                                            hide: {
                                                                   evt: 'mouseout unfocus'
                                                            },
                                                            style: {
                                                               	classes: 'qtip-bootstrap',
                                                               	tip: {
                                                               		width: 15,
                                                               		height: 10
                                                               	}
                                                            }
                                                        }, evt);

                                                    },
                                                    error: function(jqXHR, textStatus, errorThrown)
                                                    {
                                                        //Settar a mensagem de erro!
                                                        ultimoValor = 0;
                                                        // Handle errors here
                                                        console.log('ERRORS: ' + textStatus +" "+errorThrown+" "+jqXHR);
                                                        // STOP LOADING SPINNER
                                                    }
                                                });

                                                //'Example qTip on ele ' + this.data('equipamento')
                                                console.log('Teste de ultimo dado '+ultimoValor);

                                            });

                                        </script>
                                    </div>
                                <?php

                            }else{

                                ?>
                                    <div class="row">
                                        <div class="panel panel-red">
                                            <div class="panel-heading">
                                                Equipamento sem planta baixa  ou pontos registrados no momento.
                                            </div>
                                            <div class="panel-body">
                                                <p>Não há informações sobre pontos do equipamentopamento ou da planta baixa onde está localizado o equipamento! Favor verificar outros equipamentos.</p>
                                            </div>
                                            <div class="panel-footer">

                                            </div>
                                        </div>
                                    </div>
                                <?php
                            }
                        ?>
                    </div>
                </div>

            <?php

        }else{
            echo "Favor verificar suas permisões de usuário!";
        }

    }else{
        echo "Parametro inválido!";
    }

?>
