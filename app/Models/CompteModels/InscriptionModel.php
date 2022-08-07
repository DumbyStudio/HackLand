<?php

namespace App\Models\CompteModels;

class InscriptionModel
{
    public static function userIsAvailable($Pseudo, $Mail)
    {
        $db = db_connect();

        $req = 'SELECT EXISTS (SELECT * FROM User WHERE nom = :pseudo: OR email = :email:) AS "isExists";';
        $results = $db -> query($req, array(
            'pseudo' => $Pseudo,
            'email' => $Mail
        ));

        $exists = $results -> getResult()[0] -> isExists;

        return(!$exists);
    }

    public static function insertUser($identifiants)
    {
        $db = db_connect();

        $Hash = password_hash( $identifiants['password'], PASSWORD_BCRYPT );

        $req = 'INSERT INTO User (nom, email, motDePasse) VALUES ( :pseudo:, :email:, :pass: );';
        $db -> query($req, array(
            'pseudo' => $identifiants['login'],
            'email' => $identifiants['email'],
            'pass' => $Hash
        ));
    }

    public static function insertValidationCode($Pseudo, $Code)
    {
        $db = db_connect();

        $req = 'INSERT INTO RpgValidationCode (UserID, Code, CreationTime ) VALUES ( (SELECT UserID FROM RpgUser WHERE UserName = :pseudo: LIMIT 1), :code:, :currentDate:);';
        $db -> query($req, array(
            'pseudo' => $Pseudo,
            'code' => $Code,
            'currentDate' => date('Y-m-d')
        ));
    }

    public static function isCodeExists($Code)
    {
        $db = db_connect();

        $req = 'SELECT EXISTS (SELECT * FROM RpgValidationCode WHERE Code = ?) AS "isExists";';
        $results = $db -> query($req, array( $Code ));

        $exists = $results -> getResult()[0] -> isExists;

        return $exists;
    }
}