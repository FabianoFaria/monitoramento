<?php

if(!defined('EFIPATH')) exit();

?>

<script type="text/javascript">
    // gerenciador de link
    var menu = document.getElementById('listadir');
    menu.innerHTML = '<a href="<?php echo HOME_URI; ?>/home/" class="linkMenuSup">Home</a> / <a href="<?php echo HOME_URI; ?>/vinculo/" class="linkMenuSup">Vinculo</a> / <a href="#" class="linkMenuSup">Pend&ecirc;ncia de vinculo</a>';
</script>


<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <!-- Titulo pagina -->
            <label class="titulo-pagina">LISTA DE PEND&Ecirc;NCIA</label><!-- Fim Titulo pagina -->

            <ul class="lista-pendencia-vinculo">
                <?php

                if (isset($dadosNot) && !empty($dadosNot) && is_array($dadosNot))
                {
                    foreach($dadosNot as $row)
                    {
                        // Link do equipamento ou ambiente a ser vinculado
                        $dirEq = base64_encode($row['id']."/".$row['sim']);
                        // Inicia a lista de itens a ser vinculado
                        echo "<li><a href='".HOME_URI."/vinculo/vincularposicao/{$dirEq}'>";
                        // Informa o nome do cliente
                        echo "<label class='label-lista-not-cliente'>{$row['nome']}</label><br>";
                        // Verifica o tipo , se eh ambiente ou equipamento
                        if ($row['tipo'] == 'e')
                            // Para equipamento
                            echo "<label class='label-lista-not-equipamento'>Equipamento {$row['nome_equip']}</label>";
                        else if ($row['tipo'] == 'a')
                            // Para Ambiente
                            echo "<label class='label-lista-not-equipamento'>Ambiente {$row['nome_amb']}</label>";

                        // Finaliza a lista de itens a ser vinculado
                        echo "</a></li>";
                    }
                }
                else
                    echo "<div class='col-md-4 col-md-offset-4 txt-center'><label class='lb-not'>Sem pend&ecirc;ncias</label></div>";

                ?>
            </ul>
        </div>
    </div>
</div>