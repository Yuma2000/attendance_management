drop database attendance_managementdb; //ここはエラーでもOK
create database attendance_managementdb character set utf8 collate utf8_general_ci;
use attendance_managementdb;
drop user sample@localhost; //ここはエラーでもOK
CREATE USER 'sample'@'localhost' IDENTIFIED BY 'password';
grant all privileges ON attendancedb.* TO 'sample'@'localhost';
DROP TABLE kindergartener;//ここはエラーでもOK
CREATE TABLE kindergartener(
 	id MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT,
	name VARCHAR(128),
 	PRIMARY KEY(id)
	);
CREATE TABLE record(
 	id MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT,
 	
	child_id SMALLINT,
 	day date,
	status TINYINT(4),
	absence_reason VARCHAR(128),
 	PRIMARY KEY(id)
	);

CREATE TABLE reply(
 	id MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT,
 	
	absence_id SMALLINT,
	teacher_id SMALLINT,
	teacher_reply VARCHAR(128),
 	PRIMARY KEY(id)
	);

CREATE TABLE childminder(
	id MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT,
	name VARCHAR(128),
 	PRIMARY KEY(id)

);