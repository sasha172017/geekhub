<?php


namespace App\Controller;

use App\Entity\Category;
use App\Entity\Product;
use App\Entity\User;
use App\Service\SendMailProduct;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class ProductController extends AbstractController
{
    public function __construct(SendMailProduct $sendMailProduct)
    {
        $this->sendMailProduct = $sendMailProduct;
    }

    public function index()
    {
        return $this->render('item/index.html.twig');
    }


    public function createUser()
    {
        $entityManager = $this->getDoctrine()->getManager();
        for ($i = 1; $i <= 20; $i++) {
            $user = new User();
            $user->setName('user'.$i);
            $user->setPassword(md5(mt_rand(10, 50000)));
            $entityManager->persist($user);
        }
        $entityManager->flush();
    }

    public function create()
    {
        $categories = $this->getDoctrine()->getRepository(Category::class)->findAll();
        $users = $this->getDoctrine()->getRepository(User::class)->findAll();
        $entityManager = $this->getDoctrine()->getManager();
        for ($i = 11; $i <= 100; $i++) {
            $keyCategory = array_rand($categories);
            $keyUser = array_rand($users);
            $product = new Product();
            $product->setName('product '.$i);
            $product->setPrice(mt_rand(125.0, 5000.0));
            $product->setQty(mt_rand(2, 32));
            $product->setCategory($categories[$keyCategory]);
            $product->setUser($users[$keyUser]);
            $entityManager->persist($product);
        }
        $entityManager->flush();
    }

    public function product(){
        $users = $this->getDoctrine()->getRepository(User::class)->findAll();
        $categories = $this->getDoctrine()->getRepository(Category::class)->findAll();
        $products = $this->getDoctrine()->getRepository(Product::class)->findAll();

        return $this->render('product/index.html.twig', array(
            'products' => $products,
            'categories' => $categories,
            'users' => $users
        ));
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