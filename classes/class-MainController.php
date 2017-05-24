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
                    $saida = number_format(($medida / 100), 2)." (V)";
                break;
                case 'c':
                    $saida = number_format(($medida / 100), 2)." (V)";
                break;
                case 'd':
                    $saida = number_format(($medida / 100), 2)." (V)";
                break;
            }
        }else
        //SAÍDA DE TENSÃO
        if(($ponto == 'e') || ($ponto == 'f') || ($ponto == 'g')){
            switch ($ponto) {
                case 'e':
                    $saida = number_format(($medida / 100), 2)." (V)";
                break;
                case 'f':
                    $saida = number_format(($medida / 100), 2)." (V)";
                break;
                case 'g':
                    $saida = number_format(($medida / 100), 2)." (V)";
                break;
            }
        }else
        //ENTRADA DE CORRENTE
        if(($ponto == 'i') || ($ponto == 'j') || ($ponto == 'l')){
            switch ($ponto) {
                case 'i':
                    $saida = number_format(($medida / 100), 2)." (A)";
                break;
                case 'j':
                    $saida = number_format(($medida / 100), 2)." (A)";
                break;
                case 'l':
                    $saida = number_format(($medida / 100), 2)." (A)";
                break;
            }
        }else
        //SAÍDA DE CORRENTE
        if(($ponto == 'm') || ($ponto == 'n') || ($ponto == 'o')){
            switch ($ponto) {
                case 'm':
                    $saida = number_format(($medida / 100), 2)." (A)";
                break;
                case 'n':
                    $saida = number_format(($medida / 100), 2)." (A)";
                break;
                case 'o':
                    $saida = number_format(($medida / 100), 2)." (A)";
                break;
            }
        }else
        //BATERIA
        if(($ponto == 'h') || ($ponto == 'p')){
            switch ($ponto) {
                case 'h':
                    $saida = number_format(($medida / 100), 2)." (V)";
                break;
                case 'p':
                    $saida = number_format(($medida / 100), 2)." (V)";
                break;
            }
        }else
        //TEMPERATURA
        if(($ponto == 'q') || ($ponto == 'r')){
            switch ($ponto) {
                case 'q':
                    // $saida =  number_format($medida, 1, '.', '')." (°C)";
                    $saida =  number_format(($medida / 100), 2)." (°C)";
                break;
                case 'r':
                    //$saida =  number_format($medida, 1, '.', '')." (°C)";
                    $saida =   number_format(($medida / 100), 2)." (°C)";
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
    public function upload_avatar($file, $destination, $tipoAvatar)
    {
        // Pasta de upload
        $_UP['pasta'] = $destination;

        // Tamanho maximo do arquivo 2mb
        $_UP['tamanho'] = 1024 * 1024 * 2;

        // Extensoes de arquivo aceita
        $_UP['extensoes'] = array('jpg','png','gif');

        // Renomeia o arquivo
        $_UP['renomeia'] = true;

        // Redimenciona o tamanho do arquivo
        if($destination == 'user'){
            $_UP['best_size'] = 64;
        }else{
            $_UP['best_size'] = 128;
        }

        // Tipos de erro
        $_UP['erro'][0] = "N&atilde;o houve erro";
        $_UP['erro'][1] = "Arquivo muito grande";
        $_UP['erro'][2] = "O arquivo ultrapassa o limite de tamanho espeficado";
        $_UP['erro'][3] = "Upload do arquivo feito parcialmento";
        $_UP['erro'][4] = "N&atilde;o foi feito o upload do arquivo";

        // Verifica se existe algum erro
        if ($_FILES['file_foto']['error'] != 0)
        {
            // echo "N&atilde;o foi poss&iacute;vel fazer o upload do arquivo, erro: " . $_UP['erro'][$file['file_foto']['error']];
            // exit;

            $erro = "N&atilde;o foi poss&iacute;vel fazer o upload do arquivo, erro: " . $_UP['erro'][$file['file_foto']['error']];

            return array('status' => 'erro', 'mensagem' => $erro);
        }

        // Verifica a extensao
        // Converte em minusculo
        $extensao = strtolower($file['file_foto']['name']);
        // Quebra em array
        $extensao = explode(".",$extensao);
        // Pega a ultima posicao
        $extensao = end($extensao);

        // Verifica a extensão do arquivo
        if (array_search($extensao, $_UP['extensoes']) === false)
        {
            // echo "Extens&otilde;es suportadas: JPG, PNG e GIF";
            // exit;
            $erro = "Extensões de imagens suportadas: JPG, PNG e GIF";

            return array('status' => 'erro', 'mensagem' => $erro);
        }

        // Verifica o tamanho do arquivo
        if ($_UP['tamanho'] < $file['file_foto']['size'])
        {
            // echo "Tamanho maximo do arquivo: 1mb";
            // exit;
            $erro = "Tamanho maximo do arquivo: 2mb";

            return array('status' => 'erro', 'mensagem' => $erro);
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

        //$arquivoRedimencionado = $this->resize_image($file['file_foto']['tmp_name'], $_UP['best_size'], $_UP['best_size'],false);

        $arquivoRedimencionado = $this->resizeImage($file['file_foto'], $_UP['pasta'], $_UP['best_size']);

        //var_dump($arquivoRedimencionado);

        //return $arquivoRedimencionado;
        return array('status' => 'ok', 'mensagem' => $arquivoRedimencionado);

        // $file['file_foto']['tmp_name']
        // Verifica se eh possivel mover o arquivo para a pasta
        // if (move_uploaded_file($arquivoRedimencionado, $_UP['pasta'] ."/". $nome_final))
        // {
        //     // Caso o arquivo seja enviado com sucesso
        //     if (defined('DEBUG') && DEBUG == true)
        //         echo "Upload efetuado com sucesso.";
        //
        //         //Verifica o tamanho do arquivo em px
        //         $image_info = getimagesize($_UP['pasta'] ."/". $nome_final);
        //         $image_width  = $image_info[0];
        //         $image_height = $image_info[1];
        //
        //         if(($_UP['best_size'] < $image_width) || ($_UP['best_size'] < $image_height)){
        //
        //             //Arquivo necessita ser redimencionado
        //
        //         }
        //
        //
        //
        //     // Retorna o nome final
        //     return $nome_final;
        // }
        // else
        // {
        //     // Caso nao seja possivel mover o arquivo
        //     if (defined('DEBUG') && DEBUG == true)
        //         echo "N&atilde;o foi possivel enviar o arquivo, tente mais tarde.";
        //
        //     // Retorna falso caso de errado
        //     return false;
        // }
    }

    function resizeImage($file, $savePath, $bestSize){

             define ('MAX_WIDTH', 2500);//max image width
             define ('MAX_HEIGHT', 2500);//max image height
            //  define ('MAX_FILE_SIZE', 10485760);
            define ('MAX_FILE_SIZE', 2097152); // MAX 2MB

             //iamge save path
             $path = $savePath.'/';

            //size of the resize image
             $new_width = $bestSize;
             $new_height = $bestSize;
            //$new_height = 64;

            //name of the new image
            //$nameOfFile = 'resize_'.$new_width.'x'.$new_height.'_'.basename($file['name']);
            $nameOfFile = md5($file['tmp_name']).basename($file['name']);

            $image_type = $file['type'];
            $image_size = $file['size'];
            $image_error = $file['error'];
            $image_file = $file['tmp_name'];
            $image_name = $file['name'];

            $image_info = getimagesize($image_file);

            //check image type
            if ($image_info['mime'] == 'image/jpeg' or $image_info['mime'] == 'image/jpg'){
            }
            else if ($image_info['mime'] == 'image/png'){
            }
            else if ($image_info['mime'] == 'image/gif'){
            }
            else{
                //set error invalid file type
            }

            if ($image_error){
                //set error image upload error
            }

            if ( $image_size > MAX_FILE_SIZE ){
                //set error image size invalid
            }

            switch ($image_info['mime']) {
                case 'image/jpg': //This isn't a valid mime type so we should probably remove it
                case 'image/jpeg':
                $image = imagecreatefromjpeg ($image_file);
                break;
                case 'image/png':
                $image = imagecreatefrompng ($image_file);
                break;
                case 'image/gif':
                $image = imagecreatefromgif ($image_file);
                break;
            }

            if ($new_width == 0 && $new_height == 0) {
                $new_width = 100;
                $new_height = 100;
            }

            // ensure size limits can not be abused
            $new_width = min ($new_width, MAX_WIDTH);
            $new_height = min ($new_height, MAX_HEIGHT);

            //get original image h/w
            $width = imagesx ($image);
            $height = imagesy ($image);

            //$align = 'b';
            // $zoom_crop = 1;
            // $origin_x = 0;
            // $origin_y = 0;
            //TODO setting Memory

            // generate new w/h if not provided
            // if ($new_width && !$new_height) {
            //     $new_height = floor ($height * ($new_width / $width));
            // } else if ($new_height && !$new_width) {
            //     $new_width = floor ($width * ($new_height / $height));
            // }

            // scale down and add borders
        // if ($zoom_crop == 3) {
        //
        //      $final_height = $height * ($new_width / $width);
        //
        //      if ($final_height > $new_height) {
        //         $new_width = $width * ($new_height / $height);
        //      } else {
        //         $new_height = $final_height;
        //      }
        //
        // }

            // create a new true color image
            $canvas = imagecreatetruecolor ($new_width, $new_height);
            imagealphablending ($canvas, true);


            // if (strlen ($canvas_color) < 6) {
            //     $canvas_color = 'ffffff';
            // }
            $canvas_color = 'ffffff';

            $canvas_color_R = hexdec (substr ($canvas_color, 0, 2));
            $canvas_color_G = hexdec (substr ($canvas_color, 2, 2));
            $canvas_color_B = hexdec (substr ($canvas_color, 2, 2));

            // Create a new transparent color for image
            $color = imagecolorallocatealpha ($canvas, $canvas_color_R, $canvas_color_G, $canvas_color_B, 127);

            // Completely fill the background of the new image with allocated color.
            //Criando a variavel "$white" para preencher o fundo de imagens trasnparentes
            $white = imagecolorallocate($canvas, 255, 255, 255);
            imagefill ($canvas, 0, 0, $white);

            // scale down and add borders
        // if ($zoom_crop == 2) {
        //
        //         $final_height = $height * ($new_width / $width);
        //
        //     if ($final_height > $new_height) {
        //         $origin_x = $new_width / 2;
        //         $new_width = $width * ($new_height / $height);
        //         $origin_x = round ($origin_x - ($new_width / 2));
        //         } else {
        //
        //         $origin_y = $new_height / 2;
        //         $new_height = $final_height;
        //         $origin_y = round ($origin_y - ($new_height / 2));
        //
        //     }
        //
        // }

            // Restore transparency blending
            // imagesavealpha ($canvas, true);
            //
            // if ($zoom_crop > 0) {
            //
            //     $src_x = $src_y = 0;
            //     $src_w = $width;
            //     $src_h = $height;
            //
            //     $cmp_x = $width / $new_width;
            //     $cmp_y = $height / $new_height;
            //
            //     // calculate x or y coordinate and width or height of source
            //     if ($cmp_x > $cmp_y) {
            //         $src_w = round ($width / $cmp_x * $cmp_y);
            //         $src_x = round (($width - ($width / $cmp_x * $cmp_y)) / 2);
            //     } else if ($cmp_y > $cmp_x) {
            //         $src_h = round ($height / $cmp_y * $cmp_x);
            //         $src_y = round (($height - ($height / $cmp_y * $cmp_x)) / 2);
            //     }
            //
            //     // positional cropping!
            //     if (isset($align)) {
            //         if (strpos ($align, 't') !== false) {
            //             $src_y = 0;
            //         }
            //                     if (strpos ($align, 'b') !== false) {
            //                             $src_y = $height - $src_h;
            //                     }
            //                     if (strpos ($align, 'l') !== false) {
            //             $src_x = 0;
            //         }
            //         if (strpos ($align, 'r') !== false) {
            //             $src_x = $width - $src_w;
            //         }
            //     }
            //
            //     // positional cropping!
            //     imagecopyresampled ($canvas, $image, $origin_x, $origin_y, $src_x, $src_y, $new_width, $new_height, $src_w, $src_h);
            //
            //  } else {
            //     imagecopyresampled ($canvas, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
            // }
            imagecopyresampled ($canvas, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

            //Straight from Wordpress core code. Reduces filesize by up to 70% for PNG's
            if ( (IMAGETYPE_PNG == $image_info[2] || IMAGETYPE_GIF == $image_info[2]) && function_exists('imageistruecolor') && !imageistruecolor( $image ) && imagecolortransparent( $image ) > 0 ){
                imagetruecolortopalette( $canvas, false, imagecolorstotal( $image ) );
            }
            $quality = 100;
            //$nameOfFile = 'resize_'.$new_width.'x'.$new_height.'_'.basename($file['name']);

            if (preg_match('/^image\/(?:jpg|jpeg)$/i', $image_info['mime'])){
                imagejpeg($canvas, $path.$nameOfFile, $quality);

            } else if (preg_match('/^image\/png$/i', $image_info['mime'])){
                imagepng($canvas, $path.$nameOfFile, floor($quality * 0.09));

            } else if (preg_match('/^image\/gif$/i', $image_info['mime'])){
                imagegif($canvas, $path.$nameOfFile);

            }

        return $nameOfFile;
    }

    /*
    * Função para remover avagar antigo
    */
    public function removeOldAvatar($file, $folderOrigem){

        $caminhoArquivo = $folderOrigem.'/'.$file;

        if (file_exists($caminhoArquivo)){
            //echo "O arquivo $file existe";

            unlink($caminhoArquivo);

        } else {
            //echo "O arquivo $file não existe";
        }

        return;
    }


    /**
     * Funcao de upload de arquivo para planta baixa
     *
     * @param array $file - Recebe o array com os parametros do arquivo
     */
    public function upload_plantaBaixa($file, $destination){

        // Pasta de upload
        $_UP['pasta'] = $destination;

        // Tamanho maximo do arquivo 3mb
        $_UP['tamanho'] = 1024 * 1024 * 3;

        // Extensoes de arquivo aceita
        $_UP['extensoes'] = array('jpg','png','gif', 'jpeg');

        // Renomeia o arquivo
        $_UP['renomeia'] = true;

        // Redimenciona o tamanho do arquivo
        $_UP['best_size'] = 512;

        // Tipos de erro
        $_UP['erro'][0] = "N&atilde;o houve erro";
        $_UP['erro'][1] = "Arquivo muito grande";
        $_UP['erro'][2] = "O arquivo ultrapassa o limite de tamanho espeficado";
        $_UP['erro'][3] = "Upload do arquivo feito parcialmento";
        $_UP['erro'][4] = "N&atilde;o foi feito o upload do arquivo";

        // Verifica se existe algum erro
        if ($_FILES['file_planta']['error'] != 0)
        {
            $erro = "N&atilde;o foi poss&iacute;vel fazer o upload do arquivo, erro: " . $_UP['erro'][$file['file_planta']['error']];

            return array('status' => 'erro', 'mensagem' => $erro);
        }

        // Verifica a extensao
        // Converte em minusculo
        $extensao = strtolower($file['file_planta']['name']);
        // Quebra em array
        $extensao = explode(".",$extensao);
        // Pega a ultima posicao
        $extensao = end($extensao);

        // Verifica a extensão do arquivo
        if (array_search($extensao, $_UP['extensoes']) === false)
        {
            // echo "Extens&otilde;es suportadas: JPG, PNG e GIF";
            // exit;
            $erro = "Extensões de imagens suportadas: JPG, PNG e GIF";

            return array('status' => 'erro', 'mensagem' => $erro);
        }

        // Verifica o tamanho do arquivo
        if ($_UP['tamanho'] < $file['file_planta']['size'])
        {
            // echo "Tamanho maximo do arquivo: 1mb";
            // exit;
            $erro = "Tamanho maximo do arquivo: 2mb";

            return array('status' => 'erro', 'mensagem' => $erro);
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
            $nome_final = $file['file_planta']['name'];
        }

        $arquivoRedimencionado = $this->resizeImage($file['file_planta'], $_UP['pasta'], $_UP['best_size']);

        return array('status' => 'ok', 'mensagem' => $arquivoRedimencionado);

    }


}

?>
