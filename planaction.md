# Plan d'Action pour le Projet de Gestion Commerciale

## 1. Regrouper les Utilisateurs sous une seule entité `User`

### Problème :
- Deux entités distinctes pour `Client` et `Employe` pourraient compliquer la gestion des utilisateurs.

### Solution :
- Regrouper les utilisateurs sous une seule entité `User` avec des rôles (par exemple, `ROLE_USER` pour les clients et `ROLE_ADMIN` pour les employés).

### Actions :
- Fusionner les entités `Client` et `Employe` dans une seule entité `User`.
- Mettre à jour les relations dans les autres entités qui référencent `Client` ou `Employe` pour utiliser `User` à la place.
- Assurer que la gestion des rôles est correctement mise en place pour différencier les permissions entre les utilisateurs (clients, employés, etc.).

---

## 2. Relation OneToMany entre `BonDeLivraison` et `Commande`

### Problème :
- `BonDeLivraison` est actuellement un attribut de l'entité `Commande`, mais il devrait être modélisé comme une entité distincte avec une relation OneToMany.

### Solution :
- Créer une entité `BonDeLivraison` distincte avec une relation ManyToOne vers `Commande`.

### Actions :
- Créer l'entité `BonDeLivraison`.
- Mettre en place une relation OneToMany entre `Commande` et `BonDeLivraison`.
- Mettre à jour la base de données avec les migrations nécessaires.

---

## 3. Sécuriser les APIs et Implémenter un Système de Voter

### Problème :
- Les APIs ne sont pas encore sécurisées et il n'y a pas de système de Voter en place pour gérer les permissions fines.

### Solution :
- Utiliser des Voters pour gérer les autorisations fines au niveau des actions.
- Sécuriser les routes de l'API en fonction des rôles des utilisateurs.

### Actions :
- Créer des Voters pour gérer les permissions d'accès aux ressources (produits, commandes, etc.).
- Configurer les règles de contrôle d'accès dans `security.yaml` pour restreindre l'accès aux routes en fonction des rôles.
- Tester les restrictions pour s'assurer que seules les personnes autorisées peuvent accéder aux ressources protégées.

---

## 4. Créer des Formulaires pour la Modification des Profils

### Problème :
- Les utilisateurs ne peuvent pas encore modifier leurs informations de profil.

### Solution :
- Créer un formulaire Symfony permettant aux utilisateurs de modifier leurs informations de profil.

### Actions :
- Créer un formulaire `UserType` pour la modification des profils.
- Mettre en place un contrôleur pour gérer l'affichage et le traitement du formulaire.
- Vérifier que seul l'utilisateur concerné peut modifier son profil en utilisant des Voters ou des contrôles d'accès.

---

## 5. Finaliser le CRUD pour la Gestion des Produits

### Problème :
- Le CRUD pour la gestion des produits est partiellement implémenté mais nécessite des ajustements.

### Solution :
- Compléter le CRUD pour gérer les produits et les catégories, et restreindre l'accès aux utilisateurs ayant le rôle `ROLE_ADMIN`.

### Actions :
- Finaliser le CRUD pour l'ajout, la modification, et la suppression de produits et de catégories.
- Assurer que les rôles sont correctement gérés et que seules les personnes autorisées peuvent accéder aux actions du CRUD.
- Implémenter une interface utilisateur intuitive pour la gestion des produits.

---

## 6. Implémenter le Tableau de Bord de Gestion

### Problème :
- Le tableau de bord de gestion n'est pas encore implémenté, bien qu'il soit une fonctionnalité clé demandée dans le cahier des charges.

### Solution :
- Créer un tableau de bord pour afficher les indicateurs de performance (chiffre d'affaires, TOP 10 des produits, etc.).

### Actions :
- Implémenter des requêtes pour calculer les indicateurs de performance (chiffre d'affaires mois par mois, produits les plus commandés, etc.).
- Utiliser une bibliothèque de graphiques (par ex. Chart.js) pour afficher les données de manière visuelle.
- Assurer que le tableau de bord est sécurisé et accessible uniquement aux administrateurs.
