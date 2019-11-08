<?php

namespace App\Controller;

use App\AllClass\CreateItem;
use App\AllClass\MoveItem;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ItemController extends Controller
{

    public function index()
    {
        return $this->render('item/index.html.twig');
    }

    public function create($name, $id_category, $price, $qty)
    {
        $params['name'] = $name;
        $params['id_category'] = $id_category;
        $params['price'] = $price;
        $params['qty'] = $qty;
        $createItem = new CreateItem($params);
        $allCategory = $createItem->allCategory;
        $allItem = $createItem->allItem;
        return $this->render('item/create.html.twig', [
            'allItem' => $allItem,
            'allCategory' => $allCategory
        ]);
    }

    public function move($id, $id_category)
    {
        $params['id'] = $id;
        $params['id_category'] = $id_category;
        $moveItem = new MoveItem($params);
        $allCategory = $moveItem->allCategory;
        $allItem = $moveItem->allItem;
        return $this->render('item/move.html.twig', [
            'allItem' => $allItem,
            'allCategory' => $allCategory
        ]);
    }
}