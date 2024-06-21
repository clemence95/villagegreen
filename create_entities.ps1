# Fonction pour créer une entité avec des champs
function Create-Entity {
    param (
        [string]$EntityName,
        [array]$Fields
    )
    
    Write-Output "Creating entity $EntityName"
    php bin/console make:entity $EntityName | Out-Null
    foreach ($field in $Fields) {
        php bin/console make:entity $EntityName $field | Out-Null
    }
}

# Créer l'entité Adresse
Create-Entity -EntityName "Adresse" -Fields @("rue:VARCHAR(255)", "ville:VARCHAR(255)", "code_postal:VARCHAR(50)", "pays:VARCHAR(255)")

# Créer l'entité Client
Create-Entity -EntityName "Client" -Fields @(
    "nom:VARCHAR(255)",
    "prenom:VARCHAR(255)",
    "email:VARCHAR(50)",
    "password:VARCHAR(255)",
    "siret:VARCHAR(14)",
    "entreprise:VARCHAR(255)",
    "reference_client:VARCHAR(255) unique",
    "coefficient:DECIMAL(10,2)",
    "telephone:VARCHAR(50)",
    "type_client:VARCHAR(50)",
    "id_adresse_facturation:ManyToOne:Adresse",
    "id_adresse_livraison:ManyToOne:Adresse",
    "id_commercial:ManyToOne:Commercial"
)

# Créer l'entité Employe
Create-Entity -EntityName "Employe" -Fields @("nom:VARCHAR(255)", "prenom:VARCHAR(255)", "role:VARCHAR(255)", "email:VARCHAR(50)", "telephone:VARCHAR(50)")

# Créer l'entité Commercial
Create-Entity -EntityName "Commercial" -Fields @("nom:VARCHAR(255)", "prenom:VARCHAR(255)", "email:VARCHAR(50)", "telephone:VARCHAR(50)", "type_commercial:VARCHAR(50)")

# Créer l'entité Fournisseur
Create-Entity -EntityName "Fournisseur" -Fields @(
    "nom_entreprise:VARCHAR(255)",
    "contact:VARCHAR(255)",
    "telephone:VARCHAR(50)",
    "siret:VARCHAR(14)",
    "importateur:BOOLEAN",
    "fabricant:BOOLEAN",
    "id_adresse:ManyToOne:Adresse"
)

# Créer l'entité Categorie
Create-Entity -EntityName "Categorie" -Fields @("nom:VARCHAR(50)", "id_sousCategorie:ManyToOne:Categorie")

# Créer l'entité Produit
Create-Entity -EntityName "Produit" -Fields @(
    "libelle_court:VARCHAR(255)",
    "libelle_long:TEXT",
    "reference_fournisseur:VARCHAR(255)",
    "prix_achat:DECIMAL(10,2)",
    "prix_vente:DECIMAL(10,2)",
    "photo:VARCHAR(255)",
    "stock:INT",
    "actif:BOOLEAN",
    "id_fournisseur:ManyToOne:Fournisseur",
    "id_categorie:ManyToOne:Categorie"
)

# Créer l'entité Commande
Create-Entity -EntityName "Commande" -Fields @(
    "date_commande:DATETIME",
    "statut:VARCHAR(50)",
    "montant_total:DECIMAL(10,2)",
    "reduction_supplementaire:DECIMAL(10,2)",
    "mode_paiement:VARCHAR(50)",
    "information_reglement:TEXT",
    "id_adresse_facturation:ManyToOne:Adresse",
    "id_adresse_livraison:ManyToOne:Adresse",
    "id_client:ManyToOne:Client"
)

# Créer l'entité LigneCommande
Create-Entity -EntityName "LigneCommande" -Fields @("quantite:INT", "prix_unitaire:DECIMAL(10,2)", "id_commande:ManyToOne:Commande", "id_produit:ManyToOne:Produit")

# Créer l'entité BonDeLivraison
Create-Entity -EntityName "BonDeLivraison" -Fields @("id_commande:ManyToOne:Commande", "date_livraison:DATETIME", "id_adresse_livraison:ManyToOne:Adresse")

# Créer l'entité Facture
Create-Entity -EntityName "Facture" -Fields @("id_commande:OneToOne:Commande", "date_facture:DATETIME", "montant_total:DECIMAL(10,2)", "statut_paiement:VARCHAR(50)", "id_adresse_facturation:ManyToOne:Adresse")

# Créer l'entité Coefficient
Create-Entity -EntityName "Coefficient" -Fields @("type_client:VARCHAR(50)", "coefficient:DECIMAL(10,2)")

# Générer les migrations
php bin/console make:migration

# Exécuter les migrations
php bin/console doctrine:migrations:migrate

Write-Output "Entities created and migrations executed successfully."
