<?php

// src/Form/CommandeType.php

namespace App\Form;

use App\Entity\Commande;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;

class CommandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date_commande', DateTimeType::class, [
                'label' => 'Date de la commande',
            ])
            ->add('statut', TextType::class, [
                'label' => 'Statut',
            ])
            ->add('montant_total', MoneyType::class, [
                'label' => 'Montant total',
            ])
            ->add('reduction_supplementaire', MoneyType::class, [
                'label' => 'Réduction supplémentaire',
                'required' => false,
            ])
            ->add('mode_paiement', TextType::class, [
                'label' => 'Mode de paiement',
            ])
            ->add('information_reglement', TextType::class, [
                'label' => 'Information de règlement',
            ])
            ->add('id_adresse_facturation', TextType::class, [
                'label' => 'Adresse de facturation',
            ])
            ->add('id_adresse_livraison', TextType::class, [
                'label' => 'Adresse de livraison',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Commande::class,
        ]);
    }
}
