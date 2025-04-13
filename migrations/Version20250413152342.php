<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250413152342 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE adresse (id INT AUTO_INCREMENT NOT NULL, rue VARCHAR(255) NOT NULL, ville VARCHAR(255) NOT NULL, code_postal VARCHAR(50) NOT NULL, pays VARCHAR(255) NOT NULL, numero_rue VARCHAR(10) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, categorie_parent_id INT DEFAULT NULL, nom VARCHAR(50) NOT NULL, image VARCHAR(255) NOT NULL, INDEX IDX_497DD634DF25C577 (categorie_parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, id_commercial_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, siret VARCHAR(14) DEFAULT NULL, entreprise VARCHAR(255) DEFAULT NULL, reference_client VARCHAR(255) NOT NULL, coefficient NUMERIC(10, 2) NOT NULL, telephone VARCHAR(50) NOT NULL, type_client VARCHAR(50) NOT NULL, confirmation_token VARCHAR(100) DEFAULT NULL, is_email_confirmed TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_C7440455DA25B551 (reference_client), INDEX IDX_C7440455C67CD679 (id_commercial_id), UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commande (id INT AUTO_INCREMENT NOT NULL, adresse_facturation_id INT DEFAULT NULL, adresse_livraison_id INT DEFAULT NULL, client_id INT DEFAULT NULL, employe_id INT DEFAULT NULL, date_commande DATETIME NOT NULL, statut VARCHAR(50) NOT NULL, montant_total NUMERIC(10, 2) NOT NULL, reduction_supplementaire NUMERIC(10, 2) DEFAULT NULL, mode_paiement VARCHAR(50) NOT NULL, information_reglement LONGTEXT NOT NULL, INDEX IDX_6EEAA67D5BBD1224 (adresse_facturation_id), INDEX IDX_6EEAA67DBE2F0A35 (adresse_livraison_id), INDEX IDX_6EEAA67D19EB6921 (client_id), INDEX IDX_6EEAA67D1B65292 (employe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commande_produit (id INT AUTO_INCREMENT NOT NULL, commande_id INT NOT NULL, produit_id INT NOT NULL, quantite NUMERIC(10, 2) NOT NULL, INDEX IDX_DF1E9E8782EA2E54 (commande_id), INDEX IDX_DF1E9E87F347EFB (produit_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE document (id INT AUTO_INCREMENT NOT NULL, commande_id INT NOT NULL, type VARCHAR(50) NOT NULL, date_creation DATETIME NOT NULL, file_name VARCHAR(255) NOT NULL, INDEX IDX_D8698A7682EA2E54 (commande_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE employe (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, email VARCHAR(50) NOT NULL, telephone VARCHAR(50) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_NOM (nom), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fournisseur (id INT AUTO_INCREMENT NOT NULL, id_adresse_id INT DEFAULT NULL, nom_entreprise VARCHAR(255) NOT NULL, contact VARCHAR(255) DEFAULT NULL, telephone VARCHAR(50) NOT NULL, siret VARCHAR(14) NOT NULL, importateur TINYINT(1) NOT NULL, fabricant TINYINT(1) NOT NULL, INDEX IDX_369ECA32E86D5C8B (id_adresse_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE produit (id INT AUTO_INCREMENT NOT NULL, sous_categorie_id INT NOT NULL, id_fournisseur_id INT NOT NULL, libelle_court VARCHAR(50) NOT NULL, libelle_long VARCHAR(255) NOT NULL, reference_fournisseur VARCHAR(50) NOT NULL, prix_achat NUMERIC(10, 2) NOT NULL, stock INT NOT NULL, actif TINYINT(1) NOT NULL, prix_vente NUMERIC(10, 2) NOT NULL, photo VARCHAR(255) NOT NULL, INDEX IDX_29A5EC27365BF48 (sous_categorie_id), INDEX IDX_29A5EC275A6AC879 (id_fournisseur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE categorie ADD CONSTRAINT FK_497DD634DF25C577 FOREIGN KEY (categorie_parent_id) REFERENCES categorie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C7440455C67CD679 FOREIGN KEY (id_commercial_id) REFERENCES employe (id)');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D5BBD1224 FOREIGN KEY (adresse_facturation_id) REFERENCES adresse (id)');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67DBE2F0A35 FOREIGN KEY (adresse_livraison_id) REFERENCES adresse (id)');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D19EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D1B65292 FOREIGN KEY (employe_id) REFERENCES employe (id)');
        $this->addSql('ALTER TABLE commande_produit ADD CONSTRAINT FK_DF1E9E8782EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id)');
        $this->addSql('ALTER TABLE commande_produit ADD CONSTRAINT FK_DF1E9E87F347EFB FOREIGN KEY (produit_id) REFERENCES produit (id)');
        $this->addSql('ALTER TABLE document ADD CONSTRAINT FK_D8698A7682EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id)');
        $this->addSql('ALTER TABLE fournisseur ADD CONSTRAINT FK_369ECA32E86D5C8B FOREIGN KEY (id_adresse_id) REFERENCES adresse (id)');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC27365BF48 FOREIGN KEY (sous_categorie_id) REFERENCES categorie (id)');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC275A6AC879 FOREIGN KEY (id_fournisseur_id) REFERENCES fournisseur (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE categorie DROP FOREIGN KEY FK_497DD634DF25C577');
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C7440455C67CD679');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D5BBD1224');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67DBE2F0A35');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D19EB6921');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D1B65292');
        $this->addSql('ALTER TABLE commande_produit DROP FOREIGN KEY FK_DF1E9E8782EA2E54');
        $this->addSql('ALTER TABLE commande_produit DROP FOREIGN KEY FK_DF1E9E87F347EFB');
        $this->addSql('ALTER TABLE document DROP FOREIGN KEY FK_D8698A7682EA2E54');
        $this->addSql('ALTER TABLE fournisseur DROP FOREIGN KEY FK_369ECA32E86D5C8B');
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC27365BF48');
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC275A6AC879');
        $this->addSql('DROP TABLE adresse');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE commande');
        $this->addSql('DROP TABLE commande_produit');
        $this->addSql('DROP TABLE document');
        $this->addSql('DROP TABLE employe');
        $this->addSql('DROP TABLE fournisseur');
        $this->addSql('DROP TABLE produit');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
