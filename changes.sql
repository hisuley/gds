/*
SQLyog v10.2 
MySQL - 5.5.34 : Database - gds
*********************************************************************
*/


/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`gds` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `gds`;

/* 创建新闻属性表 */

DROP TABLE IF EXISTS `imall_article_attr`;

CREATE TABLE `imall_article_attr` (
  `news_attr_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '新闻属性id 自增',
  `article_id` int(10) NOT NULL DEFAULT '0' COMMENT '新闻id',
  `attr_id` int(10) NOT NULL DEFAULT '0' COMMENT '属性id',
  `attr_values` text COMMENT '属性值',
  PRIMARY KEY (`news_attr_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
ALTER TABLE `gds`.`imall_attribute` ADD COLUMN `attr_type` TINYINT(1) DEFAULT 0 NOT NULL COMMENT '属性类型 0:商品,1:新闻' AFTER `price`; 

/* 创建品牌属性表 */
CREATE TABLE `imall_brand_attr` (
  `brand_attr_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '品牌属性ID',
  `brand_id` int(10) NOT NULL COMMENT '品牌ID',
  `attr_name` varchar(255) NOT NULL COMMENT '属性名称',
  `input_type` tinyint(1) NOT NULL COMMENT '属性input类型 0:text,1:select,2:radio,3:checkbox',
  `attr_values` text COMMENT '属性值 一行代表一个',
  `sort_order` tinyint(1) NOT NULL COMMENT '显示排序',
  `selectable` tinyint(1) DEFAULT NULL,
  `price` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`brand_attr_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8

/* 文章来源表 */
CREATE TABLE `imall_article_source` (
  `source_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '文章来源ID',
  `name` varchar(255) NOT NULL COMMENT '文章来源名称',
  PRIMARY KEY (`source_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8
 
/* 文章表增加文章来源字段 */
ALTER TABLE `gds`.`imall_article` ADD COLUMN `source_id` INT(10) DEFAULT 0 NOT NULL COMMENT '文章来源ID' AFTER `short_order`; 
/* 文章分类表增加图标字段 */
ALTER TABLE `gds`.`imall_article_cat` ADD COLUMN `cat_icon` CHAR(255) DEFAULT '' NOT NULL COMMENT '分类图标' AFTER `sort_order`;
/* 前台用户表增加用户现有资金字段 */
ALTER TABLE `gds`.`imall_users` ADD COLUMN `user_money` DECIMAL(10,2) DEFAULT 0.00 NOT NULL COMMENT '用户现有资金' AFTER `locked`; 
/* 现金账户表 */
CREATE TABLE `imall_user_account` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增ID号',
  `user_id` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '跟users表中的user_id对应',
  `admin_user` varchar(255) NOT NULL COMMENT '操作该笔交易的管理员的用户名',
  `amount` decimal(10,2) NOT NULL COMMENT '资金的数目，正数为增加，负数为减少',
  `add_time` datetime NOT NULL COMMENT '记录插入时间',
  `paid_time` datetime NOT NULL COMMENT '记录更新时间',
  `admin_note` varchar(255) NOT NULL COMMENT '管理员的备注',
  `user_note` varchar(255) NOT NULL COMMENT '用户备注',
  `process_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '操作类型:1退款,0预付费，其实就是充值,2用现金账户付款交易',
  `payment` varchar(90) NOT NULL COMMENT '支付渠道的名称,取自payment的pay_name字段',
  `is_paid` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否已经付款:0未付,1已付',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `is_paid` (`is_paid`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8
/* 文章表增加审核状态和审核备注字段 */
ALTER TABLE `gds`.`imall_article` ADD COLUMN `is_audit` TINYINT(1) DEFAULT 0 NOT NULL COMMENT '文章是否审核:0待审核,1初审通过,2初审不通过,3复审不通过,4复审通过' AFTER `source_id`, ADD COLUMN `audit_note` VARCHAR(255) DEFAULT '' NOT NULL COMMENT '文章审核不通过的备注' AFTER `is_audit`; 
/* 分销商表 */
CREATE TABLE `imall_distributor` (
  `distributor_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '分销商ID',
  `distributor_name` varchar(255) NOT NULL DEFAULT '' COMMENT '分销商名称',
  `distributor_intro` text NOT NULL COMMENT '分销商简介',
  `sort_order` int(10) NOT NULL DEFAULT '0' COMMENT '序号',
  PRIMARY KEY (`distributor_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8
/* 政策通知表 */
CREATE TABLE `imall_notification_policy` (
  `policy_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '政策通知ID',
  `policy_title` varchar(255) NOT NULL DEFAULT '' COMMENT '政策通知标题',
  `policy_content` text NOT NULL COMMENT '政策通知内容',
  `sort_order` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`policy_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8
/* 商品属性表更改价格类型 */
ALTER TABLE `gds`.`imall_goods_attr` CHANGE `price` `price` TEXT NULL;
/* 文章分类表增加SEO字段 */
ALTER TABLE `gds`.`imall_article_cat` ADD COLUMN `seo` VARCHAR(255) DEFAULT '' NOT NULL COMMENT '分类搜索引擎优化' AFTER `cat_icon`; 
/* 文章表增加草稿字段 */
ALTER TABLE `gds`.`imall_article` ADD COLUMN `is_draft` TINYINT(1) DEFAULT 1 NOT NULL COMMENT '1是草稿,0不是草稿' AFTER `audit_note`; 
/* 用户详情表增加备注字段 */
ALTER TABLE `gds`.`imall_user_info` ADD COLUMN `user_notes` TEXT NULL COMMENT '备注' AFTER `user_skype`; 
/* 会员等级表 */
CREATE TABLE `imall_user_level` (
  `level_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '会员等级ID',
  `level_name` varchar(200) NOT NULL COMMENT '名称',
  `level_created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `pointBegin` int(9) NOT NULL COMMENT '开始积分',
  `pointEnd` int(9) NOT NULL COMMENT '结束积分',
  `price_img` varchar(255) NOT NULL DEFAULT '' COMMENT '价格图片',
  `head_img` varchar(255) NOT NULL DEFAULT '' COMMENT '头像图片',
  PRIMARY KEY (`level_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8
/* 会员表增加等级ID字段 */
ALTER TABLE `gds`.`imall_users` ADD COLUMN `level_id` INT(10) DEFAULT 1 NOT NULL COMMENT '用户等级' AFTER `rank_id`; 
/* 政策通知增加供应商分类字段 */
ALTER TABLE `gds`.`imall_notification_policy` ADD COLUMN `shop_cat_id` INT(10) NOT NULL COMMENT '供应商分类ID' AFTER `sort_order`; 
/* 供应商分类表增加佣金比例字段 */
ALTER TABLE `gds`.`imall_shop_categories` ADD COLUMN `commission_ratio` VARCHAR(20) DEFAULT '' NOT NULL COMMENT '佣金比例' AFTER `shops_num`; 
/* 政策通知表增加供应商ID字段 */
ALTER TABLE `gds`.`imall_notification_policy` ADD COLUMN `user_id` INT(10) DEFAULT 0 NOT NULL COMMENT '供应商ID' AFTER `shop_cat_id`; 
/* 品牌表增加景区区域、类型、级别三个字段 */
ALTER TABLE `gds`.`imall_brand` ADD COLUMN `brand_type` VARCHAR(255) DEFAULT '' NOT NULL COMMENT '景区类型' AFTER `is_show`, ADD COLUMN `brand_rank` VARCHAR(255) DEFAULT '' NOT NULL COMMENT '景区级别' AFTER `brand_type`, ADD COLUMN `brand_area` VARCHAR(255) DEFAULT '' NULL COMMENT '景区区域' AFTER `brand_rank`; 


/* 文章表增加副标题和发表日期 */
ALTER TABLE `gds`.`imall_article` ADD COLUMN `sub_title` varchar(255) DEFAULT '' NOT NULL COMMENT '文章副标题' AFTER `title`;
ALTER TABLE `gds`.`imall_article` ADD COLUMN `post_date` varchar(255) DEFAULT '' NOT NULL COMMENT '文章发表日期' AFTER `sub_title`;