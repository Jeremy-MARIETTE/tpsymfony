<?php

namespace App\Form;

use App\Entity\Site;
use App\Entity\Rapport;
use App\Repository\SiteRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class Rapport1Type extends AbstractType
{
    public function __construct(Security $security)
    {
        $this->security = $security;
        
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

        ->add('site', EntityType::class, [
            'class' => Site::class,
            'query_builder' => function (SiteRepository $siteRepository) {
                return $siteRepository->createQueryBuilder('s')
                    ->where('s.token = :token')
                    ->setParameter('token', $this->security->getUser()->getToken());
            },
            'choice_label' => 'nom',
            'multiple' => false,
            'expanded' => false,
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
            'data_class' => Rapport::class,
            'sitesChoisi' => [],
        ]);
    }
}
