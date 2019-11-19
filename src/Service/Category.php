<?php


namespace App\Service;

use App\Model\Database;

class Category
{
    public function getCategory()
    {
        $category = Database::getDatabase();
        return $category->category;
    }
}
