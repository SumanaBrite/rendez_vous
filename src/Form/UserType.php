<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $user = $options["data"]; // On récupére l'objet qui est lié au formulaire

        $builder
            ->add('email')
            
            ->add('password', PasswordType::class, [
                "mapped" => false,
                "required" => $user->getId()?false : true /* soit getId() est null donc considéré comme false  soit getId() n'est pas null donc considéré comme 
                true(parce qu'il ne peut pas etre égal à 0)*/
            ])
            ->add('nom')
            ->add('prenom')
            ->add('roles', ChoiceType::class, ["choices" => [
                "Lecteur" =>"ROLE_CLIENT",
                "Employee" => "ROLE_EMPLOYEE",
                "Administrateur" =>"ROLE_ADMIN"
            ],
            "multiple" => true,
            "expanded" => true
            ])
            ->add('telephone')
            ->add('noRue')
            ->add('rue')
            ->add('codePostale')
            ->add('ville')
            ->add('isVerified')
            ->add("enregistrer", SubmitType::class, [
                "attr" => ["class" => "btn btn-success"
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
