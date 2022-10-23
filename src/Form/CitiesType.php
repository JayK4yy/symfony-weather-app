<?php

namespace App\Form;

use App\Entity\Cities;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CitiesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('country', ChoiceType::class, [
                'choices' => [
                    'Polska' => 'PL',
                    'Niemcy' => 'DE',
                    'Czechy' => 'CZ'
                ],
            ])
            ->add('lat')
            ->add('lon')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Cities::class,
        ]);
    }
}
