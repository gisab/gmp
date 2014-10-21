-- MySQL dump 10.13  Distrib 5.5.34, for osx10.6 (i386)
--
-- Host: 127.0.0.1    Database: gmp-ref
-- ------------------------------------------------------
-- Server version	5.5.34

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
-- Table structure for table `agent`
--

DROP TABLE IF EXISTS `agent`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `agent` (
  `id` varchar(10) NOT NULL,
  `cli` varchar(256) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `country`
--

DROP TABLE IF EXISTS `country`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `country` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `wkt` varchar(2000) NOT NULL,
  `geom` geometry NOT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`) USING BTREE,
  KEY `wkt` (`wkt`(767)) USING BTREE,
  SPATIAL KEY `geom` (`geom`)
) ENGINE=MyISAM AUTO_INCREMENT=1447 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `files`
--

DROP TABLE IF EXISTS `files`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `qid` varchar(128) NOT NULL,
  `filename` varchar(512) NOT NULL,
  `url` varchar(512) NOT NULL,
  `dwnstatus` enum('N','C','Q') NOT NULL DEFAULT 'N',
  `LAST_UPDATE` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `targetid` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `qid` (`qid`),
  KEY `qid_2` (`qid`,`targetid`),
  CONSTRAINT `fk` FOREIGN KEY (`qid`, `targetid`) REFERENCES `queue` (`id`, `targetid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `product`
--

DROP TABLE IF EXISTS `product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product` (
  `id` varchar(80) NOT NULL,
  `LAST_UPDATE` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `producttype` varchar(8) DEFAULT NULL,
  `orbit` int(6) DEFAULT NULL,
  `dtid` varchar(6) DEFAULT NULL,
  `start` datetime DEFAULT NULL,
  `stop` datetime DEFAULT NULL,
  `duration` int(4) DEFAULT NULL,
  `crc` varchar(6) DEFAULT NULL,
  `polarization` char(2) DEFAULT NULL,
  `footprint` geometry NOT NULL DEFAULT '',
  `size` bigint(20) DEFAULT NULL,
  `tags` varchar(2000) DEFAULT NULL,
  `json` varchar(2000) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk5` (`producttype`) USING HASH,
  KEY `fk6` (`dtid`) USING BTREE,
  KEY `fk7` (`start`) USING BTREE,
  KEY `fk8` (`stop`) USING BTREE,
  KEY `fk9` (`duration`) USING BTREE,
  SPATIAL KEY `geom` (`footprint`),
  KEY `idx` (`tags`(1000)) USING BTREE,
  KEY `idx2` (`json`(1000)) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `ins` BEFORE INSERT ON `product` FOR EACH ROW BEGIN 
IF SUBSTR(NEW.ID,8,3) IN ('RAW','GRD','SLC') THEN
   SET NEW.PRODUCTTYPE=TRIM(TRAILING '_' FROM SUBSTR(NEW.ID,5,7));
   SET NEW.POLARIZATION=TRIM(TRAILING '_' FROM SUBSTR(NEW.ID,15,2));
   set NEW.START=SUBSTR(NEW.ID,18,15);
   set NEW.STOP=SUBSTR(NEW.ID,34,15);
   SET NEW.DURATION=TIME_TO_SEC(TIMEDIFF(NEW.STOP,NEW.START));
   set NEW.ORBIT=SUBSTR(NEW.ID,50,6);
   IF SUBSTR(NEW.ID,5,2) NOT IN ('HK','GP') THEN
      set NEW.DTID=SUBSTR(NEW.ID,57,6);
   ELSE
      set NEW.DTID=-10;
   END IF;
   set NEW.CRC=SUBSTR(NEW.ID,64,4);
ELSE
   SET NEW.PRODUCTTYPE='#';
END IF;
set NEW.LAST_UPDATE=now();
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `queue`
--

DROP TABLE IF EXISTS `queue`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `queue` (
  `id` varchar(128) NOT NULL COMMENT 'client id',
  `note` varchar(128) NOT NULL DEFAULT '',
  `status` varchar(16) NOT NULL,
  `dwnstatus` enum('N','C','Q') NOT NULL DEFAULT 'N',
  `LAST_UPDATE` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `pid` varchar(8) DEFAULT NULL,
  `agentid` varchar(10) DEFAULT NULL,
  `targetid` varchar(10) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`,`targetid`),
  KEY `iid` (`id`) USING BTREE,
  KEY `ipid` (`pid`) USING BTREE,
  KEY `istatus` (`status`) USING BTREE,
  KEY `dstatus` (`dwnstatus`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `insPrd` BEFORE INSERT ON `queue` FOR EACH ROW BEGIN
SELECT count(*) into @npr FROM product where product.id=new.id;
   IF @npr=0 THEN
      INSERT INTO product (id, footprint) values (new.id, GeomFromText('POINT(0 0)'));
   END IF;
end */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `updQueue` BEFORE UPDATE ON `queue` FOR EACH ROW BEGIN
IF (new.dwnstatus!=old.dwnstatus and new.dwnstatus='Q' )THEN
  UPDATE files set `dwnstatus`= new.dwnstatus where files.qid=new.id;
END IF;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `target`
--

DROP TABLE IF EXISTS `target`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `target` (
  `id` varchar(10) NOT NULL,
  `type` enum('oda','dhus','lfs') NOT NULL,
  `hostname` varchar(128) NOT NULL,
  `username` varchar(64) NOT NULL,
  `password` varchar(64) NOT NULL,
  `protocol` varchar(10) NOT NULL DEFAULT 'http:80',
  `port` int(11) NOT NULL,
  `rep` varchar(256) NOT NULL DEFAULT '$PRJ/rep/',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Temporary table structure for view `vfiles_lasthour`
--

DROP TABLE IF EXISTS `vfiles_lasthour`;
/*!50001 DROP VIEW IF EXISTS `vfiles_lasthour`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `vfiles_lasthour` (
  `id` tinyint NOT NULL,
  `qid` tinyint NOT NULL,
  `targetid` tinyint NOT NULL,
  `filename` tinyint NOT NULL,
  `url` tinyint NOT NULL,
  `dwnstatus` tinyint NOT NULL,
  `LAST_UPDATE` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;
