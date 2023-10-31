<?php

namespace models;
use config\DataBase;
//use config\DataBase;

class Movies extends DataBase
{
    private $connexion;
    
    public function __construct()
    {
        $this -> connexion = $this -> getConnexion();
    }
    
    // une méthode qui permet de séléctionner tous les repas 
    public function getAllMovies(): ?array
    {
        $query = $this -> connexion -> prepare("
                                                SELECT
                                                    `id`,
                                                    `title`,
                                                    `date`,
                                                    `type`,
                                                    `duration`,
                                                    `realisator`,
                                                    SUBSTR(`resume`,1,150) AS resume,
                                                    `actors`,
                                                    SUBSTR(`teaser`,1,30) AS teaser,
                                                    `poster`,
                                                    `status`
                                                FROM
                                                    `movies`
                                                
                                                ");
        $query -> execute();
        $movies = $query -> fetchAll();
        
        return $movies;
    }



    public function getShowingMovies(): ?array
    {
        $query = $this -> connexion -> prepare("
                                                SELECT
                                                    `id`,
                                                    `title`,
                                                    `date`,
                                                    `type`,
                                                    `duration`,
                                                    `realisator`,
                                                    `resume`,
                                                    `actors`,
                                                    `teaser`,
                                                    `poster`,
                                                    `status`
                                                FROM
                                                    `movies`
                                                WHERE
                                                    `status` = 1

                                                ");
        $query -> execute();
        $showingMovies = $query -> fetchAll();
        
        return $showingMovies;
    }

    public function getFutureMovies(): ?array
    {
        $query = $this -> connexion -> prepare("
                                                SELECT
                                                    `id`,
                                                    `title`,
                                                    `date`,
                                                    `type`,
                                                    `duration`,
                                                    `realisator`,
                                                    `resume`,
                                                    `actors`,
                                                    `teaser`,
                                                    `poster`,
                                                    `status`
                                                FROM
                                                    `movies`
                                                WHERE
                                                    `status` = 2

                                                ");
        $query -> execute();
        $futureMovies = $query -> fetchAll();
        
        return $futureMovies;
    }

    public function getMovieById(int $id): ?array
    {
        $query = $this -> connexion -> prepare("
                                                SELECT
                                                    `id`,
                                                    `title`,
                                                    `date`,
                                                    `type`,
                                                    `duration`,
                                                    `realisator`,
                                                    `resume`,
                                                    `actors`,
                                                    `teaser`,
                                                    `poster`,
                                                    `status`
                                                FROM
                                                    `movies`
                                                WHERE 
                                                    id = :id
                                                ");
        $query -> bindValue(":id",$id);
        $query -> execute();
        $movie = $query -> fetch();
        
        if($movie == false)
        {
            return null;
        }
        return $movie;
    }
    
    public function getMovieByName(string $title): ?array
    {
        $query = $this -> connexion -> prepare("
                                                 SELECT
                                                    `id`,
                                                    `title`,
                                                    `date`,
                                                    `type`,
                                                    `duration`,
                                                    `realisator`,
                                                    `resume`,
                                                    `actors`,
                                                    `teaser`,
                                                    `poster`,
                                                    `status`
                                                FROM
                                                    `movies`
                                                WHERE 
                                                    title = :title
                                                ");
        $query -> bindValue(":title",$title);
        $query -> execute();
        $movie = $query -> fetch();
        
        if($movie == false)
        {
            return null;
        }
        return $movie;
    }
    
    public function insertMovie(string $title,string $date,string $type,string $duration, string $realisator, string $actors, string $resume, string $teaser, int $status, string $poster): bool
    {
        $query = $this -> connexion -> prepare("
                                                INSERT INTO `movies`(
                                                            `title`,
                                                            `date`,
                                                            `type`,
                                                            `duration`,
                                                            `realisator`,
                                                            `actors`,
                                                            `resume`,
                                                            `teaser`,
                                                            `poster`,
                                                            `status`
                                                         )
                                                         VALUES(
                                                            
                                                            :title,
                                                            :date,
                                                            :type,
                                                            :duration,
                                                            :realisator,
                                                            :actors,
                                                            :resume,
                                                            :teaser,
                                                            :poster,
                                                            :status
                                                        )
                                            ");
        
        
        $query -> bindValue(":title",$title);
        $query -> bindValue(":date",$date);
        $query -> bindValue(":type",$type);
        $query -> bindValue(":duration",$duration);
        $query -> bindValue(":realisator",$realisator);
        $query -> bindValue(":actors",$actors);
        $query -> bindValue(":resume",$resume);
        $query -> bindValue(":teaser",$teaser);
        $query -> bindValue(":poster",$poster);
        $query -> bindValue(":status",$status);
        
        $test = $query -> execute();
        
        return $test;
    }
    
    public function updateMovie(int $id,string $title,string $date,string $type,string $duration, string $realisator, string $actors, string $resume, string $teaser, int $status, string $poster): bool
    {
        $query = $this -> connexion -> prepare("
                                                
                                                UPDATE
                                                    `movies`
                                                SET
                                                    `id` = :id,
                                                    `title` = :title,
                                                    `date` = :date,
                                                    `type` = :type,
                                                    `duration` = :duration,
                                                    `realisator` =:realisator,
                                                    `actors` = :actors,
                                                    `resume` = :resume,
                                                    `teaser` = :teaser,
                                                    `poster` = :poster,
                                                    `status` = :status
                                                WHERE
                                                    `id` = :id
                                                ");
        $query -> bindValue(":id",$id);
        $query -> bindValue(":title",$title);
        $query -> bindValue(":date",$date);
        $query -> bindValue(":type",$type);
        $query -> bindValue(":duration",$duration);
        $query -> bindValue(":realisator",$realisator);
        $query -> bindValue(":actors",$actors);
        $query -> bindValue(":resume",$resume);
        $query -> bindValue(":teaser",$teaser);
        $query -> bindValue(":poster",$poster);
        $query -> bindValue(":status",$status);
        
        $test = $query -> execute();
        
        return $test;
    }
    
    public function deleteMovie(int $id): bool
    {
        $query = $this -> connexion -> prepare("
                                                DELETE
                                                FROM
                                                    `movies`
                                                WHERE
                                                    `id` = :id
                                                ");
        
        $query -> bindValue(":id",$id);
        
        $test = $query -> execute();
        
        return $test;
    }
}