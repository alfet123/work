USE `work`;


CREATE TABLE `network` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT 'Идентификатор',
  `room_id` int UNSIGNED NOT NULL COMMENT 'Кабинет',
  `plug` text NOT NULL COMMENT 'Розетка',
  `panel` text NOT NULL COMMENT 'Панель',
  `switch` text NOT NULL COMMENT 'Коммутатор',
  `port` text NOT NULL COMMENT 'Порт',
  `address` text NOT NULL COMMENT 'IP-адрес',
  `dev_type` text NOT NULL COMMENT 'Тип устройства',
  `dev_name` text NOT NULL COMMENT 'Имя устройства',
  `comment` text NOT NULL COMMENT 'Примечание',
  FOREIGN KEY (`room_id`) REFERENCES `room`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Локальная сеть';
