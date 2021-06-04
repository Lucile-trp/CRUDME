<?php 
namespace src\Model;
use src\Model\BDD;

class Users {
    protected $email;
    protected $motdepasse;
    protected $id;
    protected $name;
    protected $lastname;
    protected $pseudo;

    // fonctions construct et requêtes BDD après 

    public static function getUsers(){
        $db = BDD::getInstance();
        $db->prepare("SELECT * FROM users;");
        $db->execute();
        $request= $db->fetchAll();
        return $request;
    }

    public static function connect($datas){
        $email = $datas['email'];
        $password = $datas['password'];
        $request = "SELECT use_email, use_pseudo, use_id, use_password FROM users WHERE use_email=:email;";

        // Verification champs non null
        if(!empty($email) && !empty($password)){
            $db = BDD::getInstance();
            $req = $db->prepare($request);
            $req->bindValue(":email", $email);
            $req->execute();
            $response = $req->fetch();

            // Verification correspondance email en bdd
            if ($response == false ){
                return false;

            } else {
                // Verification correspondance des mdp 
                if (password_verify($password, $response['use_password'])){
                    $_SESSION['user'] = [
                        "email" => $response['use_email'],
                        "pseudo" => $response['use_pseudo'], 
                        "id" => $response['use_id']
                        ];
                    return true;
                } else {
                    return false;
                } 
            }
        } else {
            return false;
        }
    }

    public static function insertUser($datas){
        // variable 
        $email = $datas['email'];
        $password = $datas['password'];
        $pseudo = $datas['pseudo'];
        $db = BDD::getInstance();
        $request = "SELECT use_email FROM users WHERE use_email=:email ;";

        // verification email unique 
        $req = $db->prepare($request);
        $req->bindValue(":email", $email);
        $req->execute();
        $response = $req->fetch();

        if ($response == false){
            //password Hash
            $passwordhash = password_hash($password, PASSWORD_DEFAULT);

            //insert BDD
            $request = "INSERT INTO users(use_email, use_password, use_pseudo) VALUES ('$email', '$passwordhash', '$pseudo');";
            $req = $db->prepare($request);
            $req->execute();
            return true;

        } else {
            return false;
        }
    }

}