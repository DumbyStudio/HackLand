<?php

namespace App\Controllers;

class Accueil extends BaseController
{
    public static function open()
    {
        echo view('accueil');
    }

    public static function index($action, $isAjax)
    {
        switch($action)
        {
            case 'getInscriptionForm' :
                if($isAjax)
                {
                    echo view('Forms/inscription');
                }
                break;
            case 'getConnexionForm' :
                if($isAjax)
                {
                    echo view('Forms/connexion');
                }
                break;
            default :
                Accueil::open();
                break;
        }
    }
}