<?php

namespace App\Form;

use App\Entity\Poste;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class PosteType extends AbstractType
{
    public function __construct(Security $security)
    {
        $this->security = $security;
        
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('agent', ChoiceType::class, [
                'choices' => $options['agents'],
                'choice_label' => function ($user) {
                    return $user->getPrenom() . ' ' . $user->getNom();
                }],)
            ->add('site', ChoiceType::class, [
                'choices' => $options['sites'],
                'choice_label' => function ($site) {
                    return $site->getNom();
                }],)
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
            'data_class' => Poste::class,
            'agents' => [],
            'sites' => [],
        ]);
    }
}
