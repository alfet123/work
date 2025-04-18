
SELECT *, CHAR_LENGTH(name) AS name_length FROM build ORDER BY name_length DESC LIMIT 1;

SELECT *, CHAR_LENGTH(name) AS name_length FROM floor ORDER BY name_length DESC LIMIT 1;

SELECT *, CHAR_LENGTH(number) AS number_length FROM room ORDER BY number_length DESC LIMIT 1;

SELECT *, CHAR_LENGTH(name) AS name_length FROM room ORDER BY name_length DESC LIMIT 1;

SELECT *, CHAR_LENGTH(name) AS name_length FROM depart ORDER BY name_length DESC LIMIT 1;

SELECT *, CHAR_LENGTH(fullname) AS fullname_length FROM depart ORDER BY fullname_length DESC LIMIT 1;

SELECT *, CHAR_LENGTH(name) AS name_length FROM type ORDER BY name_length DESC LIMIT 1;

SELECT *, CHAR_LENGTH(name) AS name_length FROM model ORDER BY name_length DESC LIMIT 1;

SELECT *, CHAR_LENGTH(name) AS name_length FROM status ORDER BY name_length DESC LIMIT 1;

SELECT *, CHAR_LENGTH(number) AS number_length FROM svt ORDER BY number_length DESC LIMIT 1;

SELECT *, CHAR_LENGTH(serial) AS serial_length FROM svt ORDER BY serial_length DESC LIMIT 1;

SELECT *, CHAR_LENGTH(inv) AS inv_length FROM svt ORDER BY inv_length DESC LIMIT 1;

SELECT *, CHAR_LENGTH(comment) AS comment_length FROM svt ORDER BY comment_length DESC LIMIT 1;
