<?
/**
 * Contient différentes fonctions images très utilisées
 *
 * @package Core
 */
class ImageTools{
    
    
    /**
     *
     * @var bool if set to true ImageTools will do the job, elsewhere it will only return urls 
     */
    public static $doTheJob=false;
    /**
     * return the cached url related to an ImageTools function and parameters
     * @param string $fnName the ImageTools related method
     * @param array $params the params to output
     * @return string the cached file url
     */
    public static function getUrl($fnName,$params){
        
        for($i=0;$i<count($params);$i++){
            //$params[$i]= str_replace(".", "--dot--", $params[$i]);
            $params[$i]= str_replace("/", "-_", $params[$i]); 
        }
        //file name at the end
        $fileName=array_shift($params);
        $params[]=$fileName;
        $url=Site::$mediaFolder."/cache/img/".$fnName."/".implode("/",$params);
        
        Human::log("----->url=".$url);
        FileTools::mkDirOfFile($url);
        return $url;
    }
    /**
     *
     * @param type $fnName the ImageTools related method
     * @param type $params the params used by the method
     * @return string the url of the image
     */
    public static function processUrl($fnName,$params,$extension){
        
        for($i=0;$i<count($params);$i++){
            //$params[$i]= str_replace("--dot--",".", $params[$i]);
            $params[$i]= str_replace("-_", "/", $params[$i]);
            
        }
        //file at the begining
        $fileName=array_pop($params);
        $fileName=$fileName.".$extension";
        
        array_unshift($params, $fileName);
        //$url=Site::$mediaFolder."/cache/img/".$fnName."/".implode("/",$params);
        
        return call_user_func_array(array(self,$fnName), $params);
        
    }
    public static function output($imgUrl){
        $img = new Imagick( $imgUrl );
        header('Content-Type: '.FileTools::mime($imgUrl));
        echo $img;
        die();
    }


    /**
	 * retourne une image GD redimensionnée (et souvent cropée au centre)
	 * @param Imagick $GDImage La resource image qui sera traitée
	 * @param int $thumbnail_width	 largeur souhaitée
	 * @param int $thumbnail_height	hauteur souhaitées
	 * @return Imagick une image GD redimensionnée
	 */
	static function GDresize($GDImage,$thumbnail_width,$thumbnail_height){

		$width_orig=imagesx($GDImage);
		$height_orig=imagesy($GDImage);
		$ratio_orig = $width_orig/$height_orig;

		if ($thumbnail_width/$thumbnail_height > $ratio_orig) {
			$new_height = $thumbnail_width/$ratio_orig;
			$new_width = $thumbnail_width;
		} else {
			$new_width = $thumbnail_height*$ratio_orig;
			$new_height = $thumbnail_height;
		}

		$x_mid = $new_width/2;  //horizontal middle
		$y_mid = $new_height/2; //vertical middle

		$process = imagecreatetruecolor(round($new_width), round($new_height));
		$background_color = imagecolorallocate($process, 0, 0, 0);


		imagecopyresampled($process, $GDImage, 0, 0, 0, 0, $new_width, $new_height, $width_orig, $height_orig);
		$thumb = imagecreatetruecolor($thumbnail_width, $thumbnail_height);
		imagecopyresampled($thumb, $process, 0, 0, ($x_mid-($thumbnail_width/2)), ($y_mid-($thumbnail_height/2)), $thumbnail_width, $thumbnail_height, $thumbnail_width, $thumbnail_height);

		imagedestroy($process);
		imagedestroy($GDImage);
		return $thumb;

	}
	/**
	 * Croppe une image, crée l'image en cache et retourne l'url de cette image
	 * @param String $imgUrl url de l'image à cropper
	 * @param <type> $left nombre de pixel à supprimer à gauche
	 * @param <type> $right nombre de pixel à supprimer à gauche
	 * @param <type> $top nombre de pixel à supprimer à gauche
	 * @param <type> $bottom nombre de pixel à supprimer à gauche
	 * @param <type> $mime jpg ou png
	 * @return string url de l'image croppée selon les parametres
	 */
	static function cropped($imgUrl,$left,$right,$top,$bottom,$mime="jpeg"){
		$newImgUrl="media/cache/cropped/".$left."-".$right."-".$top."-".$bottom."/".$mime."/".md5($imgUrl).".".$mime;
		if(!is_file($newImgUrl)){
			ImageTools::mkDirOfFile($newImgUrl);
			$resized=ImageTools::croppedImagick($imgUrl,$left,$right,$top,$bottom,$mime);
			if($resized){
				$resized->writeImage($newImgUrl);
			}
		}
		return $newImgUrl;
	}
	/**
	 * Croppe une image, crée l'image Imagick et la renvoie
	 * @param String $imgUrl url de l'image à cropper
	 * @param <type> $left nombre de pixel à supprimer à gauche
	 * @param <type> $right nombre de pixel à supprimer à gauche
	 * @param <type> $top nombre de pixel à supprimer à gauche
	 * @param <type> $bottom nombre de pixel à supprimer à gauche
	 * @param <type> $mime jpg ou png
	 * @return Imagick ressource obtenue après l'opération
	 */
	static function croppedImagick($imgUrl,$left,$right,$top,$bottom,$mime="jpeg"){

		if( $mime == "jpg" || $mime=="jpeg") {
			$mime = "jpeg";
		}else{
			$mime = "png";
		}

		if(!is_file($imgUrl) || ! preg_match("/image/i", mime_content_type($imgUrl))   ){
			//si erreur image noire de 10px sur 10px
			$resized = new Imagick();
			$width=10;
			$height=10;
			$test=$resized->newImage( $width , $height , "none");
			if(!$test){
				return false;
			}
			$resized->setImageFormat($mime);
			$resized->newImage($width, $height, new ImagickPixel('black'));
			$resized->colorizeImage('#'.$background,1);
			return $resized;
		}

		$img = new Imagick( $imgUrl );
		$imgHeight = $img->getImageHeight();
		$imgWidth = $img->getImageWidth();
		$resized = new Imagick();
		$resized->newImage( $imgWidth-$left-$right , $imgHeight-$top-$bottom , "none");
		$resized->setImageFormat($mime);
		$resized->compositeImage( $img ,imagick::COMPOSITE_OVER , -$left  , -$bottom );
		return $resized;
	}

