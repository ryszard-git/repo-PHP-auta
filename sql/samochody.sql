-- MySQL dump 10.13  Distrib 5.5.24, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: samochody
-- ------------------------------------------------------
-- Server version	5.5.24-0ubuntu0.12.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `auta`
--

DROP TABLE IF EXISTS `auta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auta` (
  `id_auta` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `marka_auta` varchar(70) COLLATE utf8_polish_ci NOT NULL,
  `czy_wynajete` char(3) COLLATE utf8_polish_ci NOT NULL,
  `czy_usuniete` char(3) COLLATE utf8_polish_ci NOT NULL,
  `cena_auta` smallint(5) unsigned NOT NULL,
  `zdjecie_auta` varchar(60) COLLATE utf8_polish_ci NOT NULL,
  PRIMARY KEY (`id_auta`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auta`
--

LOCK TABLES `auta` WRITE;
/*!40000 ALTER TABLE `auta` DISABLE KEYS */;
INSERT INTO `auta` VALUES (1,'Opel Corsa 1.9 diesel','NIE','NIE',98,'opel_corsa_1_9_diesel.jpeg'),(2,'Opel Corsa 1.4','NIE','TAK',0,''),(3,'Fiat Punto Grande','NIE','NIE',83,'punto_grande.jpeg'),(4,'Peugeot 406','NIE','NIE',90,'peugeot_406.jpeg'),(5,'Peugeot 407 SW','NIE','NIE',99,'peugeot_407_SW.jpeg'),(6,'Volkswagen transporter','NIE','NIE',210,'volkswagen_T4.jpeg'),(7,'Mercedes sprinter mikrobus','NIE','NIE',126,'merc_sprinter-bus.jpeg'),(8,'Mercedes sprinter furgon','NIE','NIE',190,'merc_sprinter_furgon.jpeg'),(9,'Volvo S70','NIE','NIE',97,'volvo_s70.jpeg'),(10,'Opel Corsa 1.4 12V','NIE','NIE',87,'opel_corsa_1_4.jpeg'),(11,'Ford Transit mikrobus','NIE','NIE',121,'ford_transit_mikrobus.jpeg'),(12,'Volkswagen Golf IV','NIE','NIE',94,'volkswagen_golf_4.jpeg'),(13,'Volkswagen Passat TDI','NIE','NIE',96,'volkswagen_passat_tdi.jpeg'),(14,'Fiat Scudo furgon','NIE','NIE',120,'fiat_scudo_furgon.jpeg'),(15,'Fiat Panda diesel','NIE','NIE',81,'fiat_panda.jpeg'),(16,'Citroen Berlingo diesel','NIE','NIE',80,'citroen_berlingo.jpeg'),(17,'Renault Clio','NIE','NIE',99,'renault_clio.jpeg'),(18,'Mercedes 240D \"beczka\"','TAK','NIE',84,'mercedes_240_beczka.jpeg'),(19,'Mercedes 200 \'trapez\'','NIE','NIE',83,'mercedes_200_trapez.jpeg'),(20,'BMW z3','NIE','NIE',125,'bmw_z3.jpeg'),(21,'Ford Focus','NIE','NIE',99,'ford_focus.jpeg'),(22,'Ford Fiesta','NIE','NIE',101,'ford_fiesta.jpeg'),(23,'Ford Mustang','TAK','NIE',120,'ford_mustang.jpeg'),(24,'Ford Mondeo','TAK','NIE',115,'ford_mondeo.jpeg'),(25,'Ford Fusion','NIE','NIE',95,'ford_fusion.jpeg'),(26,'Opel Vectra','NIE','NIE',120,'opel_vectra.jpeg'),(27,'Opel Tigra','NIE','NIE',150,'opel_tigra.jpeg'),(28,'Opel Astra','NIE','NIE',95,'opel_astra.jpeg'),(29,'Alfa Romeo 156','NIE','NIE',145,'alfa_romeo_156.jpeg'),(30,'Łada Niva','NIE','NIE',155,'lada_niva.jpeg');
/*!40000 ALTER TABLE `auta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `uzytkownicy`
--

DROP TABLE IF EXISTS `uzytkownicy`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `uzytkownicy` (
  `id_klienta` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `imie_kli` varchar(30) COLLATE utf8_polish_ci NOT NULL,
  `nazwisko_kli` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `adres_kli` varchar(30) COLLATE utf8_polish_ci NOT NULL,
  `miasto_kli` varchar(30) COLLATE utf8_polish_ci NOT NULL,
  `telefon_kli` varchar(20) COLLATE utf8_polish_ci NOT NULL,
  `email_kli` varchar(30) COLLATE utf8_polish_ci NOT NULL,
  `nr_prawa_jazdy_kli` varchar(20) COLLATE utf8_polish_ci NOT NULL,
  `login_name` varchar(25) COLLATE utf8_polish_ci NOT NULL,
  `haslo` char(40) COLLATE utf8_polish_ci NOT NULL,
  `is_admin` char(3) COLLATE utf8_polish_ci NOT NULL,
  PRIMARY KEY (`id_klienta`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `uzytkownicy`
--

LOCK TABLES `uzytkownicy` WRITE;
/*!40000 ALTER TABLE `uzytkownicy` DISABLE KEYS */;
INSERT INTO `uzytkownicy` VALUES (1,'Ryszard','Kowalski','Kościuszki 71/5','Gdańsk','58 656 78 99','rysiek@abc.pl','034556/344555','rysiek','0d02e33ff0e0cd5cd1337ab4b02f6f44fd1388c6','NIE'),(2,'Marek','Nowacki','Hallera 129/8','Gdynia','58 656 78 92','marek@abc.pl','123/985/4567','marek','e54ec4e8b56ff7382fb135e028860ad99be4caf9','NIE'),(3,'Jan','Kowalski','Legionów 72/8','Gdańsk','58 344 10 12','janek@abc.pl','123/7654','janek','c5303309268dbad8cdaa3fbb2f2a92c811d4c07e','NIE'),(4,'Ryszard','Kowalski (admin)','Kościuszki 71/9','Gdańsk','502 567 890','ryszardk@ijk.pl','123/45678','admin','d033e22ae348aeb5660fc2140aec35850c4da997','TAK'),(5,'Jerzy','Puchalski','Grunwaldzka 100/5','Gdańsk','58 3467890','jpuch@efg.pl','987/6345/8900','jurek','24acfb724e47a3e0cfe73ec66efe0d82529f1eae','NIE'),(6,'Marian','Żółkiewski','Andersa 12/5','Gdańsk','58 344 12 90','maniek@def.pl','678/56767/0987','marian','15985e73bfe2e61c83c1b328087be49992d25081','NIE'),(7,'Janusz','Kowalewski','Dębowa 12','Gdańsk','507 776 544','jan@gfd.pl','124/8269','cerber','e1136129ac2a10d422a1457ea48af026fcbcbdee','TAK'),(8,'Jarosław','Kulczycki','Sucha 15','Gdańsk','58 345 09 87','jaro@abc.pl','678/8765','user1','b3daa77b4c04a9551b8781d03191fe098f325e67','NIE'),(9,'Anzelm','Piotrowski','Kujawska 12/7','Gorzów Wielkopolski','65 723-09-87','anz@kkk.pl','980/889','anzelm','8fa25cf4e6e46ad694fcb65827850125359110f9','NIE'),(10,'Jakub','Cichy','Kasztanowa 2/15','Gdańsk','58 344-55-66','kuba@aaa.pl','654/98/1276','user2','a1881c06eec96db9901c7bbfe41c42a3f08e9cb4','NIE'),(19,'Imię_user','nazwisko_User','Bulońska 12/34','Gdańsk','58 520-98-00','usertestowy@wp.pl','678/0987','user\"testowy\"','9b291fdbf0bff96384e48defd3ea132f9a82736d','NIE'),(20,'Name U\'ser','nazwisko U\'ser','Potokowa 12','Gdańsk','58 344-55-99','u\'ser@abc.pl','\\1234354/ghhj','u\'ser','8bfb3d8d2280d8cda7a7b4692f79283f801fc595','NIE'),(21,'Imię user\'s','Nazwisko user\'s','Mydlana 1','\'Leźno\' k/Gdańska','78 678-09-86','user\'s@nnn.pl','98787/0998098','user\'s','388a6b8c8f317051d89aaecd240e37f0781fdc09','NIE'),(22,'Nowy','User','Nieznana 21','Pruszcz Gdański','58 683-89-69','newuser@abc.pl','456/8765/09','nowyuser','8d07bf37f397a888662114516c01c92b558c77cc','NIE'),(23,'User','Nowy','Prosta 1','Gdańsk','58 346-09-68','usernowy@bvc.pl','654/76767/098','usernowy','555576c7eb0bfee02f9fbc56fcf6d9f2b2d89c6f','NIE'),(24,'Atanazy','Kowalewski','Wiązowa 10','Lublin','65 908 09 98','atanazy@abc.pl','098/3258/98','atanazy','f1ff0a4f785426e3d0d745152f789c93fc5a0da5','NIE'),(25,'','','','','','','','kajtek','6a8460fd17fe5fb129d48d9cb164be8ed38d90de','NIE');
/*!40000 ALTER TABLE `uzytkownicy` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wynajem`
--

DROP TABLE IF EXISTS `wynajem`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wynajem` (
  `id_wynajem` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_auta` int(10) unsigned NOT NULL,
  `id_klienta` int(10) unsigned NOT NULL,
  `data_wynajmu` date NOT NULL,
  `data_zwrotu` date NOT NULL,
  `czy_wynajete` char(3) COLLATE utf8_polish_ci NOT NULL,
  PRIMARY KEY (`id_wynajem`)
) ENGINE=InnoDB AUTO_INCREMENT=77 DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wynajem`
--

LOCK TABLES `wynajem` WRITE;
/*!40000 ALTER TABLE `wynajem` DISABLE KEYS */;
INSERT INTO `wynajem` VALUES (1,4,1,'2010-05-28','2010-05-31','NIE'),(2,9,3,'2010-05-28','2010-06-01','NIE'),(3,10,2,'2010-05-28','2010-06-01','NIE'),(4,14,5,'2010-06-01','2010-06-14','NIE'),(5,1,1,'2010-06-04','2010-06-14','NIE'),(6,7,2,'2010-06-14','2010-06-30','NIE'),(7,12,6,'2010-06-14','2010-06-28','NIE'),(8,3,3,'2010-06-17','2010-07-05','NIE'),(9,13,8,'2010-06-21','2010-07-01','NIE'),(10,16,9,'2010-12-31','2011-01-10','NIE'),(11,1,1,'2011-02-09','2011-02-16','NIE'),(12,1,1,'2011-02-09','2011-02-17','NIE'),(15,1,1,'2011-02-09','2011-02-17','NIE'),(16,16,9,'2011-02-09','2011-02-17','NIE'),(17,15,8,'2011-02-09','2011-02-18','NIE'),(18,3,6,'2011-02-09','2011-02-16','NIE'),(19,10,5,'2011-02-09','2011-02-17','NIE'),(20,7,3,'2011-02-09','2011-02-17','NIE'),(21,17,2,'2011-02-09','2011-02-18','NIE'),(22,1,1,'2011-02-09','2011-02-16','NIE'),(23,1,1,'2011-02-09','2011-02-18','NIE'),(24,14,9,'2011-02-09','2011-02-16','NIE'),(25,11,9,'2011-02-09','2011-02-16','NIE'),(26,8,9,'2011-02-09','2011-02-17','NIE'),(27,4,9,'2011-02-09','2011-02-17','NIE'),(28,5,9,'2011-02-09','2011-02-18','NIE'),(29,12,9,'2011-02-09','2011-02-17','NIE'),(30,13,2,'2011-02-09','2011-02-18','NIE'),(31,6,2,'2011-02-09','2011-02-16','NIE'),(32,9,2,'2011-02-09','2011-02-18','NIE'),(33,9,3,'2011-02-16','2011-02-23','NIE'),(34,15,1,'2011-03-07','2011-03-17','NIE'),(35,7,20,'2011-03-26','2011-04-01','NIE'),(36,7,20,'2011-03-26','2011-04-01','NIE'),(37,16,21,'2011-03-26','2011-04-02','NIE'),(38,5,1,'2011-03-26','2011-04-03','NIE'),(39,3,1,'2011-03-26','2011-04-04','NIE'),(40,18,1,'2011-04-01','2011-04-08','NIE'),(41,19,1,'2011-04-12','2011-04-19','NIE'),(42,12,1,'2011-05-12','2011-05-16','NIE'),(43,1,1,'2011-05-18','2011-05-17','NIE'),(44,5,1,'2011-05-18','2011-02-17','NIE'),(45,7,1,'2011-05-18','2011-05-23','NIE'),(46,1,9,'2011-05-19','2011-05-24','NIE'),(47,11,9,'2011-05-19','2011-05-25','NIE'),(48,9,9,'2011-05-19','2011-05-29','NIE'),(49,13,1,'2011-05-19','2011-05-31','NIE'),(50,4,2,'2011-05-31','2011-06-10','NIE'),(51,16,1,'2011-06-24','2011-07-24','NIE'),(52,15,2,'2011-06-24','2011-07-25','NIE'),(53,14,3,'2011-06-24','2011-07-26','NIE'),(54,10,5,'2011-06-24','2011-07-16','NIE'),(55,3,6,'2011-06-24','2011-07-17','NIE'),(56,4,9,'2011-06-24','2011-07-18','NIE'),(57,7,10,'2011-06-24','2011-07-20','NIE'),(58,17,8,'2011-06-24','2011-07-21','NIE'),(59,18,5,'2011-08-13','2011-08-31','NIE'),(60,16,1,'2011-12-10','2011-12-10','NIE'),(61,18,1,'2011-12-10','2011-12-11','NIE'),(62,15,3,'2011-12-12','2011-12-19','NIE'),(63,4,3,'2011-12-12','2011-12-30','NIE'),(64,9,9,'2011-12-12','2011-12-30','NIE'),(65,19,1,'2011-12-12','2011-12-19','NIE'),(66,11,5,'2011-12-12','2011-12-16','NIE'),(67,1,6,'2011-12-12','2011-12-15','NIE'),(68,16,9,'2011-12-19','2011-12-29','NIE'),(69,20,5,'2011-12-31','2012-01-12','NIE'),(70,8,5,'2012-01-07','2012-01-10','NIE'),(71,12,2,'2012-01-07','2012-02-29','NIE'),(72,17,1,'2012-03-29','2012-04-10','NIE'),(73,24,1,'2012-06-30','2012-07-15','NIE'),(74,24,1,'2012-07-01','2012-07-10','TAK'),(75,18,24,'2012-07-01','2012-07-07','TAK'),(76,23,2,'2012-07-02','2012-07-12','TAK');
/*!40000 ALTER TABLE `wynajem` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2012-09-07 14:40:58
