/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

DROP TABLE IF EXISTS `endpoint`;

CREATE TABLE `endpoint` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `url` varchar(255) NOT NULL DEFAULT '',
  `status` varchar(10) NOT NULL DEFAULT 'new',
  `http_code` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_url` (`url`),
  KEY `status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `endpoint` WRITE;
/*!40000 ALTER TABLE `endpoint` DISABLE KEYS */;

INSERT INTO `endpoint` (`id`, `url`, `status`, `http_code`)
VALUES
	(2,'https://google.com','new',NULL),
	(3,'https://invalid.example.dest.com/123edcsr3','new',NULL),
	(5,'https://www.onet.pl/','new',NULL),
	(6,'notanadress','new',NULL),
	(8,'https://pl.wikipedia.org/404','new',NULL),
	(9,'http://delicious.com','new',NULL),
	(10,'http://behance.net','new',NULL),
	(11,'http://photobucket.com','new',NULL),
	(12,'http://creativecommons.org','new',NULL),
	(13,'http://scientificamerican.com','new',NULL),
	(14,'http://vistaprint.com','new',NULL),
	(15,'http://drupal.org','new',NULL),
	(16,'http://cafepress.com','new',NULL),
	(17,'http://engadget.com','new',NULL),
	(18,'http://freewebs.com','new',NULL),
	(19,'http://cdbaby.com','new',NULL),
	(20,'http://miitbeian.gov.cn','new',NULL),
	(21,'http://eepurl.com','new',NULL),
	(22,'http://liveinternet.ru','new',NULL),
	(23,'http://rambler.ru','new',NULL),
	(24,'http://1688.com','new',NULL),
	(25,'http://blogs.com','new',NULL),
	(26,'http://tamu.edu','new',NULL),
	(27,'http://fema.gov','new',NULL),
	(28,'http://imgur.com','new',NULL),
	(29,'http://eventbrite.com','new',NULL),
	(30,'http://whitehouse.gov','new',NULL),
	(31,'http://kickstarter.com','new',NULL),
	(32,'http://techcrunch.com','new',NULL),
	(33,'http://sakura.ne.jp','new',NULL),
	(34,'http://blogger.com','new',NULL),
	(35,'http://umn.edu','new',NULL),
	(36,'http://irs.gov','new',NULL),
	(37,'http://trellian.com','new',NULL),
	(38,'http://simplemachines.org','new',NULL),
	(39,'http://ustream.tv','new',NULL),
	(40,'http://patch.com','new',NULL),
	(41,'http://reuters.com','new',NULL),
	(42,'http://chronoengine.com','new',NULL),
	(43,'http://woothemes.com','new',NULL),
	(44,'http://posterous.com','new',NULL),
	(45,'http://ihg.com','new',NULL),
	(46,'http://icq.com','new',NULL),
	(47,'http://slideshare.net','new',NULL),
	(48,'http://google.cn','new',NULL),
	(49,'http://cam.ac.uk','new',NULL),
	(50,'http://istockphoto.com','new',NULL),
	(51,'http://msu.edu','new',NULL),
	(52,'http://google.com.hk','new',NULL),
	(53,'http://boston.com','new',NULL),
	(54,'http://samsung.com','new',NULL),
	(55,'http://google.es','new',NULL),
	(56,'http://bbc.co.uk','new',NULL),
	(57,'http://tripod.com','new',NULL),
	(58,'http://guardian.co.uk','new',NULL),
	(59,'http://pinterest.com','new',NULL),
	(60,'http://mac.com','new',NULL),
	(61,'http://issuu.com','new',NULL),
	(62,'http://facebook.com','new',NULL),
	(63,'http://mediafire.com','new',NULL),
	(64,'http://mail.ru','new',NULL),
	(65,'http://barnesandnoble.com','new',NULL),
	(66,'http://dagondesign.com','new',NULL),
	(67,'http://nasa.gov','new',NULL),
	(68,'http://clickbank.net','new',NULL),
	(69,'http://skype.com','new',NULL),
	(70,'http://alexa.com','new',NULL),
	(71,'http://cyberchimps.com','new',NULL),
	(72,'http://randomlists.com','new',NULL),
	(73,'http://stumbleupon.com','new',NULL),
	(74,'http://diigo.com','new',NULL),
	(75,'http://homestead.com','new',NULL),
	(76,'http://biglobe.ne.jp','new',NULL),
	(77,'http://geocities.jp','new',NULL),
	(78,'http://indiegogo.com','new',NULL),
	(79,'http://macromedia.com','new',NULL),
	(80,'http://indiatimes.com','new',NULL),
	(81,'http://hubpages.com','new',NULL),
	(82,'http://yale.edu','new',NULL),
	(83,'http://pbs.org','new',NULL),
	(84,'http://disqus.com','new',NULL),
	(85,'http://unc.edu','new',NULL),
	(86,'http://elpais.com','new',NULL),
	(87,'http://goodreads.com','new',NULL),
	(88,'http://princeton.edu','new',NULL),
	(89,'http://cloudflare.com','new',NULL),
	(90,'http://washingtonpost.com','new',NULL),
	(91,'http://smugmug.com','new',NULL),
	(92,'http://deliciousdays.com','new',NULL),
	(93,'http://nifty.com','new',NULL),
	(94,'http://desdev.cn','new',NULL),
	(95,'http://ocn.ne.jp','new',NULL),
	(96,'http://ezinearticles.com','new',NULL),
	(97,'http://webeden.co.uk','new',NULL),
	(98,'http://tiny.cc','new',NULL),
	(99,'http://nymag.com','new',NULL),
	(100,'http://usa.gov','new',NULL),
	(101,'http://chicagotribune.com','new',NULL),
	(102,'http://skyrock.com','new',NULL),
	(103,'http://cargocollective.com','new',NULL),
	(104,'http://ed.gov','new',NULL),
	(105,'http://imdb.com','new',NULL),
	(106,'http://purevolume.com','new',NULL),
	(107,'http://stanford.edu','new',NULL),
	(108,'http://google.ru','new',NULL);

/*!40000 ALTER TABLE `endpoint` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
