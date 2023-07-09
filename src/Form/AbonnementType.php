<?php

namespace App\Form;

use App\Entity\Abonnement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class AbonnementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nbLicences', NumberType::class, [
                'label' => 'Nombre de licences',
                'attr' => [
                    'placeholder' => 'Nombre de licences',
                    'min' => 10,
                ],
                'html5' => true,
                'attr' => [
                    'min' => 10,
                ],
                //valeur par defaut
                'data' => 10,
            ]) 
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Abonnement::class,
        ]);
    }
}
