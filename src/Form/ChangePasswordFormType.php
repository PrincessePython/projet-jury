<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class ChangePasswordFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => [
                    'attr' => [
                        'autocomplete' => 'new-password',
                        'class' => 'form-control mb-3'
                    ],
                    
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Entrez votre mot de passe',
                        ]),

                        new Regex([
                            'pattern' => '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{11,}$/ ',
                            'message' => 'Votre mot de passe doit contenir au moins 1 chiffre, 1 lettre majuscule et 1 lettre minuscule'
                        ]),
                            
                        new Length([
                            'min' => 11,
                            'minMessage' => 'Votre mot de passe doit contenir au moins {{ limit }} characters',
                            // max length allowed by Symfony for security reasons
                            'max' => 4096,
                        ]),
                    ],
                    'label' => 'Nouveau mot de passe ',
                    'attr' => [
                        'class' => 'form-control mb-3',
                    ],
    
                ],
                'second_options' => [
                    'attr' => [
                        'autocomplete' => 'new-password',
                        'class' => 'form-control mb-3',
                    ],
                    'label' => 'Repetez le mot de passe',
                ],
                'invalid_message' => 'Les mots de passes ne correspondent pas',
                // Instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }
}
