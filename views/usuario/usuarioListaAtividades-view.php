<!-- LISTAR ATIVIDADES USUÁRIOS VIEW -->
<?php

    if (! defined('EFIPATH')) exit;

    /*
    * VERIFICA O TIPO DE USUÁRIO E EFETUA AS RESPECTIVAS OPERAÇÕES
    */
    switch ($_SESSION['userdata']['tipo_usu']) {
        case 'Administrador':
            $listaAcess     = $modeloLog->listarAtividadesUsuarios($this->parametros[0]);
        break;
        default:
            //$this->moveHome();
            $listaAcess     = false;
        break;
    }


?>


<script type="text/javascript">
    // gerenciador de link
    var menu = document.getElementById('listadir');
    menu.innerHTML = '<a href="<?php echo HOME_URI; ?>/home/" class="linkMenuSup">Home</a> / <a href="<?php echo HOME_URI; ?>/usuario/listar">Listar usuários</a> / <a href="<?php echo HOME_URI; ?>/usuario/listarAtividades/<?php echo $this->parametros[0] ?>"> Lista de atividades do usuário</a>';
</script>

<div class="row">
    <div class="col-lg-12">

        <!-- TITULO PAGINA -->
        <label class="page-header">Atividades registradas do usuário até o momento</label><!-- Fim Titulo pagina -->

        <!-- TABELA CONTENDO OS USUÁRIOS CADASTRADOS -->
        <div class="panel panel-default">
            <div class="panel-heading">


            </div>
            <div class="panel-body">
                <div class='table-responsive'>
                    <table id="stream_table" class='table table-striped table-bordered'>
                        <thead>
                            <tr>
                                <td>
                                    Usuário
                                </td>
                                <td>
                                    Atividade
                                </td>
                                <td>
                                    Data
                                </td>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
