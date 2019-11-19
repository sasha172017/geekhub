<?php


namespace App\Service;


use App\Model\Database;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MoveItem extends AbstractController
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
                $entityManager = $this->getDoctrine()->getManager();
                $item = $entityManager->getRepository(\App\Entity\Item::class)->find($id);
                $item->setIdCategory($id_category);
                $entityManager->flush();
            }
            return true;
        }
}