<?php

namespace App\Form;

use App\Component\IO\InscritIO;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InscritType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('pseudo')
            ->add('password')
            ->add('titre')
            ->add('description')
            ->add('prenom')
            ->add('nom')
            ->add('genre')
            ->add('dateNaissance')
            ->add('email', EmailType::class)
            ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => InscritIO::class,
            'csrf_protection' => false,
        ));
    }

}
