<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use DateTimeInterface;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
//        for ($i = 1; $i <= 30; $i++) {
//            $user = new User();
//            $user->setName('user' . $i);
//            $user->setPassword(md5($i));
//            $user->setMale(mt_rand(0, 1));
//            $user->setTarget(mt_rand(0, 1));
//            $date = new \DateTime();
//            $user->setDateOfBirth($date->setDate(mt_rand(1990, 2005), mt_rand(1, 12), mt_rand(1, 28)));
//            $manager->persist($user);
//        }
//        $manager->flush();


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
