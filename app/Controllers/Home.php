<?php

namespace App\Controllers;

use \App\Controllers\CompteControllers\Connexion;
use \App\Controllers\CompteControllers\Identifiants;
use \App\Controllers\CompteControllers\Inscription;
use \App\Controllers\CompteControllers\Verification;

use \App\Controllers\CompteControllers\Profil;

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

        $_DATA['identifiants_verification'] = array();
        if(isset($_GET['code']) && isset($_GET['email']))
        {
            $page = 'verification';
            $action = 'verification';
            $_DATA['identifiants_verification']['email'] = htmlspecialchars($_GET['email']);
            $_DATA['identifiants_verification']['code'] = htmlspecialchars($_GET['code']);
        }
        if(isset($_POST['Code']) && isset($_POST['Email']))
        {
            $page = 'verification';
            $action = 'verification';
            $_DATA['identifiants_verification']['email'] = htmlspecialchars($_POST['Email']);
            $_DATA['identifiants_verification']['code'] = htmlspecialchars($_POST['Code']);
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

        $_DATA['profil'] = array();

        $_DATA['identifiants_recuperation'] = array();
        if(isset($_POST['recup_Mail']))
        {
            $page = 'getLogins';
            $action = 'getLogins';
            $_DATA['identifiants_recuperation']['email'] = htmlspecialchars($_POST['recup_Mail']);
        }

        if(!isset($_COOKIE['ticket']))
        {
            $ticket = session_id().microtime().rand(0,9999999999);
            $ticket = hash('sha512', $ticket);
            setcookie('ticket', $ticket, time() +  (60 * 20));
            $_SESSION['ticket'] = $ticket;
        }
        else
        {
            if($_COOKIE['ticket'] == $_SESSION['ticket'])
            {
                $ticket = session_id().microtime().rand(0,9999999999);
                $ticket = hash('sha512', $ticket);
                setcookie('ticket', $ticket, time() +  (60 * 20));
                $_SESSION['ticket'] = $ticket;
            }
            else
            {
                $action = 'default';
                $_SESSION = array();
                $_COOKIE = array();
                session_destroy();
                session_start();
                $ticket = session_id().microtime().rand(0,9999999999);
                $ticket = hash('sha512', $ticket);
                setcookie('ticket', $ticket, time() +  (60 * 20));
                $_SESSION['ticket'] = $ticket;
            }
        }

        Home::redirection($page, $action, $isAjax, $_DATA);
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
            case 'recupereIdentifiants' :
            case 'getLogins' :
                Identifiants::index($action, $isAjax, $_DATA['identifiants_recuperation']);
                break;
            case 'inscription' :
            case 'register' :
                Inscription::index($action, $isAjax, $_DATA['identifiants_inscription']);
                break;
            case 'verification' :
                Verification::index($action, $isAjax, $_DATA['identifiants_verification']);
                break;
            case 'creator' :
                Creator::index($action, $isAjax, $_DATA['creator_infos']); //TODO controlleur avec redirection vers les différents creators et le menu de creator
                break;
            case 'pageMJ' :
            case 'gameMasterPanel' :
                GameMasterPanel::index($action, $isAjax, $_DATA['game_mj_infos']); //TODO redirection vers la page pour créer une partie
                break;
            case 'rejoindre' :
            case 'jouer' :
                PlayerPanel::index($action, $isAjax, $_DATA['game_joueur_infos']); //TODO controlleur avec redirection vers les pages pour joindre une partie / jouer une partie
                break;
            case 'profil' :
                Profil::index($action, $isAjax, $_DATA['profil']); //TODO action de désabonnement et suppression d'objets
                break;
            case 'accueil' :
            case 'index' :
            default :
                Accueil::index($action, $isAjax);
                break;
        }
    }
}
