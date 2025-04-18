USE `work`;


CREATE TABLE `svt` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT 'Идентификатор',
  `room_id` int UNSIGNED NOT NULL COMMENT 'Кабинет',
  `model_id` int UNSIGNED NOT NULL COMMENT 'Модель',
  `status_id` int UNSIGNED NOT NULL COMMENT 'Статус',
  `number` varchar(8) NOT NULL COMMENT 'Номер',
  `serial` varchar(32) NOT NULL COMMENT 'Серийный номер',
  `inv` varchar(16) NOT NULL COMMENT 'Инвентарный номер',
  `comment` varchar(64) NOT NULL COMMENT 'Примечание',
  FOREIGN KEY (`room_id`) REFERENCES `room`(`id`),
  FOREIGN KEY (`model_id`) REFERENCES `model`(`id`),
  FOREIGN KEY (`status_id`) REFERENCES `status`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='СВТ';
