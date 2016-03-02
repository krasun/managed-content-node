DROP TABLE IF EXISTS `managed_content_node_page`;

CREATE TABLE `managed_content_node_page` (
  `slug` CHAR (80) NOT NULL,
  `title` VARCHAR (100) NOT NULL,
  `content` TEXT NOT NULL,
  PRIMARY KEY (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `managed_content_node_page_category`;

CREATE TABLE `managed_content_node_page_category` (
  `slug` CHAR (80) NOT NULL,
  PRIMARY KEY (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;