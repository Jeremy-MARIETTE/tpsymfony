<?php

namespace App\Form;

use App\Entity\Site;
use App\Entity\Poste;
use App\Entity\Ronde;

use DateTimeImmutable;
use App\Repository\SiteRepository;
use Doctrine\DBAL\Types\ArrayType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class RondeType extends AbstractType
{
    private $security;
 

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
            ->add('latDepart', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'style' => 'display: none;', // Cache le champ en utilisant le style CSS
                ],
            ])
          ->add('lntDepart', TextType::class, [
            'label' => false,
            'required' => false,
            'attr' => [
                'style' => 'display: none;', // Cache le champ en utilisant le style CSS
            ],
        ])

            

            ->add('retourAt', DateTimeType::class, [
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'datetime-picker btn btn-primary',
                ],
            ])
            
            ->add('latRetour', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'style' => 'display: none;', // Cache le champ en utilisant le style CSS
                ],
            ])
            ->add('lntRetour', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'style' => 'display: none;', // Cache le champ en utilisant le style CSS
                ],
            ])

            ->add('observation')
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
            'sites' => [],
        ]);
    }
}
