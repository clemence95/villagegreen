<?php

// src/Form/CommandeType.php

namespace App\Form;

use App\Entity\Commande;
use App\Entity\Adresse;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class CommandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id_adresse_livraison', EntityType::class, [
                'class' => Adresse::class,
                'choice_label' => function (Adresse $adresse) {
                    return $adresse->getRue() . ', ' . $adresse->getVille() . ', ' . $adresse->getCodePostal() . ', ' . $adresse->getPays();
                },
                'label' => 'Adresse de Livraison',
            ])
            ->add('id_adresse_facturation', EntityType::class, [
                'class' => Adresse::class,
                'choice_label' => function (Adresse $adresse) {
                    return $adresse->getRue() . ', ' . $adresse->getVille() . ', ' . $adresse->getCodePostal() . ', ' . $adresse->getPays();
                },
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
