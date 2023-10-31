<?php

namespace models;
use config\DataBase;
//use config\DataBase;

class Admin extends DataBase
{
    private $connexion;
    
    public function __construct()
    {
        $this -> connexion = $this -> getConnexion();
    }
    
    public function getAdminByEmail(string $email): ?array
    {
        $query = $this -> connexion -> prepare('
                                                SELECT
                                                    `ID_admin`,
                                                    `firstName`,
                                                    `lastName`,
                                                    `email`,
                                                    `password`
                                                FROM
                                                    `admin`
                                                WHERE
                                                    email = :email
                                                ');
        $query -> bindValue(":email",$email);
        $query -> execute();

        $admin = $query -> fetch();
        if($admin == false)
        {
            return null;
        }
        return $admin;
    }
    
}