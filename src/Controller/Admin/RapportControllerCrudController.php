<?php

namespace App\Controller\Admin;

use App\Entity\Rapport;
use App\Form\Rapport1Type;
use App\Repository\RapportRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('admin/rapport/controller/crud')]
class RapportControllerCrudController extends AbstractController
{
    #[Route('/', name: 'app_rapport_controller_crud_index', methods: ['GET'])]
    public function index(RapportRepository $rapportRepository): Response
    {
        return $this->render('rapport_controller_crud/index.html.twig', [
            'rapports' => $rapportRepository->findAll(),
        ]);
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
    public function show(Rapport $rapport): Response
    {
        return $this->render('rapport_controller_crud/show.html.twig', [
            'rapport' => $rapport,
        ]);
    }

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

    #[Route('/{id}', name: 'app_rapport_controller_crud_delete', methods: ['POST'])]
    public function delete(Request $request, Rapport $rapport, RapportRepository $rapportRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$rapport->getId(), $request->request->get('_token'))) {
            $rapportRepository->remove($rapport, true);
        }

        return $this->redirectToRoute('app_rapport_controller_crud_index', [], Response::HTTP_SEE_OTHER);
    }
}