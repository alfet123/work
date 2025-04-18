
SELECT * FROM `view_svt`
WHERE `serial` IN (SELECT `serial` FROM `view_doubles`)
ORDER BY `serial`;
