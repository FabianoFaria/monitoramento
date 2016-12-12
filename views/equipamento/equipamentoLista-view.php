<!-- LISTAR EQUIPAMENTOS VIEW -->
<?php
    if (! defined('EFIPATH')) exit;
?>

<script type="text/javascript">
    // gerenciador de link
    var menu = document.getElementById('listadir');
    menu.innerHTML = '<a href="<?php echo HOME_URI; ?>/home/" class="linkMenuSup">Home</a> / <a href="<?php echo HOME_URI; ?>/equipamento">Listar equipamentos</a>';
</script>
