<?php

namespace App\Form;

use App\Entity\Users;
use App\Entity\Addresses;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Validator\Constraints\Regex;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label'=> 'E-mail',
                'required' => true,
                'attr' => [
                    'placeholder'=> 'votre email',
                    'class' => 'form-control',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champs de doit pas être vide'
                    ]),
                    new Email([
                        'message' => 'Veuillez mettre une adresse email valide'
                    ]),
                ]
            ])
            
            ->add('last_name', TextType::class, [
                'label'=> 'Nom',
                'attr' => [
                    'placeholder'=> 'votre nom de famille',
                    'class' => 'form-control'
                ]
            ])
            
            ->add('first_name', TextType::class, [
                'label'=> 'Prénom',
                'attr' => [
                    'placeholder'=> 'votre prénom',
                    'class' => 'form-control'
                ]
            ])
            
            ->add('telephone', TextType::class, [
                'label'=> 'Téléphone',
                'attr' => [
                    'placeholder'=> 'votre numéro de téléphone',
                    'class' => 'form-control'
                ]
            ])

            ->add('date_of_birth', DateType::class, [
                'years' => range(1900, 2004),
                'label' => "Date de Naissance",
                'attr' => [
                   'placeholder'=> 'votre date de naissance',
                   'class' => 'form-control'
                ]
            ])

           
            ->add('RGPDConsent', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'J\'accepte les terms et les conditions.',
                    ]),
                ],
                'label'=> "J'accepte les termes et les conditions... "
            ])
            
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => [
                    'placeholder'=> 'votre mot de pass',
                    'autocomplete' => 'new-password',
                    'class'=> 'form-control',
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
            ]);
        }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }
}

