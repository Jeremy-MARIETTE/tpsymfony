<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class ProfilType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('password', PasswordType::class, [
            'label' => false,
            'attr' => [
                'placeholder' => 'Nouveau mot de passe'
            ],
          
        ])
        ->add('confirmPassword', PasswordType::class, [
            'label' => false,
            'attr' => [
                'placeholder' => 'Confirmer le mot de passe'
            ],
          
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            
        ]);
    }
}
