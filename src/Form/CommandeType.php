<?php

// src/Form/CommandeType.php

namespace App\Form;

use App\Entity\Commande;
use App\Entity\Client;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class CommandeType extends AbstractType
{
    private $user;

    public function __construct(?Client $user)
    {
        $this->user = $user;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $isProfessional = $this->user && $this->user->getTypeClient() === 'professionnel';

        $builder
            ->add('id_adresse_livraison', AdresseType::class, [
                'label' => 'Adresse de Livraison',
            ])
            ->add('id_adresse_facturation', AdresseType::class, [
                'label' => 'Adresse de Facturation',
            ])
            ->add('mode_paiement', ChoiceType::class, [
                'choices' => $isProfessional
                    ? [
                        'Virement bancaire' => 'virement_bancaire',
                        'Chèque' => 'cheque',
                      ]
                    : [
                        'Carte de crédit' => 'carte_credit',
                        'PayPal' => 'paypal',
                        'Virement bancaire' => 'virement_bancaire',
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
            'user' => null,
        ]);
    }
}



