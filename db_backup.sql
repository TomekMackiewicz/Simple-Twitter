-- MySQL dump 10.13  Distrib 5.7.17, for Linux (x86_64)
--
-- Host: localhost    Database: semi_twitter
-- ------------------------------------------------------
-- Server version	5.7.17-0ubuntu0.16.04.1

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
-- Table structure for table `Comments`
--

DROP TABLE IF EXISTS `Comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userID` int(11) DEFAULT NULL,
  `postID` int(11) DEFAULT NULL,
  `creationDate` datetime DEFAULT NULL,
  `text` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `Comments_ibfk_1` (`postID`),
  CONSTRAINT `Comments_ibfk_1` FOREIGN KEY (`postID`) REFERENCES `Tweets` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Comments`
--

LOCK TABLES `Comments` WRITE;
/*!40000 ALTER TABLE `Comments` DISABLE KEYS */;
INSERT INTO `Comments` VALUES (24,26,23,'2017-02-01 02:32:18','Apple pie candy canes macaroon sweet roll icing tiramisu pie halvah. Pastry sweet roll dragée.'),(25,26,23,'2017-02-01 01:41:34','Tiramisu gingerbread sweet roll jelly donut tart pastry pastry sesame snaps.'),(26,26,26,'2017-02-01 02:31:22','Dessert cookie apple pie donut ice cream powder brownies.'),(27,26,25,'2017-02-01 01:43:45','Chocolate sweet cotton candy donut sweet roll wafer tart pie carrot cake.'),(28,25,28,'2017-02-01 02:02:44','Cookie fruitcake cupcake donut. Lollipop ice cream gingerbread cupcake.'),(29,26,27,'2017-02-01 02:44:21','Candy canes sweet croissant chupa chups liquorice croissant.'),(30,25,27,'2017-02-01 02:46:38','Brownie liquorice brownie jujubes pastry chupa chups chupa chups.'),(31,31,28,'2017-02-01 02:47:50','Soufflé jelly beans fruitcake bonbon brownie sweet cheesecake cheesecake soufflé.'),(32,31,27,'2017-02-01 02:47:59','Soufflé jelly beans fruitcake bonbon brownie sweet cheesecake cheesecake soufflé.'),(35,25,23,'2017-02-01 20:35:37','Oat cake sweet cotton candy chocolate carrot cake sesame snaps powder croissant tootsie roll.');
/*!40000 ALTER TABLE `Comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Messages`
--

DROP TABLE IF EXISTS `Messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Messages` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `senderID` int(11) DEFAULT NULL,
  `receiverID` int(11) DEFAULT NULL,
  `text` varchar(200) DEFAULT NULL,
  `viewed` tinyint(1) DEFAULT NULL,
  `creationDate` datetime DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `senderID` (`senderID`),
  KEY `receiverID` (`receiverID`),
  CONSTRAINT `Messages_ibfk_1` FOREIGN KEY (`senderID`) REFERENCES `Users` (`id`),
  CONSTRAINT `Messages_ibfk_2` FOREIGN KEY (`receiverID`) REFERENCES `Users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Messages`
--

LOCK TABLES `Messages` WRITE;
/*!40000 ALTER TABLE `Messages` DISABLE KEYS */;
INSERT INTO `Messages` VALUES (4,26,25,'Soufflé cookie lemon drops biscuit halvah powder.',1,'2017-02-01 10:00:51'),(5,25,26,'Candy canes sweet croissant chupa chups liquorice croissant.',1,'2017-02-01 10:03:25'),(10,26,25,'Bear claw carrot cake tart tart muffin cupcake sweet roll cookie icing.',1,'2017-02-01 12:14:34'),(13,25,26,'Powder tiramisu cheesecake powder. Brownie croissant bear claw sesame snaps.',0,'2017-02-01 13:33:53'),(14,25,31,'Tiramisu biscuit chupa chups muffin candy. Danish jelly-o pastry jelly lemon drops cheesecake jelly beans jelly-o.',1,'2017-02-01 14:27:07'),(17,31,25,'Lemon drops oat cake cookie liquorice jelly beans.',1,'2017-02-01 16:46:45'),(18,25,26,'Tart apple pie gingerbread jelly sugar plum.',0,'2017-02-01 20:18:40'),(19,32,26,'Cookie marshmallow apple pie chupa chups chocolate bar. Soufflé tiramisu caramels.',0,'2017-02-01 21:21:32'),(20,32,31,'Toffee lemon drops lemon drops muffin lemon drops.',1,'2017-02-01 21:54:31'),(21,31,26,'Chupa chups bear claw candy canes muffin jelly-o lollipop biscuit cookie cupcake.',0,'2017-02-01 23:02:25');
/*!40000 ALTER TABLE `Messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Tweets`
--

DROP TABLE IF EXISTS `Tweets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Tweets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userID` int(11) DEFAULT NULL,
  `text` varchar(200) DEFAULT NULL,
  `creationDate` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `userID` (`userID`),
  CONSTRAINT `Tweets_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `Users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Tweets`
