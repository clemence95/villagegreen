<?php

// src/Form/SearchFormType.php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('search', TextType::class, [
                'label' => 'Terme de recherche',
                'required' => true,
            ])
            ->add('type', ChoiceType::class, [
                'label' => 'Type de recherche',
                'choices' => [
                    'Catégorie' => 'categorie',
                    'Sous-catégorie' => 'sous_categorie',
                    'Produit' => 'produit',
                ],
                'required' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Décommentez la ligne suivante si vous utilisez un formulaire sans entité
            // 'data_class' => null,
        ]);
    }
}
