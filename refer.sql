/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : clinic_ramet

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2020-03-13 02:01:37
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `refer`
-- ----------------------------
DROP TABLE IF EXISTS `refer`;
CREATE TABLE `refer` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `service_id` int(10) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `history` varchar(255) DEFAULT NULL COMMENT 'ประวัติการเจ็บป่วย',
  `lab` varchar(255) DEFAULT NULL COMMENT 'ผล lab',
  `diag` varchar(255) DEFAULT NULL COMMENT 'วินิจฉัย',
  `treat` varchar(255) DEFAULT NULL COMMENT 'การรักษา',
  `cause` varchar(255) DEFAULT NULL COMMENT 'สาเหตุที่ส่งตัว',
  `etc` varchar(255) DEFAULT NULL COMMENT 'อื่น ๆ ',
  `sex` char(1) DEFAULT NULL COMMENT 'M = ชาย F = หญิง',
  `age` int(3) DEFAULT NULL COMMENT 'อายุ',
  `to` varchar(255) DEFAULT NULL COMMENT 'เรียนถึง',
  `tel` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of refer
-- ----------------------------
