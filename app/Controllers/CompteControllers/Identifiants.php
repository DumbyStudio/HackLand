<?php

namespace App\Controllers\CompteControllers;

use \App\Models\CompteModels\CompteModel;
use \App\Models\CompteModels\IdentifiantsModel;

use \App\Controllers\Utils;

class Identifiants extends \App\Controllers\BaseController
{
    public static function open()
    {
        echo view("CompteViews/Identifiants");
    }

    public static function getForm()
    {
        echo view("CompteViews/Forms/Identifiants");
    }

    public static function index($action, $isAjax, $identifiants)
    {
        unset($_SESSION['error']['identifiers']);
        switch($action)
        {
            case 'getLogins' :
                Identifiants::getLogins($identifiants, $isAjax);
                break;
            case 'open' :
            default :
                if(!$isAjax)
                {
                    Identifiants::open();
                }
                else
                {
                    Identifiants::getForm();
                }
                break;
        }
    }

    private static function getLogins($identifiants, $isAjax)
    {
        $mail = $identifiants['email'];

        if(Identifiants::inputsAreValid($mail))
        {
            $pseudo = CompteModel::getUserPseudo($mail);
            if(CompteModel::userExists($pseudo))
            {
                $password = Utils::generateCode(15);
                IdentifiantsModel::insertTemporaryPassword($pseudo, $password);
                Identifiants::sendIdentifiersMail($pseudo, $password, $mail);

                if($isAjax)
                {
                    Connexion::getForm();
                }
                else
                {
                    Connexion::open();
                }
                exit();
            }
            else
            {
                $_SESSION['error']['identifiers'] = "Cet email ne correspond à aucun compte.";
            }
        }
        else
        {
            $_SESSION['error']['identifiers'] = "La saisie n'est pas conforme.";
        }
        if($isAjax)
        {
            Identifiants::getForm();
        }
        else
        {
            Identifiants::open();
        }
    }

    private static function inputsAreValid($Mail)
    {
        $allIsValid = TRUE;

        if(strlen($Mail) > 50) $allIsValid = FALSE;
        if(!filter_var($Mail, FILTER_VALIDATE_EMAIL)) $allIsValid = FALSE;

        return $allIsValid;
    }

    private static function sendIdentifiersMail($Pseudo, $Password, $Mail)
    {
        $Sujet = "Inscription sur 1To10";

        $Sujet = "Oublie d'identifiants sur 1To10";

        $Message = "Bonjour ". $Pseudo .".<br/>";
        $Message .= "Voici votre mot de passe temporaire : ". $Password ."<br/>";
        $Message .= "<p>Ce mot de passe temporaire sera effacé dans 24H s'il n'est pas utilisé d'ici là.</p>";

        echo $Message;

        $Entete = "MIME-Version: 1.0" . "\r\n";
        $Entete .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $Entete .= 'From: <dumbystudio@gmail.com>' . "\r\n";

        mail($Mail,$Sujet,$Message,$Entete);
    }
}