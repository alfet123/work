USE `work`;


CREATE TABLE `build` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT 'Идентификатор',
  `name` varchar(16) NOT NULL COMMENT 'Название',
  `sort` int UNSIGNED NOT NULL DEFAULT 0 COMMENT 'Сортировка'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Здание';


CREATE TABLE `floor` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT 'Идентификатор',
  `build_id` int UNSIGNED NOT NULL COMMENT 'Здание',
  `number` int NOT NULL COMMENT 'Номер',
  `name` varchar(8) NOT NULL COMMENT 'Название',
  FOREIGN KEY (`build_id`) REFERENCES `build`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Этаж';


CREATE TABLE `depart` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT 'Идентификатор',
  `name` varchar(16) NOT NULL COMMENT 'Название',
  `fullname` varchar(64) NOT NULL COMMENT 'Полное название'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Отделение';


CREATE TABLE `room` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT 'Идентификатор',
  `floor_id` int UNSIGNED NOT NULL COMMENT 'Этаж',
  `depart_id` int UNSIGNED DEFAULT NULL COMMENT 'Отделение',
  `number` varchar(8) NOT NULL COMMENT 'Номер',
  `name` varchar(32) NOT NULL COMMENT 'Название',
  `tech` boolean NOT NULL DEFAULT FALSE COMMENT 'Технический',
  `sort` int UNSIGNED NOT NULL DEFAULT 0 COMMENT 'Сортировка',
  FOREIGN KEY (`floor_id`) REFERENCES `floor`(`id`),
  FOREIGN KEY (`depart_id`) REFERENCES `depart`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Кабинет';


CREATE TABLE `type` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT 'Идентификатор',
  `name` varchar(32) NOT NULL COMMENT 'Название',
  `sort` int UNSIGNED NOT NULL DEFAULT 0 COMMENT 'Сортировка'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Тип';


CREATE TABLE `model` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT 'Идентификатор',
  `type_id` int UNSIGNED NOT NULL COMMENT 'Тип',
  `name` varchar(64) NOT NULL COMMENT 'Название',
  FOREIGN KEY (`type_id`) REFERENCES `type`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Модель';


CREATE TABLE `status` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT 'Идентификатор',
  `name` varchar(16) NOT NULL COMMENT 'Название',
  `class` varchar(16) NOT NULL COMMENT 'CSS-класс'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Статус';
