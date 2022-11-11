<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;




class ConnectorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $flys = array();

        $builder
            ->add('airport', ChoiceType::class, 
                ['choices' => 
                    [
                        'Fráncfort' => 'EDDF', 
                        'New York' => 'KJFK',
                        'Sevilla' => 'LEZL'
                    ]
                ]
            )
            ->add('begin', DateType::class)
            ->add('end', DateType::class)
            ->add('submit', SubmitType::class, ['label' => 'Search flights'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
