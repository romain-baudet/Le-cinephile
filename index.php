<?php
session_start();
use config\DataBase;

use controllers\MoviesController;
use controllers\UsersController;
use controllers\AdminController;
use controllers\SessionsController;
use controllers\BookingsController;




function chargerClasse($classe)
{
    $classe=str_replace('\\','/',$classe);
    require $classe . '.php'; 
}

spl_autoload_register('chargerClasse'); //Autoload

$movieController = new MoviesController();
$usersController = new UsersController();
$adminController = new AdminController();
$sessionController = new SessionsController();
$bookingController = new BookingsController();



// selon la valeur du param action on fait un appel à un controller 
// tester l'existance du param action 
if(array_key_exists("action",$_GET))
{
switch($_GET['action'])
{
    case "displayMovie" : 
        $movieController -> displayMovie();
        break;
    case "displaySessions" : 
        $sessionController -> displaySessions();
        break;
    case "formAddUser" : 
        $usersController -> formAddUser();
        break;
    case "connexion" : 
        $usersController -> formConnectUser();
        break;
    case "displayAccount" : 
        $usersController -> displayAccount();
        break;
    case "displayPanier" : 
        $sessionController -> displayPanier();
        break;
    case "userInfos" : 
        $usersController -> userInfos();
        break;
    case "userBookings" : 
        $bookingController -> userBookings();
        break;
    case "deconnexion" :
        $usersController -> deconnexion();
        break;
    case "homeAdmin" : 
        $adminController -> homeAdmin();
        break;
    case "tableauDeBord" : 
        $adminController -> tableauDeBord();
        break;
    case "addMovie" : 
        $movieController -> addMovie();
        break;
    case "modifMovie" : 
        $movieController -> modifMovie();
      break;
    case "listMovies" : 
        $movieController -> listMovies();
    break;
    case "suppMovie" : 
        $movieController -> suppMovie();
      break;
    case "listSessions" : 
        $sessionController -> listSessions();
        break;
    case "listBookings" : 
        $bookingController -> listBookings();
        break;
    case "listBookingDetails" : 
        $bookingController -> listBookingDetails();
        break;
    case "addSession" : 
        $sessionController -> addSession();
        break;
    case "modifSession" : 
        $sessionController -> modifSession();
        break;
    case "deconnexionAdmin" : 
        $adminController -> deconnexionAdmin();
     break;
    case "detailsSession" : 
        $sessionController -> detailsSession();
        break;
    case "ajaxAddPanier" : 
        $sessionController -> ajaxAddPanier();
        break;
    default :
    case "valideCmdAjax" : 
        $bookingController -> valideCmdAjax();
        break;
    
    // page not found 
    header('location:views/notFound/404.phtml');
    exit();
}
}
else
{
// on reste sur la page d'accueil --> par défault on affiche la page d'accueil 
// appel à la méthode displayMeals pour afficher la page d'acceuil 
$movieController -> displayShowingMovies();

}

