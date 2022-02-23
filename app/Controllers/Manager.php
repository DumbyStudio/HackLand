<?php

namespace App\Controllers;

class Manager extends BaseController
{
    public static function open()
    {
        echo view('mainPage');
    }

    public static function index($action, $isAjax, $data)
    {
        switch($action)
        {
            default :
            case 'openVM' :
                echo view('VirtualMachine/VirtualMachine');
                break;
            /*default :
                self::open();
                break;*/
        }
    }
}