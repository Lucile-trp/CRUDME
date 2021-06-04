<?php 
namespace src\Controller;
use src\Model\Users;
use src\Model\BDD;
use src\Model\Tickets;

class UserController extends AbstractController{
    public function index(){
        return $this->twig->render("User/login.html.twig");
    }

    public function loginForm(){
        //session_start();
        return $this->twig->render("User/login.html.twig");

    }

    //Connexion à un compte
    public function login(){
        $datas = $_POST;
        session_start();
        $response = Users::connect($datas);
        if ($response == true){
            $tickets = Tickets::getTickets();
        return $this->twig->render("Ticket/ticket.html.twig", array(
            'session' => $_SESSION,
            'tickets' => $tickets
        ));

        } else {
            return $this->twig->render("User/login.html.twig", array(
                'errmessage' => "Erreur de saisie des identifiants"
            ));
        }
    }

    
    public function createForm(){
        return $this->twig->render("User/newaccount.html.twig");

    }

    //Création d'un nouveau compte
    public function createUser(){
        $datas = $_POST;

        // verification de la correpondance des mdp
        if ($_POST['password'] === $_POST['password-val'] && $_POST['password'] != ""){
            Users::insertUser($datas);
            return $this->twig->render("User/newaccount.html.twig", array(
                'valmessage' => "Utilisateur créé avec succès."
            ));
        } else {
            return $this->twig->render("User/newaccount.html.twig", array(
                'errmessage' => "Les mots de passe sont différents."
            ));
        }
    }

    public function profil(){
        session_start();
        return $this->twig->render("User/profil.html.twig", array(
            'session' => $_SESSION
        ));

    }

    //Deconnexion
    public function disconnect(){
        session_start();
        session_destroy();
        unset($_SESSION);
        return $this->twig->render("User/login.html.twig");
    }
}

?>