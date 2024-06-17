-- Utiliser la base de données VillageGreen
USE VillageGreen;

DROP DATABASE VillageGreen;

CREATE DATABASE VillageGreen;

-- Modifier la colonne Photo dans souscategorie de LONGBLOB à VARCHAR(255)
ALTER TABLE souscategorie MODIFY COLUMN Photo VARCHAR(255);