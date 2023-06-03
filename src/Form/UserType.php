<?php

namespace App\Form;

use App\Entity\User;
use Doctrine\DBAL\Types\ArrayType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{

    
    
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

         
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('email')  
            // Champ du mot de passe masqué
            ->add('password', PasswordType::class, [
                'attr' => ['hidden' => true],
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
