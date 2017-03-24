<?php

/**
 * Classe que gerencia os controllers
 */
class MainController extends UserLogin
{
    /**
     * $db
     *
     * Armazena os parametros da conexao
     *
     * @access public
     */
    public $db;

    /**
     * $title
     *
     * Guarda o titulo da pagina
     *
     * @access public
     */
    public $title;

    /**
     * $login_required
     *
     * Verifica se eh obrigatorio o login
     *
     * @access public
     */
    public $login_required = false;

    /**
     * $parametros
     *
     * Recebe os parametros utilizados para as chamadas
     *
     * @access public
     */
    public $parametros = array();

    /**
     * Metodo construtor
     *
     * Sempre que a classe for instanciada
     * seta as configuracoes de conexao e os parametros
     *
     * @param array @parametros - Recebe os parametros utilizados
     */
    public function __construct ($parametros = array())
    {
        // Conexao com o banco
        $this->db       = new EficazDB();
        $this->mailer   = new email();

        // Parametros
		$this->parametros = $parametros;
    }

    /**
     * Funcao que move para home
     */
    public function moveHome()
    {
        // Ajusta a url
        $move = HOME_URI . '/home/';

        // Redireciona para a pagine home via javascrit
        echo '<script type="text/javascript">window.location.href = "' . $move . '";</script>';
    }

    /**
     * Funcao que carrega o model
     *
     * @param string $model_name - Recebe o nome do model
     */
    public function load_model($model_name = false)
    {
        // Verifica se enviou algum arquivo
        if (! $model_name ) return;

        // Inclui o arquivo
        $model_path = EFIPATH . '/models/'. $model_name . '.php';

        // Verifica se o arquivo existe
        if (file_exists($model_path))
        {
            // Inclui o arquivo
            require_once $model_path;

            // Converte em array
            $model_name = explode('/',$model_name);

            // Pega a ultima parte do nome
            $model_name = end ($model_name);

            // Remove caracteres invalidor
            $model_name = preg_replace( '/[^a-zA-Z0-9]/is', '', $model_name );

            // Verifica se a classe existe
            if (class_exists($model_name))
            {
                // Retorna o objeto da class
                return new $model_name($this->db, $this);
            }

            // Fim
            return;
        }
    }

    /**
    * Função para verificar o ponto da tabela
    */
    public function verificarPontoTabela($ponto){
        //EQUIPAMENTO inteiro
        if(($ponto == 'a')){
            $saida = "Equipamento mestre";
        }
        //ENTRADA DE TENSÃO
        if(($ponto == 'b') || ($ponto == 'c') || ($ponto == 'd')){
            switch ($ponto) {
                case 'b':
                    $saida = "Entrada de tensão R";
                break;
                case 'c':
                    $saida = "Entrada de tensão S";
                break;
                case 'd':
                    $saida = "Entrada de tensão T";
                break;
            }
        }
        //SAÍDA DE TENSÃO
        if(($ponto == 'e') || ($ponto == 'f') || ($ponto == 'g')){
            switch ($ponto) {
                case 'e':
                    $saida = "Saída de tensão R";
                break;
                case 'f':
                    $saida = "Saída de tensão S";
                break;
                case 'g':
                    $saida = "Saída de tensão T";
                break;
            }
        }
        //ENTRADA DE CORRENTE
        if(($ponto == 'i') || ($ponto == 'j') || ($ponto == 'l')){
            switch ($ponto) {
                case 'i':
                    $saida = "Entrada de corrente R";
                break;
                case 'j':
                    $saida = "Entrada de corrente S";
                break;
                case 'l':
                    $saida = "Entrada de corrente T";
                break;
            }
        }
        //SAÍDA DE CORRENTE
        if(($ponto == 'm') || ($ponto == 'n') || ($ponto == 'o')){
            switch ($ponto) {
                case 'm':
                    $saida = "Saída de corrente R";
                break;
                case 'n':
                    $saida = "Saída de corrente S";
                break;
                case 'o':
                    $saida = "Saída de corrente T";
                break;
            }
        }
        //BATERIA
        if(($ponto == 'h') || ($ponto == 'p')){
            switch ($ponto) {
                case 'h':
                    $saida = "Bateria";
                break;
                case 'p':
                    $saida = "Bateria 2";
                break;
            }
        }
        //TEMPERATURA
        if(($ponto == 'q') || ($ponto == 'r')){
            switch ($ponto) {
                case 'q':
                    $saida = "Temperatura Ambiente";
                break;
                case 'r':
                    $saida = "Temperatura Banco Bateria";
                break;
            }
        }
        return $saida;
    }

    /**
    * Função para tratar os últimos valores recebidos
    */
    public function configurarTipoPontoTabela($ponto, $medida){
        //ENTRADA DE TENSÃO
        if(($ponto == 'b') || ($ponto == 'c') || ($ponto == 'd')){
            switch ($ponto) {
                case 'b':
                    $saida = ($medida / 100)." (V)";
                break;
                case 'c':
                    $saida = ($medida / 100)." (V)";
                break;
                case 'd':
                    $saida = ($medida / 100)." (V)";
                break;
            }
        }else
        //SAÍDA DE TENSÃO
        if(($ponto == 'e') || ($ponto == 'f') || ($ponto == 'g')){
            switch ($ponto) {
                case 'e':
                    $saida = ($medida / 100)." (V)";
                break;
                case 'f':
                    $saida = ($medida / 100)." (V)";
                break;
                case 'g':
                    $saida = ($medida / 100)." (V)";
                break;
            }
        }else
        //ENTRADA DE CORRENTE
        if(($ponto == 'i') || ($ponto == 'j') || ($ponto == 'l')){
            switch ($ponto) {
                case 'i':
                    $saida = ($medida / 100)." (A)";
                break;
                case 'j':
                    $saida = ($medida / 100)." (A)";
                break;
                case 'l':
                    $saida = ($medida / 100)." (A)";
                break;
            }
        }else
        //SAÍDA DE CORRENTE
        if(($ponto == 'm') || ($ponto == 'n') || ($ponto == 'o')){
            switch ($ponto) {
                case 'm':
                    $saida = ($medida / 100)." (A)";
                break;
                case 'n':
                    $saida = ($medida / 100)." (A)";
                break;
                case 'o':
                    $saida = ($medida / 100)." (A)";
                break;
            }
        }else
        //BATERIA
        if(($ponto == 'h') || ($ponto == 'p')){
            switch ($ponto) {
                case 'h':
                    $saida = ($medida / 100)." (V)";
                break;
                case 'p':
                    $saida = ($medida / 100)." (V)";
                break;
            }
        }else
        //TEMPERATURA
        if(($ponto == 'q') || ($ponto == 'r')){
            switch ($ponto) {
                case 'q':
                    // $saida =  number_format($medida, 1, '.', '')." (°C)";
                    $saida =  ($medida / 100)." (°C)";
                break;
                case 'r':
                    //$saida =  number_format($medida, 1, '.', '')." (°C)";
                    $saida =   ($medida / 100)." (°C)";
                break;
            }
        }
        else{
            $saida = " Nenhum dado reconhecido";
        }
        return $saida;
    }
}

?>
