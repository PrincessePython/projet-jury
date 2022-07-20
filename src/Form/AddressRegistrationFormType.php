<?php

namespace App\Form;

use App\Entity\Users;
use App\Entity\Addresses;
use Symfony\Component\Form\AbstractType;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class AddressRegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('address', TextType::class, [
                'label'=> 'Adresse',
                'attr' => [
                    'placeholder' => 'ex: 1 rue d\'Eglise ',
                    'class' => 'form-control',
                ]
            ])

            ->add('zipcode', TextType::class, [
                'label' => 'Code postale',
                'attr' => [
                    'placeholder' => 'ex: 75000',
                    'class' => 'form-control',
                ]
            ])

            ->add('city', TextType::class, [
                'label' => 'Ville',
                'attr' => [
                    'placeholder' => 'ex: Paris',
                    'class' => 'form-control',
                ]

            ])

            ->add('country', TextType::class, [
                'label' => 'Pays',
                'attr' => [
                    'placeholder' => 'ex: France',
                    'class' => 'form-control',
                ]

                ]);
            // ->add('users_id', EntityType::class, [
            //     'class'=> Users::class
            // ]);


    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Addresses::class,
        ]);
    }
}
