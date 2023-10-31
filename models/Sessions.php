<?php

namespace models;
use config\DataBase;


class Sessions extends DataBase
{
    private $connexion;
    
    public function __construct()
    {
        $this -> connexion = $this -> getConnexion();
    }
    
     public function getSessionByMovieId(int $movie_id): ?array
    {
        $query = $this -> connexion -> prepare("
                                                SELECT
                                                    `session_id`,
                                                    `movie_id`,
                                                    `room_id`,
                                                    `date`,
                                                    `time`,
                                                    `price`
                                                FROM
                                                    `sessions`
                                                WHERE 
                                                    movie_id = :movie_id 
                                                    AND CONCAT(`date`, ' ', `time`) > NOW()
                                                    
                                                ");
        $query -> bindValue(":movie_id",$movie_id);
        $query -> execute();
        $session = $query -> fetchAll();
        
        if($session == false)
        {
            return null;
        }
        return $session;
    }
    
     public function getSessionById(int $session_id): ?array
    {
        $query = $this -> connexion -> prepare("
                                                SELECT
                                                    `session_id`,
                                                    `movie_id`,
                                                    `room_id`,
                                                    `date`,
                                                    `time`,
                                                    `price`
                                                FROM
                                                    `sessions`
                                                WHERE 
                                                    session_id = :session_id
                                                ");
        $query -> bindValue(":session_id",$session_id);
        $query -> execute();
        $session = $query -> fetch();
        
        if($session == false)
        {
            return null;
        }
        return $session;
    }
    
     public function getAllSessions(): ?array
    {
        $query = $this -> connexion -> prepare("
                                                SELECT
                                                    `session_id`,
                                                    `movie_id`,
                                                    `room_id`,
                                                    `date`,
                                                    `time`,
                                                    `price`
                                                FROM
                                                    `sessions`
                                                ");
        $query -> execute();
        $sessions = $query -> fetchAll();
        
        return $sessions;
    }
    
    public function getExistantSession(int $movie_id, int $room_id, string $date, string $time): ?array
    {
        $query = $this -> connexion -> prepare("
                                                 SELECT
                                                    `movie_id`,
                                                    `room_id`,
                                                    `date`,
                                                    `time`
                                                FROM
                                                    `sessions`
                                                WHERE
                                                    movie_id = :movie_id AND
                                                    room_id = :room_id AND
                                                    date = :date AND 
                                                    time = :time
                                                ");
        
        $query -> bindValue(":movie_id",$movie_id);
        $query -> bindValue(":room_id",$room_id);
        $query -> bindValue(":date",$date);
        $query -> bindValue(":time",$time);
        
        $query -> execute();
        $session = $query -> fetchAll();
        
        if($session == false)
        {
            return null;
        }
        return $session;
    }
    
    public function insertSession (int $movie_id, int $room_id, string $date, string $time, string $price): bool
    {
        $query = $this -> connexion -> prepare("
                                                INSERT INTO `sessions`
                                                        (
                                                            `movie_id`,
                                                            `room_id`,
                                                            `date`,
                                                            `time`,
                                                            `price`
                                                         )
                                                         VALUES(
                                                            
                                                            :movie_id, 
                                                            :room_id, 
                                                            :date, 
                                                            :time,
                                                            :price
                                                        )
                                                ");
        
        
        
        $query -> bindValue(":movie_id",$movie_id);
        $query -> bindValue(":room_id",$room_id);
        $query -> bindValue(":date",$date);
        $query -> bindValue(":time",$time);
        $query -> bindValue(":price",$price);
        
        $test = $query -> execute();
        
        return $test;
    }
    
    public function getDetailsSession(int $session_id): ?array
    {
        $query = $this -> connexion -> prepare("
                                                SELECT
                                                    `session_id`,
                                                     sessions.date AS date,
                                                    `time`,
                                                    `price`,
                                                    `name`,
                                                    `title`,
                                                    `poster`,
                                                    movies.id AS movie_id,
                                                    rooms.room_id
                                                    
                                                FROM
                                                    `sessions`
                                                INNER JOIN
                                                	`rooms`
                                                ON
                                                	`sessions`.`room_id`= rooms.room_id
                                                INNER JOIN
                                                	`movies`
                                                ON	
                                                	`sessions`.`movie_id`= movies.id
                                                
                                                WHERE
                                                    session_id = :session_id

                                                ");
        $query -> bindValue(":session_id",$session_id);
        
        
        $query -> execute();
        $session = $query -> fetch();
        
        if($session == false)
        {
            return null;
        }
        return $session;
    }
    
    public function updateSession(int $movie_id,int  $room_id ,string $date,string $time,int $price): bool
    {
        $query = $this -> connexion -> prepare("
                                                
                                                UPDATE
                                                    `sessions`
                                                SET
                                                    `session_id` = :session_id,
                                                    `movie_id` = :movie_id,
                                                    `room_id` = :room_id,
                                                    `date` = :date,
                                                    `time` = :time,
                                                    `price` = :price
                                                WHERE
                                                    `session_id` = :session_id
                                                ");
        $query -> bindValue(":session_id",$session_id);
        $query -> bindValue(":movie_id",$movie_id);
        $query -> bindValue(":room_id",$room_id);
        $query -> bindValue(":date",$date);
        $query -> bindValue(":time",$time);
        $query -> bindValue(":price",$price);
      
        
        $test = $query -> execute();
        
        return $test;
    }
}