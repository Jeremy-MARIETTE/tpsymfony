<?php

namespace App\Controller\Admin;

use PDO;
use DateTime;
use DateInterval;
use App\Entity\Site;
use App\Entity\User;
use App\Entity\Ronde;
use App\Entity\Entreprise;
use Doctrine\ORM\Query\Expr;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\Query\Expr\Func;

use App\Repository\SiteRepository;
use App\Repository\UserRepository;
use App\Repository\RondeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\ResultSetMapping;
use Knp\Component\Pager\PaginatorInterface;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Knp\Bundle\PaginatorBundle\Pagination\SlidingPaginationInterface;

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
    public function index(Request $request, PaginatorInterface $paginator): Response
    {
      

        $userId = $this->getUser()->getId(); // Assurez-vous que cette méthode retourne l'ID du gérant actuel
        $token = $this->getUser()->getToken();

        $entrepriseRepository = $this->entityManager->getRepository(Entreprise::class);
        $entreprise = $entrepriseRepository->findOneBy(['idGerant' => $userId]);

        $siteRepository = $this->entityManager->getRepository(Site::class);
        $site = $siteRepository->findBy(['token' => $token]);


        $rondeRepository = $this->entityManager->getRepository(Ronde::class);

        //réccupèrer l'option choisi par l'utilisateur

        //handleRequest() permet de récupérer les données du formulaire
   
        //var_dump($request->request->get('site'));

        $siteChoisi = $request->request->get('site');
        $siteChoisi = $siteRepository->findOneBy(['id' => $siteChoisi]);
        
        $choix = $request->request->get('site');
        $page = $request->query->getInt('page', 1);

        $date = $request->request->get('date');
   
      if($choix){

        // Obtenir la date et l'heure actuelles
        $currentDateTime = new DateTime();

        // Soustraire 24 heures de la date et de l'heure actuelles
        $dateTime24HoursAgo = $currentDateTime->sub(new DateInterval('P1D'));
        // Formater la date et l'heure en une chaîne au format MySQL (Y-m-d H:i:s)
        $dateTime24HoursAgoFormatted = $dateTime24HoursAgo->format('Y-m-d H:i:s');

        $rondes = $rondeRepository->createQueryBuilder('r')
        ->where('r.site = :site')
        ->andWhere('r.token = :token')
        ->andWhere('r.debutAt >= :dateTime24HoursAgo')
        ->setParameter('site', $choix)
        ->setParameter('token', $token)
        ->setParameter('dateTime24HoursAgo', $dateTime24HoursAgo)
        ->orderBy('r.debutAt', 'DESC')
        ->getQuery()
        ->getResult();

        }
      
        else{
            
            $rondes = $rondeRepository->findBy(['site' => '0']);
        }
        if($date != null){
            //var_dump($date);

            // Convertir la date en objet DateTime
            $dateDebut = new \DateTime($date);
            //date moins 1 jour
            $dateDebut->modify('-1 day');

            //var_dump($date);
            $dateDebut->setTime(0, 0, 0);

            $endDate = new \DateTime($date);
            $endDate->modify('+1 day');
            $endDate->setTime(23, 59, 59);

            $queryBuilder = $rondeRepository->createQueryBuilder('r');
            $queryBuilder->where('r.token = :token')
                ->andWhere('r.debutAt >= :startDate')
                ->andWhere('r.debutAt <= :endDate')
                ->andWhere('r.site = :site')
     
                ->setParameters([
                    'token' => $token,
                    'startDate' => $dateDebut,
                    'site' => $siteChoisi,
                    'endDate' => $endDate
                   
                ])
                ->orderBy('r.debutAt', 'ASC');

            // Exécuter la requête et obtenir les résultats
            $rondes = $queryBuilder->getQuery()->getResult();



        }
      
        //je veux compter le nombre user avec mon token
        $userRepository = $this->entityManager->getRepository(User::class);
       
        $user = $userRepository->findBy(['token' => $userId]);

        


    // Maintenant, vous avez l'objet Entreprise correspondant à l'ID du gérant
    // Vous pouvez l'utiliser dans votre template ou faire ce que vous voulez avec

    return $this->render('admin/index.html.twig', [
        'controller_name' => 'AdminController',
        'entreprise' => $entreprise, // Passez l'objet Entreprise au template
        'rondes' => $rondes,
        'sites' => $site,
        'siteChoisi' => $siteChoisi,
      
        'user' => $user
    ]);
    }
}
