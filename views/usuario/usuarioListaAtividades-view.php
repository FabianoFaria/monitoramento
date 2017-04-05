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
                                <th>
                                    Usuário
                                </th>
                                <th>
                                    Atividade
                                </th>
                                <th>
                                    Horário
                                </th>
                                <th>
                                    Data
                                </th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php

                                //var_dump($listaAcess);

                                if($listaAcess['status']){
                                    $atividades = $listaAcess['atividades'];
                                    foreach ($atividades as $acao) {

                                        $dataTemp = explode(' ', $acao['data_registro']);

                                    ?>
                                        <tr>
                                            <td>
                                                <?php echo $acao['nome']." ".$acao['sobrenome']; ?>
                                            </td>
                                            <td>
                                                <?php echo $acao['nome_atividade']; ?>
                                            </td>
                                            <td>
                                                <?php echo $dataTemp[1]; ?>
                                            </td>
                                            <td>
                                                <?php echo implode('/', array_reverse(explode('-', $dataTemp[0]))); ?>
                                            </td>
                                        </tr>
                                    <?php

                                    }

                                }else{
                                ?>
                                    <tr>
                                        <td colspan="3">
                                            O usuário especificado não possui atividades registradas.
                                        </td>
                                    </tr>
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