        /**
         * Retourne l'url d'une image d'une taille donnée et de la couleur donnée
         * @param Int $width largeur de l'image retournée
	 * @param Int $height hauteur de l'image retournée
	 * @param String $background peut être egal a une couleur du type ff0000 ou transparent
         * @return String l'url de l'image redimentionnée.
         */
        static function sizedEmpty($width,$height,$background,$mime="jpg")
        {
            $newImgUrl="media/cache/empty/".$width."-".$height."/$background/empty.".$mime;
            if(!is_file($newImgUrl)){
                
                ImageTools::mkDirOfFile($newImgUrl);
                $resized=ImageTools::sizedImagick(null,$width,$height,null,$mime,$background);
                if($resized){
                    try{
                        $resized->writeImage($newImgUrl);
                    }catch(Exception $e){

                    }
                }
            }

            return $newImgUrl;
        }

	/**
	 * Retourne l'url d'une image redimensionnée et crée l'image physiquement au passage afin qu'au prochain appel, l'image ne soit plus recrée et soit accédée directement.
	 * @param String $imgUrl Url de l'image à redimentionner
	 * @param Int $width largeur de l'image retournée
	 * @param Int $height hauteur de l'image retournée
	 * @param String $scaleMode peut être égal à noBorder ou showAll
	 * @param String $mime peut être égal à jpg ou png
	 * @param String $background peut être egal a une couleur du type ff0000 ou transparent
	 * @param Int $padding va rajouter une marge tournante de la valeur de padding si $scaleMode=="showAll"
	 * @return String l'url de l'image redimentionnée.
	 */
	static function sized($imgUrl,$width,$height,$scaleMode,$mime,$background,$padding=0){
                $params=func_get_args();
                Human::log($params);
		$newImgUrl=self::getUrl("sized", $params);
                if(!self::$doTheJob){
                    return $newImgUrl;
                }

		if(!is_file($newImgUrl)){
			ImageTools::mkDirOfFile($newImgUrl);
			$resized=ImageTools::sizedImagick($imgUrl,$width,$height,$scaleMode,$mime,$background,$padding);
			if(count($shadow)){
				$s=ImageTools::sizedImagick($imgUrl,$width,$height,$scaleMode,$mime,$background,$padding);
				$resized=ImageTools::setShadow($resized,$s,$shadow);
			}
			if($resized){
				try{
					$resized->writeImage($newImgUrl);
				}catch(Exception $e){
                                        Human::log($e);
				}
			}
		}
		return $newImgUrl;
	}
	/**
	 * Retourne une image Imagick redimensionnée.
	 * @param String $imgUrl Url de l'image à redimentionner
	 * @param Int $width largeur de l'image retournée
	 * @param Int $height hauteur de l'image retournée
	 * @param String $scaleMode peut être égal à noBorder ou showAll
	 * @param String $mime peut être égal à jpg ou png
	 * @param String $background peut être egal a une couleur du type ff0000 ou transparent
	 * @param Int $padding va rajouter une marge tournante de la valeur de padding si $scaleMode=="showAll"
	 * @return Imagick  une image Imagick redimensionnée.
	 *
	 */
	static function sizedImagick($imgUrl,$width,$height,$scaleMode,$mime,$background,$padding=4){
		$opacity=1.0;
		if($background=="transparent") {
			$opacity=0.0;
			$background="000000";
		}

		// background can take gradient in the form : "startingcolor-endingcolor"
		// it would create a diagonal gradient from top left to bottom right
		$gradient = explode( "-" , $background );
		if( count( $gradient ) == 2 ){
			//$background = $gradient[0];
		}else{
			$gradient = false;
		}

		if( $mime == "jpg" || $mime=="jpeg") {
			$mime = "jpeg";
		}else{
			$mime = "png";
		}

		if(!is_file($imgUrl) || ! preg_match("/image/i", mime_content_type($imgUrl))   ){
			$resized = new Imagick();



			if(!is_numeric($width)){
				$width=10;
				$height=10;
			}
			$test=$resized->newImage( $width , $height , "none");
			if(!$test){
				return false;
			}
			$resized->setImageFormat($mime);
			$resized->newImage($width, $height, new ImagickPixel('black'));
			$resized->colorizeImage('#'.$background,$opacity);
			return $resized;
		}
		 
		$img = new Imagick( $imgUrl );




		$imgHeight = $img->getImageHeight();
		$imgWidth = $img->getImageWidth();
	  
                if($height=="auto"){
                    //pas testé encore mais doit marcher pour déduire une hauteur ou une largeur automatiquement
                    $ratio=$width/$imgWidth;
                    $height=$imgHeight*$ratio;
                    $scaleMode="noBorder";
                }else if($width=="auto"){
                    $ratio=$height/$imgHeight;
                    $width=$imgWidth*$ratio;
                    $scaleMode="noBorder";
                }
	  
		//cas particulier de l'image non déformée
		if($width=="original" || $height=="original"){
		 $width=$imgWidth;
		 $height=$imgHeight;
		 $scaleMode="showAll";
		 $padding=0;
		}

		if($scaleMode=="showAll") {
			$scale = 1;
			if( $imgHeight * $scale > $height-$padding*2 ) {
				$scale *= ($height-$padding*2) / ( $imgHeight * $scale );
			}
			if( $imgWidth * $scale > $width-$padding*2 ) {
				$scale *= ($width-$padding*2) / ( $imgWidth * $scale );
			}
			$nw= $scale * $imgWidth;
			$nh= $scale * $imgHeight;
		}elseif($scaleMode=="noBorder") {
			$nw = $width;
			$scale = $width/$imgWidth;
			$nh=$scale*$imgHeight;
			if($nh<$height) {
				$nh=$height;
				$scale = $height/$imgHeight;
				$nw=$scale*$imgWidth;
			}

		}


		$resized = new Imagick();
		if($background=="empty"){
            $resized->newImage(floor($nw) , floor($nh) , "none");
            $width=floor($nw);
            $height=floor($nh);
            $background="ff0000";
        }else{
            $resized->newImage( $width , $height , "none");
        }

		$resized->setImageFormat($mime);

		$img->resizeImage( round($nw) , round($nh) , Imagick::FILTER_LANCZOS , 1, false );
		if($opacity==0.0) {
			$resized->newImage($width, $height, new ImagickPixel('transparent'));
		}else {
			$resized->newImage($width, $height, new ImagickPixel('#'.$background));
		}

	    //$resized->newImage($w,$h);
	    $resized->setImageFormat($mime);
	    $resized->setImageCompose($img->getImageCompose());
	    
	    if( $gradient ){
	    	// making the background gradient
	    	// = a square we'll turn of -45°
	    	// so it has to be the size of a diagonal

	    	$bg = new Imagick();
	    	$bgSize = sqrt($width*$width + $height*$height);
	    	$bg->newPseudoImage( $bgSize , $bgSize, "gradient:#".$gradient[0]."-#".$gradient[1] );
	    	
			// TODO: calculate the right angle depending on the ratio
	    	$bg->rotateImage(new ImagickPixel('none'),-45);
	    	$bg->cropImage( $width , $height, ($bg->getImageWidth()-$width)/2 , ($bg->getImageHeight()-$height)/2  );
	    	$resized->compositeImage( $bg , $bg->getImageCompose() , 0 , 0 );
	    }

	    //$resized->compositeImage( $img , $img->getImageCompose() , round($w/2-$imgWidth/2)  , round($h*0.5-$imgHeight*0.5) );

		//$resized->colorizeImage('#'.$background,$opacity);
		//$resized->setImageFormat($mime);
		$resized->compositeImage( $img ,$img->getImageCompose() , round(  $width/2 - $nw/2 )  , round( $height/2 - $nh/ 2) );
		return $resized;
	}

