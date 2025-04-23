USE `work`;


CREATE VIEW `view_svt_all`
AS

SELECT
	`svt`.`id` AS 'svt_id',

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

	`type`.`id` AS 'type_id',
	`type`.`name` AS 'type_name',
	`type`.`sort` AS 'type_sort',

	`svt`.`number` AS 'svt_number',

	`model`.`id` AS 'model_id',
	`model`.`name` AS 'model_name',
	`model`.`description` AS 'model_description',

	`status`.`id` AS 'status_id',
	`status`.`name` AS 'status_name',
	`status`.`class` AS 'status_class',

	`svt`.`serial` AS 'svt_serial',
	`svt`.`inv` AS 'svt_inv',
	`svt`.`comment` AS 'svt_comment'

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

LEFT JOIN `status` ON
	`svt`.`status_id` = `status`.`id`;
