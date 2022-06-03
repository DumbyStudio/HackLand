<?php

namespace App\Controllers;

class Home extends BaseController
{
    public static function index()
    {
        session_start();
        $_DATA = array();
        
        $page = 'accueil';
        $action = 'none';
        $isAjax = false;
        if(isset($_GET['page']))
        {
            $page = htmlspecialchars($_GET['page']);
        }
        if(isset($_GET['action']))
        {
            $action = htmlspecialchars($_GET['action']);
        }
        if(isset($_GET['ajax']))
        {
            if($_GET['ajax'] == 'true')
            {
                $isAjax = true;
            }
        }

        if(isset($_GET['scrap']))
        {
            $page = "scrap";
            $_DATA['scrap'] = htmlspecialchar($_GET['scrap']);
        }

        $_DATA['identifiants_connexion'] = array();
        if(isset($_POST['connect_Pseudo']) && isset($_POST['connect_Mdp']))
        {
            $page = 'connexion';
            $action = 'connexion';
            $_DATA['identifiants_connexion']['login'] = htmlspecialchars($_POST['connect_Pseudo']);
            $_DATA['identifiants_connexion']['password'] = htmlspecialchars($_POST['connect_Mdp']);
        }

        $_DATA['identifiants_inscription'] = array();
        if(isset($_POST['inscri_Pseudo']) && isset($_POST['inscri_Email']) && isset($_POST['inscri_Mdp']) && isset($_POST['inscri_Verif']))
        {
            $page = 'inscription';
            $action = 'inscription';
            $_DATA['identifiants_inscription']['login'] = htmlspecialchars($_POST['inscri_Pseudo']);
            $_DATA['identifiants_inscription']['email'] = htmlspecialchars($_POST['inscri_Email']);
            $_DATA['identifiants_inscription']['password'] = htmlspecialchars($_POST['inscri_Mdp']);
            $_DATA['identifiants_inscription']['password2'] = htmlspecialchars($_POST['inscri_Verif']);
        }

        $_DATA['manager'] = array();

        if(!self::verifyTicket())
        {
            $page = 'default';
            $action = 'default';
        }
        self::setTicket();

        self::redirection($page, $action, $isAjax, $_DATA);
    }

    private static function verifyTicket()
    {
        if(isset($_COOKIE['ticket']) && $_COOKIE['ticket'] != $_SESSION['ticket'])
        {
            $_SESSION = array();
            $_COOKIE = array();
            session_destroy();
            session_start();
            return false;
        }
        return true;
    }

    private static function setTicket()
    {
        $ticket = hash('sha512', session_id().microtime().rand(0,9999999999));
        setcookie('ticket', $ticket, ["samesite" => "Lax", "expires" => time() + 60 * 20]);
        $_SESSION['ticket'] = $ticket;
    }

    private static function redirection($page, $action, $isAjax, $_DATA)
    {
        switch($page)
        {
            case 'scrap' :
                if($isAjax)
                    Scrap::openAjax($_DATA['scrap']['name'], $_DATA['scrap']['infos']);
                else
                    Scrap::open($_DATA['scrap']);
                break;
            case 'connexion' :
            case 'connection' :
                Connexion::index($action, $isAjax, $_DATA['identifiants_connexion']);
                break;
            case 'inscription' :
            case 'register' :
                Inscription::index($action, $isAjax, $_DATA['identifiants_inscription']);
                break;
            case 'jeu' :
            case 'manager' :
                Manager::index($action, $isAjax, $_DATA['manager']);
                break;
            case 'accueil' :
            case 'index' :
            default :
                Accueil::index($action, $isAjax);
                break;
        }
    }
}
