# WordPress MySQL database backup
#
# Generated: Tuesday 23. July 2013 16:49 EDT
# Hostname: localhost
# Database: `stuyspec_tator`
# --------------------------------------------------------
# --------------------------------------------------------
# Table: `wp_commentmeta`
# --------------------------------------------------------


#
# Delete any existing table `wp_commentmeta`
#

DROP TABLE IF EXISTS `wp_commentmeta`;


#
# Table structure of table `wp_commentmeta`
#

CREATE TABLE `wp_commentmeta` (
  `meta_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `comment_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `meta_key` varchar(255) DEFAULT NULL,
  `meta_value` longtext,
  PRIMARY KEY (`meta_id`),
  KEY `comment_id` (`comment_id`),
  KEY `meta_key` (`meta_key`)
) ENGINE=MyISAM AUTO_INCREMENT=236244 DEFAULT CHARSET=utf8 ;

#
# Data contents of table `wp_commentmeta`
#
