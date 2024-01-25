-- MariaDB dump 10.19  Distrib 10.11.4-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: apex_bank
-- ------------------------------------------------------
-- Server version	10.11.4-MariaDB-1~deb12u1

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
-- Table structure for table `account`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `account` (
  `account_number` varchar(50) NOT NULL,
  `balance` decimal(11,2) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `surname` varchar(50) DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `middle_name` varchar(50) DEFAULT NULL,
  `suffix` varchar(50) DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `email` varchar(320) DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `creation_date` date DEFAULT NULL,
  `card_number` varchar(50) DEFAULT NULL,
  `card_expiration_date` date DEFAULT NULL,
  `cvv` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`account_number`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `account`
--

LOCK TABLES `account` WRITE;
/*!40000 ALTER TABLE `account` DISABLE KEYS */;
INSERT INTO `account` VALUES
('189930592671',375.00,'Password1-','afa','asfas','','','09111111112','afas','user@domain.tldr','1999-12-12',NULL,NULL,NULL,NULL),
('189938813543',500.00,'Password1-','asfasf','asf','asfas','','09111111000','09550266782','afas@asasf.com','2000-12-12',NULL,NULL,NULL,NULL),
('189941616513',485.00,'Password1-','asfafasf','asfasf','asfsaf','asfas','09123123212','assafa','safasf@asfas.asooo','2001-02-12',NULL,'1077685384003046','2029-01-22','579'),
('189948313647',520.25,'Password1-','Bonifacio','Andres','','','09111111111','Taguig','afasf','1999-12-31',NULL,NULL,NULL,NULL),
('189950727454',500.00,'Password1-','1231231','12312321','123123','13123','09121211110','09121211110','asfas@ssiii.com','2001-12-12',NULL,NULL,NULL,NULL),
('189953803781',324.00,'Password1-','Serrano','Calib','','','09121211111','taguig','user@you.com','2001-12-12',NULL,NULL,NULL,NULL),
('189957119904',400.00,'Password1-','asf','asfas','asfas','','09911111111','Taguig','mmmy@email.com','2001-02-12',NULL,NULL,NULL,NULL),
('189957715423',541.00,'Calibserrano1-1','Serrano','Calib','','','09121111111','Taguig','my@email.com','2002-12-12',NULL,NULL,NULL,NULL),
('189963629528',720.00,'Ppassword1-','saf','sfasf','afasf','','09121212121','taguig','user@mm.com','2002-12-12',NULL,NULL,NULL,NULL),
('189967205428',494.75,'Calibserrano1-','Serrano','Calib','','','09550266782','Taguig','user@domain.tld','2001-12-13',NULL,'1223487659091234','2029-01-22','138');
/*!40000 ALTER TABLE `account` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admin`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin` (
  `admin_id` varchar(50) NOT NULL,
  `password` varchar(50) DEFAULT NULL,
  `surname` varchar(50) DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `middle_name` varchar(50) DEFAULT NULL,
  `suffix` varchar(50) DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `email` varchar(320) DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  PRIMARY KEY (`admin_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin`
--

LOCK TABLES `admin` WRITE;
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
INSERT INTO `admin` VALUES
('189915847198','Password1-','Serrano','Calib','','','09111111111','user@domain.tld','2001-12-13');
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `deposit`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `deposit` (
  `transaction_id` varchar(50) NOT NULL,
  `admin_id` varchar(50) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `account_number` varchar(50) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `time` time DEFAULT NULL,
  PRIMARY KEY (`transaction_id`),
  KEY `account_number` (`account_number`),
  KEY `admin_id` (`admin_id`),
  CONSTRAINT `deposit_ibfk_1` FOREIGN KEY (`account_number`) REFERENCES `account` (`account_number`),
  CONSTRAINT `deposit_ibfk_2` FOREIGN KEY (`admin_id`) REFERENCES `admin` (`admin_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `deposit`
--

LOCK TABLES `deposit` WRITE;
/*!40000 ALTER TABLE `deposit` DISABLE KEYS */;
INSERT INTO `deposit` VALUES
('TID170550874265a7ff861ef78','189915847198',12.00,'189967205428','2024-01-17',NULL),
('TID170550875965a7ff9734ebc','189915847198',12.00,'189967205428','2024-01-17',NULL),
('TID170550881765a7ffd1b2756','189915847198',12.00,'189967205428','2024-01-17',NULL),
('TID170550966565a803218931a','189915847198',12.00,'189967205428','2024-01-17',NULL),
('TID170550970565a8034903502','189915847198',12.00,'189967205428','2024-01-17',NULL),
('TID170550976065a8038045840','189915847198',12.00,'189967205428','2024-01-17','04:42:00');
/*!40000 ALTER TABLE `deposit` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `external_bank`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `external_bank` (
  `bank_code` varchar(50) NOT NULL,
  `bank_name` varchar(50) DEFAULT NULL,
  `api_url` varchar(255) DEFAULT NULL,
  `result_url` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`bank_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `external_bank`
--

LOCK TABLES `external_bank` WRITE;
/*!40000 ALTER TABLE `external_bank` DISABLE KEYS */;
INSERT INTO `external_bank` VALUES
('12232','ABANK',NULL,NULL),
('greenaabb1122','GreenBank',NULL,NULL),
('happyeeff5566','HappyBank',NULL,NULL),
('newccdd3344','NewBank',NULL,NULL),
('VRZN','VRZN Bank','https://vrznbankapp.tech/api/receive-external-transfer.php',NULL);
/*!40000 ALTER TABLE `external_bank` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fund_transfer`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fund_transfer` (
  `transaction_id` varchar(50) NOT NULL,
  `source` varchar(50) DEFAULT NULL,
  `recipient` varchar(50) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `time` time DEFAULT NULL,
  `description` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`transaction_id`),
  KEY `source` (`source`),
  KEY `recipient` (`recipient`),
  CONSTRAINT `fund_transfer_ibfk_1` FOREIGN KEY (`source`) REFERENCES `account` (`account_number`),
  CONSTRAINT `fund_transfer_ibfk_2` FOREIGN KEY (`recipient`) REFERENCES `account` (`account_number`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fund_transfer`
--

LOCK TABLES `fund_transfer` WRITE;
/*!40000 ALTER TABLE `fund_transfer` DISABLE KEYS */;
INSERT INTO `fund_transfer` VALUES
('TID1381355020240122','189967205428','189948313647','2024-01-22',12.50,'21:11:00',NULL),
('TID1391777120240115','189967205428','189953803781','2024-01-15',12.00,'03:35:00',NULL),
('TID2502218320240122','189948313647','189967205428','2024-01-22',12.50,'17:05:00',NULL),
('TID2954666020240115','189967205428','189957715423','2024-01-15',21.00,'11:13:00',NULL),
('TID4195908420240122','189948313647','189967205428','2024-01-22',12.00,'16:15:00',NULL),
('TID5871726920240122','189948313647','189967205428','2024-01-22',12.50,'16:16:00',NULL),
('TID7548738420240118','189967205428','189963629528','2024-01-18',5.00,'22:54:00',NULL),
('TID7718307420240115','189967205428','189957715423','2024-01-15',25.00,'12:14:00',NULL),
('TID8071115320240122','189941616513','189967205428','2024-01-22',15.00,'19:33:00',NULL),
('TID9723152120240122','189948313647','189967205428','2024-01-22',12.75,'16:57:00',NULL),
('TID9852960220240124','189967205428','189948313647','2024-01-24',33.00,'00:59:00','saffff');
/*!40000 ALTER TABLE `fund_transfer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fund_transfer_external_receive`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fund_transfer_external_receive` (
  `transaction_id` varchar(50) NOT NULL,
  `source` varchar(50) DEFAULT NULL,
  `recipient` varchar(50) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `bank_code` varchar(50) DEFAULT NULL,
  `time` time DEFAULT NULL,
  PRIMARY KEY (`transaction_id`),
  KEY `recipient` (`recipient`),
  KEY `bank_code` (`bank_code`),
  CONSTRAINT `fund_transfer_external_receive_ibfk_1` FOREIGN KEY (`recipient`) REFERENCES `account` (`account_number`),
  CONSTRAINT `fund_transfer_external_receive_ibfk_2` FOREIGN KEY (`bank_code`) REFERENCES `external_bank` (`bank_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fund_transfer_external_receive`
--

LOCK TABLES `fund_transfer_external_receive` WRITE;
/*!40000 ALTER TABLE `fund_transfer_external_receive` DISABLE KEYS */;
INSERT INTO `fund_transfer_external_receive` VALUES
('TID1044147520240114','189948313647','189930592671','2024-01-14',50.00,'VRZN',NULL),
('TID1243004320240115','189967205428','189957715423','2024-01-15',50.00,'VRZN',NULL),
('TID1706132220240118','189967205428','189963629528','2024-01-18',5.00,'VRZN','23:28:00'),
('TID3100172520240114','189948313647','189930592671','2024-01-14',50.00,'VRZN',NULL),
('TID5155425520240114','189948313647','189930592671','2024-01-14',50.00,'VRZN',NULL),
('TID5388888720240115','189967205428','189963629528','2024-01-15',50.00,'VRZN',NULL),
('TID5509300120240115','189967205428','189957715423','2024-01-15',23.00,'VRZN',NULL),
('TID5698589120240115','189967205428','189957715423','2024-01-15',22.00,'VRZN',NULL),
('TID6946712820240114','189948313647','189930592671','2024-01-14',50.00,'VRZN',NULL),
('TID7372739920240115','189967205428','189953803781','2024-01-15',12.00,'VRZN',NULL),
('TID7776889220240114','189957715423','189953803781','2024-01-14',50.00,'VRZN',NULL),
('TID8033000320240114','189948313647','189953803781','2024-01-14',50.00,'VRZN',NULL);
/*!40000 ALTER TABLE `fund_transfer_external_receive` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fund_transfer_external_send`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fund_transfer_external_send` (
  `transaction_id` varchar(50) NOT NULL,
  `source` varchar(50) DEFAULT NULL,
  `recipient` varchar(50) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `bank_code` varchar(50) DEFAULT NULL,
  `time` time DEFAULT NULL,
  PRIMARY KEY (`transaction_id`),
  KEY `source` (`source`),
  KEY `bank_code` (`bank_code`),
  CONSTRAINT `fund_transfer_external_send_ibfk_1` FOREIGN KEY (`source`) REFERENCES `account` (`account_number`),
  CONSTRAINT `fund_transfer_external_send_ibfk_2` FOREIGN KEY (`bank_code`) REFERENCES `external_bank` (`bank_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fund_transfer_external_send`
--

LOCK TABLES `fund_transfer_external_send` WRITE;
/*!40000 ALTER TABLE `fund_transfer_external_send` DISABLE KEYS */;
INSERT INTO `fund_transfer_external_send` VALUES
('TID1035759820240117','189967205428','85806301','2024-01-17',10.00,'VRZN','10:42:00'),
('TID1064831920240117','189967205428','92084444','2024-01-17',12.00,'VRZN','09:40:00'),
('TID1420201420240117','189967205428','92084444','2024-01-17',12.00,'VRZN','10:27:00'),
('TID1595586020240116','189967205428','92084444','2024-01-16',12.00,'VRZN','06:52:00'),
('TID1703414520240117','189967205428','92084444','2024-01-17',12.00,'VRZN','10:30:00'),
('TID1706132220240118','189967205428','189963629528','2024-01-18',5.00,'VRZN','23:28:00'),
('TID1791853220240117','189967205428','92084444','2024-01-17',12.00,'VRZN','09:34:00'),
('TID1919398820240117','189967205428','92084444','2024-01-17',12.00,'VRZN','04:01:00'),
('TID2304285920240117','189967205428','92084444','2024-01-17',12.00,'VRZN','04:07:00'),
('TID2510222320240116','189967205428','92084444','2024-01-16',12.00,'VRZN','07:50:00'),
('TID3023485420240116','189967205428','92084444','2024-01-16',12.00,'VRZN','06:58:00'),
('TID3113997420240117','189967205428','92084444','2024-01-17',12.00,'VRZN','06:18:00'),
('TID4339163620240116','189967205428','92084444','2024-01-16',12.00,'VRZN','07:46:00'),
('TID4672837820240117','189967205428','92084444','2024-01-17',12.00,'VRZN','10:18:00'),
('TID4765161620240116','189967205428','92084444','2024-01-16',12.00,'VRZN','06:37:00'),
('TID4987877620240117','189967205428','92084444','2024-01-17',12.00,'VRZN','04:10:00'),
('TID5071151620240116','189967205428','92084444','2024-01-16',12.00,'VRZN','06:56:00'),
('TID5295049220240117','189967205428','85806301','2024-01-17',10.00,'VRZN','10:43:00'),
('TID5383035620240117','189967205428','92084444','2024-01-17',12.00,'VRZN','04:05:00'),
('TID5509300120240115','189967205428','189957715423','2024-01-15',23.00,'VRZN','10:49:00'),
('TID5698589120240115','189967205428','189957715423','2024-01-15',22.00,'VRZN','12:16:00'),
('TID5923705420240116','189967205428','92084444','2024-01-16',12.00,'VRZN','07:46:00'),
('TID6108478020240116','189967205428','92084444','2024-01-16',12.00,'VRZN','07:56:00'),
('TID6135613320240116','189967205428','92084444','2024-01-16',12.00,'VRZN','07:06:00'),
('TID6640722720240116','189967205428','92084444','2024-01-16',12.00,'VRZN','06:17:00'),
('TID6843775120240117','189967205428','92084444','2024-01-17',12.00,'VRZN','09:41:00'),
('TID7161230920240116','189967205428','92084444','2024-01-16',12.00,'VRZN','07:49:00'),
('TID7199229820240117','189967205428','92084444','2024-01-17',12.00,'VRZN','10:24:00'),
('TID7372739920240115','189967205428','189953803781','2024-01-15',12.00,'VRZN','03:41:00'),
('TID7378004720240116','189967205428','92084444','2024-01-16',12.00,'VRZN','07:09:00'),
('TID7428162520240117','189967205428','92084444','2024-01-17',12.00,'VRZN','10:15:00'),
('TID7748691220240117','189967205428','92084444','2024-01-17',12.00,'VRZN','10:22:00'),
('TID7983369820240116','189967205428','92084444','2024-01-16',12.00,'VRZN','07:51:00'),
('TID8177869820240117','189967205428','92084444','2024-01-17',12.00,'VRZN','04:03:00'),
('TID8382949520240116','189967205428','92084444','2024-01-16',12.00,'VRZN','06:17:00'),
('TID8709316520240117','189967205428','92084444','2024-01-17',12.00,'VRZN','10:33:00'),
('TID8802892220240117','189967205428','92084444','2024-01-17',12.00,'VRZN','06:08:00'),
('TID9014948120240116','189967205428','92084444','2024-01-16',12.00,'VRZN','07:55:00'),
('TID9871985520240117','189967205428','92084444','2024-01-17',12.00,'VRZN','04:09:00');
/*!40000 ALTER TABLE `fund_transfer_external_send` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `withdraw`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `withdraw` (
  `transaction_id` varchar(50) NOT NULL,
  `admin_id` varchar(50) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `account_number` varchar(50) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `time` time DEFAULT NULL,
  PRIMARY KEY (`transaction_id`),
  KEY `account_number` (`account_number`),
  KEY `admin_id` (`admin_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `withdraw`
--

LOCK TABLES `withdraw` WRITE;
/*!40000 ALTER TABLE `withdraw` DISABLE KEYS */;
INSERT INTO `withdraw` VALUES
('TID170551020565a8053d726bd','189915847198',12.00,'189967205428','2024-01-17','04:50:00'),
('TID170551022165a8054da5a69','189915847198',12.00,'189967205428','2024-01-17','04:50:00'),
('TID170551023265a80558df476','189915847198',10.00,'189967205428','2024-01-17','04:50:00');
/*!40000 ALTER TABLE `withdraw` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-01-25 22:08:36
