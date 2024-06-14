
```plantuml
@startuml
!theme toy
start
:Client consulte le catalogue;
:Client ajoute des produits au panier;
:Client valide son panier;

if (Client non connecté?) then (oui)
    :Système demande connexion ou inscription;
    :Client se connecte ou s'inscrit;
    if (Inscription?) then (oui)
        :Client remplit et soumet le formulaire d'inscription;
        :Système enregistre les détails du compte;
    endif
    if (Connexion réussie?) then (oui)
        :Système informe le client de la connexion réussie;
    else (non)
        :Système propose récupération de mot de passe;
        :Client réessaye de se connecter;
        if (Connexion réussie?) then (oui)
            :Système informe le client de la connexion réussie;
        else (non)
            :Système affiche un message d'erreur, proposer de contacter le support ou une nouvelle inscription;
            stop
        endif
    endif
endif

:Client connecté;
:Vérification des produits;
:Vérifier disponibilité des produits;
if (Produits disponibles?) then (oui)
else (non)
    :Système informe le client de l'indisponibilité;
    :Client modifie ou annule la commande;
    :Système alerte le gestionnaire des stocks;
    :Gestionnaire désactive le produit indisponible;
    repeat
        :Vérifier disponibilité des produits modifiés;
        if (Produits disponibles?) then (oui)
        else (non)
            :Système informe le client de l'indisponibilité;
            :Client modifie ou annule la commande;
        endif
    repeat while (Produits non disponibles)
endif

:Client confirme les adresses de livraison et de facturation;
:Vérification des adresses;

repeat
    :Vérifier adresse de livraison;
    if (Adresse de livraison valide?) then (oui)
    else (non)
        :Système informe le client de l'erreur d'adresse;
        :Client corrige l'adresse de livraison;
    endif
repeat while (Adresse de livraison non valide)

repeat
    :Vérifier adresse de facturation;
    if (Adresse de facturation valide?) then (oui)
    else (non)
        :Système informe le client de l'erreur d'adresse;
        :Client corrige l'adresse de facturation;
    endif
repeat while (Adresse de facturation non valide)

:Client choisit le mode de paiement;
:Traitement du paiement;
repeat
    if (Paiement réussi?) then (oui)
        :Système enregistre la commande;
        :Système met à jour les stocks;
        :Système envoie la confirmation par email;
        :Commande complétée;
    else (non)
        :Système informe le client de l'échec du paiement;
        :Client réessaye le paiement;
    endif
repeat while (Paiement non réussi)

stop
@enduml