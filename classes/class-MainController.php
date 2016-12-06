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
        $this->db = new EficazDB();
        
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
}

?>