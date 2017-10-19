/*
Navicat MySQL Data Transfer

Source Server         : 本地2
Source Server Version : 50540
Source Host           : localhost:3306
Source Database       : data

Target Server Type    : MYSQL
Target Server Version : 50540
File Encoding         : 65001

Date: 2017-06-01 17:52:13
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for temp_affix_tags
-- ----------------------------
DROP TABLE IF EXISTS `temp_affix_tags`;
CREATE TABLE `temp_affix_tags` (
  `id` int(11) unsigned NOT NULL,
  `name` varchar(64) NOT NULL COMMENT '标签名',
  `quantity` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '标签关联的数量(热度）',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of temp_affix_tags
-- ----------------------------

-- ----------------------------
-- Table structure for temp_affix_tagsarticle
-- ----------------------------
DROP TABLE IF EXISTS `temp_affix_tagsarticle`;
CREATE TABLE `temp_affix_tagsarticle` (
  `id` int(11) unsigned NOT NULL,
  `tagsid` int(11) unsigned NOT NULL COMMENT 'tagsid',
  `articleid` int(11) unsigned NOT NULL COMMENT '文章id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of temp_affix_tagsarticle
-- ----------------------------

-- ----------------------------
-- Table structure for temp_auction_banner
-- ----------------------------
DROP TABLE IF EXISTS `temp_auction_banner`;
CREATE TABLE `temp_auction_banner` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL COMMENT '标题',
  `url` varchar(256) NOT NULL COMMENT '链接',
  `imgurl` varchar(256) NOT NULL COMMENT '图片链接',
  `ordernum` int(5) NOT NULL COMMENT '排序',
  `status` enum('1','0') NOT NULL DEFAULT '1' COMMENT '1 表示正常 0表示下架',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='轮播表';

-- ----------------------------
-- Records of temp_auction_banner
-- ----------------------------
INSERT INTO `temp_auction_banner` VALUES ('1', 'fa23', '/', '/public/uploads/20170412/1491969083rmdfv.jpg', '50', '1');

-- ----------------------------
-- Table structure for temp_auction_bill
-- ----------------------------
DROP TABLE IF EXISTS `temp_auction_bill`;
CREATE TABLE `temp_auction_bill` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT COMMENT '账单表',
  `uid` int(11) unsigned NOT NULL COMMENT '用户ID',
  `tag` enum('2','1','0') NOT NULL DEFAULT '1' COMMENT '默认1 表示收入   0表示支出   2表示冻结',
  `number` int(12) unsigned NOT NULL COMMENT '变动积分额',
  `total` int(12) unsigned NOT NULL DEFAULT '0' COMMENT '变动后积分额',
  `logtime` int(11) unsigned NOT NULL COMMENT '变动时间',
  `remark` text NOT NULL COMMENT '变动备注',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='积分账单表';

-- ----------------------------
-- Records of temp_auction_bill
-- ----------------------------

-- ----------------------------
-- Table structure for temp_auction_cate
-- ----------------------------
DROP TABLE IF EXISTS `temp_auction_cate`;
CREATE TABLE `temp_auction_cate` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '商品分类ID',
  `name` varchar(64) NOT NULL COMMENT '商品分类名',
  `status` enum('1','0') NOT NULL DEFAULT '1' COMMENT '1 表示可用   0表示删除',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='商城分类表';

-- ----------------------------
-- Records of temp_auction_cate
-- ----------------------------
INSERT INTO `temp_auction_cate` VALUES ('1', '商品分类', '1');

-- ----------------------------
-- Table structure for temp_auction_convert
-- ----------------------------
DROP TABLE IF EXISTS `temp_auction_convert`;
CREATE TABLE `temp_auction_convert` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '兑换记录ID',
  `uid` int(11) unsigned NOT NULL COMMENT '用户ID',
  `goodid` int(11) unsigned NOT NULL COMMENT '用户兑换商品ID',
  `logtime` datetime NOT NULL COMMENT '用户兑换时间',
  `status` enum('2','1','0') NOT NULL DEFAULT '1' COMMENT '1 兑换中   2兑换完成',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='商品兑换表';

-- ----------------------------
-- Records of temp_auction_convert
-- ----------------------------

-- ----------------------------
-- Table structure for temp_auction_credit
-- ----------------------------
DROP TABLE IF EXISTS `temp_auction_credit`;
CREATE TABLE `temp_auction_credit` (
  `uid` int(11) unsigned NOT NULL COMMENT '用户ID',
  `credit` int(12) unsigned NOT NULL DEFAULT '0' COMMENT '用户积分额',
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户积分表';

-- ----------------------------
-- Records of temp_auction_credit
-- ----------------------------

-- ----------------------------
-- Table structure for temp_auction_good
-- ----------------------------
DROP TABLE IF EXISTS `temp_auction_good`;
CREATE TABLE `temp_auction_good` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '积分商品ID',
  `cover` varchar(256) NOT NULL COMMENT '商品封面照片',
  `imglist` mediumtext COMMENT '图片列表',
  `name` varchar(255) NOT NULL DEFAULT '错误的商品名，请及时更正' COMMENT '产品名称',
  `descr` mediumtext COMMENT '商品描述',
  `market` decimal(12,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '市场价格',
  `price` decimal(12,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '商品价格所需价格',
  `stock` int(5) unsigned NOT NULL DEFAULT '0' COMMENT '商品库存',
  `credit` int(12) unsigned NOT NULL DEFAULT '0' COMMENT '商品所需积分',
  `cateid` int(5) unsigned NOT NULL COMMENT '商品分类',
  `type` varchar(6) NOT NULL COMMENT '商品类型,   ',
  `status` enum('2','1','0') NOT NULL DEFAULT '1' COMMENT '1 表示正常   0表示已删除   2表示已下架',
  `logtime` datetime NOT NULL COMMENT '添加商品时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='积分商品表';

-- ----------------------------
-- Records of temp_auction_good
-- ----------------------------
INSERT INTO `temp_auction_good` VALUES ('1', '/public/uploads/20170413/149206622735e0u.png', null, '商品1', '商品描述', '1500.00', '1200.00', '100', '10000', '0', '1', '1', '2017-04-13 14:50:29');

-- ----------------------------
-- Table structure for temp_auction_type
-- ----------------------------
DROP TABLE IF EXISTS `temp_auction_type`;
CREATE TABLE `temp_auction_type` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '商品类型ID',
  `kno` varchar(8) NOT NULL COMMENT '商品类型标识',
  `name` varchar(32) NOT NULL COMMENT '商品类型',
  PRIMARY KEY (`id`),
  UNIQUE KEY `kno` (`kno`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='积分商城商品类型\r\n\r\n只能被添加，不能修改，删除\r\n\r\n\r\n抽奖\r\n0支付\r\n兑换码';

-- ----------------------------
-- Records of temp_auction_type
-- ----------------------------

-- ----------------------------
-- Table structure for temp_bbs_area
-- ----------------------------
DROP TABLE IF EXISTS `temp_bbs_area`;
CREATE TABLE `temp_bbs_area` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(128) NOT NULL,
  `ordernum` int(4) unsigned NOT NULL DEFAULT '50' COMMENT '默认排序',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='区块表';

-- ----------------------------
-- Records of temp_bbs_area
-- ----------------------------

-- ----------------------------
-- Table structure for temp_bbs_comment
-- ----------------------------
DROP TABLE IF EXISTS `temp_bbs_comment`;
CREATE TABLE `temp_bbs_comment` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `fid` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `author` varchar(128) NOT NULL,
  `authorid` int(11) unsigned NOT NULL,
  `content` text NOT NULL,
  `logtime` int(11) unsigned NOT NULL COMMENT '评论时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='评论表';

-- ----------------------------
-- Records of temp_bbs_comment
-- ----------------------------

-- ----------------------------
-- Table structure for temp_bbs_plate
-- ----------------------------
DROP TABLE IF EXISTS `temp_bbs_plate`;
CREATE TABLE `temp_bbs_plate` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(128) NOT NULL,
  `alias` varchar(128) DEFAULT NULL,
  `areaid` int(5) unsigned NOT NULL,
  `description` mediumtext,
  `ordernum` int(4) NOT NULL DEFAULT '50',
  `postednum` int(8) unsigned NOT NULL DEFAULT '0' COMMENT '发帖数量',
  `logtime` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='板块表';

-- ----------------------------
-- Records of temp_bbs_plate
-- ----------------------------

-- ----------------------------
-- Table structure for temp_bbs_posted
-- ----------------------------
DROP TABLE IF EXISTS `temp_bbs_posted`;
CREATE TABLE `temp_bbs_posted` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(128) NOT NULL,
  `author` varchar(128) NOT NULL,
  `authorid` int(11) unsigned NOT NULL,
  `content` text NOT NULL,
  `browsenum` int(8) unsigned NOT NULL DEFAULT '0' COMMENT '浏览量',
  `commentnum` int(8) unsigned NOT NULL DEFAULT '0' COMMENT '评论数量',
  `logtime` datetime NOT NULL COMMENT '发布时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='帖子表';

-- ----------------------------
-- Records of temp_bbs_posted
-- ----------------------------

-- ----------------------------
-- Table structure for temp_cms_article
-- ----------------------------
DROP TABLE IF EXISTS `temp_cms_article`;
CREATE TABLE `temp_cms_article` (
  `id` int(13) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(128) NOT NULL COMMENT '标题',
  `cateid` int(13) unsigned NOT NULL COMMENT '分类ID',
  `keyword` varchar(256) DEFAULT NULL COMMENT '关键字',
  `description` tinytext COMMENT '描述',
  `summary` tinytext COMMENT '摘要',
  `content` text,
  `authorid` int(13) unsigned DEFAULT NULL COMMENT '管理员ID',
  `author` varchar(255) DEFAULT NULL COMMENT '作者',
  `from` varchar(32) DEFAULT NULL COMMENT '来源',
  `cover` varchar(256) DEFAULT NULL COMMENT '封面',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '0 表示删除   1表示发布',
  `pv` int(11) unsigned NOT NULL DEFAULT '0',
  `logtime` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for temp_cms_banner
-- ----------------------------
DROP TABLE IF EXISTS `temp_cms_banner`;
CREATE TABLE `temp_cms_banner` (
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(32) NOT NULL,
  `description` varchar(128) DEFAULT NULL,
  `sn` varchar(4) NOT NULL DEFAULT '0' COMMENT '默认0 轮播',
  `ordernum` int(3) NOT NULL DEFAULT '50' COMMENT '排列序号',
  `url` varchar(256) NOT NULL,
  `imgsrc` varchar(256) NOT NULL,
  `status` enum('1','0') DEFAULT '1' COMMENT '轮播状态   1表示 正常，0表示删除',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='轮播图';

-- ----------------------------
-- Records of temp_cms_banner
-- ----------------------------
INSERT INTO `temp_cms_banner` VALUES ('1', '', null, '1', '50', '/news.html', '/public/asset/02.jpg', '1');

-- ----------------------------
-- Table structure for temp_cms_category
-- ----------------------------
DROP TABLE IF EXISTS `temp_cms_category`;
CREATE TABLE `temp_cms_category` (
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `fid` int(8) unsigned NOT NULL DEFAULT '0' COMMENT '上级分类ID',
  `title` varchar(64) NOT NULL COMMENT '分类名',
  `cover` varchar(256) NOT NULL DEFAULT '' COMMENT '封面图片地址',
  `keyword` varchar(256) NOT NULL DEFAULT '' COMMENT '关键字',
  `description` varchar(256) NOT NULL DEFAULT '' COMMENT '描述',
  `logtime` datetime NOT NULL,
  `status` enum('1','0') NOT NULL DEFAULT '1' COMMENT '分类状态  1表示正常   0 表示删除',
  `amount` int(8) unsigned NOT NULL DEFAULT '0',
  `content` text COMMENT '分类内容',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0 表示默认无内容显示列表， 1表示显示内容',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of temp_cms_category
-- ----------------------------
INSERT INTO `temp_cms_category` VALUES ('1', '0', '默认分类', '', '234234', '234234', '2016-11-24 14:01:15', '1', '1', '', '0');

-- ----------------------------
-- Table structure for temp_cms_content
-- ----------------------------
DROP TABLE IF EXISTS `temp_cms_content`;
CREATE TABLE `temp_cms_content` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `sn` varchar(32) NOT NULL COMMENT '唯一获取编号',
  `title` varchar(32) NOT NULL COMMENT '内容块标题',
  `content` text COMMENT '具体内容',
  `description` varchar(256) NOT NULL COMMENT '内容块描述',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '1表示正常  0表示删除',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of temp_cms_content
-- ----------------------------
INSERT INTO `temp_cms_content` VALUES ('1', '45', '企业文化', '<span style=\"color: rgb(105, 118, 134); font-family: \'Microsoft YaHei\', SimSun; font-size: 14px; line-height: 33px; white-space: normal;\">企业文化企业文化企业文化企业文化企业文化企业文化企业文化企业文化企业文化企业文化企业文化企业文化</span><br style=\"color: rgb(105, 118, 134); font-family: \'Microsoft YaHei\', SimSun; font-size: 14px; line-height: 33px; white-space: normal;\"><span style=\"color: rgb(105, 118, 134); font-family: \'Microsoft YaHei\', SimSun; font-size: 14px; line-height: 33px; white-space: normal;\">企业文化企业文化企业文化企业文化企业文化企业文化企业文化企业文化企业文化企业文化企业文化企业文化企业文化企业文化企业文化企业文化</span><br style=\"color: rgb(105, 118, 134); font-family: \'Microsoft YaHei\', SimSun; font-size: 14px; line-height: 33px; white-space: normal;\"><span style=\"color: rgb(105, 118, 134); font-family: \'Microsoft YaHei\', SimSun; font-size: 14px; line-height: 33px; white-space: normal;\">企业文化企业文化企业文化企业文化企业文化企业文化企业文化企业文化企业文化企业文化企业文化企业文化企业文化企业文化企业文化企业文化</span>', '企业文化企业文化企业文化企业文化企业文化企业文化企业文化企业文化企业文化企业文化企业文化企业文化\r\n企业文化企业文化企业文化企业文化企业文化企业文化企业文化企业文化企业文化企业文化企业文化企业文化企业文化企业文化企业文化企业文化\r\n企业文化企业文化企业文化企业文化企业文化企业文化企业文化企业文化企业文化企业文化企业文化企业文化企业文化企业文化企业文化企业文化', '1');
-- ----------------------------
-- Table structure for temp_cms_friendlylink
-- ----------------------------
DROP TABLE IF EXISTS `temp_cms_friendlylink`;
CREATE TABLE `temp_cms_friendlylink` (
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `sn` varchar(4) NOT NULL DEFAULT '0' COMMENT '0默认  ',
  `name` varchar(64) NOT NULL COMMENT '友链名称',
  `url` varchar(256) NOT NULL COMMENT '链接地址',
  `imglink` varchar(256) NOT NULL COMMENT '图片链接',
  `status` enum('1','0') DEFAULT '1' COMMENT '友链状态   0 表示 删除  1表示正常',
  `logtime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='友情链接表';

-- ----------------------------
-- Records of temp_cms_friendlylink
-- ----------------------------
INSERT INTO `temp_cms_friendlylink` VALUES ('1', '23', '23423', '2343', '4234', '1', '2017-03-02 15:23:52');

-- ----------------------------
-- Table structure for temp_cms_image
-- ----------------------------
DROP TABLE IF EXISTS `temp_cms_image`;
CREATE TABLE `temp_cms_image` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `sn` varchar(32) NOT NULL COMMENT '唯一获取编号',
  `title` varchar(32) NOT NULL COMMENT '内容块标题',
  `url` varchar(512) NOT NULL COMMENT '具体内容',
  `description` varchar(256) NOT NULL COMMENT '内容块描述',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '1表示正常  0表示删除',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of temp_cms_image
-- ----------------------------
INSERT INTO `temp_cms_image` VALUES ('1', '2', '插件', '/public/uploads/20170302/1488436187xjok9.jpg', '飞啊飞', '1');

-- ----------------------------
-- Table structure for temp_data
-- ----------------------------
DROP TABLE IF EXISTS `temp_data`;
CREATE TABLE `temp_data` (
  `id` int(13) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(128) NOT NULL COMMENT '标题',
  `cateid` int(13) unsigned NOT NULL COMMENT '分类ID',
  `keyword` varchar(256) DEFAULT NULL COMMENT '关键字',
  `description` tinytext COMMENT '描述',
  `summary` tinytext COMMENT '摘要',
  `content` text,
  `authorid` int(13) unsigned DEFAULT NULL COMMENT '管理员ID',
  `author` varchar(255) DEFAULT NULL COMMENT '作者',
  `from` varchar(32) DEFAULT NULL COMMENT '来源',
  `cover` varchar(256) DEFAULT NULL COMMENT '封面',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '0 表示删除   1表示发布',
  `pv` int(11) unsigned NOT NULL DEFAULT '0',
  `logtime` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of temp_data
-- ----------------------------
INSERT INTO `temp_data` VALUES ('1', '发文福娃额乏味啊', '1', '234', '243', '4234', '各个啊各位哥啊', '243', '432', '42', '', '1', '11', '0000-00-00 00:00:00');

-- ----------------------------
-- Table structure for temp_permission_node
-- ----------------------------
DROP TABLE IF EXISTS `temp_permission_node`;
CREATE TABLE `temp_permission_node` (
  `id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `nodename` varchar(24) NOT NULL COMMENT '结点名称',
  `pid` int(6) unsigned NOT NULL DEFAULT '0' COMMENT '父结点id ，0表示为顶级菜单',
  `nodeurl` varchar(256) NOT NULL COMMENT 'node链接的访问地址',
  `nodetype` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '结点的类型 1表示链接， 2表示操作',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '结点状态  1表示启用    2表示为启用',
  `datastatus` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '数据状态  1表示存在， 0表示删除',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of temp_permission_node
-- ----------------------------
INSERT INTO `temp_permission_node` VALUES ('1', '产品管理', '0', 'product', '1', '1', '1');
INSERT INTO `temp_permission_node` VALUES ('2', '用户管理', '0', 'users', '1', '1', '1');
INSERT INTO `temp_permission_node` VALUES ('3', '内容管理', '0', 'cms', '1', '1', '1');
INSERT INTO `temp_permission_node` VALUES ('4', '积分商城', '0', 'auction', '1', '1', '1');
INSERT INTO `temp_permission_node` VALUES ('5', '统计管理', '0', 'statistic', '1', '1', '1');
INSERT INTO `temp_permission_node` VALUES ('6', '系统管理', '0', 'systems', '1', '1', '1');
INSERT INTO `temp_permission_node` VALUES ('7', '权限管理', '0', 'permission', '1', '1', '1');
INSERT INTO `temp_permission_node` VALUES ('8', '数据生成模板', '0', 'scaffold', '1', '1', '1');
INSERT INTO `temp_permission_node` VALUES ('9', '产品列表', '1', 'b_product_index.html', '1', '1', '1');
INSERT INTO `temp_permission_node` VALUES ('10', '产品分类', '1', 'b_product_cates.html', '1', '1', '1');
INSERT INTO `temp_permission_node` VALUES ('11', '订单列表', '1', 'b_product_book.html', '1', '1', '1');
INSERT INTO `temp_permission_node` VALUES ('12', '用户列表', '2', 'b_users_index.html', '1', '1', '1');
INSERT INTO `temp_permission_node` VALUES ('13', '用户信息', '2', 'b_users_info.html', '1', '1', '1');
INSERT INTO `temp_permission_node` VALUES ('14', '文章列表', '3', 'b_cms_index.html', '1', '1', '1');
INSERT INTO `temp_permission_node` VALUES ('15', '文章分类', '3', 'b_cms_categorypage.html', '1', '1', '1');
INSERT INTO `temp_permission_node` VALUES ('16', '图片管理', '3', 'b_cms_imagespage.html', '1', '1', '1');
INSERT INTO `temp_permission_node` VALUES ('17', '内容片段', '3', 'b_cms_contentpage.html', '1', '1', '1');
INSERT INTO `temp_permission_node` VALUES ('18', '轮播', '3', 'b_cms_bannerpage.html', '1', '1', '1');
INSERT INTO `temp_permission_node` VALUES ('19', '友情链接', '3', 'b_cms_friendlinkpage.html', '1', '1', '1');
INSERT INTO `temp_permission_node` VALUES ('20', '积分商城主面板', '4', 'b_auction_index.html', '1', '1', '1');
INSERT INTO `temp_permission_node` VALUES ('21', '轮播管理', '4', 'b_auction_bannerspage.html', '1', '1', '1');
INSERT INTO `temp_permission_node` VALUES ('22', '兑换管理', '4', 'b_auction_convertPage.html', '1', '1', '1');
INSERT INTO `temp_permission_node` VALUES ('23', '商品管理', '4', 'b_auction_goodsPage.html', '1', '1', '1');
INSERT INTO `temp_permission_node` VALUES ('24', '商品分类管理', '4', 'b_auction_catesPage.html', '1', '1', '1');
INSERT INTO `temp_permission_node` VALUES ('25', '总体统计', '5', 'b_statistic_index.html', '1', '1', '1');
INSERT INTO `temp_permission_node` VALUES ('26', '用户统计', '5', 'b_statistic_user.html', '1', '1', '1');
INSERT INTO `temp_permission_node` VALUES ('27', '系统信息', '6', 'b_systems_index.html', '1', '1', '1');
INSERT INTO `temp_permission_node` VALUES ('28', '管理员列表', '6', 'b_systems_adminpage.html', '1', '1', '1');
INSERT INTO `temp_permission_node` VALUES ('29', '角色管理', '7', 'b_permission_rolesPage.html', '1', '1', '1');
INSERT INTO `temp_permission_node` VALUES ('30', '权限结点管理', '7', 'b_permission_nodesPage.html', '1', '1', '1');

-- ----------------------------
-- Table structure for temp_permission_role
-- ----------------------------
DROP TABLE IF EXISTS `temp_permission_role`;
CREATE TABLE `temp_permission_role` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `rolename` varchar(20) NOT NULL COMMENT '角色名称',
  `nodelist` varchar(1024) NOT NULL COMMENT '权限列表',
  `roletype` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '角色类型  1表示表示普通     8表示超级管理员',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '角色状态  1表示可用   0表示不可用',
  `datastatus` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '数据状态  1表示存在， 0 表示删除',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of temp_permission_role
-- ----------------------------
INSERT INTO `temp_permission_role` VALUES ('0', '超级管理员', '', '8', '1', '1');

-- ----------------------------
-- Table structure for temp_product_category
-- ----------------------------
DROP TABLE IF EXISTS `temp_product_category`;
CREATE TABLE `temp_product_category` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '产品分类ID',
  `title` varchar(64) NOT NULL COMMENT '分类名称',
  `fid` int(11) unsigned NOT NULL COMMENT '上级分类ID',
  `cover` varchar(255) DEFAULT NULL,
  `keyword` tinytext,
  `description` tinytext,
  `content` text,
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of temp_product_category
-- ----------------------------
INSERT INTO `temp_product_category` VALUES ('1', '默认分类', '0', '', null, '2r32r23', null, '1');

-- ----------------------------
-- Table structure for temp_product_items
-- ----------------------------
DROP TABLE IF EXISTS `temp_product_items`;
CREATE TABLE `temp_product_items` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL COMMENT '产品名称',
  `cateid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '产品分类',
  `keyword` tinytext,
  `description` tinytext,
  `cover` varchar(256) DEFAULT NULL,
  `content` text,
  `logtime` datetime DEFAULT NULL,
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '默认1 为使用中',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of temp_product_items
-- ----------------------------
INSERT INTO `temp_product_items` VALUES ('1', 'f23', '1', '2343', '432432', '432', '234', '2017-03-06 10:26:09', '1');

-- ----------------------------
-- Table structure for temp_system_admin
-- ----------------------------
DROP TABLE IF EXISTS `temp_system_admin`;
CREATE TABLE `temp_system_admin` (
  `id` int(13) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(32) NOT NULL COMMENT '管理员用户名',
  `password` varchar(128) NOT NULL COMMENT '用户密码',
  `salt` char(6) NOT NULL COMMENT '加密盐值',
  `nick` varchar(64) DEFAULT NULL,
  `mobile` varchar(11) DEFAULT NULL COMMENT '手机号',
  `email` varchar(32) DEFAULT NULL COMMENT '邮箱',
  `fullname` varchar(32) DEFAULT NULL COMMENT '姓名',
  `remark` varchar(128) DEFAULT NULL COMMENT '备注',
  `logtime` datetime NOT NULL,
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '0 1',
  `roleid` int(5) unsigned NOT NULL COMMENT '用户角色',
  `nodelist` varchar(1024) NOT NULL COMMENT '权限列表',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='系统管理员表';

-- ----------------------------
-- Records of temp_system_admin
-- ----------------------------
INSERT INTO `temp_system_admin` VALUES ('1', 'admin', '07ee91cb6446b289edb2164d199bbd4d', 'YoOq', 'admin', '23567687564', 'admin@admin.com', null, null, '0000-00-00 00:00:00', '0', '0', '');

-- ----------------------------
-- Table structure for temp_system_payment
-- ----------------------------
DROP TABLE IF EXISTS `temp_system_payment`;
CREATE TABLE `temp_system_payment` (
  `id` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(8) NOT NULL COMMENT '支付方式唯一标识',
  `name` varchar(32) NOT NULL COMMENT '支付名称',
  `logo` varchar(256) NOT NULL COMMENT '支付图标',
  `account` varchar(64) NOT NULL COMMENT '支付帐号',
  `password` varchar(128) NOT NULL COMMENT '支付密码',
  `salt` varchar(32) DEFAULT NULL COMMENT '加密字符   备用',
  `channel` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '使用渠道 1表示pc  2 表示移动端',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '0表示弃用   1表示可用  2表示暂时不可以',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='支付方式表';

-- ----------------------------
-- Records of temp_system_payment
-- ----------------------------

-- ----------------------------
-- Table structure for temp_system_servicer
-- ----------------------------
DROP TABLE IF EXISTS `temp_system_servicer`;
CREATE TABLE `temp_system_servicer` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL COMMENT '客服名称',
  `head` varchar(256) DEFAULT NULL COMMENT '头像',
  `qq` char(13) DEFAULT NULL,
  `code` varchar(512) DEFAULT NULL COMMENT '点击触发代码',
  `status` tinyint(1) unsigned NOT NULL COMMENT '客服状态',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='网站客服表';

-- ----------------------------
-- Records of temp_system_servicer
-- ----------------------------

-- ----------------------------
-- Table structure for temp_system_setting
-- ----------------------------
DROP TABLE IF EXISTS `temp_system_setting`;
CREATE TABLE `temp_system_setting` (
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `var` varchar(64) NOT NULL COMMENT '变量名',
  `val` varchar(512) NOT NULL COMMENT '变量名对应的值',
  `type` enum('user','main') NOT NULL DEFAULT 'main' COMMENT '变量分类',
  `remark` varchar(512) NOT NULL COMMENT '备注',
  PRIMARY KEY (`id`),
  UNIQUE KEY `var` (`var`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COMMENT='系统配置表';

-- ----------------------------
-- Records of temp_system_setting
-- ----------------------------
INSERT INTO `temp_system_setting` VALUES ('1', '网站名称', 'site_name', '深圳市索电医疗设备有限公司', 'main', '');
INSERT INTO `temp_system_setting` VALUES ('2', '网站logo', 'site_logo', '/public/asset/logo.jpg', 'main', '');
INSERT INTO `temp_system_setting` VALUES ('3', '网站关键字', 'site_keyword', '通用网站,飞年', 'main', '');
INSERT INTO `temp_system_setting` VALUES ('4', '描述', 'site_description', '做最通用的网站系统', 'main', '');
INSERT INTO `temp_system_setting` VALUES ('5', '网站状态', 'site_status', '1', 'main', '网站开启状态');
INSERT INTO `temp_system_setting` VALUES ('6', '备案号', 'site_beian', '粤ICP备14038***号', 'main', '');
INSERT INTO `temp_system_setting` VALUES ('7', 'email', 'site_email', 'szssdyl@163.com', 'main', '');
INSERT INTO `temp_system_setting` VALUES ('8', '电话', 'site_telphone', '0755-33027376', 'main', '');
INSERT INTO `temp_system_setting` VALUES ('9', '400电话', 'site_400', '400-234-2343', 'main', '');
INSERT INTO `temp_system_setting` VALUES ('10', '地址', 'site_address', '深圳市福田区福田街道深圳南路3037号', 'main', '');
INSERT INTO `temp_system_setting` VALUES ('11', '微博二维码', 'site_weibo', '', 'main', '');
INSERT INTO `temp_system_setting` VALUES ('12', '微信服务号', 'site_wechat1', '', 'main', '');
INSERT INTO `temp_system_setting` VALUES ('13', '微信订阅号', 'site_wechat2', '', 'main', '');
INSERT INTO `temp_system_setting` VALUES ('14', '手机号', 'site_mobile', '13786151972', 'main', '');
INSERT INTO `temp_system_setting` VALUES ('15', 'QQ号', 'site_qq', '3406053536', 'main', '');
INSERT INTO `temp_system_setting` VALUES ('16', '网址', 'site_url', 'www.feinian.com.cn', 'main', '');

-- ----------------------------
-- Table structure for temp_users
-- ----------------------------
DROP TABLE IF EXISTS `temp_users`;
CREATE TABLE `temp_users` (
  `id` int(13) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(32) NOT NULL COMMENT '用户名',
  `password` varchar(64) NOT NULL COMMENT '密码',
  `salt` varchar(6) NOT NULL COMMENT '加密盐值',
  `mobile` varchar(11) NOT NULL COMMENT '手机号',
  `email` varchar(32) NOT NULL COMMENT '邮箱地址',
  `head` varchar(256) DEFAULT NULL COMMENT '头像',
  `fullname` varchar(16) NOT NULL COMMENT '真实姓名',
  `idcard` varchar(18) NOT NULL COMMENT '身份证号',
  `status` enum('2','1','0') NOT NULL DEFAULT '1' COMMENT '用户状态',
  `regip` varchar(32) NOT NULL COMMENT '注册地址',
  `regtime` datetime NOT NULL COMMENT '注册时间',
  `logip` varchar(32) NOT NULL COMMENT '最近登录IP',
  `logtime` datetime NOT NULL COMMENT '最近登录时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='用户基本信息,用户登录';

-- ----------------------------
-- Table structure for temp_user_friend
-- ----------------------------
DROP TABLE IF EXISTS `temp_user_friend`;
CREATE TABLE `temp_user_friend` (
  `id` int(13) unsigned NOT NULL AUTO_INCREMENT,
  `userid` int(13) unsigned NOT NULL COMMENT '用户ID',
  `friendid` int(13) unsigned NOT NULL COMMENT '推荐其注册的好友ID',
  `logtime` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of temp_user_friend
-- ----------------------------

-- ----------------------------
-- Table structure for temp_user_fund
-- ----------------------------
DROP TABLE IF EXISTS `temp_user_fund`;
CREATE TABLE `temp_user_fund` (
  `id` int(13) unsigned NOT NULL COMMENT '同user_basic ID',
  `usable` decimal(14,2) unsigned NOT NULL COMMENT '可用金额',
  `frozen` decimal(14,2) unsigned NOT NULL COMMENT '冻结金额',
  `amount` decimal(14,2) unsigned NOT NULL COMMENT '总额',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户资金表';

-- ----------------------------
-- Records of temp_user_fund
-- ----------------------------

-- ----------------------------
-- Table structure for temp_user_loginlog
-- ----------------------------
DROP TABLE IF EXISTS `temp_user_loginlog`;
CREATE TABLE `temp_user_loginlog` (
  `id` int(13) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户登录记录表',
  `userid` int(13) unsigned NOT NULL COMMENT '用户ID',
  `logtime` datetime NOT NULL,
  `logip` varchar(20) NOT NULL COMMENT '登录IP',
  `useragent` varchar(128) NOT NULL COMMENT '登录通道',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户登录记录表';

-- ----------------------------
-- Records of temp_user_loginlog
-- ----------------------------

-- ----------------------------
-- Table structure for temp_user_message
-- ----------------------------
DROP TABLE IF EXISTS `temp_user_message`;
CREATE TABLE `temp_user_message` (
  `id` int(13) unsigned NOT NULL AUTO_INCREMENT,
  `userid` int(13) unsigned NOT NULL,
  `fromid` int(13) unsigned NOT NULL COMMENT '消息来源用户ID',
  `type` enum('user','sys') NOT NULL DEFAULT 'sys' COMMENT '消息类型',
  `status` enum('0','1') DEFAULT '1' COMMENT '消息状态  0 为已读   1为未读',
  `logtime` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='站内信表';

-- ----------------------------
-- Records of temp_user_message
-- ----------------------------
