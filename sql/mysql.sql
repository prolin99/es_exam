
CREATE TABLE `exam` (
  `assn` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `passwd` varchar(255) NOT NULL DEFAULT '',
  `class_id` varchar(255) NOT NULL DEFAULT '',
  `upload_mode` enum('1','0') NOT NULL DEFAULT '1',
  `ext_file` varchar(255) NOT NULL DEFAULT '',
  `note` text NOT NULL DEFAULT '',
  `uid` int(10) unsigned NOT NULL DEFAULT '0',
  `open_show` enum('1','0') NOT NULL DEFAULT '1',
  `gview_mode` enum('1','0') NOT NULL DEFAULT '0',
  `create_date` date NOT NULL,
  PRIMARY KEY (`assn`)
) ENGINE=MyISAM;



CREATE TABLE `exam_files` (
  `asfsn` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `assn` int(10) unsigned NOT NULL DEFAULT '0',
  `class_id` varchar(255) NOT NULL DEFAULT '',
  `sit_id` smallint(5) unsigned NOT NULL DEFAULT '0',
  `stud_id`  varchar(255) NOT NULL DEFAULT '',
  `file_name` varchar(255) NOT NULL DEFAULT '',
  `file_size` mediumint(9) unsigned NOT NULL DEFAULT '0',
  `file_type` varchar(255) NOT NULL DEFAULT '',
  `show_name` varchar(255) NOT NULL DEFAULT '',
  `memo` text NOT NULL DEFAULT '',
  `author` varchar(255) NOT NULL DEFAULT '',
  `score` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `comment` text NOT NULL DEFAULT '',
  `up_time` datetime DEFAULT NULL,
  PRIMARY KEY (`asfsn`)
) ENGINE=MyISAM;
