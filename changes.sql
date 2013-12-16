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

/*Table structure for table `imall_article_attr` */

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
