-- MySQL dump 10.13  Distrib 5.5.34, for osx10.6 (i386)
--
-- Host: 127.0.0.1    Database: gmp
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
) ENGINE=InnoDB AUTO_INCREMENT=109364 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `old-countrygeom`
--

DROP TABLE IF EXISTS `old-countrygeom`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `old-countrygeom` (
  `cid` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `tld` char(2) NOT NULL DEFAULT '',
  `geom` text,
  PRIMARY KEY (`cid`)
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `old-countrynames`
--

DROP TABLE IF EXISTS `old-countrynames`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `old-countrynames` (
  `cid` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `tld` char(2) NOT NULL DEFAULT '',
  `cnameen` char(128) DEFAULT NULL,
  `cnamede` char(128) DEFAULT NULL,
  PRIMARY KEY (`cid`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=latin1;
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
  `kml` varchar(2000) DEFAULT NULL,
  `polarization` char(2) DEFAULT NULL,
  `footprint` geometry NOT NULL DEFAULT '',
  `wkt` varchar(2000) DEFAULT NULL,
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
  `LAST_UPDATE` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `pid` varchar(8) DEFAULT NULL,
  `agentid` varchar(10) DEFAULT NULL,
  `targetid` varchar(10) NOT NULL DEFAULT '',
  `footprintwkt` varchar(1000) DEFAULT NULL,
  `tags` varchar(2000) DEFAULT NULL,
  `footprint` geometry DEFAULT NULL,
  `dwnstatus` enum('N','C','Q') NOT NULL DEFAULT 'N',
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

--
-- Temporary table structure for view `vproduct_lasthour`
--

DROP TABLE IF EXISTS `vproduct_lasthour`;
/*!50001 DROP VIEW IF EXISTS `vproduct_lasthour`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `vproduct_lasthour` (
  `id` tinyint NOT NULL,
  `LAST_UPDATE` tinyint NOT NULL,
  `producttype` tinyint NOT NULL,
  `orbit` tinyint NOT NULL,
  `dtid` tinyint NOT NULL,
  `start` tinyint NOT NULL,
  `stop` tinyint NOT NULL,
  `duration` tinyint NOT NULL,
  `crc` tinyint NOT NULL,
  `kml` tinyint NOT NULL,
  `polarization` tinyint NOT NULL,
  `footprint` tinyint NOT NULL,
  `wkt` tinyint NOT NULL,
  `tags` tinyint NOT NULL,
  `json` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `vqueue_lasthour`
--

DROP TABLE IF EXISTS `vqueue_lasthour`;
/*!50001 DROP VIEW IF EXISTS `vqueue_lasthour`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `vqueue_lasthour` (
  `id` tinyint NOT NULL,
  `note` tinyint NOT NULL,
  `status` tinyint NOT NULL,
  `LAST_UPDATE` tinyint NOT NULL,
  `pid` tinyint NOT NULL,
  `agentid` tinyint NOT NULL,
  `targetid` tinyint NOT NULL,
  `footprintwkt` tinyint NOT NULL,
  `tags` tinyint NOT NULL,
  `footprint` tinyint NOT NULL,
  `dwnstatus` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `vqueue_nok`
--

DROP TABLE IF EXISTS `vqueue_nok`;
/*!50001 DROP VIEW IF EXISTS `vqueue_nok`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `vqueue_nok` (
  `id` tinyint NOT NULL,
  `note` tinyint NOT NULL,
  `status` tinyint NOT NULL,
  `LAST_UPDATE` tinyint NOT NULL,
  `pid` tinyint NOT NULL,
  `agentid` tinyint NOT NULL,
  `targetid` tinyint NOT NULL,
  `footprintwkt` tinyint NOT NULL,
  `tags` tinyint NOT NULL,
  `footprint` tinyint NOT NULL,
  `dwnstatus` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `vqueue_stats`
--

DROP TABLE IF EXISTS `vqueue_stats`;
/*!50001 DROP VIEW IF EXISTS `vqueue_stats`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `vqueue_stats` (
  `targetid` tinyint NOT NULL,
  `status` tinyint NOT NULL,
  `dwnstatus` tinyint NOT NULL,
  `nrec` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Dumping routines for database 'gmp'
--

--
-- Final view structure for view `vfiles_lasthour`
--

/*!50001 DROP TABLE IF EXISTS `vfiles_lasthour`*/;
/*!50001 DROP VIEW IF EXISTS `vfiles_lasthour`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vfiles_lasthour` AS select `files`.`id` AS `id`,`files`.`qid` AS `qid`,`files`.`targetid` AS `targetid`,`files`.`filename` AS `filename`,`files`.`url` AS `url`,`files`.`dwnstatus` AS `dwnstatus`,`files`.`LAST_UPDATE` AS `LAST_UPDATE` from `files` where (`files`.`LAST_UPDATE` > (now() - interval 1 hour)) order by `files`.`LAST_UPDATE` desc */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vproduct_lasthour`
--

/*!50001 DROP TABLE IF EXISTS `vproduct_lasthour`*/;
/*!50001 DROP VIEW IF EXISTS `vproduct_lasthour`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vproduct_lasthour` AS select `product`.`id` AS `id`,`product`.`LAST_UPDATE` AS `LAST_UPDATE`,`product`.`producttype` AS `producttype`,`product`.`orbit` AS `orbit`,`product`.`dtid` AS `dtid`,`product`.`start` AS `start`,`product`.`stop` AS `stop`,`product`.`duration` AS `duration`,`product`.`crc` AS `crc`,`product`.`kml` AS `kml`,`product`.`polarization` AS `polarization`,`product`.`footprint` AS `footprint`,`product`.`wkt` AS `wkt`,`product`.`tags` AS `tags`,`product`.`json` AS `json` from `product` where (`product`.`LAST_UPDATE` > (now() - interval 1 hour)) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vqueue_lasthour`
--

/*!50001 DROP TABLE IF EXISTS `vqueue_lasthour`*/;
/*!50001 DROP VIEW IF EXISTS `vqueue_lasthour`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vqueue_lasthour` AS select `queue`.`id` AS `id`,`queue`.`note` AS `note`,`queue`.`status` AS `status`,`queue`.`LAST_UPDATE` AS `LAST_UPDATE`,`queue`.`pid` AS `pid`,`queue`.`agentid` AS `agentid`,`queue`.`targetid` AS `targetid`,`queue`.`footprintwkt` AS `footprintwkt`,`queue`.`tags` AS `tags`,`queue`.`footprint` AS `footprint`,`queue`.`dwnstatus` AS `dwnstatus` from `queue` where (`queue`.`LAST_UPDATE` > (now() - interval 1 hour)) order by `queue`.`LAST_UPDATE` desc */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vqueue_nok`
--

/*!50001 DROP TABLE IF EXISTS `vqueue_nok`*/;
/*!50001 DROP VIEW IF EXISTS `vqueue_nok`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vqueue_nok` AS select `queue`.`id` AS `id`,`queue`.`note` AS `note`,`queue`.`status` AS `status`,`queue`.`LAST_UPDATE` AS `LAST_UPDATE`,`queue`.`pid` AS `pid`,`queue`.`agentid` AS `agentid`,`queue`.`targetid` AS `targetid`,`queue`.`footprintwkt` AS `footprintwkt`,`queue`.`tags` AS `tags`,`queue`.`footprint` AS `footprint`,`queue`.`dwnstatus` AS `dwnstatus` from `queue` where ((`queue`.`status` = 'NOK') or (`queue`.`pid` is not null)) order by `queue`.`pid`,`queue`.`LAST_UPDATE` desc */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vqueue_stats`
--

/*!50001 DROP TABLE IF EXISTS `vqueue_stats`*/;
/*!50001 DROP VIEW IF EXISTS `vqueue_stats`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vqueue_stats` AS select `queue`.`targetid` AS `targetid`,`queue`.`status` AS `status`,`queue`.`dwnstatus` AS `dwnstatus`,count(`queue`.`id`) AS `nrec` from `queue` group by `queue`.`status`,`queue`.`dwnstatus`,`queue`.`targetid` order by `queue`.`targetid`,`queue`.`status` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-10-11  9:01:25
