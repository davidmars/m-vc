<?php
/**
 *
 *
 */
class M_user extends M_
{
    /**
     * @var Manager the dedicated manager to this object.
     */
    public static $manager;

    /**
     * @var TextField Well the user password
     */
    public $password;
    /**
     * @var TextField User email, that is also used for login.
     */
    public $email;

    /**
     * @var TextField Name of the user
     */
    public $name;
    /**
     * @var TextField first name of the user
     */
    public $firstName;
    /**
     * @var EnumField What are the privilege of this user?
     */
    public $role;
    /**
     * Someone that can only read the project, so a normal human the browse the website in fact.
     */
    const ROLE_READER="Reader";

    /**
     * Someone that can edit everything
     */
    const ROLE_SUPER_ADMIN="Super admin";

     /**
     * Someone that can edit everything except the configuration
     */
    const  ROLE_ADMIN="Admin";

     /**
     * Someone that can write stuff and can update its own stuff.
     */
    const  ROLE_AUTHOR="Author";
    /**
     *
     */
    public function name(){
        return $this->email;
    }
    public function humanName(){
        return $this->role." ".$this->email;
    }

    /**
     * @return bool Will be true if the user can edit stuff
     */
    public function canWrite(){
        switch ($this->role){
            case self::ROLE_READER;
            case "";
                return false;
            default:
                return true;
        }
    }

    /**
     * @var M_user The actual user
     */
    public static $current;
    /**
     * Return the current user if the user is authenticated.
     * If the user is not authenticated it will return a new user with Reader role.
     * @return M_user
     */
    public static function autoLogin(){
        if(self::$current){
            return self::$current;
        }
        if($_SESSION["user"]){
            $u=self::$manager->get($_SESSION["user"]);
            self::$current=$u;
            if($u){
                return $u;
            }
        }
        //default user...a poor reader
        $u=self::getReaderUser();
        self::$current=$u;
        return $u;
    }

    /**
     * @return M_user Return a Reader user.
     */
    private static function getReaderUser(){
        $u=new M_user();
        $u->role=self::ROLE_READER;
        return $u;
    }

    /**
     *
     * @param $email the email
     * @param $password the password
     * @return bool return true in case of success, false elsewhere.
     */
    public static function login($email,$password){
        $u=self::$manager->select()->where("email",$email)->where("password",$password)->one();
        if($u){
            $_SESSION["user"]=$u->id;
            self::$current=$u;
            return true;
        }else{
            $_SESSION["user"]="";
            return false;
        }
    }



}
