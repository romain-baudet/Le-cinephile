<?php

namespace models;
use config\DataBase;
class Users extends DataBase 
{
    private $connexion;
    
    public function __construct()
    {
        $this -> connexion = $this -> getConnexion();
    }

    // permet d'insérer un utilisateur dans la table users
    public function insertUser(string $name, string $surname, string $birthdate, string $email, string $password): bool
    {
        // lancer une requete INSERT 
        $query = $this -> connexion -> prepare("
                                                INSERT INTO `users`(
                                                    `name`,
                                                    `surname`,
                                                    `birthdate`,
                                                    `email`,
                                                    `password`
                                                )
                                                VALUES(
                                                    :name,
                                                    :surname,
                                                    :birthdate,
                                                    :email,
                                                    :password
                                                )
                                            ");

        $query -> bindValue(":name",$name);
        $query -> bindValue(":surname",$surname);
        $query -> bindValue("birthdate",$birthdate);
        $query -> bindValue(":email",$email);
        $query -> bindValue(":password",$password);
        
        $test = $query -> execute();

        return $test;// true ou false 
    }

    public function getUserByEmail(string $email): ?array
    {
        $query = $this -> connexion -> prepare('
                                                SELECT
                                                    `id`,
                                                    `email`,
                                                    `password`,
                                                    name,
                                                    surname
                                                FROM
                                                    `users`
                                                WHERE
                                                    `email` = :email
                                                ');
        $query -> bindValue(":email",$email);
        $query -> execute();

        $user = $query -> fetch();
        if($user == false)
        {
            return null;
        }
        return $user;
    }
    
     public function getUserById(int $id): ?array
    {
        $query = $this -> connexion -> prepare('
                                                SELECT
                                                    
                                                    `email`,
                                                    `password`,
                                                    birthdate,
                                                    name,
                                                    surname
                                                FROM
                                                    `users`
                                                WHERE
                                                    `id` = :id
                                                ');
        $query -> bindValue(":id",$id);
        $query -> execute();

        $user = $query -> fetch();
        if($user == false)
        {
            return null;
        }
        return $user;
    }

}