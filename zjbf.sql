/*
 Navicat Premium Data Transfer

 Source Server         : 海创空间
 Source Server Type    : MySQL
 Source Server Version : 50723
 Source Host           : 47.101.167.237:3306
 Source Schema         : zjbf

 Target Server Type    : MySQL
 Target Server Version : 50723
 File Encoding         : 65001

 Date: 12/11/2018 10:34:01
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for hc_admin
-- ----------------------------
DROP TABLE IF EXISTS `hc_admin`;
CREATE TABLE `hc_admin`  (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT COMMENT '管理员ID',
  `username` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '管理员用户名',
  `password` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '管理员密码',
  `changepwd` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '更改密码时间',
  `email` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '邮箱',
  `realname` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '真实姓名',
  `avatar` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '头像',
  `logtimes` int(8) NOT NULL DEFAULT 1 COMMENT '登陆次数',
  `last_ip` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '上次登陆ip',
  `last_time` int(10) UNSIGNED NULL DEFAULT 0 COMMENT '上次登陆时间',
  `create_time` int(10) NULL DEFAULT 0 COMMENT '添加时间',
  `uid` int(10) NULL DEFAULT 0 COMMENT '前台uid',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `username`(`username`) USING BTREE,
  UNIQUE INDEX `uid`(`uid`) USING BTREE,
  INDEX `password`(`password`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '管理员' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of hc_admin
-- ----------------------------
INSERT INTO `hc_admin` VALUES (1, 'admin', '$2a$08$8h1megB0F3k4DWFOgDVcU.F4ioa9/yu6a6pBFyIIYv/eGKuRkxdvK', 1539957748, 'ppp@g.com', '管理员', '', 47, '49.87.177.88', 1541984356, 1539762731, 1);

-- ----------------------------
-- Table structure for hc_files
-- ----------------------------
DROP TABLE IF EXISTS `hc_files`;
CREATE TABLE `hc_files`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `enterprise_id` int(11) NOT NULL COMMENT '企业ID',
  `file_path` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '图片路径',
  `create_time` int(11) NULL DEFAULT NULL COMMENT '上传时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for hc_give_money_log
-- ----------------------------
DROP TABLE IF EXISTS `hc_give_money_log`;
CREATE TABLE `hc_give_money_log`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `enterprise_id` int(11) NOT NULL COMMENT '企业ID',
  `give_money_time` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '拨款时间',
  `give_money` decimal(20, 2) NOT NULL COMMENT '拨款金额(万)',
  `handler` tinyint(1) NOT NULL COMMENT '拨款人id',
  `create_time` int(11) NOT NULL COMMENT '操作时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for hc_help_enterprise_list
-- ----------------------------
DROP TABLE IF EXISTS `hc_help_enterprise_list`;
CREATE TABLE `hc_help_enterprise_list`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `enterprise_id` int(11) NOT NULL COMMENT '扶持企业id',
  `enterprise_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '公司名称',
  `introducer` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '引进人姓名',
  `talent` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '人才姓名',
  `school` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '毕业院校和学历',
  `talent_info` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '人才基本信息',
  `enterprise_info` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '企业现状',
  `mark` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '备注',
  `paid_batch` int(2) NULL DEFAULT 0 COMMENT '已拨款批次',
  `all_money` decimal(20, 0) NULL DEFAULT 0 COMMENT '总扶持金额',
  `paid_money` decimal(20, 0) NULL DEFAULT 0 COMMENT '已拨付金额',
  `status` tinyint(1) NOT NULL DEFAULT 3 COMMENT '3=待拨付,1=拨付中,2=拨付完毕',
  `create_time` int(11) NOT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '扶持企业列表' ROW_FORMAT = Dynamic;

SET FOREIGN_KEY_CHECKS = 1;
