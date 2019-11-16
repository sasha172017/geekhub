<?php


namespace App\Service;


use App\Model\Database;

class CreateItem
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


    public function create($name, $id_category, $price, $qty)
    {
        $this->allCategory = $this->category->getCategory();
        $this->allItem = $this->item->getItem();
        if ($name && $id_category && $price && $qty) {
            $this->item->name = $name;
            $this->item->id_category = $id_category;
            $this->item->price = $price;
            $this->item->qty = $qty;
            $this->item->setId($this->allItem);
            $this->allItem[] = $this->item;
            return Database::updateItemForDatabace($this->allItem) ? true : null;
        }
    }

}