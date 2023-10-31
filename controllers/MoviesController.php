<?php

namespace controllers;

use models\Movies;
use traits\Security;


class MoviesController
{
use Security;

    private Movies $movie;
    
    public function __construct()
    {
        $this -> movie = new Movies();
    }
    
    public function displayShowingMovies()
    {
        // Appel aux deux fonctions pour afficher les films a l'affiche et à venir dans la page d'accueil
        $showingMovies = $this -> movie -> getShowingMovies();
        $futureMovies = $this -> movie -> getFutureMovies();
        // appel au template 
        $template ="home";
        // ne pas oublier le layout 
        require "views/layout.phtml";
    }
    
    public function displayMovie()
    {
        // appel à getMovieById pour récupérer les films portant un certain ID
        $movie = $this -> movie -> getMovieById($_GET['idMovie']);
        
        // appel au template 
        $template ="movies/displayMovie";
        // ne pas oublier le layout 
        require "views/layout.phtml";
    }

    
    public function listMovies()
    {
        // sécuriser et s'assurer que l'admin est connecté
        if($this -> isConnectAdmin())
        {
            // afficher une liste avec tous les films
            $movies = $this -> movie -> getAllMovies();
            $template = "movies/listMovies";
            require "views/layout.phtml";
        }
        else
        {
            header("location:index.php");
            exit();
        }
    }

    public function addMovie()
    {
        // sécuriser et s'assurer que l'admin est connecté
        if($this -> isConnectAdmin())
        {
            if(isset($_POST) && !empty($_POST))
            {
            // tester la soumission du form 
            if(isset($_POST['title']) && !empty($_POST['title'])
                    && isset($_POST['date']) && !empty($_POST['date'])
                    && isset($_POST['type']) && !empty($_POST['type'])
                    && isset($_POST['duration']) && !empty($_POST['duration'])
                    && isset($_POST['realisator']) && !empty($_POST['realisator'])
                    && isset($_POST['actors']) && !empty($_POST['actors'])
                    && isset($_POST['resume']) && !empty($_POST['resume'])
                    && isset($_POST['teaser']) && !empty($_POST['teaser'])
                    && isset($_POST['status']) && !empty($_POST['status'])
                    && isset($_FILES['poster']['name']) && !empty($_FILES['poster']['name']))
            {
                
                $title = $_POST['title'];
                $dateString = date($_POST['date']);
                $type = $_POST['type'];
                $duration = $_POST['duration'];
                $realisator = $_POST['realisator'];
                $actors = $_POST['actors'];
                $resume = $_POST['resume'];
                $teaser = htmlspecialchars($_POST['teaser']);
                $status = (int)$_POST['status'];
                $poster = $_FILES['poster']['name'];
                
                // tester si le film existe deja via le titre 
                $movie = $this -> movie -> getMovieByName($title);
                
                if($movie)
                {
                    $message = "Le film est déja enregistré";
                    $class = "error";
                }
                else
                {
                    $test = $this -> movie -> insertMovie($title,$dateString, $type, $duration, $realisator, $actors, $resume,$teaser, $status, $poster);
                    
                    
                    // tester l'insertion 
                    if($test)
                    {
                        // télécharger l'image 
                            // le code pour télécharger une image dans le dossier 
                        $uploads_dir = 'public/images/';
                        $tmp_name = $_FILES["poster"]["tmp_name"];
                        $name = basename($_FILES["poster"]["name"]);
                        
                        $load = move_uploaded_file($tmp_name, "$uploads_dir/$name");
                        
                        if($load)
                        {
                            $message = "Le film à bien été rajouté avec succès ";
                            $class = "confirm";
                            // redirection 
                            header("location:index.php?action=addMovie&message=$message&class=$class");
                            exit();
                        }
                        else
                        {
                            $message = "Une erreur de téléchargement de l'image ";
                            $class = "error";
                        }
                        
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
            // fin soumission for
            // afficher le form d'ajout d'un film 
            $template = "movies/addMovie";
            require "views/layout.phtml";
        }
        else
        {
            header("location:index.php");
            exit();
        }
    }
    


    public function modifMovie()
    {
        // sécuriser 
        if($this -> isConnectAdmin())
        {
            if(array_key_exists('idMovie',$_GET) && is_numeric($_GET['idMovie']))
            {
                // récupérer un film selon son id 
                
                $movie = $this -> movie -> getMovieById($_GET['idMovie']);
                $template = "movies/modifMovie";
                require "views/layout.phtml";   
            }
            // si on a envoyé le form de modification 
            else if(isset($_POST['title']) && !empty($_POST['title'])
                    && isset($_POST['date']) && !empty($_POST['date'])
                    && isset($_POST['type']) && !empty($_POST['type'])
                    && isset($_POST['duration']) && !empty($_POST['duration'])
                    && isset($_POST['realisator']) && !empty($_POST['realisator'])
                    && isset($_POST['actors']) && !empty($_POST['actors'])
                    && isset($_POST['resume']) && !empty($_POST['resume'])
                    && isset($_POST['teaser']) && !empty($_POST['teaser'])
                    && isset($_POST['status']) && !empty($_POST['status'])
                    )
                    // ici le probleme
            {
                $id = $_POST['idMovie'];
                $title = $_POST['title'];
                $date = $_POST['date'];
                $type = $_POST['type'];
                $duration = $_POST['duration'];
                $realisator = $_POST['realisator'];
                $actors = $_POST['actors'];
                $resume = $_POST['resume'];
                $teaser = $_POST['teaser'];
                $status = $_POST['status'];
                
                
                // tester la modif de l'image 
                if(!empty($_FILES['newPoster']['name']))
                {
                    $poster = $_FILES['newPoster']['name'];
                    
                    // télécharger l'image 
                    // le code pour télécharger une image dans le dossier 
                    $uploads_dir = 'public/images/';
                    $tmp_name = $_FILES["newPoster"]["tmp_name"];
                    $poster = basename($_FILES["newPoster"]["name"]);
                    
                    $load = move_uploaded_file($tmp_name, "$uploads_dir/$poster");
                   
                    
                }
                else
                {
                    $movie = $this -> movie -> getMovieById($id);
                    $poster = $movie['poster'];// on récupère l'ancienne photo
                }
                
                $test = $this -> movie -> updateMovie($id, $title,$date, $type, $duration, $realisator, $actors, $resume,$teaser, $status, $poster);
                
                
                if($test)
                {
                    $message = "Le film à bien été modifié avec succés ";
                    $class = "confim";
                    
                    // redirection 
                    header("location:index.php?action=listMovies&message=$message&class=$class");
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
    
    public function suppMovie()
    {
        //sécuriser  et s'assurer que l'admin est connecté
        if($this -> isConnectAdmin())
        {
            if(array_key_exists('idMovie',$_GET) && is_numeric($_GET['idMovie']))
            {
                $test = $this -> movie -> deleteMovie($_GET['idMovie']);
                
                if($test)
                {
                    $message = "Le film à bien été supprimé avec succés ";
                    $class = "confim";
                    
                    // redirection 
                    header("location:index.php?action=listMovies&message=$message&class=$class");
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
            header('location:index.php');
            exit();
        }
    }
    
}