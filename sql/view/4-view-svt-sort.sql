USE `work`;


CREATE VIEW `view_svt_sort`
AS

SELECT
	`svt`.`id` AS 'id',

	`build`.`name` AS 'build',
	`floor`.`name` AS 'floor',
	`depart`.`name` AS 'depart',
	`room`.`number` AS 'room',

	`type`.`name` AS 'type',

	`svt`.`number` AS 'number',

	`model`.`name` AS 'model',

	`svt`.`serial` AS 'serial',
	`svt`.`inv` AS 'inv',
	`svt`.`comment` AS 'comment'

FROM `svt`

LEFT JOIN `room` ON
	`svt`.`room_id` = `room`.`id`

LEFT JOIN `floor` ON
	`room`.`floor_id` = `floor`.`id`

LEFT JOIN `build` ON
	`floor`.`build_id` = `build`.`id`

LEFT JOIN `depart` ON
	`room`.`depart_id` = `depart`.`id`

LEFT JOIN `model` ON
	`svt`.`model_id` = `model`.`id`

LEFT JOIN `type` ON
	`model`.`type_id` = `type`.`id`

ORDER BY
	`build`.`sort`,
	`floor`.`number`,
	`room`.`sort`,
	`room`.`number`,
	`type`.`sort`,
	`svt`.`number`,
	`model`.`name`,
	`svt`.`serial`;