	/**
	 * permet de rajouter une ombre portée à la ressource imagick $im
	 * @param Imagick $im image qui sera utilisée
	 * @param Array $p tableau des propriété de l'ombre des 0 à 4 les valeurs correspondent à : float $opacity , float $sigma , int $x , int $y
	 * @return Imagick
	 */
	static function setShadow($im,$p){

		$shadow=ImageTools::cloneIm($im);

		/* Set image background color to black
		 (this is the color of the shadow) */
		$shadow->setImageBackgroundColor( new ImagickPixel( 'black' ) );
		$shadow->setImageFormat("png");
		/* Create the shadow */
		$shadow->shadowImage( $p[0], $p[1], $p[2], $p[3] );
		$shadow->compositeImage( $im, Imagick::COMPOSITE_OVER, 0, 0 );
		return $shadow;
	}

	/**
	 * Crée une image à l'emplacement de $imageUrl à partir de la ressource $imagick
	 * @param String $imageUrl Url où sera placé le fichier
	 * @param <type> $imagick la ressource imagick de l'image à écrire sur le disque
	 * @param Boolean $forceNew si ce parametre est true on force la réécriture de l'image
	 */
	static function createImage($imageUrl,$imagick,$forceNew = false){
		if( (!is_file($imageUrl) || $forceNew) && $imagick){
			ImageTools::mkDirOfFile($imageUrl);
			$imagick->writeImage($imageUrl);
		}
	}

