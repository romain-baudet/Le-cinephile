<?php

namespace config;

class DataBase
{
    private const SERVER = "db.3wa.io";
    private const DB = "romainbaudet_cinephile";
    private const USER = "romainbaudet";
    private const MDP = "b3623cc0978bee857ecb9e33039f49b6";
    private $connexion;
    
    public function getConnexion()
    {
        try
        {
            $this -> connexion = new \PDO("mysql:host=".self::SERVER.";dbname=".self::DB.";charset=utf8",self::USER,self::MDP);
        }
        catch(PDOException $message)
        {
            die('message erreur connexion BDD'.$message -> getMessage());
        }
        return $this -> connexion;
    }
}

// tester 
//  $dataBase = new DataBase();
//  var_dump($dataBase -> getConnexion());



