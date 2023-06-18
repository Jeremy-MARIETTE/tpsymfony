<?php

namespace App\Form;

use App\Entity\Site;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class Site1Type extends AbstractType
{
    public function __construct(Security $security)
    {
        $this->security = $security;
        
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('adresse')
            ->add('cp')
            ->add('token', TextType::class, [
                'data' => $this->security->getUser()->getToken(),
                'label_attr' => [
                    'style' => 'display: none;',
                ],
                 'attr' => [
                    'style' => 'display: none;',
                ],
            
            ])
     
         
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Site::class,
        ]);
    }
}
