<?php

namespace App\Controller\Admin;

use App\Entity\Livre;
use App\Form\LivreType;
use App\Repository\LivreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('admin/livre/controller/crud')]
class LivreControllerCrudController extends AbstractController
{
    #[Route('/', name: 'app_livre_controller_crud_index', methods: ['GET'])]
    public function index(LivreRepository $livreRepository): Response
    {
        return $this->render('livre_controller_crud/index.html.twig', [
            'livres' => $livreRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_livre_controller_crud_new', methods: ['GET', 'POST'])]
    public function new(Request $request, LivreRepository $livreRepository): Response
    {
        $livre = new Livre();
        $form = $this->createForm(LivreType::class, $livre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $livreRepository->save($livre, true);

            return $this->redirectToRoute('app_livre_controller_crud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('livre_controller_crud/new.html.twig', [
            'livre' => $livre,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_livre_controller_crud_show', methods: ['GET'])]
    public function show(Livre $livre): Response
    {
        return $this->render('livre_controller_crud/show.html.twig', [
            'livre' => $livre,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_livre_controller_crud_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Livre $livre, LivreRepository $livreRepository): Response
    {
        $form = $this->createForm(LivreType::class, $livre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $livreRepository->save($livre, true);

            return $this->redirectToRoute('app_livre_controller_crud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('livre_controller_crud/edit.html.twig', [
            'livre' => $livre,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_livre_controller_crud_delete', methods: ['POST'])]
    public function delete(Request $request, Livre $livre, LivreRepository $livreRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$livre->getId(), $request->request->get('_token'))) {
            $livreRepository->remove($livre, true);
        }

        return $this->redirectToRoute('app_livre_controller_crud_index', [], Response::HTTP_SEE_OTHER);
    }
}
