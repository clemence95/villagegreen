<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240621231858 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE adresse (id INT AUTO_INCREMENT NOT NULL, rue VARCHAR(255) NOT NULL, ville VARCHAR(255) NOT NULL, code_postal VARCHAR(50) NOT NULL, pays VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bon_de_livraison (id INT AUTO_INCREMENT NOT NULL, id_commande_id INT DEFAULT NULL, id_adresse_livraison_id INT DEFAULT NULL, date_livraison DATETIME NOT NULL, INDEX IDX_2F9D665B9AF8E3A3 (id_commande_id), INDEX IDX_2F9D665BB2DFFB91 (id_adresse_livraison_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, id_sous_categorie_id INT DEFAULT NULL, nom VARCHAR(50) NOT NULL, INDEX IDX_497DD634F252D75F (id_sous_categorie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE coefficient (id INT AUTO_INCREMENT NOT NULL, type_client VARCHAR(50) NOT NULL, coefficient NUMERIC(10, 2) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commande (id INT AUTO_INCREMENT NOT NULL, id_adresse_facturation_id INT DEFAULT NULL, id_adresse_livraison_id INT DEFAULT NULL, id_client_id INT DEFAULT NULL, date_commande DATETIME NOT NULL, statut VARCHAR(50) NOT NULL, montant_total NUMERIC(10, 2) NOT NULL, reduction_supplementaire NUMERIC(10, 2) DEFAULT NULL, mode_paiement VARCHAR(50) NOT NULL, information_reglement LONGTEXT NOT NULL, INDEX IDX_6EEAA67D5B6CA5B3 (id_adresse_facturation_id), INDEX IDX_6EEAA67DB2DFFB91 (id_adresse_livraison_id), INDEX IDX_6EEAA67D99DED506 (id_client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE employe (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, email VARCHAR(50) NOT NULL, telephone VARCHAR(50) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_USERNAME (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE facture (id INT AUTO_INCREMENT NOT NULL, id_commande_id INT DEFAULT NULL, id_adresse_facturation_id INT DEFAULT NULL, date_facture DATETIME NOT NULL, montant_total NUMERIC(10, 2) NOT NULL, statut_paiement VARCHAR(50) NOT NULL, UNIQUE INDEX UNIQ_FE8664109AF8E3A3 (id_commande_id), INDEX IDX_FE8664105B6CA5B3 (id_adresse_facturation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fournisseur (id INT AUTO_INCREMENT NOT NULL, id_adresse_id INT DEFAULT NULL, nom_entreprise VARCHAR(255) NOT NULL, contact VARCHAR(255) NOT NULL, telephone VARCHAR(50) NOT NULL, siret VARCHAR(14) NOT NULL, importateur TINYINT(1) NOT NULL, fabricant TINYINT(1) NOT NULL, INDEX IDX_369ECA32E86D5C8B (id_adresse_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ligne_commande (id INT AUTO_INCREMENT NOT NULL, id_commande_id INT DEFAULT NULL, id_produit_id INT DEFAULT NULL, quantite INT NOT NULL, prix_unitaire NUMERIC(10, 2) NOT NULL, INDEX IDX_3170B74B9AF8E3A3 (id_commande_id), INDEX IDX_3170B74BAABEFE2C (id_produit_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE produit (id INT AUTO_INCREMENT NOT NULL, id_fournisseur_id INT DEFAULT NULL, id_categorie_id INT DEFAULT NULL, libelle_court VARCHAR(255) NOT NULL, libelle_long LONGTEXT NOT NULL, reference_fournisseur VARCHAR(255) NOT NULL, prix_achat NUMERIC(10, 2) NOT NULL, prix_vente NUMERIC(10, 2) NOT NULL, photo VARCHAR(255) DEFAULT NULL, stock INT NOT NULL, actif TINYINT(1) NOT NULL, INDEX IDX_29A5EC275A6AC879 (id_fournisseur_id), INDEX IDX_29A5EC279F34925F (id_categorie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bon_de_livraison ADD CONSTRAINT FK_2F9D665B9AF8E3A3 FOREIGN KEY (id_commande_id) REFERENCES commande (id)');
        $this->addSql('ALTER TABLE bon_de_livraison ADD CONSTRAINT FK_2F9D665BB2DFFB91 FOREIGN KEY (id_adresse_livraison_id) REFERENCES adresse (id)');
        $this->addSql('ALTER TABLE categorie ADD CONSTRAINT FK_497DD634F252D75F FOREIGN KEY (id_sous_categorie_id) REFERENCES categorie (id)');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D5B6CA5B3 FOREIGN KEY (id_adresse_facturation_id) REFERENCES adresse (id)');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67DB2DFFB91 FOREIGN KEY (id_adresse_livraison_id) REFERENCES adresse (id)');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D99DED506 FOREIGN KEY (id_client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE facture ADD CONSTRAINT FK_FE8664109AF8E3A3 FOREIGN KEY (id_commande_id) REFERENCES commande (id)');
        $this->addSql('ALTER TABLE facture ADD CONSTRAINT FK_FE8664105B6CA5B3 FOREIGN KEY (id_adresse_facturation_id) REFERENCES adresse (id)');
        $this->addSql('ALTER TABLE fournisseur ADD CONSTRAINT FK_369ECA32E86D5C8B FOREIGN KEY (id_adresse_id) REFERENCES adresse (id)');
        $this->addSql('ALTER TABLE ligne_commande ADD CONSTRAINT FK_3170B74B9AF8E3A3 FOREIGN KEY (id_commande_id) REFERENCES commande (id)');
        $this->addSql('ALTER TABLE ligne_commande ADD CONSTRAINT FK_3170B74BAABEFE2C FOREIGN KEY (id_produit_id) REFERENCES produit (id)');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC275A6AC879 FOREIGN KEY (id_fournisseur_id) REFERENCES fournisseur (id)');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC279F34925F FOREIGN KEY (id_categorie_id) REFERENCES categorie (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bon_de_livraison DROP FOREIGN KEY FK_2F9D665B9AF8E3A3');
        $this->addSql('ALTER TABLE bon_de_livraison DROP FOREIGN KEY FK_2F9D665BB2DFFB91');
        $this->addSql('ALTER TABLE categorie DROP FOREIGN KEY FK_497DD634F252D75F');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D5B6CA5B3');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67DB2DFFB91');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D99DED506');
        $this->addSql('ALTER TABLE facture DROP FOREIGN KEY FK_FE8664109AF8E3A3');
        $this->addSql('ALTER TABLE facture DROP FOREIGN KEY FK_FE8664105B6CA5B3');
        $this->addSql('ALTER TABLE fournisseur DROP FOREIGN KEY FK_369ECA32E86D5C8B');
        $this->addSql('ALTER TABLE ligne_commande DROP FOREIGN KEY FK_3170B74B9AF8E3A3');
        $this->addSql('ALTER TABLE ligne_commande DROP FOREIGN KEY FK_3170B74BAABEFE2C');
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC275A6AC879');
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC279F34925F');
        $this->addSql('DROP TABLE adresse');
        $this->addSql('DROP TABLE bon_de_livraison');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE coefficient');
        $this->addSql('DROP TABLE commande');
        $this->addSql('DROP TABLE employe');
        $this->addSql('DROP TABLE facture');
        $this->addSql('DROP TABLE fournisseur');
        $this->addSql('DROP TABLE ligne_commande');
        $this->addSql('DROP TABLE produit');
    }
}
