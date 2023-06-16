<?php

namespace App\Controller\Admin;

use App\Entity\Ronde;
use App\Entity\Entreprise;
use App\Repository\UserRepository;
use App\Repository\RondeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager, RondeRepository $rondeRepository)
    {
        $this->entityManager = $entityManager;
        $this->rondeRepository = $rondeRepository;
    }
    
    #[Route('/admin', name: 'app_admin')]
    public function index(): Response
    {
      

        $userId = $this->getUser()->getId(); // Assurez-vous que cette méthode retourne l'ID du gérant actuel

        $entrepriseRepository = $this->entityManager->getRepository(Entreprise::class);
        $entreprise = $entrepriseRepository->findOneBy(['idGerant' => $userId]);

        $rondeRepository = $this->entityManager->getRepository(Ronde::class);
        $ronde = $rondeRepository->findAll();

    // Maintenant, vous avez l'objet Entreprise correspondant à l'ID du gérant
    // Vous pouvez l'utiliser dans votre template ou faire ce que vous voulez avec

    return $this->render('admin/index.html.twig', [
        'controller_name' => 'AdminController',
        'entreprise' => $entreprise, // Passez l'objet Entreprise au template
        'rondes' => $ronde
    ]);
    }
}
