DROP TABLE IF EXISTS `managed_content_node_page`;

DROP TABLE IF EXISTS `managed_content_node_page_category`;

CREATE TABLE `managed_content_node_page_category` (
  `id` INT UNSIGNED AUTO_INCREMENT NOT NULL,
  `slug` CHAR (80) NOT NULL,
  `title` VARCHAR (100) NOT NULL,

  PRIMARY KEY (`id`),

  UNIQUE KEY (`slug`),

  INDEX (`slug`)

) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `managed_content_node_page` (
  `id` INT UNSIGNED AUTO_INCREMENT NOT NULL,
  `slug` CHAR (80) NOT NULL,
  `title` VARCHAR (100) NOT NULL,
  `content` TEXT NOT NULL,
  `published_at` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
  `page_category_id` INT UNSIGNED NOT NULL,

  PRIMARY KEY (`id`),

  UNIQUE KEY (`slug`),

  INDEX(`page_category_id`),
  INDEX(`slug`, `published_at`),

  FOREIGN KEY (`page_category_id`)
  REFERENCES `managed_content_node_page_category`(`id`)

) ENGINE=InnoDB DEFAULT CHARSET=utf8;


