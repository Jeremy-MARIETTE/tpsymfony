<?php

namespace App\Controller\Admin;

use App\Entity\Entreprise;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    
    #[Route('/admin', name: 'app_admin')]
    public function index(): Response
    {
        /*
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);

        
          $user = $this->getUser()->getId();
      
        return $this->render('entreprise_controller_crud/index.html.twig', [
            'entreprises' => $entrepriseRepository->findBy(['idGerant'=> $user]),
        ]);
         */

         $userId = $this->getUser()->getId(); // Assurez-vous que cette méthode retourne l'ID du gérant actuel

    $entrepriseRepository = $this->entityManager->getRepository(Entreprise::class);
    $entreprise = $entrepriseRepository->findOneBy(['idGerant' => $userId]);

    // Maintenant, vous avez l'objet Entreprise correspondant à l'ID du gérant
    // Vous pouvez l'utiliser dans votre template ou faire ce que vous voulez avec

    return $this->render('admin/index.html.twig', [
        'controller_name' => 'AdminController',
        'entreprise' => $entreprise, // Passez l'objet Entreprise au template
    ]);
    }
}
