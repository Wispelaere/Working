<?php

namespace App\Form;

use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'attr' => ['class' => 'form-control col-12'],
                'label' => 'Email'
            ])
            ->add('Last_Name', TextType::class, [
                'attr' => ['class' => 'form-control col-12'],
                'label'=> 'Nom'
            ])
            ->add('First_Name', TextType::class, [
                'attr' => ['class' => 'form-control col-12'],
                'label'=> 'Prénom'
            ])
            ->add('Adress', TextType::class, [
                'attr' => ['class' => 'form-control col-12'],
                'label'=> 'Adresse complète'
            ])
            ->add('Phone_Number', TextType::class, [
                'attr' => ['class' => 'form-control col-12'],
                'label'=> 'Numéro de téléphone'
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Vous devez accepter nos termes',
                    ]),
                ],
                'label'=> 'En m\'inscrivant à ce site, j\'accepte...'
            ])
            ->add('plainPassword', PasswordType::class, [
                'mapped' => false,
                'attr' => [
                    'autocomplete' => 'new-password',
                    'class' =>'form-control col-12'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer un mot de passe',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe doit contenir au moins {{ limit }} caractères',
                        'max' => 4096,
                    ]),
                ],
                'label'=> 'Mot de passe',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }
}
