<?php

namespace App\Controller\Admin;

use App\Entity\Site;
use App\Entity\Category;
use App\Entity\Consignes;
use App\Form\CategoryType;
use App\Form\ConsignesType;
use App\Repository\SiteRepository;
use App\Repository\PosteRepository;
use App\Repository\ConsignesRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('admin/consignes/controller/crud')]
class ConsignesControllerCrudController extends AbstractController
{
    #[Route('/', name: 'app_consignes_controller_crud_index', methods: ['POST', 'GET'])]
    public function index(ConsignesRepository $consignesRepository, SiteRepository $sitesRepository, PosteRepository $posteRepository, Request $request): Response
    {
       
    $agentId = $this->getUser()->getId();
    $token = $this->getUser()->getToken();

    // Récupérer les sites associés à l'agent
    $sites = $posteRepository->findBy(['agent' => $agentId]);

    $consignes = [];
    
    
    if ($sites) {
        // Récupérer les consignes associées au token et aux sites
        $siteIds = array_map(function ($site) {
            return $site->getSite();
        }, $sites);
        if($this->getUser()->getRoles()[0] != "ROLE_USER"){
        $consignes = $consignesRepository->findBy(['token' => $token, 'site' => $siteIds]);
        }else{
            $consignes = $consignesRepository->findBy(['token' => $this->getUser()->getId() ]);
        }
    }

    return $this->render('consignes_controller_crud/index.html.twig', [
        "consignes" => $consignes,
        "sites" => $sites,
    ]);

    }

    #[Route('/new', name: 'app_consignes_controller_crud_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ConsignesRepository $consignesRepository): Response
    {
        $consigne = new Consignes();
        $form = $this->createForm(ConsignesType::class, $consigne);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $consignesRepository->save($consigne, true);

            return $this->redirectToRoute('app_consignes_controller_crud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('consignes_controller_crud/new.html.twig', [
            'consigne' => $consigne,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_consignes_controller_crud_show', methods: ['GET'])]
    public function show(Consignes $consigne): Response
    {
        return $this->render('consignes_controller_crud/show.html.twig', [
            'consigne' => $consigne,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_consignes_controller_crud_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Consignes $consigne, ConsignesRepository $consignesRepository): Response
    {
        $form = $this->createForm(ConsignesType::class, $consigne);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $consignesRepository->save($consigne, true);

            return $this->redirectToRoute('app_consignes_controller_crud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('consignes_controller_crud/edit.html.twig', [
            'consigne' => $consigne,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_consignes_controller_crud_delete', methods: ['POST'])]
    public function delete(Request $request, Consignes $consigne, ConsignesRepository $consignesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$consigne->getId(), $request->request->get('_token'))) {
            $consignesRepository->remove($consigne, true);
        }

        return $this->redirectToRoute('app_consignes_controller_crud_index', [], Response::HTTP_SEE_OTHER);
    }
}
