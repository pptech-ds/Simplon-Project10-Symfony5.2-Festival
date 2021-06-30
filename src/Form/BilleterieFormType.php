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

class BilleterieFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {       
        
        $builder
            ->add('lastname', TextType::class, ['label' => 'Nom'])
            ->add('firstname', TextType::class, ['label' => 'Prénom'])
            ->add('phone', TextType::class, ['label' => 'Telephone'])
            // ->add('email', EmailType::class, [
            //     'label' => 'Email',
            //     'disabled' => true
            //     ])
            // // ->add('artist', TextType::class, ['label' => 'Artiste'])
            // ->add('artist', ChoiceType::class, [
            //     'label' => 'Artiste',
            //     'choices'  => [
            //         'DJ Laine' => 'DJ Laine',
            //         'DJ Buisson' => 'DJ Buisson',
            //         'DJ Bailly' => 'DJ Bailly',
            //         'DJ Lebrun' => 'DJ Lebrun',
            //         'DJ Joseph' => 'DJ Joseph',
            //         'DJ David' => 'DJ David',
            //         'DJ Le Roux' => 'DJ Le Roux',
            //         'DJ Picard' => 'DJ Picard',
            //         'DJ Riou' => 'DJ Riou',
            //         ]
            //     ])
            // // ->add('date', TextType::class, ['label' => 'Date'])
            // ->add('date', ChoiceType::class, [
            //     'label' => 'Date',
            //     'choices'  => [
            //         '20/08/2021' => '20/08/2021',
            //         '21/08/2021' => '21/08/2021',
            //         '22/08/2021' => '22/08/2021',
            //         ]
            //     ])
            // // ->add('plage', TextType::class, ['label' => 'Plage'])
            // ->add('plage', ChoiceType::class, [
            //     'label' => 'Plage',
            //     'choices'  => [
            //         '16h - 18h' => '16h - 18h',
            //         '18h - 20h' => '18h - 20h',
            //         '21h - 23h' => '21h - 23h',
            //         ]
            //     ])
            // ->add('nbTickets', IntegerType::class, ['label' => 'Nombre de place'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
