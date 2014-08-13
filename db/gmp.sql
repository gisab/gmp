/*
 Navicat Premium Data Transfer

 Source Server         : MySQL@MAMP
 Source Server Type    : MySQL
 Source Server Version : 50534
 Source Host           : localhost
 Source Database       : gmp

 Target Server Type    : MySQL
 Target Server Version : 50534
 File Encoding         : utf-8

 Date: 08/11/2014 14:30:31 PM
*/


-- ----------------------------
--  Table structure for `files`
-- ----------------------------
DROP TABLE IF EXISTS `files`;
CREATE TABLE `files` (
  `id` int(11) NOT NULL,
  `qid` varchar(128) NOT NULL,
  `filename` varchar(128) NOT NULL,
  `url` varchar(512) NOT NULL,
  PRIMARY KEY (`id`)
) ;

-- ----------------------------
--  Table structure for `queue`
-- ----------------------------
DROP TABLE IF EXISTS `queue`;
CREATE TABLE `queue` (
  `desc` varchar(128) NOT NULL DEFAULT '',
  `id` varchar(128) NOT NULL ,
  PRIMARY KEY (`id`)
) ;
