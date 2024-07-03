<?php
namespace App\Form;

use App\Entity\Announces;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnnounceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Name_Announce', TextType::class, [
                'label' => 'Name',
            ])
            ->add('Description_Announce', TextareaType::class, [
                'label' => 'Description',
            ])
            ->add('Date_Sent', DateTimeType::class, [
                'widget' => 'single_text',
                'label' => 'Date Sent',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Announces::class,
        ]);
    }
}
