<?php

// src/Form/AdresseType.php

namespace App\Form;

use App\Entity\Adresse;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class AdresseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('rue', TextType::class, [
                'label' => 'Rue',
            ])
            ->add('ville', TextType::class, [
                'label' => 'Ville',
            ])
            ->add('code_postal', TextType::class, [
                'label' => 'Code Postal',
            ])
            ->add('pays', TextType::class, [
                'label' => 'Pays',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Adresse::class,
        ]);
    }
}
