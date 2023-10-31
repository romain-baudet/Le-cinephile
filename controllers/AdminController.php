<?php

namespace controllers;

use models\Admin;
use traits\Security;

class AdminController
{
    // utilisation du trait Security 
    use Security;
    
    private Admin $admin;
    
    public function __construct()
    {
        $this -> admin = new Admin();
    }
    
    public function homeAdmin()
    {
        if(isset($_POST) && !empty($_POST))
            {
            // tester la soumission de ce formulaire 
            if(isset($_POST['email']) && !empty($_POST['email'])
            && isset($_POST['password']) && !empty($_POST['password']))
            {
                // récupérer l'ensemble des infos (email et mdp )
                $emailForm = $_POST['email'];
                $mdpForm = $_POST['password'];
                
                // tester l'existence de l'adresse mail dans la BDD
                $admin = $this -> admin -> getAdminByEmail($emailForm);
                
                if($admin)
                {
                    // si  oui on passe à la vérif de mdp 
                    if(password_verify($mdpForm,$admin['password']))
                    {
                        // si oui on ouvre une varibale de session 
                        $_SESSION["connectAdmin"]["id"] = $admin['ID_admin'];
                        $_SESSION['connectAdmin']['infos'] = $admin['firstName'];
                        // // rediregé vers le panier 
                        header('location:index.php?action=tableauDeBord');
                    }
                    else
                    {
                        $message = "Votre mot de passe est incorrect";
                        $class = "error";
                    }
                    
                }
                else
                {
                    $message = "Votre adresse mail n'existe pas ";
                    $class = "error";
                }
            }
            else
            {
                $message = "Tous les champs sont obligatoire ";
                $class = "error";
            }
        }
            // afficher le formulaire d'authentification admin 
            $template = "admin/homeAdmin";
            require "views/layout.phtml";
    }
        
        public function tableauDeBord()
        {
            $template = "admin/tableauDeBord";
            require "views/layout.phtml";
        }
        
        public function deconnexionAdmin()
        {
            if(isset($_SESSION["connectAdmin"]))
            {
                unset($_SESSION['connectAdmin']);
                session_unset();
                session_destroy();
                
                header('location:index.php');
                exit();
            }
        }
}






