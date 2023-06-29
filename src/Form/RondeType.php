<?php

namespace App\Form;

use App\Entity\Poste;
use App\Entity\Ronde;
use DateTimeImmutable;

use App\Repository\SiteRepository;
use Doctrine\DBAL\Types\ArrayType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Form\FormBuilderInterface;
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
            ->add('site', null, [
                'choice_label' => 'nom',
                    //je veux un join en tre les tables site et poste
                     'query_builder' => function (SiteRepository $siteRepository) {
                        return $siteRepository->createQueryBuilder('s')
                             ->innerJoin('s.postes', 'p')
                             ->where('p.token = :token')
                             ->andWhere('p.agent = :id')
                             ->setParameter('token', $this->security->getUser()->getToken())
                             ->setParameter('id', $this->security->getUser()->getId())
                             ->orderBy('s.nom', 'ASC');
                     },


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
