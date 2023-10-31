<?php

namespace controllers;

use models\Sessions;
use models\Movies;

use traits\Security;


class SessionsController
{
use Security;

    private Sessions $sessions;
    
    public function __construct()
    {
        $this -> session = new Sessions();
        $this -> movies = new Movies();
    }
    
    public function displaySessions()
    {
        
        // appel à getSessionByMovieId pour récupérer tous les repas  portant un certain ID
        $session = $this -> session -> getSessionByMovieId($_GET['idMovie']);
        
        
        // appel au template 
        $template ="sessions/displaySessions";
        // ne pas oublier le layout 
        require "views/layout.phtml";
    }
    
    public function listSessions()
    {
        // sécuriser 
        if($this -> isConnectAdmin())
        {
            // afficher une liste avec toutes les séances
            $sessions = $this -> session -> getAllSessions();
            $template = "sessions/listSessions";
            require "views/layout.phtml";
        }
        else
        {
            header("location:index.php");
            exit();
        }
    }
    
    public function addSession()
    {
        // vérifier que c'est bien l'admin qui est connecté
        if($this -> isConnectAdmin())
        {
            
            $movies = $this -> movies -> getAllMovies();
            
            if(isset($_POST) && !empty($_POST))
            {
            
            // tester la soumission du form 
            if(isset($_POST['movie_id']) && !empty($_POST['movie_id'])
                    && isset($_POST['room_id']) && !empty($_POST['room_id'])
                    && isset($_POST['date']) && !empty($_POST['date'])
                    && isset($_POST['time']) && !empty($_POST['time'])
                    && isset($_POST['price']) && !empty($_POST['price']))
            {
                
                
                var_dump($_POST);
                $movie_id = $_POST['movie_id'];
                $room_id = $_POST['room_id'];
                $date= date($_POST['date']);
                $time = $_POST['time'];
                $price = $_POST['price'];
                
                
                
                // tester si la séance existe deja 
                $session = $this -> session -> getExistantSession( $movie_id, $room_id, $date, $time, $price);
                var_dump($session);
                if($session)
                {
                    $message = "La séance est déja enregistrée";
                    $class = "error";
                }
                else
                {
                    
                    $test = $this -> session -> insertSession ($movie_id, $room_id, $date, $time, $price);
                    var_dump($test);
                    // tester l'insertion 
                    if($test)
                    {
                        
                        $message = "Le film à bien été rajouté avec succès ";
                        $class = "confirm";
                        // redirection 
                        header("location:index.php?action=addSession&message=$message&class=$class");
                        exit();
                    
                    }
                    else
                    {
                        $message = "Une erreur Serveur est survenue";
                        $class = "error";
                    }
                }
                
            }
            else
            {
                $message = "Tous les champs sont obligatoire";
                $class = "error";
            }
            }
            // afficher le form d'ajout d'un repas 
            $template = "sessions/addSession";
            require "views/layout.phtml";
        }
        else
        {
            header("location:index.php");
            exit();
        }
    }
    
     public function ajaxAddPanier()
    {
        
        if(array_key_exists('session_id',$_GET) && is_numeric($_GET['session_id']))
        {
            // récupérer l'id de la session envoyé par le js 
            $session_id = $_GET['session_id'];
            $session = $this -> session -> getDetailsSession($session_id);
            
            // envoyé les infos vers la requete ajax 
            echo json_encode($session);
        }
        
    }

    // une méthode qui permet d'afficher le panier 
    public function displayPanier()
    {
        $template = "panier/displayPanier";
        require 'views/layout.phtml';
    }
    
    public function detailsSession()
    {
        if(array_key_exists("session_id",$_GET) && is_numeric($_GET['session_id']))
        {
            // lancer une requete 
            $session = $this -> session -> getDetailsSession($_GET['session_id']);
            // echo json_encode($session);// template 
            require "views/sessions/displayDetailsSession.phtml";
        }
    }
    
public function modifSession()
    {
        // sécuriser 
        if($this -> isConnectAdmin())
        {
            if(array_key_exists('idSession',$_GET) && is_numeric($_GET['idSession']))
            {
                // récupérer un film selon son id 
                
                $session = $this -> session -> getSessionById($_GET['idSession']);
                $template = "sessions/modifSession";
                require "views/layout.phtml";   
            }
            // si on a envoyé le form de modification 
            else if(isset($_POST['movie_id']) && !empty($_POST['movie_id'])
                    && isset($_POST['room_id']) && !empty($_POST['room_id'])
                    && isset($_POST['date']) && !empty($_POST['date'])
                    && isset($_POST['time']) && !empty($_POST['time'])
                    && isset($_POST['price']) && !empty($_POST['price'])
                    )
                    
            {
                $movie_id = $_POST['movie_id'];
                $room_id = $_POST['room_id'];
                $date = $_POST['date'];
                $time = $_POST['time'];
                $price = $_POST['price'];
                
                
                
                
                
                $test = $this -> movie -> updateMovie($movie_id, $room_id,$date, $time, $price);
                
                
                if($test)
                {
                    $message = "La séance à bien été modifiée avec succés ";
                    $class = "confirm";
                    
                    // redirection 
                    header("location:index.php?action=listSessions&message=$message&class=$class");
                    exit();
                }
                else
                {
                    $message = "Une erreur Serveur est survenue";
                    $class = "error";
                }
                
            }
            else
            {
                $message = "Tous les champs sont obligatoire";
                $class = "error";
            }
        }
        else
        {
            header('location:index.php');
            exit();
        }
    }
    
}





