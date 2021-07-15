<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
//    Gabarit:
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('content')
//            On peut modifier les labels en passant directement par le gabarit, ainsi tous les formulaires liés au
//            gabarit seront modifiés
//            l'ordre étant => nom, TYPE du champ, options à passer (tableau)
            ->add('createdAt', DateType::class, [
                'widget'=>'single_text',
                'data'=> new \DateTime('NOW')
//                on modifie le format d'affichage de date, avec une date du jour 
            ])
            ->add('isPublished', CheckboxType::class, [
                'data'=>true
            ])
            //On utilise la classe existante SubmitType pour intégrer un boutton submit
            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
