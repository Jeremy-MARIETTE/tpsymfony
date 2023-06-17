<?php

namespace App\Controller\Admin;

use App\Entity\Site;
use App\Entity\Ronde;
use App\Entity\Entreprise;
use App\Repository\SiteRepository;
use App\Repository\UserRepository;
use App\Repository\RondeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager, RondeRepository $rondeRepository, SiteRepository $siteRepository)
    {
        $this->entityManager = $entityManager;
        $this->rondeRepository = $rondeRepository;
        $this->siteRepository = $siteRepository;
    }
    
    #[Route('/admin', name: 'app_admin')]
    public function index(Request $request): Response
    {
      

        $userId = $this->getUser()->getId(); // Assurez-vous que cette méthode retourne l'ID du gérant actuel

        $entrepriseRepository = $this->entityManager->getRepository(Entreprise::class);
        $entreprise = $entrepriseRepository->findOneBy(['idGerant' => $userId]);

        $siteRepository = $this->entityManager->getRepository(Site::class);
        $site = $siteRepository->findAll();


        $rondeRepository = $this->entityManager->getRepository(Ronde::class);

        //réccupèrer l'option choisi par l'utilisateur

        //handleRequest() permet de récupérer les données du formulaire
   
        //var_dump($request->request->get('site'));

        $siteChoisi = $request->request->get('site');
        $siteChoisi = $siteRepository->findOneBy(['id' => $siteChoisi]);
        
        $choix = $request->request->get('site');
      if($choix != null){
        $ronde = $rondeRepository->findBy(['site' => $choix], ['debutAt' => 'DESC']);
        }else{
            $ronde = $rondeRepository->findBy(['site' => '0']);
        }
      

    // Maintenant, vous avez l'objet Entreprise correspondant à l'ID du gérant
    // Vous pouvez l'utiliser dans votre template ou faire ce que vous voulez avec

    return $this->render('admin/index.html.twig', [
        'controller_name' => 'AdminController',
        'entreprise' => $entreprise, // Passez l'objet Entreprise au template
        'rondes' => $ronde,
        'sites' => $site,
        'siteChoisi' => $siteChoisi,
    ]);
    }
}
