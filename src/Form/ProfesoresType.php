<?php

namespace App\Form;

use App\Entity\Profesores;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class ProfesoresType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombres')
            ->add('apellidos')
            ->add('identificacion')
            ->add('contrasena')
            ->add('is_active', ChoiceType::class, [
                'choices'  => [
                    'Activo' => 1,
                    'Inactivo' => 0,                    
                ],
            ])
            ->add('created_at', DateType::class, [
                // renders it as a single text box
                'widget' => 'single_text',
            ])
            ->add('updated_at', DateType::class, [
                // renders it as a single text box
                'widget' => 'single_text',
            ])            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Profesores::class,
        ]);
    }
}
