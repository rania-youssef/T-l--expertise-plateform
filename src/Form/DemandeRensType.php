<?php

namespace App\Form;

use App\Entity\DemandeRens;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DemandeRensType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('trais', ChoiceType::class, array(
            'choices'=>  array(
         "à sa santé ou à son dossier médical, y compris les renseignements 
         d’ordre génétique le concernantà sa santé ou à son dossier médical,
          y compris les renseignements d’ordre génétique le concernant"=>"à sa santé ou à son dossier médical, y compris les renseignements 
          d’ordre génétique le concernantà sa santé ou à son dossier médical,
          y compris les renseignements d’ordre génétique le concernant",
         "aux soins de santé qui lui sont fournis"=>"aux soins de santé qui lui sont fournis",
         'au paiement des soins de santé qui lui sont fournis.'=> 'au paiement des soins de santé qui lui sont fournis.',
          ),
          'expanded' => true,
          'multiple' => true
          ))
          ->add('Message', TextType::class)
          ->add('besoins' , ChoiceType::class, array(
            'choices'=>  array(
         "pour en savoir davantage sur vos antécédents médicaux et les soins qui vous ont été fournis"
         =>"pour en savoir davantage sur vos antécédents médicaux et les soins qui vous ont été fournis",
         "pour obtenir les renseignements exigés lors de la souscription d’une assurance vie ou d’une assurance maladie"
         =>"pour obtenir les renseignements exigés lors de la souscription d’une assurance vie ou d’une assurance maladie",
          ),
          'expanded' => true,
          'multiple' => true
          ))
           ->add('Envoyer', SubmitType::class, ['label' => 'Envoyer'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => DemandeRens::class,
        ]);
    }
}
