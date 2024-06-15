-- Utiliser la base de données VillageGreen
USE VillageGreen;

DROP DATABASE villageGreen;

CREATE DATABASE villagegreen;

-- Modifier la colonne Photo dans souscategorie de LONGBLOB à VARCHAR(255)
ALTER TABLE souscategorie MODIFY COLUMN Photo VARCHAR(255);