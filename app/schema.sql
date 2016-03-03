DROP TABLE IF EXISTS `managed_content_node_page`;

DROP TABLE IF EXISTS `managed_content_node_page_category`;

CREATE TABLE `managed_content_node_page_category` (
  `slug` CHAR (80) NOT NULL,
  `title` VARCHAR (100) NOT NULL,

  PRIMARY KEY (`slug`)

) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `managed_content_node_page` (
  `slug` CHAR (80) NOT NULL,
  `title` VARCHAR (100) NOT NULL,
  `content` TEXT NOT NULL,
  `published_at` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
  `page_category_slug` CHAR (80) NOT NULL,

  PRIMARY KEY (`slug`),

  INDEX(`page_category_slug`),
  INDEX(`slug`, `published_at`),

  FOREIGN KEY (`page_category_slug`)
  REFERENCES `managed_content_node_page_category`(`slug`)

) ENGINE=InnoDB DEFAULT CHARSET=utf8;


