<?php
namespace src\Model;
use DateTime;
use src\Model\BDD;

class Tickets{
    //PK
    protected $id;
    //
    protected $title;
    protected $content;
    protected $date;
    //FK
    protected $user;

    //Création de tickets 
    public static function createTicket(){

        $date = new DateTime();


        $db = BDD::getInstance(); //connect database
        $request = "INSERT INTO tickets() VALUES ...";

    }

    public static function getTickets(){
        $id = $_SESSION['user']['id'];
        $db = BDD::getInstance();
        $request = "SELECT * FROM tickets WHERE use_id=:id;";

        $req = $db->prepare($request);
        $req->bindValue(":id", $id);
        $req->execute();
        $tickets = $req->fetchAll();
        return $tickets;
    }

}