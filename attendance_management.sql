drop database attendance_managementdb; //ここはエラーでもOK
create database attendance_managementdb character set utf8 collate utf8_general_ci;
use attendance_managementdb;
drop user sample@localhost; //ここはエラーでもOK
CREATE USER 'sample'@'localhost' IDENTIFIED BY 'password';
grant all privileges ON attendancedb.* TO 'sample'@'localhost';
DROP TABLE kindergarteners;//ここはエラーでもOK
CREATE TABLE kindergarteners(
 	id MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT,
	name VARCHAR(128),
 	PRIMARY KEY(id)
	);
CREATE TABLE records(
 	id MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT,
 	
	child_id SMALLINT,
 	day date,
	status TINYINT(4),
	absence_reason VARCHAR(128),
 	PRIMARY KEY(id)
	);

CREATE TABLE replys(
 	id MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT,
 	
	absence_id SMALLINT,
	teacher_id SMALLINT,
	teacher_reply VARCHAR(128),
 	PRIMARY KEY(id)
	);

CREATE TABLE childminders(
	id MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT,
	name VARCHAR(128),
 	PRIMARY KEY(id)

);

insert into kindergarteners values (1, 'いとう あいか');
insert into kindergarteners values (2, 'いとう はると');
insert into kindergarteners values (3, 'いのうえ みさと');
insert into kindergarteners values (4, 'かとう ゆうま');
insert into kindergarteners values (5, 'きむら こうき');
insert into kindergarteners values (6, 'ささき そうた');
insert into kindergarteners values (7, 'さとう たろう');
insert into kindergarteners values (8, 'すずき さくら');
insert into kindergarteners values (9, 'たかはし ゆうな');
insert into kindergarteners values (10, 'たなか けんじ');
insert into kindergarteners values (11, 'たむら さくら');
insert into kindergarteners values (12, 'なかがわ りえ');
insert into kindergarteners values (13, 'なかむら なおみ');
insert into kindergarteners values (14, 'まつもと たけし');
insert into kindergarteners values (15, 'みやざき さわこ');
insert into kindergarteners values (16, 'やまぐち しんじ');
insert into kindergarteners values (17, 'やまだ みなこ');
insert into kindergarteners values (18, 'よしだ ゆうた');
insert into kindergarteners values (19, 'わたなべ ゆきこ');
insert into kindergarteners values (20, 'わたべ はるか');

insert into childminders values (1, '鈴木 たけし');
insert into childminders values (2, '田村 えりこ');
insert into childminders values (3, '中野 ゆかり');
insert into childminders values (4, '山田 みさき');