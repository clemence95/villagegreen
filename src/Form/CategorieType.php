<?php

// src/Form/CategorieType.php

namespace App\Form;

use App\Entity\Categorie;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategorieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('image')
            ->add('categorieParent', EntityType::class, [
                'class' => Categorie::class,
                'choice_label' => 'nom',
                'required' => false,
                'placeholder' => 'Aucune',
                'disabled' => $options['categorie_parent'] === false, // Désactiver si l'option est false
            ]);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Categorie::class,
            'categorie_parent' => true, // Par défaut, le champ catégorie parent est activé
        ]);
    }
}

