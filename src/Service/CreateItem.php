<?php


namespace App\Service;



use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CreateItem extends AbstractController
{

    public function create($name, $id_category, $price, $qty)
    {
        if ($name && $id_category && $price && $qty) {
            $entityManager = $this->getDoctrine()->getManager();
            $item = new \App\Entity\Item();
            $item->setName($name);
            $item->setIdCategory($id_category);
            $item->setPrice($price);
            $item->setQty($qty);
            $entityManager->persist($item);
            $entityManager->flush();
        }
    }

}