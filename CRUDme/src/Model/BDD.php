<?php 
namespace src\Model;
use PDO;

class BDD{
    private static $_instance = null;
    public static function init(){
        try{
            $hostname = "127.0.0.1";
            $username ="root";
            $password = "";
            $dbname = "crudme";

            SELF::$_instance = new PDO('mysql:host=' . $hostname . ';dbname=' . $dbname . ';charset=utf8', $username, $password);
            SELF::$_instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch (\Exception $e){
            SELF::$_instance = 'Erreur :' . $e->getMessage();
        }
    }

    public static function getInstance(){
        if(SELF::$_instance == null){
            SELF::init();
        }
        return SELF::$_instance;
    }
}