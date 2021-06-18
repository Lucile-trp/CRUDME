<?php 
namespace src\Controller;
use src\Model\Users;
use src\Model\BDD;
use src\Model\Tickets;

class UserController extends AbstractController{
    public function index(){
        return $this->twig->render("User/login.html.twig");
    }

    // Vers le formulaire de login
    public function loginForm(){
        return $this->twig->render("User/login.html.twig");
    }

    //Connexion à un compte
    public function login(){
        $datas = $_POST;
        // Verification des inputs
        if(isset($datas['email']) && isset($datas['password'])){
            session_start();
            $response = Users::connect($datas);
            if ($response == true){
                $tickets = Tickets::getTickets();
                // Redirection 
                return $this->twig->render("Ticket/ticket.html.twig", array(
                    'session' => $_SESSION,
                    'tickets' => $tickets
                ));
            } else {
                // Redirection 
                return $this->twig->render("User/login.html.twig", array(
                    'errmessage' => "Erreur de saisie des identifiants"
                ));
            }
        } else {
            return $this->twig->render("User/login.html.twig", array(
                'errmessage' => "Erreur de saisie des identifiants"
            ));
        }
    }

    // vers le formulaire de création de l'utilisateur
    public function createForm(){
        return $this->twig->render("User/newaccount.html.twig");
    }

    //Création d'un nouveau compte
    public function createUser(){
        $datas = $_POST;
        if (!isset($_POST) || empty($_POST)){
            header('Location: ?controller=User&action=LoginForm');
        } else {
            // verification de la correpondance des mdp
            if ($_POST['password'] === $_POST['password-val'] && $_POST['password'] != ""){
                $response = Users::insertUser($datas);
                if ($response == true){
                    return $this->twig->render("User/newaccount.html.twig", array(
                        'valmessage' => "Utilisateur créé avec succès."
                    ));
                } else {
                    return $this->twig->render("User/newaccount.html.twig", array(
                        'errmessage' => "cet email n'est pas disponible"
                    ));
                }
            } else {
                return $this->twig->render("User/newaccount.html.twig", array(
                    'errmessage' => "Les mots de passe sont différents."
                ));
            }
        }
    }

    // fonction pour accéder à la page du profil connecté. /// NOT USE
    public function profil(){
        session_start();
        if (!isset($_SESSION) || empty($_SESSION)){
            header('Location: ?controller=User&action=LoginForm');
        } else {
            return $this->twig->render("User/profil.html.twig", array(
                'session' => $_SESSION
            ));
        }
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