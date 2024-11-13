<?php

namespace App\Form;

use App\Entity\Location;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
// Include necessary form types
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class LocationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('city', TextType::class, [
                'attr' => [
                    'placeholder' => 'Enter city name',
                    'class' => 'form-control', // Bootstrap class
                ],
            ])
            ->add('country', ChoiceType::class, [
                'choices' => [
                    'Poland' => 'PL',
                    'Germany' => 'DE',
                    'France' => 'FR',
                    'Spain' => 'ES',
                    'Italy' => 'IT',
                    'United Kingdom' => 'GB',
                    'United States' => 'US',
                ],
                'placeholder' => 'Select a country',
                'attr' => [
                    'class' => 'form-select', // Bootstrap class
                ],
            ])
            ->add('latitude', null, [
                'attr' => [
                    'placeholder' => 'Enter latitude',
                    'class' => 'form-control',
                ],
            ])
            ->add('longitude', null, [
                'attr' => [
                    'placeholder' => 'Enter longitude',
                    'class' => 'form-control',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Location::class,
        ]);
    }
}
