<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;


class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i <= 5; $i++) {
            $category = new Category();
            $category->setName('category' . $i);
            $product = new Product();
            $product->setName('product '.$i);
            $product->setPrice(mt_rand(125.0, 5000.0));
            $product->setQty(mt_rand(2, 32));
            $product->setCategory($category);
            $manager->persist($product);
        }
        $manager->flush();




        $category = new Category();
        $category->setName('Computer Peripherals');

        $product = new Product();
        $product->setName('Keyboard');
        $product->setPrice(19.99);
        $product->setDescription('Ergonomic and stylish!');

        // relates this product to the category
        $product->setCategory($category);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($category);
        $entityManager->persist($product);
        $entityManager->flush();

    }


//    public function createProduct()
//    {
//        for ($i = 1; $i <= 10; $i++) {
//            $product = new Product();
//            $product->setName('product '.$i);
//            $product->setPrice(mt_rand(125.0, 5000.0));
//            $product->setQty(mt_rand(2, 32));
//            $manager->persist($product);
//        }
//        $manager->flush();
//    }
}
