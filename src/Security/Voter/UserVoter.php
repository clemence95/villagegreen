<?php

// src/Security/Voter/UserVoter.php
namespace App\Security\Voter;

use App\Entity\Client;
use App\Entity\Employe;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class UserVoter extends Voter
{
    const EDIT = 'edit_user';
    const VIEW = 'view_user';

    protected function supports(string $attribute, $subject): bool
    {
        // Ce voter ne s'applique qu'aux entités Client et Employe
        return in_array($attribute, [self::EDIT, self::VIEW])
            && ($subject instanceof Client || $subject instanceof Employe);
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        // Si l'utilisateur n'est pas authentifié, on refuse l'accès
        if (!$user instanceof UserInterface) {
            return false;
        }

        // Vérifier l'accès pour un Client
        if ($subject instanceof Client) {
            return $this->canManageClient($attribute, $subject, $user);
        }

        // Vérifier l'accès pour un Employe
        if ($subject instanceof Employe) {
            return $this->canManageEmploye($attribute, $subject, $user);
        }

        return false;
    }

    private function canManageClient(string $attribute, Client $client, UserInterface $user): bool
    {
        // Seul le client peut voir ou éditer son propre profil
        return $user instanceof Client && $user->getId() === $client->getId();
    }

    private function canManageEmploye(string $attribute, Employe $employe, UserInterface $user): bool
    {
        // Seul l'employé peut voir ou éditer son propre profil
        return $user instanceof Employe && $user->getId() === $employe->getId();
    }
}
