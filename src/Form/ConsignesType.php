<?php

namespace App\Form;

use App\Entity\Consignes;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ConsignesType extends AbstractType
{
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Consignes::class,
        ]);
    }
}
