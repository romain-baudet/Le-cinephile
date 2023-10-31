<?php

namespace controllers;

use models\Bookings;
use traits\Security;


class BookingsController
{
    use Security;

    private Bookings $bookings;
    
    public function __construct()
    {
        $this -> bookings = new Bookings();
    }
    
     public function listBookings()
    {
        // sécuriser et s'assurer que l'admin est connecté
        if($this -> isConnectAdmin())
        {
            // afficher une liste avec toutes les réservations 
            $bookings = $this -> bookings -> getAllBookings();
            $template = "bookings/listBookings";
            require "views/layout.phtml";
        }
        else
        {
            header("location:index.php");
            exit();
        }
    }
    
     public function userBookings()
    {
        // sécuriser 
        if($this -> isConnectUser())
        {
            
            // afficher une liste avec toutes les réservations de l'utilisateur 
            $bookings= $this->bookings->getBookingsDetailsByUser($_SESSION["connectUser"]["id"]);
            
            $template = "user/userBookings";
            require "views/layout.phtml";
        }
        else
        {
            $message = "Vous n'êtes pas connecté";
            $class = "error";
        }
    }
    
    public function listBookingDetails()
    {
        // sécuriser et s'assurer que l'admin est connecté
        if($this -> isConnectAdmin())
        {
            if(array_key_exists('idBooking',$_GET) && is_numeric($_GET['idBooking']))
            {
            // afficher une liste avec le détail des réservations
            
            $bookings = $this -> bookings -> getBookingsDetails($_GET['idBooking']);
            $template = "bookings/listBookingDetails";
            require "views/layout.phtml";
            }
        }
        else
        {
            header("location:index.php?action=tableauDeBord");
            exit();
        }
    }
    
    public function valideCmdAjax()
    {
       
        
        if($this -> isConnectUser())
        {
            // récupérer les infos envoyées via la requete ajax 
            if(array_key_exists('panier',$_GET) &&  array_key_exists('total',$_GET))
            {
                // panier --> json --> php
                $panier = json_decode($_GET['panier']);
                // var_dump($panier);
                $price = $_GET['total'];
                // var_dump($price);
                $user_id = $_SESSION["connectUser"]["id"];
                // var_dump($user_id);
                // insérer la cmd 
                
                $booking_id = $this -> bookings -> insertBooking($user_id, $price);
                // var_dump($booking_id);
                
                
                foreach($panier as $session)
                {                        
                    $test = $this -> bookings -> insertBookingDetails($booking_id, $user_id, $session[1],$session[8],$session[3],$session[4], $session[0], $session[5]);
                }
                
                echo $test;
            }
        }
        else
        {
            header("location:index.php?action=connexion");
            exit();
        }
        
    }
    
   
    
   
     
    
}


