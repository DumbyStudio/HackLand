<?php

namespace App\Models\CompteModels;

use \App\Models\CompteModels\CompteModel;

class ConnexionModel
{

    public static function getUserPassword($login)
    {
        $db = db_connect();
        $req = 'SELECT UserHash FROM RpgUser WHERE UserName = ? OR UserMail = ? LIMIT 1;';
        $results = $db -> query($req, array( $login, $login ));
        $userHash = $results -> getResult()[0] -> UserHash;
        return $userHash;
    }

    public static function getUserTempHash($login)
    {
        $db = db_connect();
        $req = 'SELECT HashMdp FROM RpgUser INNER JOIN RpgTempHash ON RpgUser.UserID = RpgTempHash.UserID WHERE UserName = ? OR UserMail = ? LIMIT 1;';
        $results = $db -> query($req, array( $login, $login ));
        $tempHash = $results -> getResult()[0] -> HashMdp;
        return $tempHash;
    }

    public static function userAsTempHash($login)
    {
        $db = db_connect();
        $req = 'SELECT EXISTS (SELECT * FROM RpgUser INNER JOIN RpgTempHash ON RpgUser.UserID = RpgTempHash.UserID WHERE UserName = ? OR UserMail = ? LIMIT 1 ) AS "exists";';
        $results = $db -> query($req, array( $login, $login ));
        $asTempHash = $results -> getResult()[0] -> exists;
        return $asTempHash;
    }

    public static function deleteTempHash($login)
    {
        $db = db_connect();
        $id = CompteModel::getUserId($login);
        $req = 'DELETE FROM RpgTempHash WHERE UserID = ?;';
        $db -> query($req, array( $id ));
    }
}