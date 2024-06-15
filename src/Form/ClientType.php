<?php
// src/Form/ClientType.php
namespace App\Form;

use App\Entity\Client;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('prenom', TextType::class, ['label' => 'Prénom'])
            ->add('nom', TextType::class, ['label' => 'Nom'])
            ->add('email', EmailType::class, ['label' => 'Email'])
            ->add('password', PasswordType::class, ['label' => 'Mot de passe'])
            ->add('siret', TextType::class, ['label' => 'SIRET', 'required' => false])
            ->add('entreprise', TextType::class, ['label' => 'Entreprise', 'required' => false])
            ->add('rue', TextType::class, ['label' => 'Rue'])
            ->add('ville', TextType::class, ['label' => 'Ville'])
            ->add('codePostal', TextType::class, ['label' => 'Code Postal'])
            ->add('pays', TextType::class, ['label' => 'Pays'])
            ->add('referenceClient', TextType::class, ['label' => 'Référence Client'])
            ->add('typeClient', TextType::class, ['label' => 'Type de Client'])
            ->add('coefficient', TextType::class, ['label' => 'Coefficient'])
            ->add('save', SubmitType::class, ['label' => 'Inscription']);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}
