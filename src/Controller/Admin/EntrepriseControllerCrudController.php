<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Entreprise;
use App\Form\EntrepriseType;
use App\Repository\EntrepriseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('admin/entreprise/controller/crud')]
class EntrepriseControllerCrudController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/', name: 'app_entreprise_controller_crud_index', methods: ['GET'])]
    public function index(EntrepriseRepository $entrepriseRepository): Response
    {

        $user = $this->getUser()->getId();
      
        return $this->render('entreprise_controller_crud/index.html.twig', [
            'entreprises' => $entrepriseRepository->findBy(['idGerant'=> $user]),
        ]);
    }

    #[Route('/new', name: 'app_entreprise_controller_crud_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntrepriseRepository $entrepriseRepository): Response
    {
        $entreprise = new Entreprise();
        $form = $this->createForm(EntrepriseType::class, $entreprise);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entrepriseRepository->save($entreprise, true);

            return $this->redirectToRoute('app_entreprise_controller_crud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('entreprise_controller_crud/new.html.twig', [
            'entreprise' => $entreprise,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_entreprise_controller_crud_show', methods: ['GET'])]
    public function show(Entreprise $entreprise): Response
    {
        return $this->render('entreprise_controller_crud/show.html.twig', [
            'entreprise' => $entreprise,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_entreprise_controller_crud_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Entreprise $entreprise, EntrepriseRepository $entrepriseRepository): Response
    {
        $form = $this->createForm(EntrepriseType::class, $entreprise);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entrepriseRepository->save($entreprise, true);

            return $this->redirectToRoute('app_entreprise_controller_crud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('entreprise_controller_crud/edit.html.twig', [
            'entreprise' => $entreprise,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_entreprise_controller_crud_delete', methods: ['POST'])]
    public function delete(Request $request, Entreprise $entreprise, EntrepriseRepository $entrepriseRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$entreprise->getId(), $request->request->get('_token'))) {
            $entrepriseRepository->remove($entreprise, true);
        }

        return $this->redirectToRoute('app_entreprise_controller_crud_index', [], Response::HTTP_SEE_OTHER);
    }
}