--

LOCK TABLES `Tweets` WRITE;
/*!40000 ALTER TABLE `Tweets` DISABLE KEYS */;
INSERT INTO `Tweets` VALUES (23,25,'Cheesecake caramels soufflé oat cake. Tootsie roll chocolate cake powder candy canes donut gummi bears jujubes.','2017-02-01 01:38:16'),(24,25,'Chocolate cake liquorice lollipop gummies cookie lemon drops jelly beans.','2017-02-01 01:38:31'),(25,25,'Gingerbread lemon drops gummies pudding jelly-o jujubes cupcake icing gummi bears.','2017-02-01 01:38:45'),(26,26,'Tootsie roll danish apple pie dragée biscuit tootsie roll gummies. Jelly marshmallow lollipop.','2017-02-01 02:31:57'),(27,26,'Sweet roll croissant tootsie roll oat cake cotton candy carrot cake dragée chocolate bar sesame snaps.','2017-02-01 01:40:49'),(28,25,'Pie macaroon muffin jelly-o. Marshmallow bonbon liquorice pie cake chocolate bar ice cream tootsie roll candy.','2017-02-01 02:02:15'),(29,25,'Brownie liquorice brownie jujubes pastry chupa chups chupa chups.','2017-02-01 02:46:25'),(30,31,'Soufflé jelly beans fruitcake bonbon brownie sweet cheesecake cheesecake soufflé.','2017-02-01 02:47:38'),(32,31,'Marzipan muffin cotton candy chocolate donut. Icing biscuit apple pie danish lemon drops danish tootsie roll croissant sugar plum.','2017-02-01 22:53:32'),(34,31,'Jelly brownie lemon drops jelly brownie tiramisu tootsie roll. Chupa chups pie jelly beans.','2017-02-01 23:04:19');
/*!40000 ALTER TABLE `Tweets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Users`
--

DROP TABLE IF EXISTS `Users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `hashed_password` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Users`
--

LOCK TABLES `Users` WRITE;
/*!40000 ALTER TABLE `Users` DISABLE KEYS */;
INSERT INTO `Users` VALUES (25,'tomek@gmail.com','Tomek','$2y$10$3baXKoEC/AqVh/WBV0b1XOedisrotubG/fas7rePozOLbfGYOsRJ2'),(26,'kamila@gmail.com','Kamila','$2y$10$wRhPzkImV.LKpuVkngcZSux80HrC2FEC6N0IHAigQ.HH9SxGp7Wve'),(31,'maciek@gmail.com','Maciek','$2y$10$DmWe0s35GccRGlMHYMvHJ.wNelYwnTZV5knaivNtCF6IJyiHMsqDO'),(32,'marcin@gmail.com','Marcin','$2y$10$C76rUxFOHa7zsfc5jc5TmO1vTLa2naGPDRumVwyCDQ/6/7i4sK4ua');
/*!40000 ALTER TABLE `Users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-02-01 23:12:33
