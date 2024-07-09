<?php

namespace App\Form;

use App\Entity\Adresse;
use App\Entity\Client;
use App\Entity\Employe;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;


class InscriptionFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // Si des champs doivent être exclus
        $excludeFields = $options['exclude_fields'] ?? [];

        $builder
            ->add('email', EmailType::class)
            ->add('password', PasswordType::class)
            ->add('nom', TextType::class)
            ->add('prenom', TextType::class)
            ->add('siret', TextType::class, [
                'required' => false,
            ])
            ->add('entreprise', TextType::class, [
                'required' => false,
            ])
            ->add('reference_client', TextType::class)
            ->add('telephone', TextType::class)
            ->add('type_client', ChoiceType::class, [
                'choices' => [
                    'Particulier' => 'particulier',
                    'Entreprise' => 'entreprise',
                ],
                'mapped' => false, // Ne pas mapper ce champ à l'entité Client
                'placeholder' => 'Sélectionner un type de client',
                'required' => true,
            ])
            ->add('id_adresse_facturation', EntityType::class, [
                'class' => Adresse::class,
                'choice_label' => 'id',
            ])
            ->add('id_adresse_livraison', EntityType::class, [
                'class' => Adresse::class,
                'choice_label' => 'id',
            ]);

        // Ajout dynamique du champ coefficient en fonction du type de client sélectionné
        $builder->addEventListener(FormEvents::POST_SET_DATA, function (FormEvent $event) {
            $form = $event->getForm();
            $client = $event->getData();

            if ($client && $client->getTypeClient() === 'professionnel') {
                $form->add('coefficientProfessionnel', IntegerType::class);
            } elseif ($client && $client->getTypeClient() === 'particulier') {
                $form->add('coefficientParticulier', IntegerType::class);
            }
        });

        // Exclure les champs spécifiés s'ils sont définis dans les options
        if (!in_array('id_commercial', $excludeFields)) {
            $builder->add('id_commercial', EntityType::class, [
                'class' => Employe::class,
                'choice_label' => 'id',
            ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
            'exclude_fields' => [], // Options personnalisées pour exclure certains champs
        ]);
    }
}





