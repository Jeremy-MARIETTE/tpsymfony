<?php

namespace App\Form;

use App\Entity\SiteUser;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SiteUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('SiteId', null, [
                'choice_label' => 'nom',
                'expanded' => true,
                'multiple' => true,
            ])
            ->add('SiteUser', null, [
                'choice_label' => 'nom',
                'expanded' => true,
                'multiple' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SiteUser::class,
        ]);
    }
}