	/**
	 * Crée les répertoires et sous répertoire contenant $fileUrl
	 * @param String $fileUrl url complète du fichier dont il faut éventuellement créer les répertoires conteneurs
	 */
	static function mkDirOfFile($fileUrl){
		$splitted=explode("/",$fileUrl);
		array_pop($splitted);
		$dir=implode("/" , $splitted);
		
		if( !is_dir($dir) ){
			mkdir( $dir , 0777 , true );
		}
		/*while(count($splitted)>1){
			$newFolder=array_shift($splitted);
			$dir=$dir.$newFolder;
			if(!is_dir($dir)){
				mkdir($dir);
				chmod($dir, 0777);
			}
			$dir.="/";
		}*/
	}
	/**
	 * Clone poansant des problèmes (???) cette fonction copie la ressource Imagick et en renvoie une copie
	 * @param Imagick $im l'image à cloner
	 * @return Imagick
	 */
	static function cloneIm($im){
		$c = new Imagick();
		$c->newImage($im->getImageWidth(), $im->getImageHeight(), "transparent");
		$c->compositeImage( $im ,imagick::COMPOSITE_OVER , 0  , 0 );
		return $c;
	}
	 /**
         * retourne les dimensions de l'image passée en paramètre
         * @param type $imgUrl url de l'image
         * @return Array un tableau avec les entrées width et height 
         */
        static function getSize($imgUrl){
            if(!is_file($imgUrl)){
              return array("width"=>0,"height"=>0);  
            }
            $img = new Imagick( $imgUrl );
            $imgHeight = $img->getImageHeight();
            $imgWidth = $img->getImageWidth();
            return array("width"=>$imgWidth,"height"=>$imgHeight);
        }


        static function makeEmpty($im, $background, $mime = "jpg")
        {
            $width = $im->getImageWidth();
            $height = $im->getImageHeight();
            
            return ImageTools::sizedImagick(null,$width,$height,null,$mime,$background);
        }
}


?>