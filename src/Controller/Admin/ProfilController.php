<?php

namespace App\Controller\Admin;

use App\Repository\UserRepository;
use App\Repository\EntrepriseRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProfilController extends AbstractController
{
    #[Route('/admin/profil', name: 'app_profil')]
    public function index(UserRepository $user, EntrepriseRepository $entreprise): Response
    {
    
        return $this->render('profil/index.html.twig', [
            'user' => $user->findBy(['id' => $this->getUser()->getId()]),
            'entreprise' => $entreprise->findBy(['idGerant' => $this->getUser()->getId()]),
        ]);
    }
    public function callUpdatePwd(){

    }

     

}
