<?php

/* verifica se esta definido o path */
if (! defined('EFIPATH')) exit();

// chamando lista de valores
// cliente id ; tipo
$retorno = $modelo->tabelaDeCliente($_SESSION['userdata']['cliente'],$_SESSION['userdata']['tipo']);

    var_dump($_SESSION);

    //Página aparentemente utilizada para usuários EXTERNOS

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


<div class="row">

    <div class="col-md-8 barraBemvindo">
        <!-- Titulo pagina -->
        <label class="page-header">
            <h4>Bem vindo, <?php echo $_SESSION['userdata']['firstname']." ".$_SESSION['userdata']['secondname']; ?></h4>
        </label>
    </div>
    <div class="col-md-4 pull-right">
        <div class="panel panel-info">
            <div class="panel-heading">
                <i class="fa fa-clock-o  fa-fw"></i> Última atualização
            </div>
            <div class="panel-body">
                <p>
                    <?php // Exibe alguma coisa como: Monday 8th of August 2005 03:12:46 PM
                        echo date('d/ m/ Y, g:i a');
                    ?>
                </p>
            </div>
        </div>
    </div>
</div>
<div>
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
