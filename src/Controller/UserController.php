<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\User;
use App\Form\UserRegisterType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserController extends AbstractController
{

    public function index()
    {
        $users = $this->getDoctrine()->getRepository(User::class)->findAll();
        return $this->render('user/index.html.twig', [
            'idUser' => 21,
            'users' => $users,
        ]);
    }

    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, ValidatorInterface $validator){
        $user = new User();
        $form = $this->createForm(UserRegisterType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $user->setPassword($passwordEncoder->encodePassword($user, $user->getPlainPassword()));
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            $this->addFlash('success', 'You  Registered');
        }
//        $a = get_class_methods($validator);
        return $this->render('user/register.html.twig', [
            'formIsSubmitter' => $form->isSubmitted() && $form->isValid(),
            'form' => $form->createView(),
            'errors' => $validator->validate($form)
        ]);
    }

    public function likeUser($id){
        $user = $this->getUser();
        $userLike = $this->getDoctrine()->getRepository(User::class)->find($id);
        if (!$user || !$userLike) {
            throw $this->createNotFoundException(
                'error'
            );
        }
        $em = $this->getDoctrine()->getManager();
        $user->addFavoriteUser($userLike);
        $em->persist($user);
        $em->flush();
        $request = Request::createFromGlobals();
        $url = $request->server->get('HTTP_REFERER');
        return $this->redirect($url);
    }

    public function likeProduct($id){
        $user = $this->getUser();
        $likeProduct = $this->getDoctrine()->getRepository(Product::class)->find($id);
        if (!$user || !$likeProduct) {
            throw $this->createNotFoundException(
                'error'
            );
        }
        $em = $this->getDoctrine()->getManager();
        $user->addFavoriteProduct($likeProduct);
        $em->persist($user);
        $em->flush();
        $request = Request::createFromGlobals();
        $url = $request->server->get('HTTP_REFERER');
        return $this->redirect($url);
    }

    public function favoriteProduct()
    {

        return $this->render('user/favoriteProduct.html.twig', [
            'products' => $this->getUser()->getFavoriteProducts(),
        ]);
    }

    public function favoriteUser()
    {
        return $this->render('user/favoriteUser.html.twig', [
            'users' => $this->getUser()->getFavoriteUsers(),
        ]);
    }

    public function favoriteUserDelete($idFavoriteUser)
    {
        $user = $this->getUser();
        $favoriteUser = $this->getDoctrine()->getRepository(User::class)->find($idFavoriteUser);
        if (!$user && !$favoriteUser) {
            throw $this->createNotFoundException(
                'error'
            );
        }
        $em = $this->getDoctrine()->getManager();
        $user->removeFavoriteUser($favoriteUser);
        $em->persist($user);
        $em->flush();
        $request = Request::createFromGlobals();
        $url = $request->server->get('HTTP_REFERER');


        return $this->redirect($url);
    }
}
