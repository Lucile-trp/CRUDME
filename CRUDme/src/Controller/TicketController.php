<?php
namespace src\Controller;
use src\Model\Tickets;


class TicketController extends AbstractController{

    public function index(){
        header('Location: ?controller=Ticket&action=getTicket');
    }

    // Récupère tout les tickets de l'utilisateur connecté
    public function getTickets(){
        session_start();
        $tickets = Tickets::getTickets();

        return $this->twig->render("Ticket/ticket.html.twig", array(
            'session' => $_SESSION,
            'tickets' => $tickets
        ));

    }

    public function ticketForm(){
        session_start();
        return $this->twig->render("Ticket/newticket.html.twig", array(
            'session' => $_SESSION
        ));
    }

    public function newTicket(){
        session_start();
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

    public function updateTicketForm(){

    }

    public function updateTicket(){
        session_start();
        //TODO 
        /// récupérer les données necessiares 
        /// Renvoyer au model 
        /// Redirection
    }

    public function deleteTicket($id){
        session_start();
        var_dump($_SESSION, $id);
        $userId = $_SESSION['user']['id'];
        $result = Tickets::deleteTicket($id, $userId);
        if ($result == true){
            header('Location: ?controller=Ticket&action=getTickets');
            //avec message de validation

        } else {
            header('Location: ?controller=Ticket&action=getTickets');
            //avce message d'erreur 

        }


        //HEADER LOCATION 

    }

}