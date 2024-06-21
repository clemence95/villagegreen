<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240621232736 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE client ADD id_adresse_facturation_id INT DEFAULT NULL, ADD id_adresse_livraison_id INT DEFAULT NULL, ADD id_commercial_id INT DEFAULT NULL, ADD nom VARCHAR(255) NOT NULL, ADD prenom VARCHAR(255) NOT NULL, ADD siret VARCHAR(14) DEFAULT NULL, ADD entreprise VARCHAR(255) DEFAULT NULL, ADD reference_client VARCHAR(255) NOT NULL, ADD coefficient NUMERIC(10, 2) NOT NULL, ADD telephone VARCHAR(50) NOT NULL, ADD type_client VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C74404555B6CA5B3 FOREIGN KEY (id_adresse_facturation_id) REFERENCES adresse (id)');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C7440455B2DFFB91 FOREIGN KEY (id_adresse_livraison_id) REFERENCES adresse (id)');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C7440455C67CD679 FOREIGN KEY (id_commercial_id) REFERENCES employe (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C7440455DA25B551 ON client (reference_client)');
        $this->addSql('CREATE INDEX IDX_C74404555B6CA5B3 ON client (id_adresse_facturation_id)');
        $this->addSql('CREATE INDEX IDX_C7440455B2DFFB91 ON client (id_adresse_livraison_id)');
        $this->addSql('CREATE INDEX IDX_C7440455C67CD679 ON client (id_commercial_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C74404555B6CA5B3');
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C7440455B2DFFB91');
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C7440455C67CD679');
        $this->addSql('DROP INDEX UNIQ_C7440455DA25B551 ON client');
        $this->addSql('DROP INDEX IDX_C74404555B6CA5B3 ON client');
        $this->addSql('DROP INDEX IDX_C7440455B2DFFB91 ON client');
        $this->addSql('DROP INDEX IDX_C7440455C67CD679 ON client');
        $this->addSql('ALTER TABLE client DROP id_adresse_facturation_id, DROP id_adresse_livraison_id, DROP id_commercial_id, DROP nom, DROP prenom, DROP siret, DROP entreprise, DROP reference_client, DROP coefficient, DROP telephone, DROP type_client');
    }
}
