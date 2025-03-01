<?php

namespace App\Controller;

use App\Entity\Echantillon;
use App\Entity\Analyse;
use App\Form\EchantillonType;
use App\Form\AnalyseType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Label\Font\NotoSans;
use Endroid\QrCode\Writer\PngWriter;






final class laboController extends AbstractController
{
    private $em;
    private $validator;

    public function __construct(EntityManagerInterface $em, ValidatorInterface $validator){
        $this->em = $em;
        $this->validator = $validator;
    }


    #[Route('/echantillons', name: 'app_main')]
    public function index(): Response
    {
        $echantillons = $this->em->getRepository(Echantillon::class)->findAll();
        return $this->render('labo/index.html.twig', [
            'echantillons' => $echantillons
        ]);
    }

    #[Route('/analyses', name: 'app_main1')]
    public function index1(): Response
    {
        $analyses = $this->em->getRepository(Analyse::class)->findAll();
        return $this->render('labo/index1.html.twig', [
            'analyses' => $analyses, // Make sure 'analyses' is passed
        ]);
    }


    #[Route('/create-echantillon', name: 'create-echantillon')]
public function createEchantillon(Request $request): Response
{
    $echantillon = new Echantillon();
    $form = $this->createForm(EchantillonType::class, $echantillon);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $this->em->persist($echantillon);
        $this->em->flush();
        $this->addFlash('message', 'echantillon créée avec succès');
        return $this->redirectToRoute('app_main');
    } elseif ($form->isSubmitted()) {
        $this->addFlash('error', 'Veuillez corriger les erreurs dans le formulaire');
    }

    return $this->render('labo/echantillon.html.twig', [
        'form' => $form->createView()
    ]);
}



    #[Route('/edit-echantillon/{IdE}', name:'edit-echantillon')]
    public function editEchantillon(Request $request, $IdE)
    {
        $echantillon = $this->em->getRepository(echantillon::class)->find($IdE);
        $form = $this->createForm(EchantillonType::class, $echantillon);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $this->em->persist($echantillon);
            $this->em->flush();

            $this->addFlash('message','success update');
            return $this->redirectToRoute('app_main');
        };

        return $this->render('labo/echantillon.html.twig',[
            'form' => $form->createView()
        ]);
    }

    #[Route('supp-echantillon/{IdE}', name:'supp-echantillon')]
    public function suppEchantillon($IdE)
    {
        $echantillon = $this->em->getRepository(echantillon::class)->find($IdE);
        $this->em->remove($echantillon);
        $this->em->flush();
        $this->addFlash('message','success delete');
        return $this->redirectToRoute('app_main');
    }



    #[Route('/create-analyse', name: 'create-analyse')]
public function createAnalyse(Request $request): Response
{
    $analyse = new Analyse();
    $form = $this->createForm(AnalyseType::class, $analyse);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $this->em->persist($analyse);
        $this->em->flush();
        $this->addFlash('message', 'Analyse créée avec succès');
        return $this->redirectToRoute('app_main1');
    } elseif ($form->isSubmitted()) {
        $this->addFlash('error', 'Veuillez corriger les erreurs dans le formulaire');
    }

    return $this->render('labo/analyse.html.twig', [
        'form' => $form->createView()
    ]);
}



    #[Route('/edit-analyse/{idanalyse}', name:'edit-analyse')]
    public function editanalyse(Request $request, $idanalyse)
    {
        $analyse = $this->em->getRepository(analyse::class)->find($idanalyse);
        $form = $this->createForm(AnalyseType::class, $analyse);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $this->em->persist($analyse);
            $this->em->flush();

            $this->addFlash('message','success update');
            return $this->redirectToRoute('app_main1');
        };

        return $this->render('labo/analyse.html.twig',[
            'form' => $form->createView()
        ]);
    }

    #[Route('supp-analyse/{idanalyse}', name:'supp-analyse')]
    public function suppanalyse($idanalyse)
    {
        $analyse = $this->em->getRepository(analyse::class)->find($idanalyse);
        $this->em->remove($analyse);
        $this->em->flush();
        $this->addFlash('message','success delete');
        return $this->redirectToRoute('app_main1');
    }

    #[Route('/dashboard', name: 'app_dashboard')]
    public function dashboard(): Response
    {
        $echantillons = $this->em->getRepository(Echantillon::class)->findAll();
        $analyses = $this->em->getRepository(Analyse::class)->findAll();
        
        return $this->render('labo/indexhome.html.twig', [
            'echantillons' => $echantillons,
            'analyses' => $analyses,
        ]);
    }

    // frontoffice controllers

    #[Route('/echantillonsfront', name: 'app_main_front')]
    public function indexf(): Response
    {
        $echantillons = $this->em->getRepository(Echantillon::class)->findAll();
        return $this->render('labo/front/index.html.twig', [
            'echantillons' => $echantillons
        ]);
    }

    #[IsGranted('ROLE_CLIENT')]
    #[Route('/analysesfront', name: 'app_main1_front')]
