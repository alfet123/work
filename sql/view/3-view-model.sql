USE `work`;


CREATE VIEW `view_model`
AS

SELECT
	`model`.`id` AS 'id',
	`type`.`name` AS 'type',
	`model`.`name` AS 'model'

FROM `model`

LEFT JOIN `type` ON
	`model`.`type_id` = `type`.`id`;
