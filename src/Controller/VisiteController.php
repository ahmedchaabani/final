<?php

namespace App\Controller;

use App\Form\VisiteType;
use App\Entity\Visite;
use App\Entity\User;
use App\Repository\VisiteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

//#[Route('/visite')]
class VisiteController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em){
        $this->em = $em;
    }

    
    #[Route('/visite', name: 'app_visite_index', methods: ['GET'])] 
    public function index(EntityManagerInterface $entityManager): Response
    {
        $visites = $entityManager->getRepository(Visite::class)->findAll();

        return $this->render('visite/index.html.twig', [
            'visites' => $visites, 
        ]);
    }

    #[Route('/visite/new', name: 'app_visite_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $visite = new Visite(); 
        $form = $this->createForm(VisiteType::class, $visite);
        $form->handleRequest($request);

        

        if ($form->isSubmitted() && $form->isValid()) {
            if ($visite->getDiagnostic() === null) {
                $visite->setDiagnostic(""); 
            }
            $entityManager->persist($visite); 
            $entityManager->flush();

            return $this->redirectToRoute('app_visite_index');
        }

        return $this->render('visite/visite.html.twig', [ 
            'visite' => $visite,
            'form' => $form->createView(),
            
            
        ]);
    }

    #[Route('/visite/{id}/edit', name: 'app_visite_edit', methods: ['GET', 'POST'])]
public function edit(Request $request, Visite $visite, EntityManagerInterface $entityManager): Response
{
    $form = $this->createForm(VisiteType::class, $visite);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $entityManager->flush();

        return $this->redirectToRoute('app_visite_index');
    }

    return $this->render('visite/edit.html.twig', [
        'visite' => $visite,
        'form' => $form->createView(),
    ]);
}
#[Route('/visite/{id}', name: 'app_visite_delete', methods: ['POST'])]
public function delete(Request $request, Visite $visite, EntityManagerInterface $entityManager): Response
{
    if ($this->isCsrfTokenValid('delete' . $visite->getId(), $request->request->get('_token'))) {
        $entityManager->remove($visite);
        $entityManager->flush();
    }

    return $this->redirectToRoute('app_visite_index');
}


#[IsGranted('ROLE_CLIENT')]
    #[Route('/visitefront', name: 'app_visite_indexf', methods: ['GET'])]
    public function indexf(VisiteRepository $VisiteRepository): Response
    {
        
        // Ensure the user is logged in
    $user = $this->getUser();
    if (!$user) {
        throw $this->createAccessDeniedException('You must be logged in to view this page.');
    }

    // Fetch analyses for the current user
    $visites = $this->em->getRepository(Visite::class)->findByUser($user);

    return $this->render('visite/indexfront.html.twig', [
        'visites' => $visites,
    ]);
    }


}
