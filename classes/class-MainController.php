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


    /**
     * Funcao de upload de arquivo
     *
     * @param array $file - Recebe o array com os parametros do arquivo
     */
    public function upload_avatar ($file, $destination)
    {
        // Pasta de upload
        $_UP['pasta'] = $destination;

        // Tamanho maximo do arquivo 1mb
        $_UP['tamanho'] = 1024 * 1024 * 1;

        // Extensoes de arquivo aceita
        $_UP['extensoes'] = array('jpg','png','gif');

        // Renomeia o arquivo
        $_UP['renomeia'] = true;

        // Tipos de erro
        $_UP['erro'][0] = "N&atilde;o houve erro";
        $_UP['erro'][1] = "Arquivo muito grande";
        $_UP['erro'][2] = "O arquivo ultrapassa o limite de tamanho espeficado";
        $_UP['erro'][3] = "Upload do arquivo feito parcialmento";
        $_UP['erro'][4] = "N&atilde;o foi feito o upload do arquivo";

        // Verifica se existe algum erro
        if ($_FILES['file_foto']['error'] != 0)
        {
            echo "N&atilde;o foi poss&iacute;vel fazer o upload do arquivo, erro: " . $_UP['erro'][$file['file_foto']['error']];
            exit;
        }

        // Verifica a extensao
        // Converte em minusculo
        $extensao = strtolower($file['file_foto']['name']);
        // Quebra em array
        $extensao = explode(".",$extensao);
        // Pega a ultima posicao
        $extensao = end($extensao);

        // Verifica a
        if (array_search($extensao, $_UP['extensoes']) === false)
        {
            echo "Extens&otilde;es suportadas: JPG, PNG e GIF";
            exit;
        }

        // Verifica o tamanho do arquivo
        if ($_UP['tamanho'] < $file['file_foto']['size'])
        {
            echo "Tamanho maximo do arquivo: 1mb";
            exit;
        }

        // Verifica se deve trocar o nome do arquivo
        if ($_UP['renomeia'] == true)
        {
            // Novo nome
            $nome_final = md5(time()) . "." . $extensao;
        }
        else
        {
            // Mantem o nome original
            $nome_final = $file['file_foto']['name'];
        }

        // Verifica se eh possivel mover o arquivo para a pasta
        if (move_uploaded_file($file['file_foto']['tmp_name'], $_UP['pasta'] ."/". $nome_final))
        {
            // Caso o arquivo seja enviado com sucesso
            if (defined('DEBUG') && DEBUG == true)
                echo "Upload efetuado com sucesso.";

            // Retorna o nome final
            return $nome_final;
        }
        else
        {
            // Caso nao seja possivel mover o arquivo
            if (defined('DEBUG') && DEBUG == true)
                echo "N&atilde;o foi possivel enviar o arquivo, tente mais tarde.";

            // Retorna falso caso de errado
            return false;
        }
    }
}

?>
