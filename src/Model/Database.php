<?php


namespace App\Model;


class Database
{
    public static function getDatabase(){
        $jsonString = file_get_contents(__DIR__ . "/../../data/database.json");
        return json_decode($jsonString);
    }

    public static function updateItemForDatabace($array){
        $object = self::getDatabase();
        $object->item = $array;
        $jsonString = json_encode($object, JSON_PRETTY_PRINT);
        file_put_contents(__DIR__ . "/../../data/database.json", $jsonString);
    }
}