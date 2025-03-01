<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Form\ProduitType;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;





/*#[Route('/produit')]*/
class ProduitController extends AbstractController
{

    private $em;

    public function __construct(EntityManagerInterface $em){
        $this->em = $em;
    }

    
    #[Route('/produits', name: 'app_produit_index', methods: ['GET'])]
    public function index(ProduitRepository $produitRepository): Response
    {
        return $this->render('produit/index.html.twig', [
            'produits' => $produitRepository->findAll(),
        ]);
    }

    #[Route('/produit/new', name: 'app_produit_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, ValidatorInterface $validator): Response
    {
        $produit = new Produit();
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            // Perform validation
            $errors = $validator->validate($produit);
            if (count($errors) > 0) {
                // If there are errors, render the form with error messages
                return $this->render('produit/new.html.twig', [
                    'produit' => $produit,
                    'form' => $form->createView(),
                    'errors' => $errors,
                ]);
            }

            // Persist the valid entity
            if ($form->isValid()) {
                $entityManager->persist($produit);
                $entityManager->flush();

                return $this->redirectToRoute('app_produit_index', [], Response::HTTP_SEE_OTHER);
            }
        }

        return $this->render('produit/new.html.twig', [
            'produit' => $produit,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/produit/{id}', name: 'app_produit_show', methods: ['GET'])]
    public function show(Produit $produit): Response
    {
        return $this->render('produit/show.html.twig', [
            'produit' => $produit,
        ]);
    }

    #[Route('/produit/{id}/edit', name: 'app_produit_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Produit $produit, EntityManagerInterface $entityManager, ValidatorInterface $validator): Response
    {
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            // Perform validation
            $errors = $validator->validate($produit);
            if (count($errors) > 0) {
                // If there are errors, render the form with error messages
                return $this->render('produit/edit.html.twig', [
                    'produit' => $produit,
                    'form' => $form->createView(),
                    'errors' => $errors,
                ]);
            }

            // Persist the valid entity
            if ($form->isValid()) {
                $entityManager->flush();

                return $this->redirectToRoute('app_produit_index', [], Response::HTTP_SEE_OTHER);
            }
        }

        return $this->render('produit/edit.html.twig', [
            'produit' => $produit,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/produit/{id}', name: 'app_produit_delete', methods: ['POST'])]
    public function delete(Request $request, Produit $produit, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$produit->getId(), $request->get('_token'))) {
            $entityManager->remove($produit);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_produit_index', [], Response::HTTP_SEE_OTHER);
    }

    
    #[Route('/produitsfront', name: 'app_produit_indexf', methods: ['GET'])]
    public function indexf(ProduitRepository $produitRepository): Response
    {
        
        // Ensure the user is logged in
    $user = $this->getUser();
    if (!$user) {
        throw $this->createAccessDeniedException('You must be logged in to view this page.');
    }

    // Fetch analyses for the current user
    $produits = $this->em->getRepository(Produit::class)->findByUser($user);

    return $this->render('produit/indexfront.html.twig', [
        'produits' => $produits,
    ]);
    }


    

    
}
