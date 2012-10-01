<?php
/**
 * Classe de logging simple
 *
 * @package Core
 */
class Log {
/**
 *
 * @var resource Flux de destination pour l'écriture
 */
	private $file;
	/**
	 *
	 * @var string Chemin du fichier
	 */
	private $path;

	/**
	 *
	 * @var string Nom du log
	 */
	private $name;

	/**
	 * Constructeur
	 * @param string $name Identifiant du log, à partir duquel on construit le nom de fichier
	 */
	public function __construct( $name ) {
		$this->name = $name;
		$this->path = Site::$cacheFolder . "/logs/log-{$this->name}-".time().".txt";
		FileTools::mkDirOfFile($this->path);

	}
	/**
	 * Ecrit un message sur une ligne dans le log
	 * @param string $str Message à écrire
	 */
	public function write( $str ) {
		if( !$this->file ){
			$this->file = fopen( $this->path, "a+");
		}
		fwrite( $this->file , $str."\n\r" );
	}

}
?>