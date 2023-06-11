<?php

namespace App\Form;

use App\Entity\User;
use Doctrine\DBAL\Types\ArrayType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserType extends AbstractType
{

    public function __construct(Security $security)
    {
        $this->security = $security;
        
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

         
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('email')  
            ->add('token', TextType::class, [
                'data' => $this->security->getUser()->getId(),
                'label_attr' => [
                    'style' => 'display: none;',
                ],
                 'attr' => [
                    'style' => 'display: none;',
                ],
            ])
            // Champ du mot de passe masqué
            ->add('password', PasswordType::class, [
                'label_attr' => [
                    'style' => 'display: none;',
                ],
                'attr' => [
                    'hidden' => true
                ],
            ])

            ->add('roles', ChoiceType::class, [
                'multiple' => true,
                'choices' => [
                    'Employé' => 'ROLE_EMPLOYE',
                    'Utilisateur' => 'ROLE_UTILISATEUR',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
