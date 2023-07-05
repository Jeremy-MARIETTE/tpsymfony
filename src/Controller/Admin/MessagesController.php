<?php

namespace App\Controller\Admin;

use App\Entity\Messages;
use App\Form\MessagesType;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MessagesController extends AbstractController
{

    private ManagerRegistry $managerRegistry;

    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->managerRegistry = $managerRegistry;
    }
    #[Route('admin/messages', name: 'app_messages')]
    public function index(): Response
    {
        return $this->render('messages/index.html.twig', [
            'controller_name' => 'MessagesController',
        ]);
    }

    #[Route('admin/send', name: 'app_send')]
    public function send(Request $request): Response
    {
        $message = new Messages();
        $form = $this->createForm(MessagesType::class, $message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $message->setSender($this->getUser());
            $message->setCreatedAt(new \DateTimeImmutable()); // Use DateTimeImmutable instead of DateTime
            $message->setIsRead(false);

            $entityManager = $this->managerRegistry->getManager();
            $entityManager->persist($message);
            $entityManager->flush();

            $this->addFlash('success', 'Votre message a bien été envoyé');

            return $this->redirectToRoute('app_messages');
        }

        return $this->render('messages/send.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('admin/received', name: 'app_received')]
    public function received(): Response
    {
        return $this->render('messages/received.html.twig');
    }
}
