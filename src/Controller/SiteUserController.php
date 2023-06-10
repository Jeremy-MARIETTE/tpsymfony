<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SiteUserController extends AbstractController
{
    #[Route('/site/user', name: 'app_site_user')]
    public function index(): Response
    {
        return $this->render('site_user/index.html.twig', [
            'controller_name' => 'SiteUserController',
        ]);
    }
}
