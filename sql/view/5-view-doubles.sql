USE `work`;


CREATE VIEW `view_doubles`
AS
SELECT `serial`, COUNT(`id`) AS `doubles`
FROM `svt`
WHERE `serial` <> ''
GROUP BY `serial`
HAVING `doubles` > 1;
