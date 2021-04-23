<?php

namespace App\Form;

use App\Entity\ExamenATCD;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
class ExamenATCDType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Pathologie',ChoiceType::class, [
                'choices'=>  array(
                "Pathologie clinique"=>"Pathologie clinique",
                "Anatomo-pathologie"=>"Anatomo-pathologie"
                )
                ])
            ->add('Habitude',TextType::class)
            ->add('Profession',TextType::class)
            ->add('Images',FileType::class,[
                'label'=>false,
                'multiple'=> true,
                'mapped'=> false,
                'required'=>false
                ])
            ->add('Enregistrer', SubmitType::class, ['label' => 'Enregistrer'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ExamenATCD::class,
        ]);
    }
}
