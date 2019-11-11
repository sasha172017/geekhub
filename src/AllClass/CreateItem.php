<?php


namespace App\AllClass;


use App\Model\Database;

class CreateItem
{
    public $allCategory;
    public $allItem;
    public static $error = false;

    public function __construct($params = null)
    {
        $item = new Item();
        $category = new Category();
        $this->allCategory = $category->getCategory();
        $this->allItem = $item->getItem();
        if ($params['name'] && $params['id_category'] && $params['price'] && $params['qty']) {
            $item->name = $params['name'];
            $item->id_category = $params['id_category'];
            $item->price = $params['price'];
            $item->qty = $params['qty'];
            $item->setId($this->allItem);
            $this->allItem[] = $item;
            Database::updateItemForDatabace($this->allItem);
        } else {
            self::$error = true;
        }
    }

}