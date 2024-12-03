<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    #[Route('/user/register', name: 'app_user_register')]
    public function register(
        Request $request,
        UserRepository $userRepository): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Ici, le mot de passe est directement stocké en texte clair
            // Nous ne hachons pas le mot de passe dans ce cas.
            
            // Sauvegarde de l'utilisateur
            $userRepository->save($user);

            // Redirection ou message de succès après l'enregistrement
            return $this->render('user/register.html.twig', [
                'insertion' => 'Utilisateur inscrit avec succès !'
            ]);
        }

        return $this->render('user/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
