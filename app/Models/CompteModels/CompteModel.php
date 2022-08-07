<?php

namespace App\Models\CompteModels;

class CompteModel
{
    public static function getUserPseudo($login)
    {
        $db = db_connect();
        
        $req = 'SELECT nom FROM User WHERE nom = ? OR email = ? LIMIT 1 ;';
        $results = $db -> query($req, array( $login, $login ));

        $pseudo = $results -> getResult()[0] -> UserName;

        return $pseudo;
    }

    public static function getUserId($login)
    {
        $id = 0;
        $db = db_connect();

        $req = 'SELECT ID FROM User WHERE nom = ? OR email = ? LIMIT 1;';
        $results = $db -> query($req, array( $login, $login ));
        
        $id = $results -> getResult()[0] -> UserID;

        return $id;
    }

    public static function isAccountValidate($login)
    {
        $db = db_connect();

        $req = 'SELECT EXISTS (SELECT * FROM RpgUser INNER JOIN RpgValidationCode ON RpgUser.UserID = RpgValidationCode.UserID WHERE UserName = ? OR UserMail = ? LIMIT 1) AS codeExists;';
        $results = $db -> query($req, array( $login, $login ));
        
        $CodeExists = $results -> getResult()[0] -> codeExists;

        return !$CodeExists;
    }

    public static function userExists($login)
    {
        $db = db_connect();

        $req = 'SELECT EXISTS (SELECT * FROM User WHERE nom = ? OR email = ?) AS "exists";';
        $results = $db -> query($req, [$login, $login]);

        $exists = $results -> getResult()[0] -> exists;

        return $exists;
    }

}