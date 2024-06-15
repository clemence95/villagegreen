<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240615173602 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, categorie_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, INDEX IDX_497DD634BCF5E72D (categorie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, commercial_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, siret VARCHAR(14) DEFAULT NULL, entreprise VARCHAR(255) DEFAULT NULL, rue VARCHAR(255) NOT NULL, ville VARCHAR(255) NOT NULL, code_postal VARCHAR(255) NOT NULL, pays VARCHAR(255) NOT NULL, reference_client VARCHAR(255) NOT NULL, type_client VARCHAR(20) NOT NULL, coefficient DOUBLE PRECISION NOT NULL, INDEX IDX_C74404557854071C (commercial_id), UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commande (id INT AUTO_INCREMENT NOT NULL, client_id INT DEFAULT NULL, reduction_geree_par_id INT DEFAULT NULL, date DATETIME NOT NULL, total DOUBLE PRECISION NOT NULL, statut VARCHAR(255) NOT NULL, adresse_livraison VARCHAR(255) NOT NULL, adresse_facturation VARCHAR(255) NOT NULL, mode_reglement VARCHAR(255) NOT NULL, information_reglement VARCHAR(255) NOT NULL, reduction DOUBLE PRECISION NOT NULL, INDEX IDX_6EEAA67D19EB6921 (client_id), INDEX IDX_6EEAA67D6E8A49E (reduction_geree_par_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commande_produit (commande_id INT NOT NULL, produit_id INT NOT NULL, INDEX IDX_DF1E9E8782EA2E54 (commande_id), INDEX IDX_DF1E9E87F347EFB (produit_id), PRIMARY KEY(commande_id, produit_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE document (id INT AUTO_INCREMENT NOT NULL, commande_id INT DEFAULT NULL, date DATETIME NOT NULL, total DOUBLE PRECISION NOT NULL, adresse_livraison VARCHAR(255) NOT NULL, adresse_facturation VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, INDEX IDX_D8698A7682EA2E54 (commande_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE employe (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, role VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fournisseur (id INT AUTO_INCREMENT NOT NULL, nom_entreprise VARCHAR(255) NOT NULL, contact VARCHAR(255) NOT NULL, telephone VARCHAR(255) NOT NULL, siret VARCHAR(14) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE produit (id INT AUTO_INCREMENT NOT NULL, fournisseur_id INT DEFAULT NULL, categorie_id INT DEFAULT NULL, gestion_par_id INT DEFAULT NULL, libelle_court VARCHAR(255) NOT NULL, libelle_long VARCHAR(255) NOT NULL, reference_fournisseur VARCHAR(255) NOT NULL, prix_achat_ht DOUBLE PRECISION NOT NULL, prix_vente DOUBLE PRECISION NOT NULL, stock INT NOT NULL, photo VARCHAR(255) NOT NULL, actif TINYINT(1) NOT NULL, INDEX IDX_29A5EC27670C757F (fournisseur_id), INDEX IDX_29A5EC27BCF5E72D (categorie_id), INDEX IDX_29A5EC277FCA2A07 (gestion_par_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE categorie ADD CONSTRAINT FK_497DD634BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id)');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C74404557854071C FOREIGN KEY (commercial_id) REFERENCES employe (id)');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D19EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D6E8A49E FOREIGN KEY (reduction_geree_par_id) REFERENCES employe (id)');
        $this->addSql('ALTER TABLE commande_produit ADD CONSTRAINT FK_DF1E9E8782EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commande_produit ADD CONSTRAINT FK_DF1E9E87F347EFB FOREIGN KEY (produit_id) REFERENCES produit (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE document ADD CONSTRAINT FK_D8698A7682EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id)');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC27670C757F FOREIGN KEY (fournisseur_id) REFERENCES fournisseur (id)');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC27BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id)');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC277FCA2A07 FOREIGN KEY (gestion_par_id) REFERENCES employe (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE categorie DROP FOREIGN KEY FK_497DD634BCF5E72D');
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C74404557854071C');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D19EB6921');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D6E8A49E');
        $this->addSql('ALTER TABLE commande_produit DROP FOREIGN KEY FK_DF1E9E8782EA2E54');
        $this->addSql('ALTER TABLE commande_produit DROP FOREIGN KEY FK_DF1E9E87F347EFB');
        $this->addSql('ALTER TABLE document DROP FOREIGN KEY FK_D8698A7682EA2E54');
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC27670C757F');
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC27BCF5E72D');
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC277FCA2A07');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE commande');
        $this->addSql('DROP TABLE commande_produit');
        $this->addSql('DROP TABLE document');
        $this->addSql('DROP TABLE employe');
        $this->addSql('DROP TABLE fournisseur');
        $this->addSql('DROP TABLE produit');
    }
}
