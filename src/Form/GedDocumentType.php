<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\GedDocument;
use App\Entity\GedCategorie;
use App\Entity\GedCategorieItem;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class GedDocumentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [])

            ->add('date', DateType::class, [
                'widget' => 'single_text',
                'required' => false,
            ])

            ->add('tags', TextType::class, [
                'label' => 'Mots-clés (séparés par des virgules)',
                'required' => false,
                'mapped' => false, // 🟢 clé du problème
            ])


            ->add('person', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'prenom',
                'expanded' => true,
                'multiple' => true,
            ])

            ->add('categorie', EntityType::class, [
                'class' => GedCategorie::class,
                'choice_label' => 'libelle',
            ])

            ->add('ItemCategorie', EntityType::class, [
                'class' => GedCategorieItem::class,
                'choice_label' => 'libelle',
            ])


            ->add('gscFile', FileType::class, [
                'mapped' => false,
                'label' => 'Fichier à envoyer',
                'required' => true,
                'attr' => ['accept' => '.pdf,.jpg,.png,.docx'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => GedDocument::class,
        ]);
    }
}
