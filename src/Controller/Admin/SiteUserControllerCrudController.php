<?php

namespace App\Controller\Admin;

use App\Entity\SiteUser;
use App\Form\SiteUserType;
use App\Repository\SiteUserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('admin/site/user/controller/crud')]
class SiteUserControllerCrudController extends AbstractController
{
    #[Route('/', name: 'app_site_user_controller_crud_index', methods: ['GET'])]
    public function index(SiteUserRepository $siteUserRepository): Response
    {
        return $this->render('site_user_controller_crud/index.html.twig', [
            'site_users' => $siteUserRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_site_user_controller_crud_new', methods: ['GET', 'POST'])]
    public function new(Request $request, SiteUserRepository $siteUserRepository): Response
    {
        $siteUser = new SiteUser();
        $form = $this->createForm(SiteUserType::class, $siteUser);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $siteUserRepository->save($siteUser, true);

            return $this->redirectToRoute('app_site_user_controller_crud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('site_user_controller_crud/new.html.twig', [
            'site_user' => $siteUser,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_site_user_controller_crud_show', methods: ['GET'])]
    public function show(SiteUser $siteUser): Response
    {
        return $this->render('site_user_controller_crud/show.html.twig', [
            'site_user' => $siteUser,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_site_user_controller_crud_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, SiteUser $siteUser, SiteUserRepository $siteUserRepository): Response
    {
        $form = $this->createForm(SiteUserType::class, $siteUser);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $siteUserRepository->save($siteUser, true);

            return $this->redirectToRoute('app_site_user_controller_crud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('site_user_controller_crud/edit.html.twig', [
            'site_user' => $siteUser,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_site_user_controller_crud_delete', methods: ['POST'])]
    public function delete(Request $request, SiteUser $siteUser, SiteUserRepository $siteUserRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$siteUser->getId(), $request->request->get('_token'))) {
            $siteUserRepository->remove($siteUser, true);
        }

        return $this->redirectToRoute('app_site_user_controller_crud_index', [], Response::HTTP_SEE_OTHER);
    }
}
