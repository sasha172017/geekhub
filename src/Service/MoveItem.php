<?php


namespace App\Service;


use App\Model\Database;

class MoveItem
{
    public $allCategory;
    public $allItem;
    private $item;
    private $category;

    public function __construct(Item $item, Category $category)
    {
        $this->item = $item;
        $this->category = $category;
    }

        public function move($id, $id_category){
        if ($id && $id_category) {
            $allCategory = $this->category->getCategory();
            $allItem = $this->item->getItem();
            foreach ($allItem as $item) {
                if ($id == $item->id) {
                    $item->id_category = $id_category;
                    break;
                }
            }
            $result = Database::updateItemForDatabace($allItem);
            $this->allCategory = $allCategory;
            $this->allItem = $this->item->getItem();
            return $result ? true : null;
        }
    }
}