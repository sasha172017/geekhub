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

    public function register(UserPasswordEncoderInterface $passwordEncoder, ValidatorInterface $validator){
        $user = new User();
        $errors = null;
        $form = $this->createForm(UserRegisterType::class, $user);
        $form->handleRequest(Request::createFromGlobals());
        if($form->isSubmitted() && $form->isValid()){
            $errors = $validator->validate($user);
            if ($form->isValid()){
                $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
                $user->setPassword($password);
                $user->setTarget(0);
                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();

            }
        }
        return $this->render('user/register.html.twig', [
            'form' => $form->createView(),
            'errors' => $errors
        ]);
    }

    public function likeUser($id){
        $idUser = 21;
        $user = $this->getDoctrine()->getRepository(User::class)->find($idUser);
        $userLike = $this->getDoctrine()->getRepository(User::class)->find($id);
        if (!$userLike) {
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
        $idUser = 21;
        $user = $this->getDoctrine()->getRepository(User::class)->find($idUser);
        $likeProduct = $this->getDoctrine()->getRepository(Product::class)->find($id);
        if (!$likeProduct) {
            throw $this->createNotFoundException(
                'error'
            );
        }
        $em = $this->getDoctrine()->getManager();
//        $user->addFavo
        $user->addFavoriteProduct($likeProduct);
        $em->persist($user);
        $em->flush();
        $request = Request::createFromGlobals();
        $url = $request->server->get('HTTP_REFERER');
        return $this->redirect($url);
    }

    public function favoriteProduct($id)
    {

        return $this->render('user/favoriteProduct.html.twig', [
            'products' => $this->getDoctrine()->getRepository(User::class)->find($id)->getFavoriteProducts(),
        ]);
    }

    public function favoriteUser($id)
    {

        return $this->render('user/favoriteUser.html.twig', [
            'id' => $id,
            'users' => $this->getDoctrine()->getRepository(User::class)->find($id)->getFavoriteUsers(),
        ]);
    }

    public function favoriteUserDelete($idUser, $idFavoriteUser)
    {
        $user = $this->getDoctrine()->getRepository(User::class)->find($idUser);
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
