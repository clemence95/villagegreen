<?php

namespace App\Form;

use App\Entity\Client;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class)
            ->add('password', PasswordType::class)
            ->add('nom', TextType::class)
            ->add('prenom', TextType::class)
            ->add('telephone', TextType::class)
            ->add('type_client', ChoiceType::class, [
                'choices' => [
                    'Particulier' => 'particulier',
                    'Professionnel' => 'professionnel',
                ],
                'placeholder' => 'Sélectionnez le type de client',
                'attr' => [
                    'id' => 'type_client', // Ensure this matches what you're querying in JavaScript
                ],
            ])
            ->add('siret', TextType::class, [
                'required' => false,
            ])
            ->add('entreprise', TextType::class, [
                'required' => false,
            ]);
            // Remove reference_client from the form
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => 'App\Entity\Client',
        ]);
    }
}









