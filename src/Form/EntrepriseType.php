<?php

namespace App\Form;

use App\Entity\Entreprise;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EntrepriseType extends AbstractType
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
            ->add('id_gerant', null, [
                'data' => $this->security->getUser()->getId(),
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
            'data_class' => Entreprise::class,
        ]);
    }
}
