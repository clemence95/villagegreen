<?php

// src/Form/CommandeType.php

namespace App\Form;

use App\Entity\Commande;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class CommandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id_adresse_livraison', AdresseType::class, [
                'label' => 'Adresse de Livraison',
            ])
            ->add('id_adresse_facturation', AdresseType::class, [
                'label' => 'Adresse de Facturation',
            ])
            ->add('mode_paiement', ChoiceType::class, [
                'choices' => [
                    'Carte de crédit' => 'carte_credit',
                    'PayPal' => 'paypal',
                    'Virement bancaire' => 'virement_bancaire',
                    'Chèque' => 'cheque',
                ],
                'label' => 'Mode de Paiement',
            ])
            ->add('information_reglement', TextareaType::class, [
                'label' => 'Information de Règlement',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Commande::class,
        ]);
    }
}


