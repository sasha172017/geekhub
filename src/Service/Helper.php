<?php


namespace App\Service;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class Helper extends AbstractController
{
    public function fillingCategory($allCategory){
        $entityManager = $this->getDoctrine()->getManager();
        foreach ($allCategory as $cat){
            $category = new \App\Entity\Category();
            $category->setName($cat->name);
            $entityManager->persist($category);
        }
        $entityManager->flush();
    }

    public function fillingItem($allItem){
        $entityManager = $this->getDoctrine()->getManager();
        foreach ($allItem as $it){
            $item = new \App\Entity\Item();
            $item->setName($it->name);
            $item->setIdCategory($it->id_category);
            $item->setPrice($it->price);
            $item->setQty($it->qty);
            $entityManager->persist($item);
        }
        $entityManager->flush();
    }

}