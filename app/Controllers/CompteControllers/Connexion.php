<?php

namespace App\Controllers\CompteControllers;

use \App\Models\CompteModels\CompteModel;
use \App\Models\CompteModels\ConnexionModel;

use \App\Controllers\Accueil;

class Connexion extends \App\Controllers\BaseController
{
    public static function open()
    {
        echo view('CompteViews/Connexion');
    }

    public static function getForm()
    {
        echo view('CompteViews/Forms/Connexion');
    }

    public static function index($action, $isAjax, $identifiants)
    {
        unset($_SESSION['error']['login']);
        switch($action) {
            case 'connexion' :
                Connexion::connexion($identifiants, $isAjax);
                break;
            case 'deconnexion' :
                Connexion::deconnexion();
                break;
            case 'open' :
            default :
                if($isAjax)
                {
                    Connexion::getForm();
                }
                else
                {
                    Connexion::open();
                }
                break;
        }
    }

    private static function connexion($identifiants, $isAjax)
    {
        $login = $identifiants['login'];
        $password = $identifiants['password'];

        if(Connexion::inputAreValid($login, $password))
        {
            if(CompteModel::userExists($login) && Connexion::checkPassword($login, $password))
            {
                if(CompteModel::isAccountValidate($login))
                {
                    $_SESSION['connected'] = true;
                    $_SESSION['account'] = CompteModel::getUserPseudo($login);
                    if($isAjax)
                    {
                        echo 'Accueil';
                    }
                    else
                    {
                        Accueil::open();
                    }
                }
                else
                {
                    if($isAjax)
                    {
                        Verification::getForm();
                    }
                    else
                    {
                        Verification::open();
                    }
                }
                exit();
            }
            else
            {
                $_SESSION['error']['login'] = "Les identifiants ne sont pas corrects.";
            }
        }
        else
        {
            $_SESSION['error']['login'] = "Les saisies ne sont pas conformes.";
        }
        if($isAjax)
        {
            Connexion::getForm();
        }
        else
        {
            Connexion::open();
        }
    }

    private static function inputAreValid($Pseudo, $Password)
    {
        $allIsValid = true;

        if(strlen($Pseudo) > 30) $allIsValid = false;

        if(strlen($Password) > 50) $allIsValid = false;
        if(strlen($Password) < 7) $allIsValid = false;

        return $allIsValid;
    }

    private static function deconnexion()
    {
        $_SESSION = array();
        Accueil::open();
    }

    private static function checkPassword($login, $password)
    {
        //verification password normal
        $userHash = ConnexionModel::getUserPassword($login);
        $classicPasswordIsValid = password_verify($password, $userHash);
        //fin verification password normal

        //verification existence password temporaire lors de la récupération de compte
        $asTempHash = ConnexionModel::userAsTempHash($login);

        $tempPasswordIsGood = false;
        if($asTempHash)
        {
            $tempHash = ConnexionModel::getUserTempHash($login);
            $tempPasswordIsGood = password_verify($password, $tempHash);
            ConnexionModel::deleteTempHash($login);
        }

        return ($classicPasswordIsValid || $tempPasswordIsGood);
    }

}