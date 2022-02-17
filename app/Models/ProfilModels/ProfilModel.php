<?php

namespace App\Models\ProfilModels;

use \App\Models\CompteModels\CompteModel;

class ProfilModel
{

    public static function getMyCharacters()
    {
        $db = db_connect();
        $id = CompteModel::getUserId($_SESSION['account']);
        $req = "SELECT RpgCharacter.CharacterName, RpgCharacter.CharacterDescription FROM RpgCharacter LEFT JOIN RpgNonPlayerCharacter ON RpgCharacter.CreatorID = RpgNonPlayerCharacter.CreatorID AND RpgCharacter.CharacterName = RpgNonPlayerCharacter.NpcName WHERE RpgCharacter.CreatorID = ? AND RpgNonPlayerCharacter.CreatorID IS NULL;";
        $results = $db -> query($req, [ $id ]);
        $results = $results -> getResult();

        return $results;
    }

    public static function getSubbedCharacters()
    {
        $db = db_connect();
        $id = CompteModel::getUserId($_SESSION['account']);
        $req = "SELECT RpgCharacter.CharacterName, RpgCharacter.CharacterDescription FROM RpgSubbedCharacter INNER JOIN RpgCharacter ON RpgSubbedCharacter.CreatorID = RpgCharacter.CreatorID AND RpgSubbedCharacter.CharacterName = RpgCharacter.CharacterName LEFT JOIN RpgNonPlayerCharacter ON RpgCharacter.CreatorID = RpgNonPlayerCharacter.CreatorID AND RpgCharacter.CharacterName = RpgNonPlayerCharacter.NpcName WHERE RpgSubbedCharacter.UserID = ? AND RpgNonPlayerCharacter.CreatorID IS NULL;";
        $results = $db -> query($req, [ $id ]);
        $results = $results -> getResult();

        return $results;
    }

    public static function getMyNpcs()
    {
        $db = db_connect();
        $id = CompteModel::getUserId($_SESSION['account']);
        $req = "SELECT RpgCharacter.CharacterName, RpgCharacter.CharacterDescription FROM RpgCharacter INNER JOIN RpgNonPlayerCharacter ON RpgCharacter.CreatorID = RpgNonPlayerCharacter.CreatorID AND RpgCharacter.CharacterName = RpgNonPlayerCharacter.NpcName WHERE RpgCharacter.CreatorID = ?;";
        $results = $db -> query($req, [ $id ]);
        $results = $results -> getResult();

        return $results;
    }

    public static function deleteCharacter($data)
    {
        $db = db_connect();
        $name = $data['name'];
        $db = db_connect();
        $id = CompteModel::getUserId($_SESSION['account']);
        
        $req = 'DELETE FROM RpgSubbedCharacter WHERE CreatorID = ? AND CharacterName = ?;';
        $db -> query($req, array( $id, $name ));

        if(characterIsBeingUsed($creator, $name))
        {
            $req = 'UPDATE RpgCharacter SET IsPublic = 0 WHERE CreatorID = ? AND CharacterName = ?;';
            $db -> query($req, array( $id, $name ));
            $req = 'UPDATE RpgCharacter SET IsToDelete = 1 WHERE CreatorID = ? AND CharacterName = ?;';
            $db -> query($req, array( $id, $name ));
        }
        else
        {
            $req = 'DELETE FROM RpgCharacter WHERE CreatorID = ? AND CharacterName = ?;';
            $db -> query($req, array( $id, $name ));
        }
    }

    private static function characterIsBeingUsed($creator, $name)
    {
        $db = db_connect();
        $req = 'SELECT EXISTS(SELECT * FROM RpgPlayingUser WHERE CharacterCreatorID = ? AND CharacterName = ? LIMIT 1) AS "exists";';
        $results = $db -> query($req, [$creator, $name]);

        $exists = $results -> getResult()[0] -> exists;

        return $exists;
    }

    public static function deleteMap($data)
    {
        $name = $data['name'];
        $db = db_connect();
        $id = CompteModel::getUserId($_SESSION['account']);

        $req = 'DELETE FROM RpgSubbedMap WHERE CreatorID = ? AND MapName = ?;';
        $db -> query($req, array( $id, $name ));
        
        if(mapIsBeingUsed($id, $name))
        {
            $req = 'UPDATE RpgMap SET IsPublic = 0 WHERE CreatorID = ? AND MapName = ?;';
            $db -> query($req, array( $id, $name ));
            $req = 'UPDATE RpgMap SET IsToDelete = 1 WHERE CreatorID = ? AND MapName = ?;';
            $db -> query($req, array( $id, $name ));
        }
        else
        {
            $req = 'DELETE FROM RpgMap WHERE CreatorID = ? AND MapName = ?;';
            $db -> query($req, array( $id, $name ));
        }
    }

    private static function mapIsBeingUsed($creator, $name)
    {
        $db = db_connect();
        $req = "SELECT EXISTS(SELECT * FROM RpgGame INNER JOIN RpgQuest ON 
        RpgGame.QuestCreatorID = RpgQuest.CreatorID AND RpgGame.QuestName = RpgQuest.QuestName 
        WHERE MapCreatorID = ? AND MapName = ? LIMIT 1) AS 'exists';";
        $results = $db -> query($req, [$creator, $name]);

