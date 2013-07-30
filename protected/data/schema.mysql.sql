-- MySQL dump 10.14  Distrib 5.5.31-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: fastvps_whmcs_testing
-- ------------------------------------------------------
-- Server version	5.5.31-MariaDB

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
-- Table structure for table `tbl_rates`
--

DROP TABLE IF EXISTS `tbl_rates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_rates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `remote_id` varchar(254) NOT NULL,
  `num_code` varchar(3) NOT NULL,
  `char_code` varchar(3) NOT NULL,
  `nominal` int(11) NOT NULL DEFAULT '1',
  `name` varchar(254) NOT NULL,
  `value` float NOT NULL,
  `selected` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=72 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_rates`
--

LOCK TABLES `tbl_rates` WRITE;
/*!40000 ALTER TABLE `tbl_rates` DISABLE KEYS */;
INSERT INTO `tbl_rates` VALUES
	(1,'2013-07-25 20:00:00','R01010','036','AUD',1,'Австралийский доллар',29.8142,0),
	(2,'2013-07-25 20:00:00','R01020A','944','AZN',1,'Азербайджанский манат',41.5232,0),
	(3,'2013-07-25 20:00:00','R01035','826','GBP',1,'Фунт стерлингов Соединенного королевства',49.9647,0),
	(4,'2013-07-25 20:00:00','R01060','051','AMD',1000,'Армянских драмов',79.2633,0),
	(5,'2013-07-25 20:00:00','R01090','974','BYR',10000,'Белорусских рублей',36.5591,1),
	(6,'2013-07-25 20:00:00','R01100','975','BGN',1,'Болгарский лев',21.9804,0),
	(7,'2013-07-25 20:00:00','R01115','986','BRL',1,'Бразильский реал',14.4432,0),
	(8,'2013-07-25 20:00:00','R01135','348','HUF',100,'Венгерских форинтов',14.5212,0),
	(9,'2013-07-25 20:00:00','R01215','208','DKK',10,'Датских крон',57.6468,0),
	(10,'2013-07-25 20:00:00','R01235','840','USD',1,'Доллар США',32.5376,1),
	(11,'2013-07-25 20:00:00','R01239','978','EUR',1,'Евро',42.9919,1),
	(12,'2013-07-25 20:00:00','R01270','356','INR',100,'Индийских рупий',55.1625,0),
	(13,'2013-07-25 20:00:00','R01335','398','KZT',100,'Казахских тенге',21.2359,0),
	(14,'2013-07-25 20:00:00','R01350','124','CAD',1,'Канадский доллар',31.5838,0),
	(15,'2013-07-25 20:00:00','R01370','417','KGS',100,'Киргизских сомов',66.4839,0),
	(16,'2013-07-25 20:00:00','R01375','156','CNY',10,'Китайских юаней',53.0205,0),
	(17,'2013-07-25 20:00:00','R01405','428','LVL',1,'Латвийский лат',61.1954,0),
	(18,'2013-07-25 20:00:00','R01435','440','LTL',1,'Литовский лит',12.4536,0),
	(19,'2013-07-25 20:00:00','R01500','498','MDL',10,'Молдавских леев',26.6481,0),
	(20,'2013-07-25 20:00:00','R01535','578','NOK',10,'Норвежских крон',54.9789,0),
	(21,'2013-07-25 20:00:00','R01565','985','PLN',1,'Польский злотый',10.1578,0),
	(22,'2013-07-25 20:00:00','R01585F','946','RON',10,'Новых румынских леев',97.993,0),
	(23,'2013-07-25 20:00:00','R01589','960','XDR',1,'СДР (специальные права заимствования)',49.1715,0),
	(24,'2013-07-25 20:00:00','R01625','702','SGD',1,'Сингапурский доллар',25.6727,0),
	(25,'2013-07-25 20:00:00','R01670','972','TJS',10,'Таджикских сомони',68.2259,0),
	(26,'2013-07-25 20:00:00','R01700J','949','TRY',1,'Турецкая лира',16.8939,0),
	(27,'2013-07-25 20:00:00','R01710A','934','TMT',1,'Новый туркменский манат',11.4557,0),
	(28,'2013-07-25 20:00:00','R01717','860','UZS',1000,'Узбекских сумов',15.45,0),
	(29,'2013-07-25 20:00:00','R01720','980','UAH',10,'Украинских гривен',40.0044,1),
	(30,'2013-07-25 20:00:00','R01760','203','CZK',10,'Чешских крон',16.5835,0),
	(31,'2013-07-25 20:00:00','R01770','752','SEK',10,'Шведских крон',50.0655,0),
	(32,'2013-07-25 20:00:00','R01775','756','CHF',1,'Швейцарский франк',34.7401,0),
	(33,'2013-07-25 20:00:00','R01810','710','ZAR',10,'Южноафриканских рэндов',33.3798,0),
	(34,'2013-07-25 20:00:00','R01815','410','KRW',1000,'Вон Республики Корея',29.1495,0),
	(35,'2013-07-25 20:00:00','R01820','392','JPY',100,'Японских иен',32.5685,0);
/*!40000 ALTER TABLE `tbl_rates` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2013-07-30 15:03:11
