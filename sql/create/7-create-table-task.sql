USE `work`;


CREATE TABLE `task` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT 'Идентификатор',
  `planned` boolean NOT NULL DEFAULT FALSE COMMENT 'Плановое',
  `date_create` datetime NOT NULL COMMENT 'Дата создания',
  `date_close` datetime DEFAULT NULL COMMENT 'Дата завершения',
  `description` text NOT NULL COMMENT 'Описание'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Задание';
