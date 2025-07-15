<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\GedCategorie;
use App\Entity\GedCategorieItem;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class GedDocumentSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'required' => false,
                'label' => 'Titre',
            ])
            ->add('date', DateType::class, [
                'widget' => 'single_text',
                'required' => false,
                'label' => 'Date',
            ])
            ->add('tags', TextType::class, [
                'label' => 'Mots-clés (séparés par des virgules)',
                'required' => false,
            ])
            ->add('person', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'prenom',
                'expanded' => true,
                'multiple' => true,
                'required' => false,
                'label' => 'Personnes',
            ])
            ->add('categorie', EntityType::class, [
                'class' => GedCategorie::class,
                'choice_label' => 'libelle',
                'required' => false,
                'label' => 'Catégorie',
            ])
            ->add('ItemCategorie', EntityType::class, [
                'class' => GedCategorieItem::class,
                'choice_label' => 'libelle',
                'required' => false,
                'label' => 'Sous-catégorie',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'csrf_protection' => false,
            'method' => 'GET',
        ]);
    }
}
