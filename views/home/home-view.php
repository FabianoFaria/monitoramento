<?php
    if (! defined('EFIPATH')) exit;
?>

<script type="text/javascript">
    // gerenciador de link
    var menu = document.getElementById('listadir');
    menu.innerHTML = '<a href="<?php echo HOME_URI; ?>/home/" class="linkMenuSup">Home</a>';
</script>


<div class="container-fluid nome-apresentacao">
    <!-- Titulo pagina -->
    <label class="titulo-pagina">
        <?php
            echo "Bem vindo, " . $_SESSION['userdata']['firstname'] ." ". $_SESSION['userdata']['secondname'];
        ?>
    </label><!-- Fim Titulo pagina -->
</div>

<div class="col-md-12">

    <h2>Teste</h2>

</div>


<?php /* ?>

<!-- Wrapper -->
<div id="wrapper3">

    <!-- Content -->
    <div id="content3">
        Content
    </div><!-- Fim Content -->

    <!-- Sidebar -->
    <div id="sidebar3">
        <ul class="lista-notificacao">
            <li class="not-normal">
                <label><i class="fa fa-check"></i> asdfasdfasd</label></li>
            <li class="not-warn">
                <label><i class="fa fa-exclamation"></i> sdfasdfasd</label></li>
            <li class="not-alert">
                <label><i class="fa fa-times"></i> sdfasdfasd</label></li>
            </li>
            <li>asdfasdfasd</li>
        </ul>
    </div><!-- Fim Sidebar -->

    <div id="cleared3"></div>
</div><!-- Fim Wrapper -->
<?php */ ?>
