USE `work`;


CREATE VIEW `view_floor`
AS

SELECT
	`floor`.`id` AS 'floor_id',
	`build`.`id` AS 'build_id',
	`build`.`name` AS 'build_name',
	`floor`.`number` AS 'floor_number',
	`floor`.`name` AS 'floor_name',

FROM `floor`

LEFT JOIN `build` ON
	`floor`.`build_id` = `build`.`id`;
