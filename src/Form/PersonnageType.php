<?php

namespace App\Form;

use App\Component\IO\PersonnageIO;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PersonnageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre')
            ->add('description')
            ->add('nom')
            ->add('prenom')
            ->add('fictionId')
            ->add('anneeNaissance')
            ->add('anneeMort')
            ->add('genre')
            ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => PersonnageIO::class,
            'csrf_protection' => false,
        ));
    }
}
