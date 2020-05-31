/*
Navicat MySQL Data Transfer

Source Server         : mysql 5.7
Source Server Version : 50725
Source Host           : localhost:3306
Source Database       : tutor

Target Server Type    : MYSQL
Target Server Version : 50725
File Encoding         : 65001

Date: 2020-05-31 11:19:22
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for account
-- ----------------------------
DROP TABLE IF EXISTS `account`;
CREATE TABLE `account` (
  `userId` varchar(255) NOT NULL COMMENT '用户编号',
  `userName` varchar(255) DEFAULT '' COMMENT '真实姓名',
  `email` varchar(255) NOT NULL COMMENT '邮箱地址',
  `password` varchar(255) DEFAULT NULL COMMENT '密码',
  `registerDate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP COMMENT '注册时间',
  `verifyCode` varchar(255) DEFAULT NULL COMMENT '验证码',
  `timeSpan` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT '有效时间',
  `token` varchar(255) DEFAULT NULL COMMENT '令牌',
  `nickName` varchar(255) DEFAULT NULL COMMENT '昵称',
  `birthDate` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT '出生日期',
  `location` varchar(255) DEFAULT NULL COMMENT '所在地点',
  `phone` varchar(255) CHARACTER SET utf16le DEFAULT NULL COMMENT '联系电话',
  `status` bit(1) DEFAULT NULL COMMENT '状态',
  `privilege` int(1) DEFAULT NULL COMMENT '0为普通用户，1位管理员，2为机构',
  `remark` varchar(255) DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`userId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of account
-- ----------------------------
INSERT INTO `account` VALUES ('1', 'Bob', '123@qq.com', '1234567', '2020-05-08 18:48:06', '503721', '2020-05-08 18:48:06', 'eacc6950066cb07058e4638e9cd9c861', '小明', '2020-05-08 18:48:06', null, '15489658752', '\0', '1', null);
INSERT INTO `account` VALUES ('2', '阿呆', '111@qq.com', '123456', '2020-05-08 18:47:57', null, '2020-05-08 18:47:57', 'ba43dcea5b6a85154fe82bb8e29ba9fd', '设置昵称', '2020-05-08 18:47:57', null, '16548574256', '\0', '0', null);
INSERT INTO `account` VALUES ('3', 'Rudy', '12433@qq.com', '12345678', '2020-05-31 11:19:03', '163055', '2020-05-31 11:19:03', '02bee0730ca645239ca7794511fcb672', '长安无故里', '2020-05-31 11:19:03', null, '12356585478', '', '2', null);

-- ----------------------------
-- Table structure for activity
-- ----------------------------
DROP TABLE IF EXISTS `activity`;
CREATE TABLE `activity` (
  `activityId` varchar(255) NOT NULL COMMENT '活动编号',
  `theme` varchar(255) DEFAULT NULL COMMENT '活动主题',
  `keywords` varchar(255) DEFAULT NULL COMMENT '关键字',
  `introduction` varchar(255) DEFAULT NULL COMMENT '活动简介',
  `relationUnit` varchar(255) DEFAULT NULL COMMENT '发布机构',
  `manager` varchar(255) DEFAULT NULL COMMENT '负责人',
  `publishDate` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT '发布时间',
  `startDate` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT '活动开始时间',
  `endDate` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT '活动结束时间',
  `hour` float DEFAULT NULL COMMENT '总工时',
  `score` float DEFAULT NULL COMMENT '活动学分',
  `location` varchar(255) DEFAULT NULL COMMENT '活动地点',
  `needNum` int(11) DEFAULT NULL COMMENT '预计人数',
  `actualNum` int(11) DEFAULT NULL COMMENT '参与人数',
  `status` bit(1) DEFAULT NULL COMMENT '活动状态',
  `remark` varchar(255) DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`activityId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of activity
-- ----------------------------
INSERT INTO `activity` VALUES ('1', '和谐支教', '学习', '某某中学是一个有着深厚文化底蕴的地方', '志愿机构', '某人', '2020-05-08 18:43:57', '2020-05-08 18:43:57', '2020-05-08 18:43:57', '3', '3', '北京市朝阳区', '10', '2', '', '备注');
INSERT INTO `activity` VALUES ('2', '爱心支教', '科学', '某某小学', '志愿协会', '某某', '2020-05-08 18:44:00', '2020-05-08 18:44:00', '2020-05-08 18:44:00', '2', '2', '上海市黄浦区', '12', '2', '', '备注');
INSERT INTO `activity` VALUES ('3', 'f222', '100', '随便写', '14141', '25', '2020-04-20 00:00:51', '2020-04-20 00:00:51', '2020-04-20 00:00:51', '3', '3', '010', '12', '2', '', null);
INSERT INTO `activity` VALUES ('4', '标题', '141', '123123', '及', '1231', '2020-04-20 00:20:42', '2020-04-03 00:00:00', '2020-04-10 00:00:00', '3', '3', '141', '10', '0', '', null);

-- ----------------------------
-- Table structure for apply
-- ----------------------------
DROP TABLE IF EXISTS `apply`;
CREATE TABLE `apply` (
  `applyId` varchar(255) NOT NULL DEFAULT '' COMMENT '申请编号',
  `userId` varchar(255) DEFAULT NULL COMMENT '申请人',
  `userName` varchar(255) DEFAULT NULL COMMENT '用户名',
  `activityId` varchar(255) DEFAULT NULL COMMENT '活动编号',
  `applyTime` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT '申请时间',
  `score` float DEFAULT NULL COMMENT '综合得分',
  `status` bit(1) DEFAULT NULL COMMENT '申请状态',
  `hour` float DEFAULT NULL COMMENT '执勤工时',
  `remark` varchar(255) DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`applyId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of apply
-- ----------------------------
INSERT INTO `apply` VALUES ('1', '1', 'Bob', '1', '2020-04-18 17:38:05', null, '', null, null);
INSERT INTO `apply` VALUES ('2', '1', 'Bob', '2', '2020-04-18 18:00:04', null, '\0', null, null);
INSERT INTO `apply` VALUES ('3', '3', '', '1', '2020-05-08 18:43:57', null, '', null, null);
INSERT INTO `apply` VALUES ('4', '3', '', '3', '2020-04-20 00:00:51', null, '', null, null);
INSERT INTO `apply` VALUES ('5', '3', '', '2', '2020-05-08 18:44:00', null, '', null, null);

-- ----------------------------
-- Table structure for comment
-- ----------------------------
DROP TABLE IF EXISTS `comment`;
CREATE TABLE `comment` (
  `commentId` varchar(255) NOT NULL COMMENT '评论编号',
  `activityId` varchar(255) DEFAULT NULL COMMENT '关联活动',
  `userId` varchar(255) DEFAULT NULL COMMENT '评论用户',
  `nickName` varchar(255) DEFAULT NULL COMMENT '用户昵称',
  `content` varchar(255) DEFAULT NULL COMMENT '内容',
  `time` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT '评论时间',
  `relationId` varchar(255) DEFAULT '' COMMENT '为0为主评',
  `status` bit(1) DEFAULT NULL COMMENT '状态（0为已删除）',
  `remark` varchar(255) DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`commentId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of comment
-- ----------------------------
INSERT INTO `comment` VALUES ('1', '1', '1', '小明', '这是一条评论的内容', '2020-04-16 20:04:57', '0', '', 'remark');
INSERT INTO `comment` VALUES ('2', '1', '1', '小明', '第二条评论', '2020-04-16 20:05:42', '0', '', 'continute');
INSERT INTO `comment` VALUES ('3', '1', '1', '小明', '还有一条评论', '2020-04-16 20:59:04', '0', '', null);
INSERT INTO `comment` VALUES ('4', '1', '1', '小明', '果然又是一条评论', '2020-04-16 21:07:20', '0', '', null);
INSERT INTO `comment` VALUES ('5', '1', '1', '小明', '最后一条评论', '2020-04-16 21:07:42', '0', '', null);
INSERT INTO `comment` VALUES ('6', '1', '3', '设置昵称', '123123', '2020-04-20 00:10:23', '0', '', null);

-- ----------------------------
-- Table structure for file
-- ----------------------------
DROP TABLE IF EXISTS `file`;
CREATE TABLE `file` (
  `fileId` varchar(255) NOT NULL COMMENT '文件编号',
  `fileName` varchar(255) DEFAULT NULL COMMENT '文件原名',
  `newName` varchar(255) DEFAULT NULL COMMENT '文件新名',
  `filePath` varchar(255) DEFAULT NULL COMMENT '文件路径',
  `fileSize` double DEFAULT NULL COMMENT '文件大小',
  `uploadTime` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT '文件上传时间',
  `relationId` varchar(255) DEFAULT NULL COMMENT '文件所属userId或unitId',
  `extension` varchar(255) DEFAULT NULL COMMENT '文件类型',
  `category` int(1) DEFAULT NULL COMMENT '0为unit注册，1为admin注册，2为活动',
  `status` bit(1) DEFAULT NULL COMMENT '状态',
  `remark` varchar(255) DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`fileId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of file
-- ----------------------------
INSERT INTO `file` VALUES ('1', 'null-6b52650502f090c3.jpg', '3null-6b52650502f090c3.jpg', 'D:/xampp/upload/3null-6b52650502f090c3.jpg', '52575', '2020-04-18 14:28:47', '3', 'jpg', null, '', null);
INSERT INTO `file` VALUES ('2', 'null500fcbc6aaf1b3a4.jpg', '5null500fcbc6aaf1b3a4.jpg', 'D:/xampp/upload/5null500fcbc6aaf1b3a4.jpg', '35530', '2020-04-18 14:36:05', '5', 'jpg', null, '', null);
INSERT INTO `file` VALUES ('3', 'null500fcbc6aaf1b3a4.jpg', '7null500fcbc6aaf1b3a4.jpg', 'D:/xampp/upload/7null500fcbc6aaf1b3a4.jpg', '35530', '2020-04-18 14:36:57', '7', 'jpg', null, '', null);
INSERT INTO `file` VALUES ('4', 'null500fcbc6aaf1b3a4.jpg', '9null500fcbc6aaf1b3a4.jpg', 'D:/xampp/upload/9null500fcbc6aaf1b3a4.jpg', '35530', '2020-04-18 14:38:00', '9', 'jpg', null, '', null);
INSERT INTO `file` VALUES ('5', 'null500fcbc6aaf1b3a4.jpg', '14null500fcbc6aaf1b3a4.jpg', 'D:/xampp/upload/14null500fcbc6aaf1b3a4.jpg', '35530', '2020-04-18 14:40:20', '14', 'jpg', null, '', null);
INSERT INTO `file` VALUES ('6', 'nulle05289a689662ed.jpg', '16nulle05289a689662ed.jpg', 'D:/xampp/upload/16nulle05289a689662ed.jpg', '4694', '2020-04-18 14:43:02', '16', 'jpg', null, '', null);
INSERT INTO `file` VALUES ('7', 'background-blade-blur-bokeh-352096.jpg', '7background-blade-blur-bokeh-352096.jpg', 'D:/xampp/htdocs/upload/7background-blade-blur-bokeh-352096.jpg', '2269549', '2020-04-20 00:15:27', '4', 'jpg', '0', '', null);
INSERT INTO `file` VALUES ('8', 'background-blade-blur-bokeh-352096.jpg', '8background-blade-blur-bokeh-352096.jpg', 'D:/xampp/htdocs/upload/8background-blade-blur-bokeh-352096.jpg', '2269549', '2020-04-20 00:16:08', '5', 'jpg', '1', '', null);

-- ----------------------------
-- Table structure for notice
-- ----------------------------
DROP TABLE IF EXISTS `notice`;
CREATE TABLE `notice` (
  `noticeId` varchar(255) DEFAULT NULL COMMENT '公告编号',
  `title` varchar(255) DEFAULT NULL COMMENT '标题',
  `content` varchar(255) DEFAULT NULL COMMENT '正文',
  `authorId` varchar(255) DEFAULT NULL COMMENT '发布者',
  `publishTime` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT '发布时间',
  `status` varchar(255) DEFAULT NULL COMMENT '状态',
  `remark` varchar(255) DEFAULT NULL COMMENT '备注'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of notice
-- ----------------------------
INSERT INTO `notice` VALUES ('1', '122', '13115111111111111111111111111111222222222222222222211111', '1', '2020-04-18 21:29:13', '1', null);
INSERT INTO `notice` VALUES ('2', '122', '131', '1', '2020-04-18 20:49:39', '1', null);
INSERT INTO `notice` VALUES ('3', '公告', '内容', '3', '2020-04-20 00:18:27', '1', null);

-- ----------------------------
-- Table structure for unit
-- ----------------------------
DROP TABLE IF EXISTS `unit`;
CREATE TABLE `unit` (
  `unitId` varchar(255) DEFAULT NULL COMMENT '机构编号',
  `unitName` varchar(255) DEFAULT NULL COMMENT '机构名称',
  `manager` varchar(255) DEFAULT NULL COMMENT '负责人',
  `category` varchar(255) DEFAULT NULL COMMENT '类别',
  `introduction` varchar(255) DEFAULT NULL COMMENT '简介',
  `buildDate` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT '创立时间',
  `address` varchar(255) DEFAULT NULL COMMENT '地址',
  `phone` varchar(255) DEFAULT NULL COMMENT '联系电话',
  `email` varchar(255) DEFAULT NULL COMMENT '联系邮箱',
  `status` bit(1) DEFAULT NULL COMMENT '状态',
  `remark` varchar(255) DEFAULT NULL COMMENT '备注'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of unit
-- ----------------------------
INSERT INTO `unit` VALUES ('1', '阿波罗', 'manager', '中心小学', 'a beautiful place', '2020-05-08 18:44:57', '江苏省南京市', '1235468799', '28797', '\0', '');
INSERT INTO `unit` VALUES ('2', '及', '1231', '1414', '41', '2020-05-08 18:45:01', '141', '123456', '123@123.com', '\0', null);
