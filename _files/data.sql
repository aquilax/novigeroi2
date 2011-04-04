-- MySQL dump 10.13  Distrib 5.1.56, for debian-linux-gnu (i486)
--
-- Host: localhost    Database: ng2
-- ------------------------------------------------------
-- Server version	5.1.56-1

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
-- Dumping data for table `hero`
--

LOCK TABLES `hero` WRITE;
/*!40000 ALTER TABLE `hero` DISABLE KEYS */;
<<<<<<< HEAD
INSERT INTO `hero` VALUES (1,0,1,'Варварин',1,1,'2011-03-31 15:40:36','0000-00-00 00:00:00','home',NULL,1,0,0,'{}'),(2,1,1,'123',1,1,'2011-04-01 04:15:19','0000-00-00 00:00:00','town',1,1,0,0,'{}'),(3,1,1,'цуцо',1,1,'2011-04-03 04:11:27','0000-00-00 00:00:00','home',NULL,1,0,0,'{}');
=======
INSERT INTO `hero` VALUES (1,0,1,'Варварин',1,1,'2011-03-31 15:40:36','0000-00-00 00:00:00','home',NULL,1,0,0,'{}'),(2,1,1,'123',1,1,'2011-04-01 04:15:19','0000-00-00 00:00:00','town',1,1,0,0,'{}');
>>>>>>> 46b8c1de048c13ca0ea6a6eec17f0faf081c6f2a
/*!40000 ALTER TABLE `hero` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `place`
--

LOCK TABLES `place` WRITE;
/*!40000 ALTER TABLE `place` DISABLE KEYS */;
<<<<<<< HEAD
INSERT INTO `place` VALUES (1,1,1,'ЦУМ','Всичко за всеки','2011-04-02 05:50:42',''),(2,1,2,'ВМА','Лекуваме','2011-04-04 02:39:43','');
=======
INSERT INTO `place` VALUES (1,1,1,'ЦУМ','Всичко за всеки','2011-04-02 05:50:42',''),(2,1,2,'ВМА','Лекуваме','2011-04-04 07:12:40','');
>>>>>>> 46b8c1de048c13ca0ea6a6eec17f0faf081c6f2a
/*!40000 ALTER TABLE `place` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `place_type`
--

LOCK TABLES `place_type` WRITE;
/*!40000 ALTER TABLE `place_type` DISABLE KEYS */;
<<<<<<< HEAD
INSERT INTO `place_type` VALUES (1,'Магазин','store','2011-04-02 05:50:10'),(2,'Болница','hospital','2011-04-04 02:38:56');
=======
INSERT INTO `place_type` VALUES (1,'Магазин','store','2011-04-02 05:50:10'),(2,'Лечебница','place/hospital','2011-04-04 07:13:36');
>>>>>>> 46b8c1de048c13ca0ea6a6eec17f0faf081c6f2a
/*!40000 ALTER TABLE `place_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `town`
--

LOCK TABLES `town` WRITE;
/*!40000 ALTER TABLE `town` DISABLE KEYS */;
INSERT INTO `town` VALUES (1,'Тестопополис','2011-04-02 05:49:02');
/*!40000 ALTER TABLE `town` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

<<<<<<< HEAD
-- Dump completed on 2011-04-04  6:29:19
=======
-- Dump completed on 2011-04-04 12:16:26
>>>>>>> 46b8c1de048c13ca0ea6a6eec17f0faf081c6f2a
