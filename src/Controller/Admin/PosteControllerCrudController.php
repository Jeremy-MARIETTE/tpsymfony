<?php

namespace App\Controller\Admin;

use App\Entity\Poste;
use App\Form\PosteType;
use App\Repository\PosteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('admin/poste/controller/crud')]
class PosteControllerCrudController extends AbstractController
{
    #[Route('/', name: 'app_poste_controller_crud_index', methods: ['GET'])]
    public function index(PosteRepository $posteRepository): Response
    {
        return $this->render('poste_controller_crud/index.html.twig', [
            'postes' => $posteRepository->findBy(['token' => $this->getUser()->getId()]),
        ]);
    }

    #[Route('/new', name: 'app_poste_controller_crud_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PosteRepository $posteRepository): Response
    {
        $poste = new Poste();
        $form = $this->createForm(PosteType::class, $poste);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $posteRepository->save($poste, true);

            return $this->redirectToRoute('app_poste_controller_crud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('poste_controller_crud/new.html.twig', [
            'poste' => $poste,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_poste_controller_crud_show', methods: ['GET'])]
    public function show(Poste $poste): Response
    {
        return $this->render('poste_controller_crud/show.html.twig', [
            'poste' => $poste,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_poste_controller_crud_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Poste $poste, PosteRepository $posteRepository): Response
    {
        $form = $this->createForm(PosteType::class, $poste);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $posteRepository->save($poste, true);

            return $this->redirectToRoute('app_poste_controller_crud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('poste_controller_crud/edit.html.twig', [
            'poste' => $poste,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_poste_controller_crud_delete', methods: ['POST'])]
    public function delete(Request $request, Poste $poste, PosteRepository $posteRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$poste->getId(), $request->request->get('_token'))) {
            $posteRepository->remove($poste, true);
        }

        return $this->redirectToRoute('app_poste_controller_crud_index', [], Response::HTTP_SEE_OTHER);
    }
}
