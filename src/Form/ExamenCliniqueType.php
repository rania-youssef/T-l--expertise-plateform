<?php

namespace App\Form;

use App\Entity\ExamenClinique;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ExamenCliniqueType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        
            
            ->add('poids',TextType::class,[
                'label'=>'Poid actuel du patient :',
                'attr'=>[
                    'placeholder'=>'poids en (kg)']
                    ])
            ->add('EvolutionPoids', TextType::class,[
                'label'=>"Expliquez l'évolution du poids dans le temps :",
                'attr'=>[
                    'placeholder'=>"Exemple diminution de 10kg/mois.."
                ]
                ])
            ->add('taille',TextType::class,[
                'label'=>"Taille : ",
                'attr'=>[
                    'placeholder'=>"Taille en cm.."
                ]

                ])
            ->add('indiceMasse',TextType::class,[
                'label'=>"IMC :",
                'attr'=>[
                    'placeholder'=>"L’indice de masse corporelle.."
                ]
                ])
            ->add('EtatGenerale',TextType::class,[
                'label'=>"Etat générale du patient : "])
            ->add('images',FileType::class ,[
                'label'=> 'Importez des examens.. :',
                'multiple'=> true,
                'mapped'=> false,
                'required'=>false
            ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ExamenClinique::class,
        ]);
    }
}
