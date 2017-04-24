<?php

/**
 * Verificador de url
 *
 * @param array   $array - Recebe os parametros por array
 * @param numeric $key   - Recebe a posicao
 */
function chk_array($array, $key)
{
    // Verifica se a posicao existe e nao esta vazia
    if (isset($array[$key]) && ! empty ($array[$key]))
    {
        // Retorna a posicao
        return $array[$key];
    }
    // Se nao existir
    // Retorna vazio
    return null;
}

/**
 * Inicializador de class
 *
 * @param string $class_name - Recebe o nome da classe
 */
function __autoload($class_name)
{
    // Guarda o diretorio do arquivo
    $file = EFIPATH . '/classes/class-' . $class_name . '.php';

    // Verifica se o arquivo existe
    if (! file_exists ($file))
    {
        // Se o arquivo nao existir
        // Apresenta a pagina de erro
        require_once EFIPATH . '/includes/404.php';
        return;
    }
    // Se o arquivo existir
    // Carrega o arquivo
    require_once $file;
}
?>
