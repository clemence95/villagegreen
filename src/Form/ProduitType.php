<?php

namespace App\Form;

use App\Entity\Categorie;
use App\Entity\Fournisseur;
use App\Entity\Produit;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libelleCourt')
            ->add('libelleLong')
            ->add('referenceFournisseur')
            ->add('prixAchat')
            ->add('prixVente')
            ->add('stock')
            ->add('actif', ChoiceType::class, [
                'choices' => [
                    'Oui' => true,
                    'Non' => false,
                ],
                'expanded' => true,
                'multiple' => false,
            ])
            ->add('photo')
            ->add('sousCategorie', EntityType::class, [
                'class' => Categorie::class,
                'choice_label' => 'nom',  
            ])
            ->add('idFournisseur', EntityType::class, [
                'class' => Fournisseur::class,
                'choice_label' => 'nom_entreprise',  
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}

