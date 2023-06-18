<?php

namespace App\Controller\Admin;

use App\Entity\Ronde;
use App\Form\RondeType;
use App\Repository\RondeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('admin/ronde/controller/crud')]
class RondeControllerCrudController extends AbstractController
{
    #[Route('/', name: 'app_ronde_controller_crud_index', methods: ['GET'])]
    public function index(RondeRepository $rondeRepository): Response
    {
        return $this->render('ronde_controller_crud/index.html.twig', [
            'rondes' => $rondeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_ronde_controller_crud_new', methods: ['GET', 'POST'])]
    public function new(Request $request, RondeRepository $rondeRepository): Response
    {
        $ronde = new Ronde();
        $form = $this->createForm(RondeType::class, $ronde);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $rondeRepository->save($ronde, true);

            return $this->redirectToRoute('app_ronde_controller_crud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('ronde_controller_crud/new.html.twig', [
            'ronde' => $ronde,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_ronde_controller_crud_show', methods: ['GET'])]
    public function show(Ronde $ronde): Response
    {
        return $this->render('ronde_controller_crud/show.html.twig', [
            'ronde' => $ronde,
        ]);
    }
/*
    #[Route('/{id}/edit', name: 'app_ronde_controller_crud_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Ronde $ronde, RondeRepository $rondeRepository): Response
    {
        $form = $this->createForm(RondeType::class, $ronde);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $rondeRepository->save($ronde, true);

            return $this->redirectToRoute('app_ronde_controller_crud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('ronde_controller_crud/edit.html.twig', [
            'ronde' => $ronde,
            'form' => $form,
        ]);
    }
*/
/*
    #[Route('/{id}', name: 'app_ronde_controller_crud_delete', methods: ['POST'])]
    public function delete(Request $request, Ronde $ronde, RondeRepository $rondeRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ronde->getId(), $request->request->get('_token'))) {
            $rondeRepository->remove($ronde, true);
        }

        return $this->redirectToRoute('app_ronde_controller_crud_index', [], Response::HTTP_SEE_OTHER);
    */
}
