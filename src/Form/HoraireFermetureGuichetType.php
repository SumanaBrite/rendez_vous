<?php

namespace App\Form;

use App\Entity\Guichet;
use App\Entity\Horaire;
use App\Entity\HoraireFermetureGuichet;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HoraireFermetureGuichetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('jour')
            //->add('guichet')
            ->add('guichet', EntityType::class, [
                'label' => 'Guichet :',
                // 'mapped' => false,
                'required' => true,
                'placeholder' => '-- Choisissez le Guichet --',
                'class' => Guichet::class,
                'choice_label' => 'nom',
            ])
            //->add('horaire')
            ->add('horaire', EntityType::class, [
                'label' => 'Guichet :',
                // 'mapped' => false,
                'required' => true,
                'placeholder' => '-- Choisissez le Guichet --',
                'class' => Horaire::class,
                'choice_label' => 'nom',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => HoraireFermetureGuichet::class,
        ]);
    }
}
