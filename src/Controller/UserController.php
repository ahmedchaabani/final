<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

#[Route('/user')]
final class UserController extends AbstractController
{
    #[Route('/', name: 'app_user_index', methods: ['GET'])]
    public function index(Request $request, UserRepository $userRepository): Response
    {
        // Récupérer les paramètres de la requête
        $verified = $request->query->get('verified'); // Paramètre de vérification (1 ou 0)
        $name = $request->query->get('name', ''); // Recherche par nom (par défaut vide)
    
        // Créer un tableau de critères pour la recherche
        $criteria = [];
    
        if ($verified !== null) {
            // Si un filtre "verified" est passé, nous l'ajoutons aux critères
            $criteria['isVerified'] = (bool) $verified;
        }
    
        if (!empty($name)) {
            // Si un nom est passé, ajoutez-le également comme critère de recherche
            $users = $userRepository->searchByNameAndStatus($name, $criteria['isVerified'] ?? null);
        } else {
            // Sinon, si aucun nom n'est fourni, nous appliquons seulement le filtre de vérification
            $users = $userRepository->findBy($criteria);
        }
    
        return $this->render('user/index.html.twig', [
            'users' => $users,
        ]);
    }

    #[Route('/new', name: 'app_user_new', methods: ['GET', 'POST'])]
    public function new(
        
        Request $request, 
        UserPasswordHasherInterface $passwordHasher,
        EntityManagerInterface $entityManager
    ): Response {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        
    
        if ($form->isSubmitted() && $form->isValid()) {
            // Récupération et hachage du mot de passe
            $plainPassword = $form->get('plainPassword')->getData();
            $user->setPassword(
                $passwordHasher->hashPassword($user, $plainPassword)
            );
    
            // Définir la date d'inscription
            $user->setDateInscription(new \DateTime());
    
            // Définir un rôle par défaut si nécessaire
            if (empty($user->getRoles())) {
                $user->setRoles(['ROLE_CLIENT']);
            }
    
            $entityManager->persist($user);
            $entityManager->flush();
            
    
            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }
    
        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_user_show', methods: ['GET'])]
public function show(User $user): Response
{
    // Back office show (with "back to list" link)
    return $this->render('user/show.html.twig', [
        'user' => $user,
    ]);
}

#[Route('/front/{id}', name: 'app_user_showw', methods: ['GET'])]
public function showFront(User $user): Response
{
    // Front office show (without "back to list" link)
    return $this->render('user/front/showw.html.twig', [
        'user' => $user,
    ]);
}

    #[Route('/{id}/edit', name: 'app_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

   

    #[Route('/front/{id}/edit', name: 'app_user_edit2', methods: ['GET', 'POST'])]
    public function editFront(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        // Create the form WITHOUT the 'include_roles' option
        $form = $this->createForm(UserType::class, $user);
    
        // Remove the 'roles' field from the form
        $form->remove('roles');
    
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {

            
            $entityManager->flush();
            return $this->redirectToRoute('app_user_showw', ['id' => $user->getId()], Response::HTTP_SEE_OTHER);
        }
    
        return $this->render('user/front/edit2.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/filter', name: 'filter', methods: ['GET'])]
    public function getUsersByStatus(Request $request, UserRepository $userRepository): JsonResponse
    {
        $verified = $request->query->getBoolean('verified');
        $users = $userRepository->findBy(['verified' => $verified]);

        return $this->json($users);
    }

    #[Route('/search', name: 'search', methods: ['GET'])]
    public function searchUsers(Request $request, UserRepository $userRepository): JsonResponse
    {
        $name = $request->query->get('name', '');
        $verified = $request->query->getBoolean('verified');

        $users = $userRepository->searchByNameAndStatus($name, $verified);

        return $this->json($users);
    }


    


}
