USE `work`;


CREATE VIEW `view_model_sort`
AS

SELECT
	`model`.`id` AS 'id',
	`type`.`name` AS 'type',
	`model`.`name` AS 'name',
	`model`.`description` AS 'description'

FROM `model`

LEFT JOIN `type` ON
	`model`.`type_id` = `type`.`id`

ORDER BY
	`type`.`sort`,
	`model`.`name`;
