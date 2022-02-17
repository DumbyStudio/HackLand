<?php

namespace App\Models\CompteModels;

class IdentifiantsModel
{
    public static function insertTemporaryPassword($Pseudo, $Password)
    {
        $db = db_connect();

        $req = 'SELECT EXISTS ( SELECT * FROM RpgTempHash INNER JOIN RpgUser ON RpgTempHash.UserID = RpgUser.UserID WHERE UserName = :pseudo: LIMIT 1) AS "exists";';
        $results = $db -> query($req, array( 'pseudo' => $Pseudo ));
        $AsTempHash = $results -> getResult()[0] -> exists;

        if($AsTempHash)
        {
            $req = 'UPDATE RpgTempHash SET HashMdp = :pass:, CreationTime = :currentDate: WHERE UserID = ( SELECT UserID FROM RpgUser WHERE UserName = :pseudo: LIMIT 1 );';
            $db -> query($req, array(
                'pseudo' => $Pseudo,
                'pass' => password_hash($Password, PASSWORD_BCRYPT),
                'currentDate' => date('Y-m-d H:i:s')
            ));
        }
        else
        {
            $req = 'INSERT INTO RpgTempHash (UserID, HashMdp, CreationTime ) VALUES ( (SELECT UserID FROM RpgUser WHERE UserName = :pseudo: LIMIT 1), :pass:, :currentDate:);';
            $db -> query($req, array(
                'pseudo' => $Pseudo,
                'pass' => password_hash($Password, PASSWORD_BCRYPT),
                'currentDate' => date('Y-m-d H:i:s')
            ));
        }
    }
}