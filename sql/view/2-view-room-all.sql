USE `work`;


CREATE VIEW `view_room_all`
AS

SELECT
	`room`.`id` AS 'room_id',
	`build`.`id` AS 'build_id',
	`build`.`name` AS 'build_name',
	`floor`.`id` AS 'floor_id',
	`floor`.`number` AS 'floor_number',
	`floor`.`name` AS 'floor_name',
	`depart`.`id` AS 'depart_id',
	`depart`.`name` AS 'depart_name',
	`room`.`number` AS 'room_number',
	`room`.`name` AS 'room_name'

FROM `room`

LEFT JOIN `floor` ON
	`room`.`floor_id` = `floor`.`id`

LEFT JOIN `build` ON
	`floor`.`build_id` = `build`.`id`

LEFT JOIN `depart` ON
	`room`.`depart_id` = `depart`.`id`;
