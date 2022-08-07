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
        $result = "ERROR NO RETURN VALUE !";
        switch($action)
        {
            case 'getUserInfos' :
                $result = Profil::getUserInfos();
                break;
            case 'delete' :
                $return = Profil::delete($data['delete'], $isAjax);
                break;
            case 'unsub' :
                $return = Profil::unsub($data['unsub'], $isAjax);
                break;
            case 'profil' :
            default :
                $return = Profil::open();
                break;
        }
        return $result;
    }

    private static function getUserInfos()
    {
        $arr = array('id' => 19868754, 'firstName' => 'Marcel', 'lastName' => 'Martin');    

        //add the header here
        header('Content-Type: application/json');
        echo json_encode( $arr );
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