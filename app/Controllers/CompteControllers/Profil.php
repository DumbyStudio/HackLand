<?php

namespace App\Controllers\CompteControllers;

use App\Models\ProfilModels\ProfilModel;

class Profil extends \App\Controllers\BaseController
{
    public static function open()
    {
        $_SESSION['profil']['subbedCharacters'] = ProfilModel::getSubbedCharacters();
        echo view("ProfilViews/Profil");
    }

    public static function index($action, $isAjax, $data)
    {
        switch($action)
        {
            case 'delete' :
                Profil::delete($data['delete'], $isAjax);
                break;
            case 'unsub' :
                Profil::unsub($data['unsub'], $isAjax);
                break;
            case 'profil' :
            default :
                Profil::open();
                break;
        }
    }

    private static function delete($deleteData, $isAjax)
    {
        switch($deleteData['type'])
        {
            case 'character' :
                ProfilModel::deleteCharacter($deleteData);
                echo view("ProfilViews/Scraps/myCharacters.php");
                break;
            case 'map' :
                ProfilModel::deleteMap($deleteData);
                echo view("ProfilViews/Scraps/myMaps.php");
                break;
            case 'quest' :
                ProfilModel::deleteQuest($deleteData);
                echo view("ProfilViews/Scraps/myQuests.php");
                break;
            default :
                if(!$isAjax)
                    Profil::open();
                break;
        }
    }

    private static function unsub($unsubData, $isAjax)
    {
        switch($unsubData['type'])
        {
            case 'character' :
                ProfilModel::unsubCharacter($unsubData);
                echo view("ProfilViews/Scraps/subbedCharacters.php");
                break;
            case 'map' :
                ProfilModel::unsubMap($unsubData);
                echo view("ProfilViews/Scraps/subbedMaps.php");
                break;
            case 'quest' :
                ProfilModel::unsubQuest($unsubData);
                echo view("ProfilViews/Scraps/subbedQuests.php");
                break;
            default :
                if(!$isAjax)
                    Profil::open();
                break;
        }
    }
}