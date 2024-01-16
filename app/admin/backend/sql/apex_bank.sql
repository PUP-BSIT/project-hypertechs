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
  `account_name` varchar(50) DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `balance` decimal(10,2) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`account_number`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `account`
--

LOCK TABLES `account` WRITE;
/*!40000 ALTER TABLE `account` DISABLE KEYS */;
INSERT INTO `account` VALUES
('189913463202','asfasf asfasf','1211231',0.00,'123'),
('189931806813','Maria  Alonzo','09123456789',47600.00,'123'),
('189954760695','Luisa Cruz','09123456789',53400.00,'123'),
('189965887074','asfa afasf','13212',0.00,'123'),
('189972744161','asfasf fasf','12312',0.00,'123');
/*!40000 ALTER TABLE `account` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin` (
  `employee_number` int(11) NOT NULL,
  `employee_name` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`employee_number`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin`
--

LOCK TABLES `admin` WRITE;
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
INSERT INTO `admin` VALUES
(11,'Chelsea Cutler','123'),
(12,'Aaron Mitchell','456');
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;
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
  PRIMARY KEY (`bank_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `external_bank`
--

LOCK TABLES `external_bank` WRITE;
/*!40000 ALTER TABLE `external_bank` DISABLE KEYS */;
INSERT INTO `external_bank` VALUES
('12232','ABANK',NULL),
('greenaabb1122','GreenBank',NULL),
('happyeeff5566','HappyBank',NULL),
('newccdd3344','NewBank',NULL),
('VRZN','VRZN Bank','https://vrznbankapp.tech/api/receive-external-transfer.php');
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
('TID1704717979659bee9bde02d','189954760695','189931806813','2024-01-08',500.00),
('TID1704718932659bf254dfb13','189954760695','189931806813','2024-01-08',500.00),
('TID1704719141659bf325e93a0','189954760695','189931806813','2024-01-08',500.00),
('TID1704719411659bf43370eff','189954760695','189931806813','2024-01-08',500.00),
('TID1704719747659bf583e85c6','189931806813','189954760695','2024-01-08',500.00),
('TID1704719948659bf64c24dba','189931806813','189954760695','2024-01-08',500.00),
('TID1704720021659bf6956b730','189954760695','189931806813','2024-01-08',500.00),
('TID1704720168659bf7282d3ac','189954760695','189931806813','2024-01-08',250.00),
('TID1704726010659c0dfa01cce','189931806813','189954760695','2024-01-08',500.00),
('TID1704726231659c0ed7d1303','189931806813','189954760695','2024-01-08',250.00),
('TID1704726284659c0f0c0acd6','189931806813','189954760695','2024-01-08',1122.00),
('TID1704760399659c944f6c418','189931806813','189954760695','2024-01-09',78.00),
('TID1704760999659c96a754e17','189931806813','189954760695','2024-01-09',200.00);
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

-- Dump completed on 2024-01-09 12:09:19