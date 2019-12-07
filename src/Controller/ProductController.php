<?php


namespace App\Controller;

use App\Entity\Category;
use App\Entity\Product;
use App\Entity\User;
use App\Form\ProductType;
use App\Service\SendMailProduct;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;


class ProductController extends AbstractController
{
    private $validator;
    private $sendMailProduct;

    public function __construct(SendMailProduct $sendMailProduct, ValidatorInterface $validator)
    {
        $this->validator = $validator;
        $this->sendMailProduct = $sendMailProduct;
    }

    public function index()
    {

        $products = $this->getDoctrine()->getRepository(Product::class)->findAll();
        return $this->render('product/index.html.twig', [
                'products' => $products
            ]);
    }


    public function create()
    {
        $product = new Product();
        $product->setName('Product New');
//        $product->setCategory($this->getDoctrine()->getRepository(Category::class)->find(mt_rand(1, 5)));
        $product->setQty(1);
        $product->setPrice(2.5);
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest(Request::createFromGlobals());

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $imageFile */
            $imageFile = $form['image']->getData();
            if ($imageFile) {
                $newImageName = 'product-'.uniqid().'.'.$imageFile->guessExtension();
                    $imageFile->move(
                        $this->getParameter('image_product_directory'),
                        $newImageName
                    );
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($product);
            $entityManager->flush();
            $this->addFlash('success', 'Product Created!');
        }
        return $this->render('product/create.html.twig', array(
            'form' => $form->createView(),
            'formIsSubmitter' => $form->isSubmitted() && $form->isValid(),
            'errors' => $this->validator->validate($form)
        ));
    }

//    public function show($id){
//        $item = $this->getDoctrine()->getRepository(Item::class)->find($id);
//        $category = $this->getDoctrine()->getRepository(Category::class)->find($item->getIdCategory());
//        $item->category = $category->getName();
//        return $this->render('item/show.html.twig', [
//            'item' => $item
//        ]);
//    }
}