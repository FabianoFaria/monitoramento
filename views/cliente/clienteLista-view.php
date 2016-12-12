<!-- LISTAR CLIENTES VIEW -->
<?php
    if (! defined('EFIPATH')) exit;
?>

<script type="text/javascript">
    // gerenciador de link
    var menu = document.getElementById('listadir');
    menu.innerHTML = '<a href="<?php echo HOME_URI; ?>/home/" class="linkMenuSup">Home</a> / <a href="<?php echo HOME_URI; ?>/cliente">Listar clientes</a>';
</script>

<?php

    $lista = $clienteModelo->listarCliente();


    var_dump($lista);

 ?>
