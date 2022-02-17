<?php

namespace App\Controllers;

use App\Models\AssetsModels\AssetsModel;

class Scrap extends BaseController
{
    
    public static function open($scrap)
    {
        switch($scrap)
        {
            case 'header' :
                Scrap::header();
                break;
            case 'myCharacters' :
                Scrap::myCharacters();
                break;
            case 'myNpcs' :
                Scrap::myNpcs();
                break;
            case 'myMaps' :
                Scrap::myMaps();
                break;
            case 'myQuests' :
                Scrap::myQuests();
                break;
            case 'subbedCharacters' :
                Scrap::subbedCharacters();
                break;
            case 'subbedMaps' :
                Scrap::subbedMaps();
                break;
            case 'subbedQuests' :
                Scrap::subbedQuests();
                break;
            default :
                echo "<span style='color:red;background-color:black;'>ERREUR</span>";
                break;
        }
    }

    private static function header()
    {
        echo view("Scraps/header");
    }

    private static function myCharacters()
    {
        echo view("ProfilViews/Scraps/myCharacters");
    }

    private static function myNpcs()
    {
        echo view("ProfilViews/Scraps/myNpcs");
    }

    private static function myMaps()
    {
        echo view("ProfilViews/Scraps/myMaps");
    }

    private static function myQuests()
    {
        echo view("ProfilViews/Scraps/myQuests");
    }

    private static function subbedCharacters()
    {
        echo view("ProfilViews/Scraps/subbedCharacters");
    }

    private static function subbedMaps()
    {
        echo view("ProfilViews/Scraps/subbedMaps");
    }

    private static function subbedQuests()
    {
        echo view("ProfilViews/Scraps/subbedQuests");
    }

    public static function openAjax($scrap, $infos)
    {
        switch($scrap)
        {
            case 'character' :
                Scrap::character($infos);
                break;
            case 'npc' :
                Scrap::npc($infos);
                break;
            case 'map' :
                Scrap::map($infos);
                break;
            case 'quest' :
                Scrap::quest($infos);
                break;
            default :
                echo "<span style='color:red;background-color:black;'>ERREUR</span>";
                break;
        }
    }

    private static function character($infos)
    {
        $_SESSION['asset']['character'] = AssetsModel::getCharacter();
        echo view("ProfilViews/Scraps/character");
    }

}