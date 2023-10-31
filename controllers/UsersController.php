<?php

namespace controllers;

use models\Users;
use traits\Security;

class UsersController
{
    use Security;
    private Users $users;

    public function __construct()
    {
        $this -> users = new Users();
    }

    // permet d'afficher le formulaire de création d'un compte et gérer l'ajout dans la BDD 
    public function formAddUser()
    {
        if (isset($_POST['register-submit'])) 
        {
            if (isset($_POST['name']) && 
                isset($_POST['surname']) && 
                isset($_POST['birthdate']) && 
                isset($_POST['email']) && 
                isset($_POST['password'])) 
            {
                // on vérifie la validité des données entrées par l'utilisateur
                $name = $_POST['name'];
                $surname = $_POST['surname'];
                $birthdate = $_POST['birthdate'];
                $email = $_POST['email'];
                $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hashage du mot de passe
    
                $user = $this->users->getUserByEmail($email);
                //var_dump($user);
                if ($user == null)
                {
                    // 4- appel à la méthode insertUser pour lancer lansertion 
                    $test = $this->users->insertUser($name,$surname,$birthdate,$email,$password);
                    // soit tout est ok --> un message de confirmation
                    if ($test)
                    {
                        $message = "Votre compte à bien été crée ";
                        $class = "confirm";
                        header('location:index.php?action=connexion&message='.$message.'&class='.$class);
                    }
                    else
                    {
                        // soit une erreur 
                        $message = "Une erreur serveur est survenue ";
                        $class = "error";
                    }
                }
                else
                {
                    // 3- un message d'erreur l'adresse mail existe déja 
                    $message = " Votre adresse mail existe déja ";
                    $class = "error";
                }
            }
            else
            {
                $message = "veuillez remplir tous les champs ";
                $class = "error";
            }
        }  
        $template = "user/formAddUser";
        require "views/layout.phtml";
    }

    public function formConnectUser()
    {
        // tester la soumission de ce formulaire
        if(isset($_POST['email']) && !empty($_POST['email'])
        && isset($_POST['password']) && !empty($_POST['password']))
        {
            // récupérer l'ensemble des infos (email et mdp )
            $emailForm = $_POST['email'];
            $mdpForm = $_POST['password'];
            // tester l'existence de l'adresse mail dans la BDD
            $user = $this -> users -> getUserByEmail($emailForm);
            
            if($user)
            {
                // si  oui on passe à la vérif de mdp 
                if(password_verify($mdpForm,$user['password']))
                {
                    // si oui on ouvre une varibale de session 
                    $_SESSION["connectUser"]["id"] = $user['id'];
                    $_SESSION['connectUser']['infos'] = substr($user['name'], 0, 1) . '' . substr($user['surname'], 0, 1);

                    
                    // rediregé vers le panier 
                    header('location:index.php');
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
        // afficher le form de connexion 
        $template = "user/formConnectUser";
        require "views/layout.phtml";
    }

    public function deconnexion()
    {
        if(isset($_SESSION["connectUser"]))
        {
            unset($_SESSION['connectUser']);
            session_unset();
            session_destroy();
            
            header('location:index.php?action=connexion');
            exit();
        }
    }
    
    public function displayAccount()
    {
        
        $template = "user/displayAccount";
        require "views/layout.phtml";
        
    }
    
    public function userInfos()
    {
        if(isset($_SESSION["connectUser"]))
        {
            $user = $this->users->getUserById($_SESSION["connectUser"]["id"]);
        }
        else
        {
            $message = "Vous n'êtes pas connecté";
            $class = "error";
        }
            
        $template = "user/userInfos";
        require "views/layout.phtml";
    }

}