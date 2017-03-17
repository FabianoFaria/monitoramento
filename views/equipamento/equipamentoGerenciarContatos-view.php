<?php
    if (! defined('EFIPATH')) exit;

    /*
    * VERIFICA O TIPO DE USUÁRIO E EFETUA AS RESPECTIVAS OPERAÇÕE
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
        case 'Tecnico':
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
        break;
    }

?>

<script type="text/javascript">
    // gerenciador de link
    var menu = document.getElementById('listadir');
    menu.innerHTML = '<a href="<?php echo HOME_URI; ?>/home/" class="linkMenuSup">Home</a> / <a href="<?php echo HOME_URI; ?>/alarme/alarmePorEquipamento" class="linkMenuSup">Alarmes por equipamento </a> / <a href="<?php echo HOME_URI; ?>/equipamento/gerenciarContatosEquipamentos/<?php echo $this->parametros[0]; ?>"> Cliente :<?php echo $nomeCliente; ?> - Equipamento : <?php echo $lista[0]['tipoEquip']." ".$lista[0]['nomeModeloEquipamento'];?></a>';
</script>


<?php

    var_dump($lista);

 ?>
