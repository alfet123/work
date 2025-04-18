USE `work`;


CREATE VIEW `view_room`
AS

SELECT
	`room`.`id` AS 'id',
	`build`.`name` AS 'build',
	`floor`.`name` AS 'floor',
	`depart`.`name` AS 'depart',
	`room`.`number` AS 'room_number',
	`room`.`name` AS 'room_name'

FROM `room`

LEFT JOIN `floor` ON
	`room`.`floor_id` = `floor`.`id`

LEFT JOIN `build` ON
	`floor`.`build_id` = `build`.`id`

LEFT JOIN `depart` ON
	`room`.`depart_id` = `depart`.`id`;
