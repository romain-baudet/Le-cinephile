<?php

namespace models;

use models\Bookings;
use config\DataBase;


class Bookings extends DataBase
{
    private $connexion;
    
    public function __construct()
    {
        $this -> connexion = $this -> getConnexion();
    }
    
     public function getAllBookings(): ?array
    {
        $query = $this -> connexion -> prepare("
                                                SELECT
                                                    `booking_id`,
                                                    `user_id`,
                                                    `price`,
                                                    date
                                                FROM
                                                    `bookings`
                                                ");
        $query -> execute();
        $bookings = $query -> fetchAll();
        
        return $bookings;
    }
    
    public function insertBooking(int $user_id,int $price): ?int
    {
        $query = $this -> connexion -> prepare('
                                                    INSERT INTO `bookings`(
                                                        `user_id`,
                                                        `price`,
                                                        date
                                                    )
                                                    VALUES(
                                                        :user_id,
                                                        :price,
                                                        NOW()
                                                    )
                                                ');

        $query -> bindValue(":user_id",$user_id);
        $query -> bindValue(":price",$price);

        $test = $query -> execute();
        //var_dump($query -> errorInfo());
        //var_dump($test);
        if($test)
        {
            return $this -> connexion -> lastInsertId();// de l'id de la cmd qui vient d'etre enregistrée 
        } 
        else
        {
            return null;
        }                                                      
        
    }
    
    public function insertBookingDetails(int $booking_id, int $user_id, int $movie_id,string $title, string  $date, string $time, int $session_id,int $quantity): bool
    {
        $query = $this -> connexion -> prepare('
                                                INSERT INTO `bookings_details`(
                                                    `booking_id`,
                                                    `user_id`,
                                                    `movie_id`,
                                                    `title`,
                                                    `date`,
                                                    `time`,
                                                    `session_id`,
                                                    `quantity`
                                                )
                                                VALUES(
                                                    :booking_id,
                                                    :user_id,
                                                    :movie_id,
                                                    :title,
                                                    :date,
                                                    :time,
                                                    :session_id,
                                                    :quantity
                                                )
                                            ');

        $query -> bindValue(":booking_id",$booking_id);
        $query -> bindValue(":user_id",$user_id);
        $query -> bindValue(":movie_id",$movie_id);
        $query -> bindValue(":title",$title);
        $query -> bindValue(":date",$date);
        $query -> bindValue(":time",$time);
        $query -> bindValue(":session_id",$session_id);
        $query -> bindValue(":quantity",$quantity);

        $test = $query -> execute();

        return $test;
    }
    
    public function getBookingsDetails($booking_id): ?array
    {
        $query = $this -> connexion -> prepare("
                                                SELECT
                                                    `booking_id`,
                                                    `user_id`,
                                                    `movie_id`,
                                                    `title`,
                                                    `date`,
                                                    `time`,
                                                    `session_id`,
                                                    `quantity`
                                                FROM
                                                    `bookings_details`
                                                WHERE 
                                                    booking_id = :booking_id
                                                ");
                                                
        $query -> bindValue(":booking_id",$booking_id);
        $query -> execute();
        $bookings = $query -> fetchAll();
        
        if($bookings == false)
        {
            return null;
        }
        return $bookings;
    }
    
    
    public function getBookingsDetailsByUser($user_id): ?array
    {
        $query = $this -> connexion -> prepare("
                                                SELECT
                                                    `booking_id`,
                                                    `user_id`,
                                                    `movie_id`,
                                                    `title`,
                                                    `date`,
                                                    `time`,
                                                    `session_id`,
                                                    `quantity`
                                                FROM
                                                    `bookings_details`
                                                WHERE 
                                                    user_id = :user_id
                                                ");
                                                
        $query -> bindValue(":user_id",$user_id);
        $query -> execute();
        $bookings = $query -> fetchAll();
        
        if($bookings == false)
        {
            return null;
        }
        return $bookings;
    }
    
}

