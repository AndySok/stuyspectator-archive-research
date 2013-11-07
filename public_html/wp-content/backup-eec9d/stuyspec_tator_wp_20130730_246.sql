# WordPress MySQL database backup
#
# Generated: Tuesday 30. July 2013 00:55 EDT
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
) ENGINE=MyISAM AUTO_INCREMENT=237365 DEFAULT CHARSET=utf8 ;

#
# Data contents of table `wp_commentmeta`
#
 
INSERT INTO `wp_commentmeta` VALUES (311, 3954, 'akismet_result', 'false'); 
INSERT INTO `wp_commentmeta` VALUES (312, 3954, 'akismet_history', 'a:4:{s:4:"time";s:13:"1301168763.63";s:7:"message";s:28:"Akismet cleared this comment";s:5:"event";s:9:"check-ham";s:4:"user";s:0:"";}'); 
INSERT INTO `wp_commentmeta` VALUES (314, 3954, 'akismet_history', 'a:4:{s:4:"time";s:13:"1301170356.36";s:7:"message";s:43:"john changed the comment status to approved";s:5:"event";s:15:"status-approved";s:4:"user";s:4:"john";}'); 
INSERT INTO `wp_commentmeta` VALUES (416, 3989, 'akismet_result', 'false'); 
INSERT INTO `wp_commentmeta` VALUES (417, 3989, 'akismet_history', 'a:4:{s:4:"time";s:13:"1301756337.09";s:7:"message";s:28:"Akismet cleared this comment";s:5:"event";s:9:"check-ham";s:4:"user";s:0:"";}'); 
INSERT INTO `wp_commentmeta` VALUES (324, 3958, 'akismet_result', 'false'); 
INSERT INTO `wp_commentmeta` VALUES (325, 3958, 'akismet_history', 'a:4:{s:4:"time";s:12:"1301256149.2";s:7:"message";s:28:"Akismet cleared this comment";s:5:"event";s:9:"check-ham";s:4:"user";s:0:"";}'); 
INSERT INTO `wp_commentmeta` VALUES (330, 3958, 'akismet_history', 'a:4:{s:4:"time";s:13:"1301261297.02";s:7:"message";s:43:"Leah changed the comment status to approved";s:5:"event";s:15:"status-approved";s:4:"user";s:4:"Leah";}'); 
INSERT INTO `wp_commentmeta` VALUES (413, 3988, 'akismet_result', 'false'); 
INSERT INTO `wp_commentmeta` VALUES (414, 3988, 'akismet_history', 'a:4:{s:4:"time";s:13:"1301756113.57";s:7:"message";s:28:"Akismet cleared this comment";s:5:"event";s:9:"check-ham";s:4:"user";s:0:"";}'); 
INSERT INTO `wp_commentmeta` VALUES (410, 3987, 'akismet_result', 'false'); 
INSERT INTO `wp_commentmeta` VALUES (411, 3987, 'akismet_history', 'a:4:{s:4:"time";s:13:"1301755407.05";s:7:"message";s:28:"Akismet cleared this comment";s:5:"event";s:9:"check-ham";s:4:"user";s:0:"";}'); 
INSERT INTO `wp_commentmeta` VALUES (44, 3821, 'akismet_history', 'a:4:{s:4:"time";s:13:"1299964792.93";s:7:"message";s:43:"john changed the comment status to approved";s:5:"event";s:15:"status-approved";s:4:"user";s:4:"john";}'); 
INSERT INTO `wp_commentmeta` VALUES (331, 3960, 'akismet_history', 'a:4:{s:4:"time";s:13:"1301357536.69";s:7:"message";s:43:"john changed the comment status to approved";s:5:"event";s:15:"status-approved";s:4:"user";s:4:"john";}'); 
INSERT INTO `wp_commentmeta` VALUES (77, 3882, 'akismet_result', 'false'); 
INSERT INTO `wp_commentmeta` VALUES (78, 3882, 'akismet_history', 'a:4:{s:4:"time";s:10:"1300044127";s:7:"message";s:28:"Akismet cleared this comment";s:5:"event";s:9:"check-ham";s:4:"user";s:0:"";}'); 
INSERT INTO `wp_commentmeta` VALUES (80, 3882, 'akismet_history', 'a:4:{s:4:"time";s:13:"1300045426.33";s:7:"message";s:44:"vijendra changed the comment status to trash";s:5:"event";s:12:"status-trash";s:4:"user";s:8:"vijendra";}'); 
INSERT INTO `wp_commentmeta` VALUES (92, 3882, 'akismet_history', 'a:4:{s:4:"time";s:13:"1300060398.54";s:7:"message";s:43:"john changed the comment status to approved";s:5:"event";s:15:"status-approved";s:4:"user";s:4:"john";}'); 
INSERT INTO `wp_commentmeta` VALUES (93, 3883, 'akismet_result', 'false'); 
INSERT INTO `wp_commentmeta` VALUES (94, 3883, 'akismet_history', 'a:4:{s:4:"time";s:13:"1300060544.92";s:7:"message";s:28:"Akismet cleared this comment";s:5:"event";s:9:"check-ham";s:4:"user";s:0:"";}'); 
INSERT INTO `wp_commentmeta` VALUES (96, 3883, 'akismet_history', 'a:4:{s:4:"time";s:13:"1300060924.93";s:7:"message";s:43:"john changed the comment status to approved";s:5:"event";s:15:"status-approved";s:4:"user";s:4:"john";}'); 
INSERT INTO `wp_commentmeta` VALUES (97, 3884, 'akismet_result', 'false'); 
INSERT INTO `wp_commentmeta` VALUES (98, 3884, 'akismet_history', 'a:4:{s:4:"time";s:13:"1300080700.46";s:7:"message";s:28:"Akismet cleared this comment";s:5:"event";s:9:"check-ham";s:4:"user";s:0:"";}'); 
INSERT INTO `wp_commentmeta` VALUES (106, 3884, 'akismet_history', 'a:4:{s:4:"time";s:13:"1300149655.11";s:7:"message";s:43:"john changed the comment status to approved";s:5:"event";s:15:"status-approved";s:4:"user";s:4:"john";}'); 
INSERT INTO `wp_commentmeta` VALUES (374, 3975, 'akismet_result', 'false'); 
INSERT INTO `wp_commentmeta` VALUES (375, 3975, 'akismet_history', 'a:4:{s:4:"time";s:13:"1301744165.65";s:7:"message";s:28:"Akismet cleared this comment";s:5:"event";s:9:"check-ham";s:4:"user";s:0:"";}'); 
INSERT INTO `wp_commentmeta` VALUES (230, 3928, 'akismet_result', 'false'); 
INSERT INTO `wp_commentmeta` VALUES (231, 3928, 'akismet_history', 'a:4:{s:4:"time";s:13:"1300892746.27";s:7:"message";s:28:"Akismet cleared this comment";s:5:"event";s:9:"check-ham";s:4:"user";s:0:"";}'); 
INSERT INTO `wp_commentmeta` VALUES (239, 3928, 'akismet_history', 'a:4:{s:4:"time";s:13:"1300918595.66";s:7:"message";s:43:"Leah changed the comment status to approved";s:5:"event";s:15:"status-approved";s:4:"user";s:4:"Leah";}'); 
INSERT INTO `wp_commentmeta` VALUES (288, 3947, 'akismet_result', 'false'); 
INSERT INTO `wp_commentmeta` VALUES (289, 3947, 'akismet_history', 'a:4:{s:4:"time";s:13:"1301024267.75";s:7:"message";s:28:"Akismet cleared this comment";s:5:"event";s:9:"check-ham";s:4:"user";s:0:"";}'); 
INSERT INTO `wp_commentmeta` VALUES (297, 3950, 'akismet_result', 'false'); 
INSERT INTO `wp_commentmeta` VALUES (298, 3950, 'akismet_history', 'a:4:{s:4:"time";s:12:"1301061425.8";s:7:"message";s:28:"Akismet cleared this comment";s:5:"event";s:9:"check-ham";s:4:"user";s:0:"";}'); 
INSERT INTO `wp_commentmeta` VALUES (306, 3950, 'akismet_history', 'a:4:{s:4:"time";s:13:"1301105791.23";s:7:"message";s:47:"vijendra changed the comment status to approved";s:5:"event";s:15:"status-approved";s:4:"user";s:8:"vijendra";}'); 
INSERT INTO `wp_commentmeta` VALUES (307, 3947, 'akismet_history', 'a:4:{s:4:"time";s:13:"1301105800.27";s:7:"message";s:47:"vijendra changed the comment status to approved";s:5:"event";s:15:"status-approved";s:4:"user";s:8:"vijendra";}'); 
INSERT INTO `wp_commentmeta` VALUES (13095, 8113, 'akismet_result', 'false'); 
INSERT INTO `wp_commentmeta` VALUES (13096, 8113, 'akismet_history', 'a:4:{s:4:"time";s:13:"1326412118.22";s:7:"message";s:28:"Akismet cleared this comment";s:5:"event";s:9:"check-ham";s:4:"user";s:0:"";}'); 
INSERT INTO `wp_commentmeta` VALUES (15898, 9021, 'akismet_result', 'false'); 
INSERT INTO `wp_commentmeta` VALUES (15899, 9021, 'akismet_history', 'a:4:{s:4:"time";s:13:"1332450358.44";s:7:"message";s:28:"Akismet cleared this comment";s:5:"event";s:9:"check-ham";s:4:"user";s:0:"";}'); 
INSERT INTO `wp_commentmeta` VALUES (19237, 10112, 'akismet_history', 'a:4:{s:4:"time";s:13:"1336584485.47";s:7:"message";s:52:"Administrator changed the comment status to approved";s:5:"event";s:15:"status-approved";s:4:"user";s:13:"Administrator";}'); 
INSERT INTO `wp_commentmeta` VALUES (19238, 10072, 'akismet_history', 'a:4:{s:4:"time";s:13:"1336584511.16";s:7:"message";s:52:"Administrator changed the comment status to approved";s:5:"event";s:15:"status-approved";s:4:"user";s:13:"Administrator";}'); 
INSERT INTO `wp_commentmeta` VALUES (19239, 10071, 'akismet_history', 'a:4:{s:4:"time";s:13:"1336584523.63";s:7:"message";s:52:"Administrator changed the comment status to approved";s:5:"event";s:15:"status-approved";s:4:"user";s:13:"Administrator";}'); 
INSERT INTO `wp_commentmeta` VALUES (18249, 9796, 'akismet_result', 'false'); 
INSERT INTO `wp_commentmeta` VALUES (18250, 9796, 'akismet_history', 'a:4:{s:4:"time";s:12:"1335207165.1";s:7:"message";s:28:"Akismet cleared this comment";s:5:"event";s:9:"check-ham";s:4:"user";s:0:"";}'); 
INSERT INTO `wp_commentmeta` VALUES (10787, 7364, 'akismet_history', 'a:4:{s:4:"time";s:12:"1319383951.7";s:7:"message";s:52:"Administrator changed the comment status to approved";s:5:"event";s:15:"status-approved";s:4:"user";s:13:"Administrator";}'); 
INSERT INTO `wp_commentmeta` VALUES (10788, 7358, 'akismet_history', 'a:4:{s:4:"time";s:13:"1319383960.68";s:7:"message";s:52:"Administrator changed the comment status to approved";s:5:"event";s:15:"status-approved";s:4:"user";s:13:"Administrator";}'); 
INSERT INTO `wp_commentmeta` VALUES (10789, 7354, 'akismet_history', 'a:4:{s:4:"time";s:13:"1319383962.96";s:7:"message";s:52:"Administrator changed the comment status to approved";s:5:"event";s:15:"status-approved";s:4:"user";s:13:"Administrator";}'); 
INSERT INTO `wp_commentmeta` VALUES (10790, 7332, 'akismet_history', 'a:4:{s:4:"time";s:13:"1319383967.73";s:7:"message";s:52:"Administrator changed the comment status to approved";s:5:"event";s:15:"status-approved";s:4:"user";s:13:"Administrator";}'); 
INSERT INTO `wp_commentmeta` VALUES (10791, 7323, 'akismet_history', 'a:4:{s:4:"time";s:12:"1319383974.8";s:7:"message";s:52:"Administrator changed the comment status to approved";s:5:"event";s:15:"status-approved";s:4:"user";s:13:"Administrator";}'); 
INSERT INTO `wp_commentmeta` VALUES (10793, 7268, 'akismet_history', 'a:4:{s:4:"time";s:10:"1319384077";s:7:"message";s:52:"Administrator changed the comment status to approved";s:5:"event";s:15:"status-approved";s:4:"user";s:13:"Administrator";}'); 
INSERT INTO `wp_commentmeta` VALUES (10786, 7366, 'akismet_history', 'a:4:{s:4:"time";s:13:"1319383942.45";s:7:"message";s:52:"Administrator changed the comment status to approved";s:5:"event";s:15:"status-approved";s:4:"user";s:13:"Administrator";}'); 
INSERT INTO `wp_commentmeta` VALUES (10783, 7423, 'akismet_history', 'a:4:{s:4:"time";s:13:"1319383909.65";s:7:"message";s:52:"Administrator changed the comment status to approved";s:5:"event";s:15:"status-approved";s:4:"user";s:13:"Administrator";}'); 
INSERT INTO `wp_commentmeta` VALUES (10784, 7415, 'akismet_history', 'a:4:{s:4:"time";s:13:"1319383929.22";s:7:"message";s:52:"Administrator changed the comment status to approved";s:5:"event";s:15:"status-approved";s:4:"user";s:13:"Administrator";}'); 
INSERT INTO `wp_commentmeta` VALUES (10785, 7385, 'akismet_history', 'a:4:{s:4:"time";s:13:"1319383938.83";s:7:"message";s:52:"Administrator changed the comment status to approved";s:5:"event";s:15:"status-approved";s:4:"user";s:13:"Administrator";}'); 
INSERT INTO `wp_commentmeta` VALUES (13848, 8355, 'akismet_result', 'true'); 
INSERT INTO `wp_commentmeta` VALUES (13849, 8355, 'akismet_history', 'a:4:{s:4:"time";s:12:"1329707038.7";s:7:"message";s:35:"Akismet caught this comment as spam";s:5:"event";s:10:"check-spam";s:4:"user";s:0:"";}'); 
INSERT INTO `wp_commentmeta` VALUES (19469, 10185, 'akismet_result', 'false'); 
INSERT INTO `wp_commentmeta` VALUES (19470, 10185, 'akismet_history', 'a:4:{s:4:"time";s:13:"1337123594.33";s:7:"message";s:28:"Akismet cleared this comment";s:5:"event";s:9:"check-ham";s:4:"user";s:0:"";}'); 
INSERT INTO `wp_commentmeta` VALUES (19465, 10183, 'akismet_history', 'a:4:{s:4:"time";s:13:"1337118917.89";s:7:"message";s:52:"Administrator changed the comment status to approved";s:5:"event";s:15:"status-approved";s:4:"user";s:13:"Administrator";}'); 
INSERT INTO `wp_commentmeta` VALUES (19466, 10184, 'akismet_result', 'false'); 
INSERT INTO `wp_commentmeta` VALUES (19467, 10184, 'akismet_history', 'a:4:{s:4:"time";s:13:"1337121591.05";s:7:"message";s:28:"Akismet cleared this comment";s:5:"event";s:9:"check-ham";s:4:"user";s:0:"";}'); 
INSERT INTO `wp_commentmeta` VALUES (19461, 10178, 'akismet_history', 'a:4:{s:4:"time";s:13:"1337111739.07";s:7:"message";s:52:"Administrator changed the comment status to approved";s:5:"event";s:15:"status-approved";s:4:"user";s:13:"Administrator";}'); 
INSERT INTO `wp_commentmeta` VALUES (19462, 10183, 'akismet_result', 'false'); 
INSERT INTO `wp_commentmeta` VALUES (19463, 10183, 'akismet_history', 'a:4:{s:4:"time";s:13:"1337117803.29";s:7:"message";s:28:"Akismet cleared this comment";s:5:"event";s:9:"check-ham";s:4:"user";s:0:"";}'); 
INSERT INTO `wp_commentmeta` VALUES (533, 3987, 'akismet_history', 'a:4:{s:4:"time";s:13:"1301790760.37";s:7:"message";s:43:"john changed the comment status to approved";s:5:"event";s:15:"status-approved";s:4:"user";s:4:"john";}'); 
INSERT INTO `wp_commentmeta` VALUES (534, 3988, 'akismet_history', 'a:4:{s:4:"time";s:13:"1301790764.69";s:7:"message";s:43:"john changed the comment status to approved";s:5:"event";s:15:"status-approved";s:4:"user";s:4:"john";}'); 
INSERT INTO `wp_commentmeta` VALUES (535, 3989, 'akismet_history', 'a:4:{s:4:"time";s:13:"1301790766.96";s:7:"message";s:43:"john changed the comment status to approved";s:5:"event";s:15:"status-approved";s:4:"user";s:4:"john";}'); 
INSERT INTO `wp_commentmeta` VALUES (665, 4074, 'akismet_result', 'false'); 
INSERT INTO `wp_commentmeta` VALUES (666, 4074, 'akismet_history', 'a:4:{s:4:"time";s:13:"1301862167.63";s:7:"message";s:28:"Akismet cleared this comment";s:5:"event";s:9:"check-ham";s:4:"user";s:0:"";}'); 
INSERT INTO `wp_commentmeta` VALUES (674, 4074, 'akismet_history', 'a:4:{s:4:"time";s:13:"1301863775.99";s:7:"message";s:43:"john changed the comment status to approved";s:5:"event";s:15:"status-approved";s:4:"user";s:4:"john";}'); 
INSERT INTO `wp_commentmeta` VALUES (8898, 6812, 'akismet_result', 'false'); 
INSERT INTO `wp_commentmeta` VALUES (8899, 6812, 'akismet_history', 'a:4:{s:4:"time";s:13:"1306125346.24";s:7:"message";s:28:"Akismet cleared this comment";s:5:"event";s:9:"check-ham";s:4:"user";s:0:"";}'); 
INSERT INTO `wp_commentmeta` VALUES (8589, 6583, 'akismet_history', 'a:4:{s:4:"time";s:13:"1304788928.04";s:7:"message";s:43:"john changed the comment status to approved";s:5:"event";s:15:"status-approved";s:4:"user";s:4:"john";}'); 
INSERT INTO `wp_commentmeta` VALUES (8590, 6699, 'akismet_history', 'a:4:{s:4:"time";s:13:"1304788931.79";s:7:"message";s:43:"john changed the comment status to approved";s:5:"event";s:15:"status-approved";s:4:"user";s:4:"john";}'); 
INSERT INTO `wp_commentmeta` VALUES (8591, 6169, 'akismet_history', 'a:4:{s:4:"time";s:12:"1304788936.7";s:7:"message";s:43:"john changed the comment status to approved";s:5:"event";s:15:"status-approved";s:4:"user";s:4:"john";}'); 
INSERT INTO `wp_commentmeta` VALUES (8592, 5156, 'akismet_history', 'a:4:{s:4:"time";s:13:"1304788940.84";s:7:"message";s:43:"john changed the comment status to approved";s:5:"event";s:15:"status-approved";s:4:"user";s:4:"john";}'); 
INSERT INTO `wp_commentmeta` VALUES (8892, 6810, 'akismet_result', 'false'); 
INSERT INTO `wp_commentmeta` VALUES (8893, 6810, 'akismet_history', 'a:4:{s:4:"time";s:13:"1306103522.73";s:7:"message";s:28:"Akismet cleared this comment";s:5:"event";s:9:"check-ham";s:4:"user";s:0:"";}'); 
INSERT INTO `wp_commentmeta` VALUES (9498, 7008, 'akismet_result', 'false'); 
INSERT INTO `wp_commentmeta` VALUES (9499, 7008, 'akismet_history', 'a:4:{s:4:"time";s:13:"1308939259.82";s:7:"message";s:28:"Akismet cleared this comment";s:5:"event";s:9:"check-ham";s:4:"user";s:0:"";}'); 
INSERT INTO `wp_commentmeta` VALUES (9495, 7007, 'akismet_result', 'false'); 
INSERT INTO `wp_commentmeta` VALUES (9496, 7007, 'akismet_history', 'a:4:{s:4:"time";s:13:"1308925440.24";s:7:"message";s:28:"Akismet cleared this comment";s:5:"event";s:9:"check-ham";s:4:"user";s:0:"";}'); 
INSERT INTO `wp_commentmeta` VALUES (10757, 7415, 'akismet_history', 'a:4:{s:4:"time";s:13:"1319322376.95";s:7:"message";s:28:"Akismet cleared this comment";s:5:"event";s:9:"check-ham";s:4:"user";s:0:"";}'); 
INSERT INTO `wp_commentmeta` VALUES (9887, 7128, 'akismet_result', 'false'); 
INSERT INTO `wp_commentmeta` VALUES (9888, 7128, 'akismet_history', 'a:4:{s:4:"time";s:13:"1310322884.37";s:7:"message";s:28:"Akismet cleared this comment";s:5:"event";s:9:"check-ham";s:4:"user";s:0:"";}'); 
INSERT INTO `wp_commentmeta` VALUES (9210, 6914, 'akismet_result', 'false'); 
INSERT INTO `wp_commentmeta` VALUES (9211, 6914, 'akismet_history', 'a:4:{s:4:"time";s:13:"1307561886.01";s:7:"message";s:28:"Akismet cleared this comment";s:5:"event";s:9:"check-ham";s:4:"user";s:0:"";}'); 
INSERT INTO `wp_commentmeta` VALUES (9637, 7045, 'akismet_result', 'false'); 
INSERT INTO `wp_commentmeta` VALUES (9638, 7045, 'akismet_history', 'a:4:{s:4:"time";s:13:"1309320106.34";s:7:"message";s:28:"Akismet cleared this comment";s:5:"event";s:9:"check-ham";s:4:"user";s:0:"";}'); 
INSERT INTO `wp_commentmeta` VALUES (9339, 6955, 'akismet_result', 'false'); 
INSERT INTO `wp_commentmeta` VALUES (9340, 6955, 'akismet_history', 'a:4:{s:4:"time";s:13:"1308238710.34";s:7:"message";s:28:"Akismet cleared this comment";s:5:"event";s:9:"check-ham";s:4:"user";s:0:"";}'); 
INSERT INTO `wp_commentmeta` VALUES (19410, 10169, 'akismet_result', 'false'); 
INSERT INTO `wp_commentmeta` VALUES (19411, 10169, 'akismet_history', 'a:4:{s:4:"time";s:13:"1337050316.27";s:7:"message";s:28:"Akismet cleared this comment";s:5:"event";s:9:"check-ham";s:4:"user";s:0:"";}'); 
INSERT INTO `wp_commentmeta` VALUES (13938, 8374, 'akismet_history', 'a:4:{s:4:"time";s:13:"1330038871.06";s:7:"message";s:52:"Administrator changed the comment status to approved";s:5:"event";s:15:"status-approved";s:4:"user";s:13:"Administrator";}'); 
INSERT INTO `wp_commentmeta` VALUES (13939, 8329, 'akismet_history', 'a:4:{s:4:"time";s:13:"1330039244.36";s:7:"message";s:52:"Administrator changed the comment status to approved";s:5:"event";s:15:"status-approved";s:4:"user";s:13:"Administrator";}'); 
INSERT INTO `wp_commentmeta` VALUES (13940, 8220, 'akismet_history', 'a:4:{s:4:"time";s:13:"1330039330.45";s:7:"message";s:52:"Administrator changed the comment status to approved";s:5:"event";s:15:"status-approved";s:4:"user";s:13:"Administrator";}'); 
INSERT INTO `wp_commentmeta` VALUES (18583, 9908, 'akismet_result', 'false'); 
INSERT INTO `wp_commentmeta` VALUES (18584, 9908, 'akismet_history', 'a:4:{s:4:"time";s:13:"1335743846.87";s:7:"message";s:28:"Akismet cleared this comment";s:5:"event";s:9:"check-ham";s:4:"user";s:0:"";}'); 
INSERT INTO `wp_commentmeta` VALUES (19425, 10174, 'akismet_result', 'false'); 
INSERT INTO `wp_commentmeta` VALUES (19426, 10174, 'akismet_history', 'a:4:{s:4:"time";s:13:"1337053772.53";s:7:"message";s:28:"Akismet cleared this comment";s:5:"event";s:9:"check-ham";s:4:"user";s:0:"";}'); 
INSERT INTO `wp_commentmeta` VALUES (9944, 7147, 'akismet_result', 'false'); 
INSERT INTO `wp_commentmeta` VALUES (9945, 7147, 'akismet_history', 'a:4:{s:4:"time";s:13:"1311195721.76";s:7:"message";s:28:"Akismet cleared this comment";s:5:"event";s:9:"check-ham";s:4:"user";s:0:"";}'); 
INSERT INTO `wp_commentmeta` VALUES (14016, 8410, 'akismet_result', 'true'); 
INSERT INTO `wp_commentmeta` VALUES (14017, 8410, 'akismet_history', 'a:4:{s:4:"time";s:13:"1330132944.99";s:7:"message";s:35:"Akismet caught this comment as spam";s:5:"event";s:10:"check-spam";s:4:"user";s:0:"";}'); 
INSERT INTO `wp_commentmeta` VALUES (23093, 11367, 'akismet_result', 'false'); 
INSERT INTO `wp_commentmeta` VALUES (23094, 11367, 'akismet_history', 'a:4:{s:4:"time";s:12:"1339126199.3";s:7:"message";s:28:"Akismet cleared this comment";s:5:"event";s:9:"check-ham";s:4:"user";s:0:"";}'); 
INSERT INTO `wp_commentmeta` VALUES (23301, 11367, 'akismet_history', 'a:4:{s:4:"time";s:13:"1339258682.07";s:7:"message";s:52:"Administrator changed the comment status to approved";s:5:"event";s:15:"status-approved";s:4:"user";s:13:"Administrator";}'); 
INSERT INTO `wp_commentmeta` VALUES (13659, 8297, 'akismet_result', 'false'); 
INSERT INTO `wp_commentmeta` VALUES (13660, 8297, 'akismet_history', 'a:4:{s:4:"time";s:13:"1328796594.98";s:7:"message";s:28:"Akismet cleared this comment";s:5:"event";s:9:"check-ham";s:4:"user";s:0:"";}'); 
INSERT INTO `wp_commentmeta` VALUES (20738, 10571, 'akismet_history', 'a:4:{s:4:"time";s:13:"1337873388.09";s:7:"message";s:52:"Administrator changed the comment status to approved";s:5:"event";s:15:"status-approved";s:4:"user";s:13:"Administrator";}'); 
INSERT INTO `wp_commentmeta` VALUES (23300, 11358, 'akismet_history', 'a:4:{s:4:"time";s:13:"1339258671.23";s:7:"message";s:52:"Administrator changed the comment status to approved";s:5:"event";s:15:"status-approved";s:4:"user";s:13:"Administrator";}'); 
INSERT INTO `wp_commentmeta` VALUES (22940, 11318, 'akismet_result', 'false'); 
INSERT INTO `wp_commentmeta` VALUES (22941, 11318, 'akismet_history', 'a:4:{s:4:"time";s:13:"1339028812.09";s:7:"message";s:28:"Akismet cleared this comment";s:5:"event";s:9:"check-ham";s:4:"user";s:0:"";}'); 
INSERT INTO `wp_commentmeta` VALUES (19078, 10062, 'akismet_history', 'a:4:{s:4:"time";s:13:"1336331308.96";s:7:"message";s:52:"Administrator changed the comment status to approved";s:5:"event";s:15:"status-approved";s:4:"user";s:13:"Administrator";}'); 
INSERT INTO `wp_commentmeta` VALUES (19083, 10013, 'akismet_history', 'a:4:{s:4:"time";s:13:"1336331329.65";s:7:"message";s:52:"Administrator changed the comment status to approved";s:5:"event";s:15:"status-approved";s:4:"user";s:13:"Administrator";}'); 
INSERT INTO `wp_commentmeta` VALUES (19231, 10112, 'akismet_result', 'false'); 
INSERT INTO `wp_commentmeta` VALUES (19232, 10112, 'akismet_history', 'a:4:{s:4:"time";s:13:"1336575627.06";s:7:"message";s:28:"Akismet cleared this comment";s:5:"event";s:9:"check-ham";s:4:"user";s:0:"";}'); 
INSERT INTO `wp_commentmeta` VALUES (23495, 11499, 'akismet_result', 'false'); 
INSERT INTO `wp_commentmeta` VALUES (23496, 11499, 'akismet_history', 'a:4:{s:4:"time";s:13:"1339348461.66";s:7:"message";s:28:"Akismet cleared this comment";s:5:"event";s:9:"check-ham";s:4:"user";s:0:"";}'); 
INSERT INTO `wp_commentmeta` VALUES (13707, 8313, 'akismet_result', 'true'); 
INSERT INTO `wp_commentmeta` VALUES (13708, 8313, 'akismet_history', 'a:4:{s:4:"time";s:13:"1329072935.92";s:7:"message";s:35:"Akismet caught this comment as spam";s:5:"event";s:10:"check-spam";s:4:"user";s:0:"";}'); 
INSERT INTO `wp_commentmeta` VALUES (5156, 4954, 'akismet_history', 'a:4:{s:4:"time";s:13:"1303294995.54";s:7:"message";s:47:"vijendra changed the comment status to approved";s:5:"event";s:15:"status-approved";s:4:"user";s:8:"vijendra";}'); 
INSERT INTO `wp_commentmeta` VALUES (969, 4175, 'akismet_result', 'false'); 
INSERT INTO `wp_commentmeta` VALUES (970, 4175, 'akismet_history', 'a:4:{s:4:"time";s:13:"1301953173.74";s:7:"message";s:28:"Akismet cleared this comment";s:5:"event";s:9:"check-ham";s:4:"user";s:0:"";}'); 
INSERT INTO `wp_commentmeta` VALUES (972, 4175, 'akismet_history', 'a:4:{s:4:"time";s:13:"1301954641.75";s:7:"message";s:43:"john changed the comment status to approved";s:5:"event";s:15:"status-approved";s:4:"user";s:4:"john";}'); 
INSERT INTO `wp_commentmeta` VALUES (1123, 4226, 'akismet_result', 'false'); 
INSERT INTO `wp_commentmeta` VALUES (1124, 4226, 'akismet_history', 'a:4:{s:4:"time";s:13:"1302007013.73";s:7:"message";s:28:"Akismet cleared this comment";s:5:"event";s:9:"check-ham";s:4:"user";s:0:"";}'); 
INSERT INTO `wp_commentmeta` VALUES (1219, 4226, 'akismet_history', 'a:4:{s:4:"time";s:13:"1302039763.57";s:7:"message";s:44:"stacy changed the comment status to approved";s:5:"event";s:15:"status-approved";s:4:"user";s:5:"stacy";}'); 
INSERT INTO `wp_commentmeta` VALUES (1277, 4277, 'akismet_result', 'false'); 
INSERT INTO `wp_commentmeta` VALUES (1278, 4277, 'akismet_history', 'a:4:{s:4:"time";s:13:"1302053836.96";s:7:"message";s:28:"Akismet cleared this comment";s:5:"event";s:9:"check-ham";s:4:"user";s:0:"";}'); 
INSERT INTO `wp_commentmeta` VALUES (1736, 4430, 'akismet_result', 'false'); 
INSERT INTO `wp_commentmeta` VALUES (1737, 4430, 'akismet_history', 'a:4:{s:4:"time";s:13:"1302216361.27";s:7:"message";s:28:"Akismet cleared this comment";s:5:"event";s:9:"check-ham";s:4:"user";s:0:"";}'); 
INSERT INTO `wp_commentmeta` VALUES (1772, 4430, 'akismet_history', 'a:4:{s:4:"time";s:13:"1302229371.21";s:7:"message";s:43:"john changed the comment status to approved";s:5:"event";s:15:"status-approved";s:4:"user";s:4:"john";}'); 
INSERT INTO `wp_commentmeta` VALUES (1791, 4448, 'akismet_result', 'false'); 
INSERT INTO `wp_commentmeta` VALUES (1792, 4448, 'akismet_history', 'a:4:{s:4:"time";s:13:"1302235077.71";s:7:"message";s:28:"Akismet cleared this comment";s:5:"event";s:9:"check-ham";s:4:"user";s:0:"";}'); 
INSERT INTO `wp_commentmeta` VALUES (11618, 7682, 'akismet_result', 'true'); 
INSERT INTO `wp_commentmeta` VALUES (11619, 7682, 'akismet_history', 'a:4:{s:4:"time";s:12:"1322147444.2";s:7:"message";s:35:"Akismet caught this comment as spam";s:5:"event";s:10:"check-spam";s:4:"user";s:0:"";}'); 
INSERT INTO `wp_commentmeta` VALUES (10487, 7323, 'akismet_history', 'a:4:{s:4:"time";s:13:"1317361329.85";s:7:"message";s:28:"Akismet cleared this comment";s:5:"event";s:9:"check-ham";s:4:"user";s:0:"";}'); 
INSERT INTO `wp_commentmeta` VALUES (10486, 7323, 'akismet_result', 'false'); 
INSERT INTO `wp_commentmeta` VALUES (10513, 7332, 'akismet_result', 'false'); 
INSERT INTO `wp_commentmeta` VALUES (10514, 7332, 'akismet_history', 'a:4:{s:4:"time";s:13:"1317503238.82";s:7:"message";s:28:"Akismet cleared this comment";s:5:"event";s:9:"check-ham";s:4:"user";s:0:"";}'); 
INSERT INTO `wp_commentmeta` VALUES (19075, 10062, 'akismet_result', 'false'); 
INSERT INTO `wp_commentmeta` VALUES (19076, 10062, 'akismet_history', 'a:4:{s:4:"time";s:13:"1336330586.95";s:7:"message";s:28:"Akismet cleared this comment";s:5:"event";s:9:"check-ham";s:4:"user";s:0:"";}'); 
INSERT INTO `wp_commentmeta` VALUES (13772, 8333, 'akismet_result', 'false'); 
INSERT INTO `wp_commentmeta` VALUES (13773, 8333, 'akismet_history', 'a:4:{s:4:"time";s:12:"1329311326.3";s:7:"message";s:28:"Akismet cleared this comment";s:5:"event";s:9:"check-ham";s:4:"user";s:0:"";}'); 
INSERT INTO `wp_commentmeta` VALUES (11179, 7538, 'akismet_result', 'false'); 
INSERT INTO `wp_commentmeta` VALUES (11180, 7538, 'akismet_history', 'a:4:{s:4:"time";s:13:"1320525251.64";s:7:"message";s:28:"Akismet cleared this comment";s:5:"event";s:9:"check-ham";s:4:"user";s:0:"";}'); 
INSERT INTO `wp_commentmeta` VALUES (11214, 7548, 'akismet_result', 'false'); 
INSERT INTO `wp_commentmeta` VALUES (11215, 7548, 'akismet_history', 'a:4:{s:4:"time";s:13:"1320696935.42";s:7:"message";s:28:"Akismet cleared this comment";s:5:"event";s:9:"check-ham";s:4:"user";s:0:"";}'); 
INSERT INTO `wp_commentmeta` VALUES (10321, 7268, 'akismet_result', 'false'); 
INSERT INTO `wp_commentmeta` VALUES (10322, 7268, 'akismet_history', 'a:4:{s:4:"time";s:13:"1316437690.74";s:7:"message";s:28:"Akismet cleared this comment";s:5:"event";s:9:"check-ham";s:4:"user";s:0:"";}'); 
INSERT INTO `wp_commentmeta` VALUES (12263, 7864, 'akismet_result', 'false'); 
INSERT INTO `wp_commentmeta` VALUES (12264, 7864, 'akismet_history', 'a:4:{s:4:"time";s:13:"1324085337.51";s:7:"message";s:28:"Akismet cleared this comment";s:5:"event";s:9:"check-ham";s:4:"user";s:0:"";}'); 
INSERT INTO `wp_commentmeta` VALUES (20978, 10658, 'akismet_history', 'a:4:{s:4:"time";s:13:"1337996494.86";s:7:"message";s:52:"Administrator changed the comment status to approved";s:5:"event";s:15:"status-approved";s:4:"user";s:13:"Administrator";}'); 
INSERT INTO `wp_commentmeta` VALUES (20979, 10662, 'akismet_history', 'a:4:{s:4:"time";s:13:"1337996504.23";s:7:"message";s:52:"Administrator changed the comment status to approved";s:5:"event";s:15:"status-approved";s:4:"user";s:13:"Administrator";}'); 
INSERT INTO `wp_commentmeta` VALUES (10579, 7354, 'akismet_result', 'false'); 
INSERT INTO `wp_commentmeta` VALUES (10580, 7354, 'akismet_history', 'a:4:{s:4:"time";s:13:"1318113654.95";s:7:"message";s:28:"Akismet cleared this comment";s:5:"event";s:9:"check-ham";s:4:"user";s:0:"";}'); 
INSERT INTO `wp_commentmeta` VALUES (11832, 7724, 'akismet_result', 'false'); 
INSERT INTO `wp_commentmeta` VALUES (11833, 7724, 'akismet_history', 'a:4:{s:4:"time";s:13:"1322655806.64";s:7:"message";s:28:"Akismet cleared this comment";s:5:"event";s:9:"check-ham";s:4:"user";s:0:"";}'); 
INSERT INTO `wp_commentmeta` VALUES (12239, 7856, 'akismet_result', 'false'); 
INSERT INTO `wp_commentmeta` VALUES (12240, 7856, 'akismet_history', 'a:4:{s:4:"time";s:13:"1324053426.98";s:7:"message";s:28:"Akismet cleared this comment";s:5:"event";s:9:"check-ham";s:4:"user";s:0:"";}'); 
INSERT INTO `wp_commentmeta` VALUES (16249, 9135, 'akismet_result', 'false'); 
INSERT INTO `wp_commentmeta` VALUES (16250, 9135, 'akismet_history', 'a:4:{s:4:"time";s:13:"1333314204.47";s:7:"message";s:28:"Akismet cleared this comment";s:5:"event";s:9:"check-ham";s:4:"user";s:0:"";}'); 
INSERT INTO `wp_commentmeta` VALUES (20268, 10438, 'akismet_result', 'false'); 
INSERT INTO `wp_commentmeta` VALUES (20269, 10438, 'akismet_history', 'a:4:{s:4:"time";s:12:"1337632412.7";s:7:"message";s:28:"Akismet cleared this comment";s:5:"event";s:9:"check-ham";s:4:"user";s:0:"";}'); 
INSERT INTO `wp_commentmeta` VALUES (12209, 7846, 'akismet_result', 'false'); 
INSERT INTO `wp_commentmeta` VALUES (12210, 7846, 'akismet_history', 'a:4:{s:4:"time";s:13:"1323988332.38";s:7:"message";s:28:"Akismet cleared this comment";s:5:"event";s:9:"check-ham";s:4:"user";s:0:"";}'); 
INSERT INTO `wp_commentmeta` VALUES (14325, 8513, 'akismet_result', 'false'); 
INSERT INTO `wp_commentmeta` VALUES (14326, 8513, 'akismet_history', 'a:4:{s:4:"time";s:13:"1330493574.41";s:7:"message";s:28:"Akismet cleared this comment";s:5:"event";s:9:"check-ham";s:4:"user";s:0:"";}'); 
INSERT INTO `wp_commentmeta` VALUES (13760, 8329, 'akismet_result', 'false'); 
INSERT INTO `wp_commentmeta` VALUES (13761, 8329, 'akismet_history', 'a:4:{s:4:"time";s:13:"1329159281.78";s:7:"message";s:28:"Akismet cleared this comment";s:5:"event";s:9:"check-ham";s:4:"user";s:0:"";}'); 
INSERT INTO `wp_commentmeta` VALUES (20114, 10383, 'akismet_history', 'a:4:{s:4:"time";s:13:"1337531221.79";s:7:"message";s:52:"Administrator changed the comment status to approved";s:5:"event";s:15:"status-approved";s:4:"user";s:13:"Administrator";}'); 
INSERT INTO `wp_commentmeta` VALUES (20115, 10387, 'akismet_history', 'a:4:{s:4:"time";s:13:"1337531229.09";s:7:"message";s:52:"Administrator changed the comment status to approved";s:5:"event";s:15:"status-approved";s:4:"user";s:13:"Administrator";}'); 
INSERT INTO `wp_commentmeta` VALUES (20108, 10387, 'akismet_result', 'false'); 
INSERT INTO `wp_commentmeta` VALUES (20109, 10387, 'akismet_history', 'a:4:{s:4:"time";s:13:"1337526710.45";s:7:"message";s:28:"Akismet cleared this comment";s:5:"event";s:9:"check-ham";s:4:"user";s:0:"";}'); 
INSERT INTO `wp_commentmeta` VALUES (35660, 15518, 'akismet_result', 'false'); 
INSERT INTO `wp_commentmeta` VALUES (35661, 15518, 'akismet_history', 'a:4:{s:4:"time";s:13:"1349396303.27";s:7:"message";s:28:"Akismet cleared this comment";s:5:"event";s:9:"check-ham";s:4:"user";s:0:"";}'); 
INSERT INTO `wp_commentmeta` VALUES (18976, 10020, 'akismet_history', 'a:4:{s:4:"time";s:13:"1336171109.53";s:7:"message";s:52:"Administrator changed the comment status to approved";s:5:"event";s:15:"status-approved";s:4:"user";s:13:"Administrator";}'); 
INSERT INTO `wp_commentmeta` VALUES (18977, 10015, 'akismet_history', 'a:4:{s:4:"time";s:13:"1336171124.59";s:7:"message";s:52:"Administrator changed the comment status to approved";s:5:"event";s:15:"status-approved";s:4:"user";s:13:"Administrator";}'); 
INSERT INTO `wp_commentmeta` VALUES (18978, 10022, 'akismet_history', 'a:4:{s:4:"time";s:13:"1336171148.68";s:7:"message";s:52:"Administrator changed the comment status to approved";s:5:"event";s:15:"status-approved";s:4:"user";s:13:"Administrator";}'); 
INSERT INTO `wp_commentmeta` VALUES (11308, 7556, 'akismet_history', 'a:4:{s:4:"time";s:13:"1321148913.19";s:7:"message";s:54:"Editor in Chief changed the comment status to approved";s:5:"event";s:15:"status-approved";s:4:"user";s:15:"Editor in Chief";}'); 
INSERT INTO `wp_commentmeta` VALUES (11307, 7572, 'akismet_history', 'a:4:{s:4:"time";s:13:"1321147791.17";s:7:"message";s:54:"Editor in Chief changed the comment status to approved";s:5:"event";s:15:"status-approved";s:4:"user";s:15:"Editor in Chief";}'); 
INSERT INTO `wp_commentmeta` VALUES (11305, 7564, 'akismet_history', 'a:4:{s:4:"time";s:13:"1321147774.58";s:7:"message";s:54:"Editor in Chief changed the comment status to approved";s:5:"event";s:15:"status-approved";s:4:"user";s:15:"Editor in Chief";}'); 
INSERT INTO `wp_commentmeta` VALUES (11306, 7571, 'akismet_history', 'a:4:{s:4:"time";s:13:"1321147787.46";s:7:"message";s:54:"Editor in Chief changed the comment status to approved";s:5:"event";s:15:"status-approved";s:4:"user";s:15:"Editor in Chief";}'); 
INSERT INTO `wp_commentmeta` VALUES (10423, 7302, 'akismet_result', 'false'); 
INSERT INTO `wp_commentmeta` VALUES (10424, 7302, 'akismet_history', 'a:4:{s:4:"time";s:13:"1316814961.17";s:7:"message";s:28:"Akismet cleared this comment";s:5:"event";s:9:"check-ham";s:4:"user";s:0:"";}'); 
INSERT INTO `wp_commentmeta` VALUES (11290, 7572, 'akismet_result', 'false'); 
INSERT INTO `wp_commentmeta` VALUES (10890, 7439, 'akismet_result', 'true'); 
INSERT INTO `wp_commentmeta` VALUES (10891, 7439, 'akismet_history', 'a:4:{s:4:"time";s:13:"1319564940.64";s:7:"message";s:35:"Akismet caught this comment as spam";s:5:"event";s:10:"check-spam";s:4:"user";s:0:"";}'); 
INSERT INTO `wp_commentmeta` VALUES (10588, 7358, 'akismet_result', 'false'); 
INSERT INTO `wp_commentmeta` VALUES (10589, 7358, 'akismet_history', 'a:4:{s:4:"time";s:13:"1318191730.36";s:7:"message";s:28:"Akismet cleared this comment";s:5:"event";s:9:"check-ham";s:4:"user";s:0:"";}'); 
INSERT INTO `wp_commentmeta` VALUES (11291, 7572, 'akismet_history', 'a:4:{s:4:"time";s:13:"1321033009.24";s:7:"message";s:28:"Akismet cleared this comment";s:5:"event";s:9:"check-ham";s:4:"user";s:0:"";}'); 
INSERT INTO `wp_commentmeta` VALUES (1935, 4496, 'akismet_result', 'false'); 
INSERT INTO `wp_commentmeta` VALUES (1936, 4496, 'akismet_history', 'a:4:{s:4:"time";s:13:"1302294605.27";s:7:"message";s:28:"Akismet cleared this comment";s:5:"event";s:9:"check-ham";s:4:"user";s:0:"";}'); 
INSERT INTO `wp_commentmeta` VALUES (1959, 4496, 'akismet_history', 'a:4:{s:4:"time";s:13:"1302302965.44";s:7:"message";s:47:"vijendra changed the comment status to approved";s:5:"event";s:15:"status-approved";s:4:"user";s:8:"vijendra";}'); 
INSERT INTO `wp_commentmeta` VALUES (1960, 4448, 'akismet_history', 'a:4:{s:4:"time";s:13:"1302302969.13";s:7:"message";s:47:"vijendra changed the comment status to approved";s:5:"event";s:15:"status-approved";s:4:"user";s:8:"vijendra";}'); 
INSERT INTO `wp_commentmeta` VALUES (1961, 4277, 'akismet_history', 'a:4:{s:4:"time";s:13:"1302302976.97";s:7:"message";s:47:"vijendra changed the comment status to approved";s:5:"event";s:15:"status-approved";s:4:"user";s:8:"vijendra";}'); 
INSERT INTO `wp_commentmeta` VALUES (1965, 3975, 'akismet_history', 'a:4:{s:4:"time";s:13:"1302303003.14";s:7:"message";s:47:"vijendra changed the comment status to approved";s:5:"event";s:15:"status-approved";s:4:"user";s:8:"vijendra";}'); 
INSERT INTO `wp_commentmeta` VALUES (2161, 4569, 'akismet_result', 'false'); 
INSERT INTO `wp_commentmeta` VALUES (2162, 4569, 'akismet_history', 'a:4:{s:4:"time";s:13:"1302382573.82";s:7:"message";s:28:"Akismet cleared this comment";s:5:"event";s:9:"check-ham";s:4:"user";s:0:"";}');