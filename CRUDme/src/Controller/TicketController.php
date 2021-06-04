<?php
namespace src\Controller;
use src\Model\Tickets;


class TicketController extends AbstractController{

    public function getTickets(){
        //if isset session return all ticket of corrent user, else return to login page 
        //Tickets::createTicket();
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

    }

}