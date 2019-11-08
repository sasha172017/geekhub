<?php


namespace App\AllClass;

use App\Model\Database;

class Item
{
    public $id;
    public $name;
    public $id_category;
    public $price;
    public $qty;

    public function setId(array $array)
    {
        $maxId = 0;
        foreach ($array as $item) {
            if ($item->id > $maxId) {
                $maxId = $item->id;
            }
        }
        $this->id = $maxId + 1;
    }

    public function getItem()
    {
        return Database::getDatabase()->item;
    }

}
