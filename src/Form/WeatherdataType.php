<?php

namespace App\Form;

use App\Entity\Weatherdata;
use App\Entity\Location;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WeatherdataType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // Pole wyboru lokalizacji
            ->add('location', EntityType::class, [
                'class' => Location::class,
                'choice_label' => 'city',
                'placeholder' => 'Wybierz lokalizację',
                'attr' => [
                    'class' => 'form-select',
                ],
            ])
            // Pole daty
            ->add('timestamp', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Data',
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('temperature_celsius', null, [
                'label' => 'Temperatura (°C)',
                'input' => 'number',
                'attr' => [
                    'placeholder' => 'Wprowadź temperaturę w °C',
                    'class' => 'form-control',
                ],
            ])
            ->add('wind_speed', null, [
                'label' => 'Prędkość wiatru (km/h)',
                'input' => 'number',
                'attr' => [
                    'placeholder' => 'Wprowadź prędkość wiatru',
                    'class' => 'form-control',
                ],
            ])
            ->add('humidity', null, [
                'label' => 'Wilgotność (%)',
                'input' => 'number',
                'attr' => [
                    'placeholder' => 'Wprowadź wilgotność',
                    'class' => 'form-control',
                ],
            ])
            ->add('pressure', null, [
                'label' => 'Ciśnienie (hPa)',
                'input' => 'number',
                'attr' => [
                    'placeholder' => 'Wprowadź ciśnienie',
                    'class' => 'form-control',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Weatherdata::class,
        ]);
    }
}
