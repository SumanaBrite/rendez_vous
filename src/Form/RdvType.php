<?php

namespace App\Form;

use App\Entity\Rdv;
use App\Entity\Creneau;
use App\Entity\Guichet;
use App\Entity\Horaire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RdvType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('jour')
            // ->add('guichet')
            ->add('guichet', EntityType::class, [
                'label' => 'Guichet :',
                // 'mapped' => false,
                'required' => true,
                'placeholder' => '-- Choisissez le Guichet --',
                'class' => Guichet::class,
                'choice_label' => 'nom',
            ])
            ->add('horaire', EntityType::class, [
                'label' => 'Horaire :',
                // 'mapped' => false,
                'required' => true,
                'placeholder' => '-- Choisissez l horaire --',
                'class' => Horaire::class,
                'choice_label' => 'nom',
            ])
            // ->add('creneau')
            ->add('creneau', EntityType::class, [
                'label' => 'Créneau :',
                // 'mapped' => false,
                'required' => true,
                'placeholder' => '-- Choisissez le créneau --',
                'class' => Creneau::class,
                'choice_label' => 'description',
            ])

            // ->add('email')
            // ->add('email', EntityType::class, [
            //     'label' => 'Email :',
            //     // 'mapped' => false,
            //     'required' => true,
            //     'placeholder' => '-- Choisissez le user --',
            //     'class' => User::class,
            //     'choice_label' => 'email',
            // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Rdv::class,
        ]);
    }
}