        $exists = $results -> getResult()[0] -> exists;
        return $exists;
    }

    public static function deleteQuest($data)
    {
        $name = $data['name'];
        $db = db_connect();
        $id = CompteModel::getUserId($_SESSION['account']); //TODO ajout du système de suppression à retardement si la quete est en cours d'utilisation + bloquage de la quete
        
        $req = 'DELETE FROM RpgSubbedQuest WHERE CreatorID = ? AND QuestName = ?;';
        $db -> query($req, array( $id, $name ));

        if(questIsBeingUsed($id, $name))
        {
            $req = 'UPDATE RpgQuest SET IsPublic = 0 WHERE CreatorID = ? AND QuestName = ?;';
            $db -> query($req, array( $id, $name ));
            $req = 'UPDATE RpgQuest SET IsToDelete = 1 WHERE CreatorID = ? AND QuestName = ?;';
            $db -> query($req, array( $id, $name ));
        }
        else
        {
            $req = 'DELETE FROM RpgQuest WHERE CreatorID = ? AND QuestName = ?;';
            $db -> query($req, array( $id, $name ));
        }
    }

    private static function questIsBeingUsed($creator, $name)
    {
        $db = db_connect();
        $req = "SELECT EXISTS(SELECT * FROM RpgGame WHERE QuestCreatorID = ? AND QuestName = ? LIMIT 1) AS 'exists';";
        $results = $db -> query($req, [$creator, $name]);

        $exists = $results -> getResult()[0] -> exists;
        return $exists;
    }

    public static function deleteNpc($data)
    {
        $name = $data['name'];
        $db = db_connect();
        $id = CompteModel::getUserId($_SESSION['account']);
        
        $req = 'DELETE FROM RpgSubbedNonPlayerCharacter WHERE CreatorID = ? AND NpcName = ?;';
        $db -> query($req, array( $id, $name ));
        $req = 'DELETE FROM RpgNpcFigureIn WHERE NpcCreatorID = ? AND NpcName = ?;';
        $db -> query($req, array( $id, $name ));

        if(npcIsBeingUsed($id, $name))
        {
            $req = 'UPDATE RpgCharacter SET IsPublic = 0 WHERE CreatorID = ? AND NpcName = ?;';
            $db -> query($req, array( $id, $name ));
            $req = 'UPDATE RpgCharacter SET IsToDelete = 1 WHERE CreatorID = ? AND NpcName = ?;';
            $db -> query($req, array( $id, $name ));
        }
        else
        {
            $req = 'DELETE FROM RpgNonPlayerCharacter WHERE CreatorID = ? AND NpcName = ?;';
            $db -> query($req, array( $id, $name ));
            $req = 'DELETE FROM RpgCharacter WHERE CreatorID = ? AND NpcName = ?;';
            $db -> query($req, array( $id, $name ));
        }
    }

    private static function npcIsBeingUsed($creator, $name)
    {
        $db = db_connect();
        $req = 'SELECT EXISTS(SELECT * FROM RpgPlayingNpc WHERE NpcCreatorID = ? AND NpcName = ? LIMIT 1) AS "exists";';
        $results = $db -> query($req, [$creator, $name]);

        $exists = $results -> getResult()[0] -> exists;

        return $exists;
    }

    public static function unsubCharacter($data)
    {
        $db = db_connect();
        $myId = CompteModel::getUserId($_SESSION['account']);
        $creatorId = CompteModel::getUserId($data['creator']);
        $req = 'DELETE FROM RpgSubbedCharacter WHERE UserID = ? AND CreatorID = ? AND CharacterName = ?;';
        $db -> query($req, array( $myId, $creatorId, $data['name'] ));
    }

    public static function unsubMap($data)
    {
        $db = db_connect();
        $myId = CompteModel::getUserId($_SESSION['account']);
        $creatorId = CompteModel::getUserId($data['creator']);
        $req = 'DELETE FROM RpgSubbedMap WHERE UserID = ? AND CreatorID = ? AND MapName = ?;';
        $db -> query($req, array( $myId, $creatorId, $data['name'] ));
    }

    public static function unsubQuest($data)
    {
        $db = db_connect();
        $myId = CompteModel::getUserId($_SESSION['account']);
        $creatorId = CompteModel::getUserId($data['creator']);
        $req = 'DELETE FROM RpgSubbedQuest WHERE UserID = ? AND CreatorID = ? AND QuestName = ?;';
        $db -> query($req, array( $myId, $creatorId, $data['name'] ));
    }

    public static function unsubNpc($data)
    {
        $db = db_connect();
        $myId = CompteModel::getUserId($_SESSION['account']);
        $creatorId = CompteModel::getUserId($data['creator']);
        $req = 'DELETE FROM RpgSubbedNonPlayerCharacter WHERE UserID = ? AND CreatorID = ? AND NpcName = ?;';
        $db -> query($req, array( $myId, $creatorId, $data['name'] ));
    }

}