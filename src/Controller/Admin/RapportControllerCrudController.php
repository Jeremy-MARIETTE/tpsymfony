<?php

namespace App\Controller\Admin;

use APP\Service\Pdf;
use Dompdf\Dompdf;
use App\Entity\Site;
use App\Entity\User;
use Twig\Environment;
use App\Entity\Rapport;
use App\Entity\Entreprise;
use App\Form\Rapport1Type;
use App\Repository\SiteRepository;
use App\Repository\UserRepository;
use App\Repository\PosteRepository;
use App\Repository\RapportRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('admin/rapport/controller/crud')]
class RapportControllerCrudController extends AbstractController
{
    
    private $entityManager;
   

    public function __construct(EntityManagerInterface $entityManager)
    {
      
        $this->entityManager = $entityManager;
        
    }
    #[Route('/', name: 'app_rapport_controller_crud_index', methods: ['GET'])]
    public function index(RapportRepository $rapportRepository, SiteRepository $siteRepository, UserRepository $userRepository, PosteRepository $posteRepository): Response
    {
        if($this->getUser()->getRoles()[0] == 'ROLE_EMPLOYE'){
           $rapports = $rapportRepository->findBy(['token' => $this->getUser()->getToken(), 'auteur' => $this->getUser()->getId()]);
        }
        if($this->getUser()->getRoles()[0] == 'ROLE_UTILISATEUR'){
            $agentId = $this->getUser()->getId();
            
            // Récupérer les sites associés à l'agent
            $sites = $posteRepository->findBy(['agent' => $agentId]);
            $idSite = $sites[0]->getSite()->getId();
            $rapports = $rapportRepository->findBy(['site' => $idSite]);
         }
         if($this->getUser()->getRoles()[0] == 'ROLE_USER'){
            $rapports = $rapportRepository->findBy(['token' => $this->getUser()->getToken()]);
         }
   
            return $this->render('rapport_controller_crud/index.html.twig', [
                //faire une jointure pour afficher le nom du site et de l'entreprise
          
                'rapports' => $rapports,
                'sites' => $siteRepository->findBy(['token' => $this->getUser()->getToken()]),
                'auteurs' => $userRepository->findBy(['token' => $this->getUser()->getToken()]),
            ]);

            

            
       
            return $this->render('rapport_controller_crud/index.html.twig', [
                //faire une jointure pour afficher le nom du site et de l'entreprise
          
            ]);
        
      
    }
    #[Route('/pdf/{id}',  name: 'app_rapport_pdf', methods: ['GET'])]
    public function rapportPdf(): Response
    {
        $dompdf = new Dompdf();
        //je veux récupérer le rapport associé à l'id

        $dompdf->loadHtml('Hello World !');
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
    
        $output = $dompdf->output();
    
        return new Response(
            $output,
            Response::HTTP_OK,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="rapport.pdf"',
                'Pragma' => 'public',
                'Cache-Control' => 'public, must-revalidate',
                'Content-Transfer-Encoding' => 'binary',
            ]
        );
    }




    #[Route('/new', name: 'app_rapport_controller_crud_new', methods: ['GET', 'POST'])]
    public function new(Request $request, RapportRepository $rapportRepository, Security $security): Response
    {
        $rapport = new Rapport();
        $rapport->setAuteur($security->getUser()->getId());
        $form = $this->createForm(Rapport1Type::class, $rapport);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $rapportRepository->save($rapport, true);

            return $this->redirectToRoute('app_rapport_controller_crud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('rapport_controller_crud/new.html.twig', [
            'rapport' => $rapport,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_rapport_controller_crud_show', methods: ['GET'])]
    public function show(Rapport $rapport, Security $security, EntityManagerInterface $entityManager): Response
    {
        $userRepository = $entityManager->getRepository(User::class);
        $user = $userRepository->findBy(['id' => $rapport->getAuteur()]);

        //find site by id
        $siteRepository = $entityManager->getRepository(Site::class);
        $site = $siteRepository->findBy(['id' => $rapport->getSite()]);

        //find entreprise by token
        $entrepriseRepository = $entityManager->getRepository(Entreprise::class);
        $entreprise = $entrepriseRepository->findBy(['idGerant' => $rapport->getToken()]);

      

        return $this->render('rapport_controller_crud/show.html.twig', [
            'rapport' => $rapport,
            'user' => $user,
            'site' => $site,
            'entreprise' => $entreprise,
        ]);
   
    }
  /*
    #[Route('/{id}/edit', name: 'app_rapport_controller_crud_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Rapport $rapport, RapportRepository $rapportRepository): Response
    {
        $form = $this->createForm(Rapport1Type::class, $rapport);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $rapportRepository->save($rapport, true);

            return $this->redirectToRoute('app_rapport_controller_crud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('rapport_controller_crud/edit.html.twig', [
            'rapport' => $rapport,
            'form' => $form,
        ]);
    }
    */

    /*

    #[Route('/{id}', name: 'app_rapport_controller_crud_delete', methods: ['POST'])]
    public function delete(Request $request, Rapport $rapport, RapportRepository $rapportRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$rapport->getId(), $request->request->get('_token'))) {
            $rapportRepository->remove($rapport, true);
        }

        return $this->redirectToRoute('app_rapport_controller_crud_index', [], Response::HTTP_SEE_OTHER);
    }
    */
}
