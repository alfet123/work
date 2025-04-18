USE `work`;


CREATE VIEW `view_network_all`
AS

SELECT
	`network`.`id` AS 'network_id',

	`build`.`id` AS 'build_id',
	`build`.`name` AS 'build_name',
	`build`.`sort` AS 'build_sort',
	`floor`.`id` AS 'floor_id',
	`floor`.`number` AS 'floor_number',
	`floor`.`name` AS 'floor_name',
	`depart`.`id` AS 'depart_id',
	`depart`.`name` AS 'depart_name',
	`room`.`id` AS 'room_id',
	`room`.`number` AS 'room_number',
	`room`.`name` AS 'room_name',
	`room`.`sort` AS 'room_sort',

	`network`.`plug` AS 'plug',
	`network`.`panel` AS 'panel',
	`network`.`switch` AS 'switch',
	`network`.`port` AS 'port',
	`network`.`address` AS 'address',
	`network`.`dev_type` AS 'device',
	`network`.`dev_name` AS 'name',
	`network`.`comment` AS 'comment'

FROM `network`

LEFT JOIN `room` ON
	`network`.`room_id` = `room`.`id`

LEFT JOIN `floor` ON
	`room`.`floor_id` = `floor`.`id`

LEFT JOIN `build` ON
	`floor`.`build_id` = `build`.`id`

LEFT JOIN `depart` ON
	`room`.`depart_id` = `depart`.`id`;
