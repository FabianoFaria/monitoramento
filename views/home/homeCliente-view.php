<?php

/* verifica se esta definido o path */
if (! defined('EFIPATH')) exit();

// chamando lista de valores
// cliente id ; tipo 
$retorno = $modelo->tabelaDeCliente($_SESSION['userdata']['cliente'],$_SESSION['userdata']['tipo']);

?>

<script src="<?php echo HOME_URI; ?>/views/_js/table/mustache.js" type="text/javascript"></script>
<script src="<?php echo HOME_URI; ?>/views/_js/table/stream_table.js" type="text/javascript"></script>
<script type="text/javascript">

var Movies0 = [ 
    <?php
        /* se for um array */
        if (is_array($retorno))
        {
            $guarda = "";
            foreach($retorno as $row)
            {
                $statusVer = "Desativado";
                if ($row['situacao'] == 1)
                    $statusVer = "Ativado";
                $tempo = date('d/m/Y', strtotime($row['tempo']));
                
                $chaveSim = base64_encode($row['sim']);
                /* criptografa ambiente/equipamento */
                $modelaq = base64_encode($row['id_sq']);
                /* criptograda id-sim-equip*/
                $modeliq = base64_encode($row['id_equip']);
                $guarda .= "{
                             modelsm:     '{$chaveSim}' ,
                             modelsq:     '{$modelaq}' ,
                             modeleq:     '{$modeliq}' ,
                             cliente:     '{$modelo->converte($row['cliente'],1)}' ,
                             equipamento: '{$modelo->converte($row['equipamento'],1)}' ,
                             install:     '{$tempo}' ,
                             status:      '{$statusVer}'
                            } ,";
                
            }
            $guarda .= ".";
            $guarda = str_replace(",.","",$guarda);
            echo $guarda;
        }
    ?>
];


var Movies = [Movies0];

</script>


<script src="<?php echo HOME_URI; ?>/views/_js/table/index.js" type="text/javascript"></script>


<div class="container">
    
    <label class="tituloPagina"><?php echo $modelo->converte($row['cliente'],1); ?></label>
    
    <div class='table-responsive'>
        <table id="stream_table" class='table table-striped table-bordered'>
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Equipamento</th>
                    <th>Instalado</th>
                    <th>Status</th>
                    <th class="txt-center">Monitoramento</th>
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
        <td class="tdprim">{{record.cliente}}</td>
        <td>{{record.equipamento}}</td>
        <td>{{record.install}}</td>
        <td>{{record.status}}</td>
        <td class="tdsec txt-center"><a href="<?php echo HOME_URI; ?>/home/definicoesGrafico/{{record.modelsm}}/{{record.modeleq}}/{{record.modelsq}}" class="link-tabela-moni">
            <i class="fa fa-search fa-lg"></i>
        </a></td>
    </tr>
</script>