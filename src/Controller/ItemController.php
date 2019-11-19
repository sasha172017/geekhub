<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Item;
use App\Service\CreateItem;
use App\Service\Helper;
use App\Service\MoveItem;
use App\Service\SendMailItem;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ItemController extends Controller
{
    private $createItem;
    private $moveItem;
    private $helper;

    public function __construct(CreateItem $createItem, MoveItem $moveItem, SendMailItem $sendMailItem, Helper $helper)
    {
         $this->createItem = $createItem;
         $this->moveItem = $moveItem;
         $this->sendMailItem = $sendMailItem;
         $this->helper = $helper;
    }

    public function index()
    {
        return $this->render('item/index.html.twig');
    }

    public function create($name, $id_category, $price, $qty)
    {
        $result = $this->createItem->create($name, $id_category, $price, $qty);
        if($result){
//            $this->helper->fillingCategory($allCategory);
//            $this->helper->fillingItem($allItem);
//            $this->sendMailItem->sendMailCreateItem();
        }
        $allItemObject = $this->getDoctrine()->getRepository(Item::class)->findAll();
        $allCategoryObjects = $this->getDoctrine()->getRepository(Category::class)->findAll();
        $allCategory = [];
        $allItem = [];
        foreach ($allCategoryObjects as $k => $category){
            $allCategory[$k]['id'] = $category->getId();
            $allCategory[$k]['name'] = $category->getName();
        }
        foreach ($allItemObject as $k => $item){
            $allItem[$k]['id'] = $item->getId();
            $allItem[$k]['name'] = $item->getName();
            $allItem[$k]['id_category'] = $item->getIdCategory();
            $allItem[$k]['price'] = $item->getPrice();
            $allItem[$k]['qty'] = $item->getQty();
        }
        return $this->render('item/create.html.twig', [
            'allItem' => $allItem,
            'allCategory' => $allCategory
        ]);
    }

    public function move($id, $id_category)
    {
        $result = $this->moveItem->move($id, $id_category);
        if($result){
//            $this->sendMailItem->sendMailMoveItem();
        }
        $allItemObject = $this->getDoctrine()->getRepository(Item::class)->findAll();
        $allCategoryObjects = $this->getDoctrine()->getRepository(Category::class)->findAll();
        $allCategory = [];
        $allItem = [];
        foreach ($allCategoryObjects as $k => $category){
            $allCategory[$k]['id'] = $category->getId();
            $allCategory[$k]['name'] = $category->getName();
        }
        foreach ($allItemObject as $k => $item){
            $allItem[$k]['id'] = $item->getId();
            $allItem[$k]['name'] = $item->getName();
            $allItem[$k]['id_category'] = $item->getIdCategory();
            $allItem[$k]['price'] = $item->getPrice();
            $allItem[$k]['qty'] = $item->getQty();
        }
        return $this->render('item/move.html.twig', [
            'allItem' => $allItem,
            'allCategory' => $allCategory
        ]);
    }

    public function show($id){
        $item = $this->getDoctrine()->getRepository(Item::class)->find($id);
        $category = $this->getDoctrine()->getRepository(Category::class)->find($item->getIdCategory());
        $item->category = $category->getName();
        return $this->render('item/show.html.twig', [
            'item' => $item
        ]);
    }
}