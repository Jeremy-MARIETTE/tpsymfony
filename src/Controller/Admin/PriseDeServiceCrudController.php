<?php

namespace App\Controller\Admin;

use App\Entity\PriseDeService;
use App\Form\PriseDeServiceType;
use App\Repository\PriseDeServiceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('admin/prise/de/service/crud')]
class PriseDeServiceCrudController extends AbstractController
{
    #[Route('/', name: 'app_prise_de_service_crud_index', methods: ['GET'])]
    public function index(PriseDeServiceRepository $priseDeServiceRepository): Response
    {
        return $this->render('prise_de_service_crud/index.html.twig', [
            'prise_de_services' => $priseDeServiceRepository->findBy(['idAgent' => $this->getUser()->getId(), 'dateFin' => null]),
        ]);
    }

    #[Route('/new', name: 'app_prise_de_service_crud_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PriseDeServiceRepository $priseDeServiceRepository): Response
    {
        $priseDeService = new PriseDeService();
        $form = $this->createForm(PriseDeServiceType::class, $priseDeService);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $priseDeServiceRepository->save($priseDeService, true);

            return $this->redirectToRoute('app_prise_de_service_crud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('prise_de_service_crud/new.html.twig', [
            'prise_de_service' => $priseDeService,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_prise_de_service_crud_show', methods: ['GET'])]
    public function show(PriseDeService $priseDeService): Response
    {
        return $this->render('prise_de_service_crud/show.html.twig', [
            'prise_de_service' => $priseDeService,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_prise_de_service_crud_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, PriseDeService $priseDeService, PriseDeServiceRepository $priseDeServiceRepository): Response
    {
        $form = $this->createForm(PriseDeServiceType::class, $priseDeService);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $priseDeServiceRepository->save($priseDeService, true);

            return $this->redirectToRoute('app_prise_de_service_crud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('prise_de_service_crud/edit.html.twig', [
            'prise_de_service' => $priseDeService,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_prise_de_service_crud_delete', methods: ['POST'])]
    public function delete(Request $request, PriseDeService $priseDeService, PriseDeServiceRepository $priseDeServiceRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$priseDeService->getId(), $request->request->get('_token'))) {
            $priseDeServiceRepository->remove($priseDeService, true);
        }

        return $this->redirectToRoute('app_prise_de_service_crud_index', [], Response::HTTP_SEE_OTHER);
    }
}
