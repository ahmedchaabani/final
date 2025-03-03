<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\UserRepository;
final class User2Controller extends AbstractController
{
    #[Route('/user2', name: 'app_user2')]
    public function index(): Response
    {
        return $this->render('user2/index.html.twig', [
            'controller_name' => 'User2Controller',
        ]);
    }

    #[Route('/pie', name: 'app_pie')]
    public function dashboard(UserRepository $userRepository): Response
    {
        
        // Compter les utilisateurs par rôle
        $rolesCount = [
            'Admin' => $userRepository->countUsersByRole('ROLE_ADMIN'),
            'Client' => $userRepository->countUsersByRole('ROLE_CLIENT'),
            'User' => $userRepository->countUsersByRole('ROLE_USER'),
        ];
    
        return $this->render('user/index1.html.twig', [
            'rolesCount' => $rolesCount,
        ]);
    } 

    
}
