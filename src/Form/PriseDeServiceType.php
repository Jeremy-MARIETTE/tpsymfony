<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\PriseDeService;
use Symfony\Component\Form\AbstractType;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class PriseDeServiceType extends AbstractType
{
    public function __construct(Security $security)
    {
        $this->security = $security;
        
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Date', DateTimeType::class, [
                'widget' => 'single_text',
                'label' => false,
                'attr' => [
                    'class' => 'datetime-picker btn btn-primary',
                    'id' => 'debut',
                ],])
            ->add('dateFin', DateTimeType::class, [
                'widget' => 'single_text',
                'label' => false,
                'required' => false,
                'attr' => [
                    'class' => 'datetime-picker btn btn-primary',
                ],])
            ->add('latDebut', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'style' => 'display: none;',
                ],
            ])
            ->add('lngDebut', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'style' => 'display: none;',
                ],
            ])
            ->add('latFin', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'style' => 'display: none;',
                ],
            ])
            ->add('lntFin', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'style' => 'display: none;',
                ],
            ])

            ->add('idAgent', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'nom',
                'data' => $this->security->getUser(),

                'label_attr' => [
                    'style' => 'display: none;',
                ],
                 'attr' => [
                    'style' => 'display: none;',
                ],

            ])
            ->add('token', null, [
                
                'data' => $this->security->getUser()->getToken(),
                'label_attr' => ['style' => 'display: none;'],
                'attr' => ['style' => 'display: none;'],
            ])
            
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PriseDeService::class,
        ]);
    }
}
