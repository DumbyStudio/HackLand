<?php

namespace App\Models\CompteModels;

class VerificationModel
{
    public static function getUserVerifCode($id)
    {
        $db = db_connect();

        $req = 'SELECT Code FROM RpgValidationCode WHERE UserID = ? LIMIT 1 ;';
        $results = $db -> query($req, array( $id ));

        $BaseCode = $results -> getResult()[0] -> Code;

        return $BaseCode;
    }

    public static function deleteCode($id)
    {
        //$req = 'UPDATE RpgUser SET IsValidate = TRUE WHERE UserID = ?;';
        //$db -> query($req, array( $id ));

        $db = db_connect();

        $req = 'DELETE FROM RpgValidationCode WHERE UserID = ?;';
        $db -> query($req, array( $id ));
    }
}