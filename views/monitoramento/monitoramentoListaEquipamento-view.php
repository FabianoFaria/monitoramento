<?php 

if (!defined('EFIPATH')) exit();

?>

<script src="<?php echo HOME_URI; ?>/views/_js/table/mustache.js" type="text/javascript"></script>
<script src="<?php echo HOME_URI; ?>/views/_js/table/stream_table.js" type="text/javascript"></script>

<?php
// chamando lista de valores
$retorno = $modelo->buscaRelacaoEquipamento();
$retorno2 = $modelo->buscaClienteFilial();


?>

<script type="text/javascript">
    var Movies0 = [ 
        <?php
            /* se for um array */
            if (is_array($retorno))
            {
                $guarda = "";
                
                for ($a = 0 ; $a < sizeof($retorno) ; $a++)
                {
                    if (!empty($retorno[$a]))
                    {
                        $statusVer = "Desativado";
                        if ($retorno[$a]['status_ativo'] == 1)
                            $statusVer = "Ativado";
                        
                        
                        $tempo = date('d/m/Y', strtotime($retorno[$a]['dt_criacao']));
                        /* criptografa */
                        $chaveSim = base64_encode($retorno[$a]['num_sim']);
                        /* criptografa ambiente/equipamento */
                        $modelaq = base64_encode($retorno[$a]['tb_sim_id']);
                        /* criptografa id-sim-equip*/
                        $modeliq = base64_encode($retorno[$a]['equip_id']);
                        /* criptografa id-sim-equipamento */
                        $sim_equ = base64_encode($retorno[$a]['tb_sim_id']);

                        
                        // Monta o array dos dados
                        $guarda .= "{num_sim:     '{$chaveSim}',
                                     modeleq:     '{$modeliq}' ,
                                     modelsq:     '{$modelaq}' ,
                                     sim_equi:    '{$sim_equ}' ,
                                     
                                     modelsh: '{$this->parametros[0]}', 
                                     nomeEqui: '{$retorno[$a]['tipo_equipamento']}',
                                     modelo: '{$retorno[$a]['modelo']}',
                                     fabricante: '{$retorno[$a]['nome']}',
                                     dataCriado: '{$tempo}',
                                     status: '{$statusVer}' },";
                    }
                }
                
                $guarda .= ".";
                $guarda = str_replace(",.","",$guarda);
                echo $guarda;
                
            }
        ?>
    ];
    var Movies = [Movies0];


    // gerenciador de link
    var menu = document.getElementById('listadir');
    menu.innerHTML = '<a href="<?php echo HOME_URI; ?>/home/" class="linkMenuSup">Home</a> / <a href="<?php echo HOME_URI; ?>/configuracao/" class="linkMenuSup">Configura&ccedil;&atilde;o</a>';
</script>


<script src="<?php echo HOME_URI; ?>/views/_js/table/index.js" type="text/javascript"></script>


<div class="container-fluid">
    <!-- Titulo pagina -->
    <label class="titulo-pagina-cliente"><?php echo $retorno2['nome']; ?></label>
    
    <label class="titulo-pagina">
        - VISUALIZAR BI-GRAFI DO EQUIPAMENTO
    </label><!-- Fim Titulo pagina --><!-- Fim Titulo pagina -->
    
    <div class='table-responsive'>
        <table id="stream_table" class='table table-striped table-bordered'>
            <thead>
                <tr>
                    <th lass="tdbdbottom">Nome do equipamento</th>
                    <th lass="tdbdbottom">Modelo</th>
                    <th lass="tdbdbottom">Fabricante</th>
                    <th lass="tdbdbottom">Status</th>
                    <th lass="tdbdbottom">Criado</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
        <div id="summary"><div></div></div>
    </div>
</div>

<script id="template" type="text/html">
    <tr>
        
        <td class="tdprim">
            <a href="<?php echo HOME_URI; ?>/monitoramento/gerarGrafico/{{record.num_sim}}/{{record.modeleq}}/{{record.modelsq}}/{{record.sim_equi}}" class="link-tabela-moni">
                {{record.nomeEqui}}
            </a>
        </td>
        <td>
            <a href="<?php echo HOME_URI; ?>/monitoramento/gerarGrafico/{{record.num_sim}}/{{record.modeleq}}/{{record.modelsq}}/{{record.sim_equi}}" class="link-tabela-moni">
                {{record.modelo}}
            </a>
        </td>
        <td>
            <a href="<?php echo HOME_URI; ?>/monitoramento/gerarGrafico/{{record.num_sim}}/{{record.modeleq}}/{{record.modelsq}}/{{record.sim_equi}}" class="link-tabela-moni">
                {{record.fabricante}}
            </a>
        </td>
        <td>
            <a href="<?php echo HOME_URI; ?>/monitoramento/gerarGrafico/{{record.num_sim}}/{{record.modeleq}}/{{record.modelsq}}/{{record.sim_equi}}" class="link-tabela-moni">
                {{record.status}}
            </a>
        </td>
        <td>
            <a href="<?php echo HOME_URI; ?>/monitoramento/gerarGrafico/{{record.num_sim}}/{{record.modeleq}}/{{record.modelsq}}/{{record.sim_equi}}" class="link-tabela-moni">
                {{record.dataCriado}}
            </a>
        </td>
    </tr>
</script>