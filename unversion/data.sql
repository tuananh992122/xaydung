/*
Navicat MySQL Data Transfer

Source Server         : Localhost
Source Server Version : 50525
Source Host           : localhost:3306
Source Database       : test

Target Server Type    : MYSQL
Target Server Version : 50525
File Encoding         : 65001

Date: 2016-06-22 15:51:52
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for ad_group
-- ----------------------------
DROP TABLE IF EXISTS `ad_group`;
CREATE TABLE `ad_group` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `parent` tinyint(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ad_group
-- ----------------------------
INSERT INTO `ad_group` VALUES ('5', 'Admin', '0');
INSERT INTO `ad_group` VALUES ('19', 'Super Admin', '0');

-- ----------------------------
-- Table structure for ad_log
-- ----------------------------
DROP TABLE IF EXISTS `ad_log`;
CREATE TABLE `ad_log` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `admin_id` int(20) NOT NULL,
  `content` text NOT NULL,
  `time` int(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ad_log
-- ----------------------------

-- ----------------------------
-- Table structure for ad_menu
-- ----------------------------
DROP TABLE IF EXISTS `ad_menu`;
CREATE TABLE `ad_menu` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `location` varchar(250) NOT NULL,
  `parent` int(10) NOT NULL DEFAULT '0',
  `order` int(5) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0:active, 1:no',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ad_menu
-- ----------------------------
INSERT INTO `ad_menu` VALUES ('2', 'Thành viên & Phân quyền', 'ad_user', '0', '111', '0');
INSERT INTO `ad_menu` VALUES ('3', 'Danh sách thành viên', 'ad_user/users', '2', '1', '0');
INSERT INTO `ad_menu` VALUES ('4', 'Nhóm thành viên', 'ad_user/group', '2', '2', '0');
INSERT INTO `ad_menu` VALUES ('6', 'Quản lý menu chức năng', 'ad_user/menu', '2', '3', '0');
INSERT INTO `ad_menu` VALUES ('7', 'Quản lý tài khoản', 'profile', '0', '10', '1');
INSERT INTO `ad_menu` VALUES ('8', 'Tài khoản cá nhân', 'profile/yourself', '7', '1', '0');
INSERT INTO `ad_menu` VALUES ('9', 'Thành viên trong nhóm', 'profile/group', '7', '2', '0');
INSERT INTO `ad_menu` VALUES ('10', 'Quản lý chung', 'setting', '0', '9', '0');
INSERT INTO `ad_menu` VALUES ('11', 'Cấu hình SEO', 'setting/onpage', '10', '15', '0');
INSERT INTO `ad_menu` VALUES ('19', 'Cấu hình', 'setting/config', '10', '2', '0');

-- ----------------------------
-- Table structure for ad_permission
-- ----------------------------
DROP TABLE IF EXISTS `ad_permission`;
CREATE TABLE `ad_permission` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `group_id` int(10) NOT NULL,
  `menu_id` int(20) NOT NULL,
  `chmod` int(3) NOT NULL DEFAULT '777',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=88 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ad_permission
-- ----------------------------

-- ----------------------------
-- Table structure for ad_user
-- ----------------------------
DROP TABLE IF EXISTS `ad_user`;
CREATE TABLE `ad_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `name` varchar(250) DEFAULT NULL,
  `email` varchar(250) DEFAULT NULL,
  `mobile` varchar(50) DEFAULT NULL,
  `date` datetime NOT NULL,
  `is_lock` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0:none,1:lock',
  `group_id` int(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ad_user
-- ----------------------------
INSERT INTO `ad_user` VALUES ('2', 'ntson1009', '6d97fce1edb9c5e85db5e51463b17472', 'Nguyễn Thanh Sơn', 'ntson1009@gmail.com', '0983541785', '2016-03-15 00:15:29', '0', '0');

-- ----------------------------
-- Table structure for ad_user_group
-- ----------------------------
DROP TABLE IF EXISTS `ad_user_group`;
CREATE TABLE `ad_user_group` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `ad_id` int(20) NOT NULL,
  `group_id` int(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ad_user_group
-- ----------------------------
INSERT INTO `ad_user_group` VALUES ('1', '4', '8');
INSERT INTO `ad_user_group` VALUES ('2', '5', '5');
INSERT INTO `ad_user_group` VALUES ('3', '6', '5');
INSERT INTO `ad_user_group` VALUES ('4', '3', '5');

-- ----------------------------
-- Table structure for tb_config
-- ----------------------------
DROP TABLE IF EXISTS `tb_config`;
CREATE TABLE `tb_config` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `content` text NOT NULL,
  `content_en` text,
  `kind` tinyint(1) NOT NULL COMMENT '0:input,1:textarea',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tb_config
-- ----------------------------
INSERT INTO `tb_config` VALUES ('1', 'Tiêu đề', '', null, '0');
INSERT INTO `tb_config` VALUES ('2', 'Miêu tả', '', null, '1');
INSERT INTO `tb_config` VALUES ('3', 'Từ khóa', '', null, '0');
INSERT INTO `tb_config` VALUES ('4', 'Tiêu đề', '', null, '0');
INSERT INTO `tb_config` VALUES ('5', 'Miêu tả', '', null, '1');
INSERT INTO `tb_config` VALUES ('7', 'Hotline', '', null, '0');
INSERT INTO `tb_config` VALUES ('8', 'Facebook page', '', null, '0');
INSERT INTO `tb_config` VALUES ('9', 'Bản đồ', '', null, '1');
INSERT INTO `tb_config` VALUES ('10', 'Email', '', null, '0');
INSERT INTO `tb_config` VALUES ('11', 'VAT', '', null, '0');
INSERT INTO `tb_config` VALUES ('12', 'Địa chỉ', '', null, '0');
INSERT INTO `tb_config` VALUES ('13', 'Điện thoại', '', null, '0');

-- ----------------------------
-- Table structure for tb_contact
-- ----------------------------
DROP TABLE IF EXISTS `tb_contact`;
CREATE TABLE `tb_contact` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `content` text NOT NULL,
  `time` int(20) NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0:no,1:yes',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tb_contact
-- ----------------------------

-- ----------------------------
-- Table structure for tb_news
-- ----------------------------
DROP TABLE IF EXISTS `tb_news`;
CREATE TABLE `tb_news` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `ad_id` int(20) NOT NULL,
  `cat_id` int(20) NOT NULL,
  `title` varchar(200) NOT NULL,
  `slug` varchar(200) NOT NULL,
  `caption` text NOT NULL,
  `content` text NOT NULL,
  `thumb` varchar(100) NOT NULL,
  `view` int(10) NOT NULL,
  `hot` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0:no, 1:yes',
  `state` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0:no, 1:yes',
  `time_create` int(20) NOT NULL DEFAULT '0',
  `seo_title` varchar(200) NOT NULL,
  `seo_desc` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=90 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tb_news
-- ----------------------------

-- ----------------------------
-- Table structure for tb_news_cat
-- ----------------------------
DROP TABLE IF EXISTS `tb_news_cat`;
CREATE TABLE `tb_news_cat` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `slug` varchar(150) NOT NULL,
  `parent` int(20) NOT NULL,
  `z_index` int(5) NOT NULL,
  `seo_title` varchar(200) NOT NULL,
  `seo_desc` varchar(250) NOT NULL,
  `state` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tb_news_cat
-- ----------------------------

-- ----------------------------
-- Table structure for tb_slug
-- ----------------------------
DROP TABLE IF EXISTS `tb_slug`;
CREATE TABLE `tb_slug` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `slug` varchar(200) NOT NULL,
  `controller` varchar(100) NOT NULL,
  `function` varchar(100) NOT NULL,
  `param` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tb_slug
-- ----------------------------

-- ----------------------------
-- Procedure structure for test_multi_sets
-- ----------------------------
DROP PROCEDURE IF EXISTS `test_multi_sets`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `test_multi_sets`()
    DETERMINISTIC
begin
        select user() as first_col;
        select user() as first_col, now() as second_col;
        select user() as first_col, now() as second_col, now() as third_col;
        end
;;
DELIMITER ;
