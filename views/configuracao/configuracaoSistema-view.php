<?php

    /* verifica se esta definido o path */
    if (! defined('EFIPATH')) exit();


    //CARREGA LISTA DE CONFIGURAÇÕES DE FORMULAS




?>

<script type="text/javascript">

    // gerenciador de link
    var menu = document.getElementById('listadir');

    menu.innerHTML = '<a href="<?php echo HOME_URI; ?>/home/" class="linkMenuSup">Home</a> / <a href="<?php echo HOME_URI; ?>/configuracao/configuracoesSistema/" class="linkMenuSup">Configura&ccedil;&atilde;o</a>';

</script>
