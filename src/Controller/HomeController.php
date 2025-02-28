<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/front', name: 'index')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig');
    }

    #[Route('/front2', name: 'index2')]
    public function index2(): Response
    {
    // Retrieve the current user, or ensure you pass a valid user object
    $user = $this->getUser(); // If using Symfony's built-in security component

    return $this->render('home/index2.html.twig', [
        'user' => $user,
    ]);
}

}
