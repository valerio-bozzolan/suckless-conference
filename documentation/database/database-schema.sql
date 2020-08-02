-- MySQL dump 10.17  Distrib 10.3.22-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: itwikicon_conference
-- ------------------------------------------------------
-- Server version	10.3.22-MariaDB-0+deb10u1

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
-- Table structure for table `conf_chapter`
--

DROP TABLE IF EXISTS `conf_chapter`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `conf_chapter` (
  `chapter_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `chapter_uid` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `chapter_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`chapter_ID`),
  UNIQUE KEY `chapter_uid` (`chapter_uid`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `conf_conference`
--

DROP TABLE IF EXISTS `conf_conference`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `conf_conference` (
  `conference_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `conference_uid` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `conference_title` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `conference_subtitle` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `conference_acronym` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `conference_persons_url` varchar(512) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Not part of frab/Pentabarf standard',
  `conference_events_url` varchar(512) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Not part of frab/Pentabarf standard',
  `conference_quote` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `conference_city` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Has to be removed',
  `conference_description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `conference_start` datetime NOT NULL,
  `conference_end` datetime NOT NULL,
  `conference_days` int(11) NOT NULL,
  `location_ID` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`conference_ID`),
  UNIQUE KEY `conference_uid` (`conference_uid`),
  KEY `location_ID` (`location_ID`),
  CONSTRAINT `conf_conference_ibfk_1` FOREIGN KEY (`location_ID`) REFERENCES `conf_location` (`location_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `conf_event`
--

DROP TABLE IF EXISTS `conf_event`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `conf_event` (
  `event_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `event_uid` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `event_title` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `event_subtitle` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `event_abstract_it` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `event_abstract_en` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `event_abstract_pms` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `event_description_it` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `event_description_en` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `event_description_pms` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `event_note_it` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `event_note_en` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `event_note_pms` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `event_language` char(2) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `event_start` datetime NOT NULL,
  `event_end` datetime NOT NULL,
  `event_img` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `event_subscriptions` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Enable subscriptions',
  `conference_ID` int(10) unsigned NOT NULL,
  `room_ID` int(10) unsigned DEFAULT NULL,
  `track_ID` int(10) unsigned DEFAULT NULL,
  `chapter_ID` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`event_ID`),
  UNIQUE KEY `event_uid` (`event_uid`,`conference_ID`),
  KEY `room_ID` (`room_ID`),
  KEY `track_ID` (`track_ID`),
  KEY `chapter_ID` (`chapter_ID`),
  KEY `conference_ID` (`conference_ID`),
  KEY `event_start` (`event_start`),
  CONSTRAINT `events_ibfk_5` FOREIGN KEY (`conference_ID`) REFERENCES `conf_conference` (`conference_ID`) ON DELETE CASCADE,
  CONSTRAINT `events_ibfk_6` FOREIGN KEY (`chapter_ID`) REFERENCES `conf_chapter` (`chapter_ID`),
  CONSTRAINT `events_ibfk_7` FOREIGN KEY (`track_ID`) REFERENCES `conf_track` (`track_ID`),
  CONSTRAINT `events_ibfk_8` FOREIGN KEY (`room_ID`) REFERENCES `conf_room` (`room_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=240 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `conf_event_user`
--

DROP TABLE IF EXISTS `conf_event_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `conf_event_user` (
  `event_ID` int(10) unsigned NOT NULL,
  `user_ID` int(10) unsigned NOT NULL,
  `event_user_order` int(11) NOT NULL,
  UNIQUE KEY `user_ID_event_ID` (`event_ID`,`user_ID`),
  KEY `user_ID` (`user_ID`),
  KEY `event_ID` (`event_ID`),
  KEY `order` (`event_user_order`),
  CONSTRAINT `conf_event_user_ibfk_1` FOREIGN KEY (`user_ID`) REFERENCES `conf_user` (`user_ID`) ON DELETE CASCADE,
  CONSTRAINT `conf_event_user_ibfk_2` FOREIGN KEY (`event_ID`) REFERENCES `conf_event` (`event_ID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `conf_location`
--

DROP TABLE IF EXISTS `conf_location`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `conf_location` (
  `location_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `location_uid` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `location_name` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `location_address` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `location_note` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location_geothumb` varchar(254) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location_lat` float NOT NULL,
  `location_lng` float NOT NULL,
  `location_zoom` int(1) DEFAULT NULL,
  PRIMARY KEY (`location_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `conf_room`
--

DROP TABLE IF EXISTS `conf_room`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `conf_room` (
  `room_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `location_ID` int(10) unsigned NOT NULL,
  `room_uid` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `room_name` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`room_ID`),
  UNIQUE KEY `room_uid` (`room_uid`),
  KEY `location_ID` (`location_ID`),
  CONSTRAINT `conf_room_ibfk_1` FOREIGN KEY (`location_ID`) REFERENCES `conf_location` (`location_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `conf_sharable`
--

DROP TABLE IF EXISTS `conf_sharable`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `conf_sharable` (
  `sharable_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sharable_title` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Is this useful?',
  `sharable_path` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sharable_type` enum('video','image','document','youtube') COLLATE utf8mb4_unicode_ci NOT NULL,
  `sharable_mimetype` varchar(16) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Must be set for videos',
  `sharable_license` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `event_ID` int(10) unsigned NOT NULL,
  PRIMARY KEY (`sharable_ID`),
  KEY `event_ID` (`event_ID`),
  CONSTRAINT `conf_sharable_ibfk_1` FOREIGN KEY (`event_ID`) REFERENCES `conf_event` (`event_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `conf_skill`
--

DROP TABLE IF EXISTS `conf_skill`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `conf_skill` (
  `skill_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `skill_uid` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `skill_title` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `skill_type` enum('programming','subject') COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`skill_ID`),
  UNIQUE KEY `skill_uid` (`skill_uid`),
  KEY `skill_type` (`skill_type`)
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `conf_subscription`
--

DROP TABLE IF EXISTS `conf_subscription`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `conf_subscription` (
  `subscription_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `subscription_email` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subscription_confirmed` tinyint(1) NOT NULL DEFAULT 0,
  `subscription_date` datetime NOT NULL,
  `subscription_token` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `event_ID` int(10) unsigned NOT NULL,
  PRIMARY KEY (`subscription_ID`),
  UNIQUE KEY `subscription_email` (`event_ID`,`subscription_email`),
  CONSTRAINT `conf_subscription_ibfk_1` FOREIGN KEY (`event_ID`) REFERENCES `conf_event` (`event_ID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `conf_track`
--

DROP TABLE IF EXISTS `conf_track`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `conf_track` (
  `track_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `track_uid` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `track_name` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `track_order` smallint(1) NOT NULL,
  `track_label` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`track_ID`),
  UNIQUE KEY `track_uid` (`track_uid`),
  KEY `track_order` (`track_order`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `conf_user`
--

DROP TABLE IF EXISTS `conf_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `conf_user` (
  `user_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_uid` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_role` enum('admin','user','translator') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `user_public` tinyint(1) NOT NULL DEFAULT 1,
  `user_active` tinyint(4) NOT NULL DEFAULT 0,
  `user_name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_surname` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_title` varchar(16) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_email` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_gravatar` char(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_image` varchar(254) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Gravatar when NULL',
  `user_password` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_site` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_lovelicense` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_bio_it` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_bio_en` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_bio_pms` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_rss` varchar(254) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_twtr` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_fb` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_lnkd` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_googl` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_github` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`user_ID`),
  UNIQUE KEY `user_uid` (`user_uid`),
  UNIQUE KEY `user_email` (`user_email`)
) ENGINE=InnoDB AUTO_INCREMENT=158 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `conf_user_skill`
--

DROP TABLE IF EXISTS `conf_user_skill`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `conf_user_skill` (
  `user_ID` int(10) unsigned NOT NULL,
  `skill_ID` int(10) unsigned NOT NULL,
  `skill_score` int(11) NOT NULL,
  PRIMARY KEY (`user_ID`,`skill_ID`),
  KEY `skill_ID` (`skill_ID`),
  KEY `skill_score` (`skill_score`),
  CONSTRAINT `conf_user_skill_ibfk_1` FOREIGN KEY (`user_ID`) REFERENCES `conf_user` (`user_ID`) ON DELETE CASCADE,
  CONSTRAINT `conf_user_skill_ibfk_2` FOREIGN KEY (`skill_ID`) REFERENCES `conf_skill` (`skill_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-08-02 11:28:12