public function index1f(): Response
{
    // Ensure the user is logged in
    $user = $this->getUser();
    if (!$user) {
        throw $this->createAccessDeniedException('You must be logged in to view this page.');
    }

    // Fetch analyses for the current user
    $analyses = $this->em->getRepository(Analyse::class)->findByUser($user);

    return $this->render('labo/front/index1.html.twig', [
        'analyses' => $analyses,
    ]);
}


    #[Route('/create-echantillonfront', name: 'create-echantillonfront')]
public function createEchantillonf(Request $request): Response
{
    $echantillon = new Echantillon();
    $form = $this->createForm(EchantillonType::class, $echantillon);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $this->em->persist($echantillon);
        $this->em->flush();
        $this->addFlash('message', 'echantillon créée avec succès');
        return $this->redirectToRoute('app_mainfront');
    } elseif ($form->isSubmitted()) {
        $this->addFlash('error', 'Veuillez corriger les erreurs dans le formulaire');
    }

    return $this->render('labo/front/echantillon.html.twig', [
        'form' => $form->createView()
    ]);
}



    #[Route('/edit-echantillonfront/{IdE}', name:'edit-echantillonfront')]
    public function editEchantillonf(Request $request, $IdE)
    {
        $echantillon = $this->em->getRepository(echantillon::class)->find($IdE);
        $form = $this->createForm(EchantillonType::class, $echantillon);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $this->em->persist($echantillon);
            $this->em->flush();

            $this->addFlash('message','success update');
            return $this->redirectToRoute('app_main_front');
        };

        return $this->render('labo/front/echantillon.html.twig',[
            'form' => $form->createView()
        ]);
    }

    #[Route('supp-echantillonfront/{IdE}', name:'supp-echantillonfront')]
    public function suppEchantillonf($IdE)
    {
        $echantillon = $this->em->getRepository(echantillon::class)->find($IdE);
        $this->em->remove($echantillon);
        $this->em->flush();
        $this->addFlash('message','success delete');
        return $this->redirectToRoute('app_main_front');
    }



    #[Route('/create-analysefront', name: 'create-analysefront')]
public function createAnalysef(Request $request): Response
{
    $analyse = new Analyse();
    $form = $this->createForm(AnalyseType::class, $analyse);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $this->em->persist($analyse);
        $this->em->flush();
        $this->addFlash('message', 'Analyse créée avec succès');
        return $this->redirectToRoute('app_main1_front');
    } elseif ($form->isSubmitted()) {
        $this->addFlash('error', 'Veuillez corriger les erreurs dans le formulaire');
    }

    return $this->render('labo/front/analyse.html.twig', [
        'form' => $form->createView()
    ]);
}



    #[Route('/edit-analysefront/{idanalyse}', name:'edit-analysefront')]
    public function editanalysef(Request $request, $idanalyse)
    {
        $analyse = $this->em->getRepository(analyse::class)->find($idanalyse);
        $form = $this->createForm(AnalyseType::class, $analyse);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $this->em->persist($analyse);
            $this->em->flush();

            $this->addFlash('message','success update');
            return $this->redirectToRoute('app_main1_front');
        };

        return $this->render('labo/front/analyse.html.twig',[
            'form' => $form->createView()
        ]);
    }

    #[Route('supp-analysefront/{idanalyse}', name:'supp-analysefront')]
    public function suppanalysef($idanalyse)
    {
        $analyse = $this->em->getRepository(analyse::class)->find($idanalyse);
        $this->em->remove($analyse);
        $this->em->flush();
        $this->addFlash('message','success delete');
        return $this->redirectToRoute('app_main1_front');
    }

    #[Route('/echantillon/qr/{IdE}', name: 'generate_qr')]
    public function generateQrCode(int $IdE, EntityManagerInterface $entityManager): Response
    {
        // Fetch the echantillon from the database
        $echantillon = $entityManager->getRepository(Echantillon::class)->find($IdE);
    
        if (!$echantillon) {
            throw $this->createNotFoundException('Echantillon not found.');
        }
    
        // Prepare data for QR code
        $data = sprintf(
            "ID: %d\nCodeX: %s\nType: %s\nDate: %s\nOrigine: %s\nStatus: %s",
            $echantillon->getIdE(),
            $echantillon->getCodeX(),
            $echantillon->getTypeE(),
            $echantillon->getCollectionDate()->format('Y-m-d'),
            $echantillon->getOrigin(),
            $echantillon->getStatus()
        );
    
        // Generate QR Code
        $qrCode = Builder::create()
            ->writer(new PngWriter())
            ->data($data)
            ->encoding(new Encoding('UTF-8'))
            ->errorCorrectionLevel(ErrorCorrectionLevel::Medium)
            ->size(300)
            ->margin(10)
            ->labelText('Echantillon QR')
            ->labelFont(new NotoSans(12))
            ->build();
    
        return new Response($qrCode->getString(), Response::HTTP_OK, ['Content-Type' => 'image/png']);
    }







}

    

