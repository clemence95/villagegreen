<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240624064146 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC277FCA2A07');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67DFB88E14F');
        $this->addSql('CREATE TABLE adresse (id INT AUTO_INCREMENT NOT NULL, rue VARCHAR(255) NOT NULL, ville VARCHAR(255) NOT NULL, code_postal VARCHAR(50) NOT NULL, pays VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bon_de_livraison (id INT AUTO_INCREMENT NOT NULL, id_commande_id INT DEFAULT NULL, id_adresse_livraison_id INT DEFAULT NULL, date_livraison DATETIME NOT NULL, INDEX IDX_2F9D665B9AF8E3A3 (id_commande_id), INDEX IDX_2F9D665BB2DFFB91 (id_adresse_livraison_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, id_adresse_facturation_id INT DEFAULT NULL, id_adresse_livraison_id INT DEFAULT NULL, id_commercial_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, siret VARCHAR(14) DEFAULT NULL, entreprise VARCHAR(255) DEFAULT NULL, reference_client VARCHAR(255) NOT NULL, coefficient NUMERIC(10, 2) NOT NULL, telephone VARCHAR(50) NOT NULL, type_client VARCHAR(50) NOT NULL, UNIQUE INDEX UNIQ_C7440455DA25B551 (reference_client), INDEX IDX_C74404555B6CA5B3 (id_adresse_facturation_id), INDEX IDX_C7440455B2DFFB91 (id_adresse_livraison_id), INDEX IDX_C7440455C67CD679 (id_commercial_id), UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE coefficient (id INT AUTO_INCREMENT NOT NULL, type_client VARCHAR(50) NOT NULL, coefficient NUMERIC(10, 2) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE employe (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, email VARCHAR(50) NOT NULL, telephone VARCHAR(50) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_NOM (nom), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE facture (id INT AUTO_INCREMENT NOT NULL, id_commande_id INT DEFAULT NULL, id_adresse_facturation_id INT DEFAULT NULL, date_facture DATETIME NOT NULL, montant_total NUMERIC(10, 2) NOT NULL, statut_paiement VARCHAR(50) NOT NULL, UNIQUE INDEX UNIQ_FE8664109AF8E3A3 (id_commande_id), INDEX IDX_FE8664105B6CA5B3 (id_adresse_facturation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ligne_commande (id INT AUTO_INCREMENT NOT NULL, id_commande_id INT DEFAULT NULL, id_produit_id INT DEFAULT NULL, quantite INT NOT NULL, prix_unitaire NUMERIC(10, 2) NOT NULL, INDEX IDX_3170B74B9AF8E3A3 (id_commande_id), INDEX IDX_3170B74BAABEFE2C (id_produit_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bon_de_livraison ADD CONSTRAINT FK_2F9D665B9AF8E3A3 FOREIGN KEY (id_commande_id) REFERENCES commande (id)');
        $this->addSql('ALTER TABLE bon_de_livraison ADD CONSTRAINT FK_2F9D665BB2DFFB91 FOREIGN KEY (id_adresse_livraison_id) REFERENCES adresse (id)');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C74404555B6CA5B3 FOREIGN KEY (id_adresse_facturation_id) REFERENCES adresse (id)');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C7440455B2DFFB91 FOREIGN KEY (id_adresse_livraison_id) REFERENCES adresse (id)');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C7440455C67CD679 FOREIGN KEY (id_commercial_id) REFERENCES employe (id)');
        $this->addSql('ALTER TABLE facture ADD CONSTRAINT FK_FE8664109AF8E3A3 FOREIGN KEY (id_commande_id) REFERENCES commande (id)');
        $this->addSql('ALTER TABLE facture ADD CONSTRAINT FK_FE8664105B6CA5B3 FOREIGN KEY (id_adresse_facturation_id) REFERENCES adresse (id)');
        $this->addSql('ALTER TABLE ligne_commande ADD CONSTRAINT FK_3170B74B9AF8E3A3 FOREIGN KEY (id_commande_id) REFERENCES commande (id)');
        $this->addSql('ALTER TABLE ligne_commande ADD CONSTRAINT FK_3170B74BAABEFE2C FOREIGN KEY (id_produit_id) REFERENCES produit (id)');
        $this->addSql('ALTER TABLE commande_produit DROP FOREIGN KEY FK_DF1E9E8782EA2E54');
        $this->addSql('ALTER TABLE commande_produit DROP FOREIGN KEY FK_DF1E9E87F347EFB');
        $this->addSql('DROP TABLE utilisateur');
        $this->addSql('DROP TABLE commande_produit');
        $this->addSql('ALTER TABLE categorie DROP FOREIGN KEY FK_497DD634365BF48');
        $this->addSql('DROP INDEX IDX_497DD634365BF48 ON categorie');
        $this->addSql('ALTER TABLE categorie CHANGE nom nom VARCHAR(50) NOT NULL, CHANGE sous_categorie_id id_sous_categorie_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE categorie ADD CONSTRAINT FK_497DD634F252D75F FOREIGN KEY (id_sous_categorie_id) REFERENCES categorie (id)');
        $this->addSql('CREATE INDEX IDX_497DD634F252D75F ON categorie (id_sous_categorie_id)');
        $this->addSql('DROP INDEX IDX_6EEAA67DFB88E14F ON commande');
        $this->addSql('ALTER TABLE commande ADD id_adresse_facturation_id INT DEFAULT NULL, ADD id_adresse_livraison_id INT DEFAULT NULL, ADD id_client_id INT DEFAULT NULL, ADD montant_total NUMERIC(10, 2) NOT NULL, ADD reduction_supplementaire NUMERIC(10, 2) DEFAULT NULL, ADD mode_paiement VARCHAR(50) NOT NULL, DROP utilisateur_id, DROP total, DROP adresse_livraison, DROP adresse_facturation, DROP mode_reglement, DROP reduction, CHANGE statut statut VARCHAR(50) NOT NULL, CHANGE information_reglement information_reglement LONGTEXT NOT NULL, CHANGE date date_commande DATETIME NOT NULL');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D5B6CA5B3 FOREIGN KEY (id_adresse_facturation_id) REFERENCES adresse (id)');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67DB2DFFB91 FOREIGN KEY (id_adresse_livraison_id) REFERENCES adresse (id)');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D99DED506 FOREIGN KEY (id_client_id) REFERENCES client (id)');
        $this->addSql('CREATE INDEX IDX_6EEAA67D5B6CA5B3 ON commande (id_adresse_facturation_id)');
        $this->addSql('CREATE INDEX IDX_6EEAA67DB2DFFB91 ON commande (id_adresse_livraison_id)');
        $this->addSql('CREATE INDEX IDX_6EEAA67D99DED506 ON commande (id_client_id)');
        $this->addSql('ALTER TABLE fournisseur ADD id_adresse_id INT DEFAULT NULL, ADD importateur TINYINT(1) NOT NULL, ADD fabricant TINYINT(1) NOT NULL, CHANGE telephone telephone VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE fournisseur ADD CONSTRAINT FK_369ECA32E86D5C8B FOREIGN KEY (id_adresse_id) REFERENCES adresse (id)');
        $this->addSql('CREATE INDEX IDX_369ECA32E86D5C8B ON fournisseur (id_adresse_id)');
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC27670C757F');
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC27365BF48');
        $this->addSql('DROP INDEX IDX_29A5EC277FCA2A07 ON produit');
        $this->addSql('DROP INDEX IDX_29A5EC27670C757F ON produit');
        $this->addSql('DROP INDEX IDX_29A5EC27365BF48 ON produit');
        $this->addSql('ALTER TABLE produit ADD id_fournisseur_id INT DEFAULT NULL, ADD id_categorie_id INT DEFAULT NULL, ADD prix_achat NUMERIC(10, 2) NOT NULL, DROP fournisseur_id, DROP sous_categorie_id, DROP gestion_par_id, DROP prix_achat_ht, CHANGE libelle_long libelle_long LONGTEXT NOT NULL, CHANGE prix_vente prix_vente NUMERIC(10, 2) NOT NULL, CHANGE photo photo VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC275A6AC879 FOREIGN KEY (id_fournisseur_id) REFERENCES fournisseur (id)');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC279F34925F FOREIGN KEY (id_categorie_id) REFERENCES categorie (id)');
        $this->addSql('CREATE INDEX IDX_29A5EC275A6AC879 ON produit (id_fournisseur_id)');
        $this->addSql('CREATE INDEX IDX_29A5EC279F34925F ON produit (id_categorie_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D5B6CA5B3');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67DB2DFFB91');
        $this->addSql('ALTER TABLE fournisseur DROP FOREIGN KEY FK_369ECA32E86D5C8B');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D99DED506');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, nom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, prenom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, siret VARCHAR(14) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, entreprise VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, rue VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ville VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, code_postal VARCHAR(10) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, pays VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, reference_client VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, coefficient DOUBLE PRECISION DEFAULT NULL, type_client VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE commande_produit (commande_id INT NOT NULL, produit_id INT NOT NULL, INDEX IDX_DF1E9E8782EA2E54 (commande_id), INDEX IDX_DF1E9E87F347EFB (produit_id), PRIMARY KEY(commande_id, produit_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE commande_produit ADD CONSTRAINT FK_DF1E9E8782EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commande_produit ADD CONSTRAINT FK_DF1E9E87F347EFB FOREIGN KEY (produit_id) REFERENCES produit (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bon_de_livraison DROP FOREIGN KEY FK_2F9D665B9AF8E3A3');
        $this->addSql('ALTER TABLE bon_de_livraison DROP FOREIGN KEY FK_2F9D665BB2DFFB91');
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C74404555B6CA5B3');
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C7440455B2DFFB91');
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C7440455C67CD679');
        $this->addSql('ALTER TABLE facture DROP FOREIGN KEY FK_FE8664109AF8E3A3');
        $this->addSql('ALTER TABLE facture DROP FOREIGN KEY FK_FE8664105B6CA5B3');
        $this->addSql('ALTER TABLE ligne_commande DROP FOREIGN KEY FK_3170B74B9AF8E3A3');
        $this->addSql('ALTER TABLE ligne_commande DROP FOREIGN KEY FK_3170B74BAABEFE2C');
        $this->addSql('DROP TABLE adresse');
        $this->addSql('DROP TABLE bon_de_livraison');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE coefficient');
        $this->addSql('DROP TABLE employe');
        $this->addSql('DROP TABLE facture');
        $this->addSql('DROP TABLE ligne_commande');
        $this->addSql('DROP INDEX IDX_369ECA32E86D5C8B ON fournisseur');
        $this->addSql('ALTER TABLE fournisseur DROP id_adresse_id, DROP importateur, DROP fabricant, CHANGE telephone telephone VARCHAR(10) NOT NULL');
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC275A6AC879');
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC279F34925F');
        $this->addSql('DROP INDEX IDX_29A5EC275A6AC879 ON produit');
        $this->addSql('DROP INDEX IDX_29A5EC279F34925F ON produit');
        $this->addSql('ALTER TABLE produit ADD fournisseur_id INT DEFAULT NULL, ADD sous_categorie_id INT NOT NULL, ADD gestion_par_id INT DEFAULT NULL, ADD prix_achat_ht DOUBLE PRECISION NOT NULL, DROP id_fournisseur_id, DROP id_categorie_id, DROP prix_achat, CHANGE libelle_long libelle_long VARCHAR(255) NOT NULL, CHANGE prix_vente prix_vente DOUBLE PRECISION NOT NULL, CHANGE photo photo VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC27670C757F FOREIGN KEY (fournisseur_id) REFERENCES fournisseur (id)');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC277FCA2A07 FOREIGN KEY (gestion_par_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC27365BF48 FOREIGN KEY (sous_categorie_id) REFERENCES categorie (id)');
        $this->addSql('CREATE INDEX IDX_29A5EC277FCA2A07 ON produit (gestion_par_id)');
        $this->addSql('CREATE INDEX IDX_29A5EC27670C757F ON produit (fournisseur_id)');
        $this->addSql('CREATE INDEX IDX_29A5EC27365BF48 ON produit (sous_categorie_id)');
        $this->addSql('DROP INDEX IDX_6EEAA67D5B6CA5B3 ON commande');
        $this->addSql('DROP INDEX IDX_6EEAA67DB2DFFB91 ON commande');
        $this->addSql('DROP INDEX IDX_6EEAA67D99DED506 ON commande');
        $this->addSql('ALTER TABLE commande ADD utilisateur_id INT NOT NULL, ADD total DOUBLE PRECISION NOT NULL, ADD adresse_livraison VARCHAR(255) NOT NULL, ADD adresse_facturation VARCHAR(255) NOT NULL, ADD mode_reglement VARCHAR(255) NOT NULL, ADD reduction DOUBLE PRECISION DEFAULT NULL, DROP id_adresse_facturation_id, DROP id_adresse_livraison_id, DROP id_client_id, DROP montant_total, DROP reduction_supplementaire, DROP mode_paiement, CHANGE statut statut VARCHAR(255) NOT NULL, CHANGE information_reglement information_reglement VARCHAR(255) NOT NULL, CHANGE date_commande date DATETIME NOT NULL');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67DFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('CREATE INDEX IDX_6EEAA67DFB88E14F ON commande (utilisateur_id)');
        $this->addSql('ALTER TABLE categorie DROP FOREIGN KEY FK_497DD634F252D75F');
        $this->addSql('DROP INDEX IDX_497DD634F252D75F ON categorie');
        $this->addSql('ALTER TABLE categorie CHANGE nom nom VARCHAR(255) NOT NULL, CHANGE id_sous_categorie_id sous_categorie_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE categorie ADD CONSTRAINT FK_497DD634365BF48 FOREIGN KEY (sous_categorie_id) REFERENCES categorie (id)');
        $this->addSql('CREATE INDEX IDX_497DD634365BF48 ON categorie (sous_categorie_id)');
    }
}
