<?php

namespace App\Controller\Admin;

use App\Entity\Site;
use App\Form\Site1Type;
use App\Repository\SiteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('admin/site/controller/crud')]
class SiteControllerCudController extends AbstractController
{
    #[Route('/', name: 'app_site_controller_cud_index', methods: ['GET'])]
    public function index(SiteRepository $siteRepository): Response
    {
        return $this->render('site_controller_cud/index.html.twig', [
            'sites' => $siteRepository->findBy(['token' => $this->getUser()->getId()]),
        ]);
    }

    #[Route('/new', name: 'app_site_controller_cud_new', methods: ['GET', 'POST'])]
    public function new(Request $request, SiteRepository $siteRepository): Response
    {
        $site = new Site();
        $form = $this->createForm(Site1Type::class, $site);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $siteRepository->save($site, true);

            return $this->redirectToRoute('app_site_controller_cud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('site_controller_cud/new.html.twig', [
            'site' => $site,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_site_controller_cud_show', methods: ['GET'])]
    public function show(Site $site): Response
    {
        return $this->render('site_controller_cud/show.html.twig', [
            'site' => $site,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_site_controller_cud_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Site $site, SiteRepository $siteRepository): Response
    {
        $form = $this->createForm(Site1Type::class, $site);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $siteRepository->save($site, true);

            return $this->redirectToRoute('app_site_controller_cud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('site_controller_cud/edit.html.twig', [
            'site' => $site,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_site_controller_cud_delete', methods: ['POST'])]
    public function delete(Request $request, Site $site, SiteRepository $siteRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$site->getId(), $request->request->get('_token'))) {
            $siteRepository->remove($site, true);
        }

        return $this->redirectToRoute('app_site_controller_cud_index', [], Response::HTTP_SEE_OTHER);
    }
}
