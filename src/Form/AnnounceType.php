<?php

namespace App\Form;

use App\Entity\Announces;
use App\Entity\Users;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class AnnounceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Name_Announce', TextType::class, [
                'label' => 'Nom de l\'annonce'
            ])
            ->add('Description_Announce', TextareaType::class, [
                'label' => 'Description de l\'annonce'
            ])
            ->add('Date_Sent', DateTimeType::class, [
                'widget' => 'single_text',
                'label' => 'Date d\'envoi'
            ])
            ->add('parent', EntityType::class, [
                'class' => Users::class,
                'choice_label' => 'id',
                'label' => 'Utilisateur associé'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Announces::class,
        ]);
    }
}
