<?php

    if (! defined('EFIPATH')) exit;

    $dadosEquipamento   = $modelo->dadosEquipamentoCliente($this->parametros[0]);

    //var_dump($dadosEquipamento);

    $local              = (isset($dadosEquipamento['equipamento'][0]['filial']))? $dadosEquipamento['equipamento'][0]['filial'] : "Matriz";
    $local              = $dadosEquipamento['equipamento'][0]['cliente']." - ".$local;

?>


<script type="text/javascript">
    // gerenciador de link
    var menu = document.getElementById('listadir');
    menu.innerHTML = '<a href="<?php echo HOME_URI; ?>/home/" class="linkMenuSup">Home</a> / <a href="<?php echo HOME_URI; ?>/equipamento"> Equipamentos </a> / <a href="<?php echo HOME_URI; ?>/equipamento/gerenciarPlantaBaixa/"> Listar locais </a> / <a href="<?php echo HOME_URI; ?>/equipamento/carregarPontosPlantaBaixa/<?php echo $this->parametros[0]; ?>">Configurar pontos planta baixa : <?php echo $local; ?></a>';
</script>
