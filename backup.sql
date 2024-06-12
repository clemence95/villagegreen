-- MariaDB dump 10.19  Distrib 10.6.16-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: VillageGreen
-- ------------------------------------------------------
-- Server version	10.6.16-MariaDB-0ubuntu0.22.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `BonLivraison`
--

DROP TABLE IF EXISTS `BonLivraison`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `BonLivraison` (
  `Id_BonLivraison` int(11) NOT NULL AUTO_INCREMENT,
  `Date_livraison` date NOT NULL,
  `Statut` varchar(50) NOT NULL,
  `Suivi_commande` varchar(50) NOT NULL,
  `Id_Commande` int(11) NOT NULL,
  PRIMARY KEY (`Id_BonLivraison`),
  KEY `Id_Commande` (`Id_Commande`),
  KEY `idx_id_bonlivraison` (`Id_BonLivraison`),
  CONSTRAINT `BonLivraison_ibfk_1` FOREIGN KEY (`Id_Commande`) REFERENCES `Commande` (`Id_Commande`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `BonLivraison`
--

LOCK TABLES `BonLivraison` WRITE;
/*!40000 ALTER TABLE `BonLivraison` DISABLE KEYS */;
INSERT INTO `BonLivraison` VALUES (1,'2024-05-03','En cours de preparation','9876543210',1),(2,'2024-05-04','En cours de preparation','',2),(3,'2024-05-03','En cours de preparation','9876543210',3),(4,'2024-05-04','En cours de preparation','',4),(5,'2024-05-03','En cours de preparation','9876543210',5),(6,'2024-05-04','En cours de preparation','',6),(7,'2024-05-03','En cours de preparation','9876543210',7),(8,'2024-05-04','En cours de preparation','',8),(9,'2024-05-03','En cours de livraison','9876543210',9),(10,'2024-05-04','En cours de preparation','',10);
/*!40000 ALTER TABLE `BonLivraison` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Client`
--

DROP TABLE IF EXISTS `Client`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Client` (
  `Id_Client` int(11) NOT NULL AUTO_INCREMENT,
  `Nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `telephone` varchar(50) NOT NULL,
  `Type` varchar(50) NOT NULL,
  `Adresse_livraison` varchar(255) NOT NULL,
  `Adresse_facturation` varchar(255) NOT NULL,
  `Coefficient` decimal(15,2) NOT NULL,
  `Reduction` decimal(15,2) DEFAULT NULL,
  `Reference` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  PRIMARY KEY (`Id_Client`),
  KEY `idx_id_client` (`Id_Client`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Client`
--

LOCK TABLES `Client` WRITE;
/*!40000 ALTER TABLE `Client` DISABLE KEYS */;
INSERT INTO `Client` VALUES (1,'Johnson','Thomas','0234567890','Particulier','25 rue des Melodies','25 rue des Factures',1.00,NULL,'ML001','thomas@johnson.com'),(2,'Lee','Sophie','0678901234','Entreprise','10 avenue des Harmonies','10 avenue des Factures',1.50,0.20,'SC001','sophie@lee.com'),(3,'Wilson','Christopher','0234567890','Particulier','40 rue des Melodies','40 rue des Factures',1.00,NULL,'MF001','christopher@wilson.com'),(4,'Brown','Emma','0678901234','Entreprise','20 avenue des Harmonies','20 avenue des Factures',1.50,0.20,'HL001','emma@brown.com'),(5,'Clark','Daniel','0123456789','Particulier','5 rue des Chansons','5 rue des Factures',1.00,NULL,'SB001','daniel@clark.com'),(6,'Johnson','Thomas','0234567890','Particulier','25 rue des Melodies','25 rue des Factures',1.00,NULL,'ML001','thomas@johnson.com'),(7,'Lee','Sophie','0678901234','Entreprise','10 avenue des Harmonies','10 avenue des Factures',1.50,0.20,'SC001','sophie@lee.com'),(8,'Wilson','Christopher','0234567890','Particulier','40 rue des Melodies','40 rue des Factures',1.00,NULL,'MF001','christopher@wilson.com'),(9,'Brown','Emma','0678901234','Entreprise','20 avenue des Harmonies','20 avenue des Factures',1.50,0.20,'HL001','emma@brown.com'),(10,'Clark','Daniel','0123456789','Particulier','5 rue des Chansons','5 rue des Factures',1.00,NULL,'SB001','daniel@clark.com');
/*!40000 ALTER TABLE `Client` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Commande`
--

DROP TABLE IF EXISTS `Commande`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Commande` (
  `Id_Commande` int(11) NOT NULL AUTO_INCREMENT,
  `Statut` varchar(50) NOT NULL,
  `Mode_paiement` varchar(50) NOT NULL,
  `Reduction_pro` decimal(15,2) DEFAULT NULL,
  `Total_HT` decimal(15,2) NOT NULL,
  `Total_TTC` decimal(15,2) NOT NULL,
  `Date_heure_commande` datetime NOT NULL,
  `Mode_differe` varchar(50) DEFAULT NULL,
  `Date_facturation` date NOT NULL,
  `Id_Client` int(11) NOT NULL,
  PRIMARY KEY (`Id_Commande`),
  KEY `idx_id_commande` (`Id_Commande`),
  KEY `idx_fk_id_client_cmd` (`Id_Client`),
  CONSTRAINT `Commande_ibfk_1` FOREIGN KEY (`Id_Client`) REFERENCES `Client` (`Id_Client`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Commande`
--

LOCK TABLES `Commande` WRITE;
/*!40000 ALTER TABLE `Commande` DISABLE KEYS */;
INSERT INTO `Commande` VALUES (1,'En cours','Cheque',NULL,1500.00,1575.00,'2024-05-02 10:00:00',NULL,'2024-05-03',1),(2,'En cours','Virement bancaire',0.15,3000.00,3300.00,'2024-05-02 11:30:00','Differe','2024-05-03',2),(3,'En cours','Cheque',NULL,1500.00,1575.00,'2024-05-02 10:00:00',NULL,'2024-05-03',3),(4,'En cours','Virement bancaire',0.15,3000.00,3300.00,'2024-05-02 11:30:00','Differe','2024-05-03',4),(5,'En cours','Cheque',NULL,1500.00,1575.00,'2024-05-02 10:00:00',NULL,'2024-05-03',5),(6,'En cours','Virement bancaire',0.15,3000.00,3300.00,'2024-05-02 11:30:00','Differe','2024-05-03',6),(7,'En cours','Cheque',NULL,1500.00,1575.00,'2024-05-02 10:00:00',NULL,'2024-05-03',7),(8,'En cours','Virement bancaire',0.15,3000.00,3300.00,'2024-05-02 11:30:00','Differe','2024-05-03',8),(9,'En cours de livraison','Cheque',NULL,1500.00,1575.00,'2024-05-02 10:00:00',NULL,'2024-05-03',9),(10,'En cours','Virement bancaire',0.15,3000.00,3300.00,'2024-05-02 11:30:00','Differe','2024-05-03',10);
/*!40000 ALTER TABLE `Commande` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Commercial`
--

DROP TABLE IF EXISTS `Commercial`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Commercial` (
  `Id_Commercial` int(11) NOT NULL AUTO_INCREMENT,
  `Nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `telephone` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `Id_Client` int(11) DEFAULT NULL,
  PRIMARY KEY (`Id_Commercial`),
  KEY `idx_id_commercial` (`Id_Commercial`),
  KEY `idx_fk_id_client` (`Id_Client`),
  CONSTRAINT `Commercial_ibfk_1` FOREIGN KEY (`Id_Client`) REFERENCES `Client` (`Id_Client`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Commercial`
--

LOCK TABLES `Commercial` WRITE;
/*!40000 ALTER TABLE `Commercial` DISABLE KEYS */;
INSERT INTO `Commercial` VALUES (1,'Alex Parker','Alex','0456789012','alex@guitarworld.com',1),(2,'Emma White','Emma','0890123456','emma@pianouniverse.com',2),(3,'Alex Parker','Alex','0456789012','alex@guitarworld.com',3),(4,'Emma White','Emma','0890123456','emma@pianouniverse.com',4),(5,'Alex Parker','Alex','0456789012','alex@guitarworld.com',5),(6,'Emma White','Emma','0890123456','emma@pianouniverse.com',6),(7,'Alex Parker','Alex','0456789012','alex@guitarworld.com',7),(8,'Emma White','Emma','0890123456','emma@pianouniverse.com',8),(9,'Alex Parker','Alex','0456789012','alex@guitarworld.com',9),(10,'Emma White','Emma','0890123456','emma@pianouniverse.com',10);
/*!40000 ALTER TABLE `Commercial` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Fournisseur`
--

DROP TABLE IF EXISTS `Fournisseur`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Fournisseur` (
  `Id_Fournisseur` int(11) NOT NULL AUTO_INCREMENT,
  `Nom` varchar(50) NOT NULL,
  `Contact` varchar(50) NOT NULL,
  `telephone` varchar(50) NOT NULL,
  PRIMARY KEY (`Id_Fournisseur`),
  KEY `idx_id_fournisseur` (`Id_Fournisseur`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Fournisseur`
--

LOCK TABLES `Fournisseur` WRITE;
/*!40000 ALTER TABLE `Fournisseur` DISABLE KEYS */;
INSERT INTO `Fournisseur` VALUES (1,'Guitar World','Michael Johnson','0123456789'),(2,'Piano Universe','Sarah Lee','0987654321'),(3,'Music Emporium','David Wilson','0123456789'),(4,'Melody Instruments','Jessica Brown','0987654321'),(5,'Rhythm Warehouse','Michael Clark','0123456789'),(6,'Harmony Supplies','Emma Turner','0987654321'),(7,'Beat Studio','James Lee','0123456789'),(8,'Note Haven','Sophia Martinez','0987654321'),(9,'Song Mart','Daniel Thompson','0123456789'),(10,'Sound Waves','Olivia Harris','0987654321');
/*!40000 ALTER TABLE `Fournisseur` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `achete`
--

DROP TABLE IF EXISTS `achete`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `achete` (
  `Id_Produit` int(11) NOT NULL,
  `Id_Commande` int(11) NOT NULL,
  `quantite` int(11) NOT NULL,
  PRIMARY KEY (`Id_Produit`,`Id_Commande`),
  KEY `idx_fk_id_produit_achete` (`Id_Produit`),
  KEY `idx_fk_id_commande_achete` (`Id_Commande`),
  CONSTRAINT `achete_ibfk_1` FOREIGN KEY (`Id_Produit`) REFERENCES `produit` (`Id_Produit`),
  CONSTRAINT `achete_ibfk_2` FOREIGN KEY (`Id_Commande`) REFERENCES `Commande` (`Id_Commande`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `achete`
--

LOCK TABLES `achete` WRITE;
/*!40000 ALTER TABLE `achete` DISABLE KEYS */;
INSERT INTO `achete` VALUES (1,1,1),(2,2,2),(3,3,1),(4,4,2),(5,5,1),(6,6,2),(7,7,1),(8,8,2),(9,9,1),(10,10,2);
/*!40000 ALTER TABLE `achete` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categorie`
--

DROP TABLE IF EXISTS `categorie`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categorie` (
  `Id_Categorie` int(11) NOT NULL AUTO_INCREMENT,
  `Libelle_court` varchar(50) NOT NULL,
  `Photo` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Id_Categorie`),
  KEY `idx_id_categorie` (`Id_Categorie`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categorie`
--

LOCK TABLES `categorie` WRITE;
/*!40000 ALTER TABLE `categorie` DISABLE KEYS */;
INSERT INTO `categorie` VALUES (1,'Percussion','/public/assets/images/percussion.jpg'),(2,'Accessoires','/public/assets/images/accessoire.jpg'),(3,'Instruments a cordes','/public/assets/images/corde.jpg'),(4,'Instruments a vent','/public/assets/images/vent.jpg'),(5,'Instruments a clavier','/public/assets/images/clavier.jpg');
/*!40000 ALTER TABLE `categorie` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `livre`
--

DROP TABLE IF EXISTS `livre`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `livre` (
  `Id_Produit` int(11) NOT NULL,
  `Id_BonLivraison` int(11) NOT NULL,
  `quantite` int(11) NOT NULL,
  PRIMARY KEY (`Id_Produit`,`Id_BonLivraison`),
  KEY `idx_fk_id_produit_livre` (`Id_Produit`),
  KEY `idx_fk_id_bonlivraison_livre` (`Id_BonLivraison`),
  CONSTRAINT `livre_ibfk_1` FOREIGN KEY (`Id_Produit`) REFERENCES `produit` (`Id_Produit`),
  CONSTRAINT `livre_ibfk_2` FOREIGN KEY (`Id_BonLivraison`) REFERENCES `BonLivraison` (`Id_BonLivraison`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `livre`
--

LOCK TABLES `livre` WRITE;
/*!40000 ALTER TABLE `livre` DISABLE KEYS */;
INSERT INTO `livre` VALUES (1,1,1),(2,2,2),(3,3,1),(4,4,2),(5,5,1),(6,6,2),(7,7,1),(8,8,2),(9,9,1),(10,10,2);
/*!40000 ALTER TABLE `livre` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `produit`
--

DROP TABLE IF EXISTS `produit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `produit` (
  `Id_Produit` int(11) NOT NULL AUTO_INCREMENT,
  `Libelle_court` varchar(100) NOT NULL,
  `Libelle_long` text NOT NULL,
  `Prix_achat_HT` decimal(15,2) NOT NULL,
  `Photo` varchar(255) DEFAULT NULL,
  `stock` decimal(15,2) DEFAULT NULL,
  `Actif` varchar(50) NOT NULL,
  `Id_Souscategorie` int(11) NOT NULL,
  `Id_Fournisseur` int(11) NOT NULL,
  PRIMARY KEY (`Id_Produit`),
  KEY `idx_id_produit` (`Id_Produit`),
  KEY `idx_fk_id_souscategorie` (`Id_Souscategorie`),
  KEY `idx_fk_id_fournisseur` (`Id_Fournisseur`),
  CONSTRAINT `FK_Fournisseur_Produit` FOREIGN KEY (`Id_Fournisseur`) REFERENCES `Fournisseur` (`Id_Fournisseur`),
  CONSTRAINT `FK_Souscategorie_Produit` FOREIGN KEY (`Id_Souscategorie`) REFERENCES `souscategorie` (`Id_Souscategorie`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `produit`
--

LOCK TABLES `produit` WRITE;
/*!40000 ALTER TABLE `produit` DISABLE KEYS */;
INSERT INTO `produit` VALUES (1,'Batterie Roland','Batterie electronique avec pads sensibles',1500.00,'/public/assets/images/roland.jpeg',15.00,'Oui',1,1),(2,'Accordeur chromatique Korg','Accordeur polyvalent pour tous types d\'instruments',50.00,'/public/assets/images/korg.jpg',50.00,'Oui',2,2),(3,'Piano Yamaha','Piano numerique avec toucher realiste',2000.00,'/public/assets/images/yamaha.jpg',10.00,'Oui',5,3),(4,'Guitare Fender Stratocaster','Guitare electrique emblematique',1200.00,'/public/assets/images/guitare.jpeg',20.00,'Oui',16,4),(5,'Microphone Shure SM58','Microphone dynamique pour la scene',100.00,'/public/assets/images/shure.jpg',30.00,'Oui',2,5),(6,'Amplificateur Marshall','Ampli a lampe pour une distorsion chaude',100.00,'images/amplificateur1.jpg',5.00,'Oui',38,6),(7,'Synthétiseur Korg Minilogue','Synthé analogique avec sequenceur integre',600.00,'images/amplificateur1.jpg',15.00,'Oui',39,7),(8,'Violoncelle Stradivarius','Violoncelle de haute qualite artisanale',5000.00,'images/vionloncelle1.jpg',2.00,'Oui',18,8),(9,'Flute traversiere Yamaha YFL-222','Flute traversiere pour etudiants',600.00,'/public/assets/images/fluteyamaha.jpg',20.00,'Oui',25,9),(10,'Flute traversiere Yamaha YFL-222','Flute traversiere pour etudiants',600.00,'/public/assets/images/fluteyamaha.jpg',20.00,'Oui',1,10);
/*!40000 ALTER TABLE `produit` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `souscategorie`
--

DROP TABLE IF EXISTS `souscategorie`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `souscategorie` (
  `Id_Souscategorie` int(11) NOT NULL AUTO_INCREMENT,
  `Libelle_court` varchar(50) NOT NULL,
  `Photo` blob DEFAULT NULL,
  `Id_Categorie` int(11) NOT NULL,
  PRIMARY KEY (`Id_Souscategorie`),
  KEY `idx_id_souscategorie` (`Id_Souscategorie`),
  KEY `FK_Categorie_Souscategorie` (`Id_Categorie`),
  CONSTRAINT `FK_Categorie_Souscategorie` FOREIGN KEY (`Id_Categorie`) REFERENCES `categorie` (`Id_Categorie`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `souscategorie`
--

LOCK TABLES `souscategorie` WRITE;
/*!40000 ALTER TABLE `souscategorie` DISABLE KEYS */;
INSERT INTO `souscategorie` VALUES (1,'Batteries electroniques','/public/assets/images/batterie.jpg',1),(2,'Accordeurs','/public/assets/images/accordeur.jpg',2),(3,'Batterie','/public/assets/images/batterie.jpg',1),(4,'Tambour','/public/assets/images/tambour.jpg',1),(5,'Xylophone','/public/assets/images/xylophone.jpg',1),(7,'Glockenspiel','/public/assets/images/glockenspiel.jpg',1),(8,'Tambourin','/public/assets/images/tambourin.jpg',1),(9,'Congas','/public/assets/images/congas.jpg',1),(10,'Bongos','/public/assets/images/bongos.jpg',1),(11,'Timbales','/public/assets/images/timbales.jpg',1),(12,'Vibraphone','/public/assets/images/vibraphone.jpg',1),(13,'Triangle','/public/assets/images/triangle.jpg',1),(14,'Cymbales','/public/assets/images/cymbales.jpg',1),(15,'Guitare acoustique','/public/assets/images/guitareacoustique.jpg',3),(16,'Guitare electrique','/public/assets/images/guitareelectrique.jpg',3),(17,'Violon','/public/assets/images/violon.jpg',3),(18,'Violoncelle','/public/assets/images/violoncelle.jpg',3),(19,'Contrebasse','/public/assets/images/contrebasse.jpg',3),(20,'Alto','/public/assets/images/alto.jpg',3),(21,'Harpe','/public/assets/images/harpe.jpg',3),(22,'Ukulele','/public/assets/images/ukulele.jpg',3),(23,'Benjo','/public/assets/images/benjo.jpg',3),(24,'Mandoline','/public/assets/images/mandoline.jpg',3),(25,'Flute traversiere','/public/assets/images/flutetraversiere.jpg',4),(26,'Clarinette','/public/assets/images/clarinette.jpg',4),(27,'Hautbois','/public/assets/images/hautbois.jpg',4),(28,'Basson','/public/assets/images/basson.jpg',4),(29,'Piccolo','/public/assets/images/piccolo.jpg',4),(30,'Trompette','/public/assets/images/trompette.jpg',4),(36,'Piano','/public/assets/images/piano.jpg',5),(37,'Clavier electronique','/public/assets/images/clavierelectronique.jpg',5),(38,'Amplificateur','/public/assets/images/amplificateur.jpg',2),(39,'Synthetiseur','/public/assets/images/synthetiseur.jpg',5),(40,'Saxophone','/public/assets/images/saxophone.jpg',4);
/*!40000 ALTER TABLE `souscategorie` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-06-12  9:48:02
