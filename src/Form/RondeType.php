<?php

namespace App\Form;

use App\Entity\Ronde;
use DateTimeImmutable;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class RondeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        
        $builder
            ->add('debutAt', DateTimeType::class, [
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'datetime-picker btn btn-primary',
                ],
                
            ])
            ->add('retourAt', DateTimeType::class, [
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'datetime-picker btn btn-primary',
                ],
            ])
            ->add('observation')
            ->add('site', null, [
                'choice_label' => 'nom',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ronde::class,
        ]);
    }
}
