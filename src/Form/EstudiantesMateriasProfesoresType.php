<?php

namespace App\Form;

use App\Entity\EstudiantesMateriasProfesores;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EstudiantesMateriasProfesoresType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id_estudiante')
            ->add('id_materia')
            ->add('id_profesor')
            ->add('is_active')
            ->add('created_at')
            ->add('updated_at')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => EstudiantesMateriasProfesores::class,
        ]);
    }
}
