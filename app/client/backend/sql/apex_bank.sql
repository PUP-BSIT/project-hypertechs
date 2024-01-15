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

DROP TABLE IF EXISTS `account`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `account` (
  `account_number` varchar(50) NOT NULL,
  `balance` decimal(10,2) DEFAULT NULL,
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
  PRIMARY KEY (`account_number`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `account`
--

LOCK TABLES `account` WRITE;
/*!40000 ALTER TABLE `account` DISABLE KEYS */;
INSERT INTO `account` VALUES
('189930592671',375.00,'Password1-','afa','asfas','','','09111111112','afas','user@domain.tldr','1999-12-12',NULL),
('189948313647',791.00,'Password1-','Bonifacio','Andres','','','09111111111','Taguig','afasf','1999-12-31',NULL),
('189953803781',300.00,'Password1-','Serrano','Calib','','','09121211111','taguig','user@you.com','2001-12-12',NULL),
('189957119904',400.00,'Password1-','asf','asfas','asfas','','09911111111','Taguig','mmmy@email.com','2001-02-12',NULL),
('189957715423',541.00,'Calibserrano1-1','Serrano','Calib','','','09121111111','Taguig','my@email.com','2002-12-12',NULL),
('189963629528',700.00,'Ppassword1-','saf','sfasf','afasf','','09121212121','taguig','user@mm.com','2002-12-12',NULL),
('189967205428',493.00,'Password1---','Serrano','Calib','','','09550266782','Taguig','user@domain.tld','2001-12-13',NULL);
/*!40000 ALTER TABLE `account` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `external_bank`
--

DROP TABLE IF EXISTS `external_bank`;
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

DROP TABLE IF EXISTS `fund_transfer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fund_transfer` (
  `transaction_id` varchar(50) NOT NULL,
  `source` varchar(50) DEFAULT NULL,
  `recipient` varchar(50) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `time` time DEFAULT NULL,
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
('TID2954666020240115','189967205428','189957715423','2024-01-15',21.00,'11:13:00'),
('TID7718307420240115','189967205428','189957715423','2024-01-15',25.00,'12:14:00');
/*!40000 ALTER TABLE `fund_transfer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fund_transfer_external_receive`
--

DROP TABLE IF EXISTS `fund_transfer_external_receive`;
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
('TID3100172520240114','189948313647','189930592671','2024-01-14',50.00,'VRZN',NULL),
('TID5155425520240114','189948313647','189930592671','2024-01-14',50.00,'VRZN',NULL),
('TID5388888720240115','189967205428','189963629528','2024-01-15',50.00,'VRZN',NULL),
('TID5509300120240115','189967205428','189957715423','2024-01-15',23.00,'VRZN',NULL),
('TID5698589120240115','189967205428','189957715423','2024-01-15',22.00,'VRZN',NULL),
('TID6946712820240114','189948313647','189930592671','2024-01-14',50.00,'VRZN',NULL),
('TID7776889220240114','189957715423','189953803781','2024-01-14',50.00,'VRZN',NULL),
('TID8033000320240114','189948313647','189953803781','2024-01-14',50.00,'VRZN',NULL);
/*!40000 ALTER TABLE `fund_transfer_external_receive` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fund_transfer_external_send`
--

DROP TABLE IF EXISTS `fund_transfer_external_send`;
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
('TID5509300120240115','189967205428','189957715423','2024-01-15',23.00,NULL,'10:49:00'),
('TID5698589120240115','189967205428','189957715423','2024-01-15',22.00,NULL,'12:16:00');
/*!40000 ALTER TABLE `fund_transfer_external_send` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-01-15 20:53:45
