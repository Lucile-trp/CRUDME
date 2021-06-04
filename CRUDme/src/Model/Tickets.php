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
    public static function createTicket($datas, $userId){

        //ID user
        $title = $datas['ticket-title'];
        $content = $datas['ticket-content'];
        $db = BDD::getInstance(); //connect database
        $request = "INSERT INTO tickets(use_id, tic_title, tic_content) VALUES (:userId, :title, :content)";

        $req = $db->prepare($request);
        $req->bindValue(":userId", $userId);
        $req->bindValue(":title", $title);
        $req->bindValue(":content", $content);
        $req->execute();
        return true;
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

    //TODO UPDATE
    //TODO DELETE

    public static function deleteTicket($id, $userId){

        $db = BDD::getInstance();
        $request = "DELETE FROM tickets WHERE tic_id=:id AND use_id=:userId;";
        
        $req = $db->prepare($request);
        $req->bindValue(":id", $id);
        $req->bindValue(":userId", $userId);
        $req->execute();
        return true;

    }

}