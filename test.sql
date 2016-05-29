/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50617
Source Host           : localhost:3306
Source Database       : test

Target Server Type    : MYSQL
Target Server Version : 50617
File Encoding         : 65001

Date: 2016-05-29 16:30:28
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `news`
-- ----------------------------
DROP TABLE IF EXISTS `news`;
CREATE TABLE `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(128) NOT NULL,
  `slug` varchar(128) NOT NULL,
  `text` text NOT NULL,
  `news_type` enum('weather','economy','sport') DEFAULT 'sport',
  PRIMARY KEY (`id`),
  KEY `slug` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of news
-- ----------------------------
INSERT INTO `news` VALUES ('1', 'title1', '1', 'a;sfj aisdfha;sdkj;akhf;askfj ;kajsd f;jasd;fkajdslhasdkfgqoewasd', 'weather');
INSERT INTO `news` VALUES ('2', 'title 2', 'title-2', 'text 2 text 2 text 2\r\ntext 2\r\ntext 2', 'economy');
INSERT INTO `news` VALUES ('3', 'title 3', 'title-3', 'text 3 text 3 text 3', 'sport');
