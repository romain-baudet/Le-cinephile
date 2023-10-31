<?php

namespace traits;

trait Security
{
    public function isConnectUser()
    {
        if(isset($_SESSION["connectUser"]))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function displayInfosUser()
    {
        if(isset($_SESSION["connectUser"]))
        {
            return $_SESSION["connectUser"]['infos'];
        }
        else
        {
            return "";
        }
    }
    
    // public function displayAllInfosUser()
    // {
    //     if(isset($_SESSION["connectUser"]))
    //     {
    //         return $_SESSION["connectUser"]['name'];
            
            
    //     }
    //     else
    //     {
    //         return "";
    //     }
    // }
    
    public function isConnectAdmin()
    {
        if(isset($_SESSION["connectAdmin"]))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    
    public function displayInfosAdmin()
    {
        if(isset($_SESSION["connectAdmin"]))
        {
            return $_SESSION["connectAdmin"]['infos'];
        }
        else
        {
            return "";
        }
    }
}





