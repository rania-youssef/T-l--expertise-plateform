<?php

namespace App\Form;

use App\Entity\Demande;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class DemandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('nom',TextType::class,[
            'label'=>'Nom et Prénom du patient'
        ])
        ->add('datenaiss', DateType::class, [
            'widget' => 'single_text',
            // this is actually the default format for single_text
            'format' => 'yyyy-MM-dd',
            'label' =>'Date de naissance'
        ])
        ->add('Initiale_Patient', TextType::class,[
            'attr'=> [
            'placeholder' => " L'évaluation initiale du patient.."]
        ])
        ->add('Explicatif',TextType::class,[
            'attr'=>[
            'placeholder' => ' Evaluation, diagnostic ,prise en charge.. ']
        ])
        ->add('niveauUrganece',ChoiceType::class,array(
            'choices'  => array(
                '24h' => 24,
                '72h' => 72,
                '7j' => 7,),
            'expanded' => true,
            'multiple' => false
        ))
        ->add('Enregistrer', SubmitType::class, ['label' => 'Enregistrer'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Demande::class,
        ]);
    }
}
