<?php
namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class UtilisateurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('prenom', TextType::class, ['label' => 'Prénom'])
            ->add('nom', TextType::class, ['label' => 'Nom'])
            ->add('email', EmailType::class, ['label' => 'Email'])
            ->add('plainPassword', PasswordType::class, ['label' => 'Mot de passe'])
            ->add('typeClient', ChoiceType::class, [
                'label' => 'Type de Client',
                'choices' => [
                    'Particulier' => 'particulier',
                    'Professionnel' => 'professionnel',
                ],
                'expanded' => true,
                'multiple' => false,
            ])
            ->add('siret', TextType::class, [
                'label' => 'SIRET',
                'required' => false,
                'attr' => ['class' => 'siret-field'],
            ])
            ->add('entreprise', TextType::class, [
                'label' => 'Entreprise',
                'required' => false,
                'attr' => ['class' => 'entreprise-field'],
            ])
            ->add('rue', TextType::class, ['label' => 'Rue'])
            ->add('ville', TextType::class, ['label' => 'Ville'])
            ->add('codePostal', TextType::class, ['label' => 'Code Postal'])
            ->add('pays', TextType::class, ['label' => 'Pays'])
            ->add('save', SubmitType::class, ['label' => 'Inscription']);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
}







