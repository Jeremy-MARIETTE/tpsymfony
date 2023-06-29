<?php

namespace App\Controller\Admin;

use App\Entity\Profil;
use App\Form\UserType;
use App\Form\PosteType;
use App\Form\ProfilType;
use App\Repository\UserRepository;
use App\Repository\ProfilRepository;
use App\Repository\EntrepriseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ProfilController extends AbstractController
{

    private $passwordHasher;
    private $entityManager;
 

    public function __construct(UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager)
    {
        $this->passwordHasher = $passwordHasher;
        $this->entityManager = $entityManager;
       
    }
    #[Route('/admin/profil', name: 'app_profil')]
    public function index(Request $request,UserRepository $user, EntrepriseRepository $entreprise): Response
    {

    

    
        return $this->render('profil/index.html.twig', [
            'user' => $user->findBy(['id' => $this->getUser()->getId()]),
            'entreprise' => $entreprise->findBy(['idGerant' => $this->getUser()->getId()]),
        ]);
    }
    #[Route('/admin/profil/pwd', name: 'app_pwd')]
    public function updatePwd(Request $request)
    {
        
    
        $form = $this->createForm(ProfilType::class);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            // Retrieve the submitted data
            $data = $form->getData();
    
            $pwd = $data['password'];
            $confirmPwd = $data['confirmPassword'];

            if($pwd === $confirmPwd){
                //var_dump('Les mots de passe sont identiques');
                //Je veux modifier le mot de passe de l'utilisateur en la hashant
                $user = $this->getUser();
                $user->setPassword($pwd);
                $user->setPassword($this->passwordHasher->hashPassword(
                    $user,
                    $user->getPassword()
                ));

                $this->entityManager->persist($user);
                $this->entityManager->flush();

                $this->addFlash('success', 'Votre mot de passe a été mis à jour.');
               
            }else{

                $this->addFlash('error', 'Les mots de passe sont différents.');

            }


           
    
            //return $this->redirectToRoute('app_profil');
        }
    
        return $this->render('profil/pwd.html.twig', [
            'form' => $form->createView(),
        ]);
    }

     

}
