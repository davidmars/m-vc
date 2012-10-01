<?
/**
 * Champ mot de passe
 *
 * @package Core.model
 * @subpackage Field
 */
class PasswordField extends Field {

	/**
	 *
	 * @var string Clé de cryptage
	 */
	private $salt = "Sh1C_sH@c";
	/**
	 *
	 * @var string Valeur hashée
	 */
	private $hashedValue;

	/**
	 *
	 * @var string Algorithme de cryptage
	 */

	public $algo = "whirlpool";

	public function unserialize( $value ){
		$this->value = $value;
	}
	
	public function set( $value ){
		parent::set( $this->hash( $value ) );
	}
	
	/**
	 * Hashe une chaine de caractère en SHA-1 avec la clé $this->salt
	 *
	 * @param <type> $str
	 * @return <type>
	 */
	public function hash( $str ){

		return hash( $this->algo, $this->salt . $str . $this->salt );

	}

	public function asDbColumn(){
		$c = parent::asDbColumn();
		$c->type = "varchar(128)";

		return $c;
	}

}

?>