<?php

namespace App\Form;

use App\Entity\Consignes;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ConsignesType extends AbstractType
{
    public function __construct(Security $security)
    {
        $this->security = $security;
        
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('site', null, [
                'choice_label' => 'nom',
            ])
            ->add('category', null, [
                'choice_label' => 'nom',
            ])
            ->add('content')
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
            'data_class' => Consignes::class,
        ]);
    }
}
