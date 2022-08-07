<?php

namespace App\Controllers;

class Applications extends BaseController
{
    public static function open($name)
    {
        echo view("VirtualMachine/Applications/" . $name);
    }

    public static function index($action, $isAjax, $data)
    {
        switch($action)
        {
            case 'getSoftware' :
                self::getSoftware($data['name']);
            break;
            case 'getScript' :
                self::getScript($data['name']);
            break;
        }
        
    }

    private static function getSoftware($name)
    {
        switch($name)
        {
            case 'Intranet' :
                self::open('Intranet');
                break;
            case 'Network' :
                self::open('Network');
                break;
            case 'Internet' :
                self::open('Internet');
                break;
            case 'Parameters' :
                self::open('Parameters');
                break;
        }
    }

    private static function getScript($name)
    {
        switch($name)
        {
            case 'Intranet' :
                echo file_get_contents(base_url("js/Applications/intranet.js"));
                break;
            case 'Network' :
                echo file_get_contents(base_url("js/Applications/network.js"));
                break;
            case 'Internet' :
                echo file_get_contents(base_url("js/Applications/internet.js"));
                break;
            case 'Parameters' :
                echo file_get_contents(base_url("js/Applications/parameters.js"));
                break;
        }
    }
}