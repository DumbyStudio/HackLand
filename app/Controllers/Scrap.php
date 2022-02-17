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
            case 'footer' :
                Scrap::footer();
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

    private static function footer()
    {
        echo view("Scraps/footer");
    }

}