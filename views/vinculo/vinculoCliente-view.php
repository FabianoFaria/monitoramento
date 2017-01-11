<?php

    if (! defined('EFIPATH')) exit();

    $dados = $modeloCliente->carregarDadosCliente($this->parametros[0]);

    $vinculos = $modelo->ListarVinculosCliente($this->parametros[0]);

    if($dados['status']){
		$dadosCliente = $dados['dados'][0];

	}else{
	 	$dadosCliente = null;
	}

    if($vinculos['status']){
		$dadosVinculo = $vinculos['sims'];

	}else{
	 	$dadosVinculo = null;
	}

    //var_dump($dadosCliente);

?>


<script type="text/javascript">
    // gerenciador de link
    var menu = document.getElementById('listadir');
    menu.innerHTML = '<a href="<?php echo HOME_URI; ?>/home/" class="linkMenuSup">Home</a> / <a href="<?php echo HOME_URI; ?>/cliente/" class="linkMenuSup">Lista de clientes</a> / <a href="<?php echo HOME_URI; ?>/vinculo/gerenciarVinculo/<?php echo $this->parametros[0]; ?>"> Vinculos do cliente</a>';
</script>


<div class="row">
    <div class="col-lg-12">
        <!-- TITULO PAGINA -->
        <label class="page-header">Viculos registrados para <?php echo (isset($dadosCliente)) ? $dadosCliente['nome'] : 'Desconhecido' ?> </label><!-- Fim Titulo pagina -->

    </div>

</div>

<div class="row">
    <div class="col-md-4">
        <div class="pull-left">
            <div class="btn-group">
                <a href="<?php echo HOME_URI; ?>/vinculo/cadastrarVinculo/<?php echo $this->parametros[0]; ?>" class="btn btn-primary">
                    <i class="fa fa-plus fa-lg"> </i>Adicionar novo vinculo ao cliente
                </a>
            </div>
        </div>

    </div>

</div>

<div class="row">
    <div class="col-md-12">

        <!-- Cadastra do cliente -->
       	<div class="panel-group" id="accordionVinculoClie" role="tablist" aria-multiselectable="true">
            <div class="panel panel-default">
            	<div class="panel-heading" role="tab" id="headingOne">
                  <h4 class="panel-title">
                    <a role="button" data-toggle="collapse" data-parent="#accordionContatoClie" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                      <i class="fa  fa-building-o  "></i> Sims vinculados ao cliente
                    </a>
                  </h4>
                </div>
            </div>
            <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                <div class="panel-body">
                    <div class='table-responsive'>
                        <table id="stream_table" class='table table-striped table-bordered'>
                            <thead>
                                <tr>
                                    <th>
                                        Número do Sim
                                    </th>
                                    <th>
                                        Posicionamento da tabela
                                    </th>
                                    <th>
                                        Excluir
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    if($vinculos['status']){

                                        foreach ($dadosVinculo as $vinculo) {

                                            echo "<tr><td>".$vinculo['num_sim']."</td><td><a href='javascript:void(0)' onClick='detalhesPosicao(".$vinculo['num_sim'].")'><i class='fa fa-eye '></i></a></td><td><a href='#' class='removeVinculo'><i class='fa fa-times'></i></a></td></tr>";

                                        }
                                    }
                                    else{

                                ?>
                                    <td colspan="3">
                                        Nenhum SIM cadastrado até o momento
                                    </td>
                                <?php

                                    }
                                ?>


                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>

<!-- Modal exibindo as posições já ocupadas pelo sim informado! -->

<div  id="posicoesTabela" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Posicionamento da tabela</h4>
          </div>

          <div class="modal-body">
              <div class="panel panel-default">
                  <div class="panel-heading">
                    <i class="fa fa-user-md "></i> Posições ocupadas na tabela
                  </div>
                  <div class="panel-body">
                    <div class="row">
                        <div class="col-md-6">
                            <span id="posOcupadas"></span>
                        </div>
                    </div>
                  </div>
              </div>
          </div>
        </div>
  </div>
</div>
