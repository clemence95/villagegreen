<?php

namespace App\Form;

use App\Entity\Adresse;
use App\Entity\Client;
use App\Entity\Employe;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InscriptionFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')
            ->add('roles')
            ->add('password')
            ->add('nom')
            ->add('prenom')
            ->add('siret')
            ->add('entreprise')
            ->add('reference_client')
            ->add('coefficient')
            ->add('telephone')
            ->add('type_client')
            ->add('id_adresse_facturation', EntityType::class, [
                'class' => Adresse::class,
                'choice_label' => 'id',
            ])
            ->add('id_adresse_livraison', EntityType::class, [
                'class' => Adresse::class,
                'choice_label' => 'id',
            ])
            ->add('id_commercial', EntityType::class, [
                'class' => Employe::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}
