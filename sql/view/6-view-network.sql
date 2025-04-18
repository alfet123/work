USE `work`;


CREATE VIEW `view_network`
AS

SELECT
	`network`.`id` AS 'id',

	`build`.`name` AS 'build',
	`floor`.`name` AS 'floor',
	`depart`.`name` AS 'depart',
	`room`.`number` AS 'room',

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
