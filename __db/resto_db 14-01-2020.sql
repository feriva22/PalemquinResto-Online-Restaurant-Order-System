-- MariaDB dump 10.17  Distrib 10.4.11-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: resto_db
-- ------------------------------------------------------
-- Server version	10.4.11-MariaDB-1:10.4.11+maria~bionic

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `article_tag`
--

DROP TABLE IF EXISTS `article_tag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `article_tag` (
  `atg_id` int(11) NOT NULL AUTO_INCREMENT,
  `atg_name` varchar(45) DEFAULT NULL,
  `atg_desc` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`atg_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `article_tag`
--

LOCK TABLES `article_tag` WRITE;
/*!40000 ALTER TABLE `article_tag` DISABLE KEYS */;
/*!40000 ALTER TABLE `article_tag` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `article_to_tag`
--

DROP TABLE IF EXISTS `article_to_tag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `article_to_tag` (
  `att_tag` int(11) NOT NULL,
  `att_article` int(11) NOT NULL,
  PRIMARY KEY (`att_tag`,`att_article`),
  KEY `fk_article_tag_has_articles_articles1_idx` (`att_article`),
  KEY `fk_article_tag_has_articles_article_tag1_idx` (`att_tag`),
  CONSTRAINT `fk_article_tag_has_articles_article_tag1` FOREIGN KEY (`att_tag`) REFERENCES `article_tag` (`atg_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_article_tag_has_articles_articles1` FOREIGN KEY (`att_article`) REFERENCES `articles` (`art_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `article_to_tag`
--

LOCK TABLES `article_to_tag` WRITE;
/*!40000 ALTER TABLE `article_to_tag` DISABLE KEYS */;
/*!40000 ALTER TABLE `article_to_tag` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `articles`
--

DROP TABLE IF EXISTS `articles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `articles` (
  `art_id` int(11) NOT NULL AUTO_INCREMENT,
  `art_staff` int(11) NOT NULL,
  `art_name` varchar(45) DEFAULT NULL,
  `art_slug` text DEFAULT NULL,
  `art_content` text DEFAULT NULL,
  `art_updated` timestamp NULL DEFAULT NULL,
  `art_created` timestamp NULL DEFAULT NULL,
  `art_status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`art_id`),
  KEY `fk_articles_staff1_idx` (`art_staff`),
  CONSTRAINT `fk_articles_staff1` FOREIGN KEY (`art_staff`) REFERENCES `staff` (`stf_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `articles`
--

LOCK TABLES `articles` WRITE;
/*!40000 ALTER TABLE `articles` DISABLE KEYS */;
INSERT INTO `articles` VALUES (1,1,'ini artikel terbaru bos','ini-artikel-terbaru-bos','<p><img src=\"http://localhost:8080/assets/img/upload/6c9562dcf39c321d2faa7a992897e0ec.jpg\" style=\"width: 149px; height: 128.722px;\">&nbsp;wowowowo&nbsp;<br></p>','2019-12-25 14:59:53','2019-12-25 14:59:53',0);
/*!40000 ALTER TABLE `articles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customer`
--

DROP TABLE IF EXISTS `customer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customer` (
  `cst_id` int(11) NOT NULL AUTO_INCREMENT,
  `cst_name` varchar(45) DEFAULT NULL,
  `cst_phone` varchar(45) DEFAULT NULL,
  `cst_email` varchar(45) DEFAULT NULL,
  `cst_birthday` date DEFAULT NULL,
  `cst_gender` bit(1) DEFAULT NULL,
  `cst_address` varchar(50) DEFAULT NULL,
  `cst_username` varchar(45) DEFAULT NULL,
  `cst_password` varchar(45) DEFAULT NULL,
  `cst_status` tinyint(4) DEFAULT NULL,
  `cst_created` timestamp NULL DEFAULT NULL,
  `cst_updated` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`cst_id`)
) ENGINE=InnoDB AUTO_INCREMENT=62 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customer`
--

LOCK TABLES `customer` WRITE;
/*!40000 ALTER TABLE `customer` DISABLE KEYS */;
/*!40000 ALTER TABLE `customer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `discount`
--

DROP TABLE IF EXISTS `discount`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `discount` (
  `dsc_id` int(11) NOT NULL AUTO_INCREMENT,
  `dsc_name` varchar(45) DEFAULT NULL,
  `dsc_value` int(11) DEFAULT NULL,
  `dsc_unit` tinyint(1) DEFAULT NULL,
  `dsc_expired` timestamp NULL DEFAULT NULL,
  `dsc_status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`dsc_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `discount`
--

LOCK TABLES `discount` WRITE;
/*!40000 ALTER TABLE `discount` DISABLE KEYS */;
INSERT INTO `discount` VALUES (1,'Diskon akhir Tahun 10%',10,2,'2020-12-26 09:23:00',1);
/*!40000 ALTER TABLE `discount` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `invoice`
--

DROP TABLE IF EXISTS `invoice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `invoice` (
  `inv_id` int(11) NOT NULL AUTO_INCREMENT,
  `inv_code` varchar(100) DEFAULT NULL,
  `inv_order` int(11) NOT NULL,
  `inv_customer` int(11) NOT NULL,
  `inv_date` timestamp NULL DEFAULT NULL,
  `inv_duedate` timestamp NULL DEFAULT NULL,
  `inv_paygateway` int(11) NOT NULL,
  `inv_isdp` tinyint(1) DEFAULT NULL,
  `inv_dp` varchar(45) DEFAULT NULL,
  `inv_dpvalue` int(11) DEFAULT NULL,
  `inv_total` int(11) DEFAULT NULL,
  `inv_status` tinyint(1) DEFAULT NULL,
  `inv_created` timestamp NULL DEFAULT NULL,
  `inv_updated` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`inv_id`,`inv_customer`),
  KEY `fk_invoice_order1_idx` (`inv_order`),
  KEY `fk_invoice_customer1_idx` (`inv_customer`),
  KEY `fk_invoice_payment_gateway1_idx` (`inv_paygateway`),
  CONSTRAINT `fk_invoice_customer1` FOREIGN KEY (`inv_customer`) REFERENCES `customer` (`cst_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_invoice_order1` FOREIGN KEY (`inv_order`) REFERENCES `order` (`ord_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_invoice_payment_gateway1` FOREIGN KEY (`inv_paygateway`) REFERENCES `payment_gateway` (`pyg_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `invoice`
--

LOCK TABLES `invoice` WRITE;
/*!40000 ALTER TABLE `invoice` DISABLE KEYS */;
/*!40000 ALTER TABLE `invoice` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menu`
--

DROP TABLE IF EXISTS `menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menu` (
  `mnu_id` int(11) NOT NULL AUTO_INCREMENT,
  `mnu_name` varchar(45) DEFAULT NULL,
  `mnu_desc` varchar(100) DEFAULT NULL,
  `mnu_category` int(11) DEFAULT NULL,
  `mnu_price` int(11) DEFAULT NULL,
  `mnu_photo` varchar(100) DEFAULT NULL,
  `mnu_minorder` varchar(45) DEFAULT NULL,
  `mnu_variant_parent` int(11) DEFAULT NULL,
  `mnu_status` tinyint(4) DEFAULT NULL,
  `mnu_created` timestamp NULL DEFAULT NULL,
  `mnu_updated` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`mnu_id`),
  KEY `fk_menu_menu_category1_idx` (`mnu_category`),
  CONSTRAINT `fk_menu_menu_category1` FOREIGN KEY (`mnu_category`) REFERENCES `menu_category` (`mnc_id`) ON DELETE SET NULL ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menu`
--

LOCK TABLES `menu` WRITE;
/*!40000 ALTER TABLE `menu` DISABLE KEYS */;
INSERT INTO `menu` VALUES (12,'Kambing guling Ukuran 1','kambing guling',3,1000000,'assets/img/upload/e427759267bd89370ebb59fc3c9e6bcf.png','1',0,1,'2020-01-10 20:33:07','2020-01-10 20:33:35');
/*!40000 ALTER TABLE `menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menu_additional`
--

DROP TABLE IF EXISTS `menu_additional`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menu_additional` (
  `mad_id` int(11) NOT NULL AUTO_INCREMENT,
  `mad_name` varchar(45) DEFAULT NULL,
  `mad_price` int(11) DEFAULT NULL,
  `mad_status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`mad_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menu_additional`
--

LOCK TABLES `menu_additional` WRITE;
/*!40000 ALTER TABLE `menu_additional` DISABLE KEYS */;
/*!40000 ALTER TABLE `menu_additional` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menu_additionalitem`
--

DROP TABLE IF EXISTS `menu_additionalitem`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menu_additionalitem` (
  `mai_menu` int(11) NOT NULL,
  `mai_menuadditional` int(11) NOT NULL,
  PRIMARY KEY (`mai_menu`,`mai_menuadditional`),
  KEY `fk_menu_has_menu_aditional_menu1_idx` (`mai_menu`),
  KEY `fk_menu_additionalitem_menu_additionalopt1_idx` (`mai_menuadditional`),
  CONSTRAINT `fk_menu_additionalitem_menu_additionalopt1` FOREIGN KEY (`mai_menuadditional`) REFERENCES `menu_additional` (`mad_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_menu_has_menu_aditional_menu1` FOREIGN KEY (`mai_menu`) REFERENCES `menu` (`mnu_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menu_additionalitem`
--

LOCK TABLES `menu_additionalitem` WRITE;
/*!40000 ALTER TABLE `menu_additionalitem` DISABLE KEYS */;
/*!40000 ALTER TABLE `menu_additionalitem` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menu_category`
--

DROP TABLE IF EXISTS `menu_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menu_category` (
  `mnc_id` int(11) NOT NULL AUTO_INCREMENT,
  `mnc_name` varchar(45) DEFAULT NULL,
  `mnc_status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`mnc_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menu_category`
--

LOCK TABLES `menu_category` WRITE;
/*!40000 ALTER TABLE `menu_category` DISABLE KEYS */;
INSERT INTO `menu_category` VALUES (1,'Nasi Kotak',1),(2,'Aqiqah',1),(3,'Kambing guling',1),(4,'Tumpeng',1),(5,'Prasmanan',1),(6,'Restoran',1);
/*!40000 ALTER TABLE `menu_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `module`
--

DROP TABLE IF EXISTS `module`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `module` (
  `mdl_id` int(11) NOT NULL AUTO_INCREMENT,
  `mdl_name` varchar(45) DEFAULT NULL,
  `mdl_desc` varchar(45) DEFAULT NULL,
  `mdl_relativeurl` varchar(45) DEFAULT NULL,
  `mdl_status` tinyint(4) NOT NULL,
  PRIMARY KEY (`mdl_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `module`
--

LOCK TABLES `module` WRITE;
/*!40000 ALTER TABLE `module` DISABLE KEYS */;
INSERT INTO `module` VALUES (1,'kategori_menu','kategori menu','kategori_menu',1),(2,'menu_tambahan','menu tambahan','menu_tambahan',1),(3,'manajemen_staff','manajemen staff','manajemen_staff',1),(4,'diskon','diskon','diskon',1),(5,'artikel','artikel','artikel',1),(6,'pelanggan','pelanggan','pelanggan',1),(7,'menu','menu','menu',1),(8,'daftar_pajak','daftar pajak','daftar_pajak',1),(9,'pemesanan','pemesanan','pemesanan',1),(10,'payment_gateway','payment gateway','payment_gateway',1),(11,'meja_reservasi','meja reservasi meja','meja_reservasi',1),(13,'invoice','list invoice','invoice',1),(14,'transaksi','transaksi','transaksi',1),(15,'laporan','laporan','laporan',1),(16,'konfigurasi','konfigurasi','konfigurasi',1);
/*!40000 ALTER TABLE `module` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `moduleaccess`
--

DROP TABLE IF EXISTS `moduleaccess`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `moduleaccess` (
  `mda_id` int(11) NOT NULL AUTO_INCREMENT,
  `mda_module` int(11) NOT NULL,
  `mda_staffgroup` int(11) NOT NULL,
  `mda_create` bit(1) NOT NULL DEFAULT b'0',
  `mda_read` bit(1) NOT NULL DEFAULT b'0',
  `mda_update` bit(1) NOT NULL DEFAULT b'0',
  `mda_delete` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`mda_id`,`mda_module`,`mda_staffgroup`),
  KEY `fk_moduleaccess_staffgroup_idx` (`mda_staffgroup`),
  KEY `fk_moduleaccess_module_idx` (`mda_module`),
  CONSTRAINT `fk_moduleaccess_module` FOREIGN KEY (`mda_module`) REFERENCES `module` (`mdl_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_moduleaccess_staffgroup` FOREIGN KEY (`mda_staffgroup`) REFERENCES `staffgroup` (`sdg_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `moduleaccess`
--

LOCK TABLES `moduleaccess` WRITE;
/*!40000 ALTER TABLE `moduleaccess` DISABLE KEYS */;
INSERT INTO `moduleaccess` VALUES (4,1,1,'','','',''),(5,2,1,'','','',''),(6,3,1,'','','',''),(7,4,1,'','','',''),(8,5,1,'','','',''),(9,6,1,'','','',''),(10,7,1,'','','',''),(11,8,1,'','','',''),(12,9,1,'','','','\0'),(13,10,1,'','','',''),(14,11,1,'','','',''),(16,1,2,'\0','','\0','\0'),(17,2,2,'\0','','\0','\0'),(18,3,2,'\0','\0','\0','\0'),(19,4,2,'\0','','\0','\0'),(20,5,2,'\0','','\0','\0'),(21,6,2,'','','',''),(22,7,2,'\0','','\0','\0'),(23,8,2,'\0','','\0','\0'),(24,9,2,'','','',''),(25,10,2,'\0','','\0','\0'),(26,11,2,'\0','','\0','\0'),(27,13,1,'','','',''),(28,14,1,'','','',''),(29,15,1,'','','',''),(30,16,1,'','','','');
/*!40000 ALTER TABLE `moduleaccess` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `modulemenu`
--

DROP TABLE IF EXISTS `modulemenu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `modulemenu` (
  `mdm_id` int(11) NOT NULL AUTO_INCREMENT,
  `mdm_staffgroup` int(11) NOT NULL,
  `mdm_title` varchar(45) DEFAULT NULL,
  `mdm_url` varchar(45) DEFAULT NULL,
  `mdm_parent` int(11) DEFAULT NULL,
  `mdm_group` varchar(45) DEFAULT NULL,
  `mdm_order` smallint(6) DEFAULT NULL,
  `mdm_status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`mdm_id`),
  KEY `fk_moduleoption_staffgroup_idx` (`mdm_staffgroup`),
  CONSTRAINT `fk_moduleoption_staffgroup` FOREIGN KEY (`mdm_staffgroup`) REFERENCES `staffgroup` (`sdg_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `modulemenu`
--

LOCK TABLES `modulemenu` WRITE;
/*!40000 ALTER TABLE `modulemenu` DISABLE KEYS */;
/*!40000 ALTER TABLE `modulemenu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order`
--

DROP TABLE IF EXISTS `order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order` (
  `ord_id` int(11) NOT NULL AUTO_INCREMENT,
  `ord_code` varchar(100) DEFAULT NULL,
  `ord_fordate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `ord_date` timestamp NULL DEFAULT NULL,
  `ord_isdelivery` tinyint(1) DEFAULT NULL,
  `ord_delivaddress` varchar(100) DEFAULT NULL,
  `ord_delivcity` varchar(45) DEFAULT NULL,
  `ord_delivprovince` varchar(45) DEFAULT NULL,
  `ord_delivzip` int(11) DEFAULT NULL,
  `ord_subtotal` int(11) DEFAULT NULL,
  `ord_total` int(11) DEFAULT NULL,
  `ord_discount` int(11) DEFAULT NULL,
  `ord_type` tinyint(4) DEFAULT NULL,
  `ord_status` tinyint(4) DEFAULT NULL,
  `ord_created` timestamp NULL DEFAULT NULL,
  `ord_updated` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`ord_id`),
  KEY `fk_order_discount1_idx` (`ord_discount`),
  CONSTRAINT `fk_order_discount1` FOREIGN KEY (`ord_discount`) REFERENCES `discount` (`dsc_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=104 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order`
--

LOCK TABLES `order` WRITE;
/*!40000 ALTER TABLE `order` DISABLE KEYS */;
/*!40000 ALTER TABLE `order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_menu`
--

DROP TABLE IF EXISTS `order_menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_menu` (
  `odm_id` int(11) NOT NULL AUTO_INCREMENT,
  `odm_menu` int(11) NOT NULL,
  `odm_order` int(11) NOT NULL,
  `odm_quantity` int(11) DEFAULT NULL,
  `odm_price` int(11) DEFAULT NULL,
  `odm_total` int(11) DEFAULT NULL,
  `odm_note` text DEFAULT NULL,
  PRIMARY KEY (`odm_id`,`odm_menu`,`odm_order`),
  KEY `fk_order_menu_menu1_idx` (`odm_menu`),
  KEY `fk_order_menu_order1_idx` (`odm_order`),
  CONSTRAINT `fk_order_menu_menu1` FOREIGN KEY (`odm_menu`) REFERENCES `menu` (`mnu_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_order_menu_order1` FOREIGN KEY (`odm_order`) REFERENCES `order` (`ord_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_menu`
--

LOCK TABLES `order_menu` WRITE;
/*!40000 ALTER TABLE `order_menu` DISABLE KEYS */;
/*!40000 ALTER TABLE `order_menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_menuadditional`
--

DROP TABLE IF EXISTS `order_menuadditional`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_menuadditional` (
  `oma_id` int(11) NOT NULL AUTO_INCREMENT,
  `oma_ordermenu` int(11) NOT NULL,
  `oma_menuadditional` int(11) NOT NULL,
  `oma_quantity` int(11) DEFAULT NULL,
  `oma_total` int(11) DEFAULT NULL,
  PRIMARY KEY (`oma_id`),
  KEY `fk_order_menuadditional_order_menu1_idx` (`oma_ordermenu`),
  KEY `fk_order_menuadditional_menu_additional1_idx` (`oma_menuadditional`),
  CONSTRAINT `fk_order_menuadditional_menu_additional1` FOREIGN KEY (`oma_menuadditional`) REFERENCES `menu_additional` (`mad_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_order_menuadditional_order_menu1` FOREIGN KEY (`oma_ordermenu`) REFERENCES `order_menu` (`odm_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_menuadditional`
--

LOCK TABLES `order_menuadditional` WRITE;
/*!40000 ALTER TABLE `order_menuadditional` DISABLE KEYS */;
/*!40000 ALTER TABLE `order_menuadditional` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_reservation`
--

DROP TABLE IF EXISTS `order_reservation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_reservation` (
  `odr_id` int(11) NOT NULL AUTO_INCREMENT,
  `odr_order` int(11) NOT NULL,
  `odr_table` int(11) NOT NULL,
  `odr_start` timestamp NULL DEFAULT NULL,
  `odr_end` timestamp NULL DEFAULT NULL,
  `odr_people` int(11) DEFAULT NULL,
  `odr_status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`odr_id`,`odr_order`),
  KEY `fk_order_reservation_order1_idx` (`odr_order`),
  CONSTRAINT `fk_order_reservation_order1` FOREIGN KEY (`odr_order`) REFERENCES `order` (`ord_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_reservation`
--

LOCK TABLES `order_reservation` WRITE;
/*!40000 ALTER TABLE `order_reservation` DISABLE KEYS */;
/*!40000 ALTER TABLE `order_reservation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_tax`
--

DROP TABLE IF EXISTS `order_tax`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_tax` (
  `ort_order` int(11) NOT NULL,
  `ort_tax` int(11) NOT NULL,
  PRIMARY KEY (`ort_order`,`ort_tax`),
  KEY `fk_order_has_tax_tax1_idx` (`ort_tax`),
  KEY `fk_order_has_tax_order1_idx` (`ort_order`),
  CONSTRAINT `fk_order_has_tax_order1` FOREIGN KEY (`ort_order`) REFERENCES `order` (`ord_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_order_has_tax_tax1` FOREIGN KEY (`ort_tax`) REFERENCES `tax` (`tax_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_tax`
--

LOCK TABLES `order_tax` WRITE;
/*!40000 ALTER TABLE `order_tax` DISABLE KEYS */;
/*!40000 ALTER TABLE `order_tax` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payment_gateway`
--

DROP TABLE IF EXISTS `payment_gateway`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payment_gateway` (
  `pyg_id` int(11) NOT NULL AUTO_INCREMENT,
  `pyg_name` varchar(45) DEFAULT NULL,
  `pyg_detail` varchar(100) DEFAULT NULL,
  `pyg_type` tinyint(1) DEFAULT NULL,
  `pyg_status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`pyg_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payment_gateway`
--

LOCK TABLES `payment_gateway` WRITE;
/*!40000 ALTER TABLE `payment_gateway` DISABLE KEYS */;
INSERT INTO `payment_gateway` VALUES (1,'Bank BRI','No rek 081223123123 A/N Herry',2,1);
/*!40000 ALTER TABLE `payment_gateway` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `resto_sessions`
--

DROP TABLE IF EXISTS `resto_sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `resto_sessions` (
  `id` varchar(40) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) unsigned NOT NULL DEFAULT 0,
  `data` blob NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ci_sessions_timestamp` (`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `resto_sessions`
--

LOCK TABLES `resto_sessions` WRITE;
/*!40000 ALTER TABLE `resto_sessions` DISABLE KEYS */;
INSERT INTO `resto_sessions` VALUES ('0f34f79375849e28bc6a6645ed094170e545bac0','172.22.0.1',1578978347,'__ci_last_regenerate|i:1578978347;userID|s:1:\"1\";userName|s:5:\"admin\";userGroup|s:1:\"1\";loginStatus|b:1;'),('1fbe3fa9427db1568ffcadc6678819c5978edae8','172.22.0.1',1578978662,'__ci_last_regenerate|i:1578978662;userID|s:1:\"1\";userName|s:5:\"admin\";userGroup|s:1:\"1\";loginStatus|b:1;'),('252f6f5c349662efaeb490676e93658f5feca953','172.22.0.1',1578978663,'__ci_last_regenerate|i:1578978662;userID|s:1:\"1\";userName|s:5:\"admin\";userGroup|s:1:\"1\";loginStatus|b:1;'),('92f07df67dfbe2d2f485f6d161320cd8d561704a','172.22.0.1',1579009984,'__ci_last_regenerate|i:1579009958;userID|s:1:\"1\";userName|s:5:\"admin\";userGroup|s:1:\"1\";loginStatus|b:1;'),('aabe84879ca9fac6986108b2f2b6890e360ce639','172.22.0.1',1578971392,'__ci_last_regenerate|i:1578971392;userID|s:1:\"1\";userName|s:5:\"admin\";userGroup|s:1:\"1\";loginStatus|b:1;'),('b13abb69089a0de926b4a7740f3e60e6cf257153','172.22.0.1',1578972132,'__ci_last_regenerate|i:1578972132;userID|s:1:\"1\";userName|s:5:\"admin\";userGroup|s:1:\"1\";loginStatus|b:1;');
/*!40000 ALTER TABLE `resto_sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `setting`
--

DROP TABLE IF EXISTS `setting`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `setting` (
  `stg_name` varchar(45) NOT NULL,
  `stg_value` text DEFAULT NULL,
  `stg_description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`stg_name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `setting`
--

LOCK TABLES `setting` WRITE;
/*!40000 ALTER TABLE `setting` DISABLE KEYS */;
INSERT INTO `setting` VALUES ('default_mindp','60','minim dp adalah 50%'),('invoiceend_default','1 days','maksimal hari pembayaran invoice normal'),('invoiceend_finaldp','15 days','maksimal hari pembayaran invoice final dp '),('reservationend_default','60','ini adalah default time end reservation dalam menit'),('tablemap_img','assets/img/default/8ddaec346d0ba08f482ba2bddc2d8cd9.jpg','ini adalah deskripsi foto map');
/*!40000 ALTER TABLE `setting` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `staff`
--

DROP TABLE IF EXISTS `staff`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `staff` (
  `stf_id` int(11) NOT NULL AUTO_INCREMENT,
  `stf_name` varchar(45) DEFAULT NULL,
  `stf_username` varchar(45) NOT NULL,
  `stf_email` varchar(45) DEFAULT NULL,
  `stf_password` varchar(100) DEFAULT NULL,
  `stf_lastlogin` timestamp NULL DEFAULT NULL,
  `stf_status` tinyint(4) DEFAULT NULL,
  `stf_created` timestamp NULL DEFAULT NULL,
  `stf_updated` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`stf_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `staff`
--

LOCK TABLES `staff` WRITE;
/*!40000 ALTER TABLE `staff` DISABLE KEYS */;
INSERT INTO `staff` VALUES (1,'admin','admin','','$2y$10$PTCzElMUzwPgGa5/E9u/uO272mkHiflyp6qVVpeFVhkqAiUiXlori','2020-01-14 20:52:42',1,NULL,'2019-12-19 15:59:52');
/*!40000 ALTER TABLE `staff` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `staffgroup`
--

DROP TABLE IF EXISTS `staffgroup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `staffgroup` (
  `sdg_id` int(11) NOT NULL AUTO_INCREMENT,
  `sdg_name` varchar(45) DEFAULT NULL,
  `sdg_desc` varchar(255) DEFAULT NULL,
  `sdg_status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`sdg_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `staffgroup`
--

LOCK TABLES `staffgroup` WRITE;
/*!40000 ALTER TABLE `staffgroup` DISABLE KEYS */;
INSERT INTO `staffgroup` VALUES (1,'admin','admin',1),(2,'cashier','cashier',1);
/*!40000 ALTER TABLE `staffgroup` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `staffgroupaccess`
--

DROP TABLE IF EXISTS `staffgroupaccess`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `staffgroupaccess` (
  `sga_staffgroup` int(11) NOT NULL,
  `sga_staff` int(11) NOT NULL,
  PRIMARY KEY (`sga_staffgroup`,`sga_staff`),
  KEY `fk_staffgroupaccess_staff_idx` (`sga_staff`),
  KEY `fk_staffgroupaccess_staffgroup_idx` (`sga_staffgroup`),
  CONSTRAINT `fk_staffgroupaccess_staff` FOREIGN KEY (`sga_staffgroup`) REFERENCES `staffgroup` (`sdg_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_staffgroupaccess_staffgroup` FOREIGN KEY (`sga_staff`) REFERENCES `staff` (`stf_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `staffgroupaccess`
--

LOCK TABLES `staffgroupaccess` WRITE;
/*!40000 ALTER TABLE `staffgroupaccess` DISABLE KEYS */;
INSERT INTO `staffgroupaccess` VALUES (1,1);
/*!40000 ALTER TABLE `staffgroupaccess` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `stafflog`
--

DROP TABLE IF EXISTS `stafflog`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `stafflog` (
  `sdl_id` int(11) NOT NULL AUTO_INCREMENT,
  `sdl_module` varchar(45) DEFAULT NULL,
  `sdl_action` varchar(30) DEFAULT NULL,
  `sdl_staff` int(11) DEFAULT NULL,
  `sdl_date` datetime DEFAULT NULL,
  `sdl_note` text DEFAULT NULL,
  `sdl_ip` varchar(16) DEFAULT NULL,
  PRIMARY KEY (`sdl_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stafflog`
--

LOCK TABLES `stafflog` WRITE;
/*!40000 ALTER TABLE `stafflog` DISABLE KEYS */;
/*!40000 ALTER TABLE `stafflog` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `table_map`
--

DROP TABLE IF EXISTS `table_map`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `table_map` (
  `tbm_id` int(11) NOT NULL AUTO_INCREMENT,
  `tbm_name` varchar(45) DEFAULT NULL,
  `tbm_max` int(11) DEFAULT NULL,
  `tbm_min` int(11) DEFAULT NULL,
  `tbm_attr` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`tbm_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `table_map`
--

LOCK TABLES `table_map` WRITE;
/*!40000 ALTER TABLE `table_map` DISABLE KEYS */;
INSERT INTO `table_map` VALUES (1,'1',5,2,'{\"loc_x\":\"54\",\"loc_y\":\"272\",\"rad_circle\":\"15\",\"text_size\":\"20\"}'),(2,'2',1,1,'{\"loc_x\":\"51\",\"loc_y\":\"328\",\"rad_circle\":\"15\",\"text_size\":\"20\"}'),(3,'3',1,1,'{\"loc_x\":\"175\",\"loc_y\":\"170\",\"rad_circle\":\"15\",\"text_size\":\"20\"}'),(4,'4',14,2,'{\"loc_x\":\"175\",\"loc_y\":\"203\",\"rad_circle\":\"15\",\"text_size\":\"20\"}'),(5,'5',1,1,'{\"loc_x\":\"235\",\"loc_y\":\"170\",\"rad_circle\":\"15\",\"text_size\":\"20\"}');
/*!40000 ALTER TABLE `table_map` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tax`
--

DROP TABLE IF EXISTS `tax`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tax` (
  `tax_id` int(11) NOT NULL AUTO_INCREMENT,
  `tax_name` varchar(45) DEFAULT NULL,
  `tax_description` varchar(45) DEFAULT NULL,
  `tax_value` int(11) DEFAULT NULL,
  `tax_unit` tinyint(1) DEFAULT NULL,
  `tax_status` tinyint(1) DEFAULT NULL,
  `tax_created` timestamp NULL DEFAULT NULL,
  `tax_updated` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`tax_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tax`
--

LOCK TABLES `tax` WRITE;
/*!40000 ALTER TABLE `tax` DISABLE KEYS */;
INSERT INTO `tax` VALUES (1,'PPn 10%','pajak negara 10%',10,1,0,'2019-12-25 07:01:02','2019-12-25 07:01:02'),(2,'PPn 10%','ppn 10%',10,2,1,'2019-12-25 07:04:10','2019-12-25 07:04:10'),(3,'PB1','Pajak bangunan 1 10%',10,2,1,'2019-12-26 08:09:24','2019-12-26 08:09:37'),(4,'Pajak jalan 40 rb','pajak jalan 40 rb',40000,1,1,'2019-12-27 23:41:53','2019-12-27 23:41:53');
/*!40000 ALTER TABLE `tax` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transaction`
--

DROP TABLE IF EXISTS `transaction`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transaction` (
  `trs_id` int(11) NOT NULL AUTO_INCREMENT,
  `trs_code` varchar(45) DEFAULT NULL,
  `trs_date` timestamp NULL DEFAULT NULL,
  `trs_invoicecode` varchar(100) DEFAULT NULL,
  `trs_paygateway` varchar(45) DEFAULT NULL,
  `trs_total` int(11) DEFAULT NULL,
  `trs_name` varchar(45) DEFAULT NULL,
  `trs_email` varchar(45) DEFAULT NULL,
  `trs_note` varchar(100) DEFAULT NULL,
  `trs_photo` varchar(255) DEFAULT NULL,
  `trs_status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`trs_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transaction`
--

LOCK TABLES `transaction` WRITE;
/*!40000 ALTER TABLE `transaction` DISABLE KEYS */;
/*!40000 ALTER TABLE `transaction` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-01-14 14:22:03
