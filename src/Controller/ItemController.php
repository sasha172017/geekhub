<?php

namespace App\Controller;

use App\Service\CreateItem;
use App\Service\MoveItem;
use App\Service\SendMailItem;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ItemController extends Controller
{
    private $createItem;
    private $moveItem;

    public function __construct(CreateItem $createItem, MoveItem $moveItem, SendMailItem $sendMailItem)
    {
         $this->createItem = $createItem;
         $this->moveItem = $moveItem;
         $this->sendMailItem = $sendMailItem;
    }

    public function index()
    {
        return $this->render('item/index.html.twig');
    }

    public function create($name, $id_category, $price, $qty)
    {

        $result = $this->createItem->create($name, $id_category, $price, $qty);
        $allCategory = $this->createItem->allCategory;
        $allItem = $this->createItem->allItem;
        if($result){
            $this->sendMailItem->sendMailCreateItem();
        }
        return $this->render('item/create.html.twig', [
            'allItem' => $allItem,
            'allCategory' => $allCategory
        ]);
    }

    public function move($id, $id_category)
    {
        $result = $this->moveItem->move($id, $id_category);
        $allCategory = $this->moveItem->allCategory;
        $allItem = $this->moveItem->allItem;
        if($result){
            $this->sendMailItem->sendMailMoveItem();
        }
        return $this->render('item/move.html.twig', [
            'allItem' => $allItem,
            'allCategory' => $allCategory
        ]);
    }
}