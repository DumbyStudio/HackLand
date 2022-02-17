<?php

namespace App\Controllers\CompteControllers;

use \App\Models\CompteModels\InscriptionModel;
use \App\Controllers\Utils;
use \App\Controllers\CompteControllers\Verification;

class Inscription extends \App\Controllers\BaseController
{
    public static function open()
    {
        echo view('CompteViews/Inscription');
    }

    public static function getForm()
    {
        echo view('CompteViews/Forms/Inscription');
    }

    public static function index($action, $isAjax, $identifiants)
    {
        unset($_SESSION['error']['register']);
        switch($action) 
        {
            case 'inscription' :
                Inscription::inscription($identifiants, $isAjax);
                break;
            case 'open' :
            default :
                if($isAjax)
                {
                    Inscription::getForm();
                }
                else
                {
                    Inscription::open();
                }
                break;
        }
    }

    private static function inscription($identifiants, $isAjax)
    {
        $pseudo = $identifiants['login'];
        $mail = $identifiants['email'];
        $password = $identifiants['password'];
        $password2 = $identifiants['password2'];

        if(Inscription::inputAreValid($identifiants))
        {
            if( $password == $password2 )
            {
                if(InscriptionModel::userIsAvailable($pseudo, $mail))
                {
                    InscriptionModel::insertUser($identifiants);
                    $code = Inscription::generateCode(9);
                    InscriptionModel::insertValidationCode($pseudo, $code);
                    Inscription::sendCodeMail($pseudo, $code, $mail);

                    if($isAjax)
                    {
                        Verification::getForm();
                    }
                    else
                    {
                        Verification::open();
                    }
                    
                    exit();
                }
                else
                {
                    $_SESSION['error']['register'] = "Cet Email ou ce Pseudonyme est déjà utilisé.";
                }
            }
            else
            {
                $_SESSION['error']['register'] = "Les mots de passe ne correspondent pas.";
            }
        }
        else
        {
            $_SESSION['error']['register'] = "Les saisies de sont pas conformes.";
        }
        if($isAjax)
        {
            Inscription::getForm();
        }
        else
        {
            Inscription::open();
        }
    }

    private static function inputAreValid($identifiants)
    {
        $allIsValid = TRUE;

        if(strlen($identifiants['login']) > 30) $allIsValid = FALSE;

        if(strlen($identifiants['email']) > 50) $allIsValid = FALSE;
        if(!filter_var($identifiants['email'], FILTER_VALIDATE_EMAIL)) $allIsValid = FALSE;

        if(strlen($identifiants['password']) > 50) $allIsValid = FALSE;
        if(strlen($identifiants['password']) < 7) $allIsValid = FALSE;
        
        if(strlen($identifiants['password2']) > 50) $allIsValid = FALSE;
        if(strlen($identifiants['password2']) < 7) $allIsValid = FALSE;

        return $allIsValid;
    }

    private static function generateCode ($size)
    {
        $code = '';
        $exists = FALSE;

        do {

            $code = Utils::generateCode($size);

            $exists = InscriptionModel::isCodeExists($code);

        } while ($exists);

        return $code;
    }

    private static function sendCodeMail($pseudo, $code, $mail)
    {
        $Sujet = "Inscription sur 1To10";

        $Message = "Bonjour ". $pseudo .".<br/>";
        $Message .= "Voici votre code de vérification : ". $code ."<br/>";
        $Message .= "Vous pouvez aussi valider directement par le biais de ce lien :<br/>";
        $Message .= "<a href='http://localhost/1to10/verification.php?email=". $mail ."&code=". $code ."'>Lien de vérification</a><br/>";
        $Message .= "<p>Ce code ainsi que le compte qui y est lié seront effacés 30 jours après envois de ce mail s'ils ne sont pas activés.</p>";

        $Entete = "MIME-Version: 1.0" . "\r\n";
        $Entete .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $Entete .= 'From: <dumbystudio@gmail.com>' . "\r\n";

        mail($mail, $Sujet, $Message, $Entete);
    }
}
