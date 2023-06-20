<?php

namespace App\Form;

use App\Entity\Ronde;
use DateTimeImmutable;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class RondeType extends AbstractType
{
    public function __construct(Security $security)
    {
        $this->security = $security;
        
    }
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
            'data_class' => Ronde::class,
        ]);
    }
}
