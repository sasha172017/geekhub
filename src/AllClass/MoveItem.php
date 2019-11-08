<?php


namespace App\AllClass;


use App\Model\Database;

class MoveItem
{
    public $allCategory;
    public $allItem;
    public static $error = false;

    public function __construct(array $params = null)
    {
        if ($params['id'] && $params['id_category']) {
            $item = new Item();
            $category = new Category();
            $allCategory = $category->getCategory();
            $allItem = $item->getItem();
            foreach ($allItem as $it) {
                if ($params['id'] == $it->id) {
                    $it->id_category = $params['id_category'];
                    break;
                }
            }
            Database::updateItemForDatabace($allItem);
            $this->allCategory = $allCategory;
            $this->allItem = $item->getItem();
        } else {
            self::$error = true;
        }
    }
}