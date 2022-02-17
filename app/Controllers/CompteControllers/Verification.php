<?php

namespace App\Controllers\CompteControllers;

use \App\Models\CompteModels\CompteModel;
use \App\Models\CompteModels\VerificationModel;

class Verification extends \App\Controllers\BaseController
{
    public static function open()
    {
        echo view('CompteViews/Verification');
    }

    public static function getForm()
    {
        echo view('CompteViews/Form/Verification');
    }

    public static function openVerified()
    {
        echo view('CompteViews/Verified');
    }

    public static function getFormVerified()
    {
        echo view('CompteViews/Form/Verified');
    }

    public static function index($action, $isAjax, $identifiants)
    {
        switch($action)
        {
            case 'verification' :
                Verification::verification($identifiants, $isAjax);
                break;
            case 'open' :
            default :
                if($isAjax)
                {
                    Verification::getForm();
                }
                else
                {
                    Verification::open();
                }
                break;
        }
    }

    private static function verification($identifiants, $isAjax)
    {
        $db = db_connect();

        if(CompteModel::userExists($identifiants['email']))
        {
            $id = CompteModel::getUserId($identifiants['email']);

            $baseCode = VerificationModel::getUserVerifCode($id);

            if($identifiants['code'] == $baseCode)
            {
                VerificationModel::deleteCode($id);

                if($isAjax)
                {
                    Verification::getFormVerified();
                }
                else
                {
                    Verification::openVerified();
                }
                
                exit();
            }
        }
        if($isAjax)
        {
            Verification::getForm();
        }
        else
        {
            Verification::open();
        }
        
    }
}