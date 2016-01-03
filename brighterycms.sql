/*
SQLyog Ultimate v11.5 (64 bit)
MySQL - 5.6.17 : Database - brighterycms
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `blog_categories` */

DROP TABLE IF EXISTS `blog_categories`;

CREATE TABLE `blog_categories` (
  `blog_category_id` int(11) NOT NULL AUTO_INCREMENT,
  `language_id` varchar(3) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `seo` varchar(100) DEFAULT NULL,
  `parent` int(11) DEFAULT '0',
  `image` text,
  `description` text,
  `sort` int(11) DEFAULT '0',
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`blog_category_id`),
  UNIQUE KEY `seo` (`seo`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

/*Data for the table `blog_categories` */

insert  into `blog_categories`(`blog_category_id`,`language_id`,`title`,`seo`,`parent`,`image`,`description`,`sort`,`created`) values (1,'en','title222',NULL,0,NULL,'www',0,NULL),(2,'en','Cat2',NULL,1,NULL,'rrrrrr',0,NULL),(3,'en','Cat3',NULL,0,NULL,NULL,NULL,NULL),(4,'en','Cat4',NULL,0,NULL,NULL,NULL,NULL),(5,'en','Cat5',NULL,0,NULL,NULL,0,NULL),(6,'en','ddd',NULL,0,NULL,'',0,NULL),(7,'ar','ddd',NULL,0,NULL,'11\r\n',1,NULL);

/*Table structure for table `blog_keywords` */

DROP TABLE IF EXISTS `blog_keywords`;

CREATE TABLE `blog_keywords` (
  `blog_keyword_id` int(11) NOT NULL AUTO_INCREMENT,
  `language_id` varchar(3) DEFAULT NULL,
  `blog_post_id` int(11) DEFAULT NULL,
  `keyword_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`blog_keyword_id`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8;

/*Data for the table `blog_keywords` */

insert  into `blog_keywords`(`blog_keyword_id`,`language_id`,`blog_post_id`,`keyword_id`) values (1,NULL,2,1),(2,NULL,2,2),(3,NULL,2,3),(4,NULL,3,4),(5,NULL,3,5),(23,NULL,7,2),(24,NULL,7,17),(25,NULL,7,18),(26,NULL,7,10),(38,NULL,0,28),(39,NULL,0,29);

/*Table structure for table `blog_post_comments` */

DROP TABLE IF EXISTS `blog_post_comments`;

CREATE TABLE `blog_post_comments` (
  `blog_post_comment_id` int(11) NOT NULL AUTO_INCREMENT,
  `blog_post_id` int(11) DEFAULT NULL,
  `name` varchar(300) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `datetime` datetime DEFAULT NULL,
  `comment` text,
  `email` varchar(300) DEFAULT NULL,
  PRIMARY KEY (`blog_post_comment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `blog_post_comments` */

/*Table structure for table `blog_post_tags` */

DROP TABLE IF EXISTS `blog_post_tags`;

CREATE TABLE `blog_post_tags` (
  `blog_tag_id` int(11) NOT NULL AUTO_INCREMENT,
  `blog_post_id` int(11) DEFAULT NULL,
  `tag_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`blog_tag_id`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8;

/*Data for the table `blog_post_tags` */

insert  into `blog_post_tags`(`blog_tag_id`,`blog_post_id`,`tag_id`) values (13,1,1),(14,1,2),(15,1,3),(16,1,6),(17,1,17),(18,2,14),(19,2,18),(20,3,19),(34,7,23),(35,7,26),(36,7,14),(47,0,35),(48,0,36),(49,0,37);

/*Table structure for table `blog_posts` */

DROP TABLE IF EXISTS `blog_posts`;

CREATE TABLE `blog_posts` (
  `blog_post_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `blog_category_id` int(11) DEFAULT NULL,
  `language_id` varchar(3) DEFAULT NULL,
  `title` varchar(300) DEFAULT NULL,
  `seo` varchar(200) DEFAULT NULL,
  `image` text,
  `short_content` text,
  `content` longtext,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`blog_post_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

/*Data for the table `blog_posts` */

insert  into `blog_posts`(`blog_post_id`,`user_id`,`blog_category_id`,`language_id`,`title`,`seo`,`image`,`short_content`,`content`,`created`) values (1,1,1,NULL,NULL,NULL,NULL,NULL,NULL,'2014-06-03 17:23:45'),(3,1,2,NULL,NULL,NULL,NULL,NULL,NULL,'2014-06-02 16:22:07'),(4,1,4,NULL,NULL,NULL,NULL,NULL,NULL,'2014-06-19 22:10:48'),(5,1,3,NULL,NULL,NULL,NULL,NULL,NULL,'2014-06-23 21:25:47'),(6,1,3,NULL,NULL,NULL,NULL,NULL,NULL,'2014-06-24 01:50:22'),(7,1,3,NULL,NULL,NULL,NULL,NULL,NULL,'2014-06-24 23:08:42'),(8,1,1,NULL,NULL,NULL,NULL,NULL,NULL,'2014-06-25 00:47:36'),(9,1,3,NULL,NULL,NULL,NULL,NULL,NULL,'2014-06-25 22:46:22'),(10,1,3,NULL,NULL,NULL,NULL,NULL,NULL,'2014-07-15 13:34:25'),(11,1,3,NULL,NULL,NULL,NULL,NULL,NULL,'2014-07-26 14:05:47'),(12,1,1,NULL,NULL,NULL,NULL,NULL,NULL,'2014-08-23 08:05:36');

/*Table structure for table `brightery_invoices` */

DROP TABLE IF EXISTS `brightery_invoices`;

CREATE TABLE `brightery_invoices` (
  `brightery_invoice_id` int(11) NOT NULL AUTO_INCREMENT,
  `brightery_license_id` int(11) DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `status` enum('due','paid','canceled') DEFAULT 'due',
  PRIMARY KEY (`brightery_invoice_id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

/*Data for the table `brightery_invoices` */

insert  into `brightery_invoices`(`brightery_invoice_id`,`brightery_license_id`,`due_date`,`status`) values (1,117,'2015-07-29','paid'),(2,117,'2015-07-28','canceled'),(3,117,'2015-07-08','canceled'),(4,119,'2013-08-20','due'),(5,117,'2015-08-28','canceled'),(6,117,'2015-08-29','due'),(7,119,'2015-08-20','due'),(10,117,'2015-08-29','due'),(9,227,'2015-08-29','due'),(11,117,'2015-08-29','due'),(12,117,'2015-08-29','due');

/*Table structure for table `brightery_licenses` */

DROP TABLE IF EXISTS `brightery_licenses`;

CREATE TABLE `brightery_licenses` (
  `brightery_license_id` int(10) NOT NULL AUTO_INCREMENT,
  `license_code` varchar(50) NOT NULL,
  `brightery_product_id` int(10) NOT NULL,
  `domain` varchar(50) NOT NULL,
  `data` text NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `payment_type` enum('fixed','subscription','FREE') DEFAULT NULL,
  `brightery_products_subscription_id` int(11) DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT NULL,
  PRIMARY KEY (`brightery_license_id`)
) ENGINE=InnoDB AUTO_INCREMENT=228 DEFAULT CHARSET=utf8;

/*Data for the table `brightery_licenses` */

insert  into `brightery_licenses`(`brightery_license_id`,`license_code`,`brightery_product_id`,`domain`,`data`,`user_id`,`payment_type`,`brightery_products_subscription_id`,`status`) values (117,'abc',84,'12','',2,'subscription',5,NULL),(118,'abc',83,'12','',2,'fixed',NULL,NULL),(119,'abc',83,'12','',2,'fixed',3,NULL),(120,'jjiji',83,'jji','',2,'fixed',NULL,NULL),(121,'jjiji',83,'jji','',2,'fixed',NULL,NULL),(122,'jjiji',83,'jji','',2,'fixed',NULL,NULL),(123,'ddwdw',83,'wdw','',2,'fixed',NULL,NULL),(124,'ddwdw',83,'wdw','',2,'fixed',NULL,NULL),(125,'ddwdw',83,'wdw','',2,'fixed',NULL,NULL),(126,'dada',83,'adad','',2,'fixed',NULL,NULL),(127,'dada',83,'adad','',2,'fixed',NULL,NULL),(128,'dada',83,'adad','',2,'fixed',NULL,NULL),(129,'dwdw',83,'wddw','',2,'fixed',NULL,NULL),(130,'dwdw',83,'wddw','',2,'fixed',NULL,NULL),(131,'dwdw',83,'wddw','',2,'fixed',NULL,NULL),(132,'dwdw',83,'wddw','',2,'fixed',NULL,NULL),(133,'dwdw',83,'wddw','',2,'fixed',NULL,NULL),(134,'dwdw',83,'wddw','',2,'fixed',NULL,NULL),(135,'dwdw',83,'wddw','',2,'fixed',NULL,NULL),(136,'wdwd',83,'wdwd','',2,'fixed',NULL,NULL),(137,'wdwd',83,'wdwd','',2,'fixed',NULL,NULL),(138,'wdwd',83,'wdwd','',2,'fixed',NULL,NULL),(139,'wdwd',83,'wdwd','',2,'fixed',NULL,NULL),(140,'wdwd',83,'wdwd','',2,'fixed',NULL,NULL),(141,'wdwd',83,'wdwd','',2,'fixed',NULL,NULL),(142,'wdwd',83,'wdwd','',2,'fixed',NULL,NULL),(143,'wdwd',83,'wdwd','',2,'fixed',NULL,NULL),(144,'wdwd',83,'wdwd','',2,'fixed',NULL,NULL),(145,'wdwd',83,'wdwd','',2,'fixed',NULL,NULL),(146,'wdwd',83,'wdwd','',2,'fixed',NULL,NULL),(147,'wdwd',83,'wdwd','',2,'fixed',NULL,NULL),(148,'wdwd',83,'wdwd','',2,'fixed',NULL,NULL),(149,'wdwd',83,'wdwd','',2,'fixed',NULL,NULL),(150,'wdwd',83,'wdwd','',2,'fixed',NULL,NULL),(151,'wdwd',83,'wdwd','',2,'fixed',NULL,NULL),(152,'wdwd',83,'wdwd','',2,'fixed',NULL,NULL),(153,'wdwd',83,'wdwd','',2,'fixed',NULL,NULL),(154,'wdwd',83,'wdwd','',2,'fixed',NULL,NULL),(155,'wdwd',83,'wdwd','',2,'fixed',NULL,NULL),(156,'wdwd',83,'wdwd','',2,'fixed',NULL,NULL),(157,'wdwd',83,'wdwd','',2,'fixed',NULL,NULL),(158,'wdwd',83,'wdwd','',2,'fixed',NULL,NULL),(159,'wdwd',83,'wdwd','',2,'fixed',NULL,NULL),(160,'wdwd',83,'wdwd','',2,'fixed',NULL,NULL),(161,'wdwd',83,'wdwd','',2,'fixed',NULL,NULL),(162,'wdwd',83,'wdwd','',2,'fixed',NULL,NULL),(163,'wdwd',83,'wdwd','',2,'fixed',NULL,NULL),(164,'wdwd',83,'wdwd','',2,'fixed',NULL,NULL),(165,'wdwd',83,'wdwd','',2,'fixed',NULL,NULL),(166,'wdwd',83,'wdwd','',2,'fixed',NULL,NULL),(167,'wdwd',83,'wdwd','',2,'fixed',NULL,NULL),(168,'wdwd',83,'wdwd','',2,'fixed',NULL,NULL),(169,'wdwd',83,'wdwd','',2,'fixed',NULL,NULL),(170,'wdwd',83,'wdwd','',2,'fixed',NULL,NULL),(171,'wdwd',83,'wdwd','',2,'fixed',NULL,NULL),(172,'wdwd',83,'wdwd','',2,'fixed',NULL,NULL),(173,'wdwd',83,'wdwd','',2,'fixed',NULL,NULL),(174,'wdwd',83,'wdwd','',2,'fixed',NULL,NULL),(175,'wdwd',83,'wdwd','',2,'fixed',NULL,NULL),(176,'wdwd',83,'wdwd','',2,'fixed',NULL,NULL),(177,'wdwd',83,'wdwd','',2,'fixed',NULL,NULL),(178,'wdwd',83,'wdwd','',2,'fixed',NULL,NULL),(179,'wdwd',83,'wdwd','',2,'fixed',NULL,NULL),(180,'wdwd',83,'wdwd','',2,'fixed',NULL,NULL),(181,'wdwd',83,'wdwd','',2,'fixed',NULL,NULL),(182,'wdwd',83,'wdwd','',2,'fixed',NULL,NULL),(183,'wdwd',83,'wdwd','',2,'fixed',NULL,NULL),(184,'wdwd',83,'wdwd','',2,'fixed',NULL,NULL),(185,'wdwd',83,'wdwd','',2,'fixed',NULL,NULL),(186,'wdwd',83,'wdwd','',2,'fixed',NULL,NULL),(187,'wdwd',83,'wdwd','',2,'fixed',NULL,NULL),(188,'wdwd',83,'wdwd','',2,'fixed',NULL,NULL),(189,'wdwd',83,'wdwd','',2,'fixed',NULL,NULL),(190,'wdwd',83,'wdwd','',2,'fixed',NULL,NULL),(191,'wdwd',83,'wdwd','',2,'fixed',NULL,NULL),(192,'wdwd',83,'wdwd','',2,'fixed',NULL,NULL),(193,'wdwd',83,'wdwd','',2,'fixed',NULL,NULL),(194,'sfs',83,'fssf','',2,'fixed',NULL,NULL),(195,'sfs',83,'fssf','',2,'fixed',NULL,NULL),(196,'sfs',83,'fssf','',2,'fixed',NULL,NULL),(197,'xrxr',83,'qsqsqs','',2,'fixed',NULL,NULL),(198,'xrxr',83,'qsqsqs','',2,'fixed',NULL,NULL),(199,'xrxr',83,'qsqsqs','',2,'fixed',NULL,NULL),(200,'xrxr',83,'qsqsqs','',2,'fixed',NULL,NULL),(201,'xrxr',83,'qsqsqs','',2,'fixed',NULL,NULL),(202,'xrxr',83,'qsqsqs','',2,'fixed',NULL,NULL),(203,'xrxr',83,'qsqsqs','',2,'fixed',NULL,NULL),(204,'xrxr',83,'qsqsqs','',2,'fixed',NULL,NULL),(205,'xrxr',83,'qsqsqs','',2,'fixed',NULL,NULL),(206,'xrxr',83,'qsqsqs','',2,'fixed',NULL,NULL),(207,'xrxr',83,'qsqsqs','',2,'fixed',NULL,NULL),(208,'xrxr',83,'qsqsqs','',2,'fixed',NULL,NULL),(209,'xrxr',83,'qsqsqs','',2,'fixed',NULL,NULL),(210,'xrxr',83,'qsqsqs','',2,'fixed',NULL,NULL),(211,'xrxr',83,'qsqsqs','',2,'fixed',NULL,NULL),(212,'xrxr',83,'qsqsqs','',2,'fixed',NULL,NULL),(213,'xrxr',83,'qsqsqs','',2,'fixed',NULL,NULL),(214,'xrxr',83,'qsqsqs','',2,'fixed',NULL,NULL),(215,'yyyyyyyy',83,'yyyyyyy','',2,'fixed',NULL,NULL),(216,'yousef',83,'1235666','',2,'fixed',NULL,NULL),(217,'farah',83,'123456','',2,'fixed',NULL,NULL),(218,'farah',83,'123456','',2,'fixed',NULL,NULL),(219,'bbbbbbbbbbb',83,'bbbbbbbbbbbb','',2,'fixed',NULL,NULL),(220,'',0,'','',NULL,NULL,NULL,NULL),(221,'wsws',90,'121','',2,'subscription',NULL,NULL),(222,'يص',84,'صيصي','',2,'subscription',NULL,NULL),(223,'gg7g7',84,'1848','',2,'subscription',NULL,NULL),(224,'tf6f',84,'474','',2,'subscription',NULL,NULL),(225,'tf6f',84,'474','',2,'subscription',NULL,NULL),(226,'wsws',84,'wsws','',2,'subscription',NULL,NULL),(227,'yfyfy',84,'gygy','',2,'subscription',NULL,NULL);

/*Table structure for table `brightery_products` */

DROP TABLE IF EXISTS `brightery_products`;

CREATE TABLE `brightery_products` (
  `brightery_product_id` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `fixed_price_status` tinyint(4) DEFAULT NULL,
  `fixed_price` double DEFAULT NULL,
  `subscription_price_status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`brightery_product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=98 DEFAULT CHARSET=utf8;

/*Data for the table `brightery_products` */

insert  into `brightery_products`(`brightery_product_id`,`title`,`fixed_price_status`,`fixed_price`,`subscription_price_status`) values (83,'m',1,2,1),(84,'chipsy',0,0,1),(85,'mo',1,19,0),(86,'mo',1,19,0),(87,'molto',1,19,0),(88,'molto',1,19,0),(89,'molto',1,19,0),(90,'jolt',1,19,0),(91,'cranchy',1,100,0),(92,'mo',1,19,0),(93,'mnmnmnmnmnm',1,19,0),(94,'yousef',0,0,1),(95,'543',1,111,1),(96,'5555',0,0,1),(97,'mk ',0,0,1);

/*Table structure for table `brightery_products_subscriptions` */

DROP TABLE IF EXISTS `brightery_products_subscriptions`;

CREATE TABLE `brightery_products_subscriptions` (
  `brightery_products_subscription_id` int(11) NOT NULL AUTO_INCREMENT,
  `brightery_product_id` int(11) NOT NULL,
  `period_cycle` varchar(10) NOT NULL,
  `period` int(11) NOT NULL,
  `price` double NOT NULL,
  PRIMARY KEY (`brightery_products_subscription_id`)
) ENGINE=InnoDB AUTO_INCREMENT=80 DEFAULT CHARSET=utf8;

/*Data for the table `brightery_products_subscriptions` */

insert  into `brightery_products_subscriptions`(`brightery_products_subscription_id`,`brightery_product_id`,`period_cycle`,`period`,`price`) values (3,0,'Year',2,1),(5,84,'Month',1,50),(71,84,'Day',2,2525),(72,95,'Day',1,0),(73,95,'Day',3,0),(74,95,'Day',7,0),(75,96,'Day',4,5),(76,96,'Day',2,0),(77,96,'Day',5,0),(78,97,'Day',5,0),(79,97,'Day',5,0);

/*Table structure for table `chat_conversation_messages` */

DROP TABLE IF EXISTS `chat_conversation_messages`;

CREATE TABLE `chat_conversation_messages` (
  `chat_conversation_message_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `chat_conversation_id` int(11) NOT NULL,
  `microtime` decimal(16,4) NOT NULL,
  `message` text NOT NULL,
  `status` enum('SENT','DELIVERED','SEEN') NOT NULL,
  `seen_time` datetime NOT NULL,
  PRIMARY KEY (`chat_conversation_message_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `chat_conversation_messages` */

insert  into `chat_conversation_messages`(`chat_conversation_message_id`,`user_id`,`chat_conversation_id`,`microtime`,`message`,`status`,`seen_time`) values (1,1,1,'1.0000','Hello','SENT','0000-00-00 00:00:00'),(2,1,1,'1.0000','World','SENT','0000-00-00 00:00:00'),(3,2,1,'2.0000','Yeah !','SENT','0000-00-00 00:00:00'),(4,2,1,'2.0000','You are right','SENT','0000-00-00 00:00:00');

/*Table structure for table `chat_conversation_users` */

DROP TABLE IF EXISTS `chat_conversation_users`;

CREATE TABLE `chat_conversation_users` (
  `chat_conversation_user_id` int(11) NOT NULL AUTO_INCREMENT,
  `chat_conversation_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` enum('OPENED','CLOSED') NOT NULL,
  `last_update_time` decimal(16,4) DEFAULT NULL,
  PRIMARY KEY (`chat_conversation_user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

/*Data for the table `chat_conversation_users` */

insert  into `chat_conversation_users`(`chat_conversation_user_id`,`chat_conversation_id`,`user_id`,`status`,`last_update_time`) values (1,1,1,'OPENED','1444470884.9030'),(2,1,2,'CLOSED','0.0000'),(3,2,1,'OPENED','1444470880.2373'),(4,2,3,'OPENED','0.0000'),(12,10,1,'OPENED','1444471728.3492'),(13,10,5,'OPENED','0.0000'),(14,11,1,'OPENED','1444470886.9397'),(15,11,28,'OPENED','1444470769.9124'),(16,12,30,'OPENED','1444484445.2755'),(17,12,1,'OPENED','1444484445.3090'),(18,13,30,'OPENED','1444731297.5247'),(19,13,2,'OPENED','1444731297.5691');

/*Table structure for table `chat_conversations` */

DROP TABLE IF EXISTS `chat_conversations`;

CREATE TABLE `chat_conversations` (
  `chat_conversation_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`chat_conversation_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

/*Data for the table `chat_conversations` */

insert  into `chat_conversations`(`chat_conversation_id`) values (1),(2),(3),(10),(11),(12),(13);

/*Table structure for table `classfied_areas` */

DROP TABLE IF EXISTS `classfied_areas`;

CREATE TABLE `classfied_areas` (
  `classfied_area_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `classfied_city_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`classfied_area_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

/*Data for the table `classfied_areas` */

insert  into `classfied_areas`(`classfied_area_id`,`name`,`classfied_city_id`) values (5,'محمد المفتري',1),(6,'مروة المفتييييييييييي',1),(7,'mohammad',93);

/*Table structure for table `classfied_categories` */

DROP TABLE IF EXISTS `classfied_categories`;

CREATE TABLE `classfied_categories` (
  `classfied_category_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `var_name` varchar(32) NOT NULL,
  `title` text NOT NULL,
  `description` text NOT NULL,
  `keywords` text NOT NULL,
  `category_order` int(11) NOT NULL,
  `icon` text,
  PRIMARY KEY (`classfied_category_id`),
  KEY `category_order` (`category_order`)
) ENGINE=MyISAM AUTO_INCREMENT=54 DEFAULT CHARSET=utf8 COMMENT='programming/design/admin/etc.';

/*Data for the table `classfied_categories` */

insert  into `classfied_categories`(`classfied_category_id`,`name`,`var_name`,`title`,`description`,`keywords`,`category_order`,`icon`) values (1,'فنيون','Technicians_jobs','فنيون | وظائف . كوم | وظائف خالية | وظائف اليوم | فرص عمل |وظائف شاغرة','مطلوب فنيون فى جميع التخصصات للسفر للخليج والعمل فى أكبر الشركات العالمية | فنيون | وظائف . كوم','مطلوب فنيون فى جميع التخصصات للسفر للخليج والعمل فى أكبر الشركات العالمية | فنيون | وظائف . كوم',8,'other.png'),(2,'تدريس','Teaching_jobs','وظائف مدرسين | وظائف . كوم | وظائف خالية | وظائف اليوم | فرص عمل |وظائف شاغرة','للعمل فى أفضل المدارس الخاصة وأعطاء الدروس الخاصة والعمل فى مجال التدريس فى الخليج | وظائف مدرسين | وظائف . كوم','للعمل فى أفضل المدارس الخاصة وأعطاء الدروس الخاصة والعمل فى مجال التدريس فى الخليج | وظائف مدرسين | وظائف . كوم',4,NULL),(3,'هندسة','Engineering_jobs','وظائف مهندسين | وظائف . كوم | وظائف خالية | وظائف اليوم | فرص عمل |وظائف شاغرة','كل ما يخص الوظائف الهندسية فى جميع التخصصات الهندسية | وظائف مهندسين | وظائف . كوم','كل ما يخص الوظائف الهندسية فى جميع التخصصات الهندسية | وظائف مهندسين | وظائف . كوم',0,NULL),(7,'سكرتارية','Secretariat_jobs','وظائف سكرتارية | وظائف . كوم | وظائف خالية | وظائف اليوم | فرص عمل |وظائف شاغرة','فرص للعمل سكرتارية فى أفضل الشركات والمصانع والمكاتب والشركات العالمية | وظائف سكرتارية | وظائف . كوم','فرص للعمل سكرتارية فى أفضل الشركات والمصانع والمكاتب والشركات العالمية | وظائف سكرتارية | وظائف . كوم',3,NULL),(5,'عماله','Workers_jobs','عماله | وظائف . كوم | وظائف خالية | وظائف اليوم | فرص عمل |وظائف شاغرة','للسفر لدول الخليج والهجره للعمل فى أفضل الشركات العقارية والعالمية | عماله | وظائف . كوم','للسفر لدول الخليج والهجره للعمل فى أفضل الشركات العقارية والعالمية | عماله | وظائف . كوم',6,NULL),(6,'طب و صيدلة','Medicine_and_Pharmacy_jobs','وظائف اطباء و صيادلة | وظائف . كوم | وظائف خالية | وظائف اليوم | فرص عمل |وظائف شاغرة','فرص للأطباء والصيادلة للعمل بأفضل المستشفيات العالمية والخاصة | وظائف اطباء و صيادلة | وظائف . كوم','فرص للأطباء والصيادلة للعمل بأفضل المستشفيات العالمية والخاصة | وظائف اطباء و صيادلة | وظائف . كوم',1,NULL),(8,'تسويق','Marketing_jobs','وظائف تسويق | وظائف . كوم | وظائف خالية | وظائف اليوم | فرص عمل |وظائف شاغرة','للعمل فى أكبر الشركات كمسوق مع وجود أرباح ونسب عالية | وظائف تسويق | وظائف . كوم','للعمل فى أكبر الشركات كمسوق مع وجود أرباح ونسب عالية | وظائف تسويق | وظائف . كوم',5,NULL),(9,'محاسبة','Account_jobs','وظائف محاسبين | وظائف . كوم | وظائف خالية | وظائف اليوم | فرص عمل |وظائف شاغرة','مطلوب محاسبين فى أكبر الشركات الخليجية والعربية والمصرية خبرة او بدون | وظائف محاسبين | وظائف . كوم','مطلوب محاسبين فى أكبر الشركات الخليجية والعربية والمصرية خبرة او بدون | وظائف محاسبين | وظائف . كوم',7,NULL),(15,'فندقة ومطاعم','Hotels_and_Restaurants_jobs','وظائف فندقة ومطاعم | وظائف . كوم | وظائف خالية | وظائف اليوم | فرص عمل |وظائف شاغرة','للعمل فى أكبر الفنادق العالمية والمطاعم عالية الجودة وللسفر الى الامارات والسعودية وشرم الشيخ | وظائف فندقة ومطاعم | وظائف . كوم','للعمل فى أكبر الفنادق العالمية والمطاعم عالية الجودة وللسفر الى الامارات والسعودية وشرم الشيخ | وظائف فندقة ومطاعم | وظائف . كوم',9,NULL),(16,'سائقين','Drivers_jobs','وظائف سائقين | وظائف . كوم | وظائف خالية | وظائف اليوم | فرص عمل |وظائف شاغرة','سائقين بمرتبات عالية ومواعيد ثابته وللسفر وللشركات الكبرى والخاصه | وظائف سائقين | وظائف . كوم','سائقين بمرتبات عالية ومواعيد ثابته وللسفر وللشركات الكبرى والخاصه | وظائف سائقين | وظائف . كوم',10,NULL),(17,'مندوبين','Delegates_jobs','مندوبين | وظائف . كوم | وظائف خالية | وظائف اليوم | فرص عمل |وظائف شاغرة','مندوبين بمرتبات مجزيه وذو خبرة وجادين وللعمل فى أكبر الشركات وللسفر | مندوبين | وظائف . كوم','مندوبين بمرتبات مجزيه وذو خبرة وجادين وللعمل فى أكبر الشركات وللسفر | مندوبين | وظائف . كوم',11,NULL),(18,'حرفيون','Artisans_jobs','حرفيين | وظائف . كوم | وظائف خالية | وظائف اليوم | فرص عمل |وظائف شاغرة','حرفيين فى مجالات مختلفة للشراكة او للعمل براتب مجزى او للسفر او للعمل فى مجال السياحه | حرفيين | وظائف . كوم','حرفيين فى مجالات مختلفة للشراكة او للعمل براتب مجزى او للسفر او للعمل فى مجال السياحه | حرفيين | وظائف . كوم',12,NULL),(19,'حراسات أمنية','Security_escorts_jobs','حراسات أمنية | وظائف . كوم | وظائف خالية | وظائف اليوم | فرص عمل |وظائف شاغرة','للتقدم فى أفضل شركات الحراسة والحراسةالخاصة والحراسة على المنشاءات الهامه | حراسات أمنية | وظائف . كوم','للتقدم فى أفضل شركات الحراسة والحراسةالخاصة والحراسة على المنشاءات الهامه | حراسات أمنية | وظائف . كوم',14,NULL),(20,'إدارة','Management_jobs','وظائف ادارية | وظائف . كوم | وظائف خالية | وظائف اليوم | فرص عمل |وظائف شاغرة','للعمل فى أكبر الشركات فى مجال الإدارة وبراتب مجزى وايضاً للسفر الى دبى | وظائف ادارية | وظائف . كوم','للعمل فى أكبر الشركات فى مجال الإدارة وبراتب مجزى وايضاً للسفر الى دبى | وظائف ادارية | وظائف . كوم',13,NULL),(21,'خدم / عمالة منزلية','Household_Employment_jobs','خدم و عمالة منزلية | وظائف . كوم | وظائف خالية | وظائف اليوم | فرص عمل |وظائف شاغرة','خدم ذو أمانه ونظافة وجوده وإنضباط جمال للسفر والعمل عند أفضل الأسر الخليجية | خدم و عمالة منزلية | وظائف . كوم','خدم ذو أمانه ونظافة وجوده وإنضباط جمال للسفر والعمل عند أفضل الأسر الخليجية | خدم و عمالة منزلية | وظائف . كوم',15,NULL),(26,'طباخين','Cooks_jobs','طباخين | وظائف . كوم | وظائف خالية | وظائف اليوم | فرص عمل |وظائف شاغرة','للعمل فى أفضل الفنادق والامراء الخليجين فى مجال الطبخ وايضاً للسفر | طباخين | وظائف . كوم','للعمل فى أفضل الفنادق والامراء الخليجين فى مجال الطبخ وايضاً للسفر | طباخين | وظائف . كوم',18,NULL),(22,'تمريض و مختبرات','Nursing_and_Laboratories_jobs','وظائف تمريض و مختبرات | وظائف . كوم | وظائف خالية | وظائف اليوم | فرص عمل |وظائف شاغرة','للعمل فى مجال التمريض فى دول الخليج وأفضل المستشفيات العالمية والخاصة والمختبرات | وظائف تمريض و مختبرات | وظائف . كوم','للعمل فى مجال التمريض فى دول الخليج وأفضل المستشفيات العالمية والخاصة والمختبرات | وظائف تمريض و مختبرات | وظائف . كوم',16,NULL),(24,'إستقبال / خدمة عملاء','Reception_Customer_Service_jobs','وظائف استقبال و خدمة عملاء | وظائف . كوم | وظائف خالية | وظائف اليوم | فرص عمل |وظائف شاغرة','يوجد أفراد استقبال وللعمل فى خدمة العملاء فى أكبر الشركات وللسفر | وظائف استقبال و خدمة عملاء | وظائف . كوم','يوجد أفراد استقبال وللعمل فى خدمة العملاء فى أكبر الشركات وللسفر | وظائف استقبال و خدمة عملاء | وظائف . كوم',17,NULL),(27,'بائعون','Resellers_jobs','بائعين | وظائف . كوم | وظائف خالية | وظائف اليوم | فرص عمل |وظائف شاغرة','بائعين فى جميع التخصصاتوالمجالات ذو مهارات عالية وحسن المظهر والامانه | بائعين | وظائف . كوم','بائعين فى جميع التخصصاتوالمجالات ذو مهارات عالية وحسن المظهر والامانه | بائعين | وظائف . كوم',19,NULL),(28,'كمبيوتر','Computer_jobs','وظائف كمبيوتر | وظائف . كوم | وظائف خالية | وظائف اليوم | فرص عمل |وظائف شاغرة','للعمل فى مجال الكمبيوتر فى أكثر من مجال الصيانة والبيع والشراء والهارد وير والسوفت وير وللسفر وشركات الكمبيوتر | وظائف كمبيوتر | وظائف . كوم','للعمل فى مجال الكمبيوتر فى أكثر من مجال الصيانة والبيع والشراء والهارد وير والسوفت وير وللسفر وشركات الكمبيوتر | وظائف كمبيوتر | وظائف . كوم',20,NULL),(29,'تصميم جرافيك','Graphic_Design_jobs','وظائف تصميم جرافيك | وظائف . كوم | وظائف خالية | وظائف اليوم | فرص عمل |وظائف شاغرة','مصممين جرافيكس و ذو خبرة ومهارة وإبداع وجوده للعمل فى شركات كبرى او القنوات او للسفر | وظائف تصميم جرافيك | وظائف . كوم','مصممين جرافيكس و ذو خبرة ومهارة وإبداع وجوده للعمل فى شركات كبرى او القنوات او للسفر | وظائف تصميم جرافيك | وظائف . كوم',21,NULL),(30,'محاماة','Law_Firm_jobs','محامين | وظائف . كوم | وظائف خالية | وظائف اليوم | فرص عمل |وظائف شاغرة','محامىن ذو خبرة ومهارة فى جميع الفروع القانونية للمكاتب الكبرى والاستشارات القانونية | محامين | وظائف . كوم','محامىن ذو خبرة ومهارة فى جميع الفروع القانونية للمكاتب الكبرى والاستشارات القانونية | محامين | وظائف . كوم',22,NULL),(31,'شؤون إدارية','Administrative_affairs_jobs','وظائف شؤون إدارية | وظائف . كوم | وظائف خالية | وظائف اليوم | فرص عمل |وظائف شاغرة','للعمل فى إدارة الشئون الإدارية وتخليص الاوراق والإجراءات المطلوبة والمستوفية للسفر والعمل فى الشركات الكبرى | وظائف شؤون إدارية | وظائف . كوم','للعمل فى إدارة الشئون الإدارية وتخليص الاوراق والإجراءات المطلوبة والمستوفية للسفر والعمل فى الشركات الكبرى | وظائف شؤون إدارية | وظائف . كوم',23,NULL),(32,'سفر و سياحة','Travel_and_Tourism_jobs','وظائف سفر و سياحة | وظائف . كوم | وظائف خالية | وظائف اليوم | فرص عمل |وظائف شاغرة','لكبرى شركات السياحة فى مصر والوطن العربى و دبى والسعودية وظائف فى مجال السياحة والسفر | وظائف سفر و سياحة | وظائف . كوم','لكبرى شركات السياحة فى مصر والوطن العربى و دبى والسعودية وظائف فى مجال السياحة والسفر | وظائف سفر و سياحة | وظائف . كوم',24,NULL),(33,'علاقات عامة','Public_relations_jobs','وظائف علاقات عامة | وظائف . كوم | وظائف خالية | وظائف اليوم | فرص عمل |وظائف شاغرة','للعمل فى أكبر الشركات وبمرتبات مميزة لتمثيل الشركات وللعمل فى فروع الشركات المختلفة | وظائف علاقات عامة | وظائف . كوم','للعمل فى أكبر الشركات وبمرتبات مميزة لتمثيل الشركات وللعمل فى فروع الشركات المختلفة | وظائف علاقات عامة | وظائف . كوم',25,NULL),(34,'مترجمين ','Translators_jobs','مترجمين | وظائف . كوم | وظائف خالية | وظائف اليوم | فرص عمل |وظائف شاغرة','مترجمين يجيدون الانجليزية والايطالية والفرنسية والصينية والالمانية والروسية والاسبانية وجميع اللغات لتقديم خدماتهم لرجال الاعمال والشركات  والتدريس | مترجمين | وظائف . كوم','مترجمين يجيدون الانجليزية والايطالية والفرنسية والصينية والالمانية والروسية والاسبانية وجميع اللغات لتقديم خدماتهم لرجال الاعمال والشركات  والتدريس | مترجمين | وظائف . كوم',26,NULL),(35,'تصميم ديكور','Design_Decor_jobs','وظائف تصميم ديكور | وظائف . كوم | وظائف خالية | وظائف اليوم | فرص عمل |وظائف شاغرة','مصممين ديكور على أعلى مستوى وخبرة وإبداع يقدمون خدماتهم لكافة انواع الشركات والأفراد | وظائف تصميم ديكور | وظائف . كوم','مصممين ديكور على أعلى مستوى وخبرة وإبداع يقدمون خدماتهم لكافة انواع الشركات والأفراد | وظائف تصميم ديكور | وظائف . كوم',27,NULL),(36,'إدخال بيانات','Data_entry_jobs','مدخلين بيانات | وظائف . كوم | وظائف خالية | وظائف اليوم | فرص عمل |وظائف شاغرة','مدخلين بيانات ذو مهارة وسرعة ودقة للعمل بالشركات وللسفر وذو خبرة بمجال الكمبيوتر | مدخلين بيانات | وظائف . كوم','مدخلين بيانات ذو مهارة وسرعة ودقة للعمل بالشركات وللسفر وذو خبرة بمجال الكمبيوتر | مدخلين بيانات | وظائف . كوم',28,NULL),(37,'علاج طبيعي','Physical_Therapy_jobs','وظائف علاج طبيعي | وظائف . كوم | وظائف خالية | وظائف اليوم | فرص عمل |وظائف شاغرة','خدمات العلاج الطبيعى وخبرة وتجارب ناجحه ومستعدون للسفر وللعمل فى مستوصفات ومستشفيات | وظائف علاج طبيعي | وظائف . كوم','خدمات العلاج الطبيعى وخبرة وتجارب ناجحه ومستعدون للسفر وللعمل فى مستوصفات ومستشفيات | وظائف علاج طبيعي | وظائف . كوم',29,NULL),(38,'تصميم معماري ','Architectural_design_jobs','تصميم معماري | وظائف . كوم | وظائف خالية | وظائف اليوم | فرص عمل |وظائف شاغرة','مصممين معماريين ذو خبرة ودقة وسرعة للعمل فى شركات عقارية إنشائية كبرى | تصميم معماري | وظائف . كوم','مصممين معماريين ذو خبرة ودقة وسرعة للعمل فى شركات عقارية إنشائية كبرى | تصميم معماري | وظائف . كوم',30,NULL),(39,'إعلاميون ','Media_representatives_jobs','إعلاميين | وظائف . كوم | وظائف خالية | وظائف اليوم | فرص عمل |وظائف شاغرة','إعلامى حديث التخرج وخبرة للتقديم البرامج وعمل التقارير الاخبارية وللعمل فى اى قناة فضائية او للسفر | إعلاميين | وظائف . كوم','إعلامى حديث التخرج وخبرة للتقديم البرامج وعمل التقارير الاخبارية وللعمل فى اى قناة فضائية او للسفر | إعلاميين | وظائف . كوم',31,NULL),(40,'تصميم مواقع إنترنت','Web_Design_Internet_jobs','تصميم مواقع انترنت | وظائف . كوم | وظائف خالية | وظائف اليوم | فرص عمل |وظائف شاغرة','مصممين مواقع ذو خبرة واحتراف يجيدون لغات برمجة مختلفة وبإحتراف | تصميم مواقع انترنت | وظائف . كوم','مصممين مواقع ذو خبرة واحتراف يجيدون لغات برمجة مختلفة وبإحتراف | تصميم مواقع انترنت | وظائف . كوم',32,NULL),(41,'مرافق خاص','Special_facilities_jobs','مرافق خاص | وظائف . كوم | وظائف خالية | وظائف اليوم | فرص عمل |وظائف شاغرة','مرافقين يريدون العمل ذو تحمل عالى وذو امانه وحكمه | مرافق خاص | وظائف . كوم','مرافقين يريدون العمل ذو تحمل عالى وذو امانه وحكمه | مرافق خاص | وظائف . كوم',33,NULL),(42,'حلاقة و كوافيير','Barber_and_Hairdressers_jobs','حلاقيين| وظائف . كوم | وظائف خالية | وظائف اليوم | فرص عمل |وظائف شاغرة','حلاقيين وكوافيير ذو خبرة ونظافة وجودة يعروض خدماتهم للشخصيات المرموقة وايضاً للسفر | حلاقيين| وظائف . كوم','حلاقيين وكوافيير ذو خبرة ونظافة وجودة يعروض خدماتهم للشخصيات المرموقة وايضاً للسفر | حلاقيين| وظائف . كوم',34,NULL),(43,'موزعون','Distributors_jobs','موزعون | وظائف . كوم | وظائف خالية | وظائف اليوم | فرص عمل |وظائف شاغرة','موزعون ذو خبرة وامانه للعمل فى شركات مختلفة وللسفر وتحمل المسئولية | موزعون | وظائف . كوم','موزعون ذو خبرة وامانه للعمل فى شركات مختلفة وللسفر وتحمل المسئولية | موزعون | وظائف . كوم',35,NULL),(44,'أمين مستودع','Secretary_of_the_warehouse_jobs','أمين مستودع | وظائف . كوم | وظائف خالية | وظائف اليوم | فرص عمل |وظائف شاغرة','أمين مخازن او مستودعات ذو أمانه وخبرة وتطور للعمل فى شركات كبرى او للسفر | أمين مستودع | وظائف . كوم','أمين مخازن او مستودعات ذو أمانه وخبرة وتطور للعمل فى شركات كبرى او للسفر | أمين مستودع | وظائف . كوم',36,NULL),(45,'خياطة','Sewing_jobs','خياطين | وظائف . كوم | وظائف خالية | وظائف اليوم | فرص عمل |وظائف شاغرة','خياطين ذو خبرة وجوده ودقة للعمل فى المصانع الملابس الكبرى او للسفر | خياطين | وظائف . كوم','خياطين ذو خبرة وجوده ودقة للعمل فى المصانع الملابس الكبرى او للسفر | خياطين | وظائف . كوم',37,NULL),(46,'مصورين','Photographers_jobs','مصورين | وظائف . كوم | وظائف خالية | وظائف اليوم | فرص عمل |وظائف شاغرة','مصورين محترفيين فى المجال الفوتوغرافى أو الفيديو لتقديم خدماتهم أو للعمل فى أكبر القنوات ومع والممثلين أو للسفر| مصورين | وظائف . كوم','مصورين محترفيين فى المجال الفوتوغرافى أو الفيديو لتقديم خدماتهم أو للعمل فى أكبر القنوات ومع والممثلين أو للسفر| مصورين | وظائف . كوم',38,NULL),(47,'خريج ثانوي','Graduate_of_a_secondary_jobs','خريج ثانوي | وظائف . كوم | وظائف خالية | وظائف اليوم | فرص عمل |وظائف شاغرة','خرجين ثانوى عام او غيرها يقدمون خدماتهم للعمل فى الشركات والبنوك والمصانع او المكاتب وايضاً للسفر | خريج ثانوي | وظائف . كوم','خرجين ثانوى عام او غيرها يقدمون خدماتهم للعمل فى الشركات والبنوك والمصانع او المكاتب وايضاً للسفر | خريج ثانوي | وظائف . كوم',39,NULL),(48,'أخصائي تغذية','Nutritionist_jobs','أخصائيين تغذية | وظائف . كوم | وظائف خالية | وظائف اليوم | فرص عمل |وظائف شاغرة','اخصائيين تغذية ذو خبرة وكفاءة لعرضون خدماتهم للأفراد وأيضاً للعمل فى المستشفيات الكبرى أو العيادات أو للسفر | أخصائيين تغذية | وظائف . كوم','اخصائيين تغذية ذو خبرة وكفاءة لعرضون خدماتهم للأفراد وأيضاً للعمل فى المستشفيات الكبرى أو العيادات أو للسفر | أخصائيين تغذية | وظائف . كوم',40,NULL),(49,'تصميم أزياء','Fashion_Designers_jobs','مصممين أزياء | وظائف . كوم | وظائف خالية | وظائف اليوم | فرص عمل |وظائف شاغرة','مصممين أزياء ذو إبداع ومهارة يقدمون خدماتهم لأصحاب الشهرة والمصانع الكبرى او للسفر | مصممين أزياء | وظائف . كوم','مصممين أزياء ذو إبداع ومهارة يقدمون خدماتهم لأصحاب الشهرة والمصانع الكبرى او للسفر | مصممين أزياء | وظائف . كوم',41,NULL),(50,'أخرى','Other_jobs','وظائف أخرى | وظائف . كوم | وظائف خالية | وظائف اليوم | فرص عمل |وظائف شاغرة','يوضع هنا أى وظيفة لم يتم تصنيفها فى موقع وظائف.كوم | وظائف أخرى | وظائف . كوم','يوضع هنا أى وظيفة لم يتم تصنيفها فى موقع وظائف.كوم | وظائف أخرى | وظائف . كوم',42,NULL),(51,'كيميائيين و علوم','Chemists_Sciences_jobs','وظائف العلوم والكيمياء | وظائف . كوم | وظائف خالية | وظائف اليوم | فرص عمل |وظائف شاغرة','قسم خاص بالكيميائيين وخرجين علوم  ','قسم خاص بالكيميائيين وخرجين علوم  ',2,'4.png');

/*Table structure for table `classfied_cities` */

DROP TABLE IF EXISTS `classfied_cities`;

CREATE TABLE `classfied_cities` (
  `classfied_city_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `classfied_country_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`classfied_city_id`)
) ENGINE=InnoDB AUTO_INCREMENT=94 DEFAULT CHARSET=utf8;

/*Data for the table `classfied_cities` */

insert  into `classfied_cities`(`classfied_city_id`,`name`,`classfied_country_id`) values (1,'الأردن',1),(2,'مصر',NULL),(3,'الجزائر',NULL),(4,'البحرين',NULL),(5,'الإمارات العربية المتحدة',NULL),(73,'العراق',NULL),(74,'الكويت',NULL),(75,'المغرب',NULL),(76,'المملكة العربية السعودية',NULL),(77,'اليمن',NULL),(78,'تونس',NULL),(79,'عمان',NULL),(80,'قطر',NULL),(81,'لبنان',NULL),(82,'ليبيا',NULL),(83,'سوريا',NULL),(84,'السودان',NULL),(85,'فلسطين',NULL),(93,'cairooooooooooooooo',85);

/*Table structure for table `classfied_countries` */

DROP TABLE IF EXISTS `classfied_countries`;

CREATE TABLE `classfied_countries` (
  `classfied_country_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `image` text,
  PRIMARY KEY (`classfied_country_id`)
) ENGINE=InnoDB AUTO_INCREMENT=86 DEFAULT CHARSET=utf8;

/*Data for the table `classfied_countries` */

insert  into `classfied_countries`(`classfied_country_id`,`name`,`image`) values (1,'الأردن','1440070143_egypt.png'),(2,'مصر','1440070143_egypt2.png'),(3,'الجزائر',NULL),(4,'البحرين',NULL),(5,'الإمارات العربية المتحدة',NULL),(73,'العراق',NULL),(74,'الكويت',NULL),(75,'المغرب',NULL),(76,'المملكة العربية السعودية','1440070143_egypt.png'),(77,'اليمن',NULL),(78,'تونس',NULL),(79,'عمان','1440070143_egypt1.png'),(80,'قطر',NULL),(81,'لبنان',NULL),(82,'ليبيا',NULL),(83,'سوريا',NULL),(84,'السودان',NULL),(85,'فلسطين','1440070143_egypt5.png');

/*Table structure for table `classfied_currencies` */

DROP TABLE IF EXISTS `classfied_currencies`;

CREATE TABLE `classfied_currencies` (
  `classfied_currency_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`classfied_currency_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `classfied_currencies` */

insert  into `classfied_currencies`(`classfied_currency_id`,`name`) values (1,'dollar'),(2,'LE');

/*Table structure for table `classfied_experience` */

DROP TABLE IF EXISTS `classfied_experience`;

CREATE TABLE `classfied_experience` (
  `classfied_experience_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`classfied_experience_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `classfied_experience` */

insert  into `classfied_experience`(`classfied_experience_id`,`name`) values (1,'لا يشترط'),(2,'اكثرمن سنة'),(3,'اكثرمن ثلاث سنوات');

/*Table structure for table `classfied_job_applications` */

DROP TABLE IF EXISTS `classfied_job_applications`;

CREATE TABLE `classfied_job_applications` (
  `classfied_job_application_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `classfied_job_id` int(10) unsigned NOT NULL,
  `created_on` datetime NOT NULL,
  `ip` varchar(15) NOT NULL,
  PRIMARY KEY (`classfied_job_application_id`),
  KEY `classfied_job_id` (`classfied_job_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `classfied_job_applications` */

/*Table structure for table `classfied_jobs` */

DROP TABLE IF EXISTS `classfied_jobs`;

CREATE TABLE `classfied_jobs` (
  `classfied_job_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `classfied_type_id` int(11) NOT NULL,
  `classfied_category_id` int(11) NOT NULL,
  `title` varchar(100) DEFAULT '',
  `description` text,
  `company` varchar(150) DEFAULT '',
  `classfied_city_id` int(11) DEFAULT NULL,
  `url` varchar(150) DEFAULT NULL,
  `apply` varchar(200) DEFAULT '',
  `created_on` date NOT NULL DEFAULT '0000-00-00',
  `is_temp` tinyint(4) NOT NULL,
  `is_active` tinyint(4) NOT NULL,
  `views_count` int(11) NOT NULL,
  `auth` varchar(32) NOT NULL,
  `outside_location` varchar(150) NOT NULL,
  `poster_email` varchar(100) NOT NULL,
  `apply_online` tinyint(4) NOT NULL,
  `spotlight` tinyint(4) NOT NULL,
  `workplace` varchar(150) NOT NULL DEFAULT '0,0,0',
  `salary_from` int(11) NOT NULL,
  `salary_to` int(11) NOT NULL,
  `classfied_currency_id` int(11) NOT NULL,
  `is_hidden_num` tinyint(2) NOT NULL DEFAULT '1',
  `phone_num` varchar(30) NOT NULL,
  `classfied_experience_id` int(11) NOT NULL,
  `classfied_area_id` int(11) DEFAULT NULL,
  `classfied_country_id` int(11) DEFAULT NULL,
  `candidate_location` int(11) DEFAULT NULL,
  PRIMARY KEY (`classfied_job_id`),
  KEY `type_id` (`classfied_type_id`),
  KEY `category_id` (`classfied_category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `classfied_jobs` */

/*Table structure for table `classfied_types` */

DROP TABLE IF EXISTS `classfied_types`;

CREATE TABLE `classfied_types` (
  `classfied_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(16) NOT NULL,
  `var_name` varchar(32) NOT NULL,
  `color` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`classfied_type_id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='full-time/freelance';

/*Data for the table `classfied_types` */

insert  into `classfied_types`(`classfied_type_id`,`name`,`var_name`,`color`) values (1,'وظيفة','fulltime','#2bc60f'),(2,'تعاقد','parttime','#dad2fb'),(3,'مؤقت','freelance','#f9b373'),(5,'شراكة','partnership',NULL),(8,'777','نخ','#e4b1e3');

/*Table structure for table `clients` */

DROP TABLE IF EXISTS `clients`;

CREATE TABLE `clients` (
  `client_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `image` text NOT NULL,
  PRIMARY KEY (`client_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `clients` */

insert  into `clients`(`client_id`,`name`,`image`) values (3,'jdsj','483792_489207341128752_1998018065_n1.jpg');

/*Table structure for table `clinic_branches` */

DROP TABLE IF EXISTS `clinic_branches`;

CREATE TABLE `clinic_branches` (
  `clinic_branch_id` int(11) NOT NULL AUTO_INCREMENT,
  `clinic_branch` varchar(255) DEFAULT NULL,
  `phone` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `longitude` varchar(255) NOT NULL,
  `latitude` varchar(255) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`clinic_branch_id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

/*Data for the table `clinic_branches` */

insert  into `clinic_branches`(`clinic_branch_id`,`clinic_branch`,`phone`,`address`,`longitude`,`latitude`,`description`) values (12,'Vectoria','01159500591','elgalaa','123654','98745','yyyyyyyyyyyyyyy'),(13,'Elmabara','0123659857458','elasafraa','32659857','89658968','tttttttttttttttt'),(16,'Elsalama','01159500591','sidi bishr','78965413','01236598745','ttttttttttttttt'),(18,'elsa3\'r','01000709113','elgalaa','13.39061660302741','52.5068172907145','tyyyyy');

/*Table structure for table `clinic_disease_templates` */

DROP TABLE IF EXISTS `clinic_disease_templates`;

CREATE TABLE `clinic_disease_templates` (
  `clinic_disease_template_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `content` text,
  `language_id` varchar(3) DEFAULT NULL,
  PRIMARY KEY (`clinic_disease_template_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

/*Data for the table `clinic_disease_templates` */

insert  into `clinic_disease_templates`(`clinic_disease_template_id`,`title`,`content`,`language_id`) values (5,'eyes','ssss','en'),(6,'cancer','uyuyu','en');

/*Table structure for table `clinic_doctor_reservation_types` */

DROP TABLE IF EXISTS `clinic_doctor_reservation_types`;

CREATE TABLE `clinic_doctor_reservation_types` (
  `clinic_doctor_reservation_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(250) DEFAULT NULL,
  `price` double DEFAULT NULL,
  `clinic_doctor_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`clinic_doctor_reservation_type_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `clinic_doctor_reservation_types` */

insert  into `clinic_doctor_reservation_types`(`clinic_doctor_reservation_type_id`,`title`,`price`,`clinic_doctor_id`) values (1,'ramad',75,1),(2,'nazar',900,2),(3,'cancer',75,1),(4,'Marwa',1000,2);

/*Table structure for table `clinic_doctor_reviews` */

DROP TABLE IF EXISTS `clinic_doctor_reviews`;

CREATE TABLE `clinic_doctor_reviews` (
  `clinic_doctor_review_id` int(11) NOT NULL AUTO_INCREMENT,
  `review` tinyint(4) DEFAULT NULL,
  `clinic_patient_id` int(11) DEFAULT NULL,
  `clinic_doctor_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`clinic_doctor_review_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `clinic_doctor_reviews` */

insert  into `clinic_doctor_reviews`(`clinic_doctor_review_id`,`review`,`clinic_patient_id`,`clinic_doctor_id`) values (3,4,18,20),(2,6,18,24);

/*Table structure for table `clinic_doctors` */

DROP TABLE IF EXISTS `clinic_doctors`;

CREATE TABLE `clinic_doctors` (
  `clinic_doctor_id` int(11) NOT NULL AUTO_INCREMENT,
  `clinic_specification_id` int(11) NOT NULL,
  `description` text,
  `user_id` int(11) DEFAULT NULL,
  `period_average` varchar(2) DEFAULT NULL,
  PRIMARY KEY (`clinic_doctor_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

/*Data for the table `clinic_doctors` */

insert  into `clinic_doctors`(`clinic_doctor_id`,`clinic_specification_id`,`description`,`user_id`,`period_average`) values (6,0,'',0,''),(7,30,'sssss',1,'30'),(8,30,'sssss',25,'30');

/*Table structure for table `clinic_patient_diseases` */

DROP TABLE IF EXISTS `clinic_patient_diseases`;

CREATE TABLE `clinic_patient_diseases` (
  `clinic_patient_disease_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `clinic_disease_template_id` int(11) DEFAULT NULL,
  `note` text,
  PRIMARY KEY (`clinic_patient_disease_id`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8;

/*Data for the table `clinic_patient_diseases` */

insert  into `clinic_patient_diseases`(`clinic_patient_disease_id`,`user_id`,`clinic_disease_template_id`,`note`) values (24,NULL,5,'Muhammad'),(25,NULL,6,'bnbn'),(26,NULL,6,'edw'),(27,NULL,6,'gf'),(28,NULL,5,'muhammad'),(29,NULL,5,'kokl;k;l'),(30,NULL,5,'kokl;k;l'),(31,NULL,5,'kokl;k;l'),(32,NULL,5,'kokl;k;l'),(33,NULL,6,'iuiuiu'),(34,NULL,5,'frfrrfr'),(38,2,5,'ثث'),(39,2,5,'kl'),(40,2,5,'نممنمنم'),(41,2,6,'نممنمنم');

/*Table structure for table `clinic_patients` */

DROP TABLE IF EXISTS `clinic_patients`;

CREATE TABLE `clinic_patients` (
  `clinic_patient_id` int(11) NOT NULL AUTO_INCREMENT,
  `birthdate` date DEFAULT NULL,
  `note` text,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`clinic_patient_id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

/*Data for the table `clinic_patients` */

insert  into `clinic_patients`(`clinic_patient_id`,`birthdate`,`note`,`user_id`) values (18,'2015-07-16','ttttttttttttttttt',1);

/*Table structure for table `clinic_patients_notes` */

DROP TABLE IF EXISTS `clinic_patients_notes`;

CREATE TABLE `clinic_patients_notes` (
  `clinic_patient_note_id` int(11) NOT NULL AUTO_INCREMENT,
  `clinic_doctor_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `note` text,
  PRIMARY KEY (`clinic_patient_note_id`)
) ENGINE=MyISAM AUTO_INCREMENT=38 DEFAULT CHARSET=latin1;

/*Data for the table `clinic_patients_notes` */

insert  into `clinic_patients_notes`(`clinic_patient_note_id`,`clinic_doctor_id`,`user_id`,`note`) values (35,NULL,2,'nottttesyu'),(36,NULL,2,'muhammad');

/*Table structure for table `clinic_recommended_centers` */

DROP TABLE IF EXISTS `clinic_recommended_centers`;

CREATE TABLE `clinic_recommended_centers` (
  `clinic_recommended_center_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `address` tinytext,
  `type` varchar(255) DEFAULT NULL,
  `clinic_doctor_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`clinic_recommended_center_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `clinic_recommended_centers` */

/*Table structure for table `clinic_reservations` */

DROP TABLE IF EXISTS `clinic_reservations`;

CREATE TABLE `clinic_reservations` (
  `clinic_reservation_id` int(11) NOT NULL AUTO_INCREMENT,
  `clinic_doctor_id` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `time` time DEFAULT NULL,
  `clinic_doctor_reservation_type_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `clinic_reservation_status` enum('pending','canceled','confirmed') DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `status` enum('late','attend','entered','canceled','') DEFAULT NULL COMMENT 'Patient Status',
  `order` int(11) DEFAULT NULL,
  `number` int(11) DEFAULT NULL,
  PRIMARY KEY (`clinic_reservation_id`)
) ENGINE=InnoDB AUTO_INCREMENT=76 DEFAULT CHARSET=utf8;

/*Data for the table `clinic_reservations` */

insert  into `clinic_reservations`(`clinic_reservation_id`,`clinic_doctor_id`,`date`,`time`,`clinic_doctor_reservation_type_id`,`user_id`,`clinic_reservation_status`,`created`,`status`,`order`,`number`) values (2,4,'2015-08-27','11:00:00',2,1,'confirmed','2015-08-22 14:08:00','late',0,1),(3,2,'2015-08-23','16:00:00',1,1,'confirmed','2015-08-22 14:08:23','',0,NULL),(7,1,'2015-08-29','17:00:00',1,25,'confirmed','2015-08-24 12:13:13','',0,2),(9,4,'2015-08-27','17:00:00',3,1,'confirmed','2015-08-24 16:56:41','',0,3),(11,1,'2015-08-29','19:30:00',1,29,'confirmed','2015-08-24 17:04:23','',0,5),(12,1,'2015-08-29','14:30:00',28,2,'confirmed','2015-08-24 17:05:28','',0,1),(14,4,'2015-08-27','12:00:00',4,18,'confirmed','2015-08-24 17:19:31','',0,6),(15,4,'2015-08-27','21:00:00',1,29,'confirmed','2015-08-24 17:25:37','',0,5),(17,4,'2015-08-27','18:00:00',3,28,'confirmed','2015-08-24 17:27:06','',0,4),(22,4,'2015-08-27','14:30:00',1,25,'confirmed','2015-08-25 13:08:02','',0,2),(53,3,'2015-09-01','20:00:00',3,1,'confirmed','2015-08-29 16:42:33','',NULL,NULL),(54,3,'2015-09-01','21:30:00',3,1,'confirmed','2015-08-29 16:46:56','',NULL,NULL),(55,1,'2015-08-29','20:00:00',3,18,'confirmed','2015-08-29 17:56:03','',NULL,6),(56,1,'2015-08-29','18:30:00',1,1,'confirmed','2015-08-29 17:57:38','',NULL,3),(57,1,'2015-08-29','19:00:00',1,2,'confirmed','2015-08-29 18:28:51','',NULL,4),(66,2,'2015-08-30','14:00:00',1,18,'confirmed','2015-08-30 13:48:36','late',NULL,1),(67,2,'2015-08-30','18:00:00',3,1,'confirmed','2015-08-30 13:48:45','attend',NULL,4),(68,2,'2015-08-30','20:00:00',3,2,'confirmed','2015-08-30 13:49:59','',NULL,7),(69,2,'2015-08-30','16:00:00',3,25,'confirmed','2015-08-30 13:53:22','entered',NULL,2),(70,2,'2015-08-30','17:00:00',3,28,'confirmed','2015-08-30 13:57:05','attend',NULL,3),(71,2,'2015-08-30','18:30:00',3,1,'confirmed','2015-08-30 18:06:50','late',NULL,5),(72,2,'2015-08-30','19:30:00',1,1,'confirmed','2015-08-30 18:12:03','',NULL,6),(73,24,'2015-09-22','11:25:00',4,NULL,'confirmed','2015-09-20 17:10:59',NULL,NULL,NULL),(74,25,'2015-09-30','11:25:00',2,NULL,'confirmed','2015-09-20 17:13:03',NULL,NULL,NULL),(75,24,'2015-09-30','11:25:00',4,NULL,'confirmed','2015-09-20 17:13:31',NULL,NULL,NULL);

/*Table structure for table `clinic_schedule_exceptions` */

DROP TABLE IF EXISTS `clinic_schedule_exceptions`;

CREATE TABLE `clinic_schedule_exceptions` (
  `clinic_schedule_exception_id` int(11) NOT NULL AUTO_INCREMENT,
  `clinic_doctor_id` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `from_time` time DEFAULT NULL,
  `to_time` time DEFAULT NULL,
  PRIMARY KEY (`clinic_schedule_exception_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `clinic_schedule_exceptions` */

insert  into `clinic_schedule_exceptions`(`clinic_schedule_exception_id`,`clinic_doctor_id`,`date`,`from_time`,`to_time`) values (1,3,'2015-08-25','13:00:00','14:00:00');

/*Table structure for table `clinic_schedules` */

DROP TABLE IF EXISTS `clinic_schedules`;

CREATE TABLE `clinic_schedules` (
  `clinic_schedule_id` int(11) NOT NULL AUTO_INCREMENT,
  `clinic_doctor_id` int(11) DEFAULT NULL,
  `day` enum('Saturday','Sunday','Monday','Tuesday','Wednesday','Thursday','Friday') DEFAULT NULL,
  `from_time` time DEFAULT NULL,
  `to_time` time DEFAULT NULL,
  PRIMARY KEY (`clinic_schedule_id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;

/*Data for the table `clinic_schedules` */

insert  into `clinic_schedules`(`clinic_schedule_id`,`clinic_doctor_id`,`day`,`from_time`,`to_time`) values (4,1,'Sunday','03:00:00','01:00:00'),(24,1,'Saturday','03:00:00','19:00:00'),(25,NULL,NULL,'02:00:00','07:00:00'),(26,1,'Tuesday','04:00:00','00:00:09');

/*Table structure for table `clinic_specification_branches` */

DROP TABLE IF EXISTS `clinic_specification_branches`;

CREATE TABLE `clinic_specification_branches` (
  `clinic_specification_branch_id` int(11) NOT NULL AUTO_INCREMENT,
  `clinic_specification_id` int(11) DEFAULT NULL,
  `clinic_branch_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`clinic_specification_branch_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

/*Data for the table `clinic_specification_branches` */

insert  into `clinic_specification_branches`(`clinic_specification_branch_id`,`clinic_specification_id`,`clinic_branch_id`) values (13,32,18),(14,32,13),(15,32,12);

/*Table structure for table `clinic_specifications` */

DROP TABLE IF EXISTS `clinic_specifications`;

CREATE TABLE `clinic_specifications` (
  `clinic_specification_id` int(11) NOT NULL AUTO_INCREMENT,
  `specification` varchar(255) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`clinic_specification_id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;

/*Data for the table `clinic_specifications` */

insert  into `clinic_specifications`(`clinic_specification_id`,`specification`,`description`) values (28,'eyes',''),(29,'heart',''),(30,'head',''),(32,'ramad','sss');

/*Table structure for table `clinic_xray_negative` */

DROP TABLE IF EXISTS `clinic_xray_negative`;

CREATE TABLE `clinic_xray_negative` (
  `clinic_xray_negative_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `description` text,
  `user_id` int(11) DEFAULT NULL,
  `image` text,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`clinic_xray_negative_id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

/*Data for the table `clinic_xray_negative` */

insert  into `clinic_xray_negative`(`clinic_xray_negative_id`,`title`,`description`,`user_id`,`image`,`created`) values (12,'muhammad','rdegtr',2,'tytg',NULL),(15,'mmmmmm','mmmmmmmmmm????????????m',2,'',NULL);

/*Table structure for table `commerce_brands` */

DROP TABLE IF EXISTS `commerce_brands`;

CREATE TABLE `commerce_brands` (
  `commerce_brand_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `image` text,
  PRIMARY KEY (`commerce_brand_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `commerce_brands` */

insert  into `commerce_brands`(`commerce_brand_id`,`name`,`image`) values (1,'ZEADES','zeades-blason-gris-200x1201.png'),(2,'Samsung','samsung-logo.png'),(3,'Sony','sony-corp-logo1.png');

/*Table structure for table `commerce_cart` */

DROP TABLE IF EXISTS `commerce_cart`;

CREATE TABLE `commerce_cart` (
  `commerce_cart_id` int(11) NOT NULL AUTO_INCREMENT,
  `commerce_product_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `weight` float DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `options` text,
  `datetime` datetime DEFAULT NULL,
  `session_id` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`commerce_cart_id`),
  KEY `product_id` (`commerce_product_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

/*Data for the table `commerce_cart` */

insert  into `commerce_cart`(`commerce_cart_id`,`commerce_product_id`,`user_id`,`weight`,`qty`,`options`,`datetime`,`session_id`) values (1,1,NULL,NULL,1,NULL,NULL,'lvotiuge54gbjk9dcp7g19d722'),(11,38,NULL,NULL,2,NULL,NULL,'sfr1h1m2rj6h4ur196i46hijj3'),(12,27,NULL,NULL,1,NULL,NULL,'sfr1h1m2rj6h4ur196i46hijj3');

/*Table structure for table `commerce_categories` */

DROP TABLE IF EXISTS `commerce_categories`;

CREATE TABLE `commerce_categories` (
  `commerce_category_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `parent` int(11) DEFAULT NULL,
  `seo` varchar(255) DEFAULT NULL,
  `language_id` varchar(5) DEFAULT NULL,
  `image` text,
  `featured` enum('yes','no') DEFAULT NULL,
  `description` text,
  PRIMARY KEY (`commerce_category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=utf8;

/*Data for the table `commerce_categories` */

insert  into `commerce_categories`(`commerce_category_id`,`title`,`parent`,`seo`,`language_id`,`image`,`featured`,`description`) values (9,'Phones',0,'phones','en','sony-xperia-z2-android-lollipop.jpg','yes','Electronics is the science of how to control electric energy, energy in which the electrons have a fundamental role. Electronics deals with electrical circuits that involve active electrical components such as vacuum tubes, transistors, diodes and integrated circuits, and associated passive electrical components and interconnection technologies. Commonly, electronic devices contain circuitry consisting primarily or exclusively of active semiconductors supplemented with passive elements; such a circuit is described as an electronic circuit.\r\n\r\nThe nonlinear behaviour of active components and their ability to control electron flows makes amplification of weak signals possible, and electronics is widely used in information processing, telecommunication, and signal processing. The ability of electronic devices to act as switches makes digital information processing possible. Interconnection technologies such as circuit boards, electronics packaging technology, and other varied forms of communication infrastructure complete circuit functionality and transform the mixed components into a regular working system.\r\n\r\nElectronics is distinct from electrical and electro-mechanical science and technology, which deal with the generation, distribution, switching, storage, and conversion of electrical energy to and from other energy forms using wires, motors, generators, batteries, switches, relays, transformers, resistors, and other passive components. This distinction started around 1906 with the invention by Lee De Forest of the triode, which made electrical amplification of weak radio signals and audio signals possible with a non-mechanical device. Until 1950 this field was called \"radio technology\" because its principal application was the design and theory of radio transmitters, receivers, and vacuum tubes.\r\n\r\nToday, most electronic devices use semiconductor components to perform electron control. The study of semiconductor devices and related technology is considered a branch of solid-state physics, whereas the design and construction of electronic circuits to solve practical problems come under electronics engineering. This article focuses on engineering aspects of electronics.'),(10,'Laptops',0,'laptops','en','laptop.png','yes','A laptop or a notebook is a portable personal computer with a clamshell form factor, suitable for mobile use.[1] Although there used to be a distinction between laptops and notebooks (the former were bigger and heavier than the latter), there is often no longer any difference in practice. [2] Laptops are commonly used in a variety of settings, including at work, in education, and for personal multimedia.\r\n\r\nA laptop combines the components and inputs of a desktop computer, including display, speakers, keyboard and pointing device (such as a touchpad or a trackpad) into a single device. Most modern-day laptops also have an integrated webcam and a microphone. A laptop can be powered either from a rechargeable battery, or by mains electricity via an AC adapter. Laptop is a diverse category of devices and other more specific terms, such as rugged notebook or convertible, refer to specialist types of laptops, which have been optimized for specific uses. Hardware specifications change significantly between different types, makes and models of laptops.\r\n\r\nPortable computers, which later developed into modern laptops, were originally considered to be a small niche market, mostly for specialized field applications, such as the military, accountancy, for sales representatives etc. As portable computers developed and became more like modern laptops, becoming smaller, lighter, cheaper, and more powerful, they became very widely used for a variety of purposes.[3]'),(12,'Cameras',0,'cameras','en','canon-eos-60-samples_3.jpg','yes','A camera is an optical instrument for recording images, which may be stored locally, transmitted to another location, or both. The images may be individual still photographs or sequences of images constituting videos or movies. The word camera comes from camera obscura, which means \"dark chamber\" and is the Latin name of the original device for projecting an image of external reality onto a flat surface. The modern photographic camera evolved from the camera obscura. The functioning of the camera is very similar to the functioning of the human eye.'),(13,'Sony',9,'Sony','en',NULL,'yes','A computer is a general-purpose device that can be programmed to carry out a set of arithmetic or logical operations automatically. Since a sequence of operations can be readily changed, the computer can solve more than one kind of problem.\r\n\r\nConventionally, a computer consists of at least one processing element, typically a central processing unit (CPU), and some form of memory. The processing element carries out arithmetic and logic operations, and a sequencing and control unit can change the order of operations in response to stored information. Peripheral devices allow information to be retrieved from an external source, and the result of operations saved and retrieved.\r\n\r\nMechanical analog computers started appearing in the first century and were later used in the medieval era for astronomical calculations. In World War II, mechanical analog computers were used for specialized military applications such as calculating torpedo aiming. During this time the first electronic digital computers were developed. Originally they were the size of a large room, consuming as much power as several hundred modern personal computers (PCs).[1]\r\n\r\nModern computers based on integrated circuits are millions to billions of times more capable than the early machines, and occupy a fraction of the space.[2] Computers are small enough to fit into mobile devices, and mobile computers can be powered by small batteries. Personal computers in their various forms are icons of the Information Age and are generally considered as \"computers\". However, the embedded computers found in many devices from MP3 players to fighter aircraft and from electronic toys to industrial robots are the most numerous.'),(14,'Clothes',0,'clothes','en','2014-font-b-mens-b-font-dress-shirts-social-shirt-small-mushroom-font-b-men-s.jpg','no','Clothing is fiber and textile material worn on the body.\r\n\r\nThe wearing of clothing is a feature of nearly all human societies. The amount and type of clothing worn is dependent on physical stature, gender, as well as social and geographic considerations.\r\n\r\nPhysically, clothing serves many purposes: it can serve as protection from weather, and can enhance safety during hazardous activities such as hiking and cooking. It protects the wearer from rough surfaces, rash-causing plants, insect bites, splinters, thorns and prickles by providing a barrier between the skin and the environment. Clothes can insulate against cold or hot conditions. Further, they can provide a hygienic barrier, keeping infectious and toxic materials away from the body. Clothing also provides protection from harmful UV radiation.\r\n\r\nClothes can be made out of fiber plants such as cotton, plastics such as polyester, or animal skin and hair such as wool. Humans began wearing clothes roughly 83,000 to 170,000 years ago.[1]'),(15,'Dresses',14,'dresses','en',NULL,'yes','A dress (also known as a frock or a gown) is a garment consisting of a skirt with an attached bodice (or a matching bodice giving the effect of a one-piece garment). In Western culture, dresses are more often worn by women and girls.\r\n\r\nThe hemlines of dresses vary depending on the whims of fashion and the modesty or personal taste of the wearer.[1]'),(16,'Skirts',14,'skirts','en',NULL,'yes','A skirt is a tube- or cone-shaped garment that hangs from the waist or hips and covers all or part of the legs.\r\n\r\nThe hemline of skirts can vary from micro to floor-length and can vary according to cultural conceptions of modesty and aesthetics as well as the wearer\'s personal taste, which can be influenced by such factors as fashion and social context. Most skirts are self-standing garments, but some skirt-looking panels may be part of another garment such as leggings, shorts, and swimsuits.\r\n\r\nIn the western world, skirts are more commonly worn by women; with some exceptions such as the izaar which is worn by Muslim cultures and the kilt which is a traditional men\'s garment in Scotland and Ireland. Some fashion designers, such as Jean Paul Gaultier, have shown men\'s skirts.[citation needed] Other cultures traditionally wear skirts.\r\n\r\nAt its simplest, a skirt can be a draped garment made out of a single piece of material (such as pareos), but most skirts are fitted to the body at the waist or hips and fuller below, with the fullness introduced by means of darts, gores, pleats, or panels. Modern skirts are usually made of light to mid-weight fabrics, such as denim, jersey, worsted, or poplin. Skirts of thin or clingy fabrics are often worn with slips to make the material of the skirt drape better and for modesty.'),(17,'Patns',14,'pants','en',NULL,'yes','The pantalon was a very large dulcimer with a double sounding board, approximately 6 ft (2 m) long, with about 200 strings of both gut and metal, some double- or triple-strung. It had no dampers, so the strings vibrated sympathetically, giving a rich resonating tone that was quite novel at the time and made a noticeable stir; the lack of dampers however also made articulation difficult.\r\n\r\nFew instruments were constructed and very few survive.[1] Hebenstreit and his two best pupils Maximilian Hellmann and Johann Baptist Gumpenhuber were essentially the only virtuoso players of the instrument. However it was well known in French and German musical circles of the early 18th century, and Hebenstreit gained fame and fortune playing it.\r\n\r\nHebenstreit named the instrument after himself. Glowing reviews of its qualities appear in the writings of a number of prominent commentators of the day, such as Johann Kuhnau. The instrument died out with Hebenstreit\'s retirement, but the idea of allowing sympathetic resonance from undamped strings was adopted into mechanisms that would disengage the dampers in various ways on early keyboard instruments such as the clavichord, called \"pantalon stops\".'),(18,'Scarf',14,'scarf','en',NULL,'yes','A scarf, also known as a Kremer, muffler or neck-wrap, is a piece of fabric worn around the neck, or near the head or around the waist for warmth, cleanliness, fashion or religious reasons. They can come in a variety of different colours.'),(19,'Make Up',0,'make_up','en','157998185.jpg','no','osmetics, also known as makeup or make-up, are care substances used to enhance the appearance or odor of the human body. They are generally mixtures of chemical compounds, some being derived from natural sources (such as coconut oil) and many being synthetics.[1]\r\n\r\nIn the U.S., the Food and Drug Administration (FDA), which regulates cosmetics,[2] defines cosmetics as \"intended to be applied to the human body for cleansing, beautifying, promoting attractiveness, or altering the appearance without affecting the body\'s structure or functions.\" This broad definition includes any material intended for use as a component of a cosmetic product. The FDA specifically excludes soap from this category.[3]'),(20,'Shoses',0,'shoses','en','lebron-10-x-blue-gold-red-basketball-shoes_04.jpg','yes','A shoe is an item of footwear intended to protect and comfort the human foot while doing various activities. Shoes are also used as an item of decoration. The design of shoes has varied enormously through time and from culture to culture, with appearance originally being tied to function. Additionally, fashion has often dictated many design elements, such as whether shoes have very high heels or flat ones. Contemporary footwear varies widely in style, complexity and cost. Basic sandals may consist of only a thin sole and simple strap. High fashion shoes may be made of very expensive materials in complex construction and sell for thousands of dollars a pair. Other shoes are for very specific purposes, such as boots designed specifically for mountaineering or skiing.\r\n\r\nTraditionally, shoes have been made from leather, wood or canvas, but are increasingly made from rubber, plastics, and other petrochemical-derived materials.\r\n\r\nThe foot contains more bones than any other single part of the body. Though it has evolved over hundreds of thousands of years in relation to vastly varied terrain and climate conditions, the foot is still vulnerable to environmental hazards such as sharp rocks and hot ground, against which, shoes can protect.'),(21,'Accessories',0,'accessories','en','accessories-3.jpg','yes','Accessories are the difference that make the difference. Accessories have the power to turn an okay outfit into an outstanding one, to from “yeah” \r\nAdding accessories isn’t something to be done Just For Good – accessorising is for Every Day.  When you get into the swing of it, adding an accessory, or two, or three, will feel like a natural way to complete an outfit, even if you’re working from home and no-one but the postman and the cat will see what you’re wearing. You’ll not only see it, but you’ll feel it – and that is a great reason to wear more accessories!\r\n'),(22,'Bags',0,'bags','en','i_only_look_like_a_lesbian_white_png_messenger_bag-r466fc174166a4183877d155229358fa7_2ikjn_8byvr_324.jpg','yes','A bag (also known regionally as a sack) is a common tool in the form of a non-rigid container. The use of bags predates recorded history, with the earliest bags being no more than lengths of animal skin, cotton, or woven plant fibers, folded up at the edges and secured in that shape with strings of the same material.[1] Despite their simplicity, bags have been fundamental for the development of human civilization, as they allow people to easily collect loose materials such as berries or food grains, and to transport more items than could readily be carried in the hands.[1] The word probably has its origins in the Norse word baggi,[2] from the reconstructed Proto-Indo-European bʰak, but is also comparable to the Welsh baich (load, bundle), and the Greek βάσταγμα (bástagma, load).\r\n\r\nCheap disposable paper bags and plastic shopping bags are very common in the retail trade as a convenience for shoppers, and are often supplied by the shop for free or for a small fee. Customers may also take their own shopping bags to some shops. Although paper had been used for purposes of wrapping and padding in ancient China since the 2nd century BC,[3] the first use of paper bags (for preserving the flavor of tea) in China came during the later Tang Dynasty (618–907 AD)'),(23,'Watches',0,'watches','en','intro.jpg','yes','A watch is a small timepiece intended to be carried or worn by a person. It is designed to keep working despite the motions caused by the person\'s activities. A wristwatch is designed to be worn on a wrist, attached by a watch strap or other type of bracelet. A pocket watch is designed for a person to carry in a pocket.\r\n\r\nWatches evolved in the 17th century from spring-powered clocks, which appeared as early as the 14th century. The first watches were strictly mechanical, driven by clockwork. As technology progressed, mechanical devices, used to control the speed of the watch, were largely superseded by vibrating quartz crystals that produce accurately timed electronic pulses.[2] Some watches use radio clock technology to regularly correct the time. The first digital electronic watch was developed in 1970.[3]\r\n\r\nMost inexpensive and medium-priced watches, used mainly for timekeeping, are electronic watches with quartz movements.[2] Expensive collectible watches, valued more for their elaborate craftsmanship, aesthetic appeal and glamorous design than for simple timekeeping, often have purely mechanical movements and are powered by springs, even though these movements are generally less accurate and more expensive than electronic ones. Various extra features, called \"complications\", such as moon-phase displays and the different types of tourbillon, are sometimes included.[4] Modern watches often display the day, date, month and year, and electronic watches may have many other functions. Time-related features such as timers, chronographs and alarm functions are common. Some modern designs incorporate calculators, GPS[5] and Bluetooth technology or have heart-rate monitoring capabilities. Watches incorporating GPS receivers use them not only to determine their position. They also receive and use time signals from the satellites, which make them essentially perfectly accurate timekeepers, even over long periods of time.\r\n\r\nThe study of timekeeping is known as horology.'),(24,'Glasses',0,'glasses','en','oc_042115_sunglasses_x0y0_p1.jpg','yes','Glasses, also known as eyeglasses or spectacles, are frames bearing lenses worn in front of the eyes used for vision correction.\r\n\r\nSafety glasses are a kind of eye protection against flying debris or against visible and near visible light or radiation. Sunglasses allow better vision in bright daylight, and may protect one\'s eyes against damage from high levels of ultraviolet light. Specialized glasses may be used for viewing specific visual information (such as stereoscopy). Sometimes glasses are worn simply for aesthetic or fashion purposes.'),(25,'Avon',19,'avon','en',NULL,'yes','osmetics, also known as makeup or make-up, are care substances used to enhance the appearance or odor of the human body. They are generally mixtures of chemical compounds, some being derived from natural sources (such as coconut oil) and many being synthetics.[1]\r\n\r\nIn the U.S., the Food and Drug Administration (FDA), which regulates cosmetics,[2] defines cosmetics as \"intended to be applied to the human body for cleansing, beautifying, promoting attractiveness, or altering the appearance without affecting the body\'s structure or functions.\" This broad definition includes any material intended for use as a component of a cosmetic product. The FDA specifically excludes soap from this category.[3]'),(26,'Oriflim',19,'oriflim','en',NULL,'yes','osmetics, also known as makeup or make-up, are care substances used to enhance the appearance or odor of the human body. They are generally mixtures of chemical compounds, some being derived from natural sources (such as coconut oil) and many being synthetics.[1]\r\n\r\nIn the U.S., the Food and Drug Administration (FDA), which regulates cosmetics,[2] defines cosmetics as \"intended to be applied to the human body for cleansing, beautifying, promoting attractiveness, or altering the appearance without affecting the body\'s structure or functions.\" This broad definition includes any material intended for use as a component of a cosmetic product. The FDA specifically excludes soap from this category.[3]'),(27,'My way',19,'my_way','en',NULL,'yes','osmetics, also known as makeup or make-up, are care substances used to enhance the appearance or odor of the human body. They are generally mixtures of chemical compounds, some being derived from natural sources (such as coconut oil) and many being synthetics.[1]\r\n\r\nIn the U.S., the Food and Drug Administration (FDA), which regulates cosmetics,[2] defines cosmetics as \"intended to be applied to the human body for cleansing, beautifying, promoting attractiveness, or altering the appearance without affecting the body\'s structure or functions.\" This broad definition includes any material intended for use as a component of a cosmetic product. The FDA specifically excludes soap from this category.[3]'),(28,'Chanel',24,'chanel','en',NULL,'yes','osmetics, also known as makeup or make-up, are care substances used to enhance the appearance or odor of the human body. They are generally mixtures of chemical compounds, some being derived from natural sources (such as coconut oil) and many being synthetics.[1]\r\n\r\nIn the U.S., the Food and Drug Administration (FDA), which regulates cosmetics,[2] defines cosmetics as \"intended to be applied to the human body for cleansing, beautifying, promoting attractiveness, or altering the appearance without affecting the body\'s structure or functions.\" This broad definition includes any material intended for use as a component of a cosmetic product. The FDA specifically excludes soap from this category.[3]'),(29,'Brada',24,'brada','en',NULL,'yes','osmetics, also known as makeup or make-up, are care substances used to enhance the appearance or odor of the human body. They are generally mixtures of chemical compounds, some being derived from natural sources (such as coconut oil) and many being synthetics.[1]\r\n\r\nIn the U.S., the Food and Drug Administration (FDA), which regulates cosmetics,[2] defines cosmetics as \"intended to be applied to the human body for cleansing, beautifying, promoting attractiveness, or altering the appearance without affecting the body\'s structure or functions.\" This broad definition includes any material intended for use as a component of a cosmetic product. The FDA specifically excludes soap from this category.[3]'),(30,'GUCCI',24,'gucci','en',NULL,'yes','osmetics, also known as makeup or make-up, are care substances used to enhance the appearance or odor of the human body. They are generally mixtures of chemical compounds, some being derived from natural sources (such as coconut oil) and many being synthetics.[1]\r\n\r\nIn the U.S., the Food and Drug Administration (FDA), which regulates cosmetics,[2] defines cosmetics as \"intended to be applied to the human body for cleansing, beautifying, promoting attractiveness, or altering the appearance without affecting the body\'s structure or functions.\" This broad definition includes any material intended for use as a component of a cosmetic product. The FDA specifically excludes soap from this category.[3]'),(31,'Dior',24,'dior','en',NULL,'yes','osmetics, also known as makeup or make-up, are care substances used to enhance the appearance or odor of the human body. They are generally mixtures of chemical compounds, some being derived from natural sources (such as coconut oil) and many being synthetics.[1]\r\n\r\nIn the U.S., the Food and Drug Administration (FDA), which regulates cosmetics,[2] defines cosmetics as \"intended to be applied to the human body for cleansing, beautifying, promoting attractiveness, or altering the appearance without affecting the body\'s structure or functions.\" This broad definition includes any material intended for use as a component of a cosmetic product. The FDA specifically excludes soap from this category.[3]'),(32,'Ray Pan',24,'ray_pan','en',NULL,'yes','osmetics, also known as makeup or make-up, are care substances used to enhance the appearance or odor of the human body. They are generally mixtures of chemical compounds, some being derived from natural sources (such as coconut oil) and many being synthetics.[1]\r\n\r\nIn the U.S., the Food and Drug Administration (FDA), which regulates cosmetics,[2] defines cosmetics as \"intended to be applied to the human body for cleansing, beautifying, promoting attractiveness, or altering the appearance without affecting the body\'s structure or functions.\" This broad definition includes any material intended for use as a component of a cosmetic product. The FDA specifically excludes soap from this category.[3]'),(33,'Activ',20,'activ','en',NULL,'yes',''),(34,'CAT',20,'cat','en',NULL,'yes',''),(35,'Nike',20,'nike','en',NULL,'yes',''),(36,'Rockport',20,'rockport','en',NULL,'yes',''),(37,'GUCCI',20,'gucci','en',NULL,'yes',''),(38,'Hand made',21,'hand_made','en',NULL,'yes',''),(39,'Silver',21,'silver','en',NULL,'yes',''),(40,'Paltin',21,'platin','en',NULL,'yes',''),(41,'Men',22,'men','en',NULL,'yes',''),(42,'Children',22,'children','en',NULL,'yes',''),(43,'Women',22,'women','en',NULL,'yes',''),(44,'EXOTIC',23,'exotic','en',NULL,'yes',''),(45,'BALMAIN',23,'balmain','en',NULL,'yes',''),(46,'ZEADES',23,'zeads','en',NULL,'yes','1- Is a Rolex worth the high price? <br>\r\nThere are two possible answers to this question, and I still haven\'t figured out which one is right. Why do some people automatically say \"no\"? Because the Rolex corporation artificially inflates the price of its watches by limiting the yearly supply of some of its collections (the Daytona is notorious for being near impossible to find), leading to scarcity in the market. It is a strategy similar to the one employed by De Beers, the world\'s largest diamond retailer, which limits the supply of diamonds on the market to keep prices high (even if De Beers has plenty stored in its safes).\r\nRolex also meticulously (and some say dictatorially) controls its authorized dealer system to make sure that all watches are sold at its suggested retail price. Any dealer that sells a Rolex at a discount is subject to having his dealer status revoked. So since it is nearly impossible to get a new real Rolex at a discount, you will always pay a premium for the name (thanks to smart marketing by Rolex execs) and not necessarily for the craftsmanship (though it is still very high). That is why many watch experts say that, for the cost of a Rolex, you can get a higher caliber mechanical watch from a different company.\r\n<br>\r\nOn the other hand, some firmly believe that a Rolex is worth the price because it is still a premium watch made with the highest level of craftsmanship. The artificially inflated prices also help Rolexes maintain their extremely high resale value. And, of course, you can\'t underestimate the cachet value of a Rolex. The status and prestige it projects can, in certain people\'s eyes, justify its exorbitant price. More than any other regularly produced watch, owning a Rolex is an investment and a status symbol, more than it is a teller of time. If you want to buy a watch purely on its mechanical merits, nothing beats a Piaget or a Jaeger.\r\n<br>\r\n2- What do \"chronometer\" and \"chronograph\" mean?<br>\r\nChronometer is a designation given to a watch that has the highest standard of precision. The designation is given to automatic and mechanical movement watches, not those that run with quartz movement. A watch carrying the chronometer certification has passed vigorous tests demanded by the Swiss Official Chronometer Control (COSC).'),(47,'JOVIAL',23,'JOVIAL','en',NULL,'yes',''),(48,'CALVIN KLEIN',23,'CALVIN KLEIN','en',NULL,'yes',''),(49,'RADO',23,'RADO','en',NULL,'yes',''),(51,'Tablets',0,'tablets','en','811ze7epmxl._sl1500__.jpg','yes',''),(52,'Nikon',12,'nikon','en',NULL,'yes',''),(53,'Canon',12,'canon','en',NULL,'yes',''),(54,'Samsung',12,'Samsung','en',NULL,'yes',''),(55,'Sony',12,'Sony','en',NULL,'yes',''),(56,'Fujistu',12,'Fujistu','en',NULL,'yes',''),(57,'Nokia',9,'nokia','en',NULL,'yes',''),(58,'Samsung',9,'samsung','en',NULL,'yes',''),(59,'Lenovo',9,'Lenovo','en',NULL,'yes',''),(60,'HP',10,'HP','en',NULL,'yes',''),(61,'DELL',10,'DELL','en',NULL,'yes',''),(62,'Toshiba',10,'Toshiba','en',NULL,'yes',''),(63,'Samsung',10,'samsung','en',NULL,'yes',''),(64,'Samsung',51,'samsung_','en',NULL,'yes',''),(65,'Apple',51,'apple','en',NULL,'yes',''),(66,'Addidas',20,'addidas','en',NULL,'yes','');

/*Table structure for table `commerce_category_attributes` */

DROP TABLE IF EXISTS `commerce_category_attributes`;

CREATE TABLE `commerce_category_attributes` (
  `commerce_category_attribute_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) CHARACTER SET latin1 DEFAULT NULL,
  `commerce_category_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`commerce_category_attribute_id`),
  KEY `category_id` (`commerce_category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `commerce_category_attributes` */

/*Table structure for table `commerce_invoices` */

DROP TABLE IF EXISTS `commerce_invoices`;

CREATE TABLE `commerce_invoices` (
  `commerce_invoice_id` int(11) NOT NULL AUTO_INCREMENT,
  `commerce_order_id` int(11) DEFAULT NULL,
  `status` enum('paied','unpaied') DEFAULT NULL,
  PRIMARY KEY (`commerce_invoice_id`),
  KEY `order_id` (`commerce_order_id`),
  KEY `order_id_2` (`commerce_order_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `commerce_invoices` */

insert  into `commerce_invoices`(`commerce_invoice_id`,`commerce_order_id`,`status`) values (1,7,''),(2,8,'');

/*Table structure for table `commerce_order_details` */

DROP TABLE IF EXISTS `commerce_order_details`;

CREATE TABLE `commerce_order_details` (
  `commerce_order_detail_id` int(11) NOT NULL AUTO_INCREMENT,
  `option` text,
  `qty` int(11) DEFAULT NULL,
  `weight` float DEFAULT NULL,
  `commerce_product_id` int(11) DEFAULT NULL,
  `price` double DEFAULT NULL,
  `product_total` double DEFAULT NULL,
  `commerce_order_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`commerce_order_detail_id`),
  KEY `product_id` (`commerce_product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `commerce_order_details` */

insert  into `commerce_order_details`(`commerce_order_detail_id`,`option`,`qty`,`weight`,`commerce_product_id`,`price`,`product_total`,`commerce_order_id`) values (1,NULL,1,0,22,3360,3360,6),(2,NULL,4,0,22,3360,13440,7),(3,NULL,2,0,38,2500,5000,8),(4,NULL,1,0,27,3000,3000,8);

/*Table structure for table `commerce_orders` */

DROP TABLE IF EXISTS `commerce_orders`;

CREATE TABLE `commerce_orders` (
  `commerce_order_id` int(11) NOT NULL AUTO_INCREMENT,
  `subtotal` float DEFAULT NULL,
  `total` float DEFAULT NULL,
  `commerce_payment_method_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `billing_address` text,
  `shipping_address` text,
  `created` datetime DEFAULT NULL,
  `status` enum('pending','confirmed') DEFAULT NULL,
  PRIMARY KEY (`commerce_order_id`),
  KEY `user_id` (`user_id`),
  KEY `payment_method_id` (`commerce_payment_method_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

/*Data for the table `commerce_orders` */

insert  into `commerce_orders`(`commerce_order_id`,`subtotal`,`total`,`commerce_payment_method_id`,`user_id`,`billing_address`,`shipping_address`,`created`,`status`) values (1,0,0,NULL,NULL,NULL,NULL,NULL,NULL),(2,0,0,NULL,NULL,NULL,NULL,NULL,NULL),(3,3360,3360,2,30,'84 faisal city, sedibishr','84 faisal city, sedibishr',NULL,'confirmed'),(4,3360,3360,2,30,'84 faisal city, sedibishr','84 faisal city, sedibishr',NULL,'confirmed'),(5,3360,3360,2,30,'84 faisal city, sedibishr','84 faisal city, sedibishr',NULL,'confirmed'),(6,3360,3360,2,30,'84 faisal city, sedibishr','84 faisal city, sedibishr',NULL,'confirmed'),(7,13440,13440,2,30,'84 faisal city, sedibishr','84 faisal city, sedibishr',NULL,'confirmed'),(8,8000,8000,2,30,'84 faisal city, sedibishr','84 faisal city, sedibishr',NULL,'confirmed');

/*Table structure for table `commerce_payment_method` */

DROP TABLE IF EXISTS `commerce_payment_method`;

CREATE TABLE `commerce_payment_method` (
  `commerce_payment_method_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `fees` double DEFAULT NULL,
  `image` varchar(225) DEFAULT NULL,
  `settings` text,
  PRIMARY KEY (`commerce_payment_method_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `commerce_payment_method` */

insert  into `commerce_payment_method`(`commerce_payment_method_id`,`name`,`fees`,`image`,`settings`) values (1,'Paypal',NULL,NULL,NULL),(2,'Cash on delivery',NULL,NULL,NULL);

/*Table structure for table `commerce_product_attributes` */

DROP TABLE IF EXISTS `commerce_product_attributes`;

CREATE TABLE `commerce_product_attributes` (
  `commerce_product_attribute_id` int(11) NOT NULL AUTO_INCREMENT,
  `commerce_category_attribute_id` int(11) DEFAULT NULL,
  `value` text,
  `commerce_product_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`commerce_product_attribute_id`),
  KEY `category_attribute_id` (`commerce_category_attribute_id`),
  KEY `product_id` (`commerce_product_id`),
  KEY `product_id_2` (`commerce_product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `commerce_product_attributes` */

/*Table structure for table `commerce_product_detail_options` */

DROP TABLE IF EXISTS `commerce_product_detail_options`;

CREATE TABLE `commerce_product_detail_options` (
  `commerce_product_detail_option_id` int(11) NOT NULL AUTO_INCREMENT,
  `commerce_product_detail_id` int(11) DEFAULT NULL,
  `name` text,
  `price` double DEFAULT NULL,
  PRIMARY KEY (`commerce_product_detail_option_id`),
  KEY `product_detail_id` (`commerce_product_detail_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `commerce_product_detail_options` */

/*Table structure for table `commerce_product_details` */

DROP TABLE IF EXISTS `commerce_product_details`;

CREATE TABLE `commerce_product_details` (
  `commerce_product_detail_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text,
  `commerce_product_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`commerce_product_detail_id`),
  KEY `product_id` (`commerce_product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `commerce_product_details` */

/*Table structure for table `commerce_product_images` */

DROP TABLE IF EXISTS `commerce_product_images`;

CREATE TABLE `commerce_product_images` (
  `commerce_product_image_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_image` text,
  `primary` tinyint(4) DEFAULT NULL,
  `commerce_product_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`commerce_product_image_id`)
) ENGINE=InnoDB AUTO_INCREMENT=82 DEFAULT CHARSET=utf8;

/*Data for the table `commerce_product_images` */

insert  into `commerce_product_images`(`commerce_product_image_id`,`product_image`,`primary`,`commerce_product_id`) values (19,'mf8if24rb4l.jpg',NULL,NULL),(21,'left_angle.jpg',NULL,NULL),(31,'dell-inspiron-im501r-1212lpk-laptop-with-amd-athlon-ii1.jpg',NULL,8),(32,'mf8if24rb4l1.jpg',NULL,7),(33,'hp_pavilion_x360_021.jpg',NULL,9),(34,'72157605564604036_model_huge_9b35338624.jpg',NULL,10),(35,'32250_1_l1.jpg',NULL,11),(36,'adidas-shoes-adidas-big-tongue-small-broken-flowe-37_lrg.jpg',NULL,12),(37,'lenovo-vibe-z.jpg',NULL,6),(38,'tablet_samsung_galaxy_p3100_branco__39919_zoom.jpg',NULL,15),(39,'lenovo-tab-a8_400-wide.jpg',NULL,16),(40,'k2-_b8d5815c-d743-4737-86d9-e5933879500b.v1.jpg-2d9a0761d585bd6319313f9606e011ff1b272b55-optim-500x500.jpg',NULL,17),(41,'41scbxa8eel.jpg',NULL,18),(42,'cemc189_mercury_av_quick_case_samsung_tablet_4_10_black.jpg',NULL,19),(43,'adidas-shoes-adidas-js-wings-shoes-for-girls-pink-22_6_lrg1.jpg',NULL,20),(44,'samsung-galaxy-grand-duos-i9082-mobile-phone-samsung-bhm1300-bluetooth-blue-medium_46aaf4dd26d85c84d7c3a8bfc4d70ac6.jpg',NULL,13),(45,'samsung_galaxy_s4_android_touchscreen_synaptic_mobile_phone_photos_img_image_14.jpg',NULL,21),(46,'xperia-m5-gold-1280x840.jpg-683013dca1c4f71783a7cd2ec24354f4.jpg',NULL,22),(47,'lenovo-yoga-y-11-laptop-nvidia-tegra-t30-2gb-64gb-ssd-11-6-inch-win-8-rt-razor-grey-with-laptop-bag1.jpg',NULL,23),(48,'lenovo-image-15.jpg',NULL,24),(49,'hp-pavilion-hdx.jpg',NULL,25),(50,'party-rock-shoes-women-stacked_web1.jpg',NULL,26),(51,'lebron-10-x-blue-gold-red-basketball-shoes_041.jpg',NULL,14),(52,'sony-xperia-z2-android-lollipop1.jpg',NULL,27),(54,'1319394_sd.jpg',NULL,29),(55,'72157600289362064_model_huge_a35a7f15a1.jpg',NULL,30),(56,'sony-cybershot-digital-camera-wx200-pink-.jpg',NULL,31),(57,'41lfado-vyl._sx395_.jpg',NULL,32),(58,'image.jpg',NULL,33),(59,'o_women-s-super-beautiful-sun-glasses-sunglasses-with-box-75901.jpg',NULL,34),(60,'1408679313587.jpg',NULL,35),(61,'u0289l1-nc.jpg',NULL,36),(63,'silver-steel-wrist-watch-delano-gold-face-classic-brand-jbw-jb-6218-c-.jpg',NULL,38),(66,'automatic.png',NULL,40),(67,'watches.jpeg',NULL,37),(68,'omega-duty-free.jpg',NULL,39),(69,'u0289l1-nc1.jpg',NULL,39),(70,'iwc_pilots_watch1000x13001.jpeg',NULL,39),(71,'silver-steel-wrist-watch-delano-gold-face-classic-brand-jbw-jb-6218-c-1.jpg',NULL,39),(72,'omega-duty-free1.jpg',NULL,39),(73,'51d2i9is4wl._sl246_sx190_cr0-0-190-246_1.jpg',NULL,39),(77,'1895_011.jpg',NULL,4),(78,'xperia-z3-white-1240x840-430fa6376c394cf59a94a9edca67ed7d1.jpg',NULL,28),(79,'item_xl_6901759_46329356.jpg',NULL,28),(80,'item_xs_8334726_83440716.jpg',NULL,28),(81,'item_xs_8334726_83440746.jpg',NULL,28);

/*Table structure for table `commerce_products` */

DROP TABLE IF EXISTS `commerce_products`;

CREATE TABLE `commerce_products` (
  `commerce_product_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `commerce_category_id` int(11) DEFAULT NULL,
  `price` double DEFAULT NULL,
  `type` enum('normal','digital','weighted') DEFAULT NULL,
  `discount` float DEFAULT NULL,
  `description` text,
  `commerce_brand_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`commerce_product_id`),
  KEY `category_id` (`commerce_category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8;

/*Data for the table `commerce_products` */

insert  into `commerce_products`(`commerce_product_id`,`name`,`commerce_category_id`,`price`,`type`,`discount`,`description`,`commerce_brand_id`) values (2,'Camary',7,100,'normal',5,NULL,NULL),(4,'Galaxy Tab S2 9.7',48,1000,'normal',5,NULL,NULL),(5,'Sony',11,2200,'normal',8,NULL,NULL),(6,'Lenovo Xperia 7200',59,1800,'normal',10,NULL,NULL),(7,'Addidas 1',66,150,'normal',5,NULL,NULL),(8,'DELL dv6400',61,3500,'normal',20,NULL,NULL),(9,'HP dv900',60,3600,'normal',10,NULL,NULL),(10,'Nikon 600',52,2000,'normal',7,NULL,NULL),(11,'Canon 600',53,4000,'normal',10,NULL,NULL),(12,'addidas 2',66,180,'normal',3,NULL,NULL),(13,'Smamsung s3',58,900,'normal',7,NULL,NULL),(14,'Activ Shose',33,1800,'normal',10,NULL,NULL),(15,'Samsung tab 4',64,4000,'normal',20,NULL,NULL),(16,'Lenovo tab',64,1900,'normal',30,NULL,NULL),(17,'Tablet Apple 1',65,7000,'normal',10,NULL,NULL),(18,'Tablet Apple 2',65,9000,'normal',40,NULL,NULL),(19,'Samsung Tab 5',64,6000,'normal',40,NULL,NULL),(20,'Shose Nike',35,100,'normal',20,NULL,NULL),(21,'Samsung s4',58,2500,'normal',10,NULL,2),(22,'Sony Z2',13,4200,'normal',20,NULL,NULL),(23,'Laptop Lenovo',63,4000,'normal',20,NULL,NULL),(24,'Lenovo Laoptop3',61,3600,'normal',30,NULL,NULL),(25,'Laptop HP dv',60,5000,'normal',30,NULL,NULL),(26,'Nike Shose 4',35,200,'normal',20,NULL,NULL),(27,'Sony Experia 2',13,6000,'normal',50,NULL,NULL),(28,'Sony Experia z3',13,4200,'normal',30,'eades Chance Pendant with Taupe color <br>\r\nStrap width: 24 <br>\r\nMaterial : Leather & Metal <br>\r\nSize : Adjustable <br>\r\nMetal : Stainless Steel 316L <br>\r\nMetal Color : Steel <br>\r\nLeather Version : Graphic Black <br>\r\nShape : Round <br>\r\nCase diameter : 44 <br>\r\nCase Back : Screwed Down <br>\r\nFunctions : 24H Chrono Time & Date <br>\r\nMovement : Quartz <br>\r\nBattery : Standard <br>\r\nWater resistance : 5 <br>\r\nGlass : Mineral <br>\r\nStrap Material : Genuine Leather <br>\r\nStrap maximum length(mm) : 225 <br>\r\nStrap minimum length(mm) : 180 <br>\r\nWatch type buckle : Double Butterfly Buckle <br>',3),(29,'Camera Fujstu',56,6000,'normal',30,NULL,NULL),(30,'CAmera Sony 2',55,2000,'normal',40,NULL,NULL),(31,'Smsung Camera',54,900,'normal',20,NULL,NULL),(32,'Ray Pan Glasses 2',32,900,'normal',20,NULL,NULL),(33,'Dior Glasses',31,3500,'normal',60,NULL,NULL),(34,'Gucci Glasses ',30,1800,'normal',30,NULL,NULL),(35,'Dior 2',31,3000,'normal',70,NULL,NULL),(36,'Watch 1',46,3000,'normal',20,NULL,NULL),(37,'Watch2',46,2500,'normal',30,NULL,NULL),(38,'Watch 4',46,5000,'normal',50,NULL,NULL),(39,'Watch 6',46,4500,'normal',30,'eades Chance Pendant with Taupe color <br>\r\nStrap width: 24 <br>\r\nMaterial : Leather & Metal <br>\r\nSize : Adjustable <br>\r\nMetal : Stainless Steel 316L <br>\r\nMetal Color : Steel <br>\r\nLeather Version : Graphic Black <br>\r\nShape : Round <br>\r\nCase diameter : 44 <br>\r\nCase Back : Screwed Down <br>\r\nFunctions : 24H Chrono Time & Date <br>\r\nMovement : Quartz <br>\r\nBattery : Standard <br>\r\nWater resistance : 5 <br>\r\nGlass : Mineral <br>\r\nStrap Material : Genuine Leather <br>\r\nStrap maximum length(mm) : 225 <br>\r\nStrap minimum length(mm) : 180 <br>\r\nWatch type buckle : Double Butterfly Buckle <br>',1),(40,'Watch 4 ',46,6000,'normal',50,NULL,NULL);

/*Table structure for table `commerce_products_offers` */

DROP TABLE IF EXISTS `commerce_products_offers`;

CREATE TABLE `commerce_products_offers` (
  `commerce_products_offer_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `commerce_product_id` int(11) DEFAULT NULL,
  `offer_image` text,
  PRIMARY KEY (`commerce_products_offer_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

/*Data for the table `commerce_products_offers` */

insert  into `commerce_products_offers`(`commerce_products_offer_id`,`title`,`commerce_product_id`,`offer_image`) values (1,'Lenovo 7200',6,'bt_gm_lenovo-tablets_en_28092015.jpg'),(2,'addidas 1',7,'bt_f_adidas_newcollection_en_05102015.jpg.jpg'),(3,'glaxy tab',4,'bt_gm_xtouch-x4_en_28092015.jpg'),(4,'hp dv900',9,'sony_laptop.jpg'),(5,'dell',8,'dell-laptop-price-saudi-arabia.jpg');

/*Table structure for table `commerce_shares` */

DROP TABLE IF EXISTS `commerce_shares`;

CREATE TABLE `commerce_shares` (
  `commerce_shares_id` int(11) NOT NULL AUTO_INCREMENT,
  `from_title` varchar(255) DEFAULT NULL,
  `from_description` text,
  `from_image` text,
  `location` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `to_title` varchar(255) DEFAULT NULL,
  `to_description` text,
  `to_image` text,
  PRIMARY KEY (`commerce_shares_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `commerce_shares` */

insert  into `commerce_shares`(`commerce_shares_id`,`from_title`,`from_description`,`from_image`,`location`,`user_id`,`to_title`,`to_description`,`to_image`) values (1,'Lenovo Vibe','1 GB RAM, 1 GHz Processor, 16 GB Local storage ','lenovo-vibe-z1.jpg','',1,'Playstation 2','it must be with internal storage HD Drive ',NULL);

/*Table structure for table `commerce_wishlist` */

DROP TABLE IF EXISTS `commerce_wishlist`;

CREATE TABLE `commerce_wishlist` (
  `commerce_wishlist_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `commerce_product_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`commerce_wishlist_id`),
  KEY `product_id` (`commerce_product_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `commerce_wishlist` */

insert  into `commerce_wishlist`(`commerce_wishlist_id`,`user_id`,`commerce_product_id`) values (1,30,22);

/*Table structure for table `contactus` */

DROP TABLE IF EXISTS `contactus`;

CREATE TABLE `contactus` (
  `message_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` text NOT NULL,
  `message` text NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`message_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `contactus` */

/*Table structure for table `coupons_business` */

DROP TABLE IF EXISTS `coupons_business`;

CREATE TABLE `coupons_business` (
  `coupons_business_id` int(11) NOT NULL AUTO_INCREMENT,
  `coupons_business_type_id` int(11) DEFAULT NULL,
  `name` varchar(300) DEFAULT NULL,
  `logo` text,
  `email` varchar(350) DEFAULT NULL,
  `website` text,
  PRIMARY KEY (`coupons_business_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `coupons_business` */

/*Table structure for table `coupons_business_branches` */

DROP TABLE IF EXISTS `coupons_business_branches`;

CREATE TABLE `coupons_business_branches` (
  `coupons_business_branch_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(300) DEFAULT NULL,
  `coupons_country_id` int(11) DEFAULT NULL,
  `coupons_city_id` int(11) DEFAULT NULL,
  `address` text,
  `phone` varchar(100) DEFAULT NULL,
  `fax` varbinary(100) DEFAULT NULL,
  PRIMARY KEY (`coupons_business_branch_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `coupons_business_branches` */

/*Table structure for table `coupons_business_branches_availability` */

DROP TABLE IF EXISTS `coupons_business_branches_availability`;

CREATE TABLE `coupons_business_branches_availability` (
  `coupons_business_branches_availability_id` int(11) NOT NULL AUTO_INCREMENT,
  `day` enum('Sat','Sun','Mon','Tue','Wed','Thu','Fri') DEFAULT NULL,
  `from` time DEFAULT NULL,
  `to` time DEFAULT NULL,
  `coupons_business_branch_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`coupons_business_branches_availability_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `coupons_business_branches_availability` */

/*Table structure for table `coupons_business_types` */

DROP TABLE IF EXISTS `coupons_business_types`;

CREATE TABLE `coupons_business_types` (
  `coupons_business_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(300) DEFAULT NULL,
  `description` text,
  `image` text,
  PRIMARY KEY (`coupons_business_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `coupons_business_types` */

/*Table structure for table `coupons_cities` */

DROP TABLE IF EXISTS `coupons_cities`;

CREATE TABLE `coupons_cities` (
  `coupons_city_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(300) DEFAULT NULL,
  `coupons_country_id` int(11) DEFAULT NULL,
  `long` varchar(100) DEFAULT NULL,
  `lat` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`coupons_city_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `coupons_cities` */

/*Table structure for table `coupons_countries` */

DROP TABLE IF EXISTS `coupons_countries`;

CREATE TABLE `coupons_countries` (
  `coupons_country_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(300) DEFAULT NULL,
  PRIMARY KEY (`coupons_country_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `coupons_countries` */

/*Table structure for table `coupons_offer_locations` */

DROP TABLE IF EXISTS `coupons_offer_locations`;

CREATE TABLE `coupons_offer_locations` (
  `coupons_offer_location_id` int(11) NOT NULL AUTO_INCREMENT,
  `coupons_business_branch_id` int(11) DEFAULT NULL,
  `coupons_offer_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`coupons_offer_location_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `coupons_offer_locations` */

/*Table structure for table `coupons_offers` */

DROP TABLE IF EXISTS `coupons_offers`;

CREATE TABLE `coupons_offers` (
  `coupons_offer_id` int(11) NOT NULL AUTO_INCREMENT,
  `business_title` varchar(255) DEFAULT NULL,
  `clients_title` varchar(255) DEFAULT NULL,
  `description` text,
  `image` text,
  `type` enum('amount','percentage') DEFAULT NULL,
  `amount` double DEFAULT NULL,
  `percentage` double DEFAULT NULL,
  `location` enum('store','online') DEFAULT NULL,
  `website` text,
  `starts` date DEFAULT NULL,
  `ends` date DEFAULT NULL,
  `expire` date DEFAULT NULL,
  `publish` date DEFAULT NULL,
  `Redemption_method` enum('qr','coupon','others') DEFAULT NULL,
  `qr` text,
  `coupon` text,
  `others` text,
  `terms` text,
  PRIMARY KEY (`coupons_offer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `coupons_offers` */

/*Table structure for table `downloads` */

DROP TABLE IF EXISTS `downloads`;

CREATE TABLE `downloads` (
  `download_id` int(11) NOT NULL AUTO_INCREMENT,
  `language_id` varchar(3) DEFAULT NULL,
  `url` text,
  `image` text,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`download_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

/*Data for the table `downloads` */

insert  into `downloads`(`download_id`,`language_id`,`url`,`image`,`created`) values (6,'en','LinkdIn.com','desert.jpg','2015-07-14 17:44:05');

/*Table structure for table `email_templates` */

DROP TABLE IF EXISTS `email_templates`;

CREATE TABLE `email_templates` (
  `email_template_id` int(11) NOT NULL AUTO_INCREMENT,
  `email_type` enum('html','plain') DEFAULT 'plain',
  `language_id` varchar(3) DEFAULT NULL,
  `subject` varchar(300) DEFAULT NULL,
  `content` longtext,
  `attachments` text,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`email_template_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `email_templates` */

/*Table structure for table `enquiries` */

DROP TABLE IF EXISTS `enquiries`;

CREATE TABLE `enquiries` (
  `enquiry_id` int(11) NOT NULL AUTO_INCREMENT,
  `language_id` varchar(3) DEFAULT NULL,
  `seo` varchar(300) DEFAULT NULL,
  `name` varchar(500) DEFAULT NULL,
  `answer` text,
  `email` varchar(500) DEFAULT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `question` varchar(500) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `answered` datetime DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0= Pending, 1= Replied And Published, 3= Ignored',
  PRIMARY KEY (`enquiry_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `enquiries` */

/*Table structure for table `faqs` */

DROP TABLE IF EXISTS `faqs`;

CREATE TABLE `faqs` (
  `faq_id` int(11) NOT NULL AUTO_INCREMENT,
  `language_id` varchar(3) DEFAULT NULL,
  `question` text,
  `answer` longtext,
  `created` datetime DEFAULT NULL,
  `answered` datetime DEFAULT NULL,
  `visibility_status_id` tinyint(1) NOT NULL,
  PRIMARY KEY (`faq_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `faqs` */

insert  into `faqs`(`faq_id`,`language_id`,`question`,`answer`,`created`,`answered`,`visibility_status_id`) values (1,NULL,'               1    ','      1             ',NULL,NULL,1),(2,'en','Wie Alt Bist Du ?','11',NULL,NULL,1),(3,'en','How Are You ?','Fine','2015-07-09 14:24:46',NULL,1);

/*Table structure for table `keywords` */

DROP TABLE IF EXISTS `keywords`;

CREATE TABLE `keywords` (
  `keyword_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) DEFAULT NULL,
  `parent` int(11) DEFAULT '0',
  PRIMARY KEY (`keyword_id`),
  KEY `keyword_id` (`keyword_id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;

/*Data for the table `keywords` */

insert  into `keywords`(`keyword_id`,`name`,`parent`) values (1,'sshpass',0),(2,'Ubuntu',0),(3,'Debian',0),(4,'Photography',0),(5,'10 Stupid Things',0),(6,'css3',0),(7,'media queries',0),(8,'Ubuntu Server',0),(9,'LAMP',0),(10,'Apache',0),(11,'PHP',0),(12,'MySQL',0),(13,'how to install lamp',0),(14,'how to install apache php mysql',0),(15,'Update Firefox',0),(16,'Update',0),(17,'Virtual host',0),(18,'Configuration',0),(19,'Linux',0),(20,'Unix',0),(21,'difference between linux and unix',0),(22,'Infinite loops',0),(23,'Virtual table',0),(24,'Query',0),(25,'Arduino Uno',0),(26,'Launchpad',0),(27,'TM4C123G',0),(28,'Pertol',0),(29,'FUEL',0);

/*Table structure for table `languages` */

DROP TABLE IF EXISTS `languages`;

CREATE TABLE `languages` (
  `language_id` varchar(3) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `code` varchar(3) DEFAULT NULL,
  `path` varchar(20) DEFAULT NULL,
  `default` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`language_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `languages` */

insert  into `languages`(`language_id`,`name`,`code`,`path`,`default`) values ('1','English','en','english',1),('2','عربي','ar','arabic',0);

/*Table structure for table `link_types` */

DROP TABLE IF EXISTS `link_types`;

CREATE TABLE `link_types` (
  `link_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`link_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `link_types` */

insert  into `link_types`(`link_type_id`,`name`) values (1,'Header'),(2,'Footer');

/*Table structure for table `links` */

DROP TABLE IF EXISTS `links`;

CREATE TABLE `links` (
  `link_id` int(11) NOT NULL AUTO_INCREMENT,
  `link_type_id` int(11) NOT NULL,
  `name` varchar(200) DEFAULT NULL,
  `url` text,
  `var` text,
  `visibility_status_id` int(11) NOT NULL DEFAULT '0' COMMENT '0=invisible, 1=visible',
  `sort` int(11) DEFAULT NULL,
  PRIMARY KEY (`link_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

/*Data for the table `links` */

insert  into `links`(`link_id`,`link_type_id`,`name`,`url`,`var`,`visibility_status_id`,`sort`) values (1,1,'Home','{url}','home',1,NULL),(2,1,'Portfolio','{url}portfolio','portfolio',1,NULL),(3,1,'Resume','{url}resume','resume',1,NULL),(5,1,'FAQ','{url}faq','faq',1,NULL),(6,1,'Contact','{url}contact','contact',1,NULL),(11,1,'About','https://bitbucket.org/melsaeed/brighterycms/commits/f2a13cf25605d307d545cc11909f8eec7d937501','About',2,1);

/*Table structure for table `logs` */

DROP TABLE IF EXISTS `logs`;

CREATE TABLE `logs` (
  `log_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `module` varchar(150) DEFAULT NULL,
  `action` varchar(200) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `logs` */

/*Table structure for table `marital_status` */

DROP TABLE IF EXISTS `marital_status`;

CREATE TABLE `marital_status` (
  `marital_status_id` int(11) NOT NULL AUTO_INCREMENT,
  `language_id` varchar(3) DEFAULT NULL,
  `name` varbinary(300) DEFAULT NULL,
  PRIMARY KEY (`marital_status_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `marital_status` */

insert  into `marital_status`(`marital_status_id`,`language_id`,`name`) values (1,NULL,'Single'),(2,NULL,'Married');

/*Table structure for table `modules` */

DROP TABLE IF EXISTS `modules`;

CREATE TABLE `modules` (
  `module_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `raw_name` varchar(100) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `settings` text,
  PRIMARY KEY (`module_id`),
  UNIQUE KEY `unique_raw_name` (`raw_name`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

/*Data for the table `modules` */

insert  into `modules`(`module_id`,`name`,`raw_name`,`status`,`settings`) values (1,'Home','home',1,'{\"default_home_page\":\"home\"}'),(2,'Users','users',1,NULL),(3,'Pages','About',1,NULL),(4,'Contact','Contact',1,NULL),(5,'Clinic','clinic',1,NULL);

/*Table structure for table `nationalities` */

DROP TABLE IF EXISTS `nationalities`;

CREATE TABLE `nationalities` (
  `nationality_id` int(11) NOT NULL AUTO_INCREMENT,
  `language_id` varchar(3) DEFAULT NULL,
  `name` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`nationality_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `nationalities` */

insert  into `nationalities`(`nationality_id`,`language_id`,`name`) values (1,'en','Egyption'),(2,'en','Germany'),(3,'en','England'),(4,'en','Lebanon');

/*Table structure for table `news_categories` */

DROP TABLE IF EXISTS `news_categories`;

CREATE TABLE `news_categories` (
  `news_category_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  PRIMARY KEY (`news_category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `news_categories` */

/*Table structure for table `news_posts` */

DROP TABLE IF EXISTS `news_posts`;

CREATE TABLE `news_posts` (
  `news_post_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL,
  `content` longtext NOT NULL,
  `image` tinytext NOT NULL,
  `news_category_id` int(11) NOT NULL,
  `seo` varchar(200) NOT NULL,
  PRIMARY KEY (`news_post_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `news_posts` */

/*Table structure for table `notifications` */

DROP TABLE IF EXISTS `notifications`;

CREATE TABLE `notifications` (
  `notification_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `content` text,
  `link` text,
  `created` datetime DEFAULT NULL,
  `status` enum('unread','read') DEFAULT NULL,
  PRIMARY KEY (`notification_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `notifications` */

/*Table structure for table `pages` */

DROP TABLE IF EXISTS `pages`;

CREATE TABLE `pages` (
  `page_id` int(11) NOT NULL AUTO_INCREMENT,
  `language_id` varchar(3) DEFAULT NULL,
  `title` varchar(300) DEFAULT NULL,
  `seo` varchar(150) DEFAULT NULL,
  `content` longtext,
  `created` datetime DEFAULT NULL,
  `visibility_status_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`page_id`),
  UNIQUE KEY `seo` (`seo`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `pages` */

insert  into `pages`(`page_id`,`language_id`,`title`,`seo`,`content`,`created`,`visibility_status_id`) values (1,'en','About2222','about','<p>cczxceeeeeeeeeeeeee</p>\r\n','2015-06-04 15:30:33',1),(2,NULL,'ddd','ssss','<p>eeeeeeeeeeee</p>\r\n','2015-07-16 14:33:38',1),(3,NULL,'سسسس','سسسسسسسسسسسسس','<p>سسس</p>\r\n','2015-07-16 15:41:30',2),(4,NULL,'ndhh','hdhh','<p>dhhdhh</p>\r\n','2015-07-23 14:55:33',2);

/*Table structure for table `pm_announcements` */

DROP TABLE IF EXISTS `pm_announcements`;

CREATE TABLE `pm_announcements` (
  `pm_announce_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(225) NOT NULL,
  `content` longtext NOT NULL,
  `time` datetime NOT NULL,
  PRIMARY KEY (`pm_announce_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

/*Data for the table `pm_announcements` */

insert  into `pm_announcements`(`pm_announce_id`,`title`,`content`,`time`) values (6,'VIP','Please Put Your Content Here ! ','1899-11-09 00:00:00'),(9,'Hello',' Hello Hello Hello Hello ','0000-00-00 00:00:00'),(12,'CMS','Project Project Project Project Project Project ','0000-00-00 00:00:00');

/*Table structure for table `pm_attachments` */

DROP TABLE IF EXISTS `pm_attachments`;

CREATE TABLE `pm_attachments` (
  `pm_attachment_id` int(11) NOT NULL AUTO_INCREMENT,
  `file_name` text NOT NULL,
  `count` int(11) NOT NULL,
  `attachment_type` enum('issue','comment') NOT NULL,
  `uploaded_time` datetime NOT NULL,
  `type` varchar(255) NOT NULL,
  `pm_issue_id` int(11) NOT NULL,
  PRIMARY KEY (`pm_attachment_id`)
) ENGINE=InnoDB AUTO_INCREMENT=110 DEFAULT CHARSET=utf8;

/*Data for the table `pm_attachments` */

insert  into `pm_attachments`(`pm_attachment_id`,`file_name`,`count`,`attachment_type`,`uploaded_time`,`type`,`pm_issue_id`) values (100,'up.jpg',0,'issue','2015-10-13 18:05:30','',0),(101,'toystory.jpg',0,'issue','2015-10-13 18:05:30','',0),(102,'nemo.jpg',0,'issue','2015-10-13 18:05:30','',0),(105,'toystory1.jpg',0,'issue','2015-10-13 18:07:27','',65),(106,'nemo2.jpg',0,'issue','2015-10-13 18:07:56','',66),(107,'walle.jpg',0,'issue','2015-10-13 18:07:56','',66),(108,'nemo3.jpg',0,'issue','2015-10-13 18:38:47','',67),(109,'up1.jpg',0,'issue','2015-10-13 18:52:10','',68);

/*Table structure for table `pm_clients` */

DROP TABLE IF EXISTS `pm_clients`;

CREATE TABLE `pm_clients` (
  `pm_client_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `image` varchar(225) NOT NULL,
  `mobile` varchar(100) NOT NULL,
  `job` varchar(100) NOT NULL,
  `work_address` varchar(200) NOT NULL,
  `company_name` varchar(150) NOT NULL,
  `join_date` datetime NOT NULL,
  PRIMARY KEY (`pm_client_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `pm_clients` */

/*Table structure for table `pm_comments` */

DROP TABLE IF EXISTS `pm_comments`;

CREATE TABLE `pm_comments` (
  `pm_comment_id` int(11) NOT NULL AUTO_INCREMENT,
  `pm_issue_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment` longtext NOT NULL,
  `time` datetime DEFAULT NULL,
  `parent` longtext,
  PRIMARY KEY (`pm_comment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `pm_comments` */

/*Table structure for table `pm_departments` */

DROP TABLE IF EXISTS `pm_departments`;

CREATE TABLE `pm_departments` (
  `pm_department_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(225) NOT NULL,
  `time` datetime NOT NULL,
  `description` longtext NOT NULL,
  PRIMARY KEY (`pm_department_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

/*Data for the table `pm_departments` */

insert  into `pm_departments`(`pm_department_id`,`title`,`time`,`description`) values (10,'Web & Mobile Applications','0000-00-00 00:00:00','Unwilling departure education is be dashwoods or an. Use off agreeable law unwilling sir deficient curiosity instantly. Easy mind life fact with see has bore ten. Parish any chatty can elinor direct for former. Up as meant widow equal an share least.\r\nFolly words widow one downs few age every seven. If miss part by fact he park just shew. Discovered had get considered projection who favourable. Necessary up knowledge it tolerably.'),(11,'Web Development','0000-00-00 00:00:00','Unwilling departure education is be dashwoods or an. Use off agreeable law unwilling sir deficient curiosity instantly. Easy mind life fact with see has bore ten. Parish any chatty can elinor direct for former. Up as meant widow equal an share least.\r\nFolly words widow one downs few age every seven. If miss part by fact he park just shew. Discovered had get considered projection who favourable. Necessary up knowledge it tolerably.');

/*Table structure for table `pm_history` */

DROP TABLE IF EXISTS `pm_history`;

CREATE TABLE `pm_history` (
  `pm_history_id` int(11) NOT NULL AUTO_INCREMENT,
  `pm_issue_id` int(11) NOT NULL,
  `actions` enum('assign','forward','start','pause','done') NOT NULL,
  `from_user_id` int(11) NOT NULL,
  `to_user_id` int(11) NOT NULL,
  `datetime` datetime NOT NULL,
  PRIMARY KEY (`pm_history_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `pm_history` */

insert  into `pm_history`(`pm_history_id`,`pm_issue_id`,`actions`,`from_user_id`,`to_user_id`,`datetime`) values (1,0,'assign',0,30,'0000-00-00 00:00:00'),(2,68,'assign',30,3,'2015-10-13 18:52:10');

/*Table structure for table `pm_infractions` */

DROP TABLE IF EXISTS `pm_infractions`;

CREATE TABLE `pm_infractions` (
  `pm_infraction_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `pm_issue_id` int(11) NOT NULL,
  `reson` text NOT NULL,
  `time` datetime NOT NULL,
  PRIMARY KEY (`pm_infraction_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `pm_infractions` */

/*Table structure for table `pm_invoices` */

DROP TABLE IF EXISTS `pm_invoices`;

CREATE TABLE `pm_invoices` (
  `pm_invoice_id` int(11) NOT NULL AUTO_INCREMENT,
  `total` double NOT NULL,
  `paid` double NOT NULL,
  `pm_project_id` int(11) NOT NULL,
  `pm_client_id` int(11) NOT NULL,
  PRIMARY KEY (`pm_invoice_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `pm_invoices` */

/*Table structure for table `pm_issue_statues` */

DROP TABLE IF EXISTS `pm_issue_statues`;

CREATE TABLE `pm_issue_statues` (
  `pm_issue_statues_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(225) DEFAULT NULL,
  `color` varchar(225) DEFAULT NULL,
  PRIMARY KEY (`pm_issue_statues_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `pm_issue_statues` */

insert  into `pm_issue_statues`(`pm_issue_statues_id`,`title`,`color`) values (1,'yuyi','#e7addd');

/*Table structure for table `pm_issues` */

DROP TABLE IF EXISTS `pm_issues`;

CREATE TABLE `pm_issues` (
  `pm_issue_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL,
  `description` longtext NOT NULL,
  `pm_reviewer_id` int(11) NOT NULL,
  `pm_project_id` int(11) NOT NULL,
  `created_time` datetime NOT NULL,
  `estimated_time` time NOT NULL,
  `parent` int(11) NOT NULL,
  `pm_priority_id` int(11) NOT NULL,
  `deadline` datetime NOT NULL,
  `pm_issue_type_id` int(11) NOT NULL,
  `pm_issue_statues_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`pm_issue_id`)
) ENGINE=InnoDB AUTO_INCREMENT=69 DEFAULT CHARSET=utf8;

/*Data for the table `pm_issues` */

insert  into `pm_issues`(`pm_issue_id`,`title`,`description`,`pm_reviewer_id`,`pm_project_id`,`created_time`,`estimated_time`,`parent`,`pm_priority_id`,`deadline`,`pm_issue_type_id`,`pm_issue_statues_id`) values (43,'Esraa','esraa esraa esraa esraa esraa esraa esraa esraa ',29,2,'0000-00-00 00:00:00','04:30:40',0,8,'0000-00-00 00:00:00',4,NULL),(44,'Enas','Enas',2,5,'0000-00-00 00:00:00','05:55:10',0,7,'0000-00-00 00:00:00',4,NULL),(45,'Enas','Enas',2,5,'0000-00-00 00:00:00','05:55:10',0,7,'0000-00-00 00:00:00',4,NULL),(46,'yousef','yousef',2,2,'0000-00-00 00:00:00','06:00:55',0,8,'0000-00-00 00:00:00',4,NULL),(47,'ugugu','igiiggig',2,2,'0000-00-00 00:00:00','06:05:50',0,3,'0000-00-00 00:00:00',0,NULL),(48,'ugugu','igiiggig',2,2,'0000-00-00 00:00:00','06:05:50',0,3,'0000-00-00 00:00:00',0,NULL),(49,'ugugu','igiiggig',2,2,'0000-00-00 00:00:00','06:05:50',0,3,'0000-00-00 00:00:00',0,NULL),(50,'sdfj','sdf',29,5,'0000-00-00 00:00:00','06:10:20',0,8,'0000-00-00 00:00:00',1,NULL),(51,'sdfj','sdf',29,5,'0000-00-00 00:00:00','06:10:20',0,8,'0000-00-00 00:00:00',1,NULL),(52,'sdfj','sdf',29,5,'0000-00-00 00:00:00','06:10:20',0,8,'0000-00-00 00:00:00',1,NULL),(53,'sdfj','sdf',29,5,'0000-00-00 00:00:00','06:10:20',0,8,'0000-00-00 00:00:00',1,NULL),(54,'Esso','sdf',2,2,'0000-00-00 00:00:00','06:15:20',0,3,'0000-00-00 00:00:00',4,NULL),(55,'kkkkkk','llllll',2,2,'0000-00-00 00:00:00','06:20:10',0,3,'0000-00-00 00:00:00',4,NULL),(56,'sdf','sdf',2,2,'0000-00-00 00:00:00','06:20:05',0,3,'0000-00-00 00:00:00',4,NULL),(57,'sdf','r4r4r4r',2,2,'0000-00-00 00:00:00','06:20:05',0,3,'0000-00-00 00:00:00',4,NULL),(58,'sdf','g5g55',2,2,'0000-00-00 00:00:00','06:20:05',0,3,'0000-00-00 00:00:00',4,NULL),(59,'hjjhjh','dfdfdf',2,2,'0000-00-00 00:00:00','06:30:10',0,3,'0000-00-00 00:00:00',4,NULL),(60,'hjjhjh','dfdfdf',2,2,'0000-00-00 00:00:00','06:30:10',0,3,'0000-00-00 00:00:00',4,NULL),(61,'hjjhjh','dfdfdf',2,2,'0000-00-00 00:00:00','06:30:10',0,3,'0000-00-00 00:00:00',4,NULL),(62,'hjjhjh','dfdfdf',2,2,'0000-00-00 00:00:00','06:30:10',0,3,'0000-00-00 00:00:00',4,NULL),(63,'hjjhjh','dfdfdf',2,2,'0000-00-00 00:00:00','06:30:10',0,3,'0000-00-00 00:00:00',4,NULL),(64,'hello','soft',2,2,'0000-00-00 00:00:00','12:30:00',0,3,'0000-00-00 00:00:00',4,NULL),(65,'dddd','dddd',0,0,'2015-10-13 18:05:30','05:05:50',0,0,'0000-00-00 00:00:00',0,0),(66,'rrr','rrr',0,0,'2015-10-13 18:07:56','05:10:45',0,0,'0000-00-00 00:00:00',0,0),(67,'fffff','ffff',1,2,'2015-10-13 18:38:47','05:40:10',0,7,'2011-05-10 00:00:00',1,0),(68,'ddddde','eeded',28,2,'2015-10-13 18:52:10','05:55:45',0,3,'0000-00-00 00:00:00',4,0);

/*Table structure for table `pm_issues_types` */

DROP TABLE IF EXISTS `pm_issues_types`;

CREATE TABLE `pm_issues_types` (
  `pm_issue_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  PRIMARY KEY (`pm_issue_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `pm_issues_types` */

insert  into `pm_issues_types`(`pm_issue_type_id`,`title`) values (1,'Bug'),(4,'Task');

/*Table structure for table `pm_priorities` */

DROP TABLE IF EXISTS `pm_priorities`;

CREATE TABLE `pm_priorities` (
  `pm_priority_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `color` varchar(50) NOT NULL,
  PRIMARY KEY (`pm_priority_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

/*Data for the table `pm_priorities` */

insert  into `pm_priorities`(`pm_priority_id`,`name`,`color`) values (1,'orange','#ff8000'),(3,'Blue','#6555f9'),(4,'Red','#c52c2c'),(5,'test','#8000ff'),(7,'Important','#00ff40'),(8,'Pink','#ff80c0');

/*Table structure for table `pm_projects` */

DROP TABLE IF EXISTS `pm_projects`;

CREATE TABLE `pm_projects` (
  `pm_project_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `about` longtext NOT NULL,
  `creation_time` datetime NOT NULL,
  `pm_supervisor_id` int(11) NOT NULL,
  `pm_client_id` int(11) NOT NULL,
  `deadline` datetime NOT NULL,
  `tags` text NOT NULL,
  PRIMARY KEY (`pm_project_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

/*Data for the table `pm_projects` */

insert  into `pm_projects`(`pm_project_id`,`title`,`about`,`creation_time`,`pm_supervisor_id`,`pm_client_id`,`deadline`,`tags`) values (2,'Brightry CMS 1','This disambiguation page lists articles associated with the title CMS. If an internal link led you here, you may wish to change the link to point directly to the intended article.','0000-00-00 00:00:00',25,0,'0000-00-00 00:00:00',''),(5,'Student App','Student App for students','0000-00-00 00:00:00',1,0,'0000-00-00 00:00:00','');

/*Table structure for table `pm_reputations` */

DROP TABLE IF EXISTS `pm_reputations`;

CREATE TABLE `pm_reputations` (
  `pm_reputation_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `pm_issue_id` int(11) DEFAULT NULL,
  `reason` longtext,
  `time` datetime DEFAULT NULL,
  PRIMARY KEY (`pm_reputation_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `pm_reputations` */

/*Table structure for table `pm_roles` */

DROP TABLE IF EXISTS `pm_roles`;

CREATE TABLE `pm_roles` (
  `pm_role_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  PRIMARY KEY (`pm_role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;

/*Data for the table `pm_roles` */

insert  into `pm_roles`(`pm_role_id`,`title`) values (29,'developer'),(30,'designer'),(31,'project manager'),(32,'Marketer');

/*Table structure for table `pm_sessions` */

DROP TABLE IF EXISTS `pm_sessions`;

CREATE TABLE `pm_sessions` (
  `pm_session_id` int(11) NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(50) NOT NULL,
  `user_agent` varchar(150) NOT NULL,
  `last_activity` int(11) NOT NULL,
  `user_data` text NOT NULL,
  PRIMARY KEY (`pm_session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `pm_sessions` */

/*Table structure for table `pm_team_users` */

DROP TABLE IF EXISTS `pm_team_users`;

CREATE TABLE `pm_team_users` (
  `pm_team_users_id` int(11) NOT NULL AUTO_INCREMENT,
  `pm_team_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `pm_role_id` int(11) NOT NULL,
  PRIMARY KEY (`pm_team_users_id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;

/*Data for the table `pm_team_users` */

insert  into `pm_team_users`(`pm_team_users_id`,`pm_team_id`,`user_id`,`pm_role_id`) values (23,43,28,3),(24,43,29,4),(29,46,25,31),(30,46,18,32),(31,46,28,29),(32,46,29,30);

/*Table structure for table `pm_teams` */

DROP TABLE IF EXISTS `pm_teams`;

CREATE TABLE `pm_teams` (
  `pm_team_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(225) NOT NULL,
  `description` longtext NOT NULL,
  `pm_team_leader_id` int(11) NOT NULL,
  PRIMARY KEY (`pm_team_id`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8;

/*Data for the table `pm_teams` */

insert  into `pm_teams`(`pm_team_id`,`title`,`description`,`pm_team_leader_id`) values (1,'CMS Team','any description bla bla bla ml',2),(5,'My Team','this team is ay 7aga w kda w bta3',28),(6,'Esraa','marwa esraa',18),(13,'teamaya','aj kdk lsdk ',28),(41,'Team','Esraa ',1),(44,'ENasa','sdf ls d',1),(45,'Saso 65','sasooooo',1),(46,'Mobile Applications','kl kl klkm lkll lkojn',2);

/*Table structure for table `pm_teams_projects` */

DROP TABLE IF EXISTS `pm_teams_projects`;

CREATE TABLE `pm_teams_projects` (
  `pm_team_project_id` int(11) NOT NULL AUTO_INCREMENT,
  `pm_project_id` int(11) NOT NULL,
  `pm_team_id` int(11) NOT NULL,
  PRIMARY KEY (`pm_team_project_id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

/*Data for the table `pm_teams_projects` */

insert  into `pm_teams_projects`(`pm_team_project_id`,`pm_project_id`,`pm_team_id`) values (15,2,44),(16,2,6),(17,2,46),(18,2,45),(19,3,6),(20,3,46),(21,3,5),(22,2,6),(23,2,46),(24,2,41);

/*Table structure for table `portfolio` */

DROP TABLE IF EXISTS `portfolio`;

CREATE TABLE `portfolio` (
  `portfolio_id` int(11) NOT NULL AUTO_INCREMENT,
  `portfolio_category_id` int(11) DEFAULT NULL,
  `language_id` varchar(3) DEFAULT NULL,
  `title` varchar(300) DEFAULT NULL,
  `seo` varchar(300) DEFAULT NULL,
  `image` text,
  `description` text,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`portfolio_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `portfolio` */

/*Table structure for table `portfolio_categories` */

DROP TABLE IF EXISTS `portfolio_categories`;

CREATE TABLE `portfolio_categories` (
  `portfolio_category_id` int(11) NOT NULL AUTO_INCREMENT,
  `language_id` varchar(3) DEFAULT NULL,
  `title` varchar(300) DEFAULT NULL,
  `seo` varchar(300) DEFAULT NULL,
  `description` text,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`portfolio_category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `portfolio_categories` */

insert  into `portfolio_categories`(`portfolio_category_id`,`language_id`,`title`,`seo`,`description`,`created`) values (2,'en','Ahmed Magdy','Ahmed','jjjjjjjjjjjjjjjj',NULL);

/*Table structure for table `resume_activities` */

DROP TABLE IF EXISTS `resume_activities`;

CREATE TABLE `resume_activities` (
  `resume_activity_id` int(11) NOT NULL AUTO_INCREMENT,
  `resume_id` int(11) DEFAULT NULL,
  `language_id` varchar(3) DEFAULT NULL,
  `activity` varchar(300) DEFAULT NULL,
  `role` varchar(200) DEFAULT NULL,
  `from` date DEFAULT NULL,
  `to` date DEFAULT NULL,
  `desc` text,
  `sort` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`resume_activity_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

/*Data for the table `resume_activities` */

insert  into `resume_activities`(`resume_activity_id`,`resume_id`,`language_id`,`activity`,`role`,`from`,`to`,`desc`,`sort`) values (1,1,NULL,'Arabnet Cairo Conference 2010','Entrepreneur',NULL,NULL,'Investing In Web & Mobile \r\nTalk – Hossam El Sokkari, Rishi Saha, Hatem Dowidar, Omar Tahboub, Ammar Bakkar, Karim Khalifa, William Kanaan, Khaled Ismail \r\nEgypt 1.0 \r\nIdeathon \r\nEntrepreneur Initiative \r\nStartup Demo  \r\nE-retail \r\nGroup Buying \r\nSocial Media Marketing \r\nMedia & Advertising \r\nGaming \r\nMobile Apps \r\nEgypt 2.0 \r\nAward Ceremony',0),(2,1,NULL,'Google|Egypt 2.0 Day2: Webmasters, IT Professionals ',NULL,NULL,NULL,'100% Web: Deploying Apps for your Business \r\nApps Reseller/Partner Program \r\nYouTube API \r\nMonetizing your site: AdSense \r\nMapMaker: Map Your World! \r\nAnalytics: Making the most of your site ',0),(3,1,NULL,'Google|Egypt 2.0 Day3: Developers, Programmers',NULL,NULL,NULL,'Android 4.0 Ice Cream Sandwich Platform Overview \r\nAndroid Best Practices and User Experience Excellence \r\nGoogle+ for developers \r\nPublic Data Applications, Development and APIs \r\nPanel Discussion on Innovation & Entrepreneurship',0),(4,1,NULL,'Webinars',NULL,NULL,NULL,'Best Practices for Growing your VPS and Cloud Server Business\r\n[Zend Webinars]:\nStandard Blog on standard PHP Stack - WordPress and Zend Server \r\nDatabase Deployment with Zend Server and Liquibase\r\nAdvanced Functions of DB2 with PHP on IBM i\r\nStandard Shop on standard PHP Stack - Magento and Zend Server\r\nStored Procedures with PHP and IBM i - Part II \r\nZend Server for IBM i 5.6 Update \r\nClassic Design Patterns in PHP\r\nAnd more… ',0),(5,1,NULL,'DevFest Alexandria 2013',NULL,NULL,NULL,'Python Crash Course\r\nCloud Computing, What & Why?\r\nApp Engine Development\r\nCross platform Mobile Development\r\nAppcelerator Platform\r\nAndroid\r\nAugmented Reality\r\nHTML5',0),(6,1,NULL,'Nokia',NULL,NULL,NULL,NULL,0),(7,1,NULL,'Nokia 2',NULL,NULL,NULL,NULL,0),(13,1,'en','sa','sa','2015-08-27','2015-08-27','sa',0);

/*Table structure for table `resume_contacts` */

DROP TABLE IF EXISTS `resume_contacts`;

CREATE TABLE `resume_contacts` (
  `resume_contact_id` int(11) NOT NULL AUTO_INCREMENT,
  `resume_id` int(11) DEFAULT NULL,
  `language_id` varchar(3) DEFAULT NULL,
  `contact_method` varchar(100) DEFAULT NULL,
  `contact_detail` varchar(200) DEFAULT NULL,
  `sort` int(11) DEFAULT NULL,
  PRIMARY KEY (`resume_contact_id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;

/*Data for the table `resume_contacts` */

insert  into `resume_contacts`(`resume_contact_id`,`resume_id`,`language_id`,`contact_method`,`contact_detail`,`sort`) values (1,1,NULL,'E-Mail','muhammad [at] el-saeed.info',1),(2,1,NULL,'Phone','(+20) 1000-709-113',2),(3,1,NULL,'Facebook',NULL,3),(4,1,NULL,'Twitter','',4),(5,1,NULL,'Google+','http://plus.google.com/+MuhammadElSaeed',5),(6,1,NULL,'LinkedIn',NULL,6),(8,1,'en','Facebook','asdas',NULL),(23,14,'en','Email','asasasas',NULL);

/*Table structure for table `resume_details` */

DROP TABLE IF EXISTS `resume_details`;

CREATE TABLE `resume_details` (
  `resume_detail_id` int(11) NOT NULL AUTO_INCREMENT,
  `resume_id` int(11) DEFAULT NULL,
  `language_id` varchar(3) DEFAULT NULL,
  `full_name` varchar(200) DEFAULT NULL,
  `seo` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`resume_detail_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `resume_details` */

/*Table structure for table `resume_education` */

DROP TABLE IF EXISTS `resume_education`;

CREATE TABLE `resume_education` (
  `resume_education_id` int(11) NOT NULL AUTO_INCREMENT,
  `resume_id` int(11) DEFAULT NULL,
  `language_id` varchar(3) DEFAULT NULL,
  `degree` varchar(100) DEFAULT NULL,
  `field` varchar(100) DEFAULT NULL,
  `school` varchar(100) DEFAULT NULL,
  `grade` varchar(100) DEFAULT NULL,
  `from_year` int(11) DEFAULT NULL,
  `from_month` int(11) DEFAULT NULL,
  `to_year` int(11) DEFAULT NULL,
  `to_month` int(11) DEFAULT NULL,
  `sort` int(11) DEFAULT NULL,
  PRIMARY KEY (`resume_education_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

/*Data for the table `resume_education` */

insert  into `resume_education`(`resume_education_id`,`resume_id`,`language_id`,`degree`,`field`,`school`,`grade`,`from_year`,`from_month`,`to_year`,`to_month`,`sort`) values (1,1,NULL,'Prep School','Prep','Al-Andalos Wal-Hijaz',NULL,19950901,NULL,20000601,NULL,1),(2,1,NULL,'Primary School','Primary','Ali Ben Abi-Talib',NULL,20000901,NULL,20030601,NULL,0),(3,1,NULL,'Secondary School','Secondary','Manhal Al-Maarifa',NULL,20030901,NULL,20060601,NULL,0),(4,1,NULL,'Bachelor','Business Administration Bachelor','Specialized Studies Academy',NULL,20060901,NULL,20100601,NULL,0),(5,1,NULL,'Diploma','Diploma of Computer Science','Computer and Information, Ain Shams Unversity',NULL,20130901,NULL,20150601,NULL,0),(13,0,'en','Secondary School','l;k','kl','jh',1990,7,1990,1,NULL);

/*Table structure for table `resume_hobbies` */

DROP TABLE IF EXISTS `resume_hobbies`;

CREATE TABLE `resume_hobbies` (
  `resume_hooby_id` int(11) NOT NULL AUTO_INCREMENT,
  `resume_id` int(11) DEFAULT NULL,
  `language_id` varchar(3) DEFAULT NULL,
  `name` varchar(300) DEFAULT NULL,
  `sort` int(11) DEFAULT NULL,
  PRIMARY KEY (`resume_hooby_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

/*Data for the table `resume_hobbies` */

insert  into `resume_hobbies`(`resume_hooby_id`,`resume_id`,`language_id`,`name`,`sort`) values (1,1,NULL,'Photography and Designing',1),(2,1,NULL,'Chess',2),(3,1,NULL,'Football',3),(4,1,NULL,'Programming is my passion',4),(5,1,NULL,'Playstation',5),(11,0,'en','kl',NULL);

/*Table structure for table `resume_languages` */

DROP TABLE IF EXISTS `resume_languages`;

CREATE TABLE `resume_languages` (
  `resume_language_id` int(11) NOT NULL AUTO_INCREMENT,
  `resume_id` int(11) DEFAULT NULL,
  `language_id` varchar(3) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `level` varchar(100) DEFAULT NULL,
  `sort` int(11) DEFAULT NULL,
  PRIMARY KEY (`resume_language_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `resume_languages` */

insert  into `resume_languages`(`resume_language_id`,`resume_id`,`language_id`,`name`,`level`,`sort`) values (1,1,NULL,'Arabic','Mother Tongue',0),(2,1,NULL,'English','Very Good',0),(3,1,NULL,'French','Little Knowledge',0);

/*Table structure for table `resume_locations` */

DROP TABLE IF EXISTS `resume_locations`;

CREATE TABLE `resume_locations` (
  `resume_location_id` int(11) NOT NULL AUTO_INCREMENT,
  `resume_id` int(11) DEFAULT NULL,
  `language_id` varchar(3) DEFAULT NULL,
  `location` varchar(500) DEFAULT NULL,
  `lat` varchar(30) DEFAULT NULL,
  `long` varchar(30) DEFAULT NULL,
  `address` text,
  `sort` int(11) DEFAULT NULL,
  PRIMARY KEY (`resume_location_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

/*Data for the table `resume_locations` */

insert  into `resume_locations`(`resume_location_id`,`resume_id`,`language_id`,`location`,`lat`,`long`,`address`,`sort`) values (1,1,NULL,'Hometown','31.262047','29.999515','84 Faisal city, Sedibishr, Alexandria',1),(2,1,NULL,'Current City','29.979619','31.288547','10 Ibn Al-Walid, Maadi, Cairo',2),(3,3,NULL,'(NULL)hg','h','h',NULL,NULL),(10,14,'en','sasa','2212','221','sasa',NULL);

/*Table structure for table `resume_skills` */

DROP TABLE IF EXISTS `resume_skills`;

CREATE TABLE `resume_skills` (
  `resume_skill_id` int(11) NOT NULL AUTO_INCREMENT,
  `resume_id` int(11) DEFAULT NULL,
  `language_id` varchar(3) DEFAULT NULL,
  `category` varchar(300) DEFAULT NULL,
  `content` text,
  `sort` int(11) DEFAULT NULL,
  PRIMARY KEY (`resume_skill_id`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8;

/*Data for the table `resume_skills` */

insert  into `resume_skills`(`resume_skill_id`,`resume_id`,`language_id`,`category`,`content`,`sort`) values (1,1,NULL,'Operating Systems',NULL,0),(2,1,NULL,'Development',NULL,0),(3,1,NULL,'Graphics','Photoshop, Illustrator, Light room, InDesign, FreeHand, Flash, Swish',0),(5,1,NULL,'Database ','MySQL, SQL Server, Ridis DB, MS Access, SQLite',0),(6,1,NULL,'Tools',NULL,0),(7,1,NULL,'Other','Augmented Reality, NFC, Cloud Computing, Responsive Design, OOP, Agile Development',0),(8,1,NULL,'Courses/Self Studies','MCSE, MCITP, CCNA, Embedded Systems Programming (UT.6.01x)',0),(9,1,NULL,'VCS','Mercurial, SVN, Git, VCS Base and Bazaar',0),(10,1,NULL,'Web','Hand Coded HTML5/XHTML, XML, CSS3, PHP, ASP.NET, Perl, Python, Sharepoint, NodeJS, Knowlege of Dart and Go',0),(11,1,NULL,'Desktop','Java, Visal Basic.NET, C/C++, C#',0),(12,1,NULL,'Mobile','Android (Java), Windows Phone (C#), Ubuntu (QT)',0),(13,1,NULL,'Windows','Microsoft DOS, Windows 3.11, Windows 95, Windows 98, Windows ME, Windows NT4.0, Windows 2000 (Professional & Server), Windows XP, Windows Vista, Windows 2008 (Server), Windows 7, Windows 8.1, Windows Phone',0),(14,1,NULL,'Linux/Unix','Ubuntu, CentOS, Fedora, RedHat, Linpus, Klinux, Debian',0),(15,1,NULL,'Mac','Snow Leopard x10.6, Lion x10.7',0),(16,1,NULL,'Embedded Systems','Texas Lunchpad (Keil uVision), Ardino',0),(17,1,NULL,'Webservices','WSDL (SOAP), WADL (REST)',0),(19,1,NULL,'ORM','PDO, PHPBean, Doctorine',0),(20,1,NULL,'IDE','Netbeans, Eclipse, Keil, Visual studio .Net',NULL),(21,1,NULL,'Scripts','WooCommerce, Wordpress, joomla, magento, mambo, nuke, virtuemart, jigoshop, osCommerce, Zen Cart, TomatoCart, OpenCart, Drupal, 4images, osDate, Datalife, vBulletin, Invision Power Board, PHPBB',NULL),(22,1,NULL,'Apache Packages','LAMP, MAMP, WAMP, XAMP',NULL),(23,1,NULL,'Frameworks','MVC3, MVC4, jQuery, CodeIgniter, Yii, CakePHP, Zend, Symphony, Slim microframework, QTFramework',NULL),(24,1,NULL,'Template Systems','Smarty Template, Twig',NULL),(25,1,NULL,'SDK/API','Android, Facebook, Twitter, name.com',NULL),(36,0,'en','lk;l','kkl',NULL),(37,0,'en','lk;l','kkl',NULL),(38,0,'en','oi','hu',NULL),(39,0,'en','hi','hello',NULL);

/*Table structure for table `resume_work_history` */

DROP TABLE IF EXISTS `resume_work_history`;

CREATE TABLE `resume_work_history` (
  `resume_work_history_id` int(11) NOT NULL AUTO_INCREMENT,
  `resume_id` int(11) DEFAULT NULL,
  `language_id` varchar(3) DEFAULT NULL,
  `company` varchar(300) DEFAULT NULL,
  `from` date DEFAULT NULL,
  `to` date DEFAULT NULL,
  `category` varchar(300) DEFAULT NULL,
  `title` varchar(300) DEFAULT NULL,
  `nationality_id` int(11) DEFAULT NULL,
  `responsbilities` text,
  `sort` int(11) DEFAULT NULL,
  PRIMARY KEY (`resume_work_history_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

/*Data for the table `resume_work_history` */

insert  into `resume_work_history`(`resume_work_history_id`,`resume_id`,`language_id`,`company`,`from`,`to`,`category`,`title`,`nationality_id`,`responsbilities`,`sort`) values (1,1,NULL,'OriobCities ','2010-11-01','2011-08-01','Data Center','Web Developer',0,NULL,0),(2,1,NULL,'Alandalus wel Hijaz','2009-03-01','2010-03-01','Reconstruction & Maintenance','Supervisor',0,NULL,0),(3,1,NULL,'Aljawharah ','2008-01-01',NULL,'Web Solutions','Web developer and Designer',0,'Freelancer web developer and designer',0),(4,1,NULL,'SCI','2006-04-01','2007-04-30','Training Cente','Instructor',0,NULL,0),(5,1,NULL,'Candles ','2004-05-01','2006-03-15','Advertising Agency','Graphic Designer',0,'Business Cards.\r\nBrochures.\r\nBooks.\r\nMagazines.',0),(6,1,NULL,'Topline','2012-01-01','2012-05-01','Web Solutions','Team Leader',0,'Responsible of the web services of companies department, and the team (Designers and Programmers). \r\nWorking as designer and programmer for urgently tickets',0),(7,1,NULL,'Virgo','2012-06-01',NULL,'Communications','Senior Web Developer / Team Leade',0,NULL,0),(8,1,NULL,'Self Employment',NULL,NULL,'Software','Owner',0,'Nersoft for products',0);

/*Table structure for table `resumes` */

DROP TABLE IF EXISTS `resumes`;

CREATE TABLE `resumes` (
  `resume_id` int(11) NOT NULL AUTO_INCREMENT,
  `language_id` varchar(3) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `nationality_id` int(20) DEFAULT NULL,
  `marital_status_id` int(30) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`resume_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

/*Data for the table `resumes` */

insert  into `resumes`(`resume_id`,`language_id`,`user_id`,`date_of_birth`,`nationality_id`,`marital_status_id`,`created`) values (1,'en',1,'1989-01-01',1,2,NULL),(14,'en',10,'2015-07-13',3,1,'2015-07-15 17:26:10');

/*Table structure for table `sessions` */

DROP TABLE IF EXISTS `sessions`;

CREATE TABLE `sessions` (
  `session_id` varchar(60) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `ip` varchar(32) DEFAULT NULL,
  `latest_activity` datetime DEFAULT NULL,
  `agent` varchar(255) DEFAULT NULL,
  `data` text,
  PRIMARY KEY (`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `sessions` */

insert  into `sessions`(`session_id`,`user_id`,`ip`,`latest_activity`,`agent`,`data`) values ('0laqgatuokvom823b60jhu0347',0,'::1','2015-10-26 12:36:01','Mozilla/5.0 (Windows NT 6.3; WOW64; rv:41.0) Gecko/20100101 Firefox/41.0',NULL),('28f1kjhqapql87qs5l2ok70au4',0,'::1','2015-10-20 18:50:34','Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2490.71 Safari/537.36',NULL),('28gvh9gumor744mtoc6plll7g0',0,'::1','2015-10-31 07:04:08','Mozilla/5.0 (Windows NT 6.3; WOW64; rv:41.0) Gecko/20100101 Firefox/41.0',NULL),('2p1j9r67c3j011jqje0na5cc81',0,'::1','2015-10-26 12:36:03','Mozilla/5.0 (Windows NT 6.3; WOW64; rv:41.0) Gecko/20100101 Firefox/41.0',NULL),('30dpb9nm6a2p3c45humu4mr7b0',0,'::1','2015-10-20 18:50:35','Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2490.71 Safari/537.36',NULL),('3dt33a4o2sgq5e5d1ajem23so7',1,'::1','2015-10-22 19:02:53','Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2490.71 Safari/537.36',NULL),('3jnnkvgbg8ciur77tl4lj6ou30',0,'::1','2015-11-01 23:17:54','Mozilla/5.0 (Windows NT 6.3; WOW64; rv:41.0) Gecko/20100101 Firefox/41.0',NULL),('4a8k8nuilpl74r6dd1i28il651',1,'::1','2015-10-26 12:05:38','Mozilla/5.0 (Windows NT 6.3; WOW64; Trident/7.0; rv:11.0) like Gecko',NULL),('4i4e4oh5pjl5bcmok8101g3eh7',0,'::1','2015-10-25 10:36:47','Mozilla/5.0 (Windows NT 6.3; WOW64; rv:28.0) Gecko/20100101 Firefox/28.0',NULL),('4iuliamlfi1vel4k3ggo88mfr4',0,'::1','2015-11-01 22:09:44','Mozilla/5.0 (Windows NT 6.3; WOW64; rv:41.0) Gecko/20100101 Firefox/41.0',NULL),('4vurhfcs5s42tj22qd6t07mdk5',0,'::1','2015-10-20 18:50:34','Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2490.71 Safari/537.36',NULL),('5k5gbttbhaanbh4olilrjq2c05',1,'127.0.0.1','2015-10-09 16:59:44','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/45.0.2454.101 Safari/537.36',NULL),('5qdro9gr91desoqaj09hruntv1',1,'::1','2015-10-31 16:57:03','Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2490.80 Safari/537.36',NULL),('6k71rqvn6hb0bps905arq6cvr1',0,'','2015-10-10 14:41:44','',NULL),('6qfdu0qtf2rt7m43p209b75jv4',2,'127.0.0.1','2015-10-09 11:29:38','Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:41.0) Gecko/20100101 Firefox/41.0',NULL),('74c59j0c4hfr47b4np96qf9td1',0,'192.168.43.1','2015-11-05 19:29:31','Mozilla/5.0 (Linux; Android 5.1.1; D6503 Build/23.4.A.1.232) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2490.76 Mobile Safari/537.36',NULL),('766g493qp5n5lsfoaoimvcnie1',0,'::1','2015-10-27 13:33:53','Mozilla/5.0 (Windows NT 6.3; WOW64; rv:41.0) Gecko/20100101 Firefox/41.0',NULL),('79p67lm7hfg1r4qpfpngiuon74',0,'::1','2015-10-27 13:33:54','Mozilla/5.0 (Windows NT 6.3; WOW64; rv:41.0) Gecko/20100101 Firefox/41.0',NULL),('7kq1ul57cdmam44d57lc6sgou6',0,'','2015-10-10 14:42:20','',NULL),('7qcne8o54hh6msl0066vou6u32',0,'::1','2015-10-26 12:36:01','Mozilla/5.0 (Windows NT 6.3; WOW64; rv:41.0) Gecko/20100101 Firefox/41.0',NULL),('8b50s187qunnldfn4f32551gu6',0,'::1','2015-10-31 07:04:04','Mozilla/5.0 (Windows NT 6.3; WOW64; rv:41.0) Gecko/20100101 Firefox/41.0',NULL),('8cmj6iu1s9urectnf6t83rt5j6',0,'::1','2015-11-01 23:17:55','Mozilla/5.0 (Windows NT 6.3; WOW64; rv:41.0) Gecko/20100101 Firefox/41.0',NULL),('8jn26umsigvf4esee80donbrm0',0,'::1','2015-10-26 12:36:01','Mozilla/5.0 (Windows NT 6.3; WOW64; rv:41.0) Gecko/20100101 Firefox/41.0',NULL),('a9260u0rgr2bqaolngj1peo852',0,'','2015-10-27 08:52:39','',NULL),('a9grfjj2a0b325is6dt7t12n90',0,'::1','2015-11-01 23:09:51','Mozilla/5.0 (Windows NT 6.3; WOW64; rv:41.0) Gecko/20100101 Firefox/41.0',NULL),('acgkf5v0b5n8chrrg1t2d9f010',0,'::1','2015-10-20 18:50:36','Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2490.71 Safari/537.36',NULL),('atdsioil0075fi1ig245kf9804',0,'::1','2015-10-20 18:50:33','Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2490.71 Safari/537.36',NULL),('av6r48cdcrtpc5gao3t6m6dov4',0,'::1','2015-10-31 07:04:04','Mozilla/5.0 (Windows NT 6.3; WOW64; rv:41.0) Gecko/20100101 Firefox/41.0',NULL),('b13o35rgflkghjt240kttdqen6',0,'::1','2015-10-20 18:50:36','Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2490.71 Safari/537.36',NULL),('b1nge4hi19krilkbp40pd1unq5',0,'','2015-11-04 13:08:21','',NULL),('b6skhj3ure7tvm9q4klmkii8k7',0,'::1','2015-11-01 23:18:00','Mozilla/5.0 (Windows NT 6.3; WOW64; rv:41.0) Gecko/20100101 Firefox/41.0',NULL),('bok5pebt3cnr94gihiu849vpm3',1,'192.168.43.238','2015-11-05 19:50:23','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/48.0.2553.0 Safari/537.36',NULL),('d7sm2rbsgc21brtoarulejuho0',0,'::1','2015-10-20 18:50:34','Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2490.71 Safari/537.36',NULL),('dobgogg66dihbpgr76fa6ovl00',0,'::1','2015-11-01 23:09:43','Mozilla/5.0 (Windows NT 6.3; WOW64; rv:41.0) Gecko/20100101 Firefox/41.0',NULL),('dt2rdd9ohe7tiq7fc8kc68g9f2',0,'::1','2015-11-01 23:09:45','Mozilla/5.0 (Windows NT 6.3; WOW64; rv:41.0) Gecko/20100101 Firefox/41.0',NULL),('eoscm3n7nfdm3genb090742944',1,'::1','2015-11-02 23:22:10','Mozilla/5.0 (Windows NT 6.3; WOW64; rv:28.0) Gecko/20100101 Firefox/28.0',NULL),('f7lh6eglbljhaan5nucp999h33',1,'::1','2015-12-03 17:36:09','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/48.0.2564.0 Safari/537.36',NULL),('f8g1ra57v4t45kua1nrmqhlj12',0,'::1','2015-10-25 10:36:55','Mozilla/5.0 (Windows NT 6.3; WOW64; rv:28.0) Gecko/20100101 Firefox/28.0',NULL),('fbus38kb4nvsg3dijtd1qk2i37',0,'::1','2015-10-31 07:04:05','Mozilla/5.0 (Windows NT 6.3; WOW64; rv:41.0) Gecko/20100101 Firefox/41.0',NULL),('fj78cansk87je9ns7gkc8phf21',0,'::1','2015-10-20 18:50:34','Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2490.71 Safari/537.36',NULL),('g6kj6mc76gvit6l3ok2uaj7iq1',0,'::1','2015-10-31 07:04:04','Mozilla/5.0 (Windows NT 6.3; WOW64; rv:41.0) Gecko/20100101 Firefox/41.0',NULL),('h7amvjha5runq63448poe08b87',0,'::1','2015-10-26 12:36:02','Mozilla/5.0 (Windows NT 6.3; WOW64; rv:41.0) Gecko/20100101 Firefox/41.0',NULL),('hmtineseu79tnuud40c3qi2mn1',0,'::1','2015-10-31 07:04:04','Mozilla/5.0 (Windows NT 6.3; WOW64; rv:41.0) Gecko/20100101 Firefox/41.0',NULL),('hpg5v29r44lqp0to0dnqrmkg34',0,'::1','2015-10-31 07:04:05','Mozilla/5.0 (Windows NT 6.3; WOW64; rv:41.0) Gecko/20100101 Firefox/41.0',NULL),('hqniqgksjvnpnkbe7ihp2a6mt5',0,'::1','2015-10-20 18:50:35','Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2490.71 Safari/537.36',NULL),('ioip4bbi2n27mb39sie52pq8a3',0,'::1','2015-11-01 22:09:50','Mozilla/5.0 (Windows NT 6.3; WOW64; rv:41.0) Gecko/20100101 Firefox/41.0',NULL),('isruk9stqfhniep0os52qbn6d5',0,'::1','2015-11-01 23:17:54','Mozilla/5.0 (Windows NT 6.3; WOW64; rv:41.0) Gecko/20100101 Firefox/41.0',NULL),('j2gsa2h5mntuafuokrkgs5i8d2',0,'192.168.43.1','2015-11-05 18:32:35','Mozilla/5.0 (Linux; Android 5.1.1; D6503 Build/23.4.A.1.232; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/46.0.2490.76 Mobile Safari/537.36',NULL),('jms7vsifni1424gmsfh07q6hk2',0,'::1','2015-10-25 10:36:51','Mozilla/5.0 (Windows NT 6.3; WOW64; rv:28.0) Gecko/20100101 Firefox/28.0',NULL),('k3599ie36dtm6j5v8msqg344o6',0,'::1','2015-10-26 12:36:01','Mozilla/5.0 (Windows NT 6.3; WOW64; rv:41.0) Gecko/20100101 Firefox/41.0',NULL),('k76gr1fij63k54noif0lka2mp5',0,'::1','2015-11-01 23:17:54','Mozilla/5.0 (Windows NT 6.3; WOW64; rv:41.0) Gecko/20100101 Firefox/41.0',NULL),('k850vv94o822gn9dq6r5h3geq1',0,'::1','2015-11-01 22:17:59','Mozilla/5.0 (Windows NT 6.3; WOW64; rv:41.0) Gecko/20100101 Firefox/41.0',NULL),('kc3qj9phg54g7h3ikk2d50vbg3',0,'::1','2015-11-01 23:18:00','Mozilla/5.0 (Windows NT 6.3; WOW64; rv:41.0) Gecko/20100101 Firefox/41.0',NULL),('l7bpu8njhou8hboqg42rtn7b16',0,'::1','2015-10-20 18:50:37','Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2490.71 Safari/537.36',NULL),('ldbhlpolssgprskdnnkjbt39a1',0,'::1','2015-10-20 18:50:36','Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2490.71 Safari/537.36',NULL),('ldh70duuka3hd88jj9bssvk7o6',0,'','2015-10-27 08:58:43','',NULL),('loj0chj941vui0tt85cndhbvu4',0,'','2015-11-07 22:09:11','',NULL),('m0b4in2fciq2hqo9h1fgab1ru4',0,'::1','2015-10-20 18:50:35','Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2490.71 Safari/537.36',NULL),('m6pik8m9lqtkbmijuan9k8jal0',0,'::1','2015-11-01 22:17:54','Mozilla/5.0 (Windows NT 6.3; WOW64; rv:41.0) Gecko/20100101 Firefox/41.0',NULL),('mqgr631k6hslf19ikhdkl18sj7',0,'::1','2015-12-04 20:31:23','Mozilla/5.0 (Windows NT 10.0; WOW64; rv:44.0) Gecko/20100101 Firefox/44.0',NULL),('nhf7h7g29h0k73cdolcphmliu7',0,'::1','2015-10-26 12:36:02','Mozilla/5.0 (Windows NT 6.3; WOW64; rv:41.0) Gecko/20100101 Firefox/41.0',NULL),('nrn2tv6msct5tcpho5ie1nrgj5',0,'::1','2015-10-31 07:04:07','Mozilla/5.0 (Windows NT 6.3; WOW64; rv:41.0) Gecko/20100101 Firefox/41.0',NULL),('p5v489lsdsgkvuqnvfn9g3ner6',0,'::1','2015-10-20 18:50:35','Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2490.71 Safari/537.36',NULL),('pv56bvba3j9iat3dahnhctnka0',0,'::1','2015-10-26 12:36:02','Mozilla/5.0 (Windows NT 6.3; WOW64; rv:41.0) Gecko/20100101 Firefox/41.0',NULL),('q1et7m59l0uiotog8tb8ps8tl6',0,'::1','2015-10-31 07:04:08','Mozilla/5.0 (Windows NT 6.3; WOW64; rv:41.0) Gecko/20100101 Firefox/41.0',NULL),('qeb1pfe8qi4702b29hp8qaavs1',0,'::1','2015-11-01 23:09:44','Mozilla/5.0 (Windows NT 6.3; WOW64; rv:41.0) Gecko/20100101 Firefox/41.0',NULL),('qjjnkbhchaa6noukqu2ku4qla3',0,'::1','2015-11-01 23:09:50','Mozilla/5.0 (Windows NT 6.3; WOW64; rv:41.0) Gecko/20100101 Firefox/41.0',NULL),('r132p05ht08shb0a88bipr01b2',0,'::1','2015-10-20 18:50:34','Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2490.71 Safari/537.36',NULL),('r1msoivq1mgcbidlpuh8s4ppb1',0,'::1','2015-11-01 23:09:44','Mozilla/5.0 (Windows NT 6.3; WOW64; rv:41.0) Gecko/20100101 Firefox/41.0',NULL),('sgi632jhtqk8anffoehs954dg1',0,'::1','2015-11-01 23:17:55','Mozilla/5.0 (Windows NT 6.3; WOW64; rv:41.0) Gecko/20100101 Firefox/41.0',NULL),('sgmodgrvnub2n563sr4smoai24',0,'::1','2015-10-20 18:50:35','Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2490.71 Safari/537.36',NULL),('sjkhjt50efnoit8n8aij1ugmh4',0,'::1','2015-10-25 10:36:44','Mozilla/5.0 (Windows NT 6.3; WOW64; rv:28.0) Gecko/20100101 Firefox/28.0',NULL),('sk5if3l7t15q8mjnh17rdtuud3',0,'::1','2015-10-20 18:50:36','Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2490.71 Safari/537.36',NULL),('taudokraca008lsav2ig70f0n7',0,'::1','2015-11-01 23:09:45','Mozilla/5.0 (Windows NT 6.3; WOW64; rv:41.0) Gecko/20100101 Firefox/41.0',NULL),('v8maoomkg3vhddrkk23350pla0',0,'::1','2015-10-20 18:50:34','Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2490.71 Safari/537.36',NULL),('vhcktaeelqdufu0b01i3btb545',0,'::1','2015-10-20 18:50:36','Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2490.71 Safari/537.36',NULL),('vn0gcpi8s7mcp8ohk9j38jcc62',0,'::1','2015-10-26 12:36:03','Mozilla/5.0 (Windows NT 6.3; WOW64; rv:41.0) Gecko/20100101 Firefox/41.0',NULL);

/*Table structure for table `settings` */

DROP TABLE IF EXISTS `settings`;

CREATE TABLE `settings` (
  `key` varchar(100) NOT NULL,
  `value` varchar(255) DEFAULT NULL,
  `default_value` varchar(255) DEFAULT NULL,
  `required` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `settings` */

insert  into `settings`(`key`,`value`,`default_value`,`required`) values ('alexa_verification','I_Dx4MPXaCMI7wk1yPV8AseoMIA',NULL,0),('bing_verification','FEDDDEC2D83BCD24B37782BE43D1E86B',NULL,0),('closing_message','This website is under maintenance, we\'ll be back soon.',NULL,0),('description','Brightery',NULL,1),('fb_app_id','692025277512750',NULL,0),('frontend_style','default',NULL,0),('google_verification','OSN_Iedl45U_3byyfl4hWfpG7AhW4pclluKsCyzc8Zo',NULL,0),('keywords','Brightery',NULL,1),('limit','20',NULL,0),('management_style','default',NULL,0),('site_status','0',NULL,1),('timezone','Africa/Cairo',NULL,1),('title','Brightery',NULL,1),('uploads_path','uploads','uploads',1),('webmaster_email','mail@example.com','mail@example.com',1),('yandex_verification','',NULL,0);

/*Table structure for table `sliders` */

DROP TABLE IF EXISTS `sliders`;

CREATE TABLE `sliders` (
  `slider_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`slider_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `sliders` */

insert  into `sliders`(`slider_id`,`name`) values (1,'mk');

/*Table structure for table `slides` */

DROP TABLE IF EXISTS `slides`;

CREATE TABLE `slides` (
  `slide_id` int(11) NOT NULL AUTO_INCREMENT,
  `language_id` varchar(3) DEFAULT NULL,
  `title` varchar(300) DEFAULT NULL,
  `image` text,
  `caption` text,
  `url` text,
  `from_date` datetime DEFAULT NULL,
  `to_date` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `sort` int(11) DEFAULT '0',
  `slider_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`slide_id`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8;

/*Data for the table `slides` */

insert  into `slides`(`slide_id`,`language_id`,`title`,`image`,`caption`,`url`,`from_date`,`to_date`,`created`,`sort`,`slider_id`) values (28,NULL,'YES','mylogo1.png','yes','https://mail.google.com/mail/u/0/#all/14ebb7ae3c7d2b02','0000-00-00 00:00:00','0000-00-00 00:00:00','2015-06-11 18:49:58',1,NULL),(29,NULL,'slider2','483792_489207341128752_1998018065_n.jpg','sss','http://www.el-saeed.info','0000-00-00 00:00:00','0000-00-00 00:00:00','2015-06-11 18:59:19',1,NULL),(30,NULL,'slider2','','sss','http://www.el-saeed.info','0000-00-00 00:00:00','0000-00-00 00:00:00','2015-06-11 18:59:28',1,NULL),(31,NULL,'slider2','','sss','http://www.el-saeed.info','0000-00-00 00:00:00','0000-00-00 00:00:00','2015-06-11 19:05:30',1,NULL),(32,NULL,'slider2','','sss','http://www.el-saeed.info','0000-00-00 00:00:00','0000-00-00 00:00:00','2015-06-11 19:07:45',1,NULL),(33,NULL,'slider2','','sss','http://www.el-saeed.info','0000-00-00 00:00:00','0000-00-00 00:00:00','2015-06-11 19:09:12',1,NULL),(35,NULL,'slider2','','sss','http://www.el-saeed.info','0000-00-00 00:00:00','0000-00-00 00:00:00','2015-06-11 19:10:28',1,NULL),(36,NULL,'slider2','mylogo5.png','sss','http://www.el-saeed.info','0000-00-00 00:00:00','0000-00-00 00:00:00','2015-06-11 19:14:11',1,NULL),(38,NULL,'slider2','mylogo1.png','sss','http://www.el-saeed.info','0000-00-00 00:00:00','0000-00-00 00:00:00','2015-06-11 19:15:44',1,NULL),(40,NULL,'hiiiiiiii','11117940_934000016623300_1713238114_n.jpg','sasad','https://mail.google.com/mail/u/0/#all/14ebb7ae3c7d2b02','0000-00-00 00:00:00','0000-00-00 00:00:00','2015-07-09 14:03:00',1,NULL),(41,NULL,'test','11.jpg','ssss','https://bitbucket.org/melsaeed/brighterycms/commits/f2a13cf25605d307d545cc11909f8eec7d937501','0000-00-00 00:00:00','0000-00-00 00:00:00','2015-07-13 15:09:47',1,NULL),(42,NULL,'hfghg','20094_1420919491571094_1216113210334566482_n.jpg','hgchf','https://mail.google.com/mail/u/0/#all/14ebb7ae3c7d2b02','0000-00-00 00:00:00','0000-00-00 00:00:00','2015-07-23 18:38:35',1,NULL);

/*Table structure for table `store_categories` */

DROP TABLE IF EXISTS `store_categories`;

CREATE TABLE `store_categories` (
  `store_category_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(300) DEFAULT NULL,
  `seo` varchar(300) DEFAULT NULL,
  PRIMARY KEY (`store_category_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `store_categories` */

/*Table structure for table `store_modules` */

DROP TABLE IF EXISTS `store_modules`;

CREATE TABLE `store_modules` (
  `store_module_id` int(11) NOT NULL AUTO_INCREMENT,
  `store_category_id` int(11) DEFAULT NULL,
  `seo` varchar(200) DEFAULT NULL,
  `version` double DEFAULT NULL,
  `title` varchar(200) DEFAULT NULL,
  `description` text,
  `icon` text,
  `price` double DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`store_module_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `store_modules` */

/*Table structure for table `tags` */

DROP TABLE IF EXISTS `tags`;

CREATE TABLE `tags` (
  `tag_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) DEFAULT NULL,
  `parent` int(11) DEFAULT '0',
  PRIMARY KEY (`tag_id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8;

/*Data for the table `tags` */

insert  into `tags`(`tag_id`,`name`,`parent`) values (1,'PHP',0),(2,'MySQL',0),(3,'ASP',0),(4,'.NET',0),(5,'Java',0),(6,'Javascript',0),(7,'C',0),(8,'C++',0),(9,'C#',0),(10,'HTML',0),(11,'XML',0),(12,'AJAX',0),(13,'Linux',0),(14,'Ubuntu',0),(15,'Windows',0),(16,NULL,0),(17,'JSP',0),(18,'Debian',0),(19,'Photography',0),(20,'CSS',0),(21,'CSS3',0),(22,'LAMP',0),(23,'Apache',0),(24,'Update',0),(25,'Firefox',0),(26,'Virtual host',0),(27,'Unix',0),(28,'Infinite loops',0),(29,'Query',0),(30,'Virtual Query',0),(31,'Recoed Number',0),(32,'Arduino Uno',0),(33,'Launchpad',0),(34,'TM4C123G',0),(35,'DO NOT DONATE FUEL',0),(36,'Petrol',0),(37,'Fuel',0);

/*Table structure for table `testimonials` */

DROP TABLE IF EXISTS `testimonials`;

CREATE TABLE `testimonials` (
  `testimonial_id` int(11) NOT NULL AUTO_INCREMENT,
  `client_name` varchar(200) DEFAULT NULL,
  `client_position` varchar(200) DEFAULT NULL,
  `message` text,
  `visibility_status_id` int(1) NOT NULL,
  PRIMARY KEY (`testimonial_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `testimonials` */

insert  into `testimonials`(`testimonial_id`,`client_name`,`client_position`,`message`,`visibility_status_id`) values (2,'Ahmed','Accountant ','assss',1);

/*Table structure for table `user_addresses` */

DROP TABLE IF EXISTS `user_addresses`;

CREATE TABLE `user_addresses` (
  `user_address_id` int(11) NOT NULL AUTO_INCREMENT,
  `zipcode` varchar(5) DEFAULT NULL,
  `city_id` int(11) DEFAULT NULL,
  `address` text,
  `user_id` int(11) DEFAULT NULL,
  `type` enum('shipping','billing') DEFAULT NULL,
  `primary` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`user_address_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `user_addresses` */

insert  into `user_addresses`(`user_address_id`,`zipcode`,`city_id`,`address`,`user_id`,`type`,`primary`) values (1,NULL,NULL,'alexandria',1,NULL,NULL),(2,NULL,NULL,'84 faisal city, sedibishr',1,'shipping',NULL);

/*Table structure for table `user_phones` */

DROP TABLE IF EXISTS `user_phones`;

CREATE TABLE `user_phones` (
  `user_phone_id` int(11) NOT NULL AUTO_INCREMENT,
  `primary` tinyint(4) DEFAULT NULL,
  `phone` varchar(45) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`user_phone_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;

/*Data for the table `user_phones` */

insert  into `user_phones`(`user_phone_id`,`primary`,`phone`,`user_id`) values (1,1,'87878',1),(2,0,'989898952',2),(11,NULL,'2222222222222',24),(12,NULL,'01212121212',25),(13,NULL,'01221134355',28),(26,NULL,'01221134355',28),(27,NULL,'+201000709113',30);

/*Table structure for table `usergroup_zones` */

DROP TABLE IF EXISTS `usergroup_zones`;

CREATE TABLE `usergroup_zones` (
  `usergroup_zone_id` int(11) NOT NULL AUTO_INCREMENT,
  `usergroup_id` int(11) DEFAULT NULL,
  `module_id` int(11) NOT NULL,
  `permission` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`usergroup_zone_id`)
) ENGINE=InnoDB AUTO_INCREMENT=626 DEFAULT CHARSET=utf8;

/*Data for the table `usergroup_zones` */

insert  into `usergroup_zones`(`usergroup_zone_id`,`usergroup_id`,`module_id`,`permission`) values (538,2,1,'Users'),(539,2,2,'Dashboard'),(540,2,3,'Blog'),(541,3,1,'Sliders'),(542,3,2,'Resume'),(543,3,3,'Tags'),(550,0,1,'Links'),(551,0,1,'Users'),(552,0,1,'Sliders'),(553,0,2,'Settings'),(554,0,2,'Dashboard'),(555,0,2,'Resume'),(556,0,3,'Pages'),(557,0,3,'Blog'),(558,0,3,'Tags'),(559,0,4,'Usergroups'),(560,0,4,'Photos'),(561,0,4,'Categories'),(575,7,1,'Users'),(576,7,1,'Sliders'),(577,7,2,'Dashboard'),(578,7,2,'Resume'),(579,7,3,'Blog'),(580,7,3,'Tags'),(581,7,4,'Photos'),(582,7,4,'Categories'),(589,6,1,'Users'),(590,6,1,'Sliders'),(591,6,2,'Dashboard'),(592,6,2,'Resume'),(593,6,3,'Tags'),(594,6,4,'Usergroups'),(600,5,1,'Links'),(601,5,1,'Sliders'),(602,5,2,'Resume'),(603,5,3,'Tags'),(604,5,4,'Categories'),(605,1,1,'Links'),(606,1,1,'Users'),(607,1,1,'Sliders'),(608,1,2,'Settings'),(609,1,2,'Dashboard'),(610,1,2,'Resume'),(611,1,3,'Pages'),(612,1,3,'Blog'),(613,1,3,'Tags'),(614,1,4,'Usergroups'),(615,1,4,'Photos'),(616,1,4,'Categories'),(617,4,1,'Links'),(618,4,1,'Users'),(619,4,2,'Settings'),(620,4,2,'Dashboard'),(621,4,3,'Pages'),(622,4,3,'Blog'),(623,4,4,'Usergroups'),(624,4,4,'Photos'),(625,4,4,'Categories');

/*Table structure for table `usergroups` */

DROP TABLE IF EXISTS `usergroups`;

CREATE TABLE `usergroups` (
  `usergroup_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`usergroup_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

/*Data for the table `usergroups` */

insert  into `usergroups`(`usergroup_id`,`name`) values (1,'Administrator'),(2,'Employee'),(3,'Banned'),(4,'Membe'),(5,'Mosh Ay 7aga'),(6,'fen'),(7,'kol 7aga');

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `fullname` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(32) DEFAULT NULL,
  `image` text,
  `usergroup_id` int(11) DEFAULT NULL,
  `joindate` datetime DEFAULT NULL,
  `google_id` varchar(300) DEFAULT NULL,
  `facebook_id` varchar(300) DEFAULT NULL,
  `facebook_access_token` text,
  `status` enum('pending','active','banned') DEFAULT 'pending',
  `gender` enum('male','female') DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;

/*Data for the table `users` */

insert  into `users`(`user_id`,`fullname`,`email`,`password`,`image`,`usergroup_id`,`joindate`,`google_id`,`facebook_id`,`facebook_access_token`,`status`,`gender`,`birthdate`) values (1,'Muhammad','m.elsaeed@brightery.com','e10adc3949ba59abbe56e057f20f883e','photo.png',1,'2015-07-23 13:26:03','56',NULL,NULL,'active','male',NULL),(2,'Ahmed Magdy','a_owen1@hotmail.com','e10adc3949ba59abbe56e057f20f883e',NULL,1,'2015-07-23 13:26:00',NULL,NULL,NULL,'active','male','0000-00-00'),(3,'ay 7aga',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'active',NULL,NULL),(5,'Salma','a.magdymedany@gmail.com','111','20094_1420919491571094_1216113210334566482_n.jpg',1,NULL,NULL,NULL,NULL,'active','male',NULL),(28,'Hassan','Hassan@gmail.com','e10adc3949ba59abbe56e057f20f883e',NULL,NULL,NULL,NULL,NULL,NULL,'active','male',NULL),(29,'Marwa','marwa.900@brightery.com','e10adc3949ba59abbe56e057f20f883e','MJSD_Logo_12.jpg',2,NULL,NULL,NULL,NULL,'active','female',NULL),(30,'Muhammad El-Saeed','muhammad@el-saeed.info','e10adc3949ba59abbe56e057f20f883e','wallpaper-nature-3d-1024x6402.jpg',0,NULL,NULL,NULL,NULL,'active','male',NULL);

/*Table structure for table `visibility_status` */

DROP TABLE IF EXISTS `visibility_status`;

CREATE TABLE `visibility_status` (
  `visibility_status_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`visibility_status_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `visibility_status` */

insert  into `visibility_status`(`visibility_status_id`,`name`) values (1,'Visible'),(2,'Invisible');

/*Table structure for table `zones` */

DROP TABLE IF EXISTS `zones`;

CREATE TABLE `zones` (
  `zone_id` int(11) NOT NULL AUTO_INCREMENT,
  `module_id` int(11) NOT NULL,
  `permission` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `var_view` varchar(100) DEFAULT NULL,
  `var_add` varchar(100) DEFAULT NULL,
  `var_edit` varchar(100) DEFAULT NULL,
  `var_delete` varchar(100) DEFAULT NULL,
  `var_print` varchar(100) DEFAULT NULL,
  `desc` text,
  `order` int(11) NOT NULL,
  PRIMARY KEY (`zone_id`),
  UNIQUE KEY `var` (`var_view`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;

/*Data for the table `zones` */

insert  into `zones`(`zone_id`,`module_id`,`permission`,`name`,`var_view`,`var_add`,`var_edit`,`var_delete`,`var_print`,`desc`,`order`) values (4,1,'','Links','links',NULL,NULL,NULL,NULL,NULL,0),(5,3,'','Pages','pages',NULL,NULL,NULL,NULL,NULL,0),(7,2,'','Settings','settings',NULL,NULL,NULL,NULL,NULL,0),(10,4,'','Usergroups','usergroups',NULL,NULL,NULL,NULL,NULL,0),(11,1,'','Users','users',NULL,NULL,NULL,NULL,NULL,0),(12,2,'','Dashboard','dashboard',NULL,NULL,NULL,NULL,NULL,0),(16,3,'','Blog','blogs',NULL,NULL,NULL,NULL,NULL,0),(20,4,'','Photos','photos',NULL,NULL,NULL,NULL,NULL,0),(21,1,'','Sliders','sliders',NULL,NULL,NULL,NULL,NULL,0),(22,2,'','Resume','resume',NULL,NULL,NULL,NULL,NULL,0),(23,3,'','Tags','tags',NULL,NULL,NULL,NULL,NULL,0),(24,4,'','Categories','categories',NULL,NULL,NULL,NULL,NULL,0),(25,0,'','Photo Categories','photo_categories',NULL,NULL,NULL,NULL,NULL,0);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
