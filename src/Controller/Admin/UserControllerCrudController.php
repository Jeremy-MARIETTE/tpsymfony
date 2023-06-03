<?php

namespace App\Controller\Admin;

use App\Entity\Entreprise;
use App\Entity\User;
use App\Form\UserType;
use Symfony\Component\Mime\Email;
use App\Repository\UserRepository;
use Symfony\Component\Mime\Message;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[Route('admin/user/controller/crud')]
class UserControllerCrudController extends AbstractController
{

    private $passwordHasher;
    private $entityManager;
    private $mailer;

    public function __construct(UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager, MailerInterface $mailer)
    {
        $this->passwordHasher = $passwordHasher;
        $this->entityManager = $entityManager;
        $this->mailer = $mailer;
    }

    #[Route('/', name: 'app_user_controller_crud_index', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user_controller_crud/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

  
    #[Route('/new', name: 'app_user_controller_crud_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {

        $userId = $this->getUser()->getId(); // Assurez-vous que cette méthode retourne l'ID du gérant actuel

        $entrepriseRepository = $this->entityManager->getRepository(Entreprise::class);
        $entreprise = $entrepriseRepository->findOneBy(['idGerant' => $userId]);
        
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

      //submit the form and save the user and call the password subscriber
        if ($form->isSubmitted() && $form->isValid()) {
           
            //get the password from the form
            $hashedPassword = $user->getPassword();

            //generate random token
            $hashedPassword = md5(random_bytes(60));

            $sendPassword = $hashedPassword;

            //hash the password before saving it
            $hashedPassword = $this->passwordHasher->hashPassword(
                $user,
                $hashedPassword);
            
             // Persist the user entity
             //hash the password before saving it
                $user->setPassword($hashedPassword);

                
             $this->entityManager->persist($user);
             $this->entityManager->flush();

             //send the email to the user
                $email = (new Email())
                ->from('clui1@msn.com')
                ->to($user->getEmail())
                ->subject('Confirmation de votre inscription')
                ->html($this->renderView('registration/createuser.html.twig', [
                    'user' => $user,
                    'password' => $sendPassword,
                    'entreprise' => $entreprise,
                ]));
                $this->mailer->send($email);
                
                
 
             return $this->redirectToRoute('app_user_controller_crud_index', [], Response::HTTP_SEE_OTHER);
         


        }
      

        return $this->renderForm('user_controller_crud/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_user_controller_crud_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        return $this->render('user_controller_crud/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_user_controller_crud_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, UserRepository $userRepository): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->save($user, true);

            return $this->redirectToRoute('app_user_controller_crud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user_controller_crud/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_user_controller_crud_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, UserRepository $userRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $userRepository->remove($user, true);
        }

        return $this->redirectToRoute('app_user_controller_crud_index', [], Response::HTTP_SEE_OTHER);
    }
}
