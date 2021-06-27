<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class BilleterieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lastname', TextType::class, ['label' => 'Nom'])
            ->add('firstname', TextType::class, ['label' => 'Prénom'])
            ->add('phone', TextType::class, ['label' => 'Telephone'])
            ->add('email', EmailType::class, ['label' => 'Email'])
            ->add('artist', TextType::class, ['label' => 'Artiste'])
            ->add('date', TextType::class, ['label' => 'Date'])
            ->add('time', TextType::class, ['label' => 'Plage'])
            // ->add('Date', DateType::class, [
            //     'widget' => 'single_text',
            //     // this is actually the default format for single_text
            //     'format' => 'yyyy-MM-dd',
            // ])
            // ->add('Heure', TextType::class)
            // ->add('HeurePlage', ChoiceType::class, [
            //     'choices'  => [
            //         '16h - 18h' => true,
            //         '18h - 20h' => true,
            //         '21h - 23h' => true,
            //     ],
            //])
            ->add('nbTickets', IntegerType::class, ['label' => 'Nombre de place'])
            // ->add('Envoyer', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
