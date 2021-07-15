<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Tag;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
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
//          On ajoute un lien vers l'entité 'Category' afin de choisir une catégorie pour l'article, ainsi
//                Symfonie gère automatiquement les liens id entres les deux tables.
            ->add('category', EntityType::class, [
                'class'=>Category::class,
                'choice_label'=> 'title'
            ])
            ->add('tag', EntityType::class, [
                'class'=>Tag::class,
                'choice_label'=>'title'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
