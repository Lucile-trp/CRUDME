<?php
namespace src\Controller;
use src\Model\Tickets;


class TicketController extends AbstractController{

    public function index(){
        session_start();
        var_dump($_SESSION);
        if(!isset($_SESSION['user'])){
            header('Location: ?controller=User&action=LoginForm');
        } else {
            header('Location: ?controller=Ticket&action=getTickets');
        }
    }

    // Récupère tout les tickets de l'utilisateur connecté
    public function getTickets(){
        session_start();
        //Vérification de la session
        if (isset($_SESSION) && empty($_SESSION)){
            header('Location: ?controller=User&action=LoginForm');
        } else {
            $tickets = Tickets::getTickets();
            return $this->twig->render("Ticket/ticket.html.twig", array(
                'session' => $_SESSION,
                'tickets' => $tickets
            ));
        }
    }

    // Renvoi au formulaire de création des ticket si l'utilisateur est authentifié
    public function ticketForm(){
        session_start();
        if (isset($_SESSION) && empty($_SESSION)){
            header('Location: ?controller=User&action=LoginForm');
        } else {
            return $this->twig->render("Ticket/newticket.html.twig", array(
                'session' => $_SESSION
            ));
        }
    }

    // Fonction de création d'un ticket
    public function newTicket(){
        session_start();
        if (isset($_SESSION) && empty($_SESSION)){
            header('Location: ?controller=User&action=LoginForm');
        } else {
            $datas = $_POST;
            $userId = $_SESSION['user']['id'];
            if(isset($datas['ticket-title']) && $datas['ticket-title'] != "" && isset($datas['ticket-content']) && $datas['ticket-content'] != "" ){

                $result = Tickets::createTicket($datas, $userId);

                if($result == true){
                    header('Location: ?controller=Ticket&action=getTickets');
                }

            } else {
                return $this->twig->render("Ticket/newticket.html.twig", array(
                    'session' => $_SESSION,
                    'errmessage' => "Veuillez entrer des informations valides"
                ));
            }
        }
    }

    // renvoie au formulaire de modification du ticket
    public function updateTicketForm($tic_id){
        session_start();
        if (isset($_SESSION) && empty($_SESSION)){
            header('Location: ?controller=User&action=LoginForm');
        } else {
            $ticket = Tickets::getOne($tic_id);
            return $this->twig->render("Ticket/formupdateticket.html.twig", array(
                'session' => $_SESSION,
                'ticket' => $ticket
            ));
        }
    }

    // Fonction de modification d'un ticket 
    public function updateTicket(){
        session_start();
        if (isset($_SESSION) && empty($_SESSION)){
            header('Location: ?controller=User&action=LoginForm');
        } else {
            $datas = $_POST;
            $userId = $_SESSION['user']['id'];
            if(isset($datas['ticket-title']) && $datas['ticket-title'] != "" && isset($datas['ticket-content']) && $datas['ticket-content'] != "" ){
                $result = Tickets::updateTicket($datas, $userId);
                if($result == true){
                    header('Location: ?controller=Ticket&action=getTickets');
                }
            } else {
                return $this->twig->render("Ticket/formupdateticket.html.twig", array(
                    'session' => $_SESSION,
                    'ticket' => $datas,
                    'errmessage' => "Veuillez entrer des informations valides"
                ));
            }
        }
    }

    public function deleteTicket($id){
        session_start();
        if (isset($_SESSION) && empty($_SESSION)){
            header('Location: ?controller=User&action=LoginForm');
        } else {
            $userId = $_SESSION['user']['id'];
            $result = Tickets::deleteTicket($id, $userId);
            if ($result == true){
                header('Location: ?controller=Ticket&action=getTickets');
                //avec message de validation

            } else {
                header('Location: ?controller=Ticket&action=getTickets');
                //avce message d'erreur 

            }
        }
    }
}